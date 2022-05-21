<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HomeSlider;
use App\Models\Subcategory;
use Image;

class SliderController extends Controller
{
    public function AllSlider(){
        $result = HomeSlider::get();
           
        $categoryDetailsArray = [];

        foreach ($result as $value) {
            $item = [
                'id'=>$value['id'],
                'slider_image'=>asset(HomeSlider::IMAGE_PATH.$value['slider_image']),                 
            ];
            array_push($categoryDetailsArray, $item);
        } 
        return $categoryDetailsArray;


    } // End Mehtod 


    public function GetAllSlider(){
        $slider = HomeSlider::latest()->get();
        return view('backend.slider.slider_view',compact('slider'));
    } // End Mehtod 


    public function AddSlider(){

         return view('backend.slider.slider_add');

    }// End Mehtod 

    public function StoreSlider(Request $request){

         $request->validate([
            'slider_image' => 'required',
        ],[
            'slider_image.required' => 'Upload Slider Image'

        ]);

        if($request->file('slider_image'))
        {
            $image = $request->file('slider_image');
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(1024,379)->save(public_path(HomeSlider::IMAGE_PATH.$name_gen));
            $save_url =$name_gen;
        }


        HomeSlider::insert([          
            'slider_image' => $save_url,
        ]);

        $notification = array(
            'message' => 'Slider Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.slider')->with($notification);

    }// End Mehtod 


    public function EditSlider($id){
        $slider = HomeSlider::findOrFail($id);
        return view('backend.slider.slider_edit',compact('slider'));

    } // End Mehtod 


    public function UpdateSlider(Request $request){

        $slider_id = $request->id;
        $old_image = $request->old_image;


        if ($request->file('slider_image'))
        {
            $image = $request->file('slider_image');
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(1024, 379)->save(public_path(HomeSlider::IMAGE_PATH.$name_gen));
            $save_url =$name_gen;

            
            // start delete image
            if(!empty($old_image))
            {
                if (file_exists(HomeSlider::IMAGE_PATH.$old_image)) {
                    unlink(public_path(HomeSlider::IMAGE_PATH.$old_image));
                }
            }
            // end delete image
            HomeSlider::findOrFail($slider_id)->update([          
                'slider_image' => $save_url,
            ]);

        }else{
            HomeSlider::findOrFail($slider_id)->update([          
                'slider_image' => $old_image,
            ]); 
        }



        $notification = array(
            'message' => 'Slider Updated Successfully',
            'alert-type' => 'success'
        );
        // dd('is goods');

        return redirect()->route('all.slider')->with($notification);

    } // End Mehtod 


    public function DeleteSlider($id){

        $delete = HomeSlider::findOrFail($id);
        $old_image = $delete->slider_image;
        
        if($old_image)
        {
            if(!empty($old_image))
            {
                if (file_exists(HomeSlider::IMAGE_PATH.$old_image)) {
                    unlink(HomeSlider::IMAGE_PATH.$old_image);
                }
            }

            $delete->delete();
        }


        $notification = array(
            'message' => 'Slider Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    } // End Mehtod 

    public function subcategory_ajax($category_id)
    {
        $subcat = Subcategory::where('category_id',$category_id)->get();
     	return json_encode($subcat);
    }

}