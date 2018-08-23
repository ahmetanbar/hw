@extends('layouts.app')

@section('content')

    <a href="./" class="btn btn-default">Go Back</a>
    <br>
    <br>

    @if(count($artcomment)>0)
        @foreach($artcomment as $article)
            <?php $index= array_search($article, $artcomment); ?>
            @if(!$index)
                <nav class="nav navbar-nav">
                    <i class="material-icons  md-30">date_range</i>
                    <i class="nav-link" >{{date('Y-m-d H:i', strtotime($article['created_at']))}}</i>
                    <i class="material-icons" >account_balance</i>
                    <a class="nav-link" href="{{route('categorize',['category' => $article['category']]) }}">{{$article['category']}}</a>
                    <i class="material-icons" >account_circle </i>
                    <a class="nav-link" href="{{route('profile_show',['id' => $article['username']])}}">{{$article['name']}} {{$article['surname']}}</a>
                </nav>

                <nav class="nav navbar-nav navbar-right">
                    <i class="material-icons">comment</i>
                    <i class="nav-link">Comments: {{$article['comments']}}</i>
                    <i class="material-icons">assessment</i>
                    <i class="nav-link">Views: {{$article['viewing']}}</i>
                </nav>
                <br>
                <h1>{{$article['header']}}</h1>

                <div>
                    {{$article['article']}}
                </div>

                <small>Written on {{$article['created_at']}}</small>

                <br>
                <br>
                @include('inc.messages')



                    @guest
                        <span style="color:#c30000;">For comment you should <a color:red href="{{route('login')}}">Log In</a></span>
                    @else
                        {!! Form::open(['action' => 'ArticleController@store','method'=>'POST']) !!}
                        <div class="form-group">
                            {{Form::textarea('comment','',['class'=>'form-control','placeholder'=>'Write your comment..'])}}
                        </div>
                        {{Form::hidden('art_id', $article['id'])}}

                        {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
                        {!! Form::close() !!}
                    @endguest


                <hr>
            @else
                <p><a href="{{route('profile_show',['id' => $article['username']])}}">{{$article['name'] }} {{$article['surname'] }}</a> -> {{$article['comment'] }} -- {{date('Y-m-d H:i', strtotime($article['created_at']))}}</p>
            @endif

        @endforeach
    @else
        <p>No article found</p>
    @endif

@endsection
