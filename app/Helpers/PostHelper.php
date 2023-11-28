<?php

namespace App\Helpers;



// app/Helpers/PostHelper.php

use Illuminate\Support\Facades\DB;

class PostHelper
{
    // Your helper functions

    public static function incrementPostViews($postId)
    {
        DB::table('posts')->where('id', $postId)->increment('views');
    }

    // function incrementPostLikes($postId)
    // {
    //     DB::table('posts')->where('id', $postId)->increment('likes');
    // }

    public static function incrementPostComments($postId)
    {
        DB::table('posts')->where('id', $postId)->increment('comments');
    }

    public static function addCommentToPost($postId, $userId, $content)
    {
        DB::table('comments')->insert([
            'post_id' => $postId,
            'user_id' => $userId,
            'comment_content' => $content,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public static function getPost($postId)
    {
        return DB::table('posts')->where('id', $postId)->first();
    }

    public static function getPostComments($postId)
    {
        return DB::table('comments')->where('post_id', $postId)->get();
    }
}
