<?php
/**
 * @file    PaymentController.php
 * @author  <Sandun Dissanayake> <sandunkdissanayake@gmail.com>
 *
 */

namespace App\Http\Controllers;

use App\Libraries\Helper;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    //private variables
    private $helper;

    /**
     * @param Helper $helper
     */
    public function __construct(
        Helper $helper
    )
    {
        $this->helper = $helper;
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
     * Get calculated json object
     * @return view
     */
    public function postPayment(Request $request)
    {
        $paidData = $request->jsonArray;
        print_r($paidData);
        die();
        if (isset($paidData)) {

            $payments = [];
            $owes = [];
            if (isset($paidData['data']) && !empty($paidData['data'])) {

                $payments['days'] = count($paidData['data']);
                $payments['spentTotal'] = 0;
                $payments['spent'] = [];
                foreach ($paidData['data'] as $billData) {

                    $paidAmount = isset($payments['spent'][$billData['paid_by']]) ? $payments['spent'][$billData['paid_by']] : 0;
                    $payments['spent'][$billData['paid_by']] = $paidAmount + $billData['amount'];
                    $amount = isset($billData['amount']) ? $billData['amount'] : 0;
                    $payments['spentTotal'] = $payments['spentTotal'] + $amount;
                    $totalMembers = count($billData['friends']);
                    //paid to calculation
                    foreach ($billData['friends'] as $friend) {

                        if ($friend !== $billData['paid_by']) {

                            $billForPerson = $billData['amount'] / $totalMembers;
                            $ownAmount = isset($owes[$friend][$billData['paid_by']]) ? $owes[$friend][$billData['paid_by']] + $billForPerson : $billForPerson;
                            $owes[$friend][$billData['paid_by']] = $ownAmount;
                        }
                    }
                }
            }

            $owesUsers = [];
            foreach ($owes as $own => $oweData) {
                foreach ($oweData as $user => $crdtAmount) {

                    $ownAmount = isset($owes[$user][$own]) ? $owes[$user][$own] : 0;
                    $payToPrice = ($crdtAmount - $ownAmount) > 0 ? ($crdtAmount - $ownAmount) : 0;
                    $owesUsers[$own][$user] = $payToPrice;
                }
            }
            $payments['owes'] = $owesUsers;

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
    }

}
