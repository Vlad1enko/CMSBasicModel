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
                            <a href="{{route('index', ['lang' => 'eng'])}}" id="lang-button"><h3>Eng</h3></a>
                            <a href="{{route('admin', ['lang' => $lang])}}" id="admin-button"><h3>Админ</h3></a>
                        @else
                            <h1>Posts line:</h1>
                            <a href="{{route('index', ['lang' => 'rus'])}}" id="lang-button"><h3>Rus</h3></a>
                            <a href="{{route('admin', ['lang' => $lang])}}" id="admin-button"><h3>Admin</h3></a>
                        @endif
                    </div>
                    <hr>
                    <div id="posts-line">
                        @foreach ($posts as $post)
                            <div class="publication">
                                <a href="{{route('show', ['id' => $post->id, 'lang' => $lang])}}">
                                @if ($lang == 'rus')
                                    <div id="post-top">
                                        <h3>{{$post['title_rus']}}</h3>
                                        <p id="post-time">{{$post['created_at']->timezone('Europe/Kiev')}}</p> {{-- timezone --}}
                                    </div>
                                    {!!Str::limit($post['message_rus'], 300, '...')!!}
                                @else
                                    <div id="post-top">
                                        <h3>{{$post['title_eng']}}</h3>
                                        <p id="post-time">{{$post['created_at']->timezone('Europe/London')}}</p> {{-- timezone --}}
                                    </div>
                                    {!!Str::limit($post['message_eng'], 300, '...')!!}
                                @endif
                                @if ($post['image_link'])
                                    <img src="{{$post['image_link']}}" class="post__image">
                                @endif
                                </a>
                            </div>
                            <hr class="post-divider">
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
