<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ReportMedia extends Model
{
    use HasFactory,HasUlids,Notifiable;

    protected $table='report_media';
    protected $fillable = [
        'id',
        'user_id',
        'album_id',
    ];
    protected $hidden=[];
}
