<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    function __construct()
    {
        ;
    }
    function index() {
        
        $data = [];
        //view
        return view('home.index', compact($data))->render();
    }
}
