<?php

namespace App\Repositories\Admin;

use App\Models\Order;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class OrderRepository
 * @package App\Repositories\Admin
 * @version June 26, 2019, 10:02 am UTC
 *
 * @method Order findWithoutFail($id, $columns = ['*'])
 * @method Order find($id, $columns = ['*'])
 * @method Order first($columns = ['*'])
*/
class OrderRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'name',
        'amount',
        'discount'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Order::class;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function saveRecord($request)
    {
        $input = $request->all();
        $order = $this->create($input);
        return $order;
    }

    /**
     * @param $request
     * @param $order
     * @return mixed
     */
    public function updateRecord($request, $order)
    {
        $input = $request->all();
        $order = $this->update($input, $order->id);
        return $order;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function deleteRecord($id)
    {
        $order = $this->delete($id);
        return $order;
    }

    public function invoiceGenerator(){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.escrow-sandbox.com/2017-09-01/transaction',
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_USERPWD => 'arsalan@masology.com:Arsalan1@345',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
            CURLOPT_POSTFIELDS => json_encode(
                array(
                    'currency' => 'usd',
                    'items' => array(
                        array(
                            'description' => 'johnwick.com',
                            'schedule' => array(
                                array(
                                    'payer_customer' => 'me',
                                    'amount' => '1010.0',
                                    'beneficiary_customer' => 'keanu.reaves@escrow.com',
                                ),
                            ),
                            'title' => 'johnwick.com',
                            'inspection_period' => '259200',
                            'type' => 'domain_name',
                            'quantity' => '1',
                        ),
                    ),
                    'description' => 'The sale of johnwick.com',
                    'parties' => array(
                        array(
                            'customer' => 'me',
                            'role' => 'buyer',
                        ),
                        array(
                            'customer' => 'keanu.reaves@escrow.com',
                            'role' => 'buyer',
                        ),
                    ),
                )
            )
        ));

        $output = curl_exec($curl);
        echo $output;
        curl_close($curl);
    }
}
