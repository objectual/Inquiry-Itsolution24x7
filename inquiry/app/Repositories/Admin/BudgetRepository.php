<?php

namespace App\Repositories\Admin;

use App\Models\Budget;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class BudgetRepository
 * @package App\Repositories\Admin
 * @version March 13, 2019, 3:32 pm UTC
 *
 * @method Budget findWithoutFail($id, $columns = ['*'])
 * @method Budget find($id, $columns = ['*'])
 * @method Budget first($columns = ['*'])
 */
class BudgetRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'project_id',
        'type'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Budget::class;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function saveRecord($request)
    {
        //$input = $request->all();
        $budget = $this->create($request);
        return $budget;
    }

    public function saveAPiRecord($request)
    {
        $input = $request->only('project_id', 'type');
        $budget = $this->create($input);
        return $budget;
    }

    /**
     * @param $request
     * @param $budget
     * @return mixed
     */
    public function updateRecord($request, $budget)
    {
        //$input = $request->all();
        $budget = $this->update($request, $budget->id);
        return $budget;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function deleteRecord($id)
    {
        $budget = $this->delete($id);
        return $budget;
    }
}
