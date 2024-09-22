@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                {{-- <a href="{{ route('category.index') }}" class="btn btn-outline-info col-md-2 " data-toggles="tooltip"
                    title="List category">List Category</a> --}}

                <div class="card">
                    <div style="font-size: 100%" class="card-header text-uppercase label label-default">Package Manage</div>
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error )
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                        
                    @endif
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        @if (!isset($package))
                            {!! Form::open(['route' => 'package.store', 'method' => 'POST']) !!}
                        @else
                            {!! Form::open(['route' => ['package.update', $package->id], 'method' => 'PUT']) !!}
                        @endif
                        <div class="form-group">
                            {!! Form::label('title', 'Title', []) !!}
                            {!! Form::text('title', isset($package) ? $package->title : '', [
                                'class' => 'form-control',
                                'placeholder' => 'Enter values..',
                                'id' => 'slug',
                                'onkeyup' => 'ChangeToSlug()',
                                'autofocus',
                                'onchange' => 'title()',
                                'oninvalid' => 'this.setCustomValidity("Enter Title Here")',
                                'oninput' => 'this.setCustomValidity("")',
                            ]) !!}
                        </div>
                        <div class="form-group">
                            <style>
                                .cke_1 {
                                    width: 91%;
                                }
                            </style>
                            {!! Form::label('description', 'Description', []) !!}
                            {!! Form::textarea('description', isset($package) ? $package->description : '', [
                                'class' => 'form-control',
                                'placeholder' => 'Enter values..',
                            ]) !!}
                        </div>
                        
                        <div class="form-group">
                            {!! Form::label('time', 'Time', []) !!}
                            {!! Form::number('time', isset($package) ? $package->time : '', [
                                'class' => 'form-control',
                                'placeholder' => 'Enter values..',               
                                'oninvalid' => 'this.setCustomValidity("Enter Time Here")',
                                'oninput' => 'this.setCustomValidity("")',
                            ]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('price', 'Price', []) !!}
                            {!! Form::number('price', isset($package) ? $package->price : '', [
                                'class' => 'form-control',
                                'placeholder' => 'Enter values..',               
                                'oninvalid' => 'this.setCustomValidity("Enter Price Here")',
                                'oninput' => 'this.setCustomValidity("")',
                            ]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('Active', 'Active', []) !!}
                            {!! Form::select('status', ['1' => 'Hien thi', '0' => 'Khong'], isset($package) ? $package->status : '', [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        @if (!isset($package))
                            {!! Form::submit('Create ', [
                                'class' => 'btn btn-success',
                                'data-toggles' => 'tooltip',
                                'data-placement' => 'bottom',
                                'title' => 'Create package',
                            ]) !!}
                        @else
                            {!! Form::submit('Update', [
                                'class' => 'btn btn-success',
                                'data-toggles' => 'tooltip',
                                'data-placement' => 'bottom',
                                'title' => 'Update package',
                            ]) !!}
                        @endif

                        {!! Form::close() !!}

                    </div>
                </div>


            </div>
        </div>
    </div>
    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>

    <script>
        CKEDITOR.replace('description');
    </script>
@endsection
