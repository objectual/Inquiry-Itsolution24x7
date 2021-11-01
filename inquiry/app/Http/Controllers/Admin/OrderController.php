<?php

namespace App\Http\Controllers\Admin;

use App\Criteria\UserCriteria;
use App\Helper\BreadcrumbsRegister;
use App\DataTables\Admin\OrderDataTable;
use App\Http\Requests\Admin;
use App\Http\Requests\Admin\CreateOrderRequest;
use App\Http\Requests\Admin\UpdateOrderRequest;
use App\Models\User;
use App\Repositories\Admin\OrderRepository;
use App\Http\Controllers\AppBaseController;
use App\Repositories\Admin\UserRepository;
use http\Env\Request;
use Laracasts\Flash\Flash;
use Illuminate\Http\Response;
use CoinbaseCommerce\ApiClient;
use CoinbaseCommerce\Resources\Checkout;


class OrderController extends AppBaseController
{
    /** ModelName */
    private $ModelName;

    /** BreadCrumbName */
    private $BreadCrumbName;

    /** @var  OrderRepository */
    private $orderRepository;
    private $userRepository;

    public function __construct(OrderRepository $orderRepo, UserRepository $userRepository)
    {
        $this->orderRepository = $orderRepo;
        $this->userRepository = $userRepository;
        $this->ModelName = 'orders';
        $this->BreadCrumbName = 'Orders';
    }

