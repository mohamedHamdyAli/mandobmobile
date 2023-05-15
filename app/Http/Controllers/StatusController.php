<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Status;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $status = Status::all();
        return view('admin.status.index')->with('status',$status);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $id = $request->id;
        $statusdata = Status::find($id);
        $pageTitle = 'Update Status';

        if($statusdata == null){
            $pageTitle = 'Add Status';
            $statusdata = new Status;
        }

        return view('admin.status.create', compact('pageTitle' ,'statusdata'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $id = $data['id'];
        if($id == null){
            $status = Status::create($data);
        } else {
            $status = Status::findOrFail($id);
            $status->fill($data)->update();
        }
        $message = 'updated done';
        if($status->wasRecentlyCreated){
            $message = 'created done';
        }

        return redirect('admin/status')->withSuccess($message);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $status = Status::find($id);
        if(empty($status))
        {
            $msg = 'status not found';
            return redirect(route('status.index'))->withError($msg);
        }
        return view('admin.status.show', compact('status'));
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
        $status = Status::find($id);
        $msg ='Error something went wrong please try again';

        if($status != '') {
            $status->delete();
            $msg ='statu$status has been deleted';
        }

        return redirect()->back()->withSuccess($msg);
    }
}
