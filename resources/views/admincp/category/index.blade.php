@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                {{-- <a href="{{ route('category.create') }}" class="btn btn-outline-info col-md-2" data-toggles="tooltip"
                    title="Update a category">Create Category</a> --}}
                <div class="card">

                    <div style="font-size: 100%" class="card-header text-uppercase label label-default"> Category Manage</div>
                    

                    <table class="table" id="tablephim">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Title</th>
                                <th scope="col">Description</th>
                                <th scope="col">Status</th>
                                <th scope="col">Position</th>
                                <th scope="col">Manages</th>
                            </tr>
                        </thead>
                        @can('edit category')
                            <tbody class="order_position">
                            @else
                            <tbody>
                            @endcan

                            @foreach ($list as $key => $cate)
                                <tr id="{{ $cate->id }}">
                                    <th scope="row">{{ $key }}</th>
                                    <td>{{ $cate->title }}</td>
                                    <td>{{ $cate->description }}</td>
                                    <td>
                                        @if ($cate->status)
                                            Hien thi
                                        @else
                                            Khong hien thi
                                        @endif

                                    </td>
                                    <td>{{ $cate->position }}</td>
                                    <td>
                                        {!! Form::open([
                                            'method' => 'DELETE',
                                            'route' => ['category.destroy', $cate->id],
                                            'onsubmit' => 'return confirm("Are you sure you want to delete category ( ' . $cate->title . ' )?")',
                                        ]) !!}


                                        @can('delete category')
                                            {!! Form::submit('Delete', [
                                                'class' => 'btn btn-danger',
                                                'data-toggles' => 'tooltip',
                                                'data-placement' => 'left',
                                                'title' => 'Delete a category',
                                            ]) !!}
                                        @endcan
                                        {{-- <button type="button" class="btn btn-danger" data-toggle="modal" data-toggles="tooltip" data-target="#exampleModal" title="delete a category">
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
                                        </div> --}}
                                        <br>
                                        <br>

                                        {!! Form::close() !!}
                                        @can('edit category')
                                            <a href="{{ route('category.edit', $cate->id) }}" class="btn btn-warning"
                                                data-placement="left" , data-toggles="tooltip"
                                                title="Update a category">Update</a>
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
