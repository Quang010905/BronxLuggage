<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class ShopController extends Controller
{

    public function index()
    {
        $perPage = 6;
        $category_product = DB::table('category')->where('category_status', '1')->orderBy('category_id', 'desc')->get();
        $brand_product = DB::table('brand')->where('brand_status', '1')->orderBy('brand_id', 'desc')->get();
        $all_product = DB::table('product')->where('product_status', '1')->orderBy('product_id', 'desc')
            ->paginate($perPage);
        return view('shop/index')->with('categories', $category_product)->with('brands', $brand_product)
            ->with('products', $all_product);
    }


    public function searchByName(Request $request)
    {
        $perPage = 6;
        $category_product = DB::table('category')->where('category_status', '1')->orderBy('category_id', 'desc')->get();
        $brand_product = DB::table('brand')->where('brand_status', '1')->orderBy('brand_id', 'desc')->get();
        $name = $request->input('name');

        // Kiểm tra nếu tên tìm kiếm rỗng thì không tìm kiếm
        if (empty($name)) {
            $products = DB::table('product')
                ->where('product_status', '1')
                ->orderBy('product_id', 'desc')
                ->paginate($perPage);
        } else {
            $products = Product::join('category', 'category.category_id', '=', 'product.category_id')
                ->join('brand', 'brand.brand_id', '=', 'product.brand_id')
                ->where('product.product_name', 'like', '%' . $name . '%')
                ->select('product.*', 'category.category_name as category_name', 'brand.brand_name as brand_name')
                ->paginate($perPage);
        }

        return view('shop/index', [
            'products' => $products,
            'categories' => $category_product,
            'brands' => $brand_product,
            'name' => $name
        ]);
    }
}
