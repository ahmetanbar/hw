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
                            <h3>Point:0</h3>
                            @guest

                            @else
                                <button type="button" class="btn btn-labeled btn-info" href="#">
                                <span class="btn-label"><i class="fa fa-pencil"></i></span>Update</button>
                            @endguest
                        </div>
                    </div>
                </div>
                <div class="row overview">
                    <div class="col-xs-6 user-pad text-center">
                        <button onclick="show_arts()" type="button" class="btn btn-light"><h3 >Articles</h3>
                        <h4>{{count($user_info->article)}}</h4> </button>

                        <script>
                            function show_arts() {
                                var x = document.getElementById("articles");
                                var y = document.getElementById("comments");
                                if (x.style.display === "none") {
                                    y.style.display = "none";
                                    x.style.display = "block";
                                } else {
                                    x.style.display = "none";
                                }
                            }

                            function show_comments() {
                                var x = document.getElementById("articles");
                                var y = document.getElementById("comments");
                                if (y.style.display === "none") {
                                    y.style.display = "block";
                                    x.style.display = "none";
                                } else {
                                    y.style.display = "none";
                                }
                            }
                        </script>

                    </div>
                    <div class="col-xs-6 user-pad text-center">
                        <button onclick="show_comments()" type="button" class="btn btn-light" aria-pressed="true"><h3>Comments</h3>
                        <h4>{{count($user_info->comments)}}</h4></button>
                    </div>
                </div>

                <?php $content_num=5 ?>

                <div id="articles" class="row overview">
                    <div class="btn-group-vertical square">
                        @foreach($user_info->article as $title)
                            <a href="{{route('archieve_show',['id'=>$title->id])}}" class="btn btn-default">
                                <h3>{{$title->header}} <i>{{date('Y-m-d H:i', strtotime($title->created_at))}}</i></h3>
                            </a>
                        @endforeach

                        @if(!count($user_info->article))
                            <a href="#" class="btn btn-block btn-default">
                                <h3 class="fa fa-bell-o fa-3x">Not found article</h3>
                            </a>
                        @endif
                    </div>
                </div>

                <div style="display : none;" id="comments" class="row overview">
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
