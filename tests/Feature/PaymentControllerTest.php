<?php

namespace Tests\Feature;

use App\Http\Controllers\PaymentController;
use Tests\TestCase;

class PaymentControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(302);
    }

    public function test_post_payment()
    {
        $paymentController = new PaymentController();
    }

    private function _getJsonArray()
    {
        $jsonArray = [
            'data' => [
                'day' => 1,
                'amount' => 50,
                'paid_by' => 'tanu',
                'friends' => ['kasun', 'tanu']
                ,
                'day' => 2,
                'amount' => 100,
                'paid_by' => 'kasun',
                'friends' => ['kasun', 'tanu', 'liam']
                ,
                'day' => 3,
                'amount' => 100,
                'paid_by' => 'liam',
                'friends' => ['liam', 'tanu', 'liam']
            ]
        ];

        return $jsonArray;
    }
}
