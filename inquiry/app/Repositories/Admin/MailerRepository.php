<?php

namespace App\Repositories\Admin;

use App\Models\Mailer;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class MailerRepository
 * @package App\Repositories\Admin
 * @version August 1, 2019, 4:53 pm UTC
 *
 * @method Mailer findWithoutFail($id, $columns = ['*'])
 * @method Mailer find($id, $columns = ['*'])
 * @method Mailer first($columns = ['*'])
*/
class MailerRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'email',
        'type'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Mailer::class;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function saveRecord($request)
    {
        $input = $request->all();
        $mailer = $this->create($input);
        return $mailer;
    }

    /**
     * @param $request
     * @param $mailer
     * @return mixed
     */
    public function updateRecord($request, $mailer)
    {
        $input = $request->all();
        $mailer = $this->update($input, $mailer->id);
        return $mailer;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function deleteRecord($id)
    {
        $mailer = $this->delete($id);
        return $mailer;
    }
}
