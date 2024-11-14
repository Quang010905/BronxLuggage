<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    //lay ngau nhien moi category 1 san pham
    public function index()
    {
        $categories = Category::orderBy('category_id')->take(3)->get();
        $productsByCategory = Product::all()->groupBy('category_id');
        $products = collect();

        foreach ($productsByCategory as $categoryProducts) {
            $product = $categoryProducts->random();
            $products->push($product);
        }
        return view('home/index', compact('products', 'categories'));
    }
}
