@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                {{-- <a href="{{ route('movie.create') }}" class="btn btn-outline-info col-md-2" data-toggles="tooltip"
                    title="Update a category">Add Movies</a> --}}
                <div class="card">
                    <div style="font-size: 100%" class="card-header text-uppercase label label-default"> Manage movies</div>

                    <table class="table table-hover" id="tablephim">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name Customer</th>
                                <th scope="col">Name Movie</th>
                                <th scope="col">Comment</th>
                                <th scope="col">Created_at</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($list_comment as $key => $comment)
                                <tr>
                                    <th scope="row">{{ $key }}</th>
                                    <td>{{ $comment->user->name }}</td>
                                    <td>{{ $comment->movie->title }}</td>
                                    <td>{{ $comment->comment }}</td>
                                    <td>{{ $comment->created_at }}</td>
                                    <td>
                                        <select id="{{ $comment->id }}" class="status_comment">
                                            @if ($comment->status == 1)
                                                <option selected value="1">Active</option>
                                                <option value="0">Hidden</option>
                                            @else
                                                <option value="1">Active</option>
                                                <option selected value="0">Hidden</option>
                                            @endif

                                        </select>


                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            $('.status_comment').change(function() {
                var commentstatus_val = $(this).val();
                var comment_id = $(this).attr('id');
                // alert(moviehot_val);
                //alert(comment_id);
    
                $.ajax({
                   
                    url: "{{ route('comment-status-change') }}",
                    method: "GET",
                    data: {
                        commentstatus_val: commentstatus_val,
                        comment_id: comment_id,
                    },
                    success: function(data) {
                        // window.location.reload();
                        alert('Changed comment status success!');
                    },
                    error: function() {
                        alert('Error');
                    }
                });
            })
        </script>
    @endsection

