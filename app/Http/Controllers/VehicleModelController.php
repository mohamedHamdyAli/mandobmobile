<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VehicleModel;
use App\Models\VehicleBrand;
use Yajra\DataTables\DataTables;

class VehicleModelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = VehicleModel::select('*')->get();
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '
                    <div class="dropdown">
                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                      <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a class = "dropdown-item" href="'.route('veichle_model.edit', ['id'=> $row->id]).'" ><i class="bx bx-edit-alt me-1"></i>Edit</a>
                        <a class = "dropdown-item" href="'.route('veichle_model.show', ['id'=> $row->id]).'" ><i class="bx bx-show-alt me-1"></i>Show</a>
                        <form method="POST" data--submit="veichle_model'.$row->id.'" action="'.route('veichle_model.destroy', ['id'=> $row->id]).'">
                        <input name="_method" type="hidden" value="DELETE">
                        <input name="_token" type="hidden" value="'.csrf_token().'">
                        <button class="dropdown-item"><i class="bx bx-trash me-1"></i>Delete </button>
                        </form>
                    </div>
                  </div>
                    ';
                    return $btn ;
                })
                ->addColumn('vehicle_brand_id ', function($row){
                    $vehicle_brand  = optional($row->vehicle_brand )->name_en;
                    return $vehicle_brand ;
                })

                ->rawColumns(['action','vehicle_brand'])
                ->make(true);
        }

        return view('admin.veichle_model.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $vichle_brand = VehicleBrand::all();
        $id = $request->id;
        $veichle_modeldata = VehicleModel::find($id);
        $pageTitle = 'Update veichle model';

        if($veichle_modeldata == null){
            $pageTitle = 'Add veichle model';
            $veichle_modeldata = new VehicleModel;
        }

        return view('admin.veichle_model.create', compact('pageTitle' ,'veichle_modeldata','vichle_brand'));
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
            $veichle_model = VehicleModel::create($data);
        } else {
            $veichle_model = VehicleModel::findOrFail($id);
            $veichle_model->fill($data)->update();
        }
        $message = 'updated done';
        if($veichle_model->wasRecentlyCreated){
            $message = 'created done';
        }

        return redirect('admin/veichle_model')->withSuccess($message);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $veichle_model = VehicleModel::find($id);
        if(empty($veichle_model))
        {
            $msg = 'veichle model not found';
            return redirect(route('veichle_model.index'))->withError($msg);
        }
        return view('admin.veichle_model.show', compact('veichle_model'));
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
        $veichle_model = VehicleModel::find($id);
        $msg ='Error something went wrong please try again';

        if($veichle_model != '') {
            $veichle_model->delete();
            $msg ='veichle Model has been deleted';
        }

        return redirect()->back()->withSuccess($msg);
    }

}
