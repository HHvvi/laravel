<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Activity extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = [
        'activity_title'
    ];

    protected $table = 'ac_activity';
    protected $primaryKey = 'activity_id';

}
