<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Ad extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = [
        'title'
    ];

    protected $table = 'ac_ad';
    protected $primaryKey = 'ad_id';

}
