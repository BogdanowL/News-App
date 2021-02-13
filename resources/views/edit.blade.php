@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Все записи</h1>
        <h3 class="d-flex float-right"> </h3>
        <div class="row">
            <div class="col-sm-6">

                {{ Form::open(['route' => ['news.update', $note->id], 'method' => 'put']) }}
                    @csrf
                    <div class="form-group">
                        <label for="title">Название</label>
                        <input value="{{$note->title}}" type="text" class="form-control" name="title" >
                    </div>
                    <div class="form-group">
                        <label for="description">Описание</label>
                        <input value="{{$note->description}}"  type="text" class="form-control" name="description" >
                    </div>
                    <div class="form-group">
                        <label for="text">Текст</label>
                        <textarea   class="form-control" name="text" rows="7">{{$note->text}}</textarea>
                    </div>
                <div class="form-group">
                    <label>Теги</label>
                    {{ Form::select('tags[]', $tags, null,['class' => 'form-control select2',
                  'multiple' => 'multiple', 'data-placeholder'
                  => 'Выберите теги']) }}
                </div>
                    <button  type="submit" class="btn btn-success">Созранить изменения</button>
                {{ Form::close() }}

            </div>
        </div>




    </div>
@endsection
