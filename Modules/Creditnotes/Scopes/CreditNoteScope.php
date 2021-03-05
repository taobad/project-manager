<?php
namespace Modules\Creditnotes\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Auth;

class CreditNoteScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $builder
     * @param  \Illuminate\Database\Eloquent\Model   $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(Builder $builder, Model $model)
    {
        if (auth()->check() && !isAdmin()) {
            if (Auth::user()->can('credits_view_all')) {
                return $builder;
            } else {
                $builder->where('client_id', Auth::user()->profile->company);
            }
        }
    }
}
