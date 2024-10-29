<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class CsmResponse extends Model
{
    protected $guarded = [];

    protected function responseDate() :Attribute
    {
        return Attribute::make(
            set: fn($value) => Carbon::parse($value)->setTimezone('Asia/Manila')->format('Y-m-d H:i:s'),
        );
    }
}
