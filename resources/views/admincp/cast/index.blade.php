@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error )
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>

                </div>
                @endif
                {{-- <a href="{{ route('casttry.create') }}" class="btn btn-outline-info col-md-2" data-toggle="tooltip"
                    title="Update a casttry">Create casttry</a> --}}
                <div class="card">
                    <div style="font-size: 100%" class="card-header text-uppercase label label-default"> casttry Manage</div>
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
                                        Create Actor:
                                    </h3>
                                    @if (!isset($cast))
                                    {!! Form::open(['route'=>'cast.store','method'=>'POST']) !!}    
                                    @else
                                    {!! Form::open(['route'=>['cast.update',$cast->id],'method'=>'PUT']) !!}
            
                               @endif
                               <div class="form-group">
                                        {!! Form::label('title', 'Title', []) !!}
                                        {!! Form::text('title', isset($cast)?$cast->title:'', ['class'=>'form-control','style'=>'width:100%','placeholder'=>'Enter values..','id'=>'slug','onkeyup'=>'ChangeToSlug()','autofocus','oninvalid'=>'this.setCustomValidity("Enter Title Here")','oninput'=>'this.setCustomValidity("")']) !!}
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('slug', 'Slug', []) !!}
                                        {!! Form::text('slug', isset($cast)?$cast->slug:'', ['class'=>'form-control','style'=>'width:100%','placeholder'=>'Enter values..','id'=>'convert_slug']) !!}
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('description', 'Description', []) !!}
                                        {!! Form::textarea('description', isset($cast)?$cast->description:'', ['style'=>'resize:none','style'=>'width:100%','class'=>'form-control','placeholder'=>'Enter values..','id'=>'description', 'oninvalid'=>'this.setCustomValidity("Enter Description Here")','oninput'=>'this.setCustomValidity("")']) !!}
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('Active', 'Active', []) !!}
                                        {!! Form::select('status', ['1'=>'Hien thi','0'=>'Khong'],isset($cast)?$cast->status:'', ['class'=>'form-control','style'=>'width:100%',]) !!}
                                    </div>
                                @if (!isset($cast))
                               {!! Form::submit('Add ', ['class'=>'btn btn-success', 'data-toggles' => 'tooltip',
                               'data-placement' => 'bottom',
                               'title' => 'Create cast',]) !!}
                                @else
                                {!! Form::submit('Update', ['class'=>'btn btn-success', 'data-toggles' => 'tooltip',
                                'data-placement' => 'bottom',
                                'title' => 'Update cast',]) !!}
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
                                <th scope="col">Title</th>
                                <th scope="col">Description</th>
                                <th scope="col">Status</th>
                                <th scope="col">Manages</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($list as $key => $cast)
                                <tr>
                                    <th scope="row">{{ $key }}</th>
                                    <td>{{ $cast->title }}</td>
                                    <td>{{ $cast->description }}</td>
                                    <td>
                                        @if ($cast->status)
                                            Hien thi
                                        @else
                                            Khong hien thi
                                        @endif

                                    </td>
                                    <td>
                                        {!! Form::open([
                                            'method' => 'DELETE',
                                            'route' => ['cast.destroy', $cast->id],
                                             'onsubmit' => 'return confirm("Are you sure you want to delete casttry ( '.$cast->title.' )?")',
                                        ]) !!}
                                        {{-- <button type="button" class="btn btn-danger" data-toggle="modal"
                                            data-target="#exampleModal" data-toggles="tooltip" title="delete a casttry">
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
                                        {!! Form::submit('Delete', ['class' => 'btn btn-danger', 'data-toggles' => 'tooltip',
                                        'data-placement' => 'left',
                                        'title' => 'Delete casttry',]) !!}
                                        <br>
                                        <br>
                                        {!! Form::close() !!}
                                        <a href="{{ route('cast.edit', $cast->id) }}" data-placement = 'left' data-toggles="tooltip" title="Update Actor" class="btn btn-warning">Update</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endsection
