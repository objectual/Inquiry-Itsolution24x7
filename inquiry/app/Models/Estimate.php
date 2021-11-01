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
 *      definition="Estimate",
 *      required={"customer_id", "currency_id", "date", "expiry", "subheading", "footer", "memo"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="customer_id",
 *          description="customer_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="currency_id",
 *          description="currency_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="date",
 *          description="date",
 *          type="string",
 *          format="date"
 *      ),
 *      @SWG\Property(
 *          property="expiry",
 *          description="expiry",
 *          type="string",
 *          format="date"
 *      ),
 *      @SWG\Property(
 *          property="subheading",
 *          description="subheading",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="footer",
 *          description="footer",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="memo",
 *          description="memo",
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
class Estimate extends Model
{
    use SoftDeletes;

    public $table = 'estimates';


    protected $dates = ['deleted_at'];

//    public CURRENCY = [
//        ];
    const PKR = 0;
    const DOLLAR = 1;

    public static $CURRENY = [
        self::PKR    => 'PKR',
        self::DOLLAR => 'DOLLAR',
    ];

    public $fillable = [
        'customer_id',
        'currency_id',
        'date',
        'expiry',
        'subheading',
        'footer',
        'memo'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'          => 'integer',
        'customer_id' => 'integer',
        'currency_id' => 'integer',
        'date'        => 'date',
        'expiry'      => 'date',
        'subheading'  => 'string',
        'footer'      => 'string',
        'memo'        => 'string'
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
        'customer_id' => 'required',
        'currency_id' => 'required',
        'date'        => 'required',
        'expiry'      => 'required',
        'subheading'  => 'required',
        'footer'      => 'required',
        'memo'        => 'required'
    ];

    /**
     * Validation update rules
     *
     * @var array
     */
    public static $update_rules = [
        'customer_id' => 'required',
        'currency_id' => 'required',
        'date'        => 'required',
        'expiry'      => 'required',
        'subheading'  => 'required',
        'footer'      => 'required',
        'memo'        => 'required'
    ];

    /**
     * Validation api rules
     *
     * @var array
     */
    public static $api_rules = [
        'customer_id' => 'required',
        'currency_id' => 'required',
        'date'        => 'required',
        'expiry'      => 'required',
        'subheading'  => 'required',
        'footer'      => 'required',
        'memo'        => 'required'
    ];

    /**
     * Validation api update rules
     *
     * @var array
     */
    public static $api_update_rules = [
        'customer_id' => 'required',
        'currency_id' => 'required',
        'date'        => 'required',
        'expiry'      => 'required',
        'subheading'  => 'required',
        'footer'      => 'required',
        'memo'        => 'required'
    ];

    public function details()
    {
        return $this->hasMany(EstimateDetail::class, 'estimate_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
