@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div style="padding-bottom: 1%" class="center">
                    <form action="{{ route('log') }}" method="GET">
                        <div>
                            <label for="">Date start:</label>
                            <input type="date" name="date_start" value="{!! isset($_GET['date_start']) ? $_GET['date_start']:'' !!}" required>
                        </div>
                        <div style="padding-top: 1%">
                            <label for="">Date end:</label>
                            <input type="date" name="date_end" value="{!! isset($_GET['date_end']) ? $_GET['date_end']:'' !!}" required>
                            <input type="submit" value="Submit">
                        </div>
                        
                    </form>
                </div>
                <div class="card">
                    <div style="font-size: 100%;" class="card-header text-uppercase label label-default"> Log Manage</div>
                    <table class="table" id="tablephim">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Ip</th>
                                <th scope="col">Browser</th>
                                <th scope="col">Name</th>
                                <th scope="col">Device</th>
                                <th scope="col">Platform</th>
                                <th scope="col">Language</th>
                                <th scope="col">Path</th>
                                <th scope="col">Action</th>
                                <th scope="col">Time</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sessions as $key => $session)
                                @foreach ($session->log as $key => $log)
                                    <tr>
                                        <th scope="row">{{ $key }}</th>
                                        <th>{{ $session->client_ip }}</th>
                                        <td>{{ $session->agent->browser }}-{{ $session->agent->browser_version }}</td>
                                        <td>{{ $session->agent->name }}</td>
                                        <td>{{ $session->device->kind }}</td>
                                        <td>{{ $session->device->platform }}/{{ $session->device->platform_version }}</td>
                                        <td>{{ $session->language->preference }}</td>
                                        <td>
                                            {{ $log->path->path }}
                                        </td>
                                        <td>
                                            {{ $log->method }}
                                        </td>
                                        <td>{{ $session->created_at }}</td>

                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endsection
