@extends('layouts.card')

@section('card-header')
    {{ __('Downloading The File') }}
@endsection
@section('card-body')
    <span style="font-size:0.7em;color:gray;">
        you can send page size in query string like {{route('file.index')}}?page_size=10
    </span>
    @isset($files)
            {{$files->links('pagination::bootstrap-4')}}
        <table class="table table-responsive table-hover">
            <caption>{{ __('your files') }}</caption>
            <thead class="thead-dark">
            <tr>
                <th>{{ __('Index')}}</th>
                <th>{{__('Original file name')}}</th>
                <th>{{__('Download page link')}}</th>
                <th>{{__('Upload Time')}}</th>
                <th>{{__('Download count')}}</th>
                <th>{{__('Delete')}}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($files as $file)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$file->name}}</td>
                    <td><a href="{{$file->link}}">{{$file->link}}</a></td>
                    <td title="{{$file->created_at->diffForHumans()}}">{{$file->created_at}}</td>
                    <td>{{$file->download_count}}</td>
                    <td></td>
                </tr>
            @endforeach
        </tbody>
        </table>
    @endisset
@endsection
