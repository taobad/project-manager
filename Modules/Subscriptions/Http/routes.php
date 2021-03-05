<?php

use Illuminate\Support\Facades\Route;

Route::group(
    ['middleware' => 'web', 'prefix' => 'subscriptions', 'namespace' => 'Modules\Subscriptions\Http\Controllers'],
    function () {
        Route::get('/', 'SubscriptionsController@index')->name('subscriptions.index');
        Route::post('admin-data', 'AdminSubscriptionController@tableData')
            ->name('subscriptions.admin.data')
            ->middleware(['can:menu_subscriptions', 'can:subscriptions_all']);
        Route::post('client-data', 'ClientSubscriptionController@tableData')
            ->name('subscriptions.client.data')
            ->middleware('can:menu_subscriptions');
        Route::post('admin-plans', 'AdminSubscriptionController@plansData')
            ->name('plans.data')
            ->middleware('can:menu_subscriptions', 'can:subscriptions_all');

        Route::get('plans', 'PlansController@plans')
            ->name('plans.index')
            ->middleware('can:subscriptions_create');
        Route::get('plans/{plan}', 'PlansController@edit')
            ->name('plans.edit')
            ->middleware('can:subscriptions_delete');
        Route::get('delete-plan/{plan}', 'PlansController@delete')
            ->name('plans.delete')
            ->middleware('can:subscriptions_update');
        Route::get('create', 'PlansController@create')
            ->name('plans.create')
            ->middleware('can:subscriptions_create');
        Route::get('send/{plan}', 'PlansController@send')
            ->name('plans.send')
            ->middleware('can:subscriptions_send');

        Route::get('subscribe/{plan}', 'SubscriptionsController@subscribe')
            ->name('subscriptions.subscribe');
        Route::get('cancel/{plan}', 'SubscriptionsController@cancel')
            ->name('subscriptions.cancel');
        Route::get('activate/{plan}', 'SubscriptionsController@activate')
            ->name('subscriptions.activate');
        Route::post('subscribe', 'SubscriptionsController@process')
            ->name('subscriptions.process');
        Route::post('deactivate', 'SubscriptionsController@deactivate')
            ->name('subscriptions.deactivate');

        Route::get('invoices', 'SubscriptionsController@invoices')
            ->name('subscriptions.invoices')
            ->middleware(['demo']);

        Route::get('admin-cancel/{id}', 'SubscriptionsController@adminCancel')
            ->name('subscriptions.admin.cancel')
            ->middleware('can:subscriptions_update');
        Route::get('admin-activate/{id}', 'SubscriptionsController@adminActivate')
            ->name('subscriptions.admin.activate')
            ->middleware('can:subscriptions_update');
        Route::post('admin-deactivate', 'SubscriptionsController@adminDeactivate')
            ->name('subscriptions.admin.deactivate')
            ->middleware(['can:subscriptions_update', 'demo']);
    }
);
