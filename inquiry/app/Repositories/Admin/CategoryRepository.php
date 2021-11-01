<?php

namespace App\Repositories\Admin;

use App\Models\Category;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class CategoryRepository
 * @package App\Repositories\Admin
 * @version March 14, 2019, 11:19 am UTC
 *
 * @method Category findWithoutFail($id, $columns = ['*'])
 * @method Category find($id, $columns = ['*'])
 * @method Category first($columns = ['*'])
*/
class CategoryRepository extends BaseRepository
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
        return Category::class;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function saveRecord($request)
    {
        $input = $request->all();
        $category = $this->create($input);
        return $category;
    }

    /**
     * @param $request
     * @param $category
     * @return mixed
     */
    public function updateRecord($request, $category)
    {
        $input = $request->all();
        $category = $this->update($input, $category->id);
        return $category;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function deleteRecord($id)
    {
        $category = $this->delete($id);
        return $category;
    }
}
