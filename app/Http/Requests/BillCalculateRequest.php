<?php
/**
 * @file    BillCalculateRequest.php
 * @author  <Sandun Dissanayake> <sandunkdissanayake@gmail.com>
 *
 */
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class BillCalculateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     * @return array
     */
    public function rules()
    {
        return [
            'jsonArray' => 'required',
        ];
    }
}
