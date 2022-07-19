<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class MiniCalibration extends Model
{
    protected $table = 'mini_calibration';
    protected $fillable = [
        'id', 'part_id', 'components', 'machine_id', 'miniaplicator_id','calibration_id', 'calibration_down'
    ];
    public $timestamps = false;

   	public function codice(){
        return $this->belongsTo('App\Part','part_id');
    }

	public function machines(){
        return $this->belongsTo('App\Machine','machine_id');
    }

    public function minis(){
        return $this->belongsTo('App\Miniaplicator','miniaplicator_id');
    }

    public function scopeCodice($query, $codice){
        return $query->whereHas('codice', function ($query) use($codice) {
            $query->where('name','like','%'.$codice.'%');
        });
    }

	public function scopeMachine($query, $machine){
        return $query->whereHas('machines', function ($query) use($machine) {
            $query->where('number','=',$machine);
        });
    }
    public function scopeMini($query, $mini){
        return $query->whereHas('minis', function ($query) use($mini) {
            $query->where('name','like',$mini.'%');
        });
    }
}


