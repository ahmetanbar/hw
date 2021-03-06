@extends('layouts.app')

@section('content')
    <a href="./" class="btn btn-default">Go Back</a>
    <br>
    <br>
    @if(count($article)>0)
            <nav class="nav navbar-nav">
                <i class="material-icons  md-30">date_range</i>
                <i class="nav-link" >{{date('Y-m-d H:i', strtotime($article->created_at))}}</i>
                <i class="material-icons" >account_balance</i>
                <a class="nav-link" href="{{route('categorize',['category' => $article->category->name]) }}">{{$article->category->name}}</a>
                <i class="material-icons" >account_circle </i>
                <a class="nav-link" href="{{route('profile_show',['id' => $article->user->username])}}">{{$article->user->name}} {{$article->user->surname}}</a>
            </nav>

            <nav class="nav navbar-nav navbar-right">
                <i class="material-icons">comment</i>
                <i class="nav-link">Comments: {{$article->comment_num}}</i>
                <i class="material-icons">assessment</i>
                <i class="nav-link">Views: {{$article->view_num}}</i>
            </nav>
            <br>
            <h1>{{$article->header}}</h1>

            <div>
                {!!  $article->article!!}
            </div>

            <small>Written on {{$article->created_at}}</small>

            <br>
            <br>
            @include('inc.messages')



                @guest
                    <span style="color:#c30000;">For comment you should <a color:red href="{{route('login')}}">Log In</a></span>
                @else
                    {!! Form::open(['action' => 'CommentController@store','method'=>'POST']) !!}
                    <div class="form-group">
                        {{Form::textarea('comment','',['class'=>'form-control','placeholder'=>'Write your comment..' , 'rows' => 4, 'cols' => 60 , 'style' => 'width: auto'])}}
                    </div>
                    {{Form::hidden('art_id', $article['id'])}}

                    {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
                    {!! Form::close() !!}
                @endguest

                <hr>
            <?php

            $comments=$article->comments;

            foreach ($comments->where('status',0) as $comment) { ?>
            <?php
                if(isset($edit_comment) && $edit_comment==$comment){ ?>
                    {{ Form::model($edit_comment, array('route' => array('update_comment', $edit_comment->id), 'method' => 'PUT')) }}
                        {{ csrf_field() }}
                        <div class="form-group">
                            {{ Form::textarea('comment', null, array('class' => 'form-control' , 'rows' => 4, 'cols' => 60 , 'style' => 'width: auto')) }}
                        </div>

                        {{ Form::submit('Edit!', array('class' => 'btn btn-primary')) }}

                {{ Form::close() }}

            <?php } else{ ?>
            <p><a href="{{route('profile_show',['id' => $comment->user->username])}}">{{$comment->user->name }} {{$comment->user->surname }}</a> -> {{$comment->comment }} -- {{date('Y-m-d H:i', strtotime($comment->created_at))}}</p>

            <?php }
            }
            ?>
    @else
        <p>No article found</p>
    @endif
@endsection
