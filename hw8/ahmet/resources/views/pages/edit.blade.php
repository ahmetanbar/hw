@extends('layouts.app')

@section('content')
    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>

    <script>
        tinymce.init({
            selector: 'textarea',
            branding: false ,
            plugins: 'link code',
            menubar: false
        });
    </script>

    <p class="text-center">Hello World</p>

    <div class="row">
        <h2>Edit Your Note</h2>
        <hr>

    {{ Form::model($article, array('route' => array('update_article', $article->id), 'method' => 'PUT')) }}
        {{ csrf_field() }}
        <div class="form-group">
            {{ Form::label('header', 'Header') }}
            {{ Form::text('header', null, array('class' => 'form-control')) }}
        </div>

        <div class="form-group">
            {{ Form::label('article', 'Article') }}
            {{ Form::textarea('article', null, array('class' => 'form-control')) }}
        </div>

        <div class="form-group">
            {{ Form::label('category_id', 'Category') }}
            <select class="form-control" name="category_id">
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        {{ Form::submit('Edit your note!', array('class' => 'btn btn-primary')) }}

    {{ Form::close() }}

    </div>

@endsection
