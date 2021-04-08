@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    <h3 >
                        {{__('You can Upload a file and share it with your friends')}}
                    </h3>
                    <br/>
                    <a class="btn btn-primary" href="">
                        <i class="fas fa-cloud-upload-alt animated faa-vertical faa-slow"></i>
                        Upload a File
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
