@extends("layouts.global")

@section("title")Edit Schedule @endsection

@section('header-scripts')
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="{{asset('swal2/dist/sweetalert2.min.js')}}"></script>
<link rel="stylesheet" href="{{asset('swal2/dist/sweetalert2.min.css')}}">
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.min.css">
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
                    <h1 class="m-0">Edit Schedule</h1>
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
                        <form action="{{route('schedule.update', [$schedule->id])}}" method="POST">
                            @csrf

                            <input type="hidden" value="PUT" name="_method">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="">Nama</label>
                                    <select name="nip" data-live-search="true" id="nip" class="form-control"></select>
                                        {{-- @foreach ($users as $u)
                                            <option value="{{ $u->nip }}"
                                                {{ ($schedule->nip == $u->nip) ? 'selected' : ''}} 
                                                >{{ $u->name }}</option>
                                        @endforeach --}}
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Status</label>
                                    <select name="id_schedule_type" id="" class="form-control">
                                        @foreach ($schedule_types as $st)
                                            <option value="{{ $st->id }}" {{ ($schedule->id_schedule_type == $st->id) ? 'selected' : ''}}>{{ $st->schedule_type_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Tanggal</label>
                                    <input name="start" type="date" class="form-control {{$errors->first('start') ? "is-invalid" : ""}}" value="{{old('start') ? old('start') : $schedule->start}}">
                                </div>
                                <div class="invalid-feedback d-block"> 
                                    {{$errors->first('start')}}
                                </div>
                                <div class="form-group">
                                    <label for="">Open ?</label>
                                    <select id="" class="form-control" name="is_open"> 
                                        <option value="0">Tidak</option>
                                        <option value="1" {{ ($schedule->is_open == "1") ? 'selected' : '' }}>Ya</option>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
<script src="{{asset('js/swal2.js')}}"></script>
<script>
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            } 
        });
        var SITEURL = "{{ url('/') }}";
        $('#id_user').selectpicker();

        load_data("userData");

        function load_data(type){
            $.ajax({
                url: SITEURL + "/schedule/user_json",
                method: "POST",
                data: { type: type},
                dataType: "json",
                success: function (data) {
                    var html = "";
                    var old_nip = "{{ $schedule->nip }}";
                    for (var count = 0; count < data.length; count++) {
                        html += `<option value="${data[count].nip}" ${(data[count].nip == old_nip) ? "selected" : ""}>${data[count].name}</option>`;
                    }
                    if (type == "userData") {
                        $("#nip").html(html);
                        $("#nip").selectpicker("refresh");
                    }
                },
            });
        }
    });
</script>
@endsection