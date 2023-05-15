<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CancellOrder;
use Yajra\DataTables\DataTables;

class CanellOrderController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = CancellOrder::select('*')->get();
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '
                    <div class="dropdown">
                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                      <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a class = "dropdown-item" href="'.route('cancell.edit', ['id'=> $row->id]).'" ><i class="bx bx-edit-alt me-1"></i>Edit</a>
                        <a class = "dropdown-item" href="'.route('cancell.show', ['id'=> $row->id]).'" ><i class="bx bx-show-alt me-1"></i>Show</a>
                        <form method="POST" data--submit="cancell'.$row->id.'" action="'.route('cancell.destroy', ['id'=> $row->id]).'">
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

        return view('admin.cancell.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $id = $request->id;
        $cancelldata = CancellOrder::find($id);
        $pageTitle = 'Update ';

        if($cancelldata == null){
            $pageTitle = 'Adde';
            $cancelldata = new CancellOrder;
        }

        return view('admin.cancell.create', compact('pageTitle' ,'cancelldata'));
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
            $cancell = CancellOrder::create($data);
        } else {
            $cancell = CancellOrder::findOrFail($id);
            $cancell->fill($data)->update();
        }
        $message = 'updated done';
        if($cancell->wasRecentlyCreated){
            $message = 'created done';
        }
        return redirect('admin/cancell')->withSuccess($message);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cancell = CancellOrder::find($id);
        if(empty($cancell))
        {
            $msg = 'cancell not found';
            return redirect(route('cancell.index'))->withError($msg);
        }
        return view('admin.cancell.show', compact('cancell'));
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
        $cancell = CancellOrder::find($id);
        $msg ='Error something went wrong please try again';

        if($cancell != '') {
            $cancell->delete();
            $msg ='cancell has been deleted';
        }

        return redirect()->back()->withSuccess($msg);
    }
}
