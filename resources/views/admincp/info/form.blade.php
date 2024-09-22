@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                {{-- <a href="{{ route('info.index') }}" class="btn btn-outline-info col-md-2 " data-toggles="tooltip"
                    title="List info">List info</a> --}}

                <div class="card">
                    <div style="font-size: 100%" class="card-header text-uppercase label label-default">Info Manage</div>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
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
                        @can('update info')
                            @if (isset($info))
                                {!! Form::open([
                                    'route' => ['info-web.update', $info->id],
                                    'method' => 'PUT',
                                    'enctype' => 'multipart/form-data',
                                ]) !!}
                            @endif
                        @endcan

                        <div class="form-group">
                            {!! Form::label('title', 'Title Web', []) !!}
                            {!! Form::text('title', isset($info) ? $info->title : '', [
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
                            {!! Form::textarea('description', isset($info) ? $info->description : '', [
                                'style' => 'resize:none',
                                'class' => 'form-control',
                                'placeholder' => 'Enter values..',
                                'id' => 'description',
                                'oninvalid' => 'this.setCustomValidity("Enter Description Here")',
                                'oninput' => 'this.setCustomValidity("")',
                                'onchange' => 'description()',
                            ]) !!}
                        </div>

                        <div class="form-group" di>
                            {!! Form::label('Image', 'Logo Image', []) !!}
                            {!! Form::file('image', ['class' => 'form-control-file']) !!}
                            @if (isset($info))
                                <img dis width="20%"src="{{ asset('uploads/logo/' . $info->logo) }}">
                            @endif
                        </div>
                        {{-- @if (!isset($info))
                            {!! Form::submit('Create ', [
                                'class' => 'btn btn-success',
                                'data-toggles' => 'tooltip',
                                'data-placement' => 'bottom',
                                'title' => 'Create info',
                            ]) !!}
                        @else --}}
                        @can('update info')
                            {!! Form::submit('Update', [
                                'class' => 'btn btn-success',
                                'data-toggles' => 'tooltip',
                                'data-placement' => 'bottom',
                                'title' => 'Update info',
                            ]) !!}
                        @else
                            {!! Form::submit('Update', [
                                'class' => 'btn btn-success',
                                'data-toggles' => 'tooltip',
                                'data-placement' => 'bottom',
                                'title' => 'Update info',
                                'disabled',
                            ]) !!}
                        @endcan
                        {{-- @endif --}}

                        {!! Form::close() !!}

                    </div>
                </div>


            </div>
        </div>
    </div>
@endsection
