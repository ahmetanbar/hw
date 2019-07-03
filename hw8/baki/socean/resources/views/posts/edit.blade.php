@extends('layouts.app')
@section('content')

    <div class="form-group row">

        <div class="col-md-6">
            <form action="{{ route('posts.update', $post->id) }}" enctype="multipart/form-data" method="POST">
                @method('PATCH')
                @csrf
                <label for="caption" class="col-md-4 col-form-label text-md-right">{{ __('Post Caption') }}</label>
                <input id="caption" type="text" class="form-control @error('caption') is-invalid @enderror" name="caption" value="{{$post->caption}}"  autofocus>
                @error('caption')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <br>
                <button type="submit"><strong>Share New Post</strong></button>
            </form>
        </div>
    </div>


@endsection