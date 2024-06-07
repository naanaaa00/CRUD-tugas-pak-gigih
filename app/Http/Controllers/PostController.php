<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Create a new post.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        $attrs = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
        ]);

        $post = Post::create([
            'title' => $attrs['title'],
            'description' => $attrs['description'],
            'user_id' => Auth::id(),
        ]);

        return response()->json([
            'message' => 'Post Created',
            'post' => $post
        ], 201); 
    }

    /**
     * Get all posts.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function all()
    {
        $posts = Post::orderBy('created_at', 'desc')->get();

        return response()->json([
            'posts' => $posts
        ], 200); 
    }

    /**
     * Get a specific post by id.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $post = Post::find($id);

        if (!$post) {
            return response()->json([
                'message' => 'Post Not Found'
            ], 404);
        }

        return response()->json([
            'post' => $post
        ], 200);
    }

    /**
     * Edit a post.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(Request $request, $id)
    {
        $post = Post::find($id);

        if (!$post) {
            return response()->json([
                'message' => 'Post Not Found'
            ], 404);
        }

        $attrs = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
        ]);

        $post->update([
            'title' => $attrs['title'],
            'description' => $attrs['description']
        ]);

        return response()->json([
            'message' => 'Post Updated',
            'post' => $post
        ], 200); 
    }

    /**
     * Delete a post.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        $post = Post::find($id);

        if (!$post) {
            return response()->json([
                'message' => 'Post Not Found'
            ], 404);
        }

        $post->delete();

        return response()->json([
            'message' => 'Post Deleted',
        ], 200); 
    }
}
