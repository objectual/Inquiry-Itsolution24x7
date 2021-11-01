<?php

namespace App\Repositories\Admin;

use App\Models\Description;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class DescriptionRepository
 * @package App\Repositories\Admin
 * @version March 13, 2019, 3:26 pm UTC
 *
 * @method Description findWithoutFail($id, $columns = ['*'])
 * @method Description find($id, $columns = ['*'])
 * @method Description first($columns = ['*'])
 */
class DescriptionRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'project_id',
        'details',
        'attachment'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Description::class;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function saveRecord($input)
    {
//        $input = $request->all();
        $description = $this->create($input);
        return $description;
    }

    /**
     * @param $request
     * @param $description
     * @return mixed
     */
    public function updateRecord($request, $description)
    {
        // $input = $request->all();
        $description = $this->update($request, $description->id);
        return $description;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function deleteRecord($id)
    {
        $description = $this->delete($id);
        return $description;
    }
}
