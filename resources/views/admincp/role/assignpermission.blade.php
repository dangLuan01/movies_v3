@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"> Assign Permission</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        {!! Form::open(['route' => 'assignPermissionsToRole', 'method' => 'POST']) !!}


                        <div class="form-group">
                            <label for="">Role</label>
                            <select style="width: 50%" class="form-control select-role" name="role">
                                <option disabled selected>---Role---</option>
                                @foreach ($listRole as $key => $ro)
                                    @if ($ro->name != 'Super Admin')
                                        <option value="{{ $ro->id }}">{{ $ro->name }}</option>
                                    @else
                                        <option disabled value="{{ $ro->id }}">{{ $ro->name }}</option>
                                    @endif
                                @endforeach

                            </select>
                        </div>
                        <div class="form-group" style="width: 50%">
                            <label><strong> Role has permissions</strong></label><br />
                            <select id="show_permission" multiple data-live-search="true"
                                class="form-control selects selectpicker shown" name="permissions[]">
                                <option disabled>---Permission:...---</option>
                            </select>
                        </div>

                        {!! Form::submit('Update ', ['class' => 'btn btn-success']) !!}

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Initialize the plugin: -->

    <script type="text/javascript">
        $(document).ready(function() {

            $('.selects').selectpicker();
            
        });
    </script>

    <script type="text/javascript">
        $('.select-role').change(function() {
            var id = $(this).val();
            $.ajax({
                url: "{{ route('select-role') }}",
                method: "GET",
                data: {
                    id: id
                },
                
                success: function(data) {
                    $('#show_permission').html(data);
                   
                    $('.shown').selectpicker('destroy');
                    $('.shown').selectpicker('refresh');
                    
                   
                },
                error:function(){
                    alert('loi');
                }
                
            });
        })
    </script>
@endsection
