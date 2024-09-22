@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div style="font-size: 100%" class="card-header text-uppercase label label-default"> Log Manage</div>
                    <table class="table" id="tablephim">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Ip</th>
                                <th scope="col">error message</th>
                                <th scope="col">Path</th>
                                <th scope="col">Time</th>
                               
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($errors as $key => $error)
                                
                                <tr>
                                    <th scope="row">{{ $key }}</th>
                                    <th>{{ $error->session->client_ip }}</th>
                                    <td>{{ $error->error->message }}</td>
                                    <td>{{ $error->path->path }}</td>
                                    <td>{{ $error->created_at }}</td>
                                   
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endsection
