<?php

namespace App\Repositories\Admin;

use App\Models\Customer;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class CustomerRepository
 * @package App\Repositories\Admin
 * @version June 26, 2019, 10:32 am UTC
 *
 * @method Customer findWithoutFail($id, $columns = ['*'])
 * @method Customer find($id, $columns = ['*'])
 * @method Customer first($columns = ['*'])
 */
class CustomerRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id',
        'name',
        'email'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Customer::class;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function saveRecord($request)
    {
        $input = [];
        $input = $request->only(['name', 'email', 'password']);
        $input['password'] = bcrypt(rand(0000, 9999));
        $customer = $this->create($input);
        return $customer;
    }

    /**
     * @param $request
     * @param $customer
     * @return mixed
     */
    public function updateRecord($request, $customer)
    {
        $input = $request->all();
        $customer = $this->update($input, $customer->id);
        return $customer;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function deleteRecord($id)
    {
        $customer = $this->delete($id);
        return $customer;
    }
}
