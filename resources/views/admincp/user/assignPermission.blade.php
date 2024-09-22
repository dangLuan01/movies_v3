@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"> Quan Ly Nhanh Quyen User</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        {!! Form::open(['route' => ['assignPermissionsToUser', $user->id], 'method' => 'POST']) !!}
                        {{-- <div class="form-group">
                            <label for="">Permissions</label>
                            <select class="form-control" name="">
                                @foreach ($permission as $key => $per)
                                    <option value="{{ $per->id }}">{{ $per->name }}</option>
                                @endforeach

                            </select>
                        </div> --}}
                        <div class="form-group">
                            <label for="">Permissions</label>
                            <div class="form-check">
                                @foreach ($permission as $key => $per)
                                    <input class="form-check-input"
                                        @foreach ($all_column_per as $permission)
                                            @if ($permission->id == $per->id)
                                                checked
                                            @endif @endforeach
                                        type="checkbox" value="{{ $per->id }}" name="permission[]"
                                        id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        {{ $per->name }}
                                    </label>
                                @endforeach
                            </div>
                        </div>
                        {!! Form::submit('Cap nhat', ['class' => 'btn btn-success']) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
