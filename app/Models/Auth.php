<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Auth extends Authenticatable
{

    protected $fillable = [];
    protected $table = 'ac_user';
    protected $primaryKey = 'user_guid';
    public $incrementing = false;
    
}
