@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                {{-- <a href="{{ route('server.index') }}" class="btn btn-outline-info col-md-2 " data-toggles="tooltip"
                    title="List server">List server</a> --}}

                <div class="card">
                    <div style="font-size: 100%" class="card-header text-uppercase label label-default">Server Manage</div>
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error )
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>

                    </div>
                        
                    @endif

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        @if (!isset($server))
                            {!! Form::open(['route' => 'server-movie.store', 'method' => 'POST']) !!}
                        @else
                            {!! Form::open(['route' => ['server-movie.update', $server->id], 'method' => 'PUT']) !!}
                        @endif
                        <div class="form-group">
                            {!! Form::label('title', 'Title', []) !!}
                            {!! Form::text('title', isset($server) ? $server->title : '', [
                                'class' => 'form-control',
                                'placeholder' => 'Enter values..',
                                'autofocus',
                                'onchange' => 'title()',
                                'oninvalid' => 'this.setCustomValidity("Enter Title Here")',
                                'oninput' => 'this.setCustomValidity("")',
                            ]) !!}
                        </div>
                     
                        <div class="form-group">
                            {!! Form::label('description', 'Description', []) !!}
                            {!! Form::textarea('description', isset($server) ? $server->description : '', [
                                'style' => 'resize:none',
                                'class' => 'form-control',
                                'placeholder' => 'Enter values..',
                                'id' => 'description',                            
                                'oninvalid' => 'this.setCustomValidity("Enter Description Here")',
                                'oninput' => 'this.setCustomValidity("")',
                                'onchange' => 'description()',
                            ]) !!}
                        </div>
                        
                        <div class="form-group">
                            {!! Form::label('Active', 'Active', []) !!}
                            {!! Form::select('status', ['1' => 'Hien thi', '0' => 'Khong'], isset($server) ? $server->status : '', [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                       
                        @if (!isset($server))
                            {!! Form::submit('Create ', [
                                'class' => 'btn btn-success',
                                'data-toggles' => 'tooltip',
                                'data-placement' => 'bottom',
                                'title' => 'Create server',
                            ]) !!}
                        @else
                            {!! Form::submit('Update', [
                                'class' => 'btn btn-success',
                                'data-toggles' => 'tooltip',
                                'data-placement' => 'bottom',
                                'title' => 'Update server',
                            ]) !!}
                        @endif

                        {!! Form::close() !!}

                    </div>
                </div>


            </div>
        </div>
    </div>
@endsection
