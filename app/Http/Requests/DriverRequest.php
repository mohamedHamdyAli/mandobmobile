<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use Illuminate\Http\Exceptions\HttpResponseException;

class DriverRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function rules()
    {
        $id = request()->id;

        return [
                'username'               => 'required',
                'vehicle_brand_id'          => 'required',
                'vehicle_model_id'          => 'required',
                'vehicle_year'           => 'required',
                'vehicle_color_id'          => 'required',
                'vehicle_plate_number'   => 'required',
                'veichle_type_id'        => 'required',
                'email'                  => 'required|email|unique:drivers,email,'.$id,
                'phone'                  => 'required|numeric|digits:8|unique:drivers,phone,'.$id,
                'profile_image'     => 'nullable|mimetypes:image/jpeg,image/png,image/jpg,image/gif',
                'driver_licnse'     => 'nullable|mimetypes:image/jpeg,image/png,image/jpg,image/gif',
                'registration_sicker' => 'nullable|mimetypes:image/jpeg,image/png,image/jpg,image/gif',
                'vehicle_insurance' => 'nullable|mimetypes:image/jpeg,image/png,image/jpg,image/gif',
        ];
    }
    public function messages()
    {
        return [
            'profile_image.*' => "profile image should be png/PNG, gif/GIF, jpg/JPG & jpeg/JPG.",
            'driver_licnse.*' => "driver licnse should be png/PNG, gif/GIF, jpg/JPG & jpeg/JPG.",
            'driver_licnse.*' => "driver licnse should be png/PNG, gif/GIF, jpg/JPG & jpeg/JPG.",
            'registration_sicker.*' => "registration sicker should be png/PNG, gif/GIF, jpg/JPG & jpeg/JPG.",
            'vehicle_insurance.*' => "vehicle insurance should be png/PNG, gif/GIF, jpg/JPG & jpeg/JPG.",
            'email.required' => 'email is required',
            'email.email' => 'email is not valid format',
            'email.unique' => 'email already exsits',
            'phone.required' => 'phone is required',
            'phone.numeric' => 'phone must to be number',
            'phone.digits' => 'phone number must be 8 numbers',
            'phone.unique' => 'phone number already exsits',
            'username.required' => 'username is required',
            'vehicle_brand.required' => 'vehicle brand is required',
            'vehicle_brand_id.required' => 'vehicle brand is required',
            'vehicle_model_id.required' => 'vehicle model is required',
            'vehicle_year.required' => 'vehicle year is required',
            'vehicle_color_id.required' => 'vehicle color is required',
            'vehicle_plate_number.required' => 'vehicle plate number is required',
            'veichle_type_id.required' => 'veichle type is required',
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
