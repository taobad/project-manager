<?php

namespace Modules\Leads\Entities;

use App\Entities\Category;
use App\Traits\Actionable;
use App\Traits\Chatable;
use App\Traits\Commentable;
use App\Traits\Customizable;
use App\Traits\Emailable;
use App\Traits\Eventable;
use App\Traits\Noteable;
use App\Traits\Observable;
use App\Traits\Phoneable;
use App\Traits\Remindable;
use App\Traits\Searchable;
use App\Traits\Taggable;
use App\Traits\Todoable;
use App\Traits\Uploadable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Modules\Clients\Entities\Client;
use Modules\Deals\Entities\Deal;
use Modules\Leads\Events\LeadCreated;
use Modules\Leads\Events\LeadDeleted;
use Modules\Leads\Events\LeadUpdated;
use Modules\Leads\Notifications\LeadCommented;
use Modules\Leads\Observers\LeadObserver;
use Modules\Leads\Scopes\LeadScope;
use Modules\Todos\Entities\Todo;
use Modules\Users\Entities\Profile;
use Modules\Users\Entities\User;

class Lead extends Model
{
    use Notifiable, Commentable, Todoable, Taggable, Actionable, Customizable, HasFactory,
    Observable, Noteable, Eventable, Uploadable, Remindable, Phoneable, Searchable, Emailable, Chatable;

    protected static $observer = LeadObserver::class;
    protected static $scope = LeadScope::class;

