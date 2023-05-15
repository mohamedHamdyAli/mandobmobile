<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\Driver;
use App\Models\Activity;

class DashboardController extends Controller
{
    public function Counter() {
        $users = User::count();
        $orders = Order::count();
        $activities = Activity::count();
        $drivers = Driver::count();
        $user_info = User::select('username','user_type', 'phone')->paginate(5);
        $orders_info = Order::select('user_id','status', 'address_from')->paginate(5);
        $activities_info = Activity::select('name_en')->paginate(5);
        return view('admin.dashboard', compact('users','orders','activities','user_info','orders_info','activities_info','drivers'));
    }
}
