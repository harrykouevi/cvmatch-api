<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Credittransaction
 *
 * @package namespace App\Entities;
 *
 */
class CreditTransaction extends Model implements Transformable
{

    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_email' ,
        'payment_id' ,
        'type' ,
        'credits',
        'balance_after',
        'pricing_snapshot_json',
        'description'
    ];


     /**
     * Validation rules
     *
     * @var array
     */
    public static array $rules = [
        'user_email' => 'required|email',
        'payment_id' => 'required|exists:payments,id',
        'type' => 'string' ,
        'credits' => 'required|integer|min:1|max:9999999',
        'pricing_snapshot_json' => 'required|string|max:255',
        'description' => 'string',

    ];


}
