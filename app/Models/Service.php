<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property mixed $name
 */
class Service extends Model
{
    protected $guarded = [];

    public function csm_responses(): HasMany
    {
        return $this->hasMany(CsmResponse::class);
    }
}
