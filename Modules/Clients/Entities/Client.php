<?php

namespace Modules\Clients\Entities;

use App\Entities\Tag;
use App\Traits\Actionable;
use App\Traits\Commentable;
use App\Traits\CustomBillable;
use App\Traits\Customizable;
use App\Traits\Emailable;
use App\Traits\Noteable;
use App\Traits\Observable;
use App\Traits\Taggable;
use App\Traits\Todoable;
use App\Traits\Uploadable;
use App\Traits\Vaultable;
use Illuminate\Contracts\Translation\HasLocalePreference;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Modules\Clients\Observers\ClientObserver;
use Modules\Clients\Scopes\ClientScope;
use Modules\Contracts\Entities\Contract;
use Modules\Creditnotes\Entities\CreditNote;
use Modules\Deals\Entities\Deal;
use Modules\Estimates\Entities\Estimate;
use Modules\Expenses\Entities\Expense;
use Modules\Invoices\Entities\Invoice;
use Modules\Payments\Entities\GocardlessMandate;
use Modules\Payments\Entities\Payment;
use Modules\Projects\Entities\Project;
use Modules\Users\Entities\Profile;
use Modules\Users\Entities\User;

class Client extends Model implements HasLocalePreference
{
    use Notifiable, Observable, Actionable, Commentable, Todoable, Vaultable,
    Taggable, Customizable, Noteable, Uploadable, Emailable, CustomBillable, HasFactory;

    protected $fillable = [
        'code', 'individual', 'name', 'primary_contact', 'email', 'website', 'phone', 'mobile', 'fax', 'address1',
        'address2', 'city', 'state', 'locale', 'country', 'tax_number', 'zip_code', 'currency', 'expense', 'balance', 'paid', 'skype',
        'linkedin', 'facebook', 'twitter', 'notes', 'logo', 'owner', 'slack_webhook_url', 'unsubscribed_at', 'stripe_id', 'card_brand',
        'card_last_four', 'trial_ends_at', 'billing_street', 'billing_city', 'billing_state', 'billing_zip', 'billing_country', 'shipping_street',
        'shipping_city', 'shipping_state', 'shipping_zip', 'shipping_country',
    ];
    protected $appends = ['contact_person', 'expense_cost', 'outstanding', 'map', 'maplink'];
    protected $dates = ['created_at', 'updated_at', 'trial_ends_at'];

    protected static $observer = ClientObserver::class;
    protected static $scope = ClientScope::class;

    /**
     * Get client invoices
     */
    public function invoices()
    {
        return $this->hasMany(Invoice::class)->orderByDesc('id');
    }

    /**
     * Get client estimates.
     */
    public function estimates()
    {
        return $this->hasMany(Estimate::class);
    }

    /**
     * Get client contacts.
     */
    public function contacts()
    {
        return $this->hasMany(Profile::class, 'company')->with('user:id,username,email,name');
    }

    /**
     * Get client payments.
     */
    public function payments()
    {
        return $this->hasMany(Payment::class, 'client_id');
    }

    /**
     * Get client expenses.
     */
    public function expenses()
    {
        return $this->hasMany(Expense::class)->orderBy('id', 'desc');
    }

    public function credits()
    {
        return $this->hasMany(CreditNote::class)->orderBy('id', 'desc');
    }

    public function gocardlessMandates()
    {
        return $this->hasMany(GocardlessMandate::class)->whereNotNull('gocardless_mandate');
    }

    /**
     * Get client projects.
     */
    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    /**
     * Get Deals.
     */
    public function deals()
    {
        return $this->hasMany(Deal::class, 'organization');
    }

