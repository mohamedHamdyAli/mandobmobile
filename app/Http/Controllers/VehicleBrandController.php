<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VehicleBrand;
use Yajra\DataTables\DataTables;

class VehicleBrandController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = VehicleBrand::select('id','name_en','name_ar')->get();
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '
                    <div class="dropdown">
                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                      <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a class = "dropdown-item" href="'.route('veichle_brand.edit', ['id'=> $row->id]).'" ><i class="bx bx-edit-alt me-1"></i>Edit</a>
                        <a class = "dropdown-item" href="'.route('veichle_brand.show', ['id'=> $row->id]).'" ><i class="bx bx-show-alt me-1"></i>Show</a>
                        <form method="POST" data--submit="veichle_brand'.$row->id.'" action="'.route('veichle_brand.destroy', ['id'=> $row->id]).'">
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

        return view('admin.veichle_brand.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $id = $request->id;
        $veichle_branddata = VehicleBrand::find($id);
        $pageTitle = 'Update veichle_brand';

        if($veichle_branddata == null){
            $pageTitle = 'Add veichle_brand';
            $veichle_branddata = new VehicleBrand;
        }

        return view('admin.veichle_brand.create', compact('pageTitle' ,'veichle_branddata'));
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
            $veichle_brand = VehicleBrand::create($data);
        } else {
            $veichle_brand = VehicleBrand::findOrFail($id);
            $veichle_brand->fill($data)->update();
        }
        $message = 'updated done';
        if($veichle_brand->wasRecentlyCreated){
            $message = 'created done';
        }

        return redirect('admin/veichle_brand')->withSuccess($message);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $veichle_brand = VehicleBrand::find($id);
        if(empty($veichle_brand))
        {
            $msg = 'veichle_brand not found';
            return redirect(route('veichle_brand.index'))->withError($msg);
        }
        return view('admin.veichle_brand.show', compact('veichle_brand'));
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
        $veichle_brand = VehicleBrand::find($id);
        $msg ='Error something went wrong please try again';

        if($veichle_brand != '') {
            $veichle_brand->delete();
            $msg ='veichle brand has been deleted';
        }

        return redirect()->back()->withSuccess($msg);
    }
}
