<?php

namespace Modules\Settings\Http\Controllers;

use App\Entities\Hook;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Modules\Settings\Emails\TestMail;
use Modules\Settings\Entities\Options;

class SettingController extends Controller
{
    /**
     * Request instance
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;

    public function __construct(Request $request)
    {
        $this->middleware(['auth', 'verified', '2fa', 'reauthenticate', 'can:menu_settings']);
        $this->request = $request;
        $this->media_dir = config('system.media_dir') . '/';
    }

    public function configure()
    {
        $exclude = ['invoice_logo', 'company_logo', 'login_bg', 'site_favicon', 'site_appleicon'];
        $ignoreKeys = ['_token', 'default_tax_rates'];
        foreach ($this->request->except($exclude) as $key => $value) {
            $value = is_null($value) ? '' : $value;
            if (!in_array($key, $ignoreKeys)) {
                update_option($key, $value);
            }
            if ($key == 'default_tax_rates') {
                update_option($key, json_encode($this->request->default_tax_rates));
            }
        }
        if ($this->request->hasFile('invoice_logo')) {
            $this->uploadInvoiceLogo($this->request);
        }
        if ($this->request->hasFile('company_logo')) {
            $this->uploadCompanyLogo($this->request);
        }
        if ($this->request->hasFile('login_bg')) {
            $this->uploadBackground($this->request);
        }
        if ($this->request->hasFile('site_favicon')) {
            $this->uploadFavicon($this->request);
        }
        if ($this->request->hasFile('site_appleicon')) {
            $this->uploadAppleIcon($this->request);
        }

        Cache::forget(settingsCacheName());
        Cache::forget('editorLocale');
        Cache::forget('datepickerLocale');
        Cache::forget('calendarLocale');
        Cache::forget('default-lang');

        $data['message'] = langapp('changes_saved_successful');
        $data['redirect'] = url()->previous();

        return ajaxResponse($data);
    }

    public function reorderMenu()
    {
        $items = json_decode($this->request->json);
        foreach ($items[0] as $i => $mod) {
            $menu = Hook::where('module', $mod->module)->first();
            $menu->update(['order' => $i + 1]);
        }
        Cache::forget('workice-main-menu-' . Auth::id());
        $data['message'] = langapp('changes_saved_successful');
        $data['redirect'] = url()->previous();

        return ajaxResponse($data);
    }
    public function menuIcon($module = null)
    {
        $menu = Hook::where('module', $module)->first();
        $menu->update(['icon' => $this->request->icon]);
        Cache::forget('workice-main-menu-' . Auth::id());
        $data['message'] = langapp('changes_saved_successful');
        $data['redirect'] = url()->previous();

        return ajaxResponse($data);
    }

    public function menuVisible($module = null)
    {
        $menu = Hook::where('module', $module)->first();
        $menu->update(['visible' => $this->request->visible]);
        Cache::forget('workice-main-menu-' . Auth::id());
        $data['message'] = langapp('changes_saved_successful');
        $data['redirect'] = url()->previous();

        return ajaxResponse($data);
    }

    protected function uploadInvoiceLogo($request)
    {
        $request->validate(['invoice_logo' => 'mimes:png,jpg,jpeg|max:1024']);
        $currentLogo = Options::whereConfigKey('invoice_logo')->first()->value;
        Storage::delete($this->media_dir . $currentLogo);
        Storage::putFile($this->media_dir, $request->file('invoice_logo'));
        update_option('invoice_logo', $request->invoice_logo->hashName());
    }

    protected function uploadCompanyLogo($request)
    {
        $request->validate(['company_logo' => 'mimes:png,jpg,jpeg|max:1024']);
        $currentLogo = Options::whereConfigKey('company_logo')->first()->value;
        Storage::delete($this->media_dir . $currentLogo);
        Storage::putFile($this->media_dir, $request->file('company_logo'));
        update_option('company_logo', $request->company_logo->hashName());
    }

    protected function uploadBackground($request)
    {
        $request->validate(['login_bg' => 'mimes:png,jpg,jpeg|max:2048']);
        $currentLogo = Options::whereConfigKey('login_bg')->first()->value;
        Storage::delete($this->media_dir . $currentLogo);
        Storage::putFile($this->media_dir, $request->file('login_bg'));
        update_option('login_bg', $request->login_bg->hashName());
    }

    protected function uploadFavicon($request)
    {
        $request->validate(['site_favicon' => 'mimes:png,jpg,jpeg,ico|max:600']);
        $currentLogo = Options::whereConfigKey('site_favicon')->first()->value;
        Storage::delete($this->media_dir . $currentLogo);
        Storage::putFile($this->media_dir, $request->file('site_favicon'));
        update_option('site_favicon', $request->site_favicon->hashName());
    }

    protected function uploadAppleIcon($request)
    {
        $request->validate(['site_appleicon' => 'mimes:png,jpg,jpeg,ico|max:600']);
        $currentLogo = Options::whereConfigKey('site_appleicon')->first()->value;
        Storage::delete($this->media_dir . $currentLogo);
        Storage::putFile($this->media_dir, $request->file('site_appleicon'));
        update_option('site_appleicon', $request->site_appleicon->hashName());
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index($section = 'general')
    {
        $allowedSections = ['deals', 'email', 'estimate', 'field_builder', 'fields', 'general', 'invoice', 'clauses', 'modules',
            'leads', 'menu', 'payments', 'support', 'currencies', 'system', 'theme', 'css', 'translations', 'commands', 'info', 'mail', 'integrations', 'extras'];
        $section = in_array($section, $allowedSections) ? $section : 'general';
        $data['page'] = $this->getPage();
        $data['section'] = str_contains('{section', $section) ? 'general' : $section;

        return view('settings::index')->with($data);
    }

    public function testMail()
    {
        return view('settings::modal._test_mail');
    }

    public function sendMail()
    {
        $this->request->validate(
            [
                'recipient' => 'required|email',
                'subject' => 'required',
            ]
        );
        \Mail::to($this->request->recipient)->send(new TestMail($this->request));
        $data['message'] = langapp('saved_successfully');
        $data['redirect'] = route('settings.index', ['section' => 'mail']);

        return ajaxResponse($data);
    }

    private function getPage()
    {
        return langapp('settings');
    }
}
