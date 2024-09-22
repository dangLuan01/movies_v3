@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                {{-- <a href="{{ route('genre.create') }}" class="btn btn-outline-info col-md-2" data-toggles="tooltip"
                    title="Create a Genre">Create Genre</a> --}}
                <div class="card">
                    <div style="font-size: 100%" class="card-header text-uppercase label label-default"> Genre Manage</div>
                    @if (session('success_del'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success_del') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @elseif (session('error'))
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
                            @foreach ($list as $key => $gen)
                                <tr>
                                    <th scope="row">{{ $key }}</th>
                                    <td>{{ $gen->title }}</td>
                                    <td>{{ $gen->description }}</td>
                                    <td>
                                        @if ($gen->status)
                                            Hien thi
                                        @else
                                            Khong hien thi
                                        @endif

                                    </td>
                                    <td>
                                        {!! Form::open([
                                            'method' => 'DELETE',
                                            'route' => ['genre.destroy', $gen->id],
                                            'onsubmit' => 'return confirm("Are you sure you want to delete genre ( '.$gen->title.' )?")',
                                        ]) !!}
                                        {{-- <button type="button" class="btn btn-danger" data-toggle="modal"
                                            data-target="#exampleModal" data-toggles="tooltip" title="delete a genre">
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
                                        {!! Form::submit('Delete', ['class' => 'btn btn-danger','data-toggles'=>'tooltip','data-placement'=>'left','title'=>'Delete genre']) !!}
                                        <br>
                                        <br>
                                        {!! Form::close() !!}
                                        <a href="{{ route('genre.edit', $gen->id) }}" data-toggles="tooltip",
                                            data-placement = 'left', title="Update genre" class="btn btn-warning">Update</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endsection
