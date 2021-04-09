@extends('layouts.card')

@section('card-header')
    {{ __('Downloading The File') }}
@endsection
@section('card-body')
    <table class="table table-responsive">
        <tr>
            <th>{{ __('Original File Name')}}</th>
            <td>{{$file->name}}</td>
        </tr>
        <tr>
            <th>{{ __('Upload Time')}}</th>
            <td>{{$file->created_at}}</td>
            <td style="font-size:0.7em;">{{$file->created_at->diffForHumans()}}</td>
        </tr>
        <tr>
            <th>{{ __('Download Link')}}</th>
            <td>
                <a class="btn btn-success" href="{{route('file.download',['file'=>$file])}}">
                    <i class="fa fa-download animated faa-float faa-slow"></i> Download
                </a>
            </td>
        </tr>
    </table>

@endsection
