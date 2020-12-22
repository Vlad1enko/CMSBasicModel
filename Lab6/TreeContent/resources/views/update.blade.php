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
        
        <script src="{{asset('js/formAddCustomField.js')}}"></script>

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
            #pages-wrapper h1 {
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
            hr {
                background-color: rgb(190, 190, 190);
                height: 1px;
            }
            #custom_fields_container {
                display: grid;
                grid-template-columns: 1fr 1fr;
                column-gap: 10px;
                row-gap: 15px;
            }
            .card {
                display: flex;
                align-items: center;
                flex-direction: column;
                background-color: rgb(238, 238, 238);
                border-radius: 5px;
                margin-top: 15px;
                padding: 10px;
            }
            .tiles {
                display: flex;
                align-items: center;
                flex-direction: column;
                position: relative;
                background-color: rgb(214, 214, 214);
                border-radius: 5px;
                box-shadow: 5px 5px 5px gray;
                padding: 15px 10px;
            }
            .tiles:hover {
                background-color: rgb(228, 228, 228);
            }
            .cross {
                display: flex;
                align-self: flex-end;
                margin-right: 5px;
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
            <h1>Update a page</h1>
            <div id="form-wrapper">
                <form action="{{ route('pages.update',['page' => $page]) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input name="_method" type="hidden" value="PUT">  {{-- hidden field of method --}}
                    @if ($lang == 'rus')
                        <h2>Сделать публикацию:</h2>
                    @else
                        <h2>Make a publication:</h2>
                    @endif
                    <div id="form_rus">
                        <label for="title_rus">Название поста:</label>
                        <input type="text" placeholder="Название" class="title" name="title_rus" value="{{$page['title_rus']}}">
                        <label for="message_rus">Содержание поста:</label>
                        <textarea rows="10" placeholder="Содержание" class="message" name="message_rus">{{$page['message_rus']}}</textarea>
                    </div>
                    <div id="form_eng">
                        <label for="title_eng">page title:</label>
                        <input type="text" placeholder="Title" class="title" name="title_eng" value="{{$page['title_eng']}}">
                        <label for="message_eng">page content:</label>
                        <textarea rows="10" placeholder="Description" class="message" name="message_eng">{{$page['message_eng']}}</textarea>
                    </div>
                    @if ($lang == 'rus')
                        {{-- <label for="image_link">Ссылка на картинку:</label>
                        <input type="text" placeholder="Ссылка" id="image_link" name="image_link"> --}}
                        <label for="image">Выбрать изображение:</label>
                        <input id="image" type="file" name="image" value="{{$page['image_link']}}">
                        <label for="code">Код будущей страницы:</label>
                        <input type="text" placeholder="code-for-new-page" id="code" name="code" value="{{$page['code']}}">
                    @else
                        {{-- <label for="image_link">Image link:</label>
                        <input type="text" placeholder="Image link" id="image_link" name="image_link"> --}}
                        <label for="image">Choose Image:</label>
                        <input id="image" type="file" name="image" value="{{$page['image_link']}}">
                        <label for="code">Future page code:</label>
                        <input type="text" placeholder="code-for-new-page" id="code" name="code" value="{{$page['code']}}">
                    @endif
                    @if ($lang == 'rus')
                        <h2>Пользовательские поля:</h2>
                        <div id="custom_fields_container">
                        @foreach ($page->metas()->get() as $key => $meta)
                            <div class="tiles">
                                <span class="cross"><a href="{{route('deleteMeta', ['id' => $page->id, 'key' => $meta->key, 'lang' => $lang])}}">&#10006;</a></span>
                                <label for="cf_key">Пользовательское поле:</label>
                                <input type="text" placeholder="Ключ" name="cf_key[{{$key}}]" value="{{$meta->key}}"/>
                                <input type="text" placeholder="Значение на русском" name="cf_value_rus[{{$key}}]" value="{{$meta->value_rus}}"/>
                                <input type="text" placeholder="Значение на английском" name="cf_value_eng[{{$key}}]"  value="{{$meta->value_eng}}"/>
                            </div>
                            @endforeach
                        </div>
                        <button id="button" onclick="event.preventDefault(); onClickAddInput(event, '{{$lang}}')">Добавить пользовательское поле</button>
                    @else
                        <h2>Custom fields:</h2>
                        <div id="custom_fields_container">
                        @foreach ($page->metas()->get() as $key => $meta)
                            <div class="tiles">
                                <span class="cross"><a href="{{route('deleteMeta', ['id' => $page->id, 'key' => $meta->key, 'lang' => $lang])}}">&#10006;</a></span>
                                <label for="cf_key">Сustom field:</label>
                                <input type="text" placeholder="key" name="cf_key[{{$key}}]" value="{{$meta->key}}"/>
                                <input type="text" placeholder="Russian value" name="cf_value_rus[{{$key}}]"  value="{{$meta->value_rus}}"/>
                                <input type="text" placeholder="English value" name="cf_value_eng[{{$key}}]"  value="{{$meta->value_eng}}"/>
                            </div>
                            @endforeach
                        </div>
                        <button id="button" onclick="event.preventDefault(); onClickAddInput(event, '{{$lang}}')">Add custom field</button>
                    @endif
                    @if ($lang == 'rus')
                        <button type="submit" id="button">Сохранить пост</button>
                    @else
                        <button type="submit" id="button">Save the page</button>
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