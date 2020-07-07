<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Post;

class UserController extends Controller
{
    /**
     * Instantiate a new UserController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Get the authenticated User.
     *
     * @return Response
     */
    public function profile()
    {
        return response()->json(['user' => Auth::user()], 200);
    }

    /**
     * Get all User.
     *
     * @return Response
     */
    public function allUsers()
    {
        return response()->json(['users' =>  User::all()], 200);
    }

    /**
     * Get one user.
     *
     * @return Response
     */
    public function singleUser($id)
    {
        try {
            $user = User::findOrFail($id);

            return response()->json(['user' => $user], 200);
        } catch (\Exception $e) {

            return response()->json(['message' => 'user not found!'], 404);
        }
    }



    /**
     * Update one user.
     *
     * @return Response
     */
    public function updateUser($id, Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|string',
        ]);

        try {
            $user = User::find($id);
            $user->name = $request->input('name');
            $user->email = $request->input('email');

            $user->save();

            return response()->json(['user' => $user, 'message' => 'Updated'], 201);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'User Update Failed!'], 409);
        }
    }

    /**
     * Delete one user.
     *
     * @return Response
     */
    public function deleteUser($id)
    {
        try {
            $user = User::find($id);
            $user->delete();

            return response()->json(['message' => 'User Deleted'], 201);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'User Delete Failed!'], 409);
        }
    }


    /**
     * Add one post.
     *
     * @return Response
     */
    public function addPost($id, Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
            'judul' => 'required|string',
            'isi' => 'required|string',
        ]);

        try {
            $post = new Post;
            $post->id_users = $id;
            $post->judul = $request->input('judul');
            $post->isi = $request->input('isi');

            $post->save();

            return response()->json(['message' => 'Add Post Success!'], 201);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Add Post Failed!'], 409);
        }
    }

    /**
     * Show user's all post
     *
     * @return Response
     */
    public function userPost($id, Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
            'judul' => 'required|string',
            'isi' => 'required|string',
        ]);

        try {
            $post = new Post;
            $post->id_users = $id;
            $post->judul = $request->input('judul');
            $post->isi = $request->input('isi');

            $post->save();

            return response()->json(['message' => 'Add Post Success!'], 201);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Add Post Failed!'], 409);
        }
    }

    /**
     * Get total Posts/Users.
     *
     * @return Response
     */
    public function totalPost()
    {
        $posts = Post::select(Post::raw('users.name, count(posts.judul) as total'))
            ->join('users', 'users.id', '=', 'posts.id_users')
            ->groupBy('posts.id_users')->get();
        return response()->json(['posts' =>  $posts], 200);
    }

    /**
     * Get all Posts.
     *
     * @return Response
     */
    public function allPost()
    {
        $posts = User::join('posts', 'users.id', '=', 'posts.id_users')
            ->select('users.id as id_user', 'posts.id as id_post', 'users.name', 'posts.judul', 'posts.isi')
            ->orderBy('users.id')->get();
        return response()->json(['Posts' =>  $posts], 200);
        // return response()->json(['Posts' =>  Post::all()], 200);
    }
}
