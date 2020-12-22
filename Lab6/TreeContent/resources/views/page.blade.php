<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Blog</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;400;700&display=swap" rel="stylesheet">
        <!-- Styles -->

        <style>
            body, html {
                font-family: 'Nunito';
                height: 100%;
                margin: 0;
            }
            .container {
                height: 100%;
            }
            #hero__image {
                min-height: 100%;
                width: 98%;
                margin: 0 auto;
                color: white;
                display: flex;
                align-items: center;
                justify-content: center;
                flex-direction: column;
            }
            #hero__image::before {
                position: fixed;
                left: 0;
                right: 0;
                z-index: -1;
                filter: blur(4px);
                content: "";
                background-image: linear-gradient(rgba(0, 0, 0, 0.5),rgba(0, 0, 0, 0.5)), url(https://api.discovery.com/v1/images/5e84e407f5b0ee36f6091165?aspectRatio=16x9&width=1400&key=3020a40c2356a645b4b4);
                height: 100%;
                width: 100%;
                background-position: center;
                background-repeat: no-repeat;
                background-attachment: fixed;
                background-size: cover;
            }
            /* #hero__wrapper {
                padding: 16px;
                background-color: rgba(0, 0, 0, 0.205);
                border-radius: 15px;
            } */
            #hero__image p:first-child {
                font-size: 122px;
            }
            #hero__image p {
                text-align: center;
                margin: 0;
                font-size: 60px;
                font-weight: 400;
            }
            #hero__image p strong {
                font-weight: 700;
                color: aqua;
            }
            #posts {
                background: white;
            }
            #posts {
                margin: 0 auto;
                padding: 10px 0;
                width: 50%;
            }
            #posts h1 {
                display: inline-block;
            }
            #posts-wrapper {
                background-color: white;
            }
            h1 {
                text-align: center;
            }
            hr {
                border: none;
                margin: 16px 0;
                background-color: rgb(0, 180, 180);
                height: 2px;
            }
            .post-divider {
                background-color: gray;
                height: 1px;
                margin: 24px 0;
            }
            input, textarea {
                margin: 0 5px;
                font-size: 15px;
                color: #555555;
                line-height: 1.2;
                height: 45px;
                outline: none;
                border: none;
                background: transparent;
                padding: 0 5px;
                border-bottom: 1px solid gray;
                width: 60%;
                resize: vertical;
            }
            textarea {
                width: 80%;
            }
            #button {
                width: 70%;
                display: block;
                margin: 20px auto 40px;
                padding: 10px 15px;
                border: 1px solid gray;
                border-radius: 2px;
                background: transparent;
                cursor: pointer;
            }
            label {
                margin: 10px 0;
                display: block;
            }
            #post-time {
                float: right;
                margin: 0;
                font-size: 12px;
                color: gray;
            }
            #update-time {
                margin: 0;
                font-size: 12px;
                color: gray;
            }
            h3 {
                display: inline;
            }
            #form_rus, #form_eng {
                display: inline-block;
                width: 49%;
            }
            #lang-button {
                float: right;
                text-decoration: none;
                color: black;
            }
            #lang-button h3 {
                margin: 0;
            }
            #posts__title {
                text-align: center;
            }
            #image_link {
                width: 90%;
            }
            .post__image {
                width: 100%;
            }
            a {
                color: black;
                text-decoration: none;
            }
            #home-button {
                font-weight: 700;
                font-size: 24px;
                display: inline-block;
                margin: 20px 0;
            }
            #parent_category {
                color: gray;
                font-size: 14px;
            }
            .macrolink {
                font-weight: 700;
            }
            .view_list {
                display: grid;
                grid-template-columns: 1fr 1fr;
                column-gap: 10px;
                row-gap: 15px;
            }
            .tiles {
                position: relative;
                background-color: rgb(214, 214, 214);
                border-radius: 5px;
                box-shadow: 5px 5px 5px gray;
                padding: 15px 10px;
            }
            .tiles:hover {
                background-color: rgb(228, 228, 228);
                
            }
            .tag {
                display: inline-block;
                background-color:rgb(0, 180, 180);
                padding: 2px 15px;
                border-radius: 15px;
                color: white;
                font-weight: bold;
            }
            .author {
                color: gray;
                text-align: right;
                font-size: 12px;
                margin: 0;
                margin-top: 12px;
                margin-bottom: -16px;
            }
        </style>
    </head>
<body class="antialiased">
    <div id="posts-wrapper">
        <div id="posts">
            <div id="posts-line">
                <div class="publication">
                    @if ($lang == 'rus')
                        <div id="post-top">
                            <p id="parent_category">
                                <a href="#">{{$page->preorderTraversal($page, $page->title_rus, $lang)}}/</a>
                            </p>
                            <h3>{{$page['title_rus']}}</h3>
                            <p id="post-time">{{$page['created_at']->timezone('Europe/Kiev')}}</p> {{-- timezone --}}
                        </div>
                        {!!htmlspecialchars_decode($page['message_rus'])!!}
                    @else
                        <div id="post-top">
                            <p id="parent_category">
                                <a href="#">{{$page->preorderTraversal($page, $page->title_eng, $lang)}}/</a>
                            </p>
                            <h3>{{$page['title_eng']}}</h3>
                            <p id="post-time">{{$page['created_at']->timezone('Europe/London')}}</p> {{-- timezone --}}
                        </div>
                        {!!htmlspecialchars_decode($page['message_eng'])!!}
                    @endif
                    @if ($page['image_link'])
                        <img src="{{$page['image_link']}}" class="post__image">
                    @endif
                    @if ($lang == 'rus')
                        @foreach ($page->metas()->get() as $meta)
                            @if (str_contains($meta->key,'tag'))
                                <span class="tag">{{$meta->value_rus}}</span>
                            @elseif ($meta->key == 'author')
                                <p class="author">Автор: {{$meta->value_rus}}</p>
                            @else
                                <h4 style="margin: 0; margin-top: 12px;">{{$meta->key}}: </h4> <p style="margin-top: 0">{{$meta->value_rus}}</p>
                            @endif
                        @endforeach
                    @else
                        @foreach ($page->metas()->get() as $meta)
                            @if (str_contains($meta->key,'tag'))
                                <span class="tag">{{$meta->value_eng}}</span>
                            @elseif ($meta->key == 'author')
                                <p class="author">Author: {{$meta->value_eng}}</p>
                            @else
                                <h4 style="margin: 0; margin-top: 12px;">{{$meta->key}}: </h4> <p style="margin-top: 0">{{$meta->value_eng}}</p>
                            @endif
                        @endforeach
                    @endif
                    @if ($lang == 'rus')
                        <p id="update-time">Last updated at {{$page['updated_at']->timezone('Europe/Kiev')}}</p>
                    @else
                        <p id="update-time">Last updated at {{$page['updated_at']->timezone('Europe/London')}}</p>
                    @endif
                </div>
                <a href="{{route('index', ['parent' => App\Models\Page::find($page->parent_id)->id, 'lang' => $lang])}}" id="home-button">&#10094; Go to the parent</a>
                <div></div>
                <a href="{{route('index', ['parent' => 1, 'lang' => $lang])}}" id="home-button">&#10094; Go home</a>
            </div>
        </div>
    </div>
</body>
