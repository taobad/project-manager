<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;
use Modules\Settings\Entities\Options;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(UrlGenerator $url, \Illuminate\Http\Request $request)
    {
        \Schema::defaultStringLength(191);

        if (!Cache::has(settingsCacheName())) {
            if (file_exists(storage_path('installed'))) {
                Cache::remember(
                    settingsCacheName(),
                    now()->addDays(30),
                    function () {
                        $conf = [];
                        foreach (Options::select(['value', 'config_key'])->get()->toArray() as $setting) {
                            $conf[$setting['config_key']] = $setting['value'];
                        }
                        return $conf;
                    }
                );
                Cache::add('installed', true, now()->addDays(5));
            }
        }
        date_default_timezone_set(get_option('timezone', 'UTC'));

        if (env('REDIRECT_HTTPS', false)) {
            $url->forceScheme('https');
        }
        if (app()->environment('production')) {
            \DB::disableQueryLog();
        }

        Builder::macro('whereLike', function ($attributes, string $searchTerm) {
            $this->where(function (Builder $query) use ($attributes, $searchTerm) {
                foreach (array_wrap($attributes) as $attribute) {
                    $query->when(
                        str_contains($attribute, '.'),
                        function (Builder $query) use ($attribute, $searchTerm) {
                            [$relationName, $relationAttribute] = explode('.', $attribute);
                            $query->orWhereHas($relationName, function (Builder $query) use ($relationAttribute, $searchTerm) {
                                $query->where($relationAttribute, 'LIKE', "%{$searchTerm}%");
                            });
                        },
                        function (Builder $query) use ($attribute, $searchTerm) {
                            $query->orWhere($attribute, 'LIKE', "%{$searchTerm}%");
                        }
                    );
                }
            });

            return $this;
        });

        // Uncomment if using ngrok
        if ($request->server->has('HTTP_X_ORIGINAL_HOST')) {
            $request->server->set('HTTP_X_FORWARDED_HOST', $request->server->get('HTTP_X_ORIGINAL_HOST'));
            $request->headers->set('X_FORWARDED_HOST', $request->server->get('HTTP_X_ORIGINAL_HOST'));
        }
    }

    /**
     * Register any application services.
     */
    public function register()
    {
        // if ($this->app->isLocal()) {
        //     $this->app->register(TelescopeServiceProvider::class);
        // }
    }
}
