<?php

namespace App\Models;

use App\Enums\Album_Media\StateReport;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class MediaReport extends Model
{
    use HasFactory,HasUlids,Notifiable;

    protected $table='media_report';
    protected $primaryKey = "id";
    protected $fillable = [
        'id',
        'state',
        'report_reason_id',
        'user_id',
        'media_id',
        'other_reasons',
    ];
    protected $hidden=[

    ];

    public function getStateAttribute($value){
        return $value=='0'?StateReport::getKey(0):StateReport::getKey(1);
    }


    public function reasonReport(){
        return $this->belongsTo(ReportReason::class,'report_reason_id','id');
    }

    public function userReport(){
            return $this->belongsTo(User::class,'user_id','id');
    }

    public function reportMedia(){
        return $this->belongsTo(Media::class,'media_id','id');
    }
}
