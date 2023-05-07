<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buys extends Model
{
    use HasFactory;
    protected $fillable = [
        'comment',
        'amount',
        'user',
        'music',
        'RefID',
        'is_presell',
    ];
}
