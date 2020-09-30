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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($lang = 'eng')
    {
        $post = Post::orderBy('created_at', 'DESC')->limit(10)->get();
        $data = [
            'posts' => $post,
            'lang' => $lang
        ];
        return view('home', $data);
    }

    public function admin($lang = 'eng') {
        $post = Post::orderBy('created_at', 'DESC')->get();
        $data = [
            'posts' => $post,
            'lang' => $lang
        ];
        return view('admin', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title_rus' => 'required|max:50',
            'message_rus' => 'required|max:1000',
            'title_eng' => 'required|max:50',
            'message_eng' => 'required|max:1000',
        ]);

        $post = new Post();
        $post->title_eng = $request->title_eng;
        $post->message_eng = $request->message_eng;
        $post->title_rus = $request->title_rus;
        $post->message_rus = $request->message_rus;
        $post->code = $request->code;
        $post->name = "Vladyslav";
        $post->surname = "Firstenko";
        if ($request->hasFile('image')) {
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
        return redirect()->route('admin')->with('status','Post is created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $lang = 'eng')
    {
        $post = Post::all()->firstWhere('id', $id);
        $data = [
            'post' => $post,
            'lang' => $lang
        ];
        return view('post', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $lang = 'eng')
    {
        $post = Post::all()->firstWhere('id', $id);
        $data = [
            'post' => $post,
            'lang' => $lang
        ];
        return view('update', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title_rus' => 'required|max:50',
            'message_rus' => 'required|max:1000',
            'title_eng' => 'required|max:50',
            'message_eng' => 'required|max:1000',
        ]);
        $post = Post::all()->firstWhere('id', $id);
        $post->title_eng = $request->title_eng;
        $post->message_eng = $request->message_eng;
        $post->title_rus = $request->title_rus;
        $post->message_rus = $request->message_rus;
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
        return redirect()->route('show', [$post->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $res = Post::where('id',$id)->delete();
        if ($res){
            $msg = 'Deletion success';
        } else {
            $msg = 'Deletion failed';
        }
        return redirect('admin')->with('status', $msg );
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
