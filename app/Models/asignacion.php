<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class asignacion extends Model
{
    public $timestamps = false;
    protected $table = "asignacion";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'IdPersona', 'IdCola', 'IdStatus', 'audit'
    ];

    protected $primaryKey = 'id';


    protected $connection = "mysql";
}
