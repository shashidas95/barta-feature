<?php

namespace App\Http\Controllers;

use App\Helpers\PostHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PostStoreRequest;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\PostUpdateRequest;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // $result = DB::table('users as u')
        // ->join('posts as p', 'u.id', '=', 'p.user_id')
        // ->leftJoin('comments as c', 'p.id', '=', 'c.post_id')
        // ->select('u.*', 'p.*', 'c.*')
        // ->get();

        $result = DB::table('users')
            ->select('*')
            ->addSelect('posts.*')
            ->addSelect('comments.*')
            ->leftJoin('posts', 'users.id', '=', 'posts.user_id')
            ->leftJoin('comments', 'users.id', '=', 'comments.user_id')
            // ->where('users.id', '=', $userId)
            ->get();
            // dd($result);
        return view('post.posts', compact('result'));


    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = DB::table("users")->get();
        $posts = DB::table("posts")->get();
        return view("post.create", compact("users", "posts"));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(PostStoreRequest $request)
    {
        $validated = $request->validated();
        $imageName = time() . '.' . $request->photo_path->extension();
        $request->photo_path->move(public_path('images'), $imageName);
        try {
            DB::table("posts")->insert([
                'user_id' => $validated["user_id"],
                'photo_path' => $imageName,
                'content' => $validated['content'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
            return redirect()->route('post.show')->with('success', 'The post is created successfully');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(Request $request, $post)
    {
        $post = DB::table('posts')->where('id', $request->id)->first();
        // $user =null;
        if ($post) {
            $user = DB::table('users')->where('id', $post->user_id)->first();
        }
        return view("post.single-post", compact(['user', 'post']));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($post)
    {
        $user = Auth::user();
        //retrive post accoding to id
        $post = DB::table('posts')->find($post);
        // Check if the post exists
        if (!$post) {
            return redirect()->back()->with('error', 'Post not found');
        }
        return view('post.edit', compact('post', 'user'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(PostUpdateRequest $request, string $post)
    {
        $validated = $request->validated();
        $user = Auth::user();
        try {
            // Handle image upload
            if ($request->hasFile('photo_path')) {
                // Delete the old image if it exists
                if ($user->photo_path) {
                    Storage::delete('./images/' . $user->photo_path);
                }
                // Upload the new image
                $imageName = time() . '.' . $request->photo_path->extension();
                $request->photo_path->move(public_path('images'), $imageName);
            } else {
                // If no new image is uploaded, use the existing one
                $imageName = $user->photo_path;
            }
            // Update the post
            DB::table("posts")->where('user_id', $user->id)->update([
                'user_id' => $validated["user_id"],
                'photo_path' => $imageName,
                'content' => $validated['content'],
                'updated_at' => now()
            ]);
            return redirect()->route('post.show')->with('success', 'The post is updated successfully');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $post)
    {
        // Retrieve the post by ID
        $post = DB::table('posts')->where('id', $post)->first();
        // Check if the post exists
        if ($post) {
            // Delete the associated image
            if ($post->photo_path) {
                Storage::disk('public')->delete('images/' . basename($post->photo_path));
            }
            // Delete the post from the database
            DB::table('posts')->where('id', $post)->delete();
            return redirect()->route('post.show')->with('success', 'Post deleted successfully');
        } else {
            return redirect()->route('post.show')->with('error', 'Post not found');
        }
    }
}
