<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * Class Payment.
 *
 * @package namespace App\Entities;
 *
 */
class Payment extends Model implements Transformable
{

    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_email',
        'plan',
        'amount',
        'currency',
        'stripe_session_id',
        'status'
    ];


     /**
     * Validation rules
     *
     * @var array
     */
    public static array $rules = [
        'user_email' => 'required|email',

    ];


}
