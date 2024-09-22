@extends('layouts.app')

@section('content')
    <pre id="output"></pre>
    <script>
        var file = "{{ $data->file }}";
        var path_file = file.toString().split('.');
        var path = path_file[1];

        if (path == 'pdf') {

            jQuery("#output").html(
                '<iframe style="width:100%; height:600px" src="/assets/' + file + '" frameborder="0"></iframe>');
        } else if (path == 'mp4') {
          jQuery("#output").html(
                '<video controls style="width:100%; height:600px" src="/assets/' + file + '" frameborder="0"></video>');
        } else {
            const file_url = "/assets/{{ $data->file }}";
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                document.getElementById("output").innerHTML = this.responseText;
            }
            xhttp.open("GET", file_url);
            xhttp.send();
        }
    </script>
@endsection
