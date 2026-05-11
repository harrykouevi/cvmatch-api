<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Credit
 *
 * @package namespace App\Entities;
 *
 */
class Credit extends Model implements Transformable
{

    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_email' ,
        'remaining_credits',
    ];


     /**
     * Validation rules
     *
     * @var array
     */
    public static array $rules = [
        'user_email' => 'required|email',
        'remaining_credits' => 'required|integer|min:1|max:9999999',

    ];


}
