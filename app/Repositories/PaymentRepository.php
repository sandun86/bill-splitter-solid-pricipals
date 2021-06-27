<?php
/**
 * @file    PaymentRepository.php
 * @author  <Sandun Dissanayake> <sandunkdissanayake@gmail.com>
 *
 */
namespace App\Repositories;

use App\Repositories\Contracts\PaymentRepositoryInterface;

class PaymentRepository implements PaymentRepositoryInterface
{
    /**
     * @param $paidData
     * @return array
     */
    public function calculateUserOwn($paidData)
    {
        $payments = [];
        $owes = [];
        if (isset($paidData['data']) && !empty($paidData['data'])) {

            $payments['days'] = 0;
            $payments['spentTotal'] = 0;
            $payments['spent'] = [];
            if (is_array($paidData['data'])) {

                foreach ($paidData['data'] as $billData) {

                    $payments['days'] = isset($payments['spent'][$billData['day']]) ? $payments['days'] + 1 : $payments['days'];
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
        }

        $owesUsers = [];

        //calculate owe amount for each user
        foreach ($owes as $own => $oweData) {
            foreach ($oweData as $user => $crdtAmount) {

                $ownAmount = isset($owes[$user][$own]) ? $owes[$user][$own] : 0;
                $payToPrice = ($crdtAmount - $ownAmount) > 0 ? ($crdtAmount - $ownAmount) : 0;
                $owesUsers[$own][$user] = $payToPrice;
            }
        }
        $payments['owes'] = $owesUsers;

        return $payments;
    }
}
