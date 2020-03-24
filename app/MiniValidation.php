<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class MiniValidation extends Model
{
    protected $table = 'mini_validation';
    protected $fillable = [
        'id','id_mini', 'type_validation', 'status','date','path'
    ];
    
    public $timestamps = false;


    public function minis(){
        return $this->belongsTo('App\Miniaplicator','id_mini');
    }

    public function scopeDate($query, $date){
        return $query->whereHas('minis.connector', function ($query) use($date) {
            $query->where('date', $date);
        });
    }

    public function scopeMini($query, $mini){
        return $query->whereHas('minis', function ($query) use($mini) {
            $query->where('id',$mini);
        });
    }
    public function scopeType($query, $type){
        return $query->where('type_validation','=',$type);
    }
}

