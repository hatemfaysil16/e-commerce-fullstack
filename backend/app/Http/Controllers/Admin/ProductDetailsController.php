<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\ProductList;
use App\Models\ProductDetails;
use App\Models\Subcategory;

class ProductDetailsController extends Controller
{
    public function ProductDetails(Request $request){

        $id = $request->id;

        $productDetails = ProductDetails::where('product_id',$id)->get();
        $productList = ProductList::where('id',$id)->get();

        $categoryDetailsArray = [];

        foreach ($productDetails as $value) {
            $item = [
                'id'=>$value['id'],  
                "product_id"=>$value['product_id'],
                "image_one"=>asset(ProductList::IMAGE_PATH.$value['image_one']),
                "image_two"=>asset(ProductList::IMAGE_PATH.$value['image_two']),
                "image_three"=>asset(ProductList::IMAGE_PATH.$value['image_three']),
                "image_four"=>asset(ProductList::IMAGE_PATH.$value['image_four']),
                "short_description"=>$value['short_description'],
                "color"=>$value['color'],
                "size"=>$value['size'],
                "long_description"=>$value['long_description'],
                "created_at"=>$value['created_at'],
                "updated_at"=>$value['updated_at'],
            ];
            // array_push($categoryDetailsArray, $item);
        } 


        foreach ($productList as $value) {
            $category_name = Category::where('id',$value['category_id'])->first();
            $subcategory_name = Subcategory::where('id',$value['subcategory_id'])->first();

            $item2 = [
                'id'=>$value['id'],  
                "title"=>$value['title'],
                "price"=>$value['price'],
                "special_price"=>$value['special_price'],
                "image"=>asset(ProductList::IMAGE_PATH.$value['image']),
                "category_id"=>$category_name->category_name,
                "subcategory_id"=>$subcategory_name->subcategory_name,
                "remark"=>$value['remark'],
                "brand"=>$value['brand'],
                "star"=>$value['star'],
                "product_code"=>$value['product_code'],
                "created_at"=>$value['created_at'],
                "updated_at"=>$value['updated_at']
            ];
            // array_push($categoryDetailsArray, $item);
        } 


        $adel = [
            'productDetails'=>$item,
            'productList'=>$item2,
        ];

        return $adel;

    } 



}





















// class ProductDetailsController extends Controller
// {
//     public function ProductDetails(Request $request){

//         $id = $request->id;

//         $productDetails = ProductDetails::where('product_id',$id)->get();
//         $productList = ProductList::where('id',$id)->get();

//          $item = [
//                 'productDetails' => $productDetails,
//                 'productList' => $productList,                 
//             ];

//             return $item;

//     } // End Method 



// }