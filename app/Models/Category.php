<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'icon',
        'contact_person',
        'telephone',
    ];

    public function getIconAttribute($value)
    {
        return $value ? asset('storage/' . $value) : null;
    }
}
