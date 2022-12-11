<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserinfostoreRequest extends FormRequest
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
        
        if ( $this->userType == 1 ) 
        {
            $rules = [
                'fullName'              => 'required|max:150',
                'mobileNo'              => 'max:20|required',
                'email'                 => 'email',
                'password'              => 'required|min:4',
                'password_confirmation' => 'min:4|same:password',
                'userType'              => 'required',
                'restaurant'            => 'required',
            ];
        }
        else if ( $this->userType == 2 || $this->userType == 3 || $this->userType == 4) 
        {
            $rules = [
                'fullName'              => 'required|max:150',
                'mobileNo'              => 'max:20|required',
                'email'                 => 'email',
                'password'              => 'required|min:4',
                'password_confirmation' => 'min:4|same:password',
                'userType'              => 'required',
                'restaurant'            => 'required',
                'kitchen'                => 'required',
            ];
        }
        else
        {
            $rules = [
                'fullName'              => 'required|max:150',
                'mobileNo'              => 'max:20|required',
                'email'                 => 'email',
                'password'              => 'required|min:4',
                'password_confirmation' => 'min:4|same:password',
                'userType'              => 'required',
            ];
        }

        return $rules;
    }
}
