<?php

namespace Modules\Expenses\Observers;

use App\Entities\Category;
use Illuminate\Support\Facades\Artisan;
use Modules\Clients\Entities\Client;
use Modules\Expenses\Entities\Expense;
use Modules\Projects\Entities\Project;

class ExpenseObserver
{
    /**
     * Listen to the Estimate created event.
     *
     * @param Expense $expense
     */
    public function creating(Expense $expense)
    {
        $expense->code = generateCode('expenses');
        $expense->user_id = \Auth::id();

        if (!is_numeric($expense->client_id)) {
            $expense->client_id = Client::firstOrCreate(
                ['name' => $expense->client_id],
                ['owner' => \Auth::id()]
            )->id;
        }
        if (!is_numeric($expense->project_id)) {
            $project = Project::select('id')->whereName($expense->project_id)
                ->whereClientId($expense->client_id)->first();
            $expense->project_id = isset($project->id) ? $project->id : 0;
        }
        if (!is_numeric($expense->category)) {
            $expense->category = Category::firstOrCreate(
                ['name' => $expense->category],
                ['module' => 'expenses']
            )->id;
        }
    }

    /**
     * Listen to Expense saving event.
     *
     * @param Expense $expense
     */
    public function saving(Expense $expense)
    {
        $expense->exchange_rate = xchangeRate($expense->currency);
        $expense->amount_formatted = formatCurrency($expense->currency, $expense->amount);
    }

    /**
     * Listen to the Expense saved event.
     *
     * @param Expense $expense
     */
    public function saved(Expense $expense)
    {
        if (request()->has('tags')) {
            $expense->retag(collect(request('tags'))->implode(','));
        }
        $expense->afterModelSaved();
        if ($expense->client_id > 0) {
            $expense->company->afterModelSaved();
        }
        $expense->saveCustom(request('custom'));

        if ($expense->project_id > 0) {
            $expense->AsProject->afterModelSaved();
        }
    }

    /**
     * Listen to the Client deleting event.
     *
     * @param Expense $expense
     */
    public function deleting(Expense $expense)
    {
        foreach ($expense->files as $file) {
            $file->delete();
        }
        foreach ($expense->comments as $comment) {
            $comment->delete();
        }
        foreach ($expense->activities as $activity) {
            $activity->delete();
        }
        foreach ($expense->schedules as $event) {
            $event->delete();
        }
        foreach ($expense->todos as $todo) {
            $todo->delete();
        }
        foreach ($expense->custom as $field) {
            $field->delete();
        }
        $expense->recurring()->delete();

        $expense->detag();
    }
    /**
     * Listen to the Expense deleted event.
     *
     * @param Expense $expense
     */
    public function deleted(Expense $expense)
    {
        \Artisan::call('analytics:expenses');
    }
}
