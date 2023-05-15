<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activity;
use Yajra\DataTables\DataTables;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Activity::select('id','name_en','name_ar')->get();
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '
                    <div class="dropdown">
                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                      <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a class = "dropdown-item" href="'.route('activity.edit', ['id'=> $row->id]).'" ><i class="bx bx-edit-alt me-1"></i>Edit</a>
                        <a class = "dropdown-item" href="'.route('activity.show', ['id'=> $row->id]).'" ><i class="bx bx-show-alt me-1"></i>Show</a>
                        <form method="POST" data--submit="activity'.$row->id.'" action="'.route('activity.destroy', ['id'=> $row->id]).'">
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

        return view('admin.activity.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $id = $request->id;
        $activitydata = Activity::find($id);
        $pageTitle = 'Update activity';

        if($activitydata == null){
            $pageTitle = 'Add activity';
            $activitydata = new Activity;
        }

        return view('admin.activity.create', compact('pageTitle' ,'activitydata'));
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
            $activity = Activity::create($data);
        } else {
            $activity = Activity::findOrFail($id);
            $activity->fill($data)->update();
        }
        $message = 'updated done';
        if($activity->wasRecentlyCreated){
            $message = 'created done';
        }
        return redirect('admin/activity')->withSuccess($message);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $activity = Activity::find($id);
        if(empty($activity))
        {
            $msg = 'Activity not found';
            return redirect(route('activity.index'))->withError($msg);
        }
        return view('admin.activity.show', compact('activity'));
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
        $activity = Activity::find($id);
        $msg ='Error something went wrong please try again';

        if($activity != '') {
            $activity->delete();
            $msg ='Activity has been deleted';
        }

        return redirect()->back()->withSuccess($msg);
    }
}
