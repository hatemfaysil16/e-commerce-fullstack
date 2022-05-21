<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductList;
use App\Models\ProductDetails;
use App\Models\Category;
use App\Models\Subcategory;
use Image;
 
class ProductListController extends Controller
{
    public function ProductListByRemark(Request $request){

        $remark = $request->remark;
        $productlist = ProductList::where('remark',$remark)->limit(8)->get();
        $categoryDetailsArray = [];

        foreach ($productlist as $value) {
            $item = [
                'id'=>$value['id'],  
                "title"=>$value['title'],
                "price"=>$value['price'],
                "special_price"=>$value['special_price'],
                "image"=>asset(ProductList::IMAGE_PATH.$value['image']),
                "category_id"=>$value['category_id'],
                "subcategory_id"=>$value['subcategory_id'],
                "remark"=>$value['remark'],
                "brand"=>$value['brand'],
                "star"=>$value['star'],
                "product_code"=>$value['product_code'],
                "created_at"=>$value['created_at'],
                "updated_at"=>$value['updated_at']
            ];
            array_push($categoryDetailsArray, $item);
        }
        return $categoryDetailsArray;

    } // End Method 

    public function ProductListByCategory(Request $request){

        $Category = $request->category;
        $category_id = Category::where('category_name',$Category)->first();

        $productlist = ProductList::where('category_id',$category_id->id)->get();

        $categoryDetailsArray = [];

        foreach ($productlist as $value) {
            $item = [
                'id'=>$value['id'],  
                "title"=>$value['title'],
                "price"=>$value['price'],
                "special_price"=>$value['special_price'],
                "image"=>asset(ProductList::IMAGE_PATH.$value['image']),
                "category_id"=>$value['category_id'],
                "subcategory_id"=>$value['subcategory_id'],
                "remark"=>$value['remark'],
                "brand"=>$value['brand'],
                "star"=>$value['star'],
                "product_code"=>$value['product_code'],
                "created_at"=>$value['created_at'],
                "updated_at"=>$value['updated_at']
            ];
            array_push($categoryDetailsArray, $item);
        }
        return $categoryDetailsArray;

    }// End Method 


    public function ProductListBySubCategory(Request $request){

        $Category = $request->category;
        $category_id = Category::where('category_name',$Category)->first();
        $SubCategory = $request->subcategory;
        $SubCategory_id = Subcategory::where('subcategory_name',$SubCategory)->first();
        $productlist = ProductList::where('category_id',$category_id->id)->where('subcategory_id',$SubCategory_id->id)->get();

        $categoryDetailsArray = [];

        foreach ($productlist as $value) {
            $item = [
                'id'=>$value['id'],  
                "title"=>$value['title'],
                "price"=>$value['price'],
                "special_price"=>$value['special_price'],
                "image"=>asset(ProductList::IMAGE_PATH.$value['image']),
                "category_id"=>$value['category_id'],
                "subcategory_id"=>$value['subcategory_id'],
                "remark"=>$value['remark'],
                "brand"=>$value['brand'],
                "star"=>$value['star'],
                "product_code"=>$value['product_code'],
                "created_at"=>$value['created_at'],
                "updated_at"=>$value['updated_at']
            ];
            array_push($categoryDetailsArray, $item);
        }
        return $categoryDetailsArray;

    }// End Method 



    public function ProductBySearch(Request $request){

        $key = $request->key;
        $productlist = ProductList::where('title','LIKE',"%{$key}%")->orWhere('brand','LIKE',"%{$key}%")->get();
        return $productlist;

    }// End Method 


    public function SimilarProduct(Request $request){
        $subcategory = $request->subcategory;
        $productlist = ProductList::where('subcategory',$subcategory)->orderBy('id','desc')->limit(6)->get();
        return $productlist;

    }// End Method 



    public function GetAllProduct(){

        $products = ProductList::latest()->paginate(10);
        return view('backend.product.product_all',compact('products'));

    } // End Method 


    public function AddProduct(){

        $category = Category::orderBy('category_name','ASC')->get();
        $subcategory = Subcategory::orderBy('subcategory_name','ASC')->get();
        return view('backend.product.product_add',compact('category','subcategory'));

    } // End Method 