    /**
     * Display a listing of the Order.
     *
     * @param OrderDataTable $orderDataTable
     * @return Response
     */
    public function index(OrderDataTable $orderDataTable)
    {
        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName);
        return $orderDataTable->render('admin.orders.index', ['title' => $this->BreadCrumbName]);
    }

    /**
     * Show the form for creating a new Order.
     *
     * @return Response
     */
    public function create()
    {

        $customer = $this->userRepository
            ->resetCriteria()
            ->pushCriteria(new UserCriteria(['role' => User::CUSTOMER]))
            ->pluck('name', 'id');
        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName);
        return view('admin.orders.create')->with([
            'title'    => $this->BreadCrumbName,
            'customer' => $customer,
        ]);
    }

    /**
     * Store a newly created Order in storage.
     *
     * @param CreateOrderRequest $request
     *
     * @return Response
     */
    public function store(CreateOrderRequest $request)
    {
        $order = $this->orderRepository->saveRecord($request);

        Flash::success($this->BreadCrumbName . ' saved successfully.');
        if (isset($request->continue)) {
            $redirect_to = redirect(route('admin.orders.create'));
        } elseif (isset($request->translation)) {
            $redirect_to = redirect(route('admin.orders.edit', $order->id));
        } else {
            $redirect_to = redirect(route('admin.orders.index'));
        }
        return $redirect_to->with([
            'title' => $this->BreadCrumbName
        ]);
    }

    /**
     * Display the specified Order.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $order = $this->orderRepository->findWithoutFail($id);

        if (empty($order)) {
            Flash::error($this->BreadCrumbName . ' not found');
            return redirect(route('admin.orders.index'));
        }

        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName, $order);
        return view('admin.orders.show')->with(['order' => $order, 'title' => $this->BreadCrumbName]);
    }

    /**
     * Show the form for editing the specified Order.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $order = $this->orderRepository->findWithoutFail($id);

        if (empty($order)) {
            Flash::error($this->BreadCrumbName . ' not found');
            return redirect(route('admin.orders.index'));
        }
        $customer = $this->userRepository
            ->resetCriteria()
            ->pushCriteria(new UserCriteria(['role' => User::CUSTOMER]))
            ->pluck('name', 'id');
        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName, $order);
        return view('admin.orders.edit')->with([
            'order'    => $order,
            'customer' => $customer,
            'title'    => $this->BreadCrumbName]);
    }

    /**
     * Update the specified Order in storage.
     *
     * @param  int $id
     * @param UpdateOrderRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateOrderRequest $request)
    {
        $order = $this->orderRepository->findWithoutFail($id);

        if (empty($order)) {
            Flash::error($this->BreadCrumbName . ' not found');
            return redirect(route('admin.orders.index'));
        }

        $order = $this->orderRepository->updateRecord($request, $order);

        Flash::success($this->BreadCrumbName . ' updated successfully.');
        if (isset($request->continue)) {
            $redirect_to = redirect(route('admin.orders.create'));
        } else {
            $redirect_to = redirect(route('admin.orders.index'));
        }
        return $redirect_to->with(['title' => $this->BreadCrumbName]);
    }

    /**
     * Remove the specified Order from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $order = $this->orderRepository->findWithoutFail($id);

        if (empty($order)) {
            Flash::error($this->BreadCrumbName . ' not found');
            return redirect(route('admin.orders.index'));
        }

        $this->orderRepository->deleteRecord($id);

        Flash::success($this->BreadCrumbName . ' deleted successfully.');
        return redirect(route('admin.orders.index'))->with(['title' => $this->BreadCrumbName]);
    }

    public function invoice($id)
    {
        $order = $this->orderRepository->findWithoutFail($id);
        $user = $this->userRepository->findWithoutFail($order->user_id);
//        $curl = curl_init();
//        curl_setopt_array($curl, array(
//            CURLOPT_URL => 'https://api.escrow-sandbox.com/2017-09-01/transaction',
//            CURLOPT_RETURNTRANSFER => 1,
//            CURLOPT_USERPWD => 'arsalan@masology.com:Arsalan1@345',
//            CURLOPT_HTTPHEADER => array(
//                'Content-Type: application/json'
//            ),
//            CURLOPT_POSTFIELDS => json_encode(
//                array(
//                    'currency' => 'usd',
//                    'items' => array(
//                        array(
//                            'description' => 'johnwick.com',
//                            'schedule' => array(
//                                array(
//                                    'payer_customer' => 'farhad@masology.net',
//                                    'amount' => '1000.0',
//                                    'beneficiary_customer' => 'me',
//                                ),
//                            ),
//                            'title' => 'johnwick.com',
//                            'inspection_period' => '259200',
//                            'type' => 'domain_name',
//                            'quantity' => '1',
//                        ),
//                    ),
//                    'description' => 'The sale of johnwick.com',
//                    'parties' => array(
//                        array(
//                            'customer' => 'farhad@masology.net',
//                            'role' => 'buyer',
//                        ),
//                        array(
//                            'customer' => 'me',
//                            'role' => 'seller',
//                        ),
//                    ),
//                )
//            )
//        ));
//
//        $output = curl_exec($curl);
//        echo $output;
//        curl_close($curl);

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL            => 'https://api.escrow-sandbox.com/2017-09-01/transaction',
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_USERPWD        => 'arsalan@masology.com:Arsalan1@345',
            CURLOPT_HTTPHEADER     => array(
                'Content-Type: application/json'
            ),
            CURLOPT_POSTFIELDS     => json_encode(
                array(
                    'currency'    => 'usd',
                    'items'       => array(
                        array(
                            'description'       => 'Reading the script',
                            'schedule'          => array(
                                array(
                                    'payer_customer'       => 'farhad@masology.net',
                                    'amount'               => '10000.0',
                                    'beneficiary_customer' => 'me',
                                ),
                            ),
                            'title'             => 'Script',
                            'inspection_period' => '259200',
                            'type'              => 'milestone',
                            'quantity'          => '1',
                        ),
                        array(
                            'description'       => 'Doing the story boards',
                            'schedule'          => array(
                                array(
                                    'payer_customer'       => 'farhad@masology.net',
                                    'amount'               => '1000.0',
                                    'beneficiary_customer' => 'me',
                                ),
                            ),
                            'title'             => 'Story boards',
                            'inspection_period' => '259200',
                            'type'              => 'milestone',
                            'quantity'          => '1',
                        ),
                        array(
                            'description'       => 'Acting for car crash scene 1',
                            'schedule'          => array(
                                array(
                                    'payer_customer'       => 'farhad@masology.net',
                                    'amount'               => '200000.0',
                                    'beneficiary_customer' => 'me',
                                ),
                            ),
                            'title'             => 'Acting 1',
                            'inspection_period' => '259200',
                            'type'              => 'milestone',
                            'quantity'          => '1',
                        ),
                        array(
                            'description'       => 'Acting for helicopter jump scene 2',
                            'schedule'          => array(
                                array(
                                    'payer_customer'       => 'farhad@masology.net',
                                    'amount'               => '50000.0',
                                    'beneficiary_customer' => 'me',
                                ),
                            ),
                            'title'             => 'Acting 2',
                            'inspection_period' => '259200',
                            'type'              => 'milestone',
                            'quantity'          => '1',
                        ),
                    ),
                    'description' => 'John Wick 3',
                    'parties'     => array(
                        array(
                            'customer' => 'farhad@masology.net',
                            'role'     => 'buyer',
                        ),
                        array(
                            'customer' => 'me',
                            'role'     => 'seller',
                        ),
                    ),
                )
            )
        ));

        $output = curl_exec($curl);
        echo $output;
        curl_close($curl);

    }

    public function coinbase($id)
    {
        $order = $this->orderRepository->findWithoutFail($id);
        ApiClient::init("5e860d12-1534-4a5f-9c45-58daef27f835");
        $checkoutObj = new Checkout([
            "description"    => $order->description,
            "local_price"    => [
                "amount"   => $order->amount,
                "currency" => "USD"
            ],
            "name"           => $order->name,
            "pricing_type"   => "fixed_price",
            "requested_info" => ["email"]
        ]);
        try {
            $checkoutObj->save();
            return redirect('https://commerce.coinbase.com/checkout/' . $checkoutObj->id);
        } catch (\Exception $exception) {
            echo sprintf("Enable to create checkout. Error: %s \n", $exception->getMessage());
        }
        if ($checkoutObj->id) {
            $checkoutObj->name = "New name";
            // Update "name"
            try {
                $checkoutObj->save();
                echo sprintf("Successfully updated name of checkout via save method\n");
            } catch (\Exception $exception) {
                echo sprintf("Enable to update name of checkout. Error: %s \n", $exception->getMessage());
            }
            // Update "name" by "id"
            try {
                Checkout::updateById(
                    $checkoutObj->id,
                    [
                        "name" => "Another Name"
                    ]
                );
                echo sprintf("Successfully updated name of checkout by id\n");
            } catch (\Exception $exception) {
                echo sprintf("Enable to update name of checkout by id. Error: %s \n", $exception->getMessage());
            }
            $checkoutObj->description = "New description";
            // Refresh attributes to previous values
            try {
                $checkoutObj->refresh();
                echo sprintf("Successfully refreshed checkout\n");
            } catch (\Exception $exception) {
                echo sprintf("Enable to refresh checkout. Error: %s \n", $exception->getMessage());
            }
            // Retrieve checkout by "id"
            try {
                $retrievedCheckout = Checkout::retrieve($checkoutObj->id);
                echo sprintf("Successfully retrieved checkout\n");
                echo $retrievedCheckout;
            } catch (\Exception $exception) {
                echo sprintf("Enable to retrieve checkout. Error: %s \n", $exception->getMessage());
            }
        }
        try {
            $list = Checkout::getList(["limit" => 5]);
            echo sprintf("Successfully got list of checkouts\n");
            if (count($list)) {
                echo sprintf("Checkouts in list:\n");
                foreach ($list as $checkout) {
                    echo $checkout;
                }
            }
            echo sprintf("List's pagination:\n");
            print_r($list->getPagination());
            echo sprintf("Number of all checkouts - %s \n", $list->countAll());
        } catch (\Exception $exception) {
            echo sprintf("Enable to get list of checkouts. Error: %s \n", $exception->getMessage());
        }
        if (isset($list) && $list->hasNext()) {
            // Load next page with previous settings (limit=5)
            try {
                $list->loadNext();
                echo sprintf("Next page of checkouts: \n");
                foreach ($list as $checkout) {
                    echo $checkout;
                }
            } catch (\Exception $exception) {
                echo sprintf("Enable to get new page of checkouts. Error: %s \n", $exception->getMessage());
            }
        }
        try {
            $allCharge = Checkout::getAll();
            echo sprintf("Successfully got all checkouts:\n");
            foreach ($allCharge as $charge) {
                echo $charge;
            }
        } catch (\Exception $exception) {
            echo sprintf("Enable to get all checkouts. Error: %s \n", $exception->getMessage());
        }
    }



}
