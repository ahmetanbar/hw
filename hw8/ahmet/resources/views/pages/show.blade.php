@extends('layouts.app')

@section('content')

    <a href="./" class="btn btn-default">Go Back</a>
    <br>
    <br>

    @if(count($article)>0)
        @foreach($article as $article)

            <nav class="nav navbar-nav">
                <i class="material-icons  md-30">date_range</i>
                <a class="nav-link" href="./{{$article->id}}">{{date('Y-m-d H:i', strtotime($article->created_at))}}</a>
                <i class="material-icons" >account_balance</i>
                <a class="nav-link" href="/archieve/category/{{$article->category}}">{{$article->category}}</a>
                <i class="material-icons" >account_circle </i>
                <a class="nav-link" href="profile/{{$article->author_id}}">{{$article->name}} {{$article->surname}}</a>
            </nav>

            <nav class="nav navbar-nav navbar-right">
                <i class="material-icons">comment</i>
                <a class="nav-link" href="./{{$article->id}}">Comments: {{$article->comments}}</a>
                <i class="material-icons">assessment</i>
                <a class="nav-link" href="./{{$article->id}}">Views: {{$article->viewing}}</a>
            </nav>
            <br>
            <h1>{{$article->header}}</h1>

            <div>
                {{$article->article}}
            </div>

            <small>Written on {{$article->created_at}}</small>

            <br>
            <br>
            @include('inc.messages')


            {!! Form::open(['action' => 'ArticleController@store','method'=>'POST']) !!}
                <div class="form-group">
                    {{Form::textarea('comment','',['class'=>'form-control','placeholder'=>'Write your comment..'])}}
                </div>
                @guest
                    <span style="color:#c30000;">For comment you should <a color:red href="login.php">Log In</a></span>
                @else
                    {{Form::hidden('art_id', $article->id)}}

                    {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
                @endguest
            {!! Form::close() !!}



            {{--<form method="post" autocomplete="off" accept-charset="UTF-8" action="">--}}
                {{--<div class="form-group">--}}
                    {{--<textarea class="form-control" rows="5" id="comment" placeholder="Write your comment.."></textarea>--}}
                {{--</div>--}}

                {{--@guest--}}
                    {{--<span style="color:#c30000; text-align:auto; ">For comment you should <a color:red href="login.php">Log In</a></span>--}}
                {{--@else--}}
                    {{--<button type="submit" class="btn btn-primary">Send</button>--}}
                {{--@endguest--}}

            {{--</form>--}}


            <hr>

        @endforeach
    @else
        <p>No article found</p>
    @endif



@endsection
