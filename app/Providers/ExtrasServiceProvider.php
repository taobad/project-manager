<?php
namespace App\Providers;

use App\Channels\ShoutoutChannel;
use App\Channels\WhatsAppChannel;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\ServiceProvider;
use NotificationChannels\AwsPinpoint\AwsPinpointChannel;
use NotificationChannels\Messagebird\MessagebirdChannel;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Twilio\TwilioChannel;

class ExtrasServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        \Illuminate\Support\Collection::macro('recursive', function () {
            return $this->map(function ($value) {
                if (is_array($value) || is_object($value)) {
                    return collect($value)->recursive();
                }

                return $value;
            });
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            'zip',
            function ($app) {
                return new \App\Services\Zip($app);
            }
        );

        $channels = [
            'whatsapp' => WhatsAppChannel::class,
            'shoutout' => ShoutoutChannel::class,
        ];
        foreach ($channels as $name => $className) {
            Notification::extend($name, function () use ($className) {
                return new $className;
            });
        }
        Notification::extend('pinpoint', function ($app) {
            return $app->make(AwsPinpointChannel::class);
        });
        Notification::extend('messagebird', function ($app) {
            return $app->make(MessagebirdChannel::class);
        });
        Notification::extend('telegram', function ($app) {
            return $app->make(TelegramChannel::class);
        });
        Notification::extend('twilio', function ($app) {
            return $app->make(TwilioChannel::class);
        });

        $this->registerWorkCommand();
    }

    /**
     * Get the services provider by the provider
     *
     * @return array
     */
    public function provides()
    {
        return ['zip'];
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerWorkCommand()
    {
        // $this->app->extend('command.queue.work', function ($command, Application $app) {
        //     return new WorkCommand($app['queue.worker'], $app['cache.store']);
        // });
    }
}
