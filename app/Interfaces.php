<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Interfaces extends Model{
    protected $table = 'interfaces';
    protected $fillable = [
        'id', 'name', 'code', 'blocket', 'path_stl', 'path_f3d', 'path_jpg'
    ];
    public $timestamps = false;
}