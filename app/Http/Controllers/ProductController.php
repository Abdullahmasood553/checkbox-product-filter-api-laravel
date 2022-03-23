<?php

namespace App\Http\Controllers;
use App\Models\Product;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function products() {
        $products = Product::select('id', 'product_name')->get();
        if(!empty($products)) {
            return response()->json(
                ["products" => $products,
                  "message" => "Products Loaded Successfully",
                  "status" => 200   
                ]
             );
        } else {
            return response()->json(['message' => 'Product is not available']);
        }
    }


    public function fetchMultipleProducts(Request $request) {
        if($request->isMethod('post')) {
            $data = $request->input();
            foreach($data as $key => $value) {
                $items = Product::join('product_sub_categories', 'products.id', '=', 'product_sub_categories.product_id')->whereIn('products.id', $data['selected_categories'])->get(['product_sub_categories.id', 'product_sub_categories.title', 'product_sub_categories.description', 'product_sub_categories.price']);
            }
            $result = json_encode($items, true);
            return $result;
        }
    }
}
