@extends('layouts.card')

@section('card-header')
    {{ __('File Has Uploaded') }}
@endsection
@section('card-body')

    <h4>
        {{ __('You can share This Link for everyone wants to download the file:') }}
    </h4>
    <br/>
    <div class="row">
    <button class=" col-2 btn btn-secondary" title="copy in clipboard" onClick="copyClipBoard()">
        <i style="" class="fa fa-2x fa-clipboard"></i></button>
    <a class="col-10"  style="color:black;font-size:2em;" href="{{$fileLink}}">
        <input id="file_link" type="text" class="form-control" readonly="true" value="{{$fileLink}}" />
    </a>
    <div>

    <script type="text/javascript">
        function copyClipBoard(){
            let link = document.getElementById("file_link");
            link.select();
            document.execCommand("copy");
              alert("{{ __('the link has been copied into your clipboard: ') }}" + link.value);
        }
    </script>
@endsection
