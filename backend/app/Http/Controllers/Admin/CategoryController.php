<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Subcategory;
use Image;

class CategoryController extends Controller
{
    public function AllCategory(){
        $categories = Category::all();
        $categoryDetailsArray = [];

        foreach ($categories as $value) {
            $subcategory = Subcategory::where('category_id',$value['id'])->get();

            $item = [
                'category_name' => $value['category_name'],
                'category_image' => asset(Category::IMAGE_PATH.$value['category_image']),
                'subcategory_name' => $subcategory
            ];

            array_push($categoryDetailsArray, $item);

        } 
        return $categoryDetailsArray;

    } // End Mehtod 



    public function GetAllCategory(){

        $category = Category::latest()->get();
        return view('backend.category.category_view',compact('category'));

    } // End Mehtod 


    public function AddCategory(){
      return view('backend.category.category_add');
    } // End Mehtod 


    public function StoreCategory(Request $request){

        $request->validate([
            'category_name' => 'required',
        ],[
            'category_name.required' => 'Input Category Name'

        ]);

        if($request->file('category_image'))
        {
            $image = $request->file('category_image');
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(128,128)->save(public_path(Category::IMAGE_PATH.$name_gen));
            $save_url=$name_gen;
        }


        Category::insert([
            'category_name' => $request->category_name,
            'category_image' => $save_url,
        ]);

        $notification = array(
            'message' => 'Category Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.category')->with($notification);

    }// End Mehtod 


    public function EditCategory($id){

        $category = Category::findOrFail($id);
        return view('backend.category.category_edit',compact('category'));

    } //End Method 


    public function UpdateCategory(Request $request){

        $category_id = $request->id;
        $old_image = $request->old_image;
        // start valdation
        $validate = $request->validate([
            'category_name'=>'required',
        ]);
        // end valdation

        

        if ($request->file('category_image')) {
        $image = $request->file('category_image');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(128,128)->save(public_path(Category::IMAGE_PATH.$name_gen));
        $save_url =$name_gen;


        // start delete image
        if(!empty($old_image))
        {
            if(file_exists(Category::IMAGE_PATH.$old_image))
            {
            unlink(public_path(Category::IMAGE_PATH.$old_image));
            }
        }
        // end delete image
        

        
        Category::findOrFail($category_id)->update([
            'category_name' => $request->category_name,
            'category_image' => $save_url,
        ]);
        }else{
             Category::findOrFail($category_id)->update([
            'category_name' => $request->category_name,
            'category_image' => $old_image,
        ]);


        }

        $notification = array(
            'message' => 'Category Updateed Without Image Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.category')->with($notification);


    } //End Method 



    public function DeleteCategory($id){

    $delete = Category::findOrFail($id);

    $old_image = $delete->category_image;
    if($old_image)
    {

        if(!empty($old_image))
        {
            if(file_exists(Category::IMAGE_PATH.$old_image))
            {
                unlink(Category::IMAGE_PATH.$old_image);
            }

        }

      $delete->delete();
    }
    

    $notification = array(
            'message' => 'Category Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);     

    } //End Method 



///////////// Start Sub Category All Methods. ////////////////


    public function GetAllSubCategory(){
   $subcategory = Subcategory::latest()->get();
//    $subcategory = Subcategory::find(1)->categories;
//    return  $subcategory;die;
        return view('backend.subcategory.subcategory_view',compact('subcategory'));

    } //End Method 


    public function AddSubCategory(){

        $category = Category::latest()->get();
         return view('backend.subcategory.subcategory_add',compact('category'));
    } //End Method 


    public function StoreSubCategory(Request $request){


        $request->validate([
            'subcategory_name' => 'required',
        ],[
            'subcategory_name.required' => 'Input SubCategory Name'

        ]);

        

        Subcategory::insert([
            'category_id' => $request->category_id,
            'subcategory_name' => $request->subcategory_name,
        ]);

        $notification = array(
            'message' => 'SubCategory Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.subcategory')->with($notification);

    } //End Method 


    public function EditSubCategory($id){

        $category = Category::orderBy('category_name','ASC')->get();
        $subcategory = Subcategory::findOrFail($id);
        return view('backend.subcategory.subcategory_edit',compact('category','subcategory'));

    } //End Method 

    public function UpdateSubCategory(Request $request){

        $subcategory_id = $request->id;

        Subcategory::findOrFail($subcategory_id)->update([
            'category_id' => $request->category_id,
            'subcategory_name' => $request->subcategory_name,
        ]);

        $notification = array(
            'message' => 'SubCategory Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.subcategory')->with($notification);

    } //End Method 


    public function DeleteSubCategory($id){

        Subcategory::findOrFail($id)->delete();
         $notification = array(
            'message' => 'SubCategory Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    } //End Method    

    
}
