<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class MachineLumberg extends Model
{
    protected $table = 'devices';
    protected $fillable = [
        'id', 'id_type', 'number', 'serial_number', 'Inventory_number', 'maker', 'model', 'status'
    ];
    public $timestamps = false;

   
}
