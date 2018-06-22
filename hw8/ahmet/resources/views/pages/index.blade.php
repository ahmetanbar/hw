@extends('layouts.app')

@section('content')
    <p class="text-center">Hello World</p>

    @if(count($articles)>0)
        @foreach($articles as $article)
            <div class="well">
                <h3>{{$article->article}}</h3>
            </div>
        @endforeach
        {{--{{$articles->links()}}--}}
    @else
        <p>No posts found</p>
    @endif

@endsection