    protected $fillable = [
        'name', 'source', 'stage_id', 'job_title', 'company', 'phone', 'mobile', 'email', 'address1', 'address2',
        'city', 'state', 'zip_code', 'country', 'timezone', 'website', 'skype', 'facebook', 'twitter', 'linkedin',
        'sales_rep', 'lead_score', 'due_date', 'lead_value', 'computed_value', 'todo_percent', 'message',
        'has_email', 'has_activity', 'has_chats', 'next_followup', 'unsubscribed_at', 'archived_at', 'converted_at', 'token',
        'rating_status',
    ];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => LeadCreated::class,
        'updated' => LeadUpdated::class,
        'deleted' => LeadDeleted::class,
    ];

    protected $dates = [
        'due_date', 'next_followup',
    ];

    protected $appends = ['map', 'map_link'];

    public function status()
    {
        return $this->belongsTo(Category::class, 'stage_id', 'id');
    }

    public function AsSource()
    {
        return $this->belongsTo(Category::class, 'source', 'id');
    }

    public function agent()
    {
        return $this->belongsTo(User::class, 'sales_rep', 'id')->with(['profile:user_id,avatar,use_gravatar']);
    }

    public function unreadMessages()
    {
        return $this->emails()->unread()->count();
    }

    public function hasPendingActivity()
    {
        return $this->todos()->pending()->count();
    }

    public function hasNewChats()
    {
        return $this->chats()->unread()->count();
    }

    public function commentAlert($comment)
    {
        $this->agent->notify(new LeadCommented($this));
    }

    /**
     * Check if user can download files
     *
     * @param  boolean $user The user id
     * @return boolean
     */
    public function canDownloadFiles($user = false)
    {
        return $this->sales_rep == \Auth::user()->id;
    }

    public function nextActivities()
    {
        return Todo::whereDate('datetime', '>', now()->toDateTimeString())
            ->whereAssigned(\Auth::user()->id)
            ->where('parent', '<=', 0)
            ->whereLeadId($this->id)
            ->pending()
            ->orderBy('id', 'desc')
            ->get();
    }

    public function toCustomer()
    {
        $contact = $this->createContactFromLead();

        if (request()->noPotential === '1') {
            $deal = Deal::create(
                [
                    'title' => request('deal_title'),
                    'stage_id' => get_option('default_deal_stage'),
                    'deal_value' => $this->lead_value,
                    'contact_person' => $contact->user_id,
                    'organization' => $contact->business->id,
                    'currency' => get_option('default_currency'),
                    'user_id' => get_option('default_deal_owner'),
                    'due_date' => now()->addDays(get_option('deal_rotting')),
                    'source' => $this->source,
                    'pipeline' => get_option('default_deal_pipeline'),
                ]
            );
            foreach ($this->comments as $comment) {
                $deal->comments()->create(
                    [
                        'user_id' => \Auth::id(),
                        'message' => $comment->message,
                    ]
                );
            }
            $this->tags()->sync($deal->tags);
            // Transfer lead notes to deal
            foreach ($this->notes as $note) {
                $deal->notes()->create(
                    [
                        'user_id' => $note->user_id,
                        'name' => $note->name,
                        'description' => $note->description,
                    ]
                );
            }
            return [
                'message' => langapp('saved_successfully'),
                'redirect' => route('deals.view', ['deal' => $deal->id]),
            ];
        } else {
            return [
                'message' => langapp('saved_successfully'),
                'redirect' => route('clients.view', ['client' => $contact->business->id]),
            ];
        }
    }

    public function nextStage()
    {
        $max = \App\Entities\Category::leads()->max('order');
        $currentStage = \App\Entities\Category::whereId($this->stage_id)->first()->order;
        if (\App\Entities\Category::whereId($this->stage_id)->first()->order == $max) {
            return false;
        } else {
            return $currentStage + 1;
        }
    }

    public function metaValue($key)
    {
        return optional($this->custom()->whereMetaKey($key)->first())->meta_value;
    }

    public function afterModelSaved()
    {
        $this->computed_value = formatCurrency(get_option('default_currency'), $this->lead_value);
        $this->has_email = $this->unreadMessages() ? 1 : 0;
        $this->has_activity = $this->hasPendingActivity() ? 1 : 0;
        $this->saveQuietly();
        \Artisan::queue('leads:calcstage');
        if (!\App::runningInConsole()) {
            \Artisan::call('analytics:leads');
        }
    }

    public function createContactFromLead()
    {
        $user = User::firstOrCreate(['email' => $this->email], ['username' => $this->email, 'name' => $this->name]);
        $account = Client::firstOrCreate(
            ['email' => $this->email],
            [
                'name' => $this->company, 'primary_contact' => $user->id, 'code' => generateCode('clients'),
                'website' => $this->website, 'phone' => $this->phone,
                'address1' => $this->billing_street, 'address2' => $this->address2,
                'city' => $this->billing_city, 'state' => $this->billing_state, 'currency' => get_option('default_currency'),
                'country' => $this->billing_country, 'zip_code' => $this->billing_zip, 'skype' => $this->skype, 'linkedin' => $this->linkedin,
                'facebook' => $this->facebook, 'twitter' => $this->twitter, 'owner' => \Auth::id(),
            ]
        );
        $user->profile->update(
            [
                'company' => $account->id, 'job_title' => $this->job_title,
                'city' => $this->city, 'country' => $this->country, 'address' => $this->address, 'phone' => $this->phone,
                'skype' => $this->skype, 'state' => $this->state, 'zip_code' => $this->zip_code, 'website' => $this->website,
                'twitter' => $this->twitter,
            ]
        );
        // Transfer lead notes to client comments
        foreach ($this->notes as $note) {
            $account->comments()->create(
                [
                    'user_id' => $note->user_id,
                    'message' => $note->description,
                ]
            );
        }
        return $user->profile;
    }

    public function scopeConverted($query)
    {
        return $query->whereNotNull('converted_at');
    }

    public function scopeArchived($query)
    {
        return $query->whereNotNull('archived_at');
    }

    public function getMapAttribute()
    {
        return urlencode($this->address1 . ',' . $this->state . ' ' . $this->zip_code . ',' . $this->city . ',' . $this->country);
    }

    public function getMaplinkAttribute()
    {
        return 'https://maps.google.com/maps?q=' . $this->address1 . '+' . $this->city . '+' . $this->state . '+' . $this->zip_code;
    }

    public function setNextFollowupAttribute($value)
    {
        $this->attributes['next_followup'] = dbDate($value);
    }

    public function getScoreAttribute()
    {
        $score = 0;
        $allStages = Category::whereModule('leads')->orderBy('order', 'asc')->get();
        foreach ($allStages as $stage) {
            $res = round(100 / $allStages->count());
            $score += $res;
            if ($stage->id == $this->stage_id) {
                break;
            }
        }
        return $score;
    }

    public function setDueDateAttribute($value)
    {
        $this->attributes['due_date'] = dbDate($value);
    }

    public function setLeadValueAttribute($value)
    {
        $this->attributes['lead_value'] = parseCurrency($value);
    }

    public function canReceiveEmail()
    {
        if (is_null($this->unsubscribed_at)) {
            return true;
        }
        return false;
    }

    /**
     * Route notifications for the Nexmo channel.
     */
    public function routeNotificationForNexmo()
    {
        return $this->mobile;
    }
    /**
     * Route notifications for the Twilio channel.
     */
    public function routeNotificationForTwilio()
    {
        return $this->mobile;
    }

    public function routeNotificationForWhatsapp()
    {
        return $this->whatsapp_optin ? $this->mobile : null;
    }

    public function getUrlAttribute()
    {
        return '/leads/view/' . $this->id;
    }

    public function getPhotoAttribute()
    {
        return app('gravatar')->get($this->email);
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return \Database\Factories\LeadFactory::new();
    }
}
