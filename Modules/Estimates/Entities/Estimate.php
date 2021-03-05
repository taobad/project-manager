<?php

namespace Modules\Estimates\Entities;

use App\Traits\Actionable;
use App\Traits\Commentable;
use App\Traits\Customizable;
use App\Traits\Eventable;
use App\Traits\Itemable;
use App\Traits\Observable;
use App\Traits\Remindable;
use App\Traits\Searchable;
use App\Traits\Taggable;
use App\Traits\Taxable;
use App\Traits\Uploadable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Clients\Entities\Client;
use Modules\Deals\Entities\Deal;
use Modules\Estimates\Events\EstimateCreated;
use Modules\Estimates\Events\EstimateDeleted;
use Modules\Estimates\Events\EstimateInvoiced;
use Modules\Estimates\Events\EstimateUpdated;
use Modules\Estimates\Notifications\EstimateCommented;
use Modules\Estimates\Observers\EstimateObserver;
use Modules\Estimates\Scopes\EstimateScope;
use Modules\Estimates\Services\EstimateCalculator;
use Modules\Projects\Entities\Project;
use Modules\Tasks\Entities\Task;
use Modules\Users\Entities\User;

class Estimate extends Model
{
    use Itemable, Actionable, Commentable, Taggable, Observable, Eventable, Remindable, Searchable,
    Uploadable, Customizable, Taxable, HasFactory;

    protected static $observer = EstimateObserver::class;
    protected static $scope = EstimateScope::class;

