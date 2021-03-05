<?php
namespace App\Channels;

use App\Exceptions\ShoutoutFailedNotification;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Notifications\Notification;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class ShoutoutChannel
{
    /**
     * @var string
     */
    protected $api_key;

    /**
     * @var string
     */
    protected $sms_source;

    /**
     * @var string
     */
    protected $email_source;

    /**
     * @var string
     */
    protected $api_url;

    /**
     * @var bool
     */
    protected $log_enable;

    /**
     * @var string
     */
    protected $log_path;

    /**
     * @var string
     */
    protected $log_file_name;

    /**
     * Shoutout constructor.
     */
    public function __construct()
    {
        $this->api_key = config('shoutout.api_key');
        $this->sms_source = config('shoutout.sms_source');
        $this->email_source = config('shoutout.email_source');
        $this->api_url = 'https://api.getshoutout.com/coreservice/messages';
        $this->log_enable = config('shoutout.log_enable');
        $this->log_path = config('shoutout.log_path');
        $this->log_file_name = config('shoutout.log_file_name');
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
        $message = $notification->toShoutout($notifiable);
        $data = [];

        if (is_string($message)) {
            $message = ShoutoutMessage::create($message);
        }

        if ($to = $notifiable->routeNotificationFor('shoutout')) {
            $message->setRecipients($to);
        }

        try {
            $this->sendSMS($message->recipients, $message->body);
        } catch (Exception $exception) {
            throw ShoutoutFailedNotification::serviceRespondedWithAnError($exception);
        }

        return $data;
    }

    public function sendSMS($destinations, $content)
    {
        $request_body = [
            'source' => $this->sms_source,
            'destinations' => $destinations,
            'content' => ['sms' => $content],
            'transports' => ['SMS'],
        ];

        return $this->apiCall($request_body);
    }

    public function sendEmail($destinations, $subject, $content)
    {
        $request_body = [
            'source' => $this->email_source,
            'destinations' => $destinations,
            'content' => ['email' => ['htmlType' => true, 'subject' => $subject, 'body' => $content]],
            'transports' => ['email'],
        ];

        return $this->apiCall($request_body);
    }

    public function apiCall($request_body)
    {
        $url = $this->api_url;
        $method = 'POST';
        $request = [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'apikey ' . $this->api_key,
            ],
            'json' => $request_body,
        ];
        $client = new Client(['http_errors' => false]);
        $response = $client->request($method, $url, $request);
        $this->logService($url, $method, $request['json'], $response, $this->log_file_name);

        return $response;
    }

    /**
     * @param null $url
     * @param null $method
     * @param null $request_body
     * @param null $response
     * @param null $file_name
     *
     * @throws \Exception
     */
    public function logService($url = null, $method = null, $request_body = null, $response = null, $file_name = null)
    {
        try {
            if ($this->log_enable) {
                $content = [
                    'Request URL' => $url,
                    'Request Method' => $method,
                    'Request Body' => $request_body,
                    'Status Code' => $response->getStatusCode(),
                    'Response Headers' => $response->getHeaders(),
                    'Response Body' => json_decode($response->getBody()) != null ? json_decode($response->getBody()) : $response->getBody(),
                ];

                $log = new Logger('Shoutout');
                $file_name = $file_name != null ? $file_name : date('Y_m_d') . '.log';
                $log->pushHandler(new StreamHandler($this->log_path . '/' . $file_name), Logger::INFO);
                $log->info('SERVICE LOG', $content);
            }
        } catch (\Exception $e) {
            report($e);
        }
    }
}
