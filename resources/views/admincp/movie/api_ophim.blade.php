@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @if (isset($api_ophim['pagination']))
                    <div>
                        <h4>Page: {{ $api_ophim['pagination']['currentPage'] }}</h4>
                        <h4>Total Pages:{{ $api_ophim['pagination']['totalPages'] }}</h4>
                        <label for="">Choose Page</label>
                        <form action="{{ route('get_api_ophim') }}" method="GET">
                            <input name="next_page" value="{{ $api_ophim['pagination']['currentPage'] + 1 }}" required>
                            <input type="submit" value="Next">
                        </form>
                    </div>
                @endif

                <div>
                    <label for="">Search</label>
                    <form action="{{ route('get_api_ophim') }}" method="GET">
                        <input type="text" name="search_ophim" value="" required>
                        <input type="submit" value="Search">
                    </form>
                </div>
                <div class="card">
                    <div style="font-size: 100%" class="card-header text-uppercase label label-default"> Manage movies</div>

                    <table class="table table-hover" id="tablephim">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th>Image</th>
                                <th scope="col">Thumbnail</th>
                                <th scope="col">Title</th>
                                <th scope="col">Name En</th>
                                <th scope="col">Type</th>
                                <th scope="col">Episode</th>
                                <th scope="col">Year</th>
                                <th scope="col">Manages</th>
                                <th scope="col" style="width: 90px">Notice</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($api_ophim['items'] as $key => $mov)
                                @php
                                    $api_detail = Http::get('Https://ophim1.com/phim/' . $mov['slug'])->json();

                                @endphp
                                @php
                                    $found = false;
                                @endphp
                                @foreach ($movies as $mo)
                                    @if ($mov['name'] == $mo)
                                        @php
                                            $found = true;
                                            break;
                                        @endphp
                                    @endif
                                @endforeach

                                <tr>
                                    <td>{{ $key }}</td>
                                    <td><img width="90%" data-original="{{ $link_image }}{{ $mov['thumb_url'] }}"></td>
                                    <td><img width="90%" data-original="{{ $link_image }}{{ $mov['poster_url'] }}">
                                    </td>
                                    <td>{{ $mov['name'] }}</td>
                                    <td>{{ $mov['origin_name'] }}</td>
                                    <td>{{ $api_detail['movie']['type'] }}</td>
                                    <td>{{ $api_detail['movie']['episode_current'] }}/{{ $api_detail['movie']['episode_total'] }}
                                    </td>
                                    <td>{{ $mov['year'] }}</td>

                                    <td>
                                        @if ($found)
                                            <form action="{{ route('auto_update_episode') }}" method="post">
                                                @csrf
                                                <input name='slug' value="{{ $mov['slug'] }}" hidden>
                                                <input name='title' value="{{ $mov['name'] }}" hidden>
                                                <input type="submit" value="Update Episode">

                                            </form>
                                        @else
                                            <form action="{{ route('auto_create') }}" method="post">
                                                @csrf
                                                <input name='slug' value="{{ $mov['slug'] }}" hidden>
                                                <input name='title' value="{{ $mov['name'] }}" hidden>
                                                <input type="submit" value="Create">

                                            </form>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($found)
                                            Đã Có
                                        @else
                                            Chưa Có
                                        @endif
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
    @endsection
