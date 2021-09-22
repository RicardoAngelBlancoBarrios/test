<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class vw_visualizacion extends Model
{
    public $timestamps = false;
    protected $table = "vw_visualizacion";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'IdAsignacion', 'Identificador', 'Nombre', 'IdCola', 'DescripcionCola', 'IdStatus', 'DescripcionStatus', 'Duracion'
    ];

    protected $primaryKey = 'id';


    protected $connection = "mysql";
}
