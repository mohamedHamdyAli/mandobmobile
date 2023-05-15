<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DriverRate;
use App\Models\User;
use App\Models\Roles;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\DataTables\UsersDataTable;
use Yajra\DataTables\DataTables;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::select('id','username','email','phone')->where('user_type','=','user')->get();
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '
                    <div class="dropdown">
                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                      <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a class = "dropdown-item" href="'.route('users.edit', ['id'=> $row->id]).'" ><i class="bx bx-edit-alt me-1"></i>Edit</a>
                        <a class = "dropdown-item" href="'.route('users.show', ['id'=> $row->id]).'" ><i class="bx bx-show-alt me-1"></i>Show</a>
                        <form method="POST" data--submit="user'.$row->id.'" action="'.route('users.destroy', ['id'=> $row->id]).'">
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

        return view('admin.users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $id = $request->id;
        $userdata = User::find($id);
        $user_roles = Roles::all();
        $zones = Zone::all();
        $pageTitle = 'Update User';

        if($userdata == null){
            $pageTitle = 'Add New User';
            $userdata = new User;
        }

        return view('admin.users.create', compact('pageTitle' ,'userdata', 'user_roles', 'zones' ));
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
        $data['user_type'] = 'user';
        if($id == null){
            $data['password'] = Hash::make($data['password']);
            $user = User::create($data);
        } else {
            $user = User::findOrFail($id);
            $user->fill($data)->update();
        }
        $message = 'updated done';
        if($user->wasRecentlyCreated){
            $message = 'created done';
        }
        return redirect('admin/users')->withSuccess($message);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        $rate = DriverRate::where('user_id', $id)->where('user_type', 'driver')->get();
            $order_count = $rate->count();
            $driver_rate = $rate->sum('rate');
            if($order_count != 0)
                $final_rate = $driver_rate / $order_count;
            else
                $final_rate = 0;
        if(empty($user))
        {
            $msg = 'User not found';
            return redirect(route('user.index'))->withError($msg);
        }
        return view('admin.users.show', compact('user','final_rate'));
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
        $user = User::find($id);
        $msg ='Error something went wrong please try again';

        if($user != '') {
            $user->delete();
            $msg ='User has been deleted';
        }

        return redirect()->back()->withSuccess($msg);
    }

    public function get_user_rate(Request $request)
    {
        if ($request->ajax()) {
            $data = DriverRate::select('*')->where('user_type','=','driver')->get();
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '
                    <div class="dropdown">
                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                      <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a class = "dropdown-item" href="'.route('users.show.rate', ['id'=> $row->id]).'" ><i class="bx bx-show-alt me-1"></i>Show</a>
                        </form>
                    </div>
                  </div>
                    ';
                    return $btn;
                })
                ->addColumn('username', function($row){
                    $username = optional($row->user)->username;
                    return $username;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.users.user_rate');
    }

    public function show_user_rate($id)
    {
        $user = DriverRate::find($id);
        if(empty($user))
        {
            $msg = 'User not found';
            return redirect(route('admin.users.user_rate'))->withError($msg);
        }
        return view('admin.users.show_rate', compact('user'));
    }


}
