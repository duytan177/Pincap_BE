<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Comment extends Model
{
    use HasFactory,HasUlids,Notifiable;
    protected $fillable = [
        'id',
        'user_id',
        'media_id',
        'content'
    ];
}
