<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Presentable;
use Prettus\Repository\Traits\PresentableTrait;

class User extends Model  implements Presentable
{
    use PresentableTrait;
    
    protected $fillable = [
        'email',
        'mobile',
        'user_guid',
        'user_account',
        'nick_name',
        'logo',
        'sex',
        'born_date',
        'salt',
        'pwd',
        'height',
        'weight',
    ];
    protected $hidden = [
        'user_id'
    ];
    protected $table = 'ac_user';
    protected $primaryKey = 'user_guid';
    public $incrementing = false;
    const CREATED_AT = 'dtime';
    const UPDATED_AT = 'update_time';


}
