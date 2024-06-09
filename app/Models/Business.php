<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Business extends Model
{
    use HasFactory;

    protected $table = 'Business';

    public function businessTypes(): HasMany
    {
        return $this->hasMany(BusinessType::class, 'btyp_id', 'btyp_id');
    }
}
