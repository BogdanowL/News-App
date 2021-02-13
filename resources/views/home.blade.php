@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Все записи</h1>
    <h3 class="d-flex float-right"> </h3>
    <div class="row">
        <div class="col-sm-6">
            <form action="{{route('news.store')}}" method="POST" class="mb-4">
                @csrf
                <div class="form-group">
                    <label for="title">Название</label>
                    <input  type="text" class="form-control" name="title" >
                </div>
                <div class="form-group">
                    <label for="description">Описание</label>
                    <input  type="text" class="form-control" name="description" >
                </div>
                <div class="form-group">
                    <label for="text">Текст</label>
                    <textarea  class="form-control" name="text" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label>Теги</label>
                    {{ Form::select('tags[]', $tags, null,['class' => 'form-control select2',
                  'multiple' => 'multiple', 'data-placeholder'
                  => 'Выберите теги']) }}
                </div>
                <button  type="submit" class="btn btn-primary">Добавить</button>
            </form>

        </div>

        <div class="col-sm-6">
            <h4>Список пользователей и тегов</h4>
            <table  class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">Пользователи</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    @foreach($users as $user)
                        <th> {{$user->name}}</th>
                </tr>
                @endforeach
                </tbody>
            </table>

            {{$users->links()}}
            <table  class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">Теги</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    @foreach($tag as $tagItem)
                        <td>{{$tagItem->title}}</td>
                @endforeach
                </tr>
                </tbody>
            </table>

            {{$tag->links()}}
        </div>
    </div>

{{--    <div  class="alert alert-danger text-center" role="alert">--}}
{{--        Новости не загрузились :(--}}
{{--    </div>--}}
    <div id="app"></div>
    <table  class="table table-striped">
        <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Автор</th>
            <th scope="col">Название</th>
            <th scope="col">Описание</th>
            <th scope="col">Текст</th>
            <th scope="col">Теги</th>
            <th scope="col">Операции</th>
        </tr>
        </thead>
        <tbody>
        <tr >
            @foreach($news as $note)
            <th> {{$note->id}}</th>
            <th >  {{$note->author->name}} </th>
            <td>{{$note->title}}</td>

            @if ( strlen($note->description) == 0)
                    <td>  {{Str::limit($note->text, 30)}}</td>
                @else
                    <td>{{$note->description}}</td>
            @endif
            <td>{{$note->text}}</td>

                @if ( empty($note->tags->first()) )
                    <td>  Тегов нет</td>
                @else
            @foreach($note->tags as $tag)
            <td>{{$tag->title}}</td>
            @endforeach
                @endif
            <td class="">
                @if(Auth::user()->id == $note->author->id)

                <div class="d-inline-block">
                    <button onclick="location.href='{{route('news.edit', $note->id)}}'" class="btn mt-2 btn-success">
                        <i class="fas fa-pencil-alt"></i>
                    </button>

                    {{ Form::open(['route' => ['news.destroy', $note->id], 'method' => 'delete']) }}
                    <button type="submit"  class="btn mt-2 btn-danger">
                        <i class="far fa-times-circle"></i>
                    </button>
                        {{ Form::close() }}
                    @else
                        <button  class="disabled btn mt-2 btn-success">
                            <i class="fas fa-pencil-alt"></i>
                        </button>
                        <button  class="disabled btn mt-2 btn-danger">
                            <i class="far fa-times-circle"></i>
                        </button>
                </div>
                @endif
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
        {{$news->links()}}
</div>

@endsection
