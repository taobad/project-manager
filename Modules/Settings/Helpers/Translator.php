<?php

namespace Modules\Settings\Helpers;

class Translator
{
    public function availableTranslations()
    {
        $available = [];
        $existing = [];
        foreach (\App\Entities\Language::all() as $lng) {
            $existing[] = $lng->name;
        }
        $col = \App\Entities\Local::groupBy('language')->get();
        foreach ($col as $line) {
            if (!in_array($line->language, $existing)) {
                $available[] = $line;
            }
        }

        return $available;
    }

    public function progress($locale, $pending = false)
    {
        if ($locale == 'en') {
            return 100;
        }
        $keys       = \Lang::get('app', [], 'en');
        $translated = $count = 0;
        foreach ($keys as $key => $line) {
            if ($line != trans('app.'.$key, [], $locale)) {
                ++$translated;
            }
            $count += 1;
        }

        return intval(round(($translated / $count) * 100));
    }
}
