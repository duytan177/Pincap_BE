<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ReactionMedia extends Model
{
    use HasFactory,HasUlids,Notifiable;

    protected $table='reaction_media';
    protected $fillable = [
        'id',
        'user_id',
        'media_id',
        'feeling_id'
    ];
    protected $hidden=[];



}
