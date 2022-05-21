<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductList extends Model
{
    use HasFactory;
    protected $guarded = [];
    const IMAGE_PATH ='upload/productdetails/';

    public function categories(){
        return $this->belongsTo(Category::class,'category_id');
    }

    public function subcategories(){
        return $this->belongsTo(Subcategory::class,'subcategory_id');
    }

}

