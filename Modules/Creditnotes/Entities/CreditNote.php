<?php

namespace Modules\Creditnotes\Entities;

use App\Traits\Actionable;
use App\Traits\Commentable;
use App\Traits\Itemable;
use App\Traits\Observable;
use App\Traits\Searchable;
use App\Traits\Taggable;
use App\Traits\Taxable;
use App\Traits\Uploadable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Clients\Entities\Client;
use Modules\Creditnotes\Entities\Credited;
use Modules\Creditnotes\Events\CreditNoteCreated;
use Modules\Creditnotes\Events\CreditNoteDeleted;
use Modules\Creditnotes\Events\CreditNoteUpdated;
use Modules\Creditnotes\Notifications\CreditCommented;
use Modules\Creditnotes\Observers\CreditNoteObserver;
use Modules\Creditnotes\Scopes\CreditNoteScope;
use Modules\Creditnotes\Services\CreditCalculator;
use Modules\Users\Entities\User;

class CreditNote extends Model
{
    use Actionable, Commentable, Itemable, Taggable, Observable, Searchable, Uploadable, HasFactory, Taxable;

    protected static $observer = CreditNoteObserver::class;
    protected static $scope = CreditNoteScope::class;

    protected $fillable = [
        'reference_no', 'client_id', 'status', 'sent_at', 'currency', 'notes', 'terms', 'tax', 'exchange_rate', 'is_refunded',
        'archived_at', 'amount', 'balance', 'created_at', 'tax_per_item', 'tax_types', 'show_shipping_on_credits',
        'billing_street', 'billing_city', 'billing_state', 'billing_zip', 'billing_country', 'shipping_street', 'shipping_city',
        'shipping_state', 'shipping_zip', 'shipping_country',
    ];
    protected $casts = [
        'tax_types' => 'array',
    ];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => CreditNoteCreated::class,
        'updated' => CreditNoteUpdated::class,
        'deleted' => CreditNoteDeleted::class,
    ];

    public function company()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }
    public function credited()
    {
        return $this->hasMany(Credited::class, 'creditnote_id')->orderBy('id', 'desc');
    }

    public function isEditable()
    {
        if ($this->status === 'open') {
            return true;
        }
        return false;
    }
    public function balance()
    {
        return (new CreditCalculator($this))->balance();
    }
    public function tax()
    {
        return (new CreditCalculator($this))->tax1Amount();
    }
    public function taxTypeAmount($taxes)
    {
        return (new CreditCalculator($this))->taxTypeAmount($taxes);
    }

    public function subTotal()
    {
        return (new CreditCalculator($this))->subTotal();
    }

    public function usedCredits()
    {
        return $this->credited->sum('credited_amount');
    }

    public function total()
    {
        return (new CreditCalculator($this))->total();
    }

    public function statusIcon()
    {
        if ($this->status === 'closed') {
            return '<span class="text-success">✔</span> ';
        }
        if ($this->is_refunded === 1) {
            return '<span class="text-danger">✘</span> ';
        }
        if (!is_null($this->sent_at)) {
            return '<i class="fas fa-envelope-open text-info"></i> ';
        }

        return '<i class="fas fa-exclamation-circle text-warning"></i> ';
    }

    public function commentAlert($comment)
    {
        $user = User::role('admin')->first();
        if ($user->id != $comment->user_id) {
            \Notification::send($user, new CreditCommented($this));
        }
    }

    public function isClient()
    {
        return \Auth::user()->profile->company == $this->client_id ? true : false;
    }

    /**
     * Check if user can download files
     *
     * @param  boolean $user The user id
     * @return boolean
     */
    public function canDownloadFiles($user = false)
    {
        return $this->isClient() || \Auth::user()->can('credits_view_all');
    }

    public function pdf($download = true)
    {
        return (new \App\Helpers\PDFEngine('creditnotes', $this, $download))->pdf();
    }

    public function nextCode()
    {
        $code = get_option('creditnote_prefix') . sprintf('%04d', get_option('creditnote_start_no'));
        $max = $this->whereNotNull('reference_no')->max('id');
        if ($max > 0) {
            $row = $this->find($max);
            $ref_number = intval(substr($row->reference_no, -4));
            $next_number = $ref_number + 1;
            if ($next_number < get_option('creditnote_start_no')) {
                $next_number = get_option('creditnote_start_no');
            }
            $next_number = $this->codeExists($next_number);

            $code = $this->formattedCode($next_number);
        }
        return $code;
    }
    protected function codeExists($next_number)
    {
        $next_number = sprintf('%04d', $next_number);
        if ($this->whereReferenceNo($this->formattedCode($next_number))->count() > 0) {
            return $this->codeExists((int) $next_number + 1);
        }
        return $next_number;
    }

    protected function formattedCode($num)
    {
        if (!empty(get_option('creditnote_number_format'))) {
            return get_option('creditnote_prefix') . referenceFormatted(get_option('creditnote_number_format'), $num);
        } else {
            return get_option('creditnote_prefix') . sprintf('%04d', $num);
        }
    }

    public function setTaxAttribute($value)
    {
        $this->attributes['tax'] = formatDecimal($value);
    }

    public function setCreatedAtAttribute($value)
    {
        $this->attributes['created_at'] = dbDate($value);
    }

    public function afterModelSaved()
    {
        $this->amount = $this->total();
        $this->balance = $this->balance();
        $this->saveQuietly();
        if (!\App::runningInConsole()) {
            \Artisan::call('analytics:credits');
        }
    }

    public function ribbonColor()
    {
        switch ($this->getRawOriginal('status')) {
            case 'closed':
                return 'success';
                break;
            case 'void':
                return 'red';
                break;
            case 'open':
                return 'info';
                break;
            default:
                return 'gray';
                break;
        }
    }
    public function updateAddresses()
    {
        $this->update([
            'billing_street' => $this->company->billing_street,
            'billing_city' => $this->company->billing_city,
            'billing_state' => $this->company->billing_state,
            'billing_zip' => $this->company->billing_zip,
            'billing_country' => $this->company->billing_country,
            'shipping_street' => $this->company->shipping_street,
            'shipping_city' => $this->company->shipping_city,
            'shipping_state' => $this->company->shipping_state,
            'shipping_zip' => $this->company->shipping_zip,
            'shipping_country' => $this->company->shipping_country,
        ]);
    }

    public function ajaxTotals()
    {
        return [
            'balance' => formatCurrency($this->currency, $this->balance()),
            'subtotal' => formatCurrency($this->currency, $this->subTotal()),
            'used' => formatCurrency($this->currency, $this->usedCredits()),
            'tax' => formatCurrency($this->currency, $this->tax()),
            'scope' => 'creditnotes',
        ];
    }

    public function scopeOpen($query)
    {
        return $query->where('status', 'open');
    }
    public function scopeClosed($query)
    {
        return $query->where('status', 'closed');
    }

    public function getUsedAttribute()
    {
        return $this->usedCredits();
    }

    public function getNameAttribute()
    {
        return $this->reference_no;
    }
    public function getBillingStreetAttribute($value)
    {
        return empty($value) ? $this->company->billing_street : $value;
    }
    public function getBillingCityAttribute($value)
    {
        return empty($value) ? $this->company->billing_city : $value;
    }
    public function getBillingZipAttribute($value)
    {
        return empty($value) ? $this->company->billing_zip : $value;
    }
    public function getBillingStateAttribute($value)
    {
        return empty($value) ? $this->company->billing_state : $value;
    }
    public function getBillingCountryAttribute($value)
    {
        return empty($value) ? $this->company->billing_country : $value;
    }
    public function getShippingStreetAttribute($value)
    {
        return empty($value) ? $this->company->shipping_street : $value;
    }
    public function getShippingCityAttribute($value)
    {
        return empty($value) ? $this->company->shipping_city : $value;
    }
    public function getShippingZipAttribute($value)
    {
        return empty($value) ? $this->company->shipping_zip : $value;
    }
    public function getShippingStateAttribute($value)
    {
        return empty($value) ? $this->company->shipping_state : $value;
    }
    public function getShippingCountryAttribute($value)
    {
        return empty($value) ? $this->company->shipping_country : $value;
    }
    public function getUrlAttribute()
    {
        return '/creditnotes/view/' . $this->id;
    }
    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return \Database\Factories\CreditNoteFactory::new ();
    }
}
