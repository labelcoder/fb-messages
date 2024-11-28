<?php

namespace App\Http\Controllers;

use App\FacebookComment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MessagesController extends Controller
{
    function __construct()
    {
        
    }
    function index() {
        $fbMessages = FacebookComment::all();
        if ($fbMessages && count($fbMessages) > 0) {
            foreach ($fbMessages as $item) {
                $item->post_subject = $item->facebookpost->content;
                $item->created_time_show = Carbon::parse($item->created_time)->format('d/m/Y H:i').' น.';
            }
        }
        $data = ['fbMessages'];
        // view
        return view('messages.index', compact($data))->render();
    }
}