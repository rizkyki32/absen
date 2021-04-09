@extends("layouts.global")

@section("title") Manage Schedule @endsection

@section('header-scripts')
<!-- DataTables -->
<link rel="stylesheet" href="{{asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<script src="{{asset('swal2/dist/sweetalert2.min.js')}}"></script>
<link rel="stylesheet" href="{{asset('swal2/dist/sweetalert2.min.css')}}">
@endsection

@section("content")
{{-- <!-- Preloader -->
<div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="{{asset('adminlte/dist/img/AdminLTELogo.png')}}" alt="AdminLTELogo" height="60"
        width="60">
</div> --}}

@if(session('status'))
<div class="flash-data" data-flashdata="{{session('status')}}"></div>
@endif

@if ($errors->first('file'))
<div class="flash-data-error" data-flashdata="{{$errors->first('file')}}"></div>
@endif
@if ($errors->first('month'))
<div class="flash-data-error" data-flashdata="{{$errors->first('month')}}"></div>
@endif

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Manage Schedule</h1>
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
            <div class="btn-group mb-3">
                <a href="{{route('schedule.create')}}" class="btn btn-success">TAMBAH</a>
                <a href="" class="btn btn-info" data-toggle="modal" data-target="#importExcel">IMPORT</a>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        {{-- <div class="card-header">
                            <h3 class="card-title">DataTable with default features</h3>
                        </div> --}}
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="table-responsive">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Status</th>
                                        <th>Tanggal</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
        <h5>Title</h5>
        <p>Sidebar content</p>
    </div>
</aside>
<!-- /.control-sidebar -->

<!-- Import Excel -->
<div class="modal fade" id="importExcel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="post" action="{{route('import_action')}}" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Import Excel</h5>
                </div>
                <div class="modal-body">

                    @csrf

                    <label>Pilih file excel</label>
                    <div class="form-group">
                        <input type="file" name="file" required>
                    </div>
                    <label>Pilih bulan</label>
                    <div class="form-group">
                        <input type="month" class="form-control" name="month" required>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Import</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('footer-scripts')
<script src="{{asset('js/swal2.js')}}"></script>
<!-- DataTables  & Plugins -->
<script src="{{asset('adminlte/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script>
    $(function () {
    $("#example1").DataTable({
        processing: true,
        serverSide: true,
        ajax: 'schedule_json',
        columns: [
            { data: 'name', name: 'name'},
            { data: 'schedule_type_name', name: 'schedule_type_name'},
            { data: 'start', name: 'start'},
            { data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    })
});
</script>
@endsection