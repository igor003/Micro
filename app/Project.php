<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table = 'projects';
    protected $fillable = ['name'];
    public $timestamps = false;

    public function codice(){
        return $this->hasMany('App\Part','id','project_id');
    }

    public function scopeSearch($query, $seraching){
        return $query->where('name', 'like', '%'.$seraching.'%');
    }
}