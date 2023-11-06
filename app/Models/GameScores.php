<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameScores extends Model
{

    protected $table = 'gamescores';

    protected $fillable = [
        'gamepin',
        'player_id',
        'scores',
        'player_name'
    ];

}
