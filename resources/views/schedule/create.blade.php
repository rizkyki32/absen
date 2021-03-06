@extends("layouts.global")

@section("title")Add Schedule @endsection

@section('header-scripts')
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="{{asset('swal2/dist/sweetalert2.min.js')}}"></script>
<link rel="stylesheet" href="{{asset('swal2/dist/sweetalert2.min.css')}}">
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.min.css">
@endsection

@section("content")

@if(session('status'))
<div class="flash-data" data-flashdata="{{session('status')}}"></div>
@endif

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Add Schedule</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Starter Page</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-6">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <!-- general form elements -->
                    <div class="card card-primary">
                        {{-- <div class="card-header">
                            <h3 class="card-title">Tambah</h3>
                        </div> --}}
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{route('schedule.store')}}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="">Department</label>
                                    <select name="department" id="department" class="form-control" data-live-search="true"
                        title="Department"></select>
                                </div>
                                <div class="form-group">
                                    <label for="">Nama</label>
                                    <select name="nip" id="nip" class="form-control" data-live-search="true" title="Name"></select>
                                </div>
                                <div class="form-group">
                                    <label for="">Tipe Jadwal</label>
                                    <select name="id_schedule_type" id="" class="form-control">
                                        @foreach ($schedule_type as $st)
                                        <option value="{{ $st->id }}" @if (old('id_schedule_type')==$st->id)
                                            selected
                                            @endif>{{ $st->schedule_type_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Tipe Shift</label>
                                    <select name="id_shift" id="" class="form-control">
                                        @foreach ($shift as $sh)
                                        <option value="{{ $sh->id }}" @if (old('id_shift')==$sh->id)
                                            selected
                                            @endif>{{ $sh->nama_shift }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Tanggal</label>
                                    <input name="start" type="date"
                                        class="form-control {{$errors->first('start') ? "is-invalid" : ""}}"
                                        value="{{old('start')}}">
                                </div>
                                <div class="invalid-feedback d-block">
                                    {{$errors->first('start')}}
                                </div>
                                <div class="form-group">
                                    <label for="">Open ?</label>
                                    <select id="" class="form-control" name="is_open">
                                        <option value="0">Tidak</option>
                                        <option value="1">Ya</option>
                                    </select>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="{{url('/schedule_manage')}}" class="btn btn-danger">Kembali</a>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection

@section('footer-scripts')
<!-- Latest compiled and minified JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
<script src="{{asset('js/swal2.js')}}"></script>
<script>
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            } 
        });
        $('#department').selectpicker();
        $('#nip').selectpicker();
        var SITEURL = "{{ url('/') }}";

        load_data("department_data");

        function load_data(type, id_department = ''){
            $.ajax({
                url: SITEURL + "/schedule/user_json",
                method: "POST",
                data: { type: type, id_department: id_department},
                dataType: "json",
                success: function (data) {
                    var html = '';                         

                    for(var count = 0; count < data.length; count++)
                    {
                        html += `<option value="`+data[count].id+`">`+data[count].name+`</option>`;
                    }
                    if(type == 'department_data')
                    {
                        $('#department').html(html);
                        $('#department').selectpicker('refresh');
                    }
                    else
                    {
                        $('#nip').html(html);
                        $('#nip').selectpicker('refresh');
                    }
            
                    $(document).on('change', '#department', function(){
                        var id_department = $('#department').val();
                        load_data('name', id_department);
                    });

                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    $('#nip').val('');
                    return alert("Silahkan pilih department lain : " + errorThrown);
                }
            });
        }
    });
</script>
@endsection