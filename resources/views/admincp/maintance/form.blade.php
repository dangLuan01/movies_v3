@extends('layouts.app')

@section('content')
    <div class="container">
        @role('admin')
            <a href="{{ route('down') }}"><button class="btn btn-primary mb-5">Maintance On</button></a>
            <a href="{{ route('up') }}"><button class="btn btn-primary mb-5">Maintance Off</button></a>
        @else
            <a href="javascript:void(0)"><button disabled class="btn btn-primary mb-5">Maintance On</button></a>
            <a href="javascript:void(0)"><button disabled class="btn btn-primary mb-5">Maintance Off</button></a>
        @endrole
    </div>
    <span>
        http://.../devmagic
    </span>
@endsection
