<?php

namespace App\Channels;

use App\Exceptions\InvalidConfiguration;
use App\Services\WablasClient;
use GuzzleHttp\Client;
use Illuminate\Notifications\Notification;
use Log;

class WhatsAppChannel
{
    // protected const API_ENDPOINT = 'https://panel.apiwha.com/send_message.php';

    /** @var Client */
    protected $client;

    public function __construct()
    {
        $this->client = new Client;
    }
    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     *
     * @throws \App\Exceptions\InvalidConfiguration
     */
    public function send($notifiable, Notification $notification)
    {
        if (!$routing = collect($notifiable->routeNotificationFor('whatsapp'))) {
            return;
        }
        $key = get_option('whatsapp_key');
        if (!is_null($key) && settingEnabled('whatsapp_enabled')) {
            $whatsappParameters = $notification->toWhatsapp($notifiable)->toArray();
            $apiToken = get_option('whatsapp_key');
            $wablasClient = new WablasClient($apiToken);

            // add recipient (support multiple recipient)
            $wablasClient->addRecipient($whatsappParameters['number']);
            $res = $wablasClient->sendMessage($whatsappParameters['text']);
            $response = $res->getContents();
            if (isset($response->status) && $response->status !== true) {
                Log::error('WhatsApp response: ' . $response->message);
            }

            // send image
            // $wablasClient->sendImage('your image caption here', 'http://your.image/url/here');

            // $response = $this->client->post(self::API_ENDPOINT, [
            //     'form_params' => $whatsappParameters,
            // ]);
            // $res = json_decode($response->getBody()->getContents());
            // if ($res->success !== true) {
            //     Log::error('WhatsApp response: '.$res->description);
            //     // throw CouldNotSendWhatsapp::serviceRespondedWithAnError($res->description);
            // }
        } else {
            Log::error('In order to send notification via Whatsapp you need to add credentials in settings and enable WhatsApp');
            //throw InvalidConfiguration::configurationNotSet();
        }
    }
}
