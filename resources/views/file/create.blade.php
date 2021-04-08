@extends('layouts.card')

@section('card-header')
    {{ __('Upload File To Share') }}
@endsection
@section('card-body')
    <form  class="form" method="post" action="{{route('file.store')}}">
        @csrf
        <input type="file" name="file" id="file-input" class="form-control "/>
        <br/>
        <button id="btn-file-create" class="btn btn-success" >
            <i class="fas fa-cloud-upload-alt animated faa-vertical faa-slow"></i>
            Upload
        </button>
        @error('file')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </form>

@endsection
