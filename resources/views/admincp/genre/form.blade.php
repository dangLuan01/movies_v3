@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            {{-- <a href="{{ route('genre.index') }}" class="btn btn-outline-info col-md-2"
                    data-toggle="tooltip" title="List category">List Genre</a> --}}
            <div class="card">
                <div style="font-size: 100%" class="card-header text-uppercase label label-default"> Genre Manage</div>
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
                    @elseif (session('error_add'))
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
                        @if (!isset($genre))
                        {!! Form::open(['route'=>'genre.store','method'=>'POST']) !!}    
                        @else
                        {!! Form::open(['route'=>['genre.update',$genre->id],'method'=>'PUT']) !!}

                   @endif
                   <div class="form-group">
                            {!! Form::label('title', 'Title', []) !!}
                            {!! Form::text('title', isset($genre)?$genre->title:'', ['class'=>'form-control','placeholder'=>'Enter values..','id'=>'slug','onkeyup'=>'ChangeToSlug()','autofocus','oninvalid'=>'this.setCustomValidity("Enter Title Here")','oninput'=>'this.setCustomValidity("")']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('slug', 'Slug', []) !!}
                            {!! Form::text('slug', isset($genre)?$genre->slug:'', ['class'=>'form-control','placeholder'=>'Enter values..','id'=>'convert_slug']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('description', 'Description', []) !!}
                            {!! Form::textarea('description', isset($genre)?$genre->description:'', ['style'=>'resize:none','class'=>'form-control','placeholder'=>'Enter values..','id'=>'description','oninvalid'=>'this.setCustomValidity("Enter Description Here")','oninput'=>'this.setCustomValidity("")']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('Active', 'Active', []) !!}
                            {!! Form::select('status', ['1'=>'Hien thi','0'=>'Khong'],isset($genre)?$genre->status:'', ['class'=>'form-control']) !!}
                        </div>
                    @if (!isset($genre))
                   {!! Form::submit('Create ', ['class'=>'btn btn-success',
                   'data-placement' => 'bottom', 'data-toggles' => 'tooltip',
                   'title' => 'Create genre',]) !!}
                    @else
                    {!! Form::submit('Update', ['class'=>'btn btn-success',
                    'data-placement' => 'bottom', 'data-toggles' => 'tooltip',
                    'title' => 'Update genre',]) !!}
                    @endif
                   {!! Form::close() !!}
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection
