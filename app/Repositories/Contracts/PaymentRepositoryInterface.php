<?php
/**
 * @file    PaymentRepositoryInterface.php
 * PaymentRepositoryInterface RepositoryInterface
 * @author  <Sandun Dissanayake> <sandunkdissanayake@gmail.com>
 *
 */

namespace App\Repositories\Contracts;

interface PaymentRepositoryInterface
{
    /**
     * @param $data
     * @return mixed
     */
    public function calculateUserOwn($data);

}
