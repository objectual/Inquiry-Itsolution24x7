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
 *      definition="ProjectAttribute",
 *      required={"content", "amount", "attachment"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="instance_id",
 *          description="instance_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="instance_type",
 *          description="instance_type",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="content",
 *          description="content",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="amount",
 *          description="amount",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="attachment",
 *          description="attachment",
 *          type="string"
 *      )
 * )
 */
class ProjectAttribute extends Model
{
    use SoftDeletes;

    public $table = 'project_attribute';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'instance_id',
        'instance_type',
        'content',
        'amount',
        'attachment'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'instance_id'   => 'int',
        'instance_type' => 'string',
        'content'       => 'string',
        'attachment'    => 'string'
    ];

    /**
     * The objects that should be append to toArray.
     *
     * @var array
     */
    protected $with = ['attachment'];

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
        'content'    => 'required',
        'amount'     => 'required',
        'attachment' => 'required'
    ];

    /**
     * Validation update rules
     *
     * @var array
     */
    public static $update_rules = [
        'content'    => 'required',
        'amount'     => 'required',
        'attachment' => 'required'
    ];

    /**
     * Validation api rules
     *
     * @var array
     */
    public static $api_rules = [
        'attachment'  => 'required|file'

    ];

    /**
     * Validation api update rules
     *
     * @var array
     */
    public static $api_update_rules = [
        'content'    => 'required',
        'amount'     => 'required',
        'attachment' => 'required'
    ];

    public function type()
    {
        return $this->belongsTo(ProjectType::class, 'id');
    }

    public function budget()
    {
        return $this->belongsTo(Budget::class, 'id');
    }

    public function attachment()
    {
        return $this->hasOne(Attachment::class, 'instance_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */


    public function media()
    {
        return $this->morphOne(Attachment::class, 'instance');
    }

    public function getMorphClass()
    {
        return 'stage';
    }

}
