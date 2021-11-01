<?php

namespace App\Repositories\Admin;

use App\Models\EstimateDetail;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class EstimateDetailRepository
 * @package App\Repositories\Admin
 * @version July 10, 2019, 4:08 pm UTC
 *
 * @method EstimateDetail findWithoutFail($id, $columns = ['*'])
 * @method EstimateDetail find($id, $columns = ['*'])
 * @method EstimateDetail first($columns = ['*'])
*/
class EstimateDetailRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'estimate_id',
        'project_id',
        'description',
        'quantity',
        'price',
        'tax'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return EstimateDetail::class;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function saveRecord($request)
    {
        $input = $request->all();
        $estimateDetail = $this->create($input);
        return $estimateDetail;
    }

    /**
     * @param $request
     * @param $estimateDetail
     * @return mixed
     */
    public function updateRecord($request, $estimateDetail)
    {
        $input = $request->all();
        $estimateDetail = $this->update($input, $estimateDetail->id);
        return $estimateDetail;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function deleteRecord($id)
    {
        $estimateDetail = $this->delete($id);
        return $estimateDetail;
    }
}
