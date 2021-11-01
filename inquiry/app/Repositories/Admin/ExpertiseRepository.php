<?php

namespace App\Repositories\Admin;

use App\Models\Expertise;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ExpertiseRepository
 * @package App\Repositories\Admin
 * @version March 13, 2019, 3:31 pm UTC
 *
 * @method Expertise findWithoutFail($id, $columns = ['*'])
 * @method Expertise find($id, $columns = ['*'])
 * @method Expertise first($columns = ['*'])
*/
class ExpertiseRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Expertise::class;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function saveRecord($request)
    {
        $input = $request->all();
        $expertise = $this->create($input);
        return $expertise;
    }

    /**
     * @param $request
     * @param $expertise
     * @return mixed
     */
    public function updateRecord($request, $expertise)
    {
        $input = $request->all();
        $expertise = $this->update($input, $expertise->id);
        return $expertise;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function deleteRecord($id)
    {
        $expertise = $this->delete($id);
        return $expertise;
    }
}
