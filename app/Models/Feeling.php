<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Feeling extends Model
{
    use HasFactory,HasUlids,Notifiable;
    protected $fillable = [
        'id',
        'feeling_type',
        'icon_url'
    ];

    public function reactionMedia(){
        return $this->hasMany(ReactionMedia::class,'feeling_id','id');
    }
}
