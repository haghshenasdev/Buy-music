<?php

namespace App\Setting;

use App\Models\Music;
use App\Models\Seting;

class SettingSystem
{
    protected static function repository(): \Illuminate\Database\Eloquent\Builder
    {
        return Seting::query();
    }

    public static function get(string $key)
    {
        $result = self::repository()
            ->where('name', $key)
            ->get('value')->first();

        return is_null($result) ? $result : $result->value;
    }

    public static function get_bg_page(Music $music = null)
    {
        if (is_null($music) || is_null($music->bg_page))
            return self::get('bg_page');

        return $music->bg_page;
    }
}
