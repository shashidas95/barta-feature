<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = DB::table('users')
            ->leftJoin('posts', 'users.id', '=', 'posts.user_id')
            ->leftJoin('comments', 'users.id', '=', 'comments.user_id')
            ->select('users.*', 'posts.*', 'comments.*')
            ->get();
        // $posts = DB::table('posts')->Join('comments', 'posts.id', '=', 'comments.post_id')
        //     ->select('posts.*', 'comments.*')
        //     ->get();
        // $users = DB::table('users')->where('users.id', '=', 'posts.user_id')->where('users.id', '=', 'comments.user_id')->get();

        return view('posts', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
