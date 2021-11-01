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
 *      definition="Description",
 *      required={"project_id", "details", "attachment"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
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
 *          property="details",
 *          description="details",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="attachment",
 *          description="attachment",
 *          type="string"
 *      )
 * )
 */
class Description extends Model
{
    use SoftDeletes;

    public $table = 'descriptions';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'project_id',
        'details',
        'attachment'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'details'    => 'string',
        'attachment' => 'string'
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
    public static $rules =
        [
            'project_id' => 'required',
            'details'    => 'required',
            'attachment' => 'mimes:jpeg,png,pdf,jpg',
        ];

    /**
     * Validation update rules
     *
     * @var array
     */
    public static $update_rules = [
        'project_id'   => 'required',
        'details'      => 'required',
        'attachment[]' => 'required'
    ];

    /**
     * Validation api rules
     *
     * @var array
     */
    public static $api_rules = [
        'project_id'   => 'required',
        'details'      => 'required',
        'attachment[]' => 'required'
    ];

    /**
     * Validation api update rules
     *
     * @var array
     */
    public static $api_update_rules = [
        'project_id' => 'required',
        'details'    => 'required',
        'attachment' => 'required'
    ];

    public function media()
    {
        return $this->morphMany(Attachment::class, 'instance');
    }

    public function getMorphClass()
    {
        return 'descriptionImage';
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
