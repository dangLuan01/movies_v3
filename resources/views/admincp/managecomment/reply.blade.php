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
                                
                                <th scope="col">Name</th>
                                <th scope="col">Name Movie</th>
                                <th scope="col">Comment</th>
                                <th scope="col">Reply</th>
                                <th scope="col">Created_at</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($list_reply as $reply)
                                @foreach ($reply->replies as $key => $rep)
                                    <tr>
                                        
                                        <td>{{ $rep->user->name }}</td>
                                        <td>{{ $rep->movie->title }}</td>
                                        <td>{{ $reply->comment }}</td>
                                        <td>{{ $rep->comment }}</td>
                                        <td>{{ $rep->created_at }}</td>
                                        <td>
                                            <select id="{{ $rep->id }}" class="status_reply">
                                                @if ($rep->status == 1)
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
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            $('.status_reply').change(function() {
                var replystatus_val = $(this).val();
                var reply_id = $(this).attr('id');
                // alert(moviehot_val);
                //alert(comment_id);

                $.ajax({

                    url: "{{ route('reply-status-change') }}",
                    method: "GET",
                    data: {
                        replystatus_val: replystatus_val,
                        reply_id: reply_id,
                    },
                    success: function(data) {
                        // window.location.reload();
                        alert('Changed reply status success!');
                    },
                    error: function() {
                        alert('Error');
                    }
                });
            })
        </script>
    @endsection
