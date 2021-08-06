<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index() {
       $posts = Post::latest()->with(['user', 'likes'])->paginate(20); // Laravel Collection and with make query more efficient
//        $posts = Post::latest()->paginate(20);
//        dd($posts);

        return view('posts.index', ['posts' => $posts]);
    }

    public function store(Request $request) {

        $this->validate($request,
            ['body' => 'required'],
            ['body.required' => 'Sorry you need to fill in the body of this post']
        );

        if (Auth::user() == null) {
            return redirect()->back()->with('not-authorized', 'You need to login to make any post');
        }

        $request->user()->posts()->create($request->only('body'));

        return redirect()->back();
    }

    public function destroy(Post $post) {

        $this->authorize('delete', $post);

        $post->delete();

        return back();
    }
}
