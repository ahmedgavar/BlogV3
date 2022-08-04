<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostImagesRequest;
use App\Http\Requests\StorePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class UserPostController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:sanctum', ['except' => ['index', 'search', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return PostResource::collection(Post::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(
        StorePostRequest $request,
        StorePostImagesRequest $request2
    ) {
        //
        $post = Post::create($request->validated());
        if ($request2->hasFile('images')) {
            $file = $request2->file('images');
            if ($file->isValid()) {
                $path = $file->store('/', ['disk' => 'public']);
            }
        }
        $post_images = $request2->file('images');
        return new PostResource($post);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //

        $post = Post::find($id);
        if (!$post) {
            return response()->json(['message' => 'Post Not Found'], 401);
        }
        $post = $post->load('comments', 'images');
        return new PostResource($post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StorePostRequest $request, $id)
    {
        //

        $post = Post::find($id);
        if (!$post) {
            return response()->json(['message' => 'Post Not Found'], 401);
        }
        $post->update($request->validated());
        return new PostResource($post);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $post = Post::destroy($id);
        return $post;
    }

    /**
     * search for specified post title.
     *
     * @param  string  $title
     * @return \Illuminate\Http\Response
     */
    public function search($title)
    {
        //
        $post = Post::where('title', 'like', '%' . $title . '%')->get();

        return $post;

    }
}
