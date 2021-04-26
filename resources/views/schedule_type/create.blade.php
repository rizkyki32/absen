@extends("layouts.global")

@section("title")Add Schedule Type @endsection

@section('header-scripts')
<script src="{{asset('swal2/dist/sweetalert2.min.js')}}"></script>
<link rel="stylesheet" href="{{asset('swal2/dist/sweetalert2.min.css')}}">

<!-- Bootstrap Color Picker -->
<link rel="stylesheet" href="{{asset('adminlte/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css')}}">
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
                    <h1 class="m-0">Add Schedule Type</h1>
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
                        <form action="{{route('schedule_type.store')}}" method="POST">
                            @csrf

                            <div class="card-body">
                                <div class="form-group">
                                    <label for="">Name</label>
                                    <input type="text" class="form-control" name="schedule_type_name" value="{{old('schedule_type_name')}}"
                                        placeholder="Masukkan nama schedule type...">
                                </div>
                                <!-- Color Picker -->
                                <div class="form-group">
                                    <label>Background Color</label>
                                    <input type="text" class="form-control my-colorpicker1" name="backgroundColor">
                                </div>
                                <!-- /.form group -->
                                <div class="form-group">
                                    <label>Border Color</label>
                                    <input type="text" class="form-control my-colorpicker1" name="borderColor">
                                </div>
                                <!-- /.form group -->
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="{{url('/schedule_type')}}" class="btn btn-danger">Kembali</a>
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
<!-- bootstrap color picker -->
<script src="{{asset('adminlte/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js')}}"></script>
<script src="{{asset('js/swal2.js')}}"></script>
{{-- <script src="{{asset('adminlte/plugins/moment/moment.min.js')}}"></script> --}}
<script>
    //Colorpicker
    $('.my-colorpicker1').colorpicker()
</script>
@endsection