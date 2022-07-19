<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $table = 'foto';
    protected $fillable = ['configuration_id','foto1','foto2','foto3','miniaplicator_id','machine_id','start_time','maked_at','created_at','height','work_order'];
    public function configurations2(){
        return $this->belongsTo('App\Configuration','configuration_id');
    }
    public function configurations(){
        return $this->hasMany('App\Configuration','id','configuration_id');
    }
   
    public function machines(){
        return $this->belongsTo('App\Machine','machine_id');
    }
    public function minis(){
        return $this->belongsTo('App\Miniaplicator','miniaplicator_id');
    }
    public function scopeDate($query, $date_from , $date_to){
        return $query->whereHas('configurations.codice.project', function ($query) use($date_from,$date_to) {
            $query->whereBetween('maked_at', [$date_from, $date_to]);
        });
    }
    public function scopeProject($query, $projects){
        return $query->whereHas('configurations.codice.project', function ($query) use($projects) {
            $query->whereIn('id',$projects);
        });
    }
    public function scopeMini($query, $mini){
        return $query->whereHas('minis', function ($query) use($mini) {
            $query->where('id',$mini);
        });
    }
    public function scopeConfig($query, $config){
       return $query->where('configuration_id',$config);
      
    }
    public function scopeMachine($query, $machine){
        return $query->whereHas('machines', function ($query) use($machine) {
            $query->where('id',$machine);
        });
    }
    public function scopeCodice($query, $codice){
        return $query->whereHas('configurations', function ($query) use($codice) {
            $query->where('part_id',$codice);
        });
    }
    public function scopeRaport($query, $date_from, $date_to){
        return $query->whereHas('configurations.codice.project', function ($query) use($date_from,$date_to) {
            $query->whereBetween('maked_at', [$date_from, $date_to]);
        });
    }
    public function scopeProject1($query, $project){
        return $query->whereHas('configurations.codice', function ($query) use($project) {
            $query->whereIn('project_id',$project);
        });
    }
    public function scopeConfiguration($query, $part_id){
        return $query->whereHas('configurations.codice', function ($query) use($part_id) {
            $query->where('id',$part_id);
        });
    }
    public function photos_last_year($year){
        return $this->where('maked_at','like','%'.$year);
    }

  
    // public function scopeRaportProject($query, $project_id){
    //     return $query->where('project_id', '=', $project_id);
    // }
    // public function scopeRaportPart($query, $part_id){
    //     return $query->where('part_id', '=', $part_id);
    // }

}
