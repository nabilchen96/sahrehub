<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use DB;
use Auth;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    public function data()
    {
        // dd(Request('id'));

        $data = DB::table('comments as c')
            ->leftjoin('posts as p', 'p.id', '=', 'c.id_post')
            ->leftjoin('users as u', 'u.id', '=', 'c.id_user')
            ->select(
                'c.*',
                'u.name',
                'u.photo'
            )
            ->where('c.id_post', Request('id'))
            ->orderBy('c.created_at', 'ASC')
            ->get();

        return response()->json(
            $data,
            // Request('id')
        );
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'keterangan' => 'required',
            'id_post' => 'required',
        ]);

        if ($validator->fails()) {

            return response()->json([
                'responCode' => 0,
                'success' => false,
                'message' => $validator->errors(),
            ], 401);

        } else {

            Comment::create([
                'id_post' => $request->id_post,
                'id_user' => Auth::id(),
                'keterangan' => $request->keterangan
            ]);

            $post = Post::find($request->id_post);
            $post->update([
                'total_comment' => $post->total_comment + 1
            ]);

            return response()->json([
                'responCode' => 1,
                'success' => true,
                'message' => 'Post berhasil disimpan!'
            ], 200);
        }
    }

    public function delete(Request $request)
    {

        $data = Comment::find($request->id);

        $post = Post::find($data->id_post);
        $post->update([
            'total_comment' => $post->total_comment - 1
        ]);

        $data->delete();

        $data = [
            'responCode' => 1,
            'respon' => 'Data Sukses Dihapus'
        ];

        return response()->json($data);
    }
}
