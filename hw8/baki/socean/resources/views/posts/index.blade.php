@extends('layouts.app')

@section('content')
@foreach($posts as $post)
<div class="d-flex justify-content-center p-4">
    <div class="card" style="width: 100vw;max-width: 550px;">
        <div class="card-header bg-white">
            <a class="nav-link dropdown-toggle float-right text-dark pl-2" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#" style="display: inline"><i class="material-icons" style="font-size:20px">menu</i></a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" style="font-size: 14px" href="#">Edit</a>
            <a class="dropdown-item" style="font-size: 14px" href="#">Hide</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item font-weight-bold" style="font-size: 14px"  href="#">Delete</a>
    </div>
    <img src="{{$post->user->profile->image}}" alt="" style="background-image: url('/docs/4.0/assets/brand/bootstrap-solid.svg'); width: 50px; height: 50px; border-radius: 100%; margin-right: 5px"> <a class="text-dark" href="/profile/{{$post->user->id}}">{{$post->user->username}}</a>  <p class="d-inline-block float-right text-primary pt-2" style="font-size: 12px"> {{$post->created_at->diffForHumans() }}</p>
    </div>
        <div class="card-body bg-white">
                  <div class="carousel-inner" style="min-height: 400px;max-height: 400px">
                    <div class="carousel-item active" style="position: absolute;top: 50%;-ms-transform: translateY(-50%);transform: translateY(-50%)">
                      <img src="{{ url('/' .$post->image)}}" class="d-block w-100" alt="...">
                    </div>
                  </div>
          <p class="card-text pt-2" style="font-size: 14px">
            {{$post->caption}}
        </div>
        <div class="card-footer bg-white"> 
            <a href="#" class="text-dark" data-toggle="modal" data-target="#wholiked"><span class="badge badge-pill badge-light"><strong>578</strong> like</span>
            <a href="#" class="text-dark pl-3" data-toggle="modal" data-target="#whocommented"><span class="badge badge-pill badge-light ml-1"><strong>26</strong> comment</span></a>
            <a href="#" style="font-size: 20px;" class="text-danger float-right"><i class='fas fa-heart' style='font-size:36px;color:red'></i></a>
            <a href="post.html"><i class="material-icons float-right mr-3" style='font-size:36px;color:rgb(59, 59, 59)'>mode_comment</i></a>  
        </div>
      </div>
      
<div class="bg-white rounded-right border border-light" style="width: 300px">
  <div class="pre-scrollable" style="min-height: 570px">
    @foreach($post->comments as $comment)
      <div class="p-1 row card-header bg-white m-2">
          <div class="d-inline ml-1">
              <img width="40px" height="40px" src="{{$comment->user->profile->image}}" class="rounded-circle mt-1"> 
          </div>
            <div class="d-inline ml-2" style="width: 200px">
                <a class="text-dark small" href="/profile/{{$comment->user_id}}"><strong>{{$comment->user->username}}</strong> </a>  
                <!-- <p class="d-inline float-right text-muted m-3" style="font-size: 10px"> 1 Saat Önce</p> -->
            <p class=" mt-2 small text-muted rounded d-inline" style="width: auto">{{$comment->comment}}</p>
              </div>
        </div>
    @endforeach
  </div> 
  <hr>   
  <div class="pl-4">
      <div class="input-group-prepend pb-2">
          <form method="POST" action="/">
              @csrf
              <input hidden type="text" name="post_id" value="{{$post->id}}">
              <input type="text" name="comment" id="comment" placeholder="Write a comment..." style="border-top: none;border-left: none;border-right: none;width: 200px;outline: none;font-size: 14px;padding-left: 10px">
              <button style="background-color: transparent;border: none;outline: none" type="submit" href=""><i class="material-icons pl-3 text-primary" style="font-size:32px;display: inline;">send</i></button>
          </form>
      </div>
  </div>

</div>
</div>
@endforeach
@endsection