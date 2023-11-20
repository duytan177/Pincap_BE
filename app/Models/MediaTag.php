<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class MediaTag extends Model
{
    use HasFactory,HasUlids,Notifiable;

    protected $table='tags';

    protected $fillable = [
        'id',
        'media_id',
        'tag_id',
    ];
    protected $hidden=[];
}