    public function StoreProduct(Request $request){

        // return $request;die;
         $request->validate([
            'product_code' => 'required',
        ],[
            'product_code.required' => 'Input Product Code'

        ]);

        if($request->file('image'))
        {
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(711,960)->save(ProductList::IMAGE_PATH.$name_gen);
            $save_url = $name_gen;
        }


        $product_id = ProductList::create([
            'title' => $request->title,
            'price' => $request->price,
            'special_price' => $request->special_price,
            'image' => $save_url, 
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'remark' => $request->remark,
            'brand' => $request->brand,
            'star' => $request->star,
            'product_code' => $request->product_code,

        ]);

        /////// Insert Into Product Details Table ////// 

    if($request->file('image_one'))
    {
        $image1 = $request->file('image_one');
        $name_gen1 = hexdec(uniqid()).'.'.$image1->getClientOriginalExtension();
        Image::make($image1)->resize(711,960)->save(ProductList::IMAGE_PATH.$name_gen1);
        $save_url1 = $name_gen1;
    }


    if($request->file('image_one'))
    {
        $image2 = $request->file('image_two');
        $name_gen2 = hexdec(uniqid()).'.'.$image2->getClientOriginalExtension();
        Image::make($image2)->resize(711,960)->save(ProductList::IMAGE_PATH.$name_gen2);
        $save_url2 = $name_gen2;
    }


    if($request->file('image_one'))
    {
        $image3 = $request->file('image_three');
        $name_gen3 = hexdec(uniqid()).'.'.$image3->getClientOriginalExtension();
        Image::make($image1)->resize(711,960)->save(ProductList::IMAGE_PATH.$name_gen3);
        $save_url3 = $name_gen3;
    }


    if($request->file('image_one'))
    {
        $image4 = $request->file('image_four');
        $name_gen4 = hexdec(uniqid()).'.'.$image4->getClientOriginalExtension();
        Image::make($image4)->resize(711,960)->save(ProductList::IMAGE_PATH.$name_gen4);
        $save_url4 = $name_gen4;
    }

        ProductDetails::create([
            'product_id' => $product_id->id,
            'image_one' => $save_url1,
            'image_two' => $save_url2,
            'image_three' => $save_url3,
            'image_four' => $save_url4,
            'short_description' => $request->short_description,
            'color' =>  $request->color,
            'size' =>  $request->size,
            'long_description' => $request->long_description,
        ]);
        // return $product_id;die;


        $notification = array(
            'message' => 'Product Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.product')->with($notification);


    } // End Method 



    public function EditProduct($id){

        $category = Category::orderBy('category_name','ASC')->get();
        $subcategory = Subcategory::orderBy('subcategory_name','ASC')->get();
        $product = ProductList::findOrFail($id);
        $details = ProductDetails::where('product_id',$id)->get();
        return view('backend.product.product_edit',compact('category','subcategory','product','details'));

    } // End Method 


