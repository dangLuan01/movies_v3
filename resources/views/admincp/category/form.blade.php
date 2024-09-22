@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                {{-- <a href="{{ route('category.index') }}" class="btn btn-outline-info col-md-2 " data-toggles="tooltip"
                    title="List category">List Category</a> --}}

                <div class="card">
                    <div style="font-size: 100%" class="card-header text-uppercase label label-default">Category Manage</div>
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
                        @if (!isset($category))
                            {!! Form::open(['route' => 'category.store', 'method' => 'POST']) !!}
                        @else
                            {!! Form::open(['route' => ['category.update', $category->id], 'method' => 'PUT']) !!}
                        @endif
                        <div class="form-group">
                            {!! Form::label('title', 'Title', []) !!}
                            {!! Form::text('title', isset($category) ? $category->title : '', [
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
                            {!! Form::label('slug', 'Slug', []) !!}
                            {!! Form::text('slug', isset($category) ? $category->slug : '', [
                                'class' => 'form-control',
                                'placeholder' => 'Enter values..',
                                'id' => 'convert_slug',
                                'onchange' => 'slug()',
                            ]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('description', 'Description', []) !!}
                            {!! Form::textarea('description', isset($category) ? $category->description : '', [
                                'style' => 'resize:none',
                                'class' => 'form-control',
                                'placeholder' => 'Enter values..',
                                'id' => 'description',                            
                                'oninvalid' => 'this.setCustomValidity("Enter Description Here")',
                                'oninput' => 'this.setCustomValidity("")',
                                'onchange' => 'description()',
                            ]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('Active', 'Active', []) !!}
                            {!! Form::select('status', ['1' => 'Hien thi', '0' => 'Khong'], isset($category) ? $category->status : '', [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('position', 'Position', []) !!}
                            {!! Form::number('position', isset($category) ? $category->position : '', [
                                'style' => 'resize:none',
                                'class' => 'form-control',
                                'placeholder' => 'Defaut is (0)',
                                'id' => 'position',
                                'oninvalid' => 'this.setCustomValidity("Enter Position Here")',
                                'oninput' => 'this.setCustomValidity("")',
                            ]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('nav', 'Nav', []) !!}
                            {!! Form::number('nav', isset($category) ? $category->nav : 'disabled', [
                                'style' => 'resize:none',
                                'class' => 'form-control',
                                'placeholder' => 'Defaut is (0)',
                                'id' => 'nav',
                                'oninvalid' => 'this.setCustomValidity("Enter Position Here")',
                                'oninput' => 'this.setCustomValidity("")',
                            ]) !!}
                        </div>
                        @if (!isset($category))
                            {!! Form::submit('Create ', [
                                'class' => 'btn btn-success',
                                'data-toggles' => 'tooltip',
                                'data-placement' => 'bottom',
                                'title' => 'Create category',
                            ]) !!}
                        @else
                            {!! Form::submit('Update', [
                                'class' => 'btn btn-success',
                                'data-toggles' => 'tooltip',
                                'data-placement' => 'bottom',
                                'title' => 'Update category',
                            ]) !!}
                        @endif

                        {!! Form::close() !!}

                    </div>
                </div>


            </div>
        </div>
    </div>
@endsection
