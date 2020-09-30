<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Blog</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;400;700&display=swap" rel="stylesheet">
        <link href="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.css" rel="stylesheet">
        
        <link rel="stylesheet" type="text/css" href="{{ asset('app.css')}}">
        

        <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.7/summernote.css" rel="stylesheet">

        <style>
            body {
                background: rgb(202, 202, 202);
            }
            .container {
                height: auto;
                background: white;
                margin: 0 auto;
                padding: 10px 20px;
                width: 50%;
            }
            #posts-wrapper h1 {
                display: inline-block;
            }
            .publication h2 {
                margin-right: 20px;
                float: left;
            }
            .publication h2::before {
                content: "id:";
                font-size: 12px;
                color: gray;
            }
            #notification {
                height: 100px;
                color: white;
                display: flex;
                justify-content: center;
                align-items: center;
                border-radius: 5px;
                margin: 10px 0;
            }
            #destroy-form {
                cursor: pointer;
            }
        </style>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script>
            setTimeout(function() {
                $('#notification').fadeOut('fast');
            }, 3000); 
        </script>

    </head>
    <body class="antialiased">
        <div class="container">
            <h1>Admin panel</h1>
            <div id="form-wrapper">
                <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if ($lang == 'rus')
                        <h2>Сделать публикацию:</h2>
                    @else
                        <h2>Make a publication:</h2>
                    @endif
                    <div id="form_rus">
                        <label for="title_rus">Название поста:</label>
                        <input type="text" placeholder="Название" class="title" name="title_rus">
                        <label for="message_rus">Содержание поста:</label>
                        <textarea rows="10" placeholder="Содержание" class="message" name="message_rus"></textarea>
                    </div>
                    <div id="form_eng">
                        <label for="title_eng">Post title:</label>
                        <input type="text" placeholder="Title" class="title" name="title_eng">
                        <label for="message_eng">Post content:</label>
                        <textarea rows="10" placeholder="Description" class="message" name="message_eng"></textarea>
                        @if ($errors->has('body'))
                        <span class="help-block">
                            <strong>{!! $errors->first('body') !!}</strong>
                        </span>
                    @endif
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
            <div id="posts-wrapper">
                <div>
                    @if (session('status'))
                        <div id="notification" 
                        @if (session('status') == 'Deletion success' || session('status') == 'Post is created')
                            style="background: rgb(22, 218, 22)"
                        @else
                            style="background: rgb(187, 8, 8)"
                        @endif
                        >{{ session('status') }}</div>
                    @endif
                    <div id="posts__title">
                        @if ($lang == 'rus')
                            <h1>Лента постов:</h1>
                            <a href="{{route('admin', ['lang' => 'eng'])}}" id="lang-button"><h3>Eng</h3></a>
                            <a href="{{route('index', ['lang' => $lang])}}" id="admin-button"><h3>Домой</h3></a>
                        @else
                            <h1>Posts line:</h1>
                            <a href="{{route('admin', ['lang' => 'rus'])}}" id="lang-button"><h3>Rus</h3></a>
                            <a href="{{route('index', ['lang' => $lang])}}" id="admin-button"><h3>Home</h3></a>
                        @endif
                    </div>
                    <hr>
                    <div id="posts-line">
                        @foreach ($posts as $post)
                        <div class="publication">
                            <h2>{{$post['id']}}</h2>
                            <a href="{{route('show', ['id' => $post->id, 'lang' => $lang])}}">
                            @if ($lang == 'rus')
                                <div id="post-top">
                                    <h3>{{$post['title_rus']}}</h3>
                                    <p id="post-time">{{$post['created_at']->timezone('Europe/Kiev')}}</p> {{-- timezone --}}
                                </div>
                                <p>{!!Str::limit($post['message_rus'], 200, '...')!!}</p>
                            @else
                                <div id="post-top">
                                    <h3>{{$post['title_eng']}}</h3>
                                    <p id="post-time">{{$post['created_at']->timezone('Europe/London')}}</p> {{-- timezone --}}
                                </div>
                                <p>{!!Str::limit($post['message_eng'], 200, '...')!!}</p>
                            @endif
                            </a>
                        </div>
                        <a href="{{route('posts.edit', ['post' => $post, 'lang' => $lang])}}" class="update-button">Update</a>
                        <form action="{{ route('posts.destroy', ['post' => $post]) }}" method="POST" id="destroy-form">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <a onclick="$(this).closest('form').submit();" class="delete-button">Delete</a>
                        </form>
                        <hr class="post-divider">
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
        <script src="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.js"></script>
        <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.7/summernote.js"></script>
        <script>
            $(document).ready(function() {
                $('.message').summernote({
                height: 200,
                });
            });
        </script>
    </body>
