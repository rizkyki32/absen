@extends("layouts.global")
@section('header-scripts')
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.min.css">
<!-- DataTables -->
<link rel="stylesheet" href="{{asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
@endsection

@section("title")History Absensi @endsection

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
                    <h1 class="m-0">History Absensi</h1>
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
            <div class="form-row">
                <div class="form-group col-md-4">
                    <select name="department" id="department" class="form-control" data-live-search="true"
                        title="Department"></select>
                </div>
                <div class="form-group col-md-4">
                    <select name="name" id="name" class="form-control" data-live-search="true" title="Name"></select>
                </div>
                <div class="form-group col-md-2">
                    <button id="filter" class="btn btn-success">Cari</button>
                    <button id="reset" class="btn btn-danger">Reset</button>
                </div>
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
                                            <th>Waktu Lama</th>
                                            <th>Waktu Baru</th>
                                            <th>Status Lama</th>
                                            <th>Status Baru</th>
                                            <th>Catatan</th>
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
<!-- Latest compiled and minified JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="{{asset('adminlte/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script>
    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            } 
        });
    $('#department').selectpicker();
    $('#name').selectpicker();
    var SITEURL = "{{ url('/') }}";
    
    load_data('department_data');

    function load_data(type, id_department = '')
    {
        $.ajax({
            url: SITEURL + "/presence_history/department_json",
            method:"POST",
            data:{type : type, id_department:id_department},
            dataType:"json",
            success:function(data)
            {
                var html = '';
                for(var count = 0; count < data.length; count++)
                {
                    html += '<option value="'+data[count].id+'">'+data[count].name+'</option>';
                }
                if(type == 'department_data')
                {
                    $('#department').html(html);
                    $('#department').selectpicker('refresh');
                }
                else
                {
                    $('#name').html(html);
                    $('#name').selectpicker('refresh');
                }
            }
        })
    }

    $(document).on('change', '#department', function(){
        var id_department = $('#department').val();
        load_data('name', id_department);
    });

    fill_datatable();

    function fill_datatable(filter_department_id = '', filter_user_id = '')
    {
        var dataTable = $('#example1').DataTable({
            processing: true,
            serverSide: true,
            ajax:{
                url: 'presence_history/search_json',
                data:{filter_department_id : filter_department_id, filter_user_id : filter_user_id}
            },
            columns: [
                { data: 'name', name: 'name'},
                { data: 'email', name: 'email'},
                { data: 'department_name', name: 'department_name'},
                { data: 'date_time_old', name: 'date_time_old'},
                { data: 'date_time_new', name: 'date_time_new'},
                { data: 'status_old', name: 'status_old'},
                { data: 'status_new', name: 'status_new'},
                { data: 'note', name: 'note'},
            ],
        });
    }

    $('#filter').click(function(){
        let filter_department_id = $('#department').val();
        let filter_user_id = $('#name').val();
        
        if(filter_user_id != '')
        {
            filter_department_id = '';
            $('#example1').DataTable().destroy();
            fill_datatable(filter_department_id, filter_user_id);
        }
        else if(filter_department_id != ''){
            $('#example1').DataTable().destroy();
            fill_datatable(filter_department_id, filter_user_id);
        }else{
            alert('Silahkan pilih nama departemen dan nama pegawai');
        }
    });

    $('#reset').click(function(){
        $('#filter_department_id').val('');
        $('#filter_user_id').val('');
        $('#example1').DataTable().destroy();
        fill_datatable();
    });
});
</script>
@endsection