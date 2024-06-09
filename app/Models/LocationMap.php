<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocationMap extends Model
{
    use HasFactory;

    protected $table = 'LocationMap';

    public function getLmImageLgAttribute($image)
    {
        return 'https://london.cityviewmaps.com/public/uploads/' .$image;
    }
    public function getLmImageSmAttribute($image)
    {
        return 'https://london.cityviewmaps.com/public/uploads/' .$image;
    }
}
