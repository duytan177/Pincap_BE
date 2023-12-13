<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReactionComment extends Model
{
    protected $table='reaction_comments';
    protected $fillable = [
        'id',
        'user_id',
        'comment_id',
        'feeling_id'
    ];
}
