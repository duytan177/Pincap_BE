<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReactionReply extends Model
{
    protected $table='reaction_replies';
    protected $fillable = [
        'id',
        'user_id',
        'reply_id',
        'feeling_id'
    ];
}
