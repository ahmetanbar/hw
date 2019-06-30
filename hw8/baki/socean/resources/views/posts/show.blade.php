@extends('layouts.app')

@section('content')
<div class="container">
<div class="row justify-content-center pt-5">
        <div class="col-md-8">
            <div class="card">
            <div class="card-header">
                <img src="/storage/{{$post->user->profile->image}}" width="50px" class="rounded-circle">
            <a href="/profile/{{$post->user->id}}">{{$post->user->username}}</a>
            </div>

                <div class="card-body">
                <a href="/p/{{$post->id}}">
                    <img  src="/storage/{{$post->image}}" class="w-100">
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



</div>
@endsection
