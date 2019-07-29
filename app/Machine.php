<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{
    protected $table = 'machines';
    protected $fillable = [
        'id', 'number'
    ];
    public $timestamps = false;

    public function scopeSearch($query, $seraching){
        return $query->where('number', 'like', '%'.$seraching.'%');
    }
}
