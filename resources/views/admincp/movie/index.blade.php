@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                {{-- <a href="{{ route('movie.create') }}" class="btn btn-outline-info col-md-2" data-toggles="tooltip"
                    title="Update a category">Add Movies</a> --}}
                <div class="card">
                    <div style="font-size: 100%" class="card-header text-uppercase label label-default"> Manage movies</div>

                    {{-- @if (session('message_del'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('message_del') }}
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
                    @endif --}}
                    <table class="table table-hover" id="tablephim">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Title</th>
                                {{-- <th scope="col">Name En</th> --}}
                                <th scope="col">Image</th>
                                {{-- <th scope="col">Description</th> --}}
                                <th scope="col">Quality</th>
                                <th scope="col">Imdb</th>
                                <th scope="col">Time</th>
                                <th scope="col">Language</th>
                                <th scope="col">Movie Hot</th>
                                <th scope="col">Category</th>
                                <th scope="col">Genre</th>
                                <th scope="col">Country</th>
                                <th scope="col">Episode</th>
                                <th scope="col">Season</th>
                                <th scope="col">Created_at</th>
                                {{-- <th scope="col">Ngay cap nhat</th> --}}
                                <th scope="col">Year</th>
                               
                                <th scope="col">Status</th>
                                <th scope="col">Manages</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($list as $key => $mov)
                                <tr>
                                    <th scope="row">{{ $key }}</th>
                                    <td>{{ $mov->title }}</td>
                                    {{-- <td>{{ $mov->name_english }}</td> --}}

                                    <td>
                                        @php
                                            $image_check = substr($mov->movie_image->image, 0, 5);
                                        @endphp
                                        @if ($image_check == 'https')
                                            <img width="60%" data-original="{{ $mov->movie_image->image }}">
                                        @else
                                            <img width="60%"
                                                data-original="{{ asset('uploads/movie/' . $mov->movie_image->image) }}">
                                        @endif

                                    </td>
                                    {{-- <td>
                    @foreach ($mov->movie_description as $des)
                        {{ $des->description }}
                    @endforeach
                </td> --}}

                                    <td>
                                        @if ($mov->quality == 1)
                                            Bluray
                                        @elseif ($mov->quality == 2)
                                            HD
                                        @else
                                            FHD
                                        @endif
                                    </td>

                                    <td @if (auth()->user()->can('edit movie') ||
                                            auth()->user()->can('create movie')) contenteditable class="edit_imdbcode" data-movie_id="{{ $mov->id }}" @endif
                                        data-toggles="tooltip" title="Double click to open page rate">
                                        <a style="color: #000" onclick="return false" ondblclick="window.open(this.href)"
                                            href="https://www.imdb.com/title/{{ $mov->imdb }}"
                                            target="true">{{ $mov->imdb }}</a>
                                        {{-- {{ $mov->movie_rating }} --}}

                                    </td>
                                    <td>{{ $mov->time }}</td>
                                    <td>
                                        @if ($mov->language == 1)
                                            VietSub
                                        @elseif ($mov->language == 2)
                                            Tiếng Gốc
                                        @elseif($mov->language == 0)
                                            Thuyết Minh
                                        @else
                                            Lồng Tiếng
                                        @endif
                                    </td>
                                    <td>
                                        <select id="{{ $mov->id }}"
                                            @can('edit movie')
                                            class="movie_hot"
                                            @else
                                            disabled="true" 
                                            @endcan>
                                            @if ($mov->hot == 1)
                                                <option selected value="1">Hot</option>
                                                <option value="0">Không</option>
                                            @else
                                                <option value="1">Hot</option>
                                                <option selected value="0">Không</option>
                                            @endif
                                        </select>
                                    </td>
                                    <td>{{ $mov->category->title }}</td>

                                    <td>
                                        @foreach ($mov->movie_genre as $gen)
                                            <span class="badge badge-dark">{{ $gen->title }} </span>
                                        @endforeach
                                    </td>
                                    <td>{{ $mov->country->title }}</td>
                                    <td>{{ $mov->episode_count }}/{{ $mov->sotap }} Tập</td>
                                    <td>
                                        @if (auth()->user()->can('edit movie') ||
                                                auth()->user()->can('create movie'))
                                            <form method="post">
                                                @csrf

                                                {!! Form::selectRange('season', 0, 20, isset($mov->season) ? $mov->season : '', [
                                                    'class' => 'select-season',
                                                    'id' => $mov->id,
                                                    'placeholder' => '-Season-',
                                                ]) !!}
                                            </form>
                                        @else
                                            <form method="post">
                                                @csrf

                                                {!! Form::selectRange('season', 0, 20, isset($mov->season) ? $mov->season : '', [
                                                    'placeholder' => '-Season-',
                                                    'disabled',
                                                ]) !!}
                                            </form>
                                        @endif
                                    </td>
                                    <td>{{ $mov->created_at }}</td>
                                    {{-- <td>{{ $mov->ngaycapnhat }}</td> --}}
                                    <td>
                                        @if (auth()->user()->can('edit movie') ||
                                                auth()->user()->can('create movie'))
                                            {!! Form::selectYear('year', 1923, now()->year + 2, isset($mov->year) ? $mov->year : '', [
                                                'class' => 'select-year',
                                                'id' => $mov->id,
                                                'placeholder' => '-Year-',
                                            ]) !!}
                                        @else
                                            {!! Form::selectYear('year', 1923, now()->year + 2, isset($mov->year) ? $mov->year : '', [
                                                'disabled',
                                                'placeholder' => '-Year-',
                                            ]) !!}
                                        @endif

                                    </td>
                                    <td>
                                        <select id="{{ $mov->id }}"
                                            @can('edit movie')
                                             class="status_movie"
                                             @else
                                             disabled="true" 
                                             @endcan>
                                            @if ($mov->status == 1)
                                                <option selected value="1">Active</option>
                                                <option value="0">Hidden</option>
                                            @else
                                                <option value="1">Active</option>
                                                <option selected value="0">Hidden</option>
                                            @endif

                                        </select>


                                    </td>
                                    <td>
                                        {!! Form::open([
                                            'method' => 'DELETE',
                                            'route' => ['movie.destroy', $mov->id],
                                            'onsubmit' => 'return confirm("Are you sure you want to delete movie ( ' . $mov->title . ' )?")',
                                        ]) !!}
                                        {{-- <button type="button" class="btn btn-danger" data-toggle="modal"
                                            data-target="#exampleModal" data-toggles="tooltip" title="delete a movie">
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
                                        @can('delete movie')
                                            {!! Form::submit('Delete', [
                                                'class' => 'btn btn-danger',
                                                'data-toggles' => 'tooltip',
                                                'title' => 'Delete Movie',
                                            ]) !!}
                                        @else
                                            <a href="javascript:void(0);" class="btn btn-danger" data-toggles="tooltip"
                                                title="Delete movie deny access" disabled="true">Delete</a>
                                        @endcan

                                        <br>
                                        <br>
                                        {!! Form::close() !!}
                                        @can('edit movie')
                                            <a href="{{ route('movie.edit', $mov->id) }}" class="btn btn-warning"
                                                data-toggles="tooltip" title="Update movie">Update</a>
                                        @else
                                            <a href="javascript:void(0);" class="btn btn-warning" data-toggles="tooltip"
                                                title="Update movie deny access" disabled="true">Update</a>
                                        @endcan

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.lazyload/1.9.1/jquery.lazyload.min.js"
            integrity="sha512-jNDtFf7qgU0eH/+Z42FG4fw3w7DM/9zbgNPe3wfJlCylVDTT3IgKW5r92Vy9IHa6U50vyMz5gRByIu4YIXFtaQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script>
            $(document).ready(function() {
                $("img").lazyload({
                    effect: "fadeIn"
                });
            })
        </script>
        <script>
            // dung blur hoac input
            $(document).on('input', '.edit_imdbcode', function() {
                var imdbcode = $(this).text();
                var movie_id = $(this).data('movie_id');

                $.ajax({
                    url: "{{ route('update-imdb') }}",
                    method: "POST",
                    data: {
                        imdbcode: imdbcode,
                        movie_id: movie_id,
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        //alert('Change code imdb success!');
                    }

                });
            });
        </script>
    @endsection
