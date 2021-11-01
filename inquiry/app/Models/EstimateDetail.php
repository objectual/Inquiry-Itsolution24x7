<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer id
 * @property string name
 * @property string created_at
 * @property string updated_at
 * @property string deleted_at
 *
 * @SWG\Definition(
 *      definition="EstimateDetail",
 *      required={"estimate_id", "project_id", "description", "quantity", "price", "tax"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="estimate_id",
 *          description="estimate_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="project_id",
 *          description="project_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="description",
 *          description="description",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="quantity",
 *          description="quantity",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="price",
 *          description="price",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="tax",
 *          description="tax",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="created_at",
 *          description="created_at",
 *          type="string",
 *          format="date-time"
 *      ),
 *      @SWG\Property(
 *          property="updated_at",
 *          description="updated_at",
 *          type="string",
 *          format="date-time"
 *      ),
 *      @SWG\Property(
 *          property="deleted_at",
 *          description="deleted_at",
 *          type="string",
 *          format="date-time"
 *      )
 * )
 */
class EstimateDetail extends Model
{
    use SoftDeletes;

    public $table = 'estimate_details';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'estimate_id',
        'project_id',
        'description',
        'quantity',
        'price',
        'tax'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'          => 'integer',
        'estimate_id' => 'integer',
        'project_id'  => 'integer',
        'description' => 'string',
        'quantity'    => 'integer',
        'price'       => 'string',
        'tax'         => 'string'
    ];

    /**
     * The objects that should be append to toArray.
     *
     * @var array
     */
    protected $with = [];

    /**
     * The attributes that should be append to toArray.
     *
     * @var array
     */
    protected $appends = [];

    /**
     * The attributes that should be visible in toArray.
     *
     * @var array
     */
    protected $visible = [];

    /**
     * Validation create rules
     *
     * @var array
     */
    public static $rules = [
        'estimate_id' => 'required',
        'project_id'  => 'required',
        'description' => 'required',
        'quantity'    => 'required',
        'price'       => 'required',
        'tax'         => 'required'
    ];

    /**
     * Validation update rules
     *
     * @var array
     */
    public static $update_rules = [
        'estimate_id' => 'required',
        'project_id'  => 'required',
        'description' => 'required',
        'quantity'    => 'required',
        'price'       => 'required',
        'tax'         => 'required'
    ];

    /**
     * Validation api rules
     *
     * @var array
     */
    public static $api_rules = [
        'estimate_id' => 'required',
        'project_id'  => 'required',
        'description' => 'required',
        'quantity'    => 'required',
        'price'       => 'required',
        'tax'         => 'required'
    ];

    /**
     * Validation api update rules
     *
     * @var array
     */
    public static $api_update_rules = [
        'estimate_id' => 'required',
        'project_id'  => 'required',
        'description' => 'required',
        'quantity'    => 'required',
        'price'       => 'required',
        'tax'         => 'required'
    ];

    public function estimates()
    {
        return $this->belongsTo(Estimate::class);
    }
}
