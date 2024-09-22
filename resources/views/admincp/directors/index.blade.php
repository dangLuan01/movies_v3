@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                {{-- <a href="{{ route('directry.create') }}" class="btn btn-outline-info col-md-2" data-toggle="tooltip"
                    title="Update a directry">Create directry</a> --}}
                <div class="card">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>

                        </div>
                    @endif
                    <div style="font-size: 100%" class="card-header text-uppercase label label-default"> Directry Manage</div>

                    <!-- Button trigger modal -->
                    <button class="btn btn-success" data-toggle="modal" data-target="#exampleModal" data-backdrop="static"
                        data-keyboard="false">
                        Create
                    </button>
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div style="background-color: #fff;" class="modal-header">
                                    <h3 style="color: #000;" class="modal-title text-center">
                                        Create Director:
                                    </h3>
                                    @if (!isset($directors))
                                        {!! Form::open(['route' => 'directors.store', 'method' => 'POST']) !!}
                                    @else
                                        {!! Form::open(['route' => ['directors.update', $directors->id], 'method' => 'PUT']) !!}
                                    @endif
                                    <div class="form-group">
                                        {!! Form::label('title', 'Name', []) !!}
                                        {!! Form::text('name', isset($directors) ? $directors->name : '', [
                                            'class' => 'form-control',
                                            'placeholder' => 'Enter values..',
                                            'id' => 'slug',
                                            'onkeyup' => 'ChangeToSlug()',
                                            'autofocus',
                                            'oninvalid' => 'this.setCustomValidity("Enter Title Here")',
                                            'oninput' => 'this.setCustomValidity("")',
                                            'required',
                                            'style'=>'width:100%',
                                        ]) !!}
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('slug', 'Slug', []) !!}
                                        {!! Form::text('slug', isset($directors) ? $directors->slug : '', [
                                            'class' => 'form-control',
                                            'placeholder' => 'Enter values..',
                                            'id' => 'convert_slug',
                                            'required',
                                            'style'=>'width:100%',
                                        ]) !!}
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('description', 'Description', []) !!}
                                        {!! Form::textarea('description', isset($directors) ? $directors->description : '', [
                                            'style' => 'resize:none',
                                            'class' => 'form-control',
                                            'placeholder' => 'Enter values..',
                                            'id' => 'description',
                                            'oninvalid' => 'this.setCustomValidity("Enter Description Here")',
                                            'oninput' => 'this.setCustomValidity("")',
                                            'required',
                                            'style'=>'width:100%',
                                        ]) !!}
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('Active', 'Active', []) !!}
                                        {!! Form::select('status', ['1' => 'Hien thi', '0' => 'Khong'], isset($directors) ? $directors->status : '', [
                                            'class' => 'form-control','style'=>'width:100%',
                                        ]) !!}
                                    </div>
                                    @if (!isset($directors))
                                        {!! Form::submit('Add ', [
                                            'class' => 'btn btn-success',
                                            'data-toggles' => 'tooltip',
                                            'data-placement' => 'bottom',
                                            'title' => 'Create directors',
                                        ]) !!}
                                    @else
                                        {!! Form::submit('Update', [
                                            'class' => 'btn btn-success',
                                            'data-toggles' => 'tooltip',
                                            'data-placement' => 'bottom',
                                            'title' => 'Update directors',
                                        ]) !!}
                                    @endif
                                    {!! Form::close() !!}
                                </div>

                                <div style="background-color: #fff;" class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">
                                        Close
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="table" id="tablephim">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Description</th>
                                <th scope="col">Status</th>

                                <th scope="col">Manages</th>


                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($list as $key => $direc)
                                <tr>
                                    <th scope="row">{{ $key }}</th>
                                    <td>{{ $direc->name }}</td>
                                    <td>{{ $direc->description }}</td>
                                    <td>
                                        @if ($direc->status)
                                            Hien thi
                                        @else
                                            Khong hien thi
                                        @endif

                                    </td>

                                    <td>
                                        @can('delete directors')
                                            {!! Form::open([
                                                'method' => 'DELETE',
                                                'route' => ['directors.destroy', $direc->id],
                                                'onsubmit' => 'return confirm("Are you sure you want to delete directors ( ' . $direc->name . ' )?")',
                                            ]) !!}
                                            {{-- <button type="button" class="btn btn-danger" data-toggle="modal"
                                            data-target="#exampleModal" data-toggles="tooltip" title="delete a directry">
                                            Delete
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Delete</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Are you want to delete?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-primary">Confirm</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <br> --}}
                                            {!! Form::submit('Delete', [
                                                'class' => 'btn btn-danger',
                                                'data-toggles' => 'tooltip',
                                                'data-placement' => 'left',
                                                'title' => 'Delete directry',
                                            ]) !!}
                                            <br>
                                            <br>
                                            {!! Form::close() !!}
                                        @endcan
                                        @can('edit directors')
                                            <a data-id="{{ $direc->id }}" href="{{ route('directors.edit', $direc->id) }}"
                                                data-placement='left' data-toggles="tooltip" title="Update Directors"
                                                class="btn btn-warning">Update</a>
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
