@extends('layouts.app')

@section('css')
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
@endsection

@section('content')
    <div class="container">
        <div style="font-size: 100%;" class="card-header text-uppercase label label-default">Manage episodes</div>

        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card">
                   
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        @if (!isset($episode))
                            {!! Form::open(['route' => 'episode.store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                        @else
                            {!! Form::open([
                                'route' => ['episode.update', $episode->id],
                                'method' => 'PUT',
                                'enctype' => 'multipart/form-data',
                            ]) !!}
                        @endif

                        <div class="form-group">
                            {!! Form::label('movie', 'Choose movie', []) !!}
                            {!! Form::select('movie_id', [' '=>'Select Movie','List Movies' => $list_movie], isset($episode) ? $episode->movie_id : '', [
                                'class' => 'form-control select-movie selectpicker',
                                'data-live-search' => 'true',
                                isset($episode) ? 'disabled' : '',
                            ]) !!}
                        </div>


                        <div class="form-group" dis>
                            {!! Form::label('link', 'Link', []) !!}
                            {!! Form::text('link', isset($episode) ? $episode->linkphim : '', [
                                'class' => 'form-control',
                                'placeholder' => 'Enter link server..',
                                'required',
                            ]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('link', 'Link Download', []) !!}
                            {!! Form::text('linkdownload', isset($episode) ? $episode->linkdownload : '', [
                                'class' => 'form-control',
                                'placeholder' => 'Enter link download..',
                            ]) !!}
                        </div>
                        @if (isset($episode))
                            <div class="form-group">
                                {!! Form::label('episode', 'Tap phim', []) !!}
                                {!! Form::text('episode', isset($episode) ? $episode->episode : '', [
                                    'class' => 'form-control',
                                    'placeholder' => '...',
                                    isset($episode) ? 'readonly' : '',
                                ]) !!}

                            </div>
                        @else
                            <div class="form-group">
                                {!! Form::label('episode', 'Tap phim', []) !!}

                                <select name="episode" class="form-control" id="show_movie" required>

                                </select>
                            </div>
                        @endif
                        <div class="form-group">
                            {!! Form::label('server', 'Server Movie', []) !!}
                            {!! Form::select('servermovie',$list_server,isset($episode) ? $episode->server_id : '', ['class' => 'form-control',
                            ]) !!}
                        </div>

                        @if (!isset($episode))
                            {!! Form::submit('Create ', ['class' => 'btn btn-success', 'data-toggles' => 'tooltip',
                            'data-placement' => 'bottom',
                            'title' => 'Create episode',]) !!}
                        @else
                            {!! Form::submit('Update', ['class' => 'btn btn-success', 'data-toggles' => 'tooltip',
                            'data-placement' => 'bottom',
                            'title' => 'Update episode',]) !!}
                        @endif
                        {!! Form::close() !!}
                    </div>
                </div>
             
            </div>
        </div>

    </div>

@endsection
@section('js')
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
@endsection
