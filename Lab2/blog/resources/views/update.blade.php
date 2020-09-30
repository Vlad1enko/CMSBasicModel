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
            <h1>Update a post</h1>
            <div id="form-wrapper">
                <form action="{{ route('posts.update',['post' => $post]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input name="_method" type="hidden" value="PUT">  {{-- hidden field of method --}}
                    @if ($lang == 'rus')
                        <h2>Сделать публикацию:</h2>
                    @else
                        <h2>Make a publication:</h2>
                    @endif
                    <div id="form_rus">
                        <label for="title_rus">Название поста:</label>
                        <input type="text" placeholder="Название" class="title" name="title_rus" value="{{$post['title_rus']}}">
                        <label for="message_rus">Содержание поста:</label>
                        <textarea rows="10" placeholder="Содержание" class="message" name="message_rus">{{$post['message_rus']}}</textarea>
                    </div>
                    <div id="form_eng">
                        <label for="title_eng">Post title:</label>
                        <input type="text" placeholder="Title" class="title" name="title_eng" value="{{$post['title_eng']}}">
                        <label for="message_eng">Post content:</label>
                        <textarea rows="10" placeholder="Description" class="message" name="message_eng">{{$post['message_eng']}}</textarea>
                    </div>
                    @if ($lang == 'rus')
                        {{-- <label for="image_link">Ссылка на картинку:</label>
                        <input type="text" placeholder="Ссылка" id="image_link" name="image_link"> --}}
                        <label for="image">Выбрать изображение:</label>
                        <input id="image" type="file" name="image" value="{{$post['image_link']}}">
                        <label for="code">Код будущей страницы:</label>
                        <input type="text" placeholder="code-for-new-page" id="code" name="code" value="{{$post['code']}}">
                    @else
                        {{-- <label for="image_link">Image link:</label>
                        <input type="text" placeholder="Image link" id="image_link" name="image_link"> --}}
                        <label for="image">Choose Image:</label>
                        <input id="image" type="file" name="image" value="{{$post['image_link']}}">
                        <label for="code">Future page code:</label>
                        <input type="text" placeholder="code-for-new-page" id="code" name="code" value="{{$post['code']}}">
                    @endif
                    @if ($lang == 'rus')
                        <button type="submit" id="button">Сохранить пост</button>
                    @else
                        <button type="submit" id="button">Save the post</button>
                    @endif
                </form>
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