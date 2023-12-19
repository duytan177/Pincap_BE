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

    public function  userComments(){
        return $this->belongsToMany(User::class,'comments')->withPivot(["content",'id'])->withTimestamps();
    }
    public function reactionUser(){
        return $this->belongsToMany(User::class,"reaction_media")->withPivot(["feeling_id"])->withTimestamps();
    }

    public function albums(){
        return $this->belongsToMany(Album::class,'album_media')->withTimestamps();
    }
    public function tags(){
        return $this->belongsToMany(Tag::class,'media_tag')->withTimestamps();
    }

    public function userOwner(){
        return $this->belongsTo(User::class,'mediaOwner_id','id');
    }

    public function mediaReported(){
        return $this->belongsToMany(User::class,'media_report')->withPivot(["state","report_reason_id","other_reasons"])->withTimestamps();
    }

}
