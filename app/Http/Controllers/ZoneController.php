<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Zone;
use Yajra\DataTables\DataTables;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportZone;
use App\Exports\ExportZone;

class ZoneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Zone::select('id','name_en','name_ar')->get();
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '
                    <div class="dropdown">
                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                      <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a class = "dropdown-item" href="'.route('zone.edit', ['id'=> $row->id]).'" ><i class="bx bx-edit-alt me-1"></i>Edit</a>
                        <a class = "dropdown-item" href="'.route('zone.show', ['id'=> $row->id]).'" ><i class="bx bx-show-alt me-1"></i>Show</a>
                        <form method="POST" data--submit="zone'.$row->id.'" action="'.route('zone.destroy', ['id'=> $row->id]).'">
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

        return view('admin.zone.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $id = $request->id;

        $zonedata = Zone::find($id);
        $pageTitle = 'Update Zone';

        if($zonedata == null){
            $pageTitle = 'Add Zone';
            $zonedata = new Zone;
        }

        return view('admin.zone.create', compact('pageTitle' ,'zonedata'));
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
            $zone = Zone::create($data);
        } else {
            $zone = Zone::findOrFail($id);
            $zone->fill($data)->update();
        }
        $message = 'updated done';
        if($zone->wasRecentlyCreated){
            $message = 'created done';
        }
        return redirect('admin/zone')->withSuccess($message);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $zone = Zone::find($id);
        if(empty($zone))
        {
            $msg = 'Zone not found';
            return redirect(route('zone.index'))->withError($msg);
        }
        return view('admin.zone.show', compact('zone'));
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
        $zone = Zone::find($id);
        $msg ='Error something went wrong please try again';

        if($zone != '') {
            $zone->delete();
            $msg ='Zone has been deleted';
        }

        return redirect()->back()->withSuccess($msg);
    }

    public function import(Request $request){
        Excel::import(new ImportZone, $request->file('file')->store('files'));
        return redirect()->back();
    }

    public function export_zone(){
        return Excel::download(new ExportZone, 'zones.xlsx');
    }

}
