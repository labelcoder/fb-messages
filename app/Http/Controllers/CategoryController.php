<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    function __construct()
    {
        ;
    }
    function index() {
        $categories = Category::all();
        if ($categories && count($categories) > 0) {
            foreach ($categories as $item) {
                $item->product_counts = $item->products->count();
            }
        }
        
        $data = ['categories'];
        // view
        return view('categories.index', compact($data))->render();
    }
    function create(Request $request) {
        
        $data = [];
        // view
        return view('categories.create', compact($data))->render();
    }
    function update(Request $request,$id) {
        $category = Category::find(intval($id));

        $data = ['category'];
        // view
        return view('categories.update', compact($data))->render();
    }
}
