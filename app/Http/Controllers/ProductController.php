<?php

namespace App\Http\Controllers;

use App\Product;
use App\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    function __construct()
    {
        ;
    }

    function index(Request $request) {
        $products = Product::all();
        if ($products && count($products) > 0) {
            foreach ($products as $item) {
                $item->category_name = $item->category->name;
            }
        }
       
        $data = ['products'];
        // view
        return view('products.index', compact($data))->render();
    }
    function create(Request $request) {
        $categories = Category::all();
       
        $data = ['categories'];
        // view
        return view('products.create', compact($data))->render();
    }
    function update(Request $request, $id) {
        $categories = Category::all();
        $product = Product::find(intval($id));
       
        $data = ['categories', 'product'];
        // view
        return view('products.update', compact($data))->render();
    }

}
