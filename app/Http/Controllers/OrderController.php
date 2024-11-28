<?php

namespace App\Http\Controllers;

use App\Order;
use App\Product;
use App\Customer;
use App\ProductPromotion;
use App\Promotion;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    function __construct()
    {
        ;
    }
    function index() {
        $orders = Order::all();
        if ($orders && count($orders) > 0) {
            foreach ($orders as $item) {
                $item->customer_name = $item->customer->first_name.' '.$item->customer->last_name;
                $item->total_qty = $item->orderitems->sum('quantity');
            }
        }
        $data = ['orders'];
        // view
        return view('orders.index', compact($data))->render();
    }
    function create(Request $request) {
        $customers = Customer::getItems();
        $products = Product::all();
        
        $data = ['customers', 'products'];
        // view
        return view('orders.create', compact($data))->render();
    }
}
