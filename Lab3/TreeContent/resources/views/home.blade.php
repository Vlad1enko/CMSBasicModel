<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Blog</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;400;700&display=swap" rel="stylesheet">
        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('app.css')}}">
    </head>
    <body class="antialiased">
        <div class="container">
            <div id="hero__image">
                <div id="hero__wrapper">
                    @if ($lang == 'rus')
                        <p>Привет!</p>
                        <p>Меня зовут <strong>Фирстенко Владислав</strong></p>
                        <p>И это мой блог...</p> 
                    @else
                        <p>Hello!</p>
                        <p>My name is <strong>Vladyslav Firstenko</strong></p>
                        <p>And that's my blog...</p> 
                    @endif
                </div>
            </div>
            <div id="posts-wrapper">
                <div id="posts">
                    <div id="posts__title">
                        @if ($lang == 'rus')
                            <h1>Лента постов:</h1>
                            <a href="{{route('index', ['parent' => $parent, 'lang' => 'eng'])}}" id="lang-button"><h3>Eng</h3></a>
                            <a href="{{route('admin', ['lang' => $lang])}}" id="admin-button"><h3>Админ</h3></a>
                            <div>
                                <form method="POST" action="{{route('changeOrder', ['lang' => $lang])}}">
                                    {{ csrf_field() }}
                                    <select name="parent" id="parent">
                                        <option value="{{$parent['id']}}"> {{$parent->preorderTraversal($parent, $parent->title_rus, $lang)}}</option>
                                        @foreach ($pages as $page)
                                            <option value="{{ $page['id'] }}">{{ $page->preorderTraversal($page, $page->title_rus, $lang) }}</option>
                                        @endforeach
                                    </select>
                                    <select name="order_type" id="order_type">
                                        @foreach ($sortListRus as $item)
                                            {!! $item !!}
                                        @endforeach
                                    </select>
                                    <select name="view_type" id="view_type">
                                        @if ($parent->view_type == 'list')
                                            <option value="list">List</option>
                                            <option value="tiles">Tiles</option>
                                        @else
                                            <option value="tiles">Tiles</option>
                                            <option value="list">List</option>
                                        @endif
                                    </select>
                                    <button type="submit">Enable filter</button>
                                </form>
                            </div>
                        @else
                            <h1>Posts line:</h1>
                            <a href="{{route('index', ['parent' => $parent, 'lang' => 'rus'])}}" id="lang-button"><h3>Rus</h3></a>
                            <a href="{{route('admin', ['lang' => $lang])}}" id="admin-button"><h3>Admin</h3></a>
                            <div>
                                <form method="POST" action="{{route('changeOrder', ['lang' => $lang])}}">
                                    {{ csrf_field() }}
                                    <select name="parent" id="parent">
                                        <option value="{{$parent['id']}}"> {{$parent->preorderTraversal($parent, $parent->title_eng, $lang)}}</option>
                                        @foreach ($pages as $page)
                                            <option value="{{ $page['id'] }}">{{ $page->preorderTraversal($page, $page->title_eng, $lang) }}</option>
                                        @endforeach
                                    </select>
                                    <select name="order_type" id="order_type">
                                        @foreach ($sortListEng as $item)
                                            {!! $item !!}
                                        @endforeach
                                    </select>
                                    <select name="view_type" id="view_type">
                                        @if ($parent->view_type == 'list')
                                            <option value="list">List</option>
                                            <option value="tiles">Tiles</option>
                                        @else
                                            <option value="tiles">Tiles</option>
                                            <option value="list">List</option>
                                        @endif
                                    </select>
                                    <button type="submit">Enable filter</button>
                                </form>
                            </div>
                        @endif
                    </div>
                    <hr>
                    <div id="posts-line">
                        @if ($parent->view_type == 'list')
                            @foreach ($filteredPages as $page)
                                <div class="publication">
                                    <a href="{{route('show', ['id' => $page->id, 'lang' => $lang])}}">
                                    @if ($lang == 'rus')
                                        <div id="post-top">
                                            <h3>{{$page['title_rus']}}</h3>
                                            <p id="post-time">{{$page['created_at']}}</p> {{-- timezone --}}
                                        </div>
                                        {!!Str::limit($page['message_rus'], 150, '...')!!}
                                    @else
                                        <div id="post-top">
                                            <h3>{{$page['title_eng']}}</h3>
                                            <p id="post-time">{{$page['created_at']}}</p> {{-- timezone --}}
                                        </div>
                                        {!!Str::limit($page['message_eng'], 150, '...')!!}
                                    @endif
                                    @if ($page['image_link'])
                                        <img src="{{$page['image_link']}}" class="post__image">
                                    @endif
                                    </a>
                                </div>
                                <hr class="post-divider">
                            @endforeach
                        @else
                            <div class="view_list">
                                @foreach ($filteredPages as $page)
                                    <div class="publication tiles">
                                        <a href="{{route('show', ['id' => $page->id, 'lang' => $lang])}}">
                                        @if ($lang == 'rus')
                                            <div id="post-top">
                                                <h3>{{$page['title_rus']}}</h3>
                                                <p id="post-time">{{$page['created_at']}}</p> {{-- timezone --}}
                                            </div>
                                            {!!Str::limit($page['message_rus'], 150, '...')!!}
                                        @else
                                            <div id="post-top">
                                                <h3>{{$page['title_eng']}}</h3>
                                                <p id="post-time">{{$page['created_at']}}</p> {{-- timezone --}}
                                            </div>
                                            {!!Str::limit($page['message_eng'], 150, '...')!!}
                                        @endif
                                        @if ($page['image_link'])
                                            <img src="{{$page['image_link']}}" class="post__image">
                                        @endif
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    <ul>
                    @foreach ($parent->child_pages as $item)
                        @if ($parent->id != $item->id)
                            <li>{{$item->title_eng}}
                                <ul>
                                    @foreach ($item->child_pages as $child_item)
                                        <li>{{$child_item->title_eng}}</li>
                                    @endforeach
                                </ul>
                            </li>
                        @endif
                    @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </body>
</html>
