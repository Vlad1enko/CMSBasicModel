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
            .child_category {
                padding-left: 10px;
            }
            .order_num {
                font-size: 12px;
                color: gray;
                clear:both;
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
                <form action="{{ route('pages.store') }}" method="POST" enctype="multipart/form-data">
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
                        <label for="parent">Выбрать родительскую страницу:</label>
                        <select name="parent" id="parent">
                            <option value="1">Всё</option>
                            @foreach ($pages as $page)
                                <option value="{{ $page['id'] }}">{{ $page->preorderTraversal($page, $page->title_rus, $lang) }}</option>
                            @endforeach
                        </select>
                    @else
                        <label for="parent">Choose a parent page:</label>
                        <select name="parent" id="parent">
                            <option value="1">All</option>
                            @foreach ($pages as $page)
                                <option value="{{ $page['id'] }}">{{ $page->preorderTraversal($page, $page->title_eng, $lang) }}</option>
                            @endforeach
                        </select>
                    @endif
                    @if ($lang == 'rus')
                        <label for="alias_of">Ярлык страницы:</label>
                        <select name="alias_of" id="alias_of">
                            <option value="0">None</option>
                            @foreach ($pages as $page)
                                <option value="{{ $page['id'] }}">{{ $page->preorderTraversal($page, $page->title_rus, $lang) }}</option>
                            @endforeach
                        </select>
                    @else
                        <label for="alias_of">Alias of:</label>
                        <select name="alias_of" id="alias_of">
                            <option value="0">None</option>
                            @foreach ($pages as $page)
                                <option value="{{ $page['id'] }}">{{ $page->preorderTraversal($page, $page->title_eng, $lang) }}</option>
                            @endforeach
                        </select>
                    @endif
                    @if ($lang == 'rus')
                        <label for="order">Порядковый номер:</label>
                        <input type="text" placeholder="Число" id="order" name="order">
                    @else
                        <label for="order">Choose the order:</label>
                        <input type="text" placeholder="Number" id="order" name="order">
                    @endif
                    
                    @if ($lang == 'rus')
                        <h2>Пользовательские поля:</h2>
                        <div id="custom_fields_container">
                            <label for="cf_key">Пользовательское поле:</label>
                            <input type="text" placeholder="Ключ" name="cf_key[0]" />
                            <input type="text" placeholder="Значение на русском" name="cf_value_rus[0]" />
                            <input type="text" placeholder="Значение на английском" name="cf_value_eng[0]" />
                        </div>
                        <button id="button" onclick="event.preventDefault(); onClickAddInput(event, '{{$lang}}')">Добавить пользовательское поле</button>
                    @else
                        <h2>Custom fields:</h2>
                        <div id="custom_fields_container">
                            <label for="cf_key">Сustom field:</label>
                            <input type="text" placeholder="key" name="cf_key[0]" />
                            <input type="text" placeholder="Russian value" name="cf_value_rus[0]" />
                            <input type="text" placeholder="English value" name="cf_value_eng[0]" />
                        </div>
                        <button id="button" onclick="event.preventDefault(); onClickAddInput(event, '{{$lang}}')">Add custom field</button>
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
                    <hr>
                    <div id="posts__title">
                        @if ($lang == 'rus')
                            <h1>Лента постов:</h1>
                            <a href="{{route('admin', ['lang' => 'eng'])}}" id="lang-button"><h3>Eng</h3></a>
                            <a href="{{route('index', ['lang' => $lang])}}" id="admin-button"><h3>Домой</h3></a>
                            <div>
                                <form method="POST" action="{{route('changeAdminOrder', ['lang' => $lang])}}">
                                    {{ csrf_field() }}
                                    <select name="order_type" id="order_type">
                                        @foreach ($sortListRus as $item)
                                            {!! $item !!}
                                        @endforeach
                                    </select>
                                    <button type="submit">Enable filter</button>
                                </form>
                            </div>
                        @else
                            <h1>Posts line:</h1>
                            <a href="{{route('admin', ['lang' => 'rus'])}}" id="lang-button"><h3>Rus</h3></a>
                            <a href="{{route('index', ['parent' => 1, 'lang' => $lang])}}" id="admin-button"><h3>Home</h3></a>
                            <div>
                                <form method="POST" action="{{route('changeAdminOrder', ['lang' => $lang])}}">
                                    {{ csrf_field() }}
                                    <select name="order_type" id="order_type">
                                        @foreach ($sortListEng as $item)
                                            {!! $item !!}
                                        @endforeach
                                    </select>
                                    <button type="submit">Enable filter</button>
                                </form>
                            </div>
                        @endif
                    </div>
                    <hr>
                    <div id="posts-line">
                        @foreach ($pages as $page)
                        <div class="publication">
                            <h2>{{$page['id']}}</h2>
                            <a href="{{route('show', ['id' => ($page->aliasOf) ? $page->aliasOf->id : $page->id, 'lang' => $lang])}}">
                            @if ($lang == 'rus')
                                <div id="post-top">
                                    <h3>{{$page['title_rus']}}</h3>
                                    <p id="post-time">{{$page['created_at']}}</p> {{-- timezone --}}
                                </div>
                                <p>{!!Str::limit($page['message_rus'], 150, '...')!!}</p>
                            @else
                                <div id="post-top">
                                    <h3>{{$page['title_eng']}}</h3>
                                    <p id="post-time">{{$page['created_at']}}</p> {{-- timezone --}}
                                </div>
                                <p>{!!Str::limit($page['message_eng'], 150, '...')!!}</p>
                                <div class="order_num">Order: {{$page['order']}}</div>
                            @endif
                            </a>
                        </div>
                        <a href="{{route('pages.edit', ['page' => $page, 'lang' => $lang])}}" class="update-button">Update</a>
                        <form action="{{ route('pages.destroy', ['page' => $page]) }}" method="POST" id="destroy-form">
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
