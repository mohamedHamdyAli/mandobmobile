<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRequest extends FormRequest
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
                'username'          => 'required',
                'email'             => 'required|email|unique:users,email,'.$id,
                'phone'             => 'required|numeric|digits:8|unique:users,phone,'.$id,
                'profile_image'     => 'nullable|mimetypes:image/jpeg,image/png,image/jpg,image/gif',
        ];
    }
    public function messages()
    {
        return [
            'profile_image.*' => "Image should be png/PNG, gif/GIF, jpg/JPG & jpeg/JPG.",
            'email.required' => 'email is required',
            'email.email' => 'email is not valid format',
            'email.unique' => 'email already exsits',
            'phone.required' => 'phone is required',
            'phone.numeric' => 'phone must to be number',
            'phone.digits' => 'phone number must be 8 numbers',
            'phone.unique' => 'phone number already exsits',
            'username.required' => 'username is required',
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        if ( request()->is('api*')){
            $data = [
                'success' => false,
                'data' => '',
                'message' => $validator->errors()->first(),
                // 'all_message' =>  $validator->errors()
            ];

            throw new HttpResponseException(response()->json($data,422));
        }

        throw new HttpResponseException(redirect()->back()->withInput()->with('errors', $validator->errors()));
    }
}
