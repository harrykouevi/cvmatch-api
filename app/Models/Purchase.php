<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Illuminate\Support\Str;

/**
 * Class Payment.
 *
 * @package namespace App\Entities;
 *
 */
class Purchase extends Model implements Transformable
{

    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [

        "uuid",
        'user_id' ,
        'payment_id',
        'product_type' ,
        'product_id' ,
        'status',
        'amount',
        'currency',
        'product_snapshot_json' ,
        'purchased_at',
    ];

    protected $casts = [
        'product_snapshot_json' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->uuid) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }



     /**
     * Validation rules
     *
     * @var array
     */
    public static array $rules = [
        'user_email' => 'required|email',

    ];


}
