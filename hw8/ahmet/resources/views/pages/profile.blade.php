@extends('layouts.app')


@section('content')
    
    <div class="container">
    <div class="row user-menu-container ">
        <div class="container">
            <div class="row coralbg white">
                <div class="col-md-6 no-pad">
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
                    <h4>2,784</h4>
                </div>
                <div class="col-md-4 user-pad text-center">
                    <h3>Articles</h3>
                    <h4>456</h4>
                </div>
                <div class="col-md-4 user-pad text-center">
                    <h3>Comments</h3>
                    <h4>4,901</h4>
                </div>
            </div>

            {{--last 4 articles--}}

            <div class="row overview">
                <div class="btn-group-vertical square">
                    <a href="#" class="btn btn-block btn-default">
                        <i class="fa fa-bell-o fa-3x">Hesadasdsa</i>
                    </a>
                    <a href="#" class="btn btn-block btn-default">
                        <i class="fa fa-bell-o fa-3x"></i>
                    </a>
                    <a href="#" class="btn btn-block btn-default">
                        <i class="fa fa-bell-o fa-3x"></i>
                    </a>
                    <a href="#" class="btn btn-block btn-default">
                        <i class="fa fa-bell-o fa-3x"></i>
                    </a>
                </div>
            </div>

            {{--last 4 comments--}}

            <div class="row overview">
                <div class="btn-group-vertical square">
                    <a href="#" class="btn btn-block btn-default">
                        <i class="fa fa-bell-o fa-3x"></i>
                    </a>
                    <a href="#" class="btn btn-block btn-default">
                        <i class="fa fa-bell-o fa-3x"></i>
                    </a>
                    <a href="#" class="btn btn-block btn-default">
                        <i class="fa fa-bell-o fa-3x"></i>
                    </a>
                    <a href="#" class="btn btn-block btn-default">
                        <i class="fa fa-bell-o fa-3x"></i>
                    </a>
                </div>
            </div>
        </div>

    </div>
    </div>

    <a href="./" class="btn btn-default">Go Back</a>
    <br>

@endsection
