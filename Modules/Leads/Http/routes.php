<?php

Route::group(
    ['middleware' => 'web', 'prefix' => 'leads', 'namespace' => 'Modules\Leads\Http\Controllers'],
    function () {
        Route::get('/', 'LeadCustomController@index')->name('leads.index')->middleware('can:menu_leads');
        Route::get('/create', 'LeadCustomController@create')->name('leads.create')->middleware('can:leads_create');
        Route::get('/view/{lead}/{tab?}/{option?}', 'LeadCustomController@view')->name('leads.view');
        Route::get('/delete/{lead}', 'LeadCustomController@delete')->name('leads.delete')->middleware('can:leads_delete');

        Route::get('/next-stage/{lead}', 'LeadCustomController@nextStage')->name('leads.nextstage')->middleware('can:leads_update');
        Route::get('/edit/{lead}', 'LeadCustomController@edit')->name('leads.edit')->middleware('can:leads_update');

        Route::post('bulk-delete', 'LeadCustomController@bulkDelete')->name('leads.bulk.delete')->middleware('can:leads_delete');
        Route::post('bulk-email', 'LeadCustomController@bulkEmail')->name('leads.bulk.email')->middleware('can:leads_update');
        Route::post('bulk-sms', 'LeadCustomController@bulkSms')->name('leads.bulk.sms')->middleware('can:leads_update');
        Route::post('bulk-send', 'LeadCustomController@sendBulk')->name('leads.bulk.send');
        Route::post('bulk-send-sms', 'LeadCustomController@sendBulkSms')->name('leads.bulk.send.sms');

        Route::get('/import', 'LeadCustomController@import')->name('leads.import')->middleware('can:leads_create');
        Route::get('import/callback', 'LeadCustomController@importGoogleContacts')->name('leads.import.callback')->middleware('can:leads_create');
        Route::get('/export', 'LeadCustomController@export')->name('leads.export')->middleware('can:menu_leads');
        Route::post('csvmap', 'LeadCustomController@parseImport')->name('leads.csvmap')->middleware('can:leads_create');
        Route::post('csvprocess', 'LeadCustomController@processImport')->name('leads.csvprocess')->middleware('can:leads_create');

        Route::post('table-json', 'LeadCustomController@tableData')->name('leads.data')->middleware('can:menu_leads');

        Route::get('/convert/{lead}', 'LeadCustomController@convert')->name('leads.convert')->middleware('can:deals_create');

        Route::get('/consent/{lead}', 'LeadCustomController@sendConsent')->name('leads.consent')->middleware('can:leads_create');
        Route::get('/whatsapp-consent/{lead}', 'LeadCustomController@sendWhatsappConsent')->name('leads.consent.whatsapp')->middleware('can:leads_create');
        Route::get('/consent-accept/{token}', 'LeadConsentController@accept')->name('leads.consent.accept');
        Route::get('/consent-decline/{token}', 'LeadConsentController@decline')->name('leads.consent.decline');

        Route::post('/email-delete', 'LeadCustomController@ajaxDeleteMail')->name('leads.email.delete');
        Route::post('/email/{lead}', 'LeadCustomController@email')->name('leads.email');
        Route::post('/emails/reply', 'LeadCustomController@replyEmail')->name('leads.emailReply');

        Route::post('rating', 'LeadCustomController@rating')->name('leads.rating');
    }
);
