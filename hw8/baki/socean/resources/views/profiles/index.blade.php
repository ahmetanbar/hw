@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Profile</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <img src="/storage/{{$user->profile->image}}" class="w-50 pb-5"><br>
                    Name:<strong> {{$user->name}}</strong>
                    <br>
                    Username:<strong> {{$user->username}}</strong> 
                    <br>
                    Email:<strong> {{$user->email}}</strong>
                    <br>
                    Title:<strong> {{$user->profile->title}}</strong>
                    <br>
                    Description:<strong> {{$user->profile->describtion}}</strong>
                    <br>
                    Url: <strong>{{ $user->profile->url ?? ' N/A'}}</strong>
                    <br>
                    Post: <strong>{{ $user->posts->count()}}</strong>
                    <br>
                    <follow-button user-id="{{$user->id}}"></follow-button>
                    @can('update', $user->profile)
                    <a href="/p/create" style="color: blue"><strong>Add New Post</strong></a>
                    <br>
                    <a href="/profile/{{$user->id}}/edit" style="color: red"><strong>Edit Profile</strong></a>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@foreach($user->posts as $post)
<div class="row justify-content-center pt-5">
        <div class="col-md-8">
            <div class="card">
            <div class="card-header">{{$user->username}}</div>

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
@endforeach


</div>
@endsection
