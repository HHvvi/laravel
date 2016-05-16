<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class DefaultIcon extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = [];

    protected $table = 'ac_default_icon';
    protected $primaryKey = 'icon_id';

}
