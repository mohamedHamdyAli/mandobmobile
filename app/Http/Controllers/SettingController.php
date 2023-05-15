<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use App\Helper\CustomHelper;
use App\Models\Complaints;
use App\Models\TermsConditions;
use App\Models\About;
use App\Models\PrivacyPolicy;
use Yajra\DataTables\DataTables;

class SettingController extends Controller
{
    public function index($id) {
        $setting = Setting::find($id);
        if(empty($setting))
        {
            $msg = 'setting not found';
            return redirect(route('setting.index'))->withError($msg);
        }
        return view('admin.setting', compact('setting'));
    }

    public function update(Request $request)
    {
        $data = $request->all();
        // dd($data);
        $id = $data['id'];
        if($id == null){
            $setting = Setting::create($data);
            if($request->hasFile('logo_image') && $request->file('logo_image')->isValid()){
                $setting->addMediaFromRequest('logo_image')->toMediaCollection('logo_image');
            }
            if($request->hasFile('fav_image') && $request->file('fav_image')->isValid()){
                $setting->addMediaFromRequest('fav_image')->toMediaCollection('fav_image');
            }
        } else {
            $setting = Setting::findOrFail($id);
            $setting->fill($data)->update();
            if($request->hasFile('logo_image') && $request->file('logo_image')->isValid()){
                $setting->clearMediaCollection('logo_image');
                $setting->addMediaFromRequest('logo_image')->toMediaCollection('logo_image');
            }
            if($request->hasFile('fav_image') && $request->file('fav_image')->isValid()){
                $setting->clearMediaCollection('fav_image');
                $setting->addMediaFromRequest('fav_image')->toMediaCollection('fav_image');
            }
        }
        $message = 'updated done';
        if($setting->wasRecentlyCreated){
            $message = 'created done';
        }
        return redirect('admin/setting/'.$id )->withSuccess($message);

    }
    public function get_complaints(Request $request) {
        if ($request->ajax()) {
            $data = Complaints::select('*')->get();
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '
                    <div class="dropdown">
                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                      <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a class = "dropdown-item" href="'.route('complaints.show', ['id'=> $row->id]).'" ><i class="bx bx-show-alt me-1"></i>Show</a>
                        <form method="POST" data--submit="complaints'.$row->id.'" action="'.route('complaints.destroy', ['id'=> $row->id]).'">
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

        return view('admin.complaints.index');
    }
    public function show_complaints($id) {
        $complaints = Complaints::find($id);
        if(empty($complaints))
        {
            $msg = 'complaints not found';
            return redirect(route('complaints.index'))->withError($msg);
        }
        return view('admin.complaints.show', compact('complaints'));
    }
    public function destroy_complaints ($id)
    {
        $complaints = Complaints::find($id);
        $msg ='Error something went wrong please try again';

        if($complaints != '') {
            $complaints->delete();
            $msg ='complaints has been deleted';
        }

        return redirect()->back()->withSuccess($msg);
    }

    public function index_about($id) {
        $about = About::find($id);
        if(empty($about))
        {
            $msg = 'about not found';
            return redirect(route('about.index'))->withError($msg);
        }
        return view('admin.about', compact('about'));
    }

    public function update_about(Request $request) {
        $data = $request->all();
        $id = $data['id'];
        if($id == null){
            $about = About::create($data);
        } else {
            $about = About::findOrFail($id);
            $about->fill($data)->update();
        }
        $message = 'updated done';
        if($about->wasRecentlyCreated){
            $message = 'created done';
        }
        return redirect('admin/about/'.$id)->withSuccess($message);
    }
    public function index_terms($id) {
        $terms = TermsConditions::find($id);
        if(empty($terms))
        {
            $msg = 'terms not found';
            return redirect(route('terms.index'))->withError($msg);
        }
        return view('admin.terms', compact('terms'));
    }

    public function update_terms(Request $request) {
        $data = $request->all();
        $id = $data['id'];
        if($id == null){
            $terms = TermsConditions::create($data);
        } else {
            $terms = TermsConditions::findOrFail($id);
            $terms->fill($data)->update();
        }
        $message = 'updated done';
        if($terms->wasRecentlyCreated){
            $message = 'created done';
        }
        return redirect('admin/terms/'.$id)->withSuccess($message);
    }
    public function index_privacy($id) {
        $privacy = PrivacyPolicy::find($id);
        if(empty($privacy))
        {
            $msg = 'privacy not found';
            return redirect(route('privacy.index'))->withError($msg);
        }
        return view('admin.privacy', compact('privacy'));
    }

    public function update_privacy(Request $request) {
        $data = $request->all();
        $id = $data['id'];
        if($id == null){
            $privacy = PrivacyPolicy::create($data);
        } else {
            $privacy = PrivacyPolicy::findOrFail($id);
            $privacy->fill($data)->update();
        }
        $message = 'updated done';
        if($privacy->wasRecentlyCreated){
            $message = 'created done';
        }
        return redirect('admin/privacy/'.$id)->withSuccess($message);
    }
}
