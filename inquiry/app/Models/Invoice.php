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
 *      definition="Invoice",
 *      required={"number", "order_id", "from", "to", "status", "amount", "description"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="number",
 *          description="number",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="order_id",
 *          description="order_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="from",
 *          description="from",
 *          type="string",
 *          format="date"
 *      ),
 *      @SWG\Property(
 *          property="to",
 *          description="to",
 *          type="string",
 *          format="date"
 *      ),
 *      @SWG\Property(
 *          property="status",
 *          description="status",
 *          type="boolean"
 *      ),
 *      @SWG\Property(
 *          property="amount",
 *          description="amount",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="description",
 *          description="description",
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
class Invoice extends Model
{
    use SoftDeletes;

    public $table = 'invoices';


    protected $dates = ['deleted_at'];

    const PAID = 0;
    const DUE = 1;
    const PARTIAL = 2;

    public static $STATUS = [
        self::PAID    => 'Paid',
        self::DUE     => 'Due',
        self::PARTIAL => 'Partial',
    ];
    public $fillable = [
        'number',
        'order_id',
        'from',
        'to',
        'status',
        'amount',
        'description'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'          => 'integer',
        'number'      => 'integer',
        'order_id'    => 'integer',
        'from'        => 'date',
        'to'          => 'date',
        'status'      => 'integer',
        'amount'      => 'string',
        'description' => 'string'
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
        'number'      => 'required',
        'order_id'    => 'required',
        'from'        => 'required',
        'to'          => 'required',
        'status'      => 'required',
        'amount'      => 'required',
        'description' => 'required'
    ];

    /**
     * Validation update rules
     *
     * @var array
     */
    public static $update_rules = [
        'number'      => 'required',
        'order_id'    => 'required',
        'from'        => 'required',
        'to'          => 'required',
        'status'      => 'required',
        'amount'      => 'required',
        'description' => 'required'
    ];

    /**
     * Validation api rules
     *
     * @var array
     */
    public static $api_rules = [
        'number'      => 'required',
        'order_id'    => 'required',
        'from'        => 'required',
        'to'          => 'required',
        'status'      => 'required',
        'amount'      => 'required',
        'description' => 'required'
    ];

    /**
     * Validation api update rules
     *
     * @var array
     */
    public static $api_update_rules = [
        'number'      => 'required',
        'order_id'    => 'required',
        'from'        => 'required',
        'to'          => 'required',
        'status'      => 'required',
        'amount'      => 'required',
        'description' => 'required'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
