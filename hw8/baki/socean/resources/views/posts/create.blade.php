@extends('layouts.app')
@section('content')
    <form action="/p" enctype="multipart/form-data" method="POST">
        @csrf
    <div class="form-group row">
        <label for="caption" class="col-md-4 col-form-label text-md-right">{{ __('Post Caption') }}</label>

        <div class="col-md-6">
            <input id="caption" type="text" class="form-control @error('caption') is-invalid @enderror" name="caption" value="{{ old('name') }}"  autofocus>

            @error('caption')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div>
        <br>
        Post Image
        <br>
        <input type="file" id="image" name="image">

        @error('image')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    <div>
        <br>
        <button><strong>Share New Post</strong></button>
    </div>
</form>

@endsection