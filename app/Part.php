<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Part extends Model
{
    protected $table = 'part';
    protected $fillable = ['project_id','name'];
    public $timestamps = false;

    public function project(){
        return $this->belongsTo('App\Project');
    }

    public function configuration(){
        return $this->hasMany('App\Project','part_id','id');
    }

    public function scopeSearch($query, $seraching){
        return $query->where('name', 'like', '%'.$seraching.'%');
    }

    public function scopeFilter($query, $filter){
        return $query->whereIn('project_id',$filter);
    }
}
