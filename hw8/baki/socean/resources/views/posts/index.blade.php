@extends('layouts.app')

@section('content')
@foreach($posts as $post)
<div class="row justify-content-center pt-5">
        <div class="col-md-8">
            <div class="card">
            <div class="card-header">
                <a href="/profile/{{$post->user->id}}">{{$post->user->username}}</a>
                - {{$post->created_at->diffForHumans() }}
            </div>

                <div class="card-body">
                <a href="/p/{{$post->id}}">
                            <img  src="{{ url('/' .$post->image)}}" class="w-100">
                    </a>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>
            <div class="card-header">{{$post->caption}}</div>
            </div>
        </div>
    </div>
@endforeach
@endsection