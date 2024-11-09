<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property mixed $service_id
 */
class CsmResponse extends Model
{
    protected $guarded = [];

    protected $appends = [];

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    protected function responseDate(): Attribute
    {
        return Attribute::make(
            set: fn($value) => Carbon::parse($value)->setTimezone('Asia/Manila')->format('Y-m-d H:i:s'),
        );
    }
}
