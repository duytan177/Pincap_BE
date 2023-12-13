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
        'isArchived'
    ];
    protected $hidden=[];

    public function getPrivacyAttribute($value)
    {
        return $value=='0'?'PRIVATE':'PUBLIC';
    }



    public function userOwner(){
        return $this->belongsToMany(User::class,"user_album")->withPivot(["isUserOwner","invitation_status"])->withTimestamps();
    }
    public function medias(){
        return $this->belongsToMany(Media::class,'album_media')->withTimestamps();
    }
}
