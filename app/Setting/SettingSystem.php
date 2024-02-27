<?php

namespace App\Setting;

use App\Models\Music;
use App\Models\Seting;
use Illuminate\Support\Facades\Storage;

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
            $bg_page = self::get('bg_page');
        else
            $bg_page = $music->bg_page;

        if (!str_starts_with($bg_page,"http")) $bg_page = Storage::url($bg_page);

        return $bg_page;
    }
}
