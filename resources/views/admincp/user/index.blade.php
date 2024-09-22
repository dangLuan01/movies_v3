@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <table class="table" id="tablephim">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Role</th>
                            <th scope="col">Manages</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($list as $key => $use)
                            <tr>
                                <th scope="row">{{ $key }}</th>
                                <td>{{ $use->name }}</td>
                                <td>{{ $use->email }}</td>
                                <td style="text-transform: uppercase;">
                                    @foreach ($use->roles as $role)
                                        {{ $role->name }}
                                    @endforeach
                                </td>

                                <td>
                                    {!! Form::open([
                                        'method' => 'DELETE',
                                        'route' => ['user.destroy', $use->id],
                                        'onsubmit' => 'return confirm("Are you sure you want to delete this ( ' . $use->name . ' )?")',
                                    ]) !!}
                                    @can('delete user')
                                        {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                                        <br>
                                        <br>
                                    @endcan
                                    {!! Form::close() !!}
                                    @can('edit user')
                                        <a href="{{ route('user.edit', $use->id) }}" class="btn btn-warning">Update</a>
                                        <br>
                                        <a style="margin-top: 20px;" href="{{ route('assignpermissionuser', $use->id) }}"
                                            class="btn btn-success">Permission</a>
                                    @endcan
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
