<?php

namespace App\Repositories\Admin;

use App\Models\Question;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class QuestionRepository
 * @package App\Repositories\Admin
 * @version March 13, 2019, 3:30 pm UTC
 *
 * @method Question findWithoutFail($id, $columns = ['*'])
 * @method Question find($id, $columns = ['*'])
 * @method Question first($columns = ['*'])
*/
class QuestionRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'project_id',
        'question',
        'profile'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Question::class;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function saveRecord($request)
    {
//        $input = $request->all();
        $question = $this->create($request);
        return $question;
    }

    /**
     * @param $request
     * @param $question
     * @return mixed
     */
    public function updateRecord($request, $question)
    {
        $input = $request->all();
        $question = $this->update($input, $question->id);
        return $question;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function deleteRecord($id)
    {
        $question = $this->delete($id);
        return $question;
    }
}
