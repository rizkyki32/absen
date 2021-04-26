@extends("layouts.global")
@section('header-scripts')

@endsection

@section("title")Laporan Absensi @endsection

@section("content")
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
                <div class="col-sm-12">
                    <h1 class="m-0 text-center">Laporan Kehadiran Karyawan</h1>
                    <h1 class="m-0 text-center">{{date('m - Y')}}</h1>
                </div><!-- /.col -->
                <div class="col-sm-12">
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
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">PT. PANGANSARI UTAMA</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <td>NAMA STAFF</td>
                                    <td>:</td>
                                    <td>{{$user->name}}</td>
                                </tr>
                                <tr>
                                    <td>NIP</td>
                                    <td>:</td>
                                    <td>{{$user->nip}}</td>
                                </tr>
                                <tr>
                                    <td>DEPARTEMEN</td>
                                    <td>:</td>
                                    <td>HR ADMIN & HR</td>
                                </tr>
                                <tr>
                                    <td>JABATAN</td>
                                    <td>:</td>
                                    <td>HR ADMIN</td>
                                </tr>
                            </table>
                            <table class="table table-bordered">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Hari</th>
                                    <th>Tipe</th>
                                    <th>Jam Masuk</th>
                                    <th>Jam Keluar</th>
                                    <th>Total Jam Kerja</th>
                                    <th>Lembur Terusan</th>
                                    <th>Lembur</th>
                                    <th>Total Kurang Jam</th>
                                    <th>Datang Telat (Menit)</th>
                                    <th>Pulang Cepat (Menit)</th>
                                    <th>Tidak Absen (Hari)</th>
                                    <th>Lupa Absen (Hari)</th>
                                    <th>Ijin(Hari)</th>
                                </tr>
                                @foreach ($report as $key => $r)
                                <tr>
                                    <td>{{$r->tanggal}}</td>
                                    <td>{{$r->hari}}</td>
                                    <td>{{$r->tipe}}</td>
                                    <td>{{$r->jam_masuk}}</td>
                                    <td>{{$r->jam_keluar}}</td>
                                    <td>{{$r->total_jam_kerja}}</td>
                                    <td>{{$r->lembur_terusan}}</td>
                                    <td>{{$r->lembur}}</td>
                                    <td>{{$r->total_kurang_jam}}</td>
                                    <td>{{$r->datang_telat_menit}}</td>
                                    <td>{{$r->pulang_cepat_menit}}</td>
                                    <td>{{$r->tidak_absen_hari}}</td>
                                    <td>{{$r->lupa_absen_hari}}</td>
                                    <td>{{$r->ijin_hari}}</td>
                                </tr>
                                @endforeach
                            </table>
                            <div class="col-xs-12 col-md-4">
                                <h3>Evaluasi Kehadiran Staff</h3>
                            <table class="table">
                                <tr>
                                    <td>Datang Terlambat</td>
                                    <td>:</td>
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <td>Lupa Absen</td>
                                    <td>:</td>
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <td>Absen (Tidak Masuk)</td>
                                    <td>:</td>
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <td>Ijin</td>
                                    <td>:</td>
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <td>Total Hari Periode Kerja</td>
                                    <td>:</td>
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <td>Total Hadir Kerja</td>
                                    <td>:</td>
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <td>Persentase Kehadiran</td>
                                    <td>:</td>
                                    <td>-</td>
                                </tr>
                            </table>
                            </div>
                            
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

@endsection