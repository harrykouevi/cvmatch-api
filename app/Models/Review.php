<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Review
 *
 * @package namespace App\Entities;
 *
 */
class Review extends Model implements Transformable
{

    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [

        "analysis_id",
        "rating",
        "comment"
    ];


     /**
     * Validation rules
     *
     * @var array
     */
    public static array $rules = [

        "analysis_id" => 'required|exists:analyses,id',
        "rating"=> 'numeric|max:5|min:0',
        "comment"=> 'required|string'

    ];


}
