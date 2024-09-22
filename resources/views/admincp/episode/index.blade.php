@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div style="font-size: 100%" class="card-header text-uppercase label label-default">Manage episodes</div>
                   
                </div>
                <table class="table table-responsive" id="tablephim">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Ten Phim</th>
                            {{-- <th scope="col">Link</th> --}}
                            <th scope="col">Link Download</th>
                            <th scope="col">Server</th>
                            <th scope="col">So tap</th>
                            <th scope="col">Manages</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($list_episode as $key => $epi)
                            <tr>
                                <th scope="row">{{ $key }}</th>
                                <td>{{ $epi->movie->title }}</td>
                                {{-- <td>{{ $epi->linkphim }}</td> --}}
                                <td>{{ $epi->linkdownload }}</td>
                               
                                <td>
                                    @foreach ($list_servers as $key => $server )
                                    @if ($epi->server_id==$server->id)
                                        {{ $server->title }}
                                    @endif
                                    
                                @endforeach
                                 </td>
                                <td>{{ $epi->episode }}</td>

                                {{-- <td>
                    @if ($epi->status)
                        Hien thi
                        @else
                        Khong hien thi
                    @endif
                    
                    </td> --}}
                                <td>
                                    {!! Form::open([
                                        'method' => 'DELETE',
                                        'route' => ['episode.destroy', $epi->id],
                                        'onsubmit' => 'return confirm("Are you sure you want to delete this item?")',
                                    ]) !!}
                                    {!! Form::submit('Delete', ['class' => 'btn btn-danger', 'data-toggles' => 'tooltip',
                                    'data-placement' => 'left',
                                    'title' => 'Delete episode',]) !!}
                                    <br>
                                    <br>
                                    {!! Form::close() !!}
                                    <a href="{{ route('episode.edit', $epi->id) }}" data-toggles = 'tooltip',
                                        data-placement = 'left',
                                        title = 'Update episode' class="btn btn-warning">Update</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

@endsection
