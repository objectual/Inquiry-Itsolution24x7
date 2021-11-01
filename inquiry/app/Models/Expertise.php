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
 *      definition="Expertise",
 *      required={"expertise_id"},
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
 * )
 */
class Expertise extends Model
{
    use SoftDeletes;

    public $table = 'expertise';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'name'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string'
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
    protected $appends = [];

    /**
     * The attributes that should be visible in toArray.
     *
     * @var array
     */
    protected $visible = [
        'id',
        'name'
    ];

    /**
     * Validation create rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required'
    ];

    /**
     * Validation update rules
     *
     * @var array
     */
    public static $update_rules = [
        'name' => 'required'
    ];

    /**
     * Validation api rules
     *
     * @var array
     */
    public static $api_rules = [
        'expertise_id' => 'required'
    ];

    /**
     * Validation api update rules
     *
     * @var array
     */
    public static $api_update_rules = [
        'name' => 'required'
    ];

    public function project_expertise()
    {
        return $this->hasMany(ProjectExpertise::class, 'expertise_id');
    }
}
