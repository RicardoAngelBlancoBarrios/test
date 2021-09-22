<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class vw_tiempoespera extends Model
{
    public $timestamps = false;
    protected $table = "vw_tiempoespera";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idcola', 'cola', 'cantidad', 'tiempoespera'
    ];

    protected $primaryKey = 'idcola';


    protected $connection = "mysql";
}
