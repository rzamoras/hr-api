<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class OfficeSection extends Model
{
    protected $guarded = [];

    public function office(): BelongsTo
    {
        return $this->belongsTo(Office::class, 'office_code', 'code');
    }

    protected function name(): Attribute
    {
        return Attribute::make(
            set: fn($value) => Str::upper($value),
        );
    }
}
