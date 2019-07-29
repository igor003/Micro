<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Connector extends Model
{
    protected $table = 'connectors';
    protected $fillable = [
        'id', 'name'
    ];
    public $timestamps = false;

    public function codice(){
        return $this->hasMany('App\Miniaplicator','id','connector_id');
    }
    public function configuration(){
        return $this->hasMany('App\Configuration','id','connector_id');
    }
    public function scopeSearch($query, $seraching){
        return $query->where('name', 'like', '%'.$seraching.'%');
    }
    // public function codice(){
    //     return $this->belongsTo('App\Part','part_id');
    // }
    // public function scopeSearch($query,$req){
    //     return $query::with(['codice'=> function ($query) use($req) {
    //         $query->where('name','like','%'.$req.'%');
    //     }]);
    // }
    // public function scopeFilter($query, $req){
    //     return $query::with(['codice.project'=> function ($query) use($req) {
    //         $query->whereIn('project_id',$req);
    //     }]);
    // }
    // public function photos(){
    //     return $this->belongsTo('App\Photo');
    // }
}