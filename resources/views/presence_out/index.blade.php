@extends("layouts.global")

@section("title") Absen Keluar @endsection

@section('header-scripts')
<script src="{{asset('swal2/dist/sweetalert2.min.js')}}"></script>
<link rel="stylesheet" href="{{asset('swal2/dist/sweetalert2.min.css')}}">
@endsection

@section("content")

<style>
    #results {
        padding: 20px;
        border: 1px solid;
        background: #ccc;
    }

    @media (max-width: 576px) {
        #my_camera video {
            padding-left: 200px;
            max-width: 100%;
            max-height: 100%;
        }

        #results img {
            max-width: 80%;
            max-height: 80%;
        }
    }
</style>

@if(session('status'))
<div class="flash-data" data-flashdata="{{session('status')}}"></div>
@endif

@if ($errors->first('image'))
<div class="flash-data-error" data-flashdata="{{$errors->first('image')}}"></div>
@endif

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Absen Keluar</h1>
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
                <div class="col-12 col-md-12 col-lg-6 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{route('presence_out.store')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div id="my_camera"></div>
                                <br>
                                <input type="hidden" name="image" class="image-tag">
                                <input type="text" name="latitude" class="latitude-tag">
                                <input type="text" name="longitude" class="longitude-tag">
                                <br>
                                <br>
                                @if (!empty($presence_in->date_time))
                                <input type="button" class="btn btn-info" value="Ambil Foto" onClick="take_snapshot()">
                                <button class="btn btn-danger">Absen Sekarang</button>
                                <p>Jumlah absensi keluar hari ini : {{$presence_out}}</p>
                                @else
                                <p><b>*Anda belum melakukan absen masuk!<b></p>
                                @endif

                        </div>
                    </div>

                </div>
                <div class="col-12 col-md-12 col-lg-6 mb-3">
                    <div id="results">Your captured image will appear here...</div>
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
<script src="{{asset('webcam/webcam.js')}}"></script>

<script>
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else { 
        x.innerHTML = "Geolocation is not supported by this browser.";
    }

    function showPosition(position) {
        document.getElementsByClassName("latitude-tag")[0].setAttribute("value", position.coords.latitude);
        document.getElementsByClassName("longitude-tag")[0].setAttribute("value", position.coords.longitude);
    }

    Webcam.set({
            width: 325,
            height: 290,
            image_format: 'jpeg',
            jpeg_quality: 90,
            flip_horiz: true,
            // constraints: {
            //     width: 320, // { exact: 320 },
            //     height: 180, // { exact: 180 },
            //     facingMode: 'environment',
            //     frameRate: 30
            // }
        });

        Webcam.attach('#my_camera');

        function take_snapshot() {
            Webcam.snap(function(data_uri) {
                $(".image-tag").val(data_uri);
                document.getElementById('results').innerHTML = '<img src="' + data_uri + '"/>';
            });
        }
</script>
@endsection