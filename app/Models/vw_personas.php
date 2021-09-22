<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class vw_personas extends Model
{
    public $timestamps = false;
    protected $table = "vw_personas";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'Identificador', 'Nombre'
    ];

    protected $primaryKey = 'id';


    protected $connection = "mysql";
}
