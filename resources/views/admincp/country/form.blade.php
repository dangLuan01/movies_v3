@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            {{-- <a href="{{ route('country.index') }}" class="btn btn-outline-info col-md-2" data-toggle="tooltip"
                    title="Update a country">List Country</a> --}}
            <div class="card">
                <div style="font-size: 100%" class="card-header text-uppercase label label-default"> Country Manage</div>
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error )
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>

                </div>
                    
                @endif
                @if (session('success_del'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @elseif (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @elseif (session('message_add'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('message_add') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @elseif (session('message_update'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('message_update') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                        @if (!isset($country))
                        {!! Form::open(['route'=>'country.store','method'=>'POST']) !!}    
                        @else
                        {!! Form::open(['route'=>['country.update',$country->id],'method'=>'PUT']) !!}

                   @endif
                   <div class="form-group">
                            {!! Form::label('title', 'Title', []) !!}
                            {!! Form::text('title', isset($country)?$country->title:'', ['class'=>'form-control','placeholder'=>'Enter values..','id'=>'slug','onkeyup'=>'ChangeToSlug()','autofocus','oninvalid'=>'this.setCustomValidity("Enter Title Here")','oninput'=>'this.setCustomValidity("")']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('slug', 'Slug', []) !!}
                            {!! Form::text('slug', isset($country)?$country->slug:'', ['class'=>'form-control','placeholder'=>'Enter values..','id'=>'convert_slug']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('description', 'Description', []) !!}
                            {!! Form::textarea('description', isset($country)?$country->description:'', ['style'=>'resize:none','class'=>'form-control','placeholder'=>'Enter values..','id'=>'description', 'oninvalid'=>'this.setCustomValidity("Enter Description Here")','oninput'=>'this.setCustomValidity("")']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('Active', 'Active', []) !!}
                            {!! Form::select('status', ['1'=>'Hien thi','0'=>'Khong'],isset($country)?$country->status:'', ['class'=>'form-control']) !!}
                        </div>
                    @if (!isset($country))
                   {!! Form::submit('Create ', ['class'=>'btn btn-success', 'data-toggles' => 'tooltip',
                   'data-placement' => 'bottom',
                   'title' => 'Create country',]) !!}
                    @else
                    {!! Form::submit('Update', ['class'=>'btn btn-success', 'data-toggles' => 'tooltip',
                    'data-placement' => 'bottom',
                    'title' => 'Update country',]) !!}
                    @endif
                   {!! Form::close() !!}
                </div>
            </div>
           
        </div>
    </div>
</div>
@endsection
