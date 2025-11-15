<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ticket extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'thumbnail',
        'address',
        'path_video',
        'price',
        'is_popular',
        'about',
        'open_time_at',
        'close_time_at',
        'category_id',
        'slug',
        'approval_status',
        'approval_notes'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function photos()
    {
        return $this->hasMany(TicketPhoto::class);
    }
}
