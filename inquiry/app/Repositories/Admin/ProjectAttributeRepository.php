<?php

namespace App\Repositories\Admin;

use App\Models\Budget;
use App\Models\ProjectAttribute;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ProjectAttributeRepository
 * @package App\Repositories\Admin
 * @version March 13, 2019, 3:29 pm UTC
 *
 * @method ProjectAttribute findWithoutFail($id, $columns = ['*'])
 * @method ProjectAttribute find($id, $columns = ['*'])
 * @method ProjectAttribute first($columns = ['*'])
 */
class ProjectAttributeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'content',
        'amount',
        'attachment'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return ProjectAttribute::class;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function saveRecord($request)
    {
        $input = $request->all();
        $projectAttribute = $this->create($input);
        return $projectAttribute;
    }

    public function saveBudgetRecord($budget, $request)
    {

        $input = [];
        if ($request->type == Budget::HOUR) {
            $input['instance_type'] = 'Hour';
        } elseif ($request->type == Budget::FIXED) {
            $input['instance_type'] = 'Fixed';
        } else {
            $input['instance_type'] = 'NotSure';
        }
        $input['instance_id'] = $budget;
        $input['content'] = json_encode([
            'experience' => $request->experience,
            'stage'      => $request->stage,
            'time'       => $request->time,
        ]);
        $input['amount'] = $request->amount;
        $projectAttribute = $this->create($input);
        return $projectAttribute;
    }


    /**
     * @param $request
     * @param $projectAttribute
     * @return mixed
     */
    public function updateRecord($request, $projectAttribute)
    {
        $input = $request->all();
        $projectAttribute = $this->update($input, $projectAttribute->id);
        return $projectAttribute;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function deleteRecord($id)
    {
        $projectAttribute = $this->delete($id);
        return $projectAttribute;
    }
}
