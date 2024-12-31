<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CmsPage;
use App\Models\AdminsRole;
use Illuminate\Http\Request;
use Validator;
use Session;
use Auth;

class CmsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Session::put('page','cms-pages');
        $cms_pages = CmsPage::get();
        /*$cms_pages = json_decode(json_encode($cms_pages));
        echo "<pre>"; print_r($cms_pages); die;*/

        // Set Admin/Subadmins Permissions for CMS Pages
        $cmspagesModuleCount = AdminsRole::where(['subadmin_id'=>Auth::guard('admin')->user()->id,'module'=>'cms_pages'])->count();
        if(Auth::guard('admin')->user()->type=="admin"){
            $pagesModule['view_access'] = 1;
            $pagesModule['edit_access'] = 1;
            $pagesModule['full_access'] = 1;
        }else if($cmspagesModuleCount==0){
            $message = "This feature is restricted for you!";
            return redirect('admin/dashboard')->with('error_message',$message);
        }else{
            $pagesModule = AdminsRole::where(['subadmin_id'=>Auth::guard('admin')->user()->id,'module'=>'cms_pages'])->first()->toArray();  
            /*dd($pagesModule); die; */    
        }


        return view('admin.pages.cms_pages')->with(compact('cms_pages','pagesModule'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(CmsPage $cmsPage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id=null)
    {
        if($id ==""){
            $title="Add CMS Page";
            $cmspage = new CmsPage;
            $message = "CMS Page added successfully";
        }else{
            $title="Edit CMS Page";
            $cmspage = CmsPage::find($id);
            $message = "CMS Page updated successfully";
        }

         if($request->isMethod('post')){
            $data = $request->all();
            /*echo "<pre>"; print_r($data); die;*/

            // Category Validations
            $rules = [
                'title' => 'required',
                'url' => 'required',
                'description' => 'required'
            ];
            $customMessages = [
                'title.required' => 'Title is required',
                'url.required' => 'URL is required',
                'description.required' => 'Description is required',
            ];

            $request->validate($rules,$customMessages);

            $cmspage->title = $data['title'];
            $cmspage->url = $data['url'];
            $cmspage->description = $data['description'];
            $cmspage->status = 1;
            $cmspage->save();

            return redirect('/admin/cms-pages')->with("success_message",$message);

        }

        return view('admin.pages.add_edit_cmspage')->with(compact('title','cmspage'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CmsPage $cmsPage)
    {
        if($request->ajax()){
            $data = $request->all();
            /*echo "<pre>"; print_r($data); die;*/
            if($data['status']=="Active"){
                $status = 0;
            }else{
                $status = 1;
            }
            CmsPage::where('_id',$data['page_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'page_id'=>$data['page_id']]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Delete CMS Page
        CmsPage::where(['_id'=>$id])->delete();
        return redirect()->back()->with('success_message', 'CMS Page has been deleted successfully');
    }
}
