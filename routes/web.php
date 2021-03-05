<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Modules\Webhook\Http\Controllers\StripeWebhookController;

Route::get('/', 'Welcome@index')->middleware(['auth']);

Auth::routes(['verify' => config('system.verification'), 'register' => settingEnabled('allow_client_registration')]);

Route::get('/redirect/{provider}', 'SocialAuthController@redirectToProvider');
Route::get('/callback/{provider}', 'SocialAuthController@handleProviderCallback');

Route::get('/logout', 'Auth\LoginController@logout');
Route::get('/articles', 'ArticleController@index')->name('articles.public');
Route::get('/articles/view/{article}', 'ArticleController@view')->name('articles.public.view');

Route::get('error/403', 'ErrorController@fourZeroThree')->name('error.403');

Route::get('setlocale/{locale}', 'LocaleController@setLang')->name('setLanguage');
Route::get('setview/{type}/{view}', 'ViewTypeController@setView')->name('set.view.type');
Route::get('setcalendar/{view}', 'ViewTypeController@activeCalendar')->name('set.calendar.type');

Route::post('license/verify', 'LicenseController@verify')->name('app.license');

Route::get('whatsapp/subscribe', 'WhatsAppSubscribeController@form')->name('whatsapp.subscribe');
Route::post('whatsapp/subscribed', 'WhatsAppSubscribeController@subscribe')->name('whatsapp.subscribe.send');
Route::get('invite', 'InviteController@invite')->name('invite');
Route::get('tell-friend', 'TellFriendController@share')->name('tell.friend');
Route::post('tell-friend', 'TellFriendController@invite')->name('invite.friend');
Route::post('invite', 'InviteController@process')->name('invite.process');
Route::post('bulk-archive', 'ArchiveController@archive')->name('archive.process');
Route::get('accept/{token}', 'InviteController@accept')->name('invite.accept');
Route::post('accepted', 'InviteController@accepted')->name('invite.accepted');

Route::post('auth/2fa', 'TwoFactorAuthController@authenticate')->name('2fa.auth')->middleware('2fa');
Route::get('reset/2fa', 'TwoFactorAuthController@reset')->name('2fa.reset');

Route::get('cron/schedule/{token}', 'ScheduleController@run')->name('artisan.schedule')->middleware('demo');

Route::get('weblead', 'WebToLeadController@form')->name('web.lead');
Route::post('weblead/save', 'WebToLeadController@capture')->name('web.lead.save');

Route::post('search', 'SearchController@search')->name('search.app');

Route::get('/mg', 'Welcome@mg')->middleware(['demo']);

Route::get('support', 'SupportController@ticket')->name('support.ticket')->middleware('cors');
Route::post('stripe/webhook', [StripeWebhookController::class, 'handleWebhook']);
Route::gocardlessWebhooks('webhook/gocardless/ipn');
