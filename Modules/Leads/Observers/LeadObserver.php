<?php

namespace Modules\Leads\Observers;

use App\Entities\Category;
use Modules\Leads\Entities\Lead;

class LeadObserver
{
    /**
     * Listen to the Lead saving event.
     *
     * @param Lead $lead
     */
    public function saving(Lead $lead)
    {
        if (empty($lead->name) || $lead->name == '') {
            $lead->name = $lead->email;
        }
        $lead->stage_id = empty($lead->stage_id) ? get_option('default_lead_stage') : $lead->stage_id;
        if (!is_numeric($lead->stage_id)) {
            $stage = Category::firstOrCreate(['name' => $lead->stage, 'module' => 'leads']);
            $lead->stage_id = $stage->id;
        }
        if (!is_numeric($lead->source)) {
            $source = Category::firstOrCreate(['name' => $lead->source, 'module' => 'source'], ['color' => 'info']);
            $lead->source = $source->id;
        }
        $lead->sales_rep = $lead->sales_rep <= 0 ? get_option('default_sales_rep') : $lead->sales_rep;
        $lead->computed_value = formatCurrency(get_option('default_currency'), parseCurrency($lead->lead_value));
    }

    public function creating(Lead $lead)
    {
        $lead->token = genToken();
        $lead->next_followup = now()->addDays(get_option('lead_followup_days'));
        $lead->due_date = empty($lead->due_date) ? now()->addDays(get_option('lead_expire_days')) : $lead->due_date;
        if (settingEnabled('leads_opt_in')) {
            $lead->unsubscribed_at = now()->toDateTimeString();
        }
    }

    /**
     * Listen to the Lead updated event.
     *
     * @param Lead $lead
     */
    public function saved(Lead $lead)
    {
        if (request()->has('tags')) {
            $lead->retag(collect(request('tags'))->implode(','));
        }
        $lead->saveCustom(request('custom'));
        $lead->afterModelSaved();
    }

    /**
     * Listen to Lead deleting event.
     *
     * @param Lead $lead
     */
    public function deleting(Lead $lead)
    {
        foreach ($lead->comments as $comment) {
            $comment->delete();
        }
        foreach ($lead->custom as $field) {
            $field->delete();
        }
        foreach ($lead->emails as $email) {
            $email->delete();
        }
        foreach ($lead->calls as $call) {
            $call->delete();
        }
        foreach ($lead->activities as $activity) {
            $activity->delete();
        }
        foreach ($lead->notes as $note) {
            $note->delete();
        }
        foreach ($lead->schedules as $event) {
            $event->delete();
        }
        foreach ($lead->files as $file) {
            $file->delete();
        }
        foreach ($lead->todos as $todo) {
            $todo->delete();
        }
        $lead->detag();
    }
    /**
     * Listen to the Lead deleted event.
     *
     * @param Lead $lead
     */
    public function deleted(Lead $lead)
    {
        \Artisan::call('analytics:leads');
    }
}
