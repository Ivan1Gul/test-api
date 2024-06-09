<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $table = 'Category';

    public function business(): HasMany
    {
        return $this->hasMany(Business::class, 'cat_id', 'cat_id')->limit(3);
    }
}
