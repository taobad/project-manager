<?php
namespace App\Services;

use Crypt;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Modules\Webhook\Jobs\Xrun;

class PurChecker
{
    protected $endpoint = 'https://sales.gitbench.com/verify';

    public function exec()
    {
        if (urlAccessible($this->endpoint) && !isDemo()) {
            return $this->queryPur();
        }
    }

    private function queryPur()
    {
        $client = new Client();
        $response = $client->get($this->endpoint . '?code=' . request('code'));
        $response = collect(json_decode($response->getBody()->getContents()));
        if ($response->has('error')) {
            $this->invalidate();
            return false;
        }
        if ($response->has('item_id')) {
            return $this->activateApp($response);
        }
        return false;
    }
    private function activateApp(Collection $response)
    {
        update_option('purchase_code', request('code'));
        return \Storage::put('verified.json', Crypt::encryptString($response->toJson()));
    }

    private function invalidate()
    {
        Xrun::dispatch()->onQueue('low');
        // if (\Storage::exists('verified.json')) {
        //     \Storage::delete('verified.json');
        // }
    }
}
