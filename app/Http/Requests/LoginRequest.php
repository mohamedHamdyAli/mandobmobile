<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use Illuminate\Http\Exceptions\HttpResponseException;
class LoginRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        $id = request()->id;

        return [

            'phone' => 'required|numeric|digits:8'.$id,
        ];
    }

    public function messages()
    {
        return [
            'phone.required' => 'phone is required',
            'phone.numeric' => 'phone must to be number',
            'phone.digits' => 'phone number must be 8 numbers',
        ];
    }


    protected function failedValidation(Validator $validator)
    {
        if ( request()->is('api*')){
            $data = [
                'success' => false,
                'data' => '',
                'message' => $validator->errors()->first(),
            ];

            throw new HttpResponseException(response()->json($data,422));
        }

        throw new HttpResponseException(redirect()->back()->withInput()->with('errors', $validator->errors()));
    }
}
