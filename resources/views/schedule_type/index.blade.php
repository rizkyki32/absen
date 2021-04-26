@extends("layouts.global")
@section('header-scripts')
<script src="{{asset('swal2/dist/sweetalert2.min.js')}}"></script>
<link rel="stylesheet" href="{{asset('swal2/dist/sweetalert2.min.css')}}">
<!-- DataTables -->
<link rel="stylesheet" href="{{asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
@endsection

@section("title")Schedule Type @endsection

@section("content")

@if(session('status'))
<div class="flash-data" data-flashdata="{{session('status')}}"></div>
@endif

<!-- Preloader -->
<div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="{{asset('adminlte/dist/img/AdminLTELogo.png')}}" alt="AdminLTELogo" height="60" width="60">
  </div>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Daftar Schedule Type</h1>
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
                <a href="{{route('schedule_type.create')}}" class="btn btn-success">TAMBAH</a>
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
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Background Color</th>
                                        <th>Border Color</th>
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
        ajax: 'schedule_type/json',
        columns: [
            { data: 'id', name: 'id'},
            { data: 'schedule_type_name', name: 'schedule_type_name'},
            { data: 'backgroundColor', name: 'backgroundColor'},
            { data: 'borderColor', name: 'borderColor'},
            { data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        createdRow: function ( row, data, index ) {
            $('td', row).eq(2).css('background-color', data.backgroundColor);
            $('td', row).eq(3).css('background-color', data.borderColor);
        }
    })
});
</script>
@endsection