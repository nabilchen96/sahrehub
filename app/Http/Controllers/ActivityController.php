<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\Like;
use App\Models\Up;
use Illuminate\Http\Request;
use DB;
use Auth;
use Illuminate\Support\Facades\Validator;

class ActivityController extends Controller
{
    public function like()
    {
        return view('activity.like');
    }

    public function dataLike()
    {
        $data = DB::table('likes as l')
            ->leftJoin('posts as p', 'p.id', '=', 'l.id_post')
            ->where('l.id_user', Auth::id())
            ->paginate(10);

        return response()->json($data);
    }

    public function up()
    {
        return view('activity.up');
    }

    public function dataUp()
    {
        $data = DB::table('ups as l')
            ->leftJoin('posts as p', 'p.id', '=', 'l.id_post')
            ->where('l.id_user', Auth::id())
            ->paginate(10);

        return response()->json($data);
    }

    public function bookmark()
    {
        return view('activity.bookmark');
    }

    public function dataBookmark()
    {
        $data = DB::table('bookmarks as b')
            ->leftJoin('posts as p', 'p.id', '=', 'b.id_post')
            ->where('b.id_user', Auth::id())
            ->paginate(10);

        return response()->json($data);
    }

    public function post()
    {
        return view('activity.post');
    }

    public function dataPost()
    {
        $data = DB::table('posts as b')
            ->where('b.id_user', Auth::id())
            ->orderBy('b.created_at', 'DESC')
            ->paginate(18);

        return response()->json($data);
    }

    public function comment()
    {
        return view('activity.comment');
    }

    public function dataComment()
    {
        $data = DB::table('comments as b')
            ->leftJoin('posts as p', 'p.id', '=', 'b.id_post')
            ->where('b.id_user', Auth::id())
            ->select(
                'p.*', 
                'b.keterangan as komentar', 
                'b.created_at as waktu_komentar'
            )
            ->orderBy('b.created_at', 'DESC')
            ->paginate(10);

        return response()->json($data);
    }
}
