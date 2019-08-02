<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $table = 'foto';
    protected $fillable = ['configuration_id','foto1','foto2','foto3','maked_at','created_at'];

    public function configurations(){
        return $this->hasMany('App\Configuration','id','configuration_id');
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
    public function scopeCodice($query, $codice){
        return $query->whereHas('configurations', function ($query) use($codice) {
            $query->whereIn('part_id',$codice);
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
    // public function scopeRaportProject($query, $project_id){
    //     return $query->where('project_id', '=', $project_id);
    // }
    // public function scopeRaportPart($query, $part_id){
    //     return $query->where('part_id', '=', $part_id);
    // }

}