<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Music extends Model
{
    use HasFactory;

    protected $table = 'musics';
    public $timestamps = false;

    protected $fillable = [
        'title',
        'slug',
        'cover',
        'amount',
        'min_amount',
        'bg_page',
        'description',
        'description_download',
        'presell',
        'is_active',
    ];
}