    protected $fillable = [
        'reference_no', 'title', 'client_id', 'deal_id', 'due_date', 'currency', 'discount', 'notes', 'tax', 'tax2',
        'status', 'sent_at', 'viewed_at', 'discount_percent', 'invoiced_id', 'invoiced_at', 'accepted_time',
        'rejected_time', 'rejected_reason', 'exchange_rate', 'is_visible', 'amount', 'sub_total', 'show_shipping_on_estimate',
        'discounted', 'tax1_amount', 'tax2_amount', 'archived_at', 'reminded_at', 'created_at', 'tax_per_item', 'tax_types',
        'billing_street', 'billing_city', 'billing_state', 'billing_zip', 'billing_country', 'shipping_street', 'shipping_city',
        'shipping_state', 'shipping_zip', 'shipping_country', 'discount_per_item',
    ];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => EstimateCreated::class,
        'updated' => EstimateUpdated::class,
        'deleted' => EstimateDeleted::class,
    ];

    protected $dates = [
        'due_date',
    ];
    protected $casts = [
        'tax_types' => 'array',
    ];

    public function company()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function deal()
    {
        return $this->belongsTo(Deal::class);
    }

    public function subTotal()
    {
        return (new EstimateCalculator($this))->subTotal();
    }

    public function metaValue($key)
    {
        return optional($this->custom()->whereMetaKey($key)->first())->meta_value;
    }
    public function totalTax()
    {
        return (new EstimateCalculator($this))->totalTax();
    }

    public function tax1Amount()
    {
        return (new EstimateCalculator($this))->tax1Amount();
    }

    public function tax2Amount()
    {
        return (new EstimateCalculator($this))->tax2Amount();
    }
    public function taxTypeAmount($taxes)
    {
        return (new EstimateCalculator($this))->taxTypeAmount($taxes);
    }

    public function discounted()
    {
        return (new EstimateCalculator($this))->discounted();
    }

    public function isLocked()
    {
        return $this->status != langapp('pending') ? true : false;
    }

    public function amount()
    {
        return (new EstimateCalculator($this))->amount();
    }

    public function commentAlert($comment)
    {
        $user = User::role('admin')->first();
        if ($user->id != $comment->user_id) {
            \Notification::send($user, new EstimateCommented($this));
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
        return $this->isClient() || \Auth::user()->can('estimates_view_all');
    }

    public function afterModelSaved()
    {
        $this->amount = $this->amount();
        $this->sub_total = $this->subTotal();
        $this->discounted = $this->discounted();
        $this->tax1_amount = $this->tax1Amount();
        $this->tax2_amount = $this->tax2Amount();
        $this->saveQuietly();
        if (!\App::runningInConsole()) {
            \Artisan::call('analytics:estimates');
        }
    }

    public function ajaxTotals()
    {
        return [
            'total' => formatCurrency($this->currency, $this->amount()),
            'subtotal' => formatCurrency($this->currency, $this->subTotal()),
            'tax1' => formatCurrency($this->currency, $this->tax1Amount()),
            'tax2' => formatCurrency($this->currency, $this->tax2Amount()),
            'discount' => formatCurrency($this->currency, $this->discounted()),
            'scope' => 'estimates',
        ];
    }

    public function isEditable()
    {
        if ($this->status != langapp('pending')) {
            return false;
        }
        return true;
    }

    public function viewed()
    {
        if (!\Auth::check()) {
            if (is_null($this->viewed_at)) {
                event(new \Modules\Estimates\Events\EstimateViewed($this));
            }
        }
    }

    public function clientViewed()
    {
        if (\Auth::check() && !isAdmin()) {
            if (\Auth::user()->profile->company == $this->client_id) {
                if (is_null($this->viewed_at)) {
                    event(new \Modules\Estimates\Events\EstimateViewed($this));
                }
            }
        }
    }

    public function isDraft()
    {
        if ($this->status === 'Pending' && $this->is_sent === 0 && $this->is_visible === 0) {
            return true;
        }
        return false;
    }

    public function pdf($download = true)
    {
        return (new \App\Helpers\PDFEngine('estimates', $this, $download))->pdf();
    }

    public function newDeal()
    {
        $deal = new Deal;
        $deal->title = $this->title;
        $deal->stage_id = get_option('default_deal_stage');
        $deal->deal_value = $this->getRawOriginal('amount');
        $deal->contact_person = $this->company->primary_contact;
        $deal->organization = $this->client_id;
        $deal->due_date = $this->due_date;
        $deal->source = \App\Entities\Category::deals()->first()->name;
        $deal->pipeline = get_option('default_deal_pipeline');
        $deal->currency = $this->currency;
        $deal->user_id = \Auth::id();
        $deal->save();
        $this->update(['deal_id' => $deal->id]);
    }

    public function toProject()
    {
        $admin = \Modules\Users\Entities\User::role('admin')->first();
        $project = new Project;
        $project->code = generateCode('projects');
        $project->name = 'Project ' . $this->name;
        $project->description = $this->notes;
        $project->client_id = $this->client_id;
        $project->currency = $this->currency;
        $project->start_date = now()->format(config('system.preferred_date_format'));
        $project->due_date = now()->addDays(30)->format(config('system.preferred_date_format'));
        $project->billing_method = 'fixed_rate';
        $project->hourly_rate = get_option('hourly_rate');
        $project->fixed_price = formatDecimal($this->amount);
        $project->progress = 0;
        $project->manager = $admin->id;
        $project->auto_progress = 1;
        $project->notes = 'Created from Estimate ' . $this->name;
        $project->save();

        $project->assignees()->create(['user_id' => $admin->id]);
        // Default project settings
        $default_settings = json_decode(get_option('default_project_settings'), true);
        foreach ($default_settings as $key => &$value) {
            if (strtolower($value) == 'off') {
                unset($default_settings[$key]);
            }
        }
        $project->update(['settings' => $default_settings]);

        foreach ($this->items as $item) {
            $task = new Task();
            $task->name = $item->name;
            $task->project_id = $project->id;
            $task->description = $item->description;
            $task->start_date = now()->format(config('system.preferred_date_format'));
            $task->due_date = now()->addDays(config('system.task_due_after'))->format(config('system.preferred_date_format'));
            $task->estimated_hours = 0.00;
            $task->user_id = \Auth::id();
            $task->save();
            $task->assignees()->create(['user_id' => $admin->id]);
        }

        return $project;
    }

    public function toInvoice()
    {
        $filtered = array_only(
            $this->toArray(),
            [
                'client_id', 'due_date', 'currency', 'discount', 'notes', 'tax', 'tax2', 'is_visible', 'discount_percent',
            ]
        );
        $filtered['reference_no'] = generateCode('invoices');
        $invoice = \Modules\Invoices\Entities\Invoice::create($filtered);
        foreach ($this->items as $item) {
            $invoice->items()->create(array_except($item->toArray(), ['id']));
        }
        $this->update(
            [
                'invoiced_id' => $invoice->id, 'invoiced_at' => now()->toDateTimeString(),
            ]
        );
        $invoice->retag($this->tagList);
        $invoice->updateAddresses();
        event(new EstimateInvoiced($this, \Auth::check() ? \Auth::id() : firstAdminId()));
        return $invoice;
    }
    public function ribbonColor()
    {
        switch ($this->getRawOriginal('status')) {
            case 'accepted':
                return 'success';
                break;
            case 'declined':
                return 'red';
                break;
            case 'Pending':
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

    public function getStatusAttribute()
    {
        if ($this->getRawOriginal('status') == 'Accepted') {
            return langapp('accepted');
        }
        if ($this->getRawOriginal('status') == 'Declined') {
            return langapp('declined');
        }
        if (!is_null($this->viewed_at)) {
            return langapp('viewed');
        }
        if (!is_null($this->sent_at)) {
            return langapp('sent');
        }
        if ($this->isOverdue()) {
            return langapp('overdue');
        }
        return langapp(strtolower($this->getRawOriginal('status')));
    }

    public function statusIcon()
    {
        if ($this->getRawOriginal('status') === 'Accepted') {
            return '<span class="text-success">✔</span> ';
        }
        if ($this->isOverdue() || $this->getRawOriginal('status') === 'Declined') {
            return '<span class="text-danger">✘</span> ';
        }
        if (!is_null($this->sent_at)) {
            return '<i class="fas fa-envelope-open text-info"></i> ';
        }
        if ($this->is_visible == 0) {
            return '<i class="far fa-file-alt text-warning"></i>';
        }

        return '<i class="fas fa-exclamation-circle text-warning"></i> ';
    }

    public function nextCode()
    {
        $code = get_option('estimate_prefix') . sprintf('%04d', get_option('estimate_start_no'));
        $max = $this->withoutGlobalScopes()->whereNotNull('reference_no')->max('id');
        if ($max > 0) {
            $row = $this->withoutGlobalScopes()->find($max);
            $ref_number = intval(substr($row->reference_no, -4));
            $next_number = $ref_number + 1;
            if ($next_number < get_option('estimate_start_no')) {
                $next_number = get_option('estimate_start_no');
            }
            $next_number = $this->codeExists($next_number);

            $code = $this->formattedCode($next_number);
        }
        return $code;
    }
    public function codeExists($next_number)
    {
        $next_number = sprintf('%04d', $next_number);
        if ($this->withoutGlobalScopes()->whereReferenceNo($this->formattedCode($next_number))->count() > 0) {
            return $this->codeExists((int) $next_number + 1);
        }
        return $next_number;
    }

    private function formattedCode($num)
    {
        if (!empty(get_option('estimate_number_format'))) {
            return get_option('estimate_prefix') . referenceFormatted(get_option('estimate_number_format'), $num);
        } else {
            return get_option('estimate_prefix') . sprintf('%04d', $num);
        }
    }

    public function isOverdue()
    {
        return strtotime($this->due_date) < time() && $this->amount > 0;
    }

    public function setStatusAttribute($value)
    {
        $enum = ['Accepted', 'Declined', 'Pending'];
        $this->attributes['status'] = in_array($value, $enum) ? $value : 'Pending';
    }

    public function setDueDateAttribute($value)
    {
        $this->attributes['due_date'] = dbDate($value);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'Pending')->whereNull('archived_at');
    }

    public function scopeAccepted($query)
    {
        return $query->whereNotNull('accepted_time')->whereNull('archived_at');
    }
    public function scopeRejected($query)
    {
        return $query->whereNotNull('rejected_time')->whereNull('archived_at');
    }

    public function scopeReminderAlerts($query)
    {
        return $query->where('status', 'Pending')->whereDate('due_date', '>=', now())->whereDate('due_date', '<=', now()->addDays(get_option('remind_estimates_before')))->whereNull('reminded_at');
    }

    public function getNameAttribute()
    {
        return is_null($this->title) ? '#' . $this->reference_no : $this->title;
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
        return '/estimates/view/' . $this->id;
    }
    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return \Database\Factories\EstimateFactory::new();
    }
}
