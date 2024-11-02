<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Office extends Model
{
    protected $guarded = [];

    public function sections(): HasMany
    {
        return $this->hasMany(OfficeSection::class, 'office_code', 'code');
    }

    protected function department(): Attribute
    {
        return Attribute::make(
            set: fn($value) => Str::upper($value),
        );
    }

    protected function code(): Attribute
    {
        return Attribute::make(
            set: fn($value) => trim($value),
        );
    }
}
