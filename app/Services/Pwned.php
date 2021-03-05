<?php
namespace App\Services;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Lang;

class Pwned implements Rule
{
    /**
     * @var int
     */
    private $minimum;
    /**
     * @param int $minimum Minimum number of times the password was pwned before it is blocked
     */
    public function __construct($minimum = 1)
    {
        $this->minimum = $minimum;
    }
    public function validate($attribute, $value, $params)
    {
        $this->minimum = array_shift($params) ?? 1;
        return $this->passes($attribute, $value);
    }
    public function passes($attribute, $value)
    {
        list($prefix, $suffix) = $this->hashAndSplit($value);
        $results = $this->query($prefix);
        $count = $results[$suffix] ?? 0;
        return $count < $this->minimum;
    }
    public function message()
    {
        return Lang::get('validation.pwned');
    }
    private function hashAndSplit($value)
    {
        $hash = strtoupper(sha1($value));
        $prefix = substr($hash, 0, 5);
        $suffix = substr($hash, 5);
        return [$prefix, $suffix];
    }
    private function query($prefix)
    {
        // Cache results for a week, to avoid constant API calls for identical prefixes
        return Cache::remember(
            'pwned:' . $prefix,
            now()->addMinutes(10080),
            function () use ($prefix) {
                $curl = curl_init('https://api.pwnedpasswords.com/range/' . $prefix);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                $results = curl_exec($curl);
                curl_close($curl);
                return (new Collection(explode("\n", $results)))
                    ->mapWithKeys(
                        function ($value) {
                            list($suffix, $count) = explode(':', trim($value));
                            return [$suffix => $count];
                        }
                    );
            }
        );
    }
}
