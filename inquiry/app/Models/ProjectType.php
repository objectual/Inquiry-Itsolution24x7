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
 *      definition="ProjectType",
 *      required={"project_id", "type"},
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
 *          property="type",
 *          description="type",
 *          type="boolean"
 *      )
 * )
 */
class ProjectType extends Model
{
    use SoftDeletes;

    public $table = 'project_type';


    protected $dates = ['deleted_at'];

    const NOTSURE = 0;
    const ONETIME = 1;
    const ONGOING = 2;

    public static $TYPE = [
        self::NOTSURE => 'NotSure',
        self::ONETIME => 'OneTime',
        self::ONGOING => 'OnGoing',
    ];

    public $fillable = [
        'project_id',
        'type'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'type' => 'int'
    ];

    /**
     * The objects that should be append to toArray.
     *
     * @var array
     */
    protected $with = [
        'project_attributes'
    ];

    /**
     * The attributes that should be append to toArray.
     *
     * @var array
     */
    protected $appends = [

    ];

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
        'project_id' => 'required',
        'type'       => 'required'
    ];

    /**
     * Validation update rules
     *
     * @var array
     */
    public static $update_rules = [
        'project_id' => 'required',
        'type'       => 'required'
    ];

    /**
     * Validation api rules
     *
     * @var array
     */
    public static $api_rules = [
        'project_id' => 'required',
        'type'       => 'required'
    ];

    /**
     * Validation api update rules
     *
     * @var array
     */
    public static $api_update_rules = [
        'project_id' => 'required',
        'type'       => 'required'
    ];

    public function project()
    {
        return $this->hasOne(Project::class);
    }

    public function project_attributes()
    {
        return $this->hasOne(ProjectAttribute::class, 'instance_id');
    }


}
