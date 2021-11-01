<?php

namespace App\Repositories\Admin;

use App\Models\Receiver;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ReceiverRepository
 * @package App\Repositories\Admin
 * @version August 1, 2019, 4:56 pm UTC
 *
 * @method Receiver findWithoutFail($id, $columns = ['*'])
 * @method Receiver find($id, $columns = ['*'])
 * @method Receiver first($columns = ['*'])
*/
class ReceiverRepository extends BaseRepository
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
        return Receiver::class;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function saveRecord($request)
    {
        $input = $request->all();
        $receiver = $this->create($input);
        return $receiver;
    }

    /**
     * @param $request
     * @param $receiver
     * @return mixed
     */
    public function updateRecord($request, $receiver)
    {
        $input = $request->all();
        $receiver = $this->update($input, $receiver->id);
        return $receiver;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function deleteRecord($id)
    {
        $receiver = $this->delete($id);
        return $receiver;
    }
}
