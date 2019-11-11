<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class MiniValidation extends Model
{
    protected $table = 'mini_validation';
    protected $fillable = [
        'id','id_mini', 'type_validation', 'status','date','path'
    ];
    
    public $timestamps = false;


    public function minis(){
        return $this->belongsTo('App\Miniaplicator','id_mini');
    }

}

