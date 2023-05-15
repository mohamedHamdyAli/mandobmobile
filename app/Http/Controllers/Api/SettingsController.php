<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController as BaseController;
use App\Http\Requests\ComplaintsRequest;
use App\Models\Complaints;
use App\Models\About;
use App\Models\PrivacyPolicy;
use App\Models\TermsConditions;
use App\Http\Resources\AboutResource;

class SettingsController extends BaseController
{
    public function store_complaints(ComplaintsRequest $request) {
        $data = $request->all();
        Complaints::create($data);
        $message = __("auth.Data_Has_Been_Added") ;
        return $this->sendResponse($data,$message);
    }

    public function get_about() {
        $about = About::first();
        if($about) {
            $message = __("auth.Data_Has_Been_Added") ;
            return $this->sendResponse(AboutResource::make($about),$message);
        } else {
            $message = __("auth.No_Data_found") ;
            return $this->sendError($message, '');
        }
    }
    public function get_privacy() {
        $privacy = PrivacyPolicy::first();
        if($privacy) {
            $message = __("auth.Data_Has_Been_Added") ;
            return $this->sendResponse(AboutResource::make($privacy),$message);
        } else {
            $message = __("auth.No_Data_found") ;
            return $this->sendError($message, '');
        }
    }
    public function get_terms() {
        $terms = TermsConditions::first();
        if($terms) {
            $message = __("auth.Data_Has_Been_Added") ;
            return $this->sendResponse(AboutResource::make($terms),$message);
        } else {
            $message = __("auth.No_Data_found") ;
            return $this->sendError($message, '');
        }
    }
}
