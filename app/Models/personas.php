<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class personas extends Model
{
    public $timestamps = false;
    protected $table = "personas";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'Identificador', 'Nombre', 'audit'
    ];

    protected $primaryKey = 'id';


    protected $connection = "mysql";
}
