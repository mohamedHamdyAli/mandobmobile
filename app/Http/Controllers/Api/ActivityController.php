<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\Activity;
use App\Models\Veichle;
use App\Models\Zone;
use App\Http\Resources\ActivityResource;
use App\Http\Resources\VeichleResource;
use App\Http\Resources\ZoneResource;

class ActivityController extends BaseController
{
    public function get_activity() {
        $activities = Activity::orderBy('id', 'desc')->get();
        $message = __("auth.All_Activities") ;
        return $this->sendResponse(ActivityResource::collection($activities), $message);
    }

    public function get_veichle() {
        $veichles = Veichle::orderBy('id', 'desc')->get();
        $message = __("auth.All_Veichles") ;
        return $this->sendResponse(VeichleResource::collection($veichles), $message);
    }

    public function get_zone() {
        $zones = Zone::orderBy('id', 'desc')->get();
        $message = __("auth.All_Zone") ;
        return $this->sendResponse(ZoneResource::collection($zones), $message);
    }
}
