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
                        <form action="/profile/{{$user->id}}" enctype="multipart/form-data" method="POST">
                            @csrf
                            @method('PATCH')
                                {{-- Name:<input type="text" style="margin: 5px" value="{{$user->name}}"> <br> --}}
                                {{-- Username:<input type="text" style="margin: 5px" value="{{$user->username}}"> <br> --}}
                                {{-- Email:<input type="text" style="margin: 5px" value="{{$user->email}}"> <br> --}}
                                Title:<input type="text" name="title" id="title" style="margin: 5px" value="{{$user->profile->title}}"> <br>
                                Description:<input type="text" name="describtion" id="describtion" style="margin: 5px" value="{{$user->profile->describtion}}"> <br>
                                Url:<input type="text" style="margin: 5px" name="url" id="url" value="{{ $user->profile->url ?? ' N/A'}}"> <br>
                                PP:<input type="file" name='image' id="image" style="margin: 5px"> <br>
                                <button style="margin: 5px" type="submit">Save</button>
                            </form>
                        </div>
                </div>
            </div>
        </div>       
    </div>


@endsection