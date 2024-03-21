<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        'sort',
    ];

    public function file(): HasMany
    {
        return $this->hasMany(File::class);
    }
}
