<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class TranslateApi extends Model
{
    protected $table    = 'translate_apis';
    protected $fillable = ['key', 'value'];

    public static function getValue(string $key, $default = null)
    {
        return Cache::remember("translate_api:$key", 3600, function () use ($key, $default) {
            $record = self::where('key', $key)->first();
            return $record ? $record->value : $default;
        });
    }

    public static function setValue(string $key, $value)
    {
        self::updateOrCreate(['key' => $key], ['value' => $value]);
        Cache::forget("translate_api:$key");
    }
}
