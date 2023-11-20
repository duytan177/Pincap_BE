<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class AlbumMedia extends Model
{
    use HasFactory,HasUlids,Notifiable;

//    protected $table='album_media';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'album_id',
        'media_id',
        'created_at',
        'updated_at'
    ];
    protected $hidden=[];
}
