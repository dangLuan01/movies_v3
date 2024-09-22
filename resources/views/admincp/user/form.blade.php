@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"> Quan Ly Account</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        @if (!isset($user))
                            {!! Form::open(['route' => 'user.store', 'method' => 'POST']) !!}
                        @else
                            {!! Form::open(['route' => ['user.update', $user->id], 'method' => 'PUT']) !!}
                        @endif
                        <div class="form-group">
                            {!! Form::label('name', 'Name', []) !!}
                            {!! Form::text('name', isset($user) ? $user->name : '', [
                                'class' => 'form-control',
                                'placeholder' => 'Enter values..',
                            
                                'autofocus',
                                'required',
                                'oninvalid' => 'this.setCustomValidity("Enter Name Here")',
                                'oninput' => 'this.setCustomValidity("")',
                            ]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('email', 'Email', []) !!}
                            {!! Form::text('email', isset($user) ? $user->email : '', [
                                'class' => 'form-control',
                                'placeholder' => 'Enter values..',
                            ]) !!}
                        </div>
                        @if (!isset($user))
                            <div class="form-group">
                                {!! Form::label('password', 'Password', []) !!}
                                {!! Form::text('password', isset($user) ? $user->password : '', [
                                    'style' => 'resize:none',
                                    'class' => 'form-control',
                                    'placeholder' => 'Enter values..',
                                
                                    'required',
                                    'oninvalid' => 'this.setCustomValidity("Enter password Here")',
                                    'oninput' => 'this.setCustomValidity("")',
                                ]) !!}
                            </div>
                        @endif

                        <div class="form-group">
                            <label for="">Role</label>
                            <select class="form-control" name="role">
                                @foreach ($role as $key => $ro)
                                    @if (isset($user) && isset($all_column_role))
                                        <option value="{{ $ro->id }}"
                                            {{ $ro->id == $all_column_role->id ? 'selected' : '' }}>{{ $ro->name }}
                                        </option>
                                    @else
                                        <option value="{{ $ro->id }}">{{ $ro->name }}</option>
                                    @endif
                                @endforeach

                            </select>
                        </div>
                        {{-- <div class="form-group">
                            {!! Form::label('Permissions', 'Permissions', []) !!}
                            {!! Form::select('permissions', ['0' => 'Admin', '1' => 'User'], isset($user) ? $user->role : '', [
                                'class' => 'form-control',
                            ]) !!}
                        </div> --}}
                        @if (!isset($user))
                            {!! Form::submit('Them ', ['class' => 'btn btn-success']) !!}
                        @else
                            {!! Form::submit('Cap nhat', ['class' => 'btn btn-success']) !!}
                        @endif
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
