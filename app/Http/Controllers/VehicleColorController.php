<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VehicleColor;
use Yajra\DataTables\DataTables;

class VehicleColorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = VehicleColor::select('id','name_en','name_ar')->get();
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '
                    <div class="dropdown">
                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                      <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a class = "dropdown-item" href="'.route('veichle_color.edit', ['id'=> $row->id]).'" ><i class="bx bx-edit-alt me-1"></i>Edit</a>
                        <a class = "dropdown-item" href="'.route('veichle_color.show', ['id'=> $row->id]).'" ><i class="bx bx-show-alt me-1"></i>Show</a>
                        <form method="POST" data--submit="veichle_color'.$row->id.'" action="'.route('veichle_color.destroy', ['id'=> $row->id]).'">
                        <input name="_method" type="hidden" value="DELETE">
                        <input name="_token" type="hidden" value="'.csrf_token().'">
                        <button class="dropdown-item"><i class="bx bx-trash me-1"></i>Delete </button>
                        </form>
                    </div>
                  </div>
                    ';
                    return $btn ;
                })

                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.veichle_color.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $id = $request->id;
        $veichle_colordata = VehicleColor::find($id);
        $pageTitle = 'Update veichle model';

        if($veichle_colordata == null){
            $pageTitle = 'Add veichle model';
            $veichle_colordata = new VehicleColor;
        }

        return view('admin.veichle_color.create', compact('pageTitle' ,'veichle_colordata'));
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
            $veichle_color = VehicleColor::create($data);
            if($request->hasFile('veichle_color') && $request->file('veichle_color')->isValid()){
                $veichle_color->addMediaFromRequest('veichle_color')->toMediaCollection('veichle_color');
            }
        } else {
            $veichle_color = VehicleColor::findOrFail($id);
            $veichle_color->fill($data)->update();
            if($request->hasFile('veichle_color') && $request->file('veichle_color')->isValid()){
                $veichle_color->clearMediaCollection('veichle_color');
                $veichle_color->addMediaFromRequest('veichle_color')->toMediaCollection('veichle_color');
            }

        }
        $message = 'updated done';
        if($veichle_color->wasRecentlyCreated){
            $message = 'created done';
        }

        return redirect('admin/veichle_color')->withSuccess($message);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $veichle_color = VehicleColor::find($id);
        if(empty($veichle_color))
        {
            $msg = 'veichle model not found';
            return redirect(route('veichle_color.index'))->withError($msg);
        }
        return view('admin.veichle_color.show', compact('veichle_color'));
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
        $veichle_color = VehicleColor::find($id);
        $msg ='Error something went wrong please try again';

        if($veichle_color != '') {
            $veichle_color->delete();
            $msg ='veichle Color has been deleted';
        }

        return redirect()->back()->withSuccess($msg);
    }
}
