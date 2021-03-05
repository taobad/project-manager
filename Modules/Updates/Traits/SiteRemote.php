<?php

namespace Modules\Updates\Traits;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

trait SiteRemote
{

    protected static function getRemote($url, $data = array())
    {
        $base = 'https://desk.workice.com/';

        $client = new Client(['verify' => false, 'base_uri' => $base]);

        $headers['headers'] = array(
            'Accept' => 'application/json',
            'Referer' => url('/'),
            'workice' => getCurrentVersion()['version'],
        );

        $data['http_errors'] = false;

        $data = array_merge($data, $headers);

        try {
            $result = $client->get($url, $data);
        } catch (RequestException $e) {
            $result = $e;
        }

        return $result;
    }
}
