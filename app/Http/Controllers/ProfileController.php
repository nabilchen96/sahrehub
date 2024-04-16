<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Models\Tag;
use DB;
use Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;


class ProfileController extends Controller
{
    public function index()
    {

        if (Request('id')) {

            return view('profile');
            
        } else {

            return redirect('/');
        }
    }

    public function dataProfile()
    {

        $id = Request('id');

        if ($id) {

            $data = DB::table('users')
                ->select(
                    'id',
                    'name',
                    'email',
                    'photo',
                    'created_at',
                    'keterangan',
                    'website'
                )
                ->where('id', $id)->first();

            return response()->json($data);

        }
    }

    public function dataProfilePost(){
        
        $data = DB::table('posts as p')
                ->join('tags as t', 't.id_post', '=', 'p.id')
                ->select(
                    'p.*',
                    't.tag'
                )
                ->where('p.id_user', Request('id'))
                ->orderBy('p.created_at', 'DESC')
                ->paginate(18);

        return response()->json(
            $data
        );
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'photo' => 'image',
            'id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'responCode' => 0,
                'success' => false,
                'message' => $validator->errors(),
            ], 401);
        } else {

            if ($request->photo) {
                $photo = time() . '.' . $request->photo->extension();
                $request->photo->move(public_path('profile'), $photo);
            }

            $user = User::find($request->id);
            $user = $user->update([
                'name' => $request->name,
                'password' => $request->password ? Hash::make($request->password) : $user->password,
                'photo' => $photo ?? $user->photo,
                'keterangan' => $request->keterangan, 
                'website' => $request->website
            ]);

            return response()->json($data = [
                'responCode' => 1,
                'respon' => 'Data Sukses Diupdate'
            ]);

        }
    }
}
