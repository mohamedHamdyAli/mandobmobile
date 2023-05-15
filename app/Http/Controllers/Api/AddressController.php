<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddressRequest;
use Illuminate\Http\Request;
use App\Models\Address;
use App\Http\Resources\AddressResource;
use App\Http\Controllers\Api\BaseController as BaseController;

class AddressController extends BaseController
{
    public function get_address()
    {
        $user = auth()->user()->id;
        $address = Address::where('user_id','=',$user)->orderBy('id', 'desc')->paginate(10);
        if($address){
            $message = __("auth.User_Address") ;
            return $this->sendResponse(AddressResource::collection($address), $message);
        } else {
            $message = __("auth.These_credentials_do_not_match_our_records") ;
            return $this->sendError($message, '');
        }
    }

    public function address_store(AddressRequest $request) {
        $data = $request->all();
        $data['user_id'] = auth()->user()->id;
        $address = Address::create($data);
        $message = __("auth.Data_Has_Been_Added") ;
        return $this->sendResponse(new AddressResource($address), $message);
    }

    public function address_show($id) {
        $user = auth()->user()->id;
        $model = Address::findOrFail($id);
        $address = Address::where('user_id','=',$user)->where('id','=',$model->id)->first();
        if(is_null($address)) {
            $message = __("auth.These_credentials_do_not_match_our_records") ;
            return $this->sendError($message, '');
        } else {
            $message = __("auth.Address_details") ;
            return $this->sendResponse(new AddressResource($address), $message);
        }
    }

    public function address_update(Request $request, $id) {
        $data = $request->all();
        $address = Address::findOrFail($id);
        $address->fill($data)->update();
        $message = __("auth.Address_Update") ;
        return $this->sendResponse(new AddressResource($address), $message);
    }
    public function address_destroy($id) {
        $address = Address::findOrFail($id);
        if($address){
            $address->delete();
            $message = __("auth.Address_Deleted_Successfully") ;
            return $this->sendResponse('', $message);
        } else {
            $message = __("auth.These_credentials_do_not_match_our_records") ;
            return $this->sendError($message, '');
        }
    }

}
