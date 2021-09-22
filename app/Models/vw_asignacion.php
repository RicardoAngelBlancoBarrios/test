<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class vw_asignacion extends Model
{
    public $timestamps = false;
    protected $table = "vw_asignacion";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'IdPersona', 'IdCola', 'IdStatus'
    ];

    protected $primaryKey = 'id';


    protected $connection = "mysql";
}
