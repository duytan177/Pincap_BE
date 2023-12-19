<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Album extends Model
{
    use HasFactory,HasUlids,Notifiable;

    protected $table="albums";
    protected $fillable = [
        'id',
        'albumName',
        'imageCover',
        'description',
        'privacy',
        'isArchived',
        'user_id',
    ];
    protected $hidden=[];

    public function getPrivacyAttribute($value)
    {
        return $value=='0'?'PRIVATE':'PUBLIC';
    }
    public function members(){
        return $this->belongsToMany(User::class,"user_album")->withPivot("invitation_status")->withTimestamps();
    }

    public function userOwner(){
        return $this->belongsTo(User::class,"user_id",'id');
    }
    public function medias(){
        return $this->belongsToMany(Media::class,'album_media')->withTimestamps();
    }
}
