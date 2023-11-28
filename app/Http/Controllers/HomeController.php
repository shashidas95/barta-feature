<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function home()
    {
        $result = DB::table('users')
            ->select('*')
            ->addSelect('posts.*')
            ->addSelect('comments.*')
            ->leftJoin('posts', 'users.id', '=', 'posts.user_id')
            ->leftJoin('comments', 'posts.id', '=', 'comments.post_id')
            // ->where('users.id', '=', $userId)
            ->get();

            
        return view('home', compact('result'));
    }
}
