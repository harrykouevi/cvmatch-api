<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class MobileWait
 *
 * @package namespace App\Entities;
 *
 */
class MobileWait extends Model implements Transformable
{

    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [

        "email",
        "source"
    ];


     /**
     * Validation rules
     *
     * @var array
     */
    public static array $rules = [

        "email" => 'required|email',
        "source"=> 'required|string'

    ];


}
