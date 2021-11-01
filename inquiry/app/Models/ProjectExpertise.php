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
 *      definition="ProjectExpertise",
 *      required={"expertise_id"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *     @SWG\Property(
 *          property="project_id",
 *          description="project id",
 *          type="integer",
 *          format="int32"
 *      ),
 *     @SWG\Property(
 *          property="expertise_id",
 *          description="Expertise",
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
class ProjectExpertise extends Model
{
    use SoftDeletes;

    public $table = 'project_expertise';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'project_id',
        'expertise_id',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'project_id'   => 'int',
        'expertise_id' => 'int',
    ];

    /**
     * The objects that should be append to toArray.
     *
     * @var array
     */
    protected $with = [

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
    protected $visible = [
        'project_id',
        'expertise_id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function name()
    {
        return $this->belongsTo(Expertise::class);
    }

}
