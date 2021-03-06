@extends("layouts.global")
@section('header-scripts')
<!-- DataTables -->
<link rel="stylesheet" href="{{asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
{{-- <link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="../../plugins/datatables-buttons/css/buttons.bootstrap4.min.css"> --}}
@endsection

@section("title")Daftar Absensi @endsection

@section("content")
<!-- Preloader -->
<div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="{{asset('adminlte/dist/img/AdminLTELogo.png')}}" alt="AdminLTELogo" height="60"
        width="60">
</div>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Daftar Absensi</h1>
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
                <a href="{{url('presence_search')}}" class="btn btn-success">SEARCH ALL</a>
                <a href="{{route('presence_history.index')}}" class="btn btn-info">HISTORY ALL</a>
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
                                <table id="example1" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Department</th>
                                            <th>Waktu</th>
                                            <th>Catatan</th>
                                            <th>Status</th>
                                            <th>Tipe Jadwal</th>
                                            <th>Tipe Shift</th>
                                            {{-- <th>Jam Masuk</th>
                                            <th>Jam Keluar</th> --}}
                                            <th>Keterangan</th>
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
<!-- DataTables  & Plugins -->
<script src="{{asset('adminlte/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
{{-- <script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="../../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="../../plugins/jszip/jszip.min.js"></script>
<script src="../../plugins/pdfmake/pdfmake.min.js"></script>
<script src="../../plugins/pdfmake/vfs_fonts.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.colVis.min.js"></script> --}}
<script>
$(function () {
    $("#example1").DataTable({
        processing: true,
        serverSide: true,
        ajax: 'presence_list/json',
        columns: [
            { data: 'name', name: 'name'},
            { data: 'email', name: 'email'},
            { data: 'department_name', name: 'department_name'},
            { data: 'date_time', name: 'date_time'},
            { data: 'note', name: 'note'},
            { data: 'status', name: 'status'},
            { data: 'schedule_type_name', name: 'schedule_type_name'},
            { data: 'nama_shift', name: 'nama_shift'},
            // { data: 'jam_masuk', name: 'jam_masuk'},
            // { data: 'jam_keluar', name: 'jam_keluar'},
            { data: 'keterangan', name: 'keterangan'},
            { data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        createdRow: function ( row, data, index ) {
            if(data.keterangan == "Late"){
                $('td', row).eq(8).css('background-color', '#f70000');
            } else if(data.keterangan == "Earlier"){
                $('td', row).eq(8).css('background-color', '#f70000');
            }
        }
    });
});
</script>
@endsection