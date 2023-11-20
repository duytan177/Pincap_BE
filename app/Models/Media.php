<?php

namespace App\Models;

use App\Enums\Album_Media\Privacy;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Media extends Model
{
    use HasFactory,HasUlids,Notifiable;

    protected $table='medias';
    protected $fillable = [
        'id',
        'mediaName',
        'mediaURL',
        'description',
        'type',
        'privacy',
        'isCreated',
        'isDeleted',
        'mediaOwner_id',
    ];
    protected $hidden=[

    ];


    public function getTypeAttribute($value){
        return $value=='0'?'IMAGE':'VIDEO';
    }
    public function getPrivacyAttribute($value){
        return $value=='0'?'PRIVATE':'PUBLIC';
    }

    public function albums(){
        return $this->belongsToMany(Album::class,'album_media')->withTimestamps();
    }



}
