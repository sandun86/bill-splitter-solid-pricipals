<?php
/**
 * @file    Helper.php
 * Helper Helper
 * @author  Sandun Dissanayake <sandunkdissanayake@gmail.com>
 *
 */

namespace App\Libraries;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;

class Helper
{
    public function __construct()
    {
    }

    /**
     * Get response
     *
     * @param $status
     * @param $message
     * @return $this
     */
    public function response($status, $message)
    {
        return (new Response($message, $status))
            ->header('Content-Type', 'application/json');
    }
}
