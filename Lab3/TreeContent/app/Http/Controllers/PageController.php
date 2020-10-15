<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Page;
use App\Models\File;
use Auth;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($parent = 1, $lang = 'eng' )
    {
        
        $allPages = Page::all();
        if ( $parent == 1) {
            $pages = $allPages->where('id', '!=', 1);
        }  else {
            $pages = $allPages->where('id', '!=', 1)->where('parent_id', '=', $parent);
        }
        $parentPage = Page::find($parent);
        $allPages = $allPages->forget($parent-1);

        $sortListEng = collect([
            "<option value=\"date_desc\">Date descending</option>", "<option value=\"date_asc\">Date ascending</option>", "<option value=\"order_num_desc\">OrderNum descending</option>", "<option value=\"order_num_asc\">OrderNum ascending</option>"
        ]);
        $sortListRus = collect([
            "<option value=\"date_desc\">Сначала новые</option>", "<option value=\"date_asc\">Сначала старые</option>", "<option value=\"order_num_desc\">Убывающий пользовательский порядок</option>", "<option value=\"order_num_asc\">Возрастающий пользовательский порядок</option>"
        ]);
        
        switch ($parentPage->order_type) {
            case 'date_desc':
                $pages = $pages->sortByDesc('created_at');
                break;
            case 'date_asc':
                $pages = $pages->sortBy('created_at');
                $sortListEng->prepend($sortListEng->pull(1));
                $sortListRus->prepend($sortListRus->pull(1));
                break;
            case 'order_num_desc':
                $pages = $pages->sortByDesc('order');
                $sortListEng->prepend($sortListEng->pull(2));
                $sortListRus->prepend($sortListRus->pull(2));
                break;
            case 'order_num_asc':
                $pages = $pages->sortBy('order');
                $sortListEng->prepend($sortListEng->pull(3));
                $sortListRus->prepend($sortListRus->pull(3));
                break;
            default:
                # code...
                break;
        }

        $data = [
            'pages' => $allPages,
            'filteredPages' => $pages,
            'parent' => $parentPage,
            'sortListEng' => $sortListEng,
            'sortListRus' => $sortListRus,
            'lang' => $lang
        ];
        return view('home', $data);
    }

    public function changeOrder(Request $request, $lang = 'eng') {
        $page = Page::find($request->parent);
        $page->order_type = $request->order_type;
        $page->view_type = $request->view_type;
        $page->save();
        return redirect()->route('index', ['lang' => $lang, 'parent' => $request->parent]);
    }

    public function changeAdminOrder(Request $request, $lang = 'eng') {
        $page = Page::find(1);
        $page->order_type = $request->order_type;
        $page->save();
        return redirect()->route('admin', ['lang' => $lang]);
    }

    public function admin($lang = 'eng') {
        $pages = Page::all()->where('id', '!=', 1);
        $parentPage = Page::find(1);

        $sortListEng = collect([
            "<option value=\"date_desc\">Date descending</option>", "<option value=\"date_asc\">Date ascending</option>", "<option value=\"order_num_desc\">OrderNum descending</option>", "<option value=\"order_num_asc\">OrderNum ascending</option>"
        ]);
        $sortListRus = collect([
            "<option value=\"date_desc\">Сначала новые</option>", "<option value=\"date_asc\">Сначала старые</option>", "<option value=\"order_num_desc\">Убывающий пользовательский порядок</option>", "<option value=\"order_num_asc\">Возрастающий пользовательский порядок</option>"
        ]);
        
        switch ($parentPage->order_type) {
            case 'date_desc':
                $pages = $pages->sortByDesc('created_at');
                break;
            case 'date_asc':
                $pages = $pages->sortBy('created_at');
                $sortListEng->prepend($sortListEng->pull(1));
                $sortListRus->prepend($sortListRus->pull(1));
                break;
            case 'order_num_desc':
                $pages = $pages->sortByDesc('order');
                $sortListEng->prepend($sortListEng->pull(2));
                $sortListRus->prepend($sortListRus->pull(2));
                break;
            case 'order_num_asc':
                $pages = $pages->sortBy('order');
                $sortListEng->prepend($sortListEng->pull(3));
                $sortListRus->prepend($sortListRus->pull(3));
                break;
            default:
                # code...
                break;
        }

        $data = [
            'pages' => $pages,
            'sortListEng' => $sortListEng,
            'sortListRus' => $sortListRus,
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

        $page = new Page();
        $page->title_eng = $request->title_eng;
        $page->message_eng = $request->message_eng;
        $page->title_rus = $request->title_rus;
        $page->message_rus = $request->message_rus;
        $page->code = $request->code;
        $page->parent_id = $request->parent;
        $page->order = $request->order;
        $page->name = "Vladyslav";
        $page->surname = "Firstenko";
        if ($request->hasFile('image')) {
            if ($request->file('image')->isValid()) {
                //
                $request->validate([
                    'image' => 'mimes:jpeg,jpg,png|max:1024',
                ]);
                $extension = $request->image->extension();
                $request->image->storeAs('/public', $request->image->getClientOriginalName());
                $url = Storage::url($request->image->getClientOriginalName());
                $page->image_link = $url;
                $file = File::create([
                   'name' => $request->image->getClientOriginalName(),
                    'url' => $url,
                ]);
            }
        }
        $page->save();
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
        $page = Page::all()->firstWhere('id', $id);
        $data = [
            'page' => $page,
            'lang' => $lang
        ];
        return view('page', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $lang = 'eng')
    {
        $page = Page::all()->firstWhere('id', $id);
        $data = [
            'page' => $page,
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
        $page = Page::all()->firstWhere('id', $id);
        $page->title_eng = $request->title_eng;
        $page->message_eng = $request->message_eng;
        $page->title_rus = $request->title_rus;
        $page->message_rus = $request->message_rus;
        $page->code = $request->code;
        $page->name = "Vladyslav";
        $page->surname = "Firstenko";
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
                $page->image_link = $url;
                $file = File::create([
                   'name' => $request->image->getClientOriginalName(),
                    'url' => $url,
                ]);
            }
        }
        $page->save();
        return redirect()->route('show', [$page->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $res = Page::where('id',$id)->delete();
        if ($res){
            $msg = 'Deletion success';
        } else {
            $msg = 'Deletion failed';
        }
        return redirect('admin')->with('status', $msg );
    }

    public function showPageWithCode($code, $lang = 'eng') {
        $page = Page::all()->firstWhere('code', $code);
        $data = [
            'page' => $page,
            'lang' => $lang
        ];
        return view('page', $data);
    }
}
