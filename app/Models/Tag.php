<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Tag extends Model
{
    use HasFactory,HasUlids,Notifiable;

    protected $table='tags';
    protected $fillable = [
        'id',
        'tagName',
        'ownerUserCreated_id',
    ];
    protected $hidden=[];

    public function userOwner(){
        return $this->belongsTo(User::class,'ownerUserCreated_id');
    }
    public function medias(){
        return $this->belongsToMany(Media::class,'media_tag')->withTimestamps();
    }
}
