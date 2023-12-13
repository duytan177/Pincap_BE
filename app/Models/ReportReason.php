<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ReportReason extends Model
{
    use HasFactory,HasUlids,Notifiable;

    protected $table='report_reasons';
    protected $fillable = [
        'id',
        'title',
        'description'
    ];
    protected $hidden=[];


    public function reasonReport(){
        return $this->hasMany(MediaReport::class,'report_reason_id','id');
    }
}
