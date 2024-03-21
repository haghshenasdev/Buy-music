<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class File extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'path',
        'title',
        'music_id',
    ];

    public function music(): BelongsTo
    {
        return $this->belongsTo(Music::class);
    }
}
