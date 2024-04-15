<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Like;
use App\Models\Tag;
use DB;
use Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class PostController extends Controller
{
    public function index()
    {

        return view('welcome');
    }

    public function data()
    {

        $data = DB::table('posts as p')
            ->join('users as u', 'u.id', '=', 'p.id_user')
            ->join('tags as t', 't.id_post', '=', 'p.id')
            ->leftjoin('likes as l', 'l.id_post', '=', 'p.id')
            ->leftjoin('bookmarks as b', 'b.id_post', '=', 'p.id')
            ->orderBy('p.created_at', 'DESC');

        if (Auth::id()) {

            $data = DB::table('posts as p')
                ->join('users as u', 'u.id', '=', 'p.id_user')
                ->join('tags as t', 't.id_post', '=', 'p.id')
                ->leftjoin('likes as l', 'l.id_post', '=', 'p.id')
                ->leftjoin('bookmarks as b', 'b.id_post', '=', 'p.id')
                ->orderBy('p.created_at', 'DESC')
                ->select(
                    DB::raw('MAX(p.id) as id'),
                    DB::raw('MAX(p.id_user) as id_user'),
                    DB::raw('MAX(p.keterangan) as keterangan'),
                    DB::raw('MAX(p.created_at) as created_at'),
                    DB::raw('MAX(p.media) as media'),
                    DB::raw('MAX(p.total_like) as total_like'),
                    DB::raw('MAX(p.total_comment) as total_comment'),

                    DB::raw('MAX(u.name) as name'),
                    DB::raw('MAX(u.photo) as photo'),

                    DB::raw('MAX(t.tag) as tag'),

                    DB::raw('(SELECT id_user FROM likes WHERE id_post = p.id AND id_user = ' . Auth::id() . ' LIMIT 1) as id_user_like'),
                    DB::raw('(SELECT id_user FROM bookmarks WHERE id_post = p.id AND id_user = ' . Auth::id() . ' LIMIT 1) as id_user_bookmark')

                )
                ->orderBy('p.created_at', 'DESC')
                ->groupBy('p.id')
                ->paginate(5);

        } else {

            $data = $data
                ->select(
                    DB::raw('MAX(p.id) as id'),
                    DB::raw('MAX(p.id_user) as id_user'),
                    DB::raw('MAX(p.keterangan) as keterangan'),
                    DB::raw('MAX(p.created_at) as created_at'),
                    DB::raw('MAX(p.media) as media'),
                    DB::raw('MAX(p.total_like) as total_like'),
                    DB::raw('MAX(p.total_comment) as total_comment'),

                    DB::raw('MAX(u.name) as name'),
                    DB::raw('MAX(u.photo) as photo'),

                    DB::raw('MAX(t.tag) as tag'),

                )
                ->orderBy('p.created_at', 'DESC')
                ->groupBy('p.id')
                ->paginate(5);
        }

        return response()->json(
            $data
        );
    }
    public function dataPopular()
    {
        // Ambil semua teks dari tabel
        $texts = DB::table('tags')->get();

        // Inisialisasi array untuk menyimpan total kemunculan setiap tag
        $totalTags = [];

        // Loop melalui setiap teks
        foreach ($texts as $text) {
            // Pisahkan teks menjadi tag-tag individu
            $tags = explode(', ', $text->tag);

            // Loop melalui setiap tag
            foreach ($tags as $tag) {
                // Jika tag sudah ada dalam array totalTags, tambahkan 1 ke nilai totalnya
                // Jika tag belum ada dalam array totalTags, inisialisasi nilai totalnya menjadi 1
                $totalTags[$tag] = isset($totalTags[$tag]) ? $totalTags[$tag] + 1 : 1;
            }
        }

        // Urutkan array output berdasarkan total kemunculan tag terbanyak
        uasort($totalTags, function ($a, $b) {
            return $b - $a;
        });

        // Format output sesuai keinginan
        $output = [];
        foreach ($totalTags as $tag => $total) {
            $output[] = [
                'tag' => $tag,
                'total' => $total
            ];
        }

        return response()->json(
            $output
        );
    }

    public function create()
    {
        return view('create-post');
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'media' => 'required|mimes:jpeg,png,mp4',
            'keterangan' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'responCode' => 0,
                'success' => false,
                'message' => $validator->errors(),
            ], 401);
        } else {

            if ($request->media) {
                $media = time() . '.' . $request->media->extension();
                $request->media->move(public_path('media'), $media);
            }

            $new_uuid = Str::uuid(); // Menyimpan UUID yang dihasilkan
            $post = new Post();
            $post->id = $new_uuid; // Menggunakan UUID untuk id
            $post->media = $media ?? '';
            $post->keterangan = $request->keterangan;
            $post->id_user = Auth::id();
            $post->total_like = 0;
            $post->total_comment = 0;
            $post->save();

            // Ambil data tagar dari request dan ubah menjadi array
            $tagar = json_decode($request->tagar, true);

            // Hapus karakter 'X' dari setiap string dalam array tagar dan tambahkan tanda '#'
            $tagar = array_map(function ($tag) {
                return str_replace('X', '', $tag);
            }, $tagar);

            // Gabungkan elemen-elemen array menjadi string dengan tanda koma sebagai pemisah
            $tagar = implode(', ', $tagar);

            Tag::create([
                'id_post' => $new_uuid,
                'id_user' => Auth::id() ?? 1,
                'tag' => $tagar
            ]);

            return response()->json([
                'responCode' => 1,
                'success' => true,
                'message' => 'Post berhasil disimpan!'
            ], 200);
        }
    }

    public function detail()
    {


        $data = DB::table('posts as p')
            ->join('users as u', 'u.id', '=', 'p.id_user')
            ->join('tags as t', 't.id_post', '=', 'p.id')
            ->select(
                'p.*',
                't.tag',
                'u.name',
                'u.photo',
            )
            ->where('p.id', Request('id'))
            ->first();

        // dd($data);

        return view('detail-post', [
            'data' => $data
        ]);
    }

    public function like(Request $request)
    {
        //GET DATA POST
        $post = Post::where('id', $request->id)->first();

        //GET DATA LIKE
        $like = Like::where('id_user', Auth::id())->where('id_post', $request->id)->first();

        if ($like) {
            //DELETE DATA COMMENT JIKA SUDAH ADA
            $like->delete();

            //KURANGI TOTAL LIKE JIKA SUDAH ADA
            $post->update([
                'total_like' => $post->total_like - 1
            ]);
        } else {

            //TAMBAH DATA COMMENT JIKA BELUM ADA
            Like::create([
                'id_user' => Auth::id(),
                'id_post' => $request->id,
            ]);

            //TAMBAH DATA TOTAL LIKE JIKA BELUM ADA
            $post->update([
                'total_like' => $post->total_like + 1
            ]);
        }


        return response()->json([
            'responCode' => 1,
            'success' => true,
            'message' => $post,
            'id' => $request->id
        ], 200);

    }

    public function bookmark(Request $request)
    {
        //GET DATA POST
        $post = Post::where('id', $request->id)->first();

        //GET DATA BOOMARK
        $bookmark = Bookmark::where('id_user', Auth::id())->where('id_post', $request->id)->first();

        if ($bookmark) {

            //DELETE DATA BOOKMARK JIKA SUDAH ADA
            $bookmark->delete();

        } else {

            //TAMBAH DATA BOOKMARK JIKA BELUM ADA
            Bookmark::create([
                'id_user' => Auth::id(),
                'id_post' => $request->id,
            ]);
        }


        return response()->json([
            'responCode' => 1,
            'success' => true,
            'message' => $post,
            'id' => $request->id
        ], 200);

    }
}
