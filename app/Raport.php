<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Raport extends Model
{
    protected $table = 'raport';
    protected $fillable = ['total_micr','efectuated_micr','total_launch','date'];
    public $timestamps = false;

}