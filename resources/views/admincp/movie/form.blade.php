@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                {{-- <a href="{{ route('movie.index') }}" class="btn btn-outline-info col-md-2 "
                data-toggles="tooltip" title="List movies">Danh sách phim</a> --}}
                <div class="card">
                    <div style="font-size: 100%" class="card-header text-uppercase label label-default"> Manage movies</div>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if (session('message_del'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('message_del') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @elseif (session('message_error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('message_error') }}
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
                    @endif
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        @if (!isset($movie))
                            {!! Form::open([
                                'route' => 'movie.store',
                                'method' => 'POST',
                                'enctype' => 'multipart/form-data',
                                'onsubmit' => 'return true;',
                            ]) !!}
                        @else
                            {!! Form::open(['route' => ['movie.update', $movie->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) !!}
                        @endif
                        <div class="form-group">
                            {!! Form::label('title', 'Title', []) !!}
                            {!! Form::text('title', isset($movie) ? $movie->title : '', [
                                'class' => 'form-control txtTest',
                                'placeholder' => 'Enter values..',
                                'id' => 'slug',
                                'data-id' => 'txtTest',
                                'onkeyup' => 'ChangeToSlug()',
                                'autofocus',
                                'required',
                                'oninvalid' => 'this.setCustomValidity("Enter Title Here")',
                                'oninput' => 'this.setCustomValidity("")',
                            ]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('name_english', 'Name English', []) !!}
                            {!! Form::text('name_english', isset($movie) ? $movie->name_english : '', [
                                'class' => 'form-control',
                                'placeholder' => 'Enter values..',
                                'required',
                                'oninvalid' => 'this.setCustomValidity("Enter Name Enghlis Here")',
                                'oninput' => 'this.setCustomValidity("")',
                            ]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('slug', 'Slug', []) !!}
                            {!! Form::text('slug', isset($movie) ? $movie->slug : '', [
                                'class' => 'form-control',
                                'placeholder' => 'Enter values..',
                                'id' => 'convert_slug',
                            ]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('year', 'Year', []) !!}
                            {!! Form::text('year', isset($movie) ? $movie->year : '', [
                                'class' => 'form-control',
                                'id' => 'datepicker2',
                                'placeholder' => 'Choose a year..',
                                'required',
                            ]) !!}
                        </div>
                        <div class="form-group">
                            <style>
                                .cke_1 {
                                    width: 91%;
                                }
                            </style>
                            @if (isset($movie))
                                {!! Form::label('description', 'Description', []) !!}
                                {!! Form::textarea(
                                    'description',
                                    isset($movie->movie_description) ? $movie->movie_description->description : '',
                                    [
                                        'style' => 'resize:none',
                                        'class' => 'form-control',
                                        'placeholder' => 'Enter values..',
                                        'id' => 'description',
                                        'required',
                                        'oninvalid' => 'this.setCustomValidity("Enter Description Here")',
                                        'oninput' => 'this.setCustomValidity("")',
                                    ],
                                ) !!}
                            @else
                                {!! Form::label('description', 'Description', []) !!}
                                {!! Form::textarea('description', '', [
                                    'style' => 'resize:none',
                                    'class' => 'form-control',
                                    'placeholder' => 'Enter values..',
                                    'id' => 'description',
                                    'required',
                                    'oninvalid' => 'this.setCustomValidity("Enter Description Here")',
                                    'oninput' => 'this.setCustomValidity("")',
                                ]) !!}
                            @endif
                        </div>
                        <div class="form-group">
                            @if (isset($movie))
                                {!! Form::label('tags', 'Tags', []) !!}
                                {!! Form::textarea('tags', isset($movie->movie_tags) ? $movie->movie_tags->tags : '', [
                                    'style' => 'resize:none',
                                    'class' => 'form-control',
                                    'placeholder' => 'Enter values..',
                                    'id' => 'tags',
                                    'required',
                                    'oninvalid' => 'this.setCustomValidity("Enter Tags Here")',
                                    'oninput' => 'this.setCustomValidity("")',
                                ]) !!}
                            @else
                                {!! Form::label('tags', 'Tags', []) !!}
                                {!! Form::textarea('tags', '', [
                                    'style' => 'resize:none',
                                    'class' => 'form-control',
                                    'placeholder' => 'Enter values..',
                                    'id' => 'tags',
                                    'required',
                                    'oninvalid' => 'this.setCustomValidity("Enter Tags Here")',
                                    'oninput' => 'this.setCustomValidity("")',
                                ]) !!}
                            @endif
                        </div>
                        <div class="form-group">
                            {!! Form::label('thuocphim', 'Thể loại phim', []) !!}
                            {!! Form::select(
                                'thuocphim',
                                ['' => '--Select Type--', '0' => 'Phim Lẻ', '1' => 'Phim Bộ'],
                                isset($movie) ? $movie->type_movie : '',
                                [
                                    'class' => 'form-control',
                                    'required',
                                ],
                            ) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('Active', 'Active', []) !!}
                            {!! Form::select('status', ['1' => 'Hien thi', '0' => 'Khong'], isset($movie) ? $movie->status : '', [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('quality', 'Quality', []) !!}
                            {!! Form::select('quality', ['1' => 'Bluray', '0' => 'FHD', '2' => 'HD'], isset($movie) ? $movie->quality : '', [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('language', 'Language', []) !!}
                            {!! Form::select(
                                'language',
                                ['1' => 'VietSub', '0' => 'Thuyết Minh', '2' => 'Tiếng Gốc', '3' => 'Lồng Tiếng'],
                                isset($movie) ? $movie->language : '',
                                ['class' => 'form-control'],
                            ) !!}
                        </div>
                        <div class="form-group">
                            @if (isset($movie))
                                {!! Form::label('imdb', 'Imdb Code', []) !!}
                                {!! Form::text('imdb', isset($movie) ? $movie->imdb : '', [
                                    'class' => 'form-control',
                                    'placeholder' => 'Enter values..',
                                    'oninvalid' => 'this.setCustomValidity("Enter Imdb Here")',
                                    'oninput' => 'this.setCustomValidity("")',
                                    'required',
                                ]) !!}
                            @endif
                        </div>

                        <div class="form-group">
                            {!! Form::label('time', 'Time', []) !!}

                            {!! Form::number('time', isset($movie) ? $movie->time : '', [
                                'class' => 'form-control',
                                'placeholder' => 'Enter values..',
                                'required',
                                'oninvalid' => 'this.setCustomValidity("Enter Time Here")',
                                'oninput' => 'this.setCustomValidity("")',
                            ]) !!}

                        </div>
                        <div class="form-group">
                            {!! Form::label('Hot', 'Hot', []) !!}
                            {!! Form::select('hot', ['0' => 'Khong', '1' => 'Co'], isset($movie) ? $movie->hot : '', [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group">
                            @if (isset($movie))
                                {!! Form::label('trailer', 'Trailer', []) !!}
                                {!! Form::text('trailer', isset($movie->movie_trailer) ? $movie->movie_trailer->trailer : '', [
                                    'style' => 'resize:none',
                                    'class' => 'form-control',
                                    'required',
                                    'placeholder' => 'Enter values..',
                                ]) !!}
                            @else
                                {!! Form::label('trailer', 'Trailer', []) !!}
                                {!! Form::text('trailer', '', [
                                    'style' => 'resize:none',
                                    'class' => 'form-control',
                                    'required',
                                    'placeholder' => 'Enter values..',
                                ]) !!}
                            @endif
                        </div>
                        <div class="form-group">
                            {!! Form::label('Category', 'Category', []) !!}
                            {!! Form::select('category_id', $category, isset($movie) ? $movie->category_id : '', [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('Country', 'Country', []) !!}
                            {!! Form::select('country_id', $country, isset($movie) ? $movie->country_id : '', ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('Genre', 'Genre', []) !!}
                            <br>
                            {{-- {!! Form::select('genre_id',$genre ,isset($movie)?$movie->genre_id:'', ['class'=>'form-control']) !!} --}}
                            @foreach ($list_genre as $key => $gen)
                                @if (isset($movie))
                                    {!! Form::checkbox('genre[]', $gen->id, isset($movie_genre) && $movie_genre->contains($gen->id) ? true : false) !!}
                                @else
                                    {!! Form::checkbox('genre[]', $gen->id, '') !!}
                                @endif
                                {!! Form::label('genre', $gen->title) !!}
                            @endforeach
                        </div>
                        <div class="form-group">
                            {!! Form::label('sotap', 'Episode Number', []) !!}
                            {!! Form::number('sotap', isset($movie) ? $movie->sotap : '', [
                                'class' => 'form-control input-episode',
                                'placeholder' => 'Enter values..',
                                'required',
                                'value' => '1',
                            ]) !!}

                        </div>

                        <div class="form-group">
                            <label><strong>Directors:</strong></label><br />
                            <select class="selects selectpicker" multiple data-live-search="true" name="directors[]">
                                @foreach ($list_directors as $key => $direc)
                                    @if (isset($movie))
                                        <option value="{{ $direc->id }}"
                                            {{ isset($movie_directors) && $movie_directors->contains($direc->id) ? 'selected' : '' }}>
                                            {{ $direc->name }}</option>
                                    @else
                                        <option value="{{ $direc->id }}">{{ $direc->name }}</option>
                                    @endif
                                    {{-- <option value="{{ $cast->id }}">{{ $cast->title }}</option> --}}
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label><strong>Cast:</strong></label><br />
                            <select class="selects selectpicker" multiple data-live-search="true" name="cast[]">
                                @foreach ($list_cast as $key => $cast)
                                    @if (isset($movie))
                                        <option value="{{ $cast->id }}"
                                            {{ isset($movie_cast) && $movie_cast->contains($cast->id) ? 'selected' : '' }}>
                                            {{ $cast->title }}</option>
                                    @else
                                        <option value="{{ $cast->id }}">{{ $cast->title }}</option>
                                    @endif
                                    {{-- <option value="{{ $cast->id }}">{{ $cast->title }}</option> --}}
                                @endforeach
                            </select>

                        </div>
                        <div class="form-group" style="width:22%">
                            {!! Form::label('fee', 'Fee', []) !!}
                            {!! Form::text('paid_movie', isset($movie) ? $movie->paid_movie : '', [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('Image', 'Image_Poster', []) !!}
                            {!! Form::file('image', [
                                'class' => 'form-control-file',
                                'id' => 'fileChooser',
                                'onchange' => 'return fileValidation(this)',
                                // 'accept' => '.jpg, .png, .jpeg, .gif, .psd',
                                isset($movie) ? '' : 'required',
                            ]) !!}

                            @if (isset($movie))
                                @php
                                    $image_check = substr($movie->movie_image->image, 0, 5);
                                    $startPos = strpos($movie->movie_image->image, 'movies/');
                                    $image = substr($movie->movie_image->image, $startPos + strlen('movies/')); @endphp
                                @if ($image_check == 'https')
                                    <img width="20%"src="{{ $url_update . $image }}">
                                @else
                                    <img width="20%"src="{{ asset('uploads/movie/' . $movie->movie_image->image) }}">
                                @endif
                            @endif
                        </div>
                        <div class="form-group">
                            {!! Form::label('Image', 'Image_Thumbnail', []) !!}
                            {!! Form::file('image_thumbnail', [
                                'class' => 'form-control-file',
                                'id' => 'fileChooser',
                                'onchange' => 'return fileValidation(this)',
                                // 'accept' => '.jpg, .png, .jpeg, .gif, .psd',
                                isset($movie_thumbnail) ? '' : '',
                            ]) !!}

                            @if (isset($movie_thumbnail))
                                @php
                                    $image_check = substr($movie_thumbnail->movie_image->image, 0, 5);
                                    $startPos = strpos($movie_thumbnail->movie_image->image, 'movies/');
                                $image = substr($movie_thumbnail->movie_image->image, $startPos + strlen('movies/')); @endphp
                                @if ($image_check == 'https')
                                    <img width="20%"src="{{ $url_update . $image }}">
                                @else
                                    <img
                                        width="20%"src="{{ asset('uploads/movie/' . $movie_thumbnail->movie_image->image) }}">
                                @endif
                            @endif
                        </div>
                        <div class="form-group">
                            @if (isset($movie))
                                {!! Form::label('logo', 'Logo', []) !!}
                                {!! Form::text('logo', isset($movie->movie_logo) ? $movie_logo->image : '', [
                                    'style' => 'resize:none',
                                    'class' => 'form-control',
                                    '',
                                    'placeholder' => 'Enter url logo',
                                ]) !!}
                            @else
                                {!! Form::label('logo', 'Logo', []) !!}
                                {!! Form::text('trailer', '', [
                                    'style' => 'resize:none',
                                    'class' => 'form-control',
                                    '',
                                    'placeholder' => 'Enter url logo',
                                ]) !!}
                            @endif
                        </div>

                        @if (!isset($movie))
                            {!! Form::submit('Create ', ['class' => 'btn btn-success', 'onclick' => 'displayRadioValue()']) !!}
                        @else
                            {!! Form::submit('Update', ['class' => 'btn btn-success']) !!}
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

    <!-- Initialize the plugin: -->
    <script>
        $(function() {
            $('#datepicker2').datepicker({
                yearRange: "c-100:c+2",
                changeMonth: false,
                changeYear: true,
                showButtonPanel: true,
                closeText: 'Select',
                currentText: 'This year',
                onClose: function(dateText, inst) {
                    var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                    $(this).val($.datepicker.formatDate('yy', new Date(year, 1, 1)));
                }
            }).focus(function() {
                $(".ui-datepicker-month").hide();
                $(".ui-datepicker-calendar").hide();
                $(".ui-datepicker-current").hide();
                $(".ui-datepicker-prev").hide();
                $(".ui-datepicker-next").hide();
                $("#ui-datepicker-div").position({
                    my: "left top",
                    at: "left bottom",
                    of: $(this)
                });
            }).attr("readonly", false);
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {

            $('.selects').selectpicker();

        });
    </script>
    <!--validate image-->
    <script type="text/javascript">
        function fileValidation(input) {
            debugger;
            var validExtensions = ['jpg', 'png', 'jpeg', 'webp']; //array of valid extensions
            var fileName = input.files[0].name;
            var fileNameExt = fileName.substr(fileName.lastIndexOf('.') + 1);
            if ($.inArray(fileNameExt, validExtensions) == -1) {
                input.type = ''
                input.type = 'file'
                $('#user_img').attr('src', "");
                alert("Only these file types are accepted : " + validExtensions.join(', '));
            } else {
                if (input.files && input.files[0]) {
                    var filerdr = new FileReader();
                    filerdr.onload = function(e) {
                        $('#user_img').attr('src', e.target.result);
                    }
                    filerdr.readAsDataURL(input.files[0]);
                }
            }
            //5MB
            const maxAllowedSize = 3 * 1024 * 1024;
            if (input.files[0].size > maxAllowedSize) {
                input.type = ''
                input.type = 'file'
                $('#user_img').attr('src', "");
                // Here you can ask your users to load correct file
                alert(" File uploads to no more than " + maxAllowedSize / (1024 * 1024) + " MB");
            }
        }
    </script>

    <!-- ajax disable  -->
    <script type="text/javascript">
        $(document).ready(function() {
            $('select[name="thuocphim"]').on('change', function() {
                var eins = $(this).val();

                if (eins == "0") {
                    $('.input-episode').attr('readOnly', 'readOnly');
                    $('.input-episode').val('1');
                } else {
                    $('.input-episode').removeAttr('readOnly');
                }
            });
        });
    </script>
    <script>
        function displayRadioValue(event) {
            var checkboxes = document.querySelectorAll('input[type="checkbox"]')
            var gen = document.getElementsByName('genre[]');
            var genValue = false;
            for (i = 0; i < gen.length; i++) {
                if (gen[i].checked)
                    genValue = true;
            }
            if (!genValue) {
                alert('Vui lòng chọn ít nhất 1 thể loại!');
                event.preventDefault();
                return false;
            }
        }
    </script>

    <script>
        document.getElementById("slug").addEventListener("input", forceLower);

        function forceLower(evt) {
            var words = evt.target.value.toLowerCase().split(/\s+/g);
            var newWords = words.map(function(element) {
                return element !== "" ? element[0].toUpperCase() + element.substr(1, element.length) : "";
            });
            evt.target.value = newWords.join(" ");
        }
    </script>
    <script></script>
@endsection
