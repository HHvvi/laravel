<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class UserMark extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = [
        'mark_id',
        'dtime',
        'user_guid'
    ];
    protected $table = 'ac_user_mark';
    const CREATED_AT = 'dtime';
    const UPDATED_AT = 'dtime';
}
