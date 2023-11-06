<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Games extends Model
{

    protected $table = 'games';

    protected $fillable = [
        'user_id',
        'gamepin',
        'playlist_id',
        'gm',
        'tips',
        'status'
    ];

}
