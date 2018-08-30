@extends('layouts.app')

@section('content')
    <?php $categories=array("C","PHP","Java"); ?>
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
        <h2>Create New Note</h2>
        <hr>

        {!! Form::open(array('route' => 'article_store', 'data-parsley-validate' => '')) !!}
        {{ Form::label('title', 'Title:') }}
        {{ Form::text('title', null, array('class' => 'form-control', 'required' => '', 'maxlength' => '255')) }}

        {{ Form::label('category', 'Category:') }}
        <select class="form-control" name="category">
            @foreach($categories as $category)
                <option>{{ $category }}</option>
            @endforeach
        </select>

        {{ Form::label('body', "Body:") }}
        {{ Form::textarea('body', null, array('class' => 'form-control')) }}

        {{ Form::submit('Share Post', array('class' => 'btn btn-success btn-lg', 'style' => 'margin-top: 20px;')) }}
        {!! Form::close() !!}
    </div>

@endsection
