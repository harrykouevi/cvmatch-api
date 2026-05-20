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
        'tenant_id',
        'user_id',
        'payment_id',
        'type',
        'credits',
        'balance_after',
        'snapshot_json',
        'description',

    ];


    protected $casts = [
        'snapshot_json' => 'array',
    ];

     /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

}
