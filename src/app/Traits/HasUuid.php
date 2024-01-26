<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasUuid
{
    public static function bootHasUuid(){
        static::creating(static function ($query) {
            $query->external_id = $query->external_id ?? (string) Str::uuid();
        });
    }
}
