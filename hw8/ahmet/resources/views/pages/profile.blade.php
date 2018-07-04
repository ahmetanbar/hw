@extends('layouts.app')


@section('profile')

    <div class="container">
    <div class="row user-menu-container ">
        <div class="container">
            <div class="row coralbg white">
                <div class="col-md-8 no-pad">
                    <div class="user-pad">
                        <h3>{{$data['profile']->name}}  {{$data['profile']->surname}}</h3>
                        <h4 class="white"><i class="fa fa-check-circle-o"></i><h3>@ {{$data['profile']->username}}</h3></h4>
                        @guest

                        @else
                            <button type="button" class="btn btn-labeled btn-info" href="#">
                            <span class="btn-label"><i class="fa fa-pencil"></i></span>Update</button>
                        @endguest
                    </div>
                </div>
                {{--<div class="col-md-6 no-pad">--}}
                    {{--<div class="user-image">--}}
                        {{--<img src="https://farm7.staticflickr.com/6163/6195546981_200e87ddaf_b.jpg" class="img-responsive thumbnail">--}}
                    {{--</div>--}}
                {{--</div>--}}
            </div>
            <div class="row overview">
                <div class="col-md-4 user-pad text-center">
                    <h3>Point</h3>
                    <h4>0</h4>
                </div>
                <div class="col-md-4 user-pad text-center">
                    <h3>Articles</h3>
                    <h4>{{count($data['articles'])}}</h4>
                </div>
                <div class="col-md-4 user-pad text-center">
                    <h3>Comments</h3>
                    <h4>{{count($data['comments'])}}</h4>
                </div>
            </div>

            {{--last 4 articles--}}

            <div class="row overview">
                <div class="btn-group-vertical square">
                    <div class="text-center" style="background:rgba(75,63,65,0.72);">
                             <h4>Last articles</h4>
                    </div>
                    @foreach($data['articles'] as $title)
                        <a href="{{route('archieve.show',['id'=>$title->id])}}" class="btn btn-block btn-default">
                            <h3 class="fa fa-bell-o fa-3x">{{$title->header}}</h3>
                        </a>
                    @endforeach

                    @if(!count($data['articles']))
                        <a href="#" class="btn btn-block btn-default">
                            <h3 class="fa fa-bell-o fa-3x">Not found article</h3>
                        </a>
                    @endif
                </div>
            </div>

            {{--last 4 comments--}}

            <div class="row overview">
                <div class="btn-group-vertical square">
                    <div class="text-center" style="background:rgba(75,63,65,0.72);">
                        <h4>Last comments</h4>
                    </div>
                    @foreach($data['comments'] as $comment)
                        <a href="{{route('archieve.show',['id'=>$comment->article_id])}}" class="btn btn-block btn-default">
                            <h3 class="fa fa-bell-o fa-3x">"{{$comment->comment}}" on <i>{{$comment->header}}</i> </h3>
                            <h3 class="fa fa-bell-o fa-3x"></h3>
                        </a>
                    @endforeach

                    @if(!count($data['comments']))
                        <a href="#" class="btn btn-block btn-default">
                            <h3 class="fa fa-bell-o fa-3x">Not found comment</h3>
                        </a>
                    @endif

                </div>
            </div>
        </div>

    </div>
    </div>

    <a href="./" class="btn btn-default">Go Back</a>
    <br>

@endsection
