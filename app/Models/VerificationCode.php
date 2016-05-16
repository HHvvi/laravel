<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class VerificationCode extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = [
        'to',
        'verification_code',
        'sent_time',
        'created_at',
        'updated_at',
        'dtime',
    ];

    protected $table = 'ac_verification_code';
    protected $primaryKey = 'id';



}
