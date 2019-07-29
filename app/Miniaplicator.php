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
    // }
    // public function photos(){
    //     return $this->belongsTo('App\Photo');
     }

    public function scopeSearch($query, $seraching){
        return $query->where('name', 'like', '%'.$seraching.'%');
    }
}

