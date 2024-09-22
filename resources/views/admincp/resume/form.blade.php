@extends('layouts.app')

@section('content')
    <div class="container">
        
        <form action="{{ url('admin/uploadpage') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="text" name="name" id="">
            <input type="file" name="file" id="">
            <input type="submit" value="Upload">
        </form>
        <br>
        <a href="{{ url('admin/show-resume') }}"><button class="btn btn-success">Show</button></a>
       
    </div>
@endsection