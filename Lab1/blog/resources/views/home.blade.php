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
                width: 100%;
                margin: 0 auto;
                color: white;
                display: flex;
                align-items: center;
                justify-content: center;
                flex-direction: column;
                position: relative;
            }
            #hero__image::before {
                position: absolute;
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
                height: 80px;
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
            #image {
                outline: 0;
            }
        </style>
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
                            <a href="{{route('home', ['lang' => 'eng'])}}" id="lang-button"><h3>Eng</h3></a>
                        @else
                            <h1>Posts line:</h1>
                            <a href="{{route('home', ['lang' => 'rus'])}}" id="lang-button"><h3>Rus</h3></a>
                        @endif
                    </div>
                    <hr>
                    <div id="posts-line">
                        <div id="form-wrapper">
                            <form action="{{ route('create') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                @if ($lang == 'rus')
                                    <h2>Сделать публикацию:</h2>
                                @else
                                    <h2>Make a publication:</h2>
                                @endif
                                <div id="form_rus">
                                    <label for="title_rus">Название поста:</label>
                                    <input type="text" placeholder="Название" id="title" name="title_rus">
                                    <label for="message_rus">Содержание поста:</label>
                                    <textarea rows="10" placeholder="Содержание" id="message" name="message_rus"></textarea>
                                </div>
                                <div id="form_eng">
                                    <label for="title_eng">Post title:</label>
                                    <input type="text" placeholder="Title" id="title" name="title_eng">
                                    <label for="message_eng">Post content:</label>
                                    <textarea rows="10" placeholder="Description" id="message" name="message_eng"></textarea>
                                </div>
                                @if ($lang == 'rus')
                                    {{-- <label for="image_link">Ссылка на картинку:</label>
                                    <input type="text" placeholder="Ссылка" id="image_link" name="image_link"> --}}
                                    <label for="image">Выбрать изображение:</label>
                                    <input id="image" type="file" name="image">
                                    <label for="code">Код будущей страницы:</label>
                                    <input type="text" placeholder="code-for-new-page" id="code" name="code">
                                @else
                                    {{-- <label for="image_link">Image link:</label>
                                    <input type="text" placeholder="Image link" id="image_link" name="image_link"> --}}
                                    <label for="image">Choose Image:</label>
                                    <input id="image" type="file" name="image">
                                    <label for="code">Future page code:</label>
                                    <input type="text" placeholder="code-for-new-page" id="code" name="code">
                                @endif
                                @if ($lang == 'rus')
                                    <button type="submit" id="button">Создать пост</button>
                                @else
                                    <button type="submit" id="button">Create a post</button>
                                @endif
                            </form>
                        </div>
                        <hr class="post-divider">
                        @foreach ($posts as $post)
                            <div class="publication">
                                <a href="{{route('post', ['id' => $post['id'], 'lang' => $lang])}}">
                                @if ($lang == 'rus')
                                    <div id="post-top">
                                        <h3>{{$post['title_rus']}}</h3>
                                        <p id="post-time">{{$post['created_at']->timezone('Europe/Kiev')}}</p> {{-- timezone --}}
                                    </div>
                                    {!!Str::limit(htmlspecialchars_decode($post['message_rus']), 300, '...')!!}
                                @else
                                    <div id="post-top">
                                        <h3>{{$post['title_eng']}}</h3>
                                        <p id="post-time">{{$post['created_at']->timezone('Europe/London')}}</p> {{-- timezone --}}
                                    </div>
                                    {!!Str::limit(htmlspecialchars_decode($post['message_eng']), 300, '...')!!}
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
