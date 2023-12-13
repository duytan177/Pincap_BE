<?php

namespace App\Models;

use App\Enums\Album_Media\InvitationStatus;
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
        'isUserOner',
        'invitation_status'
    ];
    protected $hidden=[];

    public function getInvitationStatusAttribute($value){
        $value = (int)$value;
        switch ($value){
            case 0:
                return InvitationStatus::getKey($value);
                break;
            case 1:
                return InvitationStatus::getKey($value);
                break;
            case 2:
                return InvitationStatus::getKey($value);
                break;
        }
    }
}
