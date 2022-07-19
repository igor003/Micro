<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Odl extends Model
{
    protected $table = 'odl';
    protected $fillable = ['odl_number','created_at'];
    public $timestamps = false;

}