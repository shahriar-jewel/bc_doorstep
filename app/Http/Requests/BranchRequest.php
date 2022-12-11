<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BranchRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'branchname'        => 'required',
            'contactno'         => 'max:20|required',
            'restaurant'        => 'required',
            'minorderamount'    => 'required|numeric',
            'mindeliverytime'   => 'required|numeric',
            'deliveryfee'       => 'required|numeric',
            'deliveryzone'      => 'required',
        ];
    }
}
