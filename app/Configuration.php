<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
    protected $table = 'part_configuration';
    protected $fillable = [
        'part_id','department','components','connector_id','sez_components','total_sez','nr_strand','height','width'
    ];
    public $timestamps = false;

    public function codice(){
        return $this->belongsTo('App\Part','part_id');
    }
    public function connector(){
        return $this->belongsTo('App\Connector','connector_id');
    }


    public function scopeProject($query, $projects){
         return $query->whereHas('codice', function ($query) use($projects) {
            $query->whereIn('project_id',$projects);
        });
    }
    
    public function scopeConnectors($query, $connector){
        return $query->whereHas('connector', function ($query) use($connector) {
            $query->where('id','=',$connector);
        });
    }
    public function scopeSection($query, $section){
        return $query->where('total_sez','=',$section);
        
    }
    public function scopeDepartment($query, $department){
        return $query->where('department','=',$department);
        
    }

    public function scopeSearch($query,$req){
        return $query::with(['codice'=> function ($query) use($req) {
            $query->where('name','like','%'.$req.'%');
        }]);
    }
    public function scopeFilter($query, $req){
        return $query::with(['codice.project'=> function ($query) use($req) {
            $query->whereIn('project_id',$req);
        }]);
    }
    public function photos(){
        return $this->belongsTo('App\Photo');
    }
}