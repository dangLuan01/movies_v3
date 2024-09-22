@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"> Thêm Vai Trò</div>
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

                        @if (!isset($role))
                            {!! Form::open(['route' => 'role.store', 'method' => 'POST']) !!}
                        @else
                            {!! Form::open(['route' => ['role.update', $role->id], 'method' => 'PUT']) !!}
                        @endif
                        <div class="form-group" style="width: 55%">
                            {!! Form::label('name', 'Name Role', []) !!}
                            {!! Form::text('name', isset($role) ? $role->name : '', [
                                'class' => 'form-control',
                                'placeholder' => 'Enter values..',
                                'autofocus',
                                'required',
                                'oninvalid' => 'this.setCustomValidity("Enter Name Here")',
                                'oninput' => 'this.setCustomValidity("")',
                                // isset($role)?'readOnly' : '',
                            ]) !!}
                        </div>
                        @if (!isset($role))
                            <div class="form-group" style="width: 50%">
                                <label><strong> Permissions</strong></label><br />
                                <select id="show_permission" multiple data-live-search="true"
                                    class="form-control selects selectpicker shown" name="permissions[]">
                                    <option disabled>---Permission:...---</option>
                                    @foreach ($listPermission as $permission)
                                        <option>{{ $permission->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif


                        @if (!isset($role))
                            {!! Form::submit('Thêm ', ['class' => 'btn btn-success']) !!}
                        @else
                            {!! Form::submit('Lưu', ['class' => 'btn btn-success']) !!}
                        @endif
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card">

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        @if (!isset($role))
                            {!! Form::open(['route' => 'permissions', 'method' => 'POST']) !!}
                        @else
                            {{-- {!! Form::open(['route' => ['role.update', $role->id], 'method' => 'PUT']) !!} --}}
                        @endif
                        <div class="form-group" style="width: 55%">
                            {!! Form::label('name', 'Name Permissions', []) !!}
                            {!! Form::text('name', '', [
                                'class' => 'form-control',
                                'placeholder' => 'Enter values..',
                                'required',
                                'oninvalid' => 'this.setCustomValidity("Enter Name Here")',
                                'oninput' => 'this.setCustomValidity("")',
                            ]) !!}
                        </div>


                        @if (!isset($role))
                            {!! Form::submit('Them ', ['class' => 'btn btn-success']) !!}
                        @else
                            {{-- {!! Form::submit('Cap nhat', ['class' => 'btn btn-success']) !!} --}}
                        @endif
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {

            $('.selects').selectpicker();

        });
    </script>
@endsection
