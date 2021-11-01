<?php

namespace App\Repositories\Admin;

use App\Models\Project;
use App\Models\User;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ProjectRepository
 * @package App\Repositories\Admin
 * @version March 13, 2019, 3:25 pm UTC
 *
 * @method Project findWithoutFail($id, $columns = ['*'])
 * @method Project find($id, $columns = ['*'])
 * @method Project first($columns = ['*'])
 */
class ProjectRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'category_id',
        'name'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Project::class;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function saveRecord($request)
    {
        $input = $request->only('user_id', 'category_id', 'name');
        $project = $this->create($input);
        return $project;
    }

    /**
     * @param $request
     * @param $project
     * @return mixed
     */
    public function updateRecord($request, $project)
    {
       //$input = $request->all();
	$input = $request;
        $project = $this->update($input, $project);
	//$project = $this->update($input, $project->id);
        return $project;
    }

    public function updateApiRecord($request, $project)
    {
        $input = $request->only(['user_id','name','category_id']);
        $project = $this->update($input, $project);
        return $project;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function deleteRecord($id)
    {
        $project = $this->delete($id);
        return $project;
    }

    public function verifyProject($id)
    {
        $project = $this->model->where(['id' => $id, 'status' => 0]);
        return $project->count();
    }

    public function verifyUser($id)
    {
        $project = $this->model->where(['id' => $id, 'status' => 0])->first();
        $user = User::where('id', $project->user_id)->first();
        return $user->email;
    }

}
