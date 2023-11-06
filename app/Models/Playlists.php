<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Playlists extends Model
{
    protected $table = 'playlists';


    protected $fillable = [
        'user_id',
        'name',
        'ActiveSongs',
    ];
}
