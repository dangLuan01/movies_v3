@extends('layouts.app')

@section('content')
    <div class="container">
        <table border="1">
            <tr>
                <th>Name</th>
                <th>View</th>
                <th>Download</th>
                <th>URL</th>
                <th>Action</th>
            </tr>
            @foreach ($data as $data)
                <tr>
                    <th>{{ $data->name }}</th>
                    <th><a href="{{ url('admin/view-resume',$data->id) }}">View</a></th>
                    <th><a href="{{ url('admin/download',$data->file) }}">Download</a></th>
                    <th>{!! $data->file !!}</th>
                    <th>
                        <form action="{{ route('delete_resume',[$data->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Are you sure?')" >Delete</button>
                        </form>
                    </th>  
                </tr>
            @endforeach
        </table>



    </div>
@endsection
