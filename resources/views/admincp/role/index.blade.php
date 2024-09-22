@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div>
                <h4>Manage Role</h4>
            </div>
            <div class="col-md-12">
                <table class="table" id="tablephim">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name Role</th>
                            <th scope="col">Has Permission</th>
                            <th scope="col">Manages</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rolesWithPermissions as $key => $role)
                            @php
                                $roleName = $role->name;
                                $permissions = $role->permissions->pluck('name')->toArray();
                                $permission = join(', ', $permissions);
                            @endphp
                            <tr>
                                <th scope="row">{{ $key }}</th>
                                <td>{{ $role->name }}</td>
                                <td style="text-transform: capitalize;">{!! $permission !!}</td>
                                <td>
                                    {!! Form::open([
                                        'method' => 'DELETE',
                                        'route' => ['role.destroy', $role->id],
                                        'onsubmit' => 'return confirm("Are you sure you want to delete this ( ' . $role->name . ' )?")',
                                    ]) !!}
                                    {!! Form::submit('Delete', ['class' => 'btn btn-danger', '']) !!}
                                    <br>
                                    <br>
                                    {!! Form::close() !!}
                                    <a href="{{ route('role.edit', $role->id) }}" class="btn btn-warning">Update</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
@endsection
