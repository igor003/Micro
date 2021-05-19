<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Connector extends Model
{
    protected $table = 'connectors';
    protected $fillable = [
        'id', 'name', 'specification_path', 'photo_path'
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
}