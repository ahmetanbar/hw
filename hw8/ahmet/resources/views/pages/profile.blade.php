@extends('layouts.app')


@section('profile')

    <div class="container">
        <a href="./" class="btn btn-default">Go Back</a>
        <div class="row user-menu-container ">
            <div class="container">
                <div class="row coralbg white">
                    <div class="col-md-8 no-pad">
                        <div class="user-pad">
                            <h3>{{$user_info->name}}  {{$user_info->surname}}</h3>
                            <h4 class="white"><i class="fa fa-check-circle-o"></i><h3>@ {{$user_info->username}}</h3></h4>
                            @guest

                            @else
                                <button type="button" class="btn btn-labeled btn-info" href="#">
                                <span class="btn-label"><i class="fa fa-pencil"></i></span>Update</button>
                            @endguest
                        </div>
                    </div>
                </div>
                <div class="row overview">
                    <div class="col-md-4 user-pad text-center">
                        <h3>Point</h3>
                        <h4>0</h4>
                    </div>
                    <div class="col-md-4 user-pad text-center">
                        <h3>Articles</h3>
                        <h4>{{count($user_info->article)}}</h4>
                    </div>
                    <div class="col-md-4 user-pad text-center">
                        <h3>Comments</h3>
                        <h4>{{count($user_info->comments)}}</h4>
                    </div>
                </div>

                {{--last 5 articles--}}

                <div class="row overview">
                    <div class="btn-group-vertical square">
                        <div class="text-center" style="background:rgba(75,63,65,0.72);">
                                 <h4>Last articles</h4>
                        </div>
                        @foreach($user_info->article as $title)
                            <a href="{{route('archieve_show',['id'=>$title->id])}}" class="btn btn-block btn-default">
                                <h3 class="fa fa-bell-o fa-3x">{{$title->header}}</h3>
                            </a>
                        @endforeach

                        @if(!count($user_info->article))
                            <a href="#" class="btn btn-block btn-default">
                                <h3 class="fa fa-bell-o fa-3x">Not found article</h3>
                            </a>
                        @endif
                    </div>
                </div>

                {{--last 5 comments--}}

                <div class="row overview">
                    <div class="btn-group-vertical square">
                        <div class="text-center" style="background:rgba(75,63,65,0.72);">
                            <h4>Last comments</h4>
                        </div>

                        @foreach($user_info->comment as $comment)
                            <a href="{{route('archieve_show',['id'=>$comment->article_id])}}" class="btn btn-block btn-default">
                                <h3 class="fa fa-bell-o fa-3x">"{{$comment->comment}}" on <i>{{$comment->header}}</i> </h3>
                                <h3 class="fa fa-bell-o fa-3x"></h3>
                            </a>
                        @endforeach

                        @if(!count($user_info->comment))
                            <a href="#" class="btn btn-block btn-default">
                                <h3 class="fa fa-bell-o fa-3x">Not found comment</h3>
                            </a>
                        @endif

                    </div>
                </div>
            </div>

        </div>
    </div>

    <br>

@endsection
