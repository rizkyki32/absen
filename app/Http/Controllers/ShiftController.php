<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use Illuminate\Http\Request;
use DataTables;

class ShiftController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function json()
    {
        $data = Shift::select('*');
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {

                $btn = '<div class="btn btn-group"><a href="' . route('shift.edit', [$row->id]) . '" class="btn btn-warning">Edit</a><a href="#" data-title="' . $row->nama_shift . '" class="btn btn-danger swal-confirm" onclick="deleteConfirmation(' . $row->id . ')"><form class="d-inline" action="' . route('shift.destroy', $row->id) . '" id="delete' . $row->id . '" method="POST">
                ' . csrf_field() . '
                <input type="hidden" name="_method" value="DELETE">
            </form>
                Delete
            </a>';
                // 

                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('shift.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('shift.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        \Validator::make($request->all(), [
            "nama_shift" => "required",
            "jam_masuk" => "required",
            "jam_keluar" => "required",
            "toleransi_telat" => "required",
            "keterangan" => "required",
        ])->validate();

        $nama_shift = $request->get('nama_shift');
        $jam_masuk = $request->get('jam_masuk');
        $jam_keluar = $request->get('jam_keluar');

        $waktu_awal     = strtotime($request->get('jam_masuk'));
        $waktu_akhir    = strtotime($request->get('jam_keluar'));
        //menghitung selisih dengan hasil detik
        $diff = $waktu_akhir - $waktu_awal;
        //membagi detik menjadi jam
        $jam = floor($diff / (60 * 60));
        //membagi sisa detik setelah dikurangi $jam menjadi menit
        $menit = $diff - $jam * (60 * 60);
        $total_jam_kerja = $jam.':'.floor($menit/60);
        
        $toleransi_telat = $request->get('toleransi_telat');
        $keterangan = $request->get('keterangan');

        $shift = new \App\Models\Shift();
        $shift->nama_shift = $nama_shift;
        $shift->jam_masuk = $jam_masuk;
        $shift->jam_keluar = $jam_keluar;
        $shift->total_jam_kerja = $total_jam_kerja;
        $shift->toleransi_telat = $toleransi_telat;
        $shift->keterangan = $keterangan;
    
        $shift->save();

        return redirect()->route('shift.create')->with('status', 'Shift successfully created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $shift = \App\Models\Shift::findOrFail($id);
        return view('shift.edit', ['shift' => $shift]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $shift = \App\Models\Shift::findOrFail($id);

        $shift->delete();

        return redirect('shift')
            ->with('status', 'Shift successfully delete');
    }
}
