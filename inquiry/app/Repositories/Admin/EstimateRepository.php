<?php

namespace App\Repositories\Admin;

use App\Models\Estimate;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class EstimateRepository
 * @package App\Repositories\Admin
 * @version July 10, 2019, 4:07 pm UTC
 *
 * @method Estimate findWithoutFail($id, $columns = ['*'])
 * @method Estimate find($id, $columns = ['*'])
 * @method Estimate first($columns = ['*'])
*/
class EstimateRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'customer_id',
        'currency_id',
        'date',
        'expiry',
        'subheading',
        'footer',
        'memo'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Estimate::class;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function saveRecord($request)
    {
        $input = $request->all();
        $estimate = $this->create($input);
        return $estimate;
    }

    /**
     * @param $request
     * @param $estimate
     * @return mixed
     */
    public function updateRecord($request, $estimate)
    {
        $input = $request->all();
        $estimate = $this->update($input, $estimate->id);
        return $estimate;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function deleteRecord($id)
    {
        $estimate = $this->delete($id);
        return $estimate;
    }
}
