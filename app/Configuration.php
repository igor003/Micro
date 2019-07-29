<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
    protected $table = 'part_configuration';
    protected $fillable = [
        'part_id','components','connecting_element','sez_components','total_sez','nr_strand','height','width'
    ];
    public $timestamps = false;

    public function codice(){
        return $this->belongsTo('App\Part','part_id');
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