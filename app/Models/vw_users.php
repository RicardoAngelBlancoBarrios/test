<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class vw_users extends Model
{
    public $timestamps = false;
    protected $table = "vw_users";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'full_name', 'email', 'password'
    ];

    protected $primaryKey = 'id';


    protected $connection = "mysql";
}
