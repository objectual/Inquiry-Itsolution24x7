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
 *      definition="Attachment",
 *      required={"name"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="name",
 *          description="name",
 *          type="string"
 *      )
 * )
 */
class Attachment extends Model
{
    use SoftDeletes;

    public $table = 'attachments';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'instance_id',
        'instance_type',
        'attachment',
        'filename',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'instance_id'   => 'int',
        'instance_type' => 'string',
        'attachment'    => 'string',
        'filename'      => 'string',
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
    protected $appends = [
        'file_url'
    ];

    /**
     * The attributes that should be visible in toArray.
     *
     * @var array
     */
    protected $visible = [
        'id',
        'title',
        'filename',
        'attachment',
        'created_at'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */

    public function instance()
    {
        return $this->morphTo();
    }

    public function attribute()
    {
        return $this->belongsTo(ProjectAttribute::class, 'id');
    }

}
