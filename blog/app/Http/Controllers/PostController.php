<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Post;
use App\Models\File;
use Auth;

class PostController extends Controller
{
    public function home($lang = 'eng') {
        $post = Post::orderBy('created_at', 'DESC')->limit(10)->get();
        $data = [
            'posts' => $post,
            'lang' => $lang
        ];
        return view('home', $data);
    }
    public function create(Request $request) {
        $request->validate([
            'title_rus' => 'required|max:50',
            'message_rus' => 'required|max:1000',
            'title_eng' => 'required|max:50',
            'message_eng' => 'required|max:1000',
        ]);

        $post = new Post();
        $post->title_eng = $request->title_eng;
        $post->message_eng = htmlspecialchars($request->message_eng, ENT_QUOTES);
        $post->title_rus = $request->title_rus;
        $post->message_rus = htmlspecialchars($request->message_rus, ENT_QUOTES);
        $post->code = $request->code;
        $post->name = "Vladyslav";
        $post->surname = "Firstenko";
        if ($request->hasFile('image')) {
            //  Let's do everything here
            if ($request->file('image')->isValid()) {
                //
                $request->validate([
                    'image' => 'mimes:jpeg,jpg,png|max:1024',
                ]);
                $extension = $request->image->extension();
                $request->image->storeAs('/public', $request->image->getClientOriginalName());
                $url = Storage::url($request->image->getClientOriginalName());
                $post->image_link = $url;
                $file = File::create([
                   'name' => $request->image->getClientOriginalName(),
                    'url' => $url,
                ]);
            }
        }
        $post->save();
        return redirect()->route('home');
    }
    public function showPost($id, $lang = 'eng') {
        $post = Post::all()->firstWhere('id', $id);
        $data = [
            'post' => $post,
            'lang' => $lang
        ];
        return view('post', $data);
    }
    public function showPostWithCode($code, $lang = 'eng') {
        $post = Post::all()->firstWhere('code', $code);
        $data = [
            'post' => $post,
            'lang' => $lang
        ];
        return view('post', $data);
    }
}

// https://fishtext.ru/img/rmbg.jpg
// https://i.pinimg.com/originals/24/3d/75/243d75cbbfa4a9f64626fcfaccb637d9.jpg