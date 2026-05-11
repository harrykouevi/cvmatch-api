<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Event
 *
 * @package namespace App\Entities;
 *
 */
class Event extends Model implements Transformable
{

    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [

        "event_name" ,
        "session_id",
        "analysis_id",
        "payload"
    ];


     /**
     * Validation rules
     *
     * @var array
     */
    public static array $rules = [

        "event_name"  => 'required|string',
        "session_id" => 'required|string',
        "analysis_id" => 'required|exists:analyses,id',
        "payload"=> 'required|string'

    ];


}
