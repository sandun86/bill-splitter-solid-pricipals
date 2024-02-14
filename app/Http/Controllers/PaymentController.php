<?php
/**
 * @file    PaymentController.php
 * @author  <Sandun Dissanayake> <sandunkdissanayake@gmail.com>
 *
 */

namespace App\Http\Controllers;

use App\Libraries\Helper;
use App\Repositories\PaymentRepository;
use App\Http\Requests\BillCalculateRequest;

class PaymentController extends Controller
{
    //private variables
    protected $helper;
    protected $paymentRepository;

    /**
     * PaymentController constructor.
     * @param Helper $helper
     * @param PaymentRepository $paymentRepository
     */
    public function __construct(
        Helper $helper,
        PaymentRepository $paymentRepository
    )
    {
        $this->helper = $helper;
        $this->paymentRepository = $paymentRepository;
    }

    /**
     * Get payment
     * @return view
     */
    public function index()
    {

        return view('payment.payment')->with('title', 'Payment Splitter');
    }

    /**
     * Create posts view
     * @return view
     */
    public function getPayment()
    {

        return view('payment.payment-create')->with('title', 'Payment Calculate');
    }

    /**
     * @param BillCalculateRequest $request
     * @return Helper
     */
    public function postPayment(BillCalculateRequest $request)
    {
        try {

            $paidData = $request->jsonArray;
            if (isset($paidData)) {

                $payments = $this->paymentRepository->calculateUserOwn($paidData);

                return $this->helper
                    ->response(200, [
                        'message' => 'You have converted the json data successfully.!',
                        'data' => $payments
                    ]);
            } else {

                return $this->helper
                    ->response(
                        400,
                        ['message' => 'Something went wrong, Please try again later.']
                    );
            }
        } catch (Exception $e) {

            return $this->helper
                ->response(
                    500,
                    ['message' => 'Something went wrong, Please try again later.']
                );
        }
    }

}
