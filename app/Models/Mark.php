<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Mark extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = [];
    protected $table = 'ac_mark';
    protected $primaryKey = 'mark_id';
}
