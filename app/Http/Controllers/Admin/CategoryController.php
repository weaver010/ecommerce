<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\AdminsRole;
use Session;
use Image;
use Auth;

class CategoryController extends Controller
{
    public function categories(){
        Session::put('page','categories');
        $categories = Category::with('parentcategory')->get()->toArray();
        //dd($categories);

        // Set Admin/Subadmins Permissions for Categories
        $categoriesModuleCount = AdminsRole::where(['subadmin_id'=>Auth::guard('admin')->user()->id,'module'=>'categories'])->count();
        if(Auth::guard('admin')->user()->type=="admin"){
            $categoriesModule['view_access'] = 1;
            $categoriesModule['edit_access'] = 1;
            $categoriesModule['full_access'] = 1;
        }else if($categoriesModuleCount==0){
            $message = "This feature is restricted for you!";
            return redirect('admin/dashboard')->with('error_message',$message);
        }else{
            $categoriesModule = AdminsRole::where(['subadmin_id'=>Auth::guard('admin')->user()->id,'module'=>'categories'])->first()->toArray();  
            /*dd($categoriesModule); die; */    
        }

        return view('admin.categories.categories')->with(compact('categories','categoriesModule'));
    }

    public function updateCatgoryStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            /*echo "<pre>"; print_r($data); die;*/
            if($data['status']=="Active"){
                $status = 0;
            }else{
                $status = 1;
            }
            Category::where('_id',$data['category_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'category_id'=>$data['category_id']]);
        }
    }

    public function deleteCategory($id){
        // Delete Category
        Category::where('_id',$id)->delete();
        return redirect()->back()->with('success_message','Category deleted successfully!');
    }

    public function addEditCategory(Request $request,$id=null){
        Session::put('page','categories');
        if($id ==""){
            $title="Add Category";
            $category = new Category;
            $message = "Category added successfully!";
        }else{
            $title="Edit Category";
            $category = Category::find($id);
            $message = "Category updated successfully!";
        }
        if($request->isMethod('post')){
            $data = $request->all();
            /*echo "<pre>"; print_r($data); die;*/

            if($id ==""){
                $rules = [
                    'category_name' => 'required|regex:/^[\pL\s\-]+$/u',
                    'url' => 'required|unique:categories',   
                ];
            }else{
                $rules = [
                    'category_name' => 'required|regex:/^[\pL\s\-]+$/u',
                    'url' => 'required',   
                ];
            }

            $customMessages = [
                'category_name.required' => 'Category Name is required',
                'category_name.regex' => 'Valid Category Name is required',
                'url.required' => 'Category URL is required',
                'url.unique' => 'Unique Category URL is required',
            ];

            $request->validate($rules,$customMessages);

            if($data['category_discount']==""){
                $data['category_discount'] = 0;    
            }

            // Upload Category Image
            if($request->hasFile('category_image')){
                $image_tmp = $request->file('category_image');
                if($image_tmp->isValid()){
                    // Get Image Extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    // Generate New Image Name
                    $imageName = rand(111,99999).'.'.$extension;
                    $imagePath = 'front/images/categories/'.$imageName;
                    // Upload the Image
                    Image::make($image_tmp)->save($imagePath);
                    $category->category_image = $imageName;
                }
            }else{
                $category->category_image = "";
            }

            $category->parent_id = $data['parent_id'];
            $category->category_name = $data['category_name'];
            $category->category_discount = $data['category_discount'];
            $category->description = $data['description'];
            $category->url = $data['url'];
            $category->meta_title = $data['meta_title'];
            $category->meta_description = $data['meta_description'];
            $category->meta_keywords = $data['meta_keywords'];
            $category->status = 1;
            $category->save();

            return redirect('admin/categories')->with('success_message',$message);

        }
        $getCategories = Category::getcategories();
        //dd($getCategories);
        return view('admin.categories.add_edit_category')->with(compact('title','category','getCategories'));
    }

    public function deleteCategoryImage($id){
        // Get Category Image
        $categoryImage = Category::select('category_image')->where('_id',$id)->first();

        // Get Category Image Path
        $category_image_path = 'front/images/categories/';

        // Delete Category image from category_images folder if exists
        if(file_exists($category_image_path.$categoryImage->category_image)){
            unlink($category_image_path.$categoryImage->category_image);
        } 

        // Delete Category Image from categories table
        Category::where('_id',$id)->update(['category_image'=>'']);

        return redirect()->back()->with('success_message','Category image deleted successfully!');
    }
}
