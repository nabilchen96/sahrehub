<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Tag;
use DB;
use Auth;

class EksplorController extends Controller
{
    public function index()
    {
        return view('eksplor');
    }

    public function data()
    {

        $q = explode(' ', Request('q'));
        $data = DB::table('posts as p')
            ->join('tags as t', 't.id_post', '=', 'p.id')
            ->select(
                'p.*',
                't.tag'
            );

        foreach ($q as $keyword) {
            $data = $data->orwhere('p.keterangan', 'like', '%' . $keyword . '%')
                    ->orwhere('t.tag', 'like', '%' .$keyword. '%');
        }

        $data = $data->orderByRaw('RAND()')->paginate(18);

        return response()->json(
            $data
        );
    }
}
