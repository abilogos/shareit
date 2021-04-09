@extends('layouts.card')

@section('card-header')
    {{ __('Dashboard') }}
@endsection
@section('card-body')
    <h3 >
        {{__('You can Upload a file and share it with your friends')}}
    </h3>
    <br/>
    <a id="btn-file-create" class="btn btn-primary" href="{{route('file.create')}}">
        <i class="fas fa-cloud-upload-alt animated faa-vertical faa-slow"></i>
        Upload a File
    </a>
    <a id="btn-file-index" class="btn btn-info" href="{{route('file.index')}}">
        <i class="fas fa-th-list animated faa-pulse faa-slow"></i>
        View List of Uploaded Files
    </a>
@endsection
