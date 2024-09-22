@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            {{-- <a href="{{ route('cast.index') }}" class="btn btn-outline-info col-md-2" data-toggle="tooltip"
                    title="Update a cast">List cast</a> --}}
            <div class="card">
                <div style="font-size: 100%" class="card-header text-uppercase label label-default"> cast Manage</div>
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
                        @if (!isset($cast))
                        {!! Form::open(['route'=>'cast.store','method'=>'POST']) !!}    
                        @else
                        {!! Form::open(['route'=>['cast.update',$cast->id],'method'=>'PUT']) !!}

                   @endif
                   <div class="form-group">
                            {!! Form::label('title', 'Title', []) !!}
                            {!! Form::text('title', isset($cast)?$cast->title:'', ['class'=>'form-control','placeholder'=>'Enter values..','id'=>'slug','onkeyup'=>'ChangeToSlug()','autofocus','oninvalid'=>'this.setCustomValidity("Enter Title Here")','oninput'=>'this.setCustomValidity("")']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('slug', 'Slug', []) !!}
                            {!! Form::text('slug', isset($cast)?$cast->slug:'', ['class'=>'form-control','placeholder'=>'Enter values..','id'=>'convert_slug']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('description', 'Description', []) !!}
                            {!! Form::textarea('description', isset($cast)?$cast->description:'', ['style'=>'resize:none','class'=>'form-control','placeholder'=>'Enter values..','id'=>'description', 'oninvalid'=>'this.setCustomValidity("Enter Description Here")','oninput'=>'this.setCustomValidity("")']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('Active', 'Active', []) !!}
                            {!! Form::select('status', ['1'=>'Hien thi','0'=>'Khong'],isset($cast)?$cast->status:'', ['class'=>'form-control']) !!}
                        </div>
                    @if (!isset($cast))
                   {!! Form::submit('Create ', ['class'=>'btn btn-success', 'data-toggles' => 'tooltip',
                   'data-placement' => 'bottom',
                   'title' => 'Create cast',]) !!}
                    @else
                    {!! Form::submit('Update', ['class'=>'btn btn-success', 'data-toggles' => 'tooltip',
                    'data-placement' => 'bottom',
                    'title' => 'Update cast',]) !!}
                    @endif
                   {!! Form::close() !!}
                </div>
            </div>
           
        </div>
    </div>
</div>
@endsection
