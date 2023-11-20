<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class UserAlbum extends Model
{
    use HasFactory,HasUlids,Notifiable;

    protected $table='user_album';
    protected $fillable = [
        'id',
        'user_id',
        'album_id',
    ];
    protected $hidden=[];
}
