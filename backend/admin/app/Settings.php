<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * @property int $id
 * @property string $key
 * @property string $value
 * @property string $created_at
 * @property string $updated_at
 */
class Settings extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['key', 'value', 'created_at', 'updated_at'];


    /**
     * @return array
     */
    public static function getAll()
    {
        $settings_arr = Settings::all()->toArray();

        $result_settings = [];
        foreach ($settings_arr as $key => $setting) {
            $result_settings[$setting["key"]] = $setting["value"];
        }

        return $result_settings;
    }

    public static function getByKey($key)
    {
        return DB::table("settings")->where("key", "=", $key)->first() ?? null;
    }
}
