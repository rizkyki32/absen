@extends("layouts.global")

@section("title")Add Leave @endsection

@section('header-scripts')
<script src="{{asset('swal2/dist/sweetalert2.min.js')}}"></script>
<link rel="stylesheet" href="{{asset('swal2/dist/sweetalert2.min.css')}}">
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
                    <h1 class="m-0">Add Leave</h1>
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
                        <form action="{{route('leave.store')}}" method="POST">
                            @csrf

                            <div class="card-body">
                                <div class="form-group">
                                    <label for="">Tipe Izin</label>
                                    <input type="text" class="form-control" name="leave_name" value="{{old('leave_name')}}"
                                        placeholder="Masukkan tipe izin...">
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="{{url('/leave')}}" class="btn btn-danger">Kembali</a>
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
<script src="{{asset('js/swal2.js')}}"></script>
@endsection