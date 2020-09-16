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
        </style>
    </head>
<body class="antialiased">
    <div id="posts-wrapper">
        <div id="posts">
            <div id="posts-line">
                <div class="publication">
                    @if ($lang == 'rus')
                        <div id="post-top">
                            <h3>{{$post['title_rus']}}</h3>
                            <p id="post-time">{{$post['created_at']->timezone('Europe/Kiev')}}</p> {{-- timezone --}}
                        </div>
                        {!!htmlspecialchars_decode($post['message_rus'])!!}
                    @else
                        <div id="post-top">
                            <h3>{{$post['title_eng']}}</h3>
                            <p id="post-time">{{$post['created_at']->timezone('Europe/London')}}</p> {{-- timezone --}}
                        </div>
                        {!!htmlspecialchars_decode($post['message_eng'])!!}
                    @endif
                    @if ($post['image_link'])
                        <img src="{{$post['image_link']}}" class="post__image">
                    @endif
                    @if ($lang == 'rus')
                        <p id="update-time">Last updated at {{$post['updated_at']->timezone('Europe/Kiev')}}</p>
                    @else
                        <p id="update-time">Last updated at {{$post['updated_at']->timezone('Europe/London')}}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</body>
