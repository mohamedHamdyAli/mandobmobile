<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Status;
use App\Models\Order_request;
use Yajra\DataTables\DataTables;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $statusdata = Status::all();

        if ($request->ajax()) {
            $data = Order::select('*');
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '
                    <div class="dropdown">
                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                      <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a class = "dropdown-item" href="'.route('order.edit', ['id'=> $row->id]).'" ><i class="bx bx-edit-alt me-1"></i>Edit</a>
                        <a class = "dropdown-item" href="'.route('order.show', ['id'=> $row->id]).'" ><i class="bx bx-show-alt me-1"></i>Show</a>
                    </div>
                  </div>
                    ';
                    return $btn ;
                })
                ->addColumn('username', function($row){
                    $username = optional($row->user)->username;
                    return $username;
                })
                ->addColumn('activity_type', function($row){
                    $activity_type = $row->activity_type->pluck('name_en')->implode(',');
                    return $activity_type;
                })
                ->addColumn('veichle_type', function($row){
                    $veichle_type = optional($row->veichle_type)->name_en;
                    return $veichle_type;
                })
                ->filter(function ($instance) use ($request) {
                    if ($request->get('status') == 'pending' || $request->get('status') == 'cancel'||   $request->get('status') == 'upcoming'|| $request->get('status') == 'delivered'||   $request->get('status') == 'accepted') {
                        $instance->where('status', $request->get('status'));
                    }
                })
                ->rawColumns(['status'])
                ->rawColumns(['action','username','veichle_type','activity_type'])
                ->make(true);
        }

        return view('admin.orders.index')->with('statusdata',$statusdata);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::find($id);
        $order_request = Order_request::where('order_id', $order->id)->get();

        if(empty($order))
        {
            $msg = 'order not found';
            return redirect(route('order.index'))->withError($msg);
        }
        return view('admin.orders.show', compact('order', 'order_request'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order = Order::find($id);
        $status = Status::all();
        if(empty($order))
        {
            $msg = 'Order not found';
            return redirect(route('order.index'))->withError($msg);
        }
        return view('admin.orders.edit', compact('order', 'status'));
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
        $order = Order::find($id);
        $order->status = $request->get('status');;
        $order->save();
        $message = 'updated done';
        return redirect('admin/order')->withSuccess($message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
