<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    function __construct()
    {
        ;
    }

    function index(Request $request) {
        $customers = Customer::all();
        if ($customers && count($customers) > 0) {
            foreach ($customers as $item) {
                $item->fullname = $item->first_name ?? '';
                $item->fullname .= ' ' . $item->last_name ?? '';
            }
        }
        
        $data = ['customers'];
        // view
        return view('customers.index', compact($data))->render();
    }
    function create(Request $request) {
        
        $data = [];
        // view
        return view('customers.create', compact($data))->render();
    }
    function update(Request $request,$id) {
        $customer = Customer::find(intval($id));

        $data = ['customer'];
        // view
        return view('customers.update', compact($data))->render();
    }
}