    /**
     * client contracts
     */
    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }

    /**
     * Get contact person profile.
     */
    public function contact()
    {
        return $this->belongsTo(User::class, 'primary_contact');
    }

    public function commentAlert($comment)
    {
        return;
    }

    public function metaValue($key)
    {
        return optional($this->custom()->whereMetaKey($key)->first())->meta_value;
    }

    public function unbilledExpenses()
    {
        $balance = 0;
        $unbilled = $this->expenses()->billable()->where(
            function ($query) {
                $query->orWhere('invoiced', 0)->orWhereNull('invoiced');
            }
        )->get();
        foreach ($unbilled as $expense) {
            if ($expense->currency != $this->currency) {
                $balance += convertCurrency($expense->currency, $expense->cost, $this->currency);
            } else {
                $balance += $expense->cost;
            }
        }
        return formatDecimal($balance);
    }

    public function due()
    {
        $due = 0;
        foreach ($this->invoices()->open()->get() as $invoice) {
            if ($invoice->currency != $this->currency) {
                $due += convertCurrency($invoice->currency, $invoice->balance, $this->currency);
            } else {
                $due += $invoice->balance;
            }
        }

        return formatDecimal($due);
    }

    public function overdue()
    {
        $overdue = 0;
        foreach ($this->invoices()->open()->whereDate('due_date', '<', now()->toDateString())->get() as $invoice) {
            if ($invoice->currency != $this->currency) {
                $overdue += convertCurrency($invoice->currency, $invoice->balance, $this->currency);
            } else {
                $overdue += $invoice->balance;
            }
        }

        return formatDecimal($overdue);
    }

    public function creditBalance()
    {
        $bal = 0;
        foreach ($this->credits()->open()->get() as $credit) {
            if ($credit->currency != $this->currency) {
                $bal += convertCurrency($credit->currency, $credit->balance, $this->currency);
            } else {
                $bal += $credit->balance;
            }
        }

        return formatDecimal($bal);
    }

    public function afterModelSaved()
    {
        $this->expense = $this->unbilledExpenses();
        $this->balance = $this->due();
        $this->paid = $this->amountPaid();
        $this->primary_contact = $this->primary_contact <= 0 ? optional($this->contacts()->first())->id : $this->primary_contact;
        $this->saveQuietly();
    }

    public function hasUnread()
    {
        return $this->comments()->whereUnread(1)->where('user_id', '!=', \Auth::id())->count();
    }

    public function amountToPay()
    {
        $total = 0;
        foreach ($this->invoices->where('status', '!=', 'Cancelled') as $inv) {
            if ($inv->currency != get_option('default_currency')) {
                $total += convertCurrency($inv->currency, $inv->payable());
            } else {
                $total += $inv->payable();
            }
        }

        return $total;
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    // Amount paid by client
    public function amountPaid()
    {
        $total = 0;
        foreach ($this->payments()->active()->get() as $payment) {
            if ($payment->currency != $this->currency) {
                $total += convertCurrency($payment->currency, $payment->amount, $this->currency);
            } else {
                $total += $payment->amount;
            }
        }
        return formatDecimal($total);
    }

    /**
     * Check if user can download files
     *
     * @param  boolean $user The user id
     * @return boolean
     */
    public function canDownloadFiles($user = false)
    {
        return $this->owner == \Auth::user()->id;
    }

    public function percentDue()
    {
        if ($this->balance > 0 && $this->amountToPay() > 0) {
            return ceil(($this->due() / $this->amountToPay()) * 100);
        }

        return 0;
    }

    public function creditsWithBalance()
    {
        return $this->credits->filter(
            function ($item, $key) {
                return $item->balance() > 0 && $item->is_refunded === 0;
            }
        );
    }

    public function nextCode()
    {
        $code = sprintf('%05d', 1);
        $max = $this->whereNotNull('code')->max('id');
        if ($max > 0) {
            $row = $this->find($max);
            $ref_number = intval(substr($row->code, -4));
            $next_number = $ref_number + 1;
            if ($next_number < 1) {
                $next_number = 1;
            }
            $next_number = $this->codeExists($next_number);
            $code = sprintf('%05d', $next_number);
        }
        return get_option('company_id_prefix') . $code;
    }
    public function codeExists($next_number)
    {
        $next_number = sprintf('%05d', $next_number);
        if ($this->whereCode(get_option('company_id_prefix') . $next_number)->count() > 0) {
            return $this->codeExists((int) $next_number + 1);
        }
        return $next_number;
    }

    public function getContactPersonAttribute()
    {
        return optional($this->contact)->name;
    }

    public function getOutstandingAttribute()
    {
        return formatCurrency($this->currency, $this->balance);
    }

    public function getExpenseCostAttribute()
    {
        return formatCurrency($this->currency, $this->expense);
    }

    public function getMapAttribute()
    {
        return urlencode($this->billing_street . ',' . $this->billing_state . ' ' . $this->billing_zip . ',' . $this->billing_city . ',' . $this->billing_country);
    }

    public function getMaplinkAttribute()
    {
        return 'https://maps.google.com/maps?q=' . $this->billing_street . '+' . $this->billing_city . '+' . $this->billing_state . '+' . $this->billing_zip;
    }

    public function getLogoAttribute()
    {
        return is_null($this->getRawOriginal('logo')) ? $this->createAvatar() : $this->logoUrl();
    }

    protected function createAvatar()
    {
        if (!\App::runningUnitTests()) {
            // To use gravatar uncomment
            // $this->update(['logo' => \Avatar::create($this->email)->toGravatar()]);
            // return $this->logoUrl();
            return getStorageUrl(config('system.logos_dir') . '/' . 'default_avatar.png');
        }
    }

    protected function logoUrl()
    {
        if (!\App::runningUnitTests()) {
            if (filter_var($this->getRawOriginal('logo'), FILTER_VALIDATE_URL)) {
                return $this->getRawOriginal('logo');
            }
            return getStorageUrl(config('system.logos_dir') . '/' . $this->getRawOriginal('logo'));
        }
    }

    /**
     * Route notifications for the Slack channel.
     *
     * @return string
     */
    public function routeNotificationForSlack()
    {
        return $this->slack_webhook_url;
    }

    public function routeNotificationForWhatsapp()
    {
        return $this->primary_contact > 0 ? $this->contact->mobile : $this->mobile;
    }

    public function canReceiveEmail()
    {
        if (is_null($this->unsubscribed_at)) {
            return true;
        }
        return false;
    }
    public function preferredLocale()
    {
        return $this->locale;
    }
    public function getUrlAttribute()
    {
        return '/clients/view/' . $this->id;
    }
    public function getBillingStreetAttribute($value)
    {
        return empty($value) ? $this->address1 : $value;
    }
    public function getBillingCityAttribute($value)
    {
        return empty($value) ? $this->city : $value;
    }
    public function getBillingZipAttribute($value)
    {
        return empty($value) ? $this->zip_code : $value;
    }
    public function getBillingStateAttribute($value)
    {
        return empty($value) ? $this->state : $value;
    }
    public function getBillingCountryAttribute($value)
    {
        return empty($value) ? $this->country : $value;
    }
    public function getShippingStreetAttribute($value)
    {
        return empty($value) ? $this->address1 : $value;
    }
    public function getShippingCityAttribute($value)
    {
        return empty($value) ? $this->city : $value;
    }
    public function getShippingZipAttribute($value)
    {
        return empty($value) ? $this->zip_code : $value;
    }
    public function getShippingStateAttribute($value)
    {
        return empty($value) ? $this->state : $value;
    }
    public function getShippingCountryAttribute($value)
    {
        return empty($value) ? $this->country : $value;
    }
    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return \Database\Factories\ClientFactory::new ();
    }
}
