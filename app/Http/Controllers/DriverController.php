<?php

namespace App\Http\Controllers;
use App\Models\Driver;
use App\Models\Zone;
use App\Models\VehicleColor;
use App\Models\VehicleModel;
use App\Models\VehicleBrand;
use App\Models\Veichle;
use App\Models\DriverWallet;
use App\Models\DriverRate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class DriverController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Driver::select('id','username','email','phone')->where('user_type','=','driver')->get();
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '
                    <div class="dropdown">
                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                      <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a class = "dropdown-item" href="'.route('drivers.edit', ['id'=> $row->id]).'" ><i class="bx bx-edit-alt me-1"></i>Edit</a>
                        <a class = "dropdown-item" href="'.route('drivers.show', ['id'=> $row->id]).'" ><i class="bx bx-show-alt me-1"></i>Show</a>
                        <a class = "dropdown-item" href="'.route('drivers.wallet', ['id'=> $row->id]).'" ><i class="bx bx-wallet-alt me-1"></i>Wallet</a>
                        <form method="POST" data--submit="user'.$row->id.'" action="'.route('drivers.destroy', ['id'=> $row->id]).'">
                        <input name="_method" type="hidden" value="DELETE">
                        <input name="_token" type="hidden" value="'.csrf_token().'">
                        <button class="dropdown-item"><i class="bx bx-trash me-1"></i>Delete </button>
                        </form>
                    </div>
                  </div>
                    ';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.drivers.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $id = $request->id;
        $driverdata = Driver::find($id);
        $zones = Zone::all();
        $vehicle_colors = VehicleColor::all();
        $vehicle_model = VehicleModel::all();
        $vehicle_brands = VehicleBrand::all();
        $veichles = Veichle::all();
        $pageTitle = 'Update driver';

        if($driverdata == null){
            $pageTitle = 'Add New driver';
            $driverdata = new Driver;
        }

        return view('admin.drivers.create', compact('pageTitle' ,'driverdata', 'zones','vehicle_colors','vehicle_model','vehicle_brands','veichles' ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $request->validate([
            'email' => 'required|email|max:255',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/',
        ],[
            'email.required' => 'email is required',
            'email.email' => 'email is not valid format',
            'phone.required' => 'phone is required',
            'phone.regex' => 'phone must to be number',
        ]);
        $data = $request->all();
        $id = $data['id'];
        $data['user_type'] = 'driver';
        if($id == null){
            $data['password'] = Hash::make($data['password']);
            $driver = Driver::create($data);
            if($request->hasFile('profile_image') && $request->file('profile_image')->isValid()){
                $driver->addMediaFromRequest('profile_image')->toMediaCollection('profile_image');
            }
            if($request->hasFile('driver_licnse') && $request->file('driver_licnse')->isValid()){
                $driver->addMediaFromRequest('driver_licnse')->toMediaCollection('driver_licnse');
            }
            if($request->hasFile('registration_sicker') && $request->file('registration_sicker')->isValid()){
                $driver->addMediaFromRequest('registration_sicker')->toMediaCollection('registration_sicker');
            }
            if($request->hasFile('vehicle_insurance') && $request->file('vehicle_insurance')->isValid()){
                $driver->addMediaFromRequest('vehicle_insurance')->toMediaCollection('vehicle_insurance');
            }
        } else {
            $driver = Driver::findOrFail($id);
            $driver->fill($data)->update();
            if(isset($request->profile_image) && $request->profile_image != null ) {
                $driver->clearMediaCollection('profile_image');
                $driver->addMediaFromRequest('profile_image')->toMediaCollection('profile_image');
            }
            if(isset($request->driver_licnse) && $request->driver_licnse != null){
                $driver->clearMediaCollection('driver_licnse');
                $driver->addMediaFromRequest('driver_licnse')->toMediaCollection('driver_licnse');
            }
            if(isset($request->registration_sicker) && $request->registration_sicker != null){
                $driver->clearMediaCollection('registration_sicker');
                $driver->addMediaFromRequest('registration_sicker')->toMediaCollection('registration_sicker');
            }
            if(isset($request->vehicle_insurance) && $request->vehicle_insurance != null){
                $driver->clearMediaCollection('vehicle_insurance');
                $driver->addMediaFromRequest('vehicle_insurance')->toMediaCollection('vehicle_insurance');
            }
        }
        $message = 'updated done';
        if($driver->wasRecentlyCreated){
            $message = 'created done';
        }
        return redirect('admin/drivers')->withSuccess($message);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $driver = Driver::find($id);
        $rate = DriverRate::where('driver_id', $id)->where('user_type', 'user')->get();
            $order_count = $rate->count();
            $driver_rate = $rate->sum('rate');
            if($order_count != 0)
                $final_rate = $driver_rate / $order_count;
            else
                $final_rate = 0;
        if(empty($driver))
        {
            $msg = 'driver not found';
            return redirect(route('driver.index'))->withError($msg);
        }
        return view('admin.drivers.show', compact('driver','final_rate'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $driver = Driver::find($id);
        $msg ='Error something went wrong please try again';

        if($driver != '') {
            $driver->delete();
            $msg ='Driver has been deleted';
        }

        return redirect()->back()->withSuccess($msg);
    }

    public function show_wallet($id) {
        $driver = Driver::find($id);
        $driver_wallet = DriverWallet::where('driver_id',$driver->id)->get();
        $key_amount = collect($driver_wallet)->sum('wallet_cost');
        if(empty($driver))
        {
            $msg = 'driver not found';
            return redirect(route('driver.index'))->withError($msg);
        }
        return view('admin.drivers.wallet', compact('driver','key_amount'));
    }

    public function update_wallet($id) {
        $driver = Driver::find($id);
        $driver_wallet = DriverWallet::where('driver_id',$driver->id)->update(["wallet_cost" => '0']);
        $message = 'update has been done';
        return redirect('admin/drivers')->withSuccess($message);
    }

    public function get_user_rate(Request $request)
    {
        if ($request->ajax()) {
            $data = DriverRate::select('*')->where('user_type','=','user')->get();
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '
                    <div class="dropdown">
                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                      <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a class = "dropdown-item" href="'.route('drivers.show.rate', ['id'=> $row->id]).'" ><i class="bx bx-show-alt me-1"></i>Show</a>
                        </form>
                    </div>
                  </div>
                    ';
                    return $btn;
                })
                ->addColumn('username', function($row){
                    $username = optional($row->driver)->username;
                    return $username;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.drivers.driver_rate');
    }

    public function show_user_rate($id)
    {
        $user = DriverRate::find($id);
        if(empty($user))
        {
            $msg = 'User not found';
            return redirect(route('admin.drivers.driver_rate'))->withError($msg);
        }
        return view('admin.drivers.show_rate', compact('user'));
    }
}
