<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Miniaplicator extends Model
{
    protected $table = 'miniaplicators';
    protected $fillable = [
        'id', 'name', 'connector_id'
    ];
    public $timestamps = false;


    public function connector(){
        return $this->belongsTo('App\Connector');
    }
 
    public function scopeFilter($query, $req){
        return $query->whereHas('connector', function ($query) use($req) {
        $query->where('id',$req);
        });
     }

    public function scopeSearch($query, $seraching){
        return $query->where('name', 'like', '%'.$seraching.'%');
    }

    public function calibration(){
        return $this->hasMany('App\MiniCalibration','id','miniaplicator_id');
    }

    public function validation(){
        return $this->hasMany('App\MiniValidation','id','id_mini');
    }

}

