@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            {{-- <a href="{{ route('directors.index') }}" class="btn btn-outline-info col-md-2" data-toggle="tooltip"
                    title="Update a directors">List directors</a> --}}
            <div class="card">
                <div style="font-size: 100%" class="card-header text-uppercase label label-default"> Directors Manage</div>
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
                        @if (!isset($directors))
                        {!! Form::open(['route'=>'directors.store','method'=>'POST']) !!}    
                        @else
                        {!! Form::open(['route'=>['directors.update',$directors->id],'method'=>'PUT']) !!}

                   @endif
                   <div class="form-group">
                            {!! Form::label('title', 'Name', []) !!}
                            {!! Form::text('name', isset($directors)?$directors->name:'', ['class'=>'form-control','placeholder'=>'Enter values..','id'=>'slug','onkeyup'=>'ChangeToSlug()','autofocus','oninvalid'=>'this.setCustomValidity("Enter Title Here")','oninput'=>'this.setCustomValidity("")']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('slug', 'Slug', []) !!}
                            {!! Form::text('slug', isset($directors)?$directors->slug:'', ['class'=>'form-control','placeholder'=>'Enter values..','id'=>'convert_slug']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('description', 'Description', []) !!}
                            {!! Form::textarea('description', isset($directors)?$directors->description:'', ['style'=>'resize:none','class'=>'form-control','placeholder'=>'Enter values..','id'=>'description', 'oninvalid'=>'this.setCustomValidity("Enter Description Here")','oninput'=>'this.setCustomValidity("")']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('Active', 'Active', []) !!}
                            {!! Form::select('status', ['1'=>'Hien thi','0'=>'Khong'],isset($directors)?$directors->status:'', ['class'=>'form-control']) !!}
                        </div>
                    @if (!isset($directors))
                   {!! Form::submit('Create ', ['class'=>'btn btn-success', 'data-toggles' => 'tooltip',
                   'data-placement' => 'bottom',
                   'title' => 'Create directors',]) !!}
                    @else
                    {!! Form::submit('Update', ['class'=>'btn btn-success', 'data-toggles' => 'tooltip',
                    'data-placement' => 'bottom',
                    'title' => 'Update directors',]) !!}
                    @endif
                   {!! Form::close() !!}
                </div>
            </div>
           
        </div>
    </div>
</div>
@endsection
