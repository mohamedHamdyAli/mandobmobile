<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Veichle;
use Yajra\DataTables\DataTables;

class VeichleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Veichle::select('id','name_en','name_ar','amount','max_num_km','extra_price')->get();
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '
                    <div class="dropdown">
                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                      <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a class = "dropdown-item" href="'.route('veichle.edit', ['id'=> $row->id]).'" ><i class="bx bx-edit-alt me-1"></i>Edit</a>
                        <a class = "dropdown-item" href="'.route('veichle.show', ['id'=> $row->id]).'" ><i class="bx bx-show-alt me-1"></i>Show</a>
                        <form method="POST" data--submit="veichle'.$row->id.'" action="'.route('veichle.destroy', ['id'=> $row->id]).'">
                        <input name="_method" type="hidden" value="DELETE">
                        <input name="_token" type="hidden" value="'.csrf_token().'">
                        <button class="dropdown-item"><i class="bx bx-trash me-1"></i>Delete </button>
                        </form>
                    </div>
                  </div>
                    ';
                    return $btn ;
                })
                ->addColumn('image', function($row){

                    if ($row->getFirstMediaUrl('veichle_image') != null) {
                        $image_url = '<img src="'.$row->getFirstMediaUrl('veichle_image').'"alt="user-avatar" class="d-block rounded" height="100" width="100" id="uploadedAvatar" />';
                    } else {
                        $image_url = 'No Image';
                    }
                    return $image_url;
                })
                ->rawColumns(['action', 'image'])
                ->make(true);
        }

        return view('admin.veichle.index');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $id = $request->id;
        $veichledata = Veichle::find($id);
        $pageTitle = 'Update veichle';

        if($veichledata == null){
            $pageTitle = 'Add veichle';
            $veichledata = new Veichle;
        }

        return view('admin.veichle.create', compact('pageTitle' ,'veichledata'));
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
            $veichle = Veichle::create($data);
            if($request->hasFile('veichle_image') && $request->file('veichle_image')->isValid()){
                $veichle->addMediaFromRequest('veichle_image')->toMediaCollection('veichle_image');
            }
        } else {
            $veichle = Veichle::findOrFail($id);
            $veichle->fill($data)->update();
            if($request->hasFile('veichle_image') && $request->file('veichle_image')->isValid()){
                $veichle->clearMediaCollection('veichle_image');
                $veichle->addMediaFromRequest('veichle_image')->toMediaCollection('veichle_image');
            }
        }
        $message = 'updated done';
        if($veichle->wasRecentlyCreated){
            $message = 'created done';
        }

        return redirect('admin/veichle')->withSuccess($message);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $veichle = Veichle::find($id);
        if(empty($veichle))
        {
            $msg = 'Veichle not found';
            return redirect(route('veichle.index'))->withError($msg);
        }
        return view('admin.veichle.show', compact('veichle'));
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
        $veichle = Veichle::find($id);
        $msg ='Error something went wrong please try again';

        if($veichle != '') {
            $veichle->delete();
            $msg ='Veichle has been deleted';
        }

        return redirect()->back()->withSuccess($msg);
    }
}