    public function updateProduct(Request $request){

        $id = $request->id;


         $request->validate([
            'product_code' => 'required',
        ],[
            'product_code.required' => 'Input Product Code'
        ]);


        if ($request->file('image')) {
            if (!empty($request->old_thumbnail)) {
                unlink(public_path(ProductList::IMAGE_PATH.$request->old_thumbnail));
            }
        }

        if ($request->file('image')) {
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(711, 960)->save(public_path(ProductList::IMAGE_PATH.$name_gen));
            $save_url = $name_gen;
        }

        $product_id = ProductList::find($id)->update([
            'title' => $request->title,
            'price' => $request->price,
            'special_price' => $request->special_price,
            'image' => !empty($save_url)?$save_url:$request->old_thumbnail,
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'remark' => $request->remark,
            'brand' => $request->brand,
            'star' => $request->star,
            'product_code' => $request->product_code,
        ]);




        /////// Insert Into Product Details Table ////// 

        if ($request->file('image_one')) {
            if (!empty($request->old_image_one)) {
                if(file_exists(ProductList::IMAGE_PATH.$request->old_image_one))
                {
                  unlink(public_path(ProductList::IMAGE_PATH.$request->old_image_one));
                }
            }
        }
        if ($request->file('image_two')) {
            if (!empty($request->old_image_two)) {
                if(file_exists(ProductList::IMAGE_PATH.$request->old_image_two))
                {
                    unlink(public_path(ProductList::IMAGE_PATH.$request->old_image_two));
                }
            }
        }
        if ($request->file('image_three')) {
            if (!empty($request->old_image_three)) {
                if (file_exists(ProductList::IMAGE_PATH.$request->old_image_three)) {
                    unlink(public_path(ProductList::IMAGE_PATH.$request->old_image_three));
                }
            }
        }

        if ($request->file('image_four')) {
            if (!empty($request->old_image_four)) {
                if (file_exists(ProductList::IMAGE_PATH.$request->old_image_four)) {
                    unlink(public_path(ProductList::IMAGE_PATH.$request->old_image_four));
                }
            }
        }
    if($request->file('image_one'))
    {
        $image1 = $request->file('image_one');
        $name_gen1 = hexdec(uniqid()).'.'.$image1->getClientOriginalExtension();
        Image::make($image1)->resize(711,960)->save(public_path(ProductList::IMAGE_PATH.$name_gen1));
        $save_url1 = $name_gen1;
    }


    if($request->file('image_two'))
    {
        $image2 = $request->file('image_two');
        $name_gen2 = hexdec(uniqid()).'.'.$image2->getClientOriginalExtension();
        Image::make($image2)->resize(711,960)->save(public_path(ProductList::IMAGE_PATH.$name_gen2));
        $save_url2 = $name_gen2;
    }


    if($request->file('image_three'))
    {
        $image3 = $request->file('image_three');
        $name_gen3 = hexdec(uniqid()).'.'.$image3->getClientOriginalExtension();
        Image::make($image1)->resize(711,960)->save(public_path(ProductList::IMAGE_PATH.$name_gen3));
        $save_url3 = $name_gen3;
    }


    if($request->file('image_four'))
    {
        $image4 = $request->file('image_four');
        $name_gen4 = hexdec(uniqid()).'.'.$image4->getClientOriginalExtension();
        Image::make($image4)->resize(711,960)->save(public_path(ProductList::IMAGE_PATH.$name_gen4));
        $save_url4 = $name_gen4;
    }

    $id_product = ProductDetails::where('product_id',$id)->first();
    // dd($id_product->id);
    ProductDetails::find($id_product->id)->update([
        'product_id' => $id,
        'image_one' => !empty($save_url1)?$save_url1:$request->old_image_one,
        'image_two' => !empty($save_url2)?$save_url2:$request->old_image_two,
        'image_three' => !empty($save_url3)?$save_url3:$request->old_image_three,
        'image_four' => !empty($save_url4)?$save_url4:$request->old_image_four,
        'short_description' => $request->short_description,
        'color' =>  $request->color,
        'size' =>  $request->size,
        'long_description' => $request->long_description,
    ]);
        // return $product_id;die;


        $notification = array(
            'message' => 'Product Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.product')->with($notification);


    } // End Method 

    public function DeleteProduct($id)
    {
        $product = ProductList::find($id);
        $old_image = $product->image;
        if($old_image)
        {
            if(!empty($old_image))
            {
                if (file_exists(ProductList::IMAGE_PATH.$old_image)) {
                    unlink(ProductList::IMAGE_PATH.$old_image);
                }
            }

            $product->delete();
        }


        $details = ProductDetails::where('product_id',$product->id)->first();
            $old_image_one = $details->image_one;
            $old_image_two = $details->image_two;
            $old_image_three = $details->image_three;
            $old_image_four = $details->image_four;





                if (!empty($old_image_one)) {
                    if (file_exists(ProductList::IMAGE_PATH.$old_image_one))
                    {
                    unlink(public_path(ProductList::IMAGE_PATH.$old_image_one));
                    }
                }
                if (!empty($old_image_two)) {
                    if (file_exists(ProductList::IMAGE_PATH.$old_image_two)) {
                        unlink(public_path(ProductList::IMAGE_PATH.$old_image_two));
                    }
                }
                if (!empty($old_image_three)) {
                    if (file_exists(ProductList::IMAGE_PATH.$old_image_three)) {
                        unlink(public_path(ProductList::IMAGE_PATH.$old_image_three));
                    }
                }
                if (!empty($old_image_four)) {
                    if (file_exists(ProductList::IMAGE_PATH.$old_image_four)) {
                        unlink(public_path(ProductList::IMAGE_PATH.$old_image_four));
                    }
                }
                $details->delete();

            $notification = array(
                'message' => 'Product Inserted Successfully',
                'alert-type' => 'success'
            );
    
            return redirect()->route('all.product')->with($notification);
        
    }


}
