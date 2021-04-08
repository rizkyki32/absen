<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Imports\SchedulesImport;

use DB;
use DataTables;


class ScheduleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        //
        if ($request->ajax()) {

            $data = DB::table('calendar_view')->where('start', '>=', $request->start)->get(['id', 'title', 'start', 'backgroundColor', 'borderColor']);

            // $data = Schedule::whereDate('start', '>=', $request->start)

            //     ->get(['id', 'id_user', 'start', 'title', 'backgroundColor']);

            return response()->json($data);
        }
        return view('schedule.index');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    // public function ajax(Request $request)
    // {
    //     switch ($request->type) {
    //         case 'add':
    //             $event = Schedule::create([
    //                 'status' => $request->title,
    //                 'start' => $request->start,
    //                 'end' => $request->end,
    //             ]);
    //             return response()->json($event);
    //             break;
    //         case 'update':
    //             $event = Schedule::find($request->id)->update([
    //                 'status' => $request->title,
    //                 'start' => $request->start,
    //                 'end' => $request->end,
    //             ]);
    //             return response()->json($event);
    //             break;

    //         case 'delete':
    //             $event = Schedule::find($request->id)->delete();
    //             return response()->json($event);
    //             break;
    //         default:
    //             # code...
    //             break;
    //     }
    // }

    public function schedule_json()
    {
        $data = DB::table('calendar_view');
        return Datatables::of($data)->order(function ($query){
            $query->orderBy('id','desc');
        })->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '<a href="'.route('schedule.edit', [$row->id]).'" class="btn btn-primary">Edit</a>
                
                <a href="#" data-title="'.$row->title.'" class="btn btn-danger swal-confirm" onclick="deleteConfirmation('.$row->id.')">
                <form class="d-inline" action="'.route('schedule.destroy', $row->id).'" id="delete'.$row->id.'" method="POST">
                    '.csrf_field().'
                    <input type="hidden" name="_method" value="DELETE">
                </form>
                    Delete
                </a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function schedule_manage()
    {
        $schedule = DB::table('calendar_view')->get();
        return view('schedule.manage', ['schedule' => $schedule]);
    }

    public function import_action(Request $request)
    {
        // validasi
        $this->validate($request, [
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);

        // menangkap file excel
        $file = $request->file('file');

        // membuat nama file unik
        $nama_file = rand() . $file->getClientOriginalName();

        // upload ke folder file_schedule di dalam folder public
        $file->move('file_schedule', $nama_file);

        // import data
        Excel::import(new SchedulesImport, public_path('/file_schedule/' . $nama_file));

        // alihkan halaman kembali dan notifikasi dengan session
        return redirect('/schedule_manage')->with('status', 'Import data berhasil!'); ;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = DB::table('users')->get();
        $schedule_types = DB::table('schedule_types')->get();
        return view('schedule.create', ['users' => $users, 'schedule_types' => $schedule_types]);
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
            "id_user" => "required",
            "id_schedule_type" => "required",
            "start" => "required",
        ])->validate();

        $id_user = $request->get('id_user');
        $id_schedule_type = $request->get('id_schedule_type');
        $start = $request->get('start');

        $new_schedule = new \App\Models\Schedule;
        $new_schedule->id_user = $id_user;
        $new_schedule->id_schedule_type = $id_schedule_type;
        $new_schedule->start = $start;
        $new_schedule->save();

        return redirect()->route('schedule.create')->with('status', 'Schedule successfully created');
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
        $schedule = \App\Models\Schedule::findOrFail($id);

        $schedule->delete();

        return redirect('schedule_manage')
            ->with('status', 'Schedule successfully delete');
    }
}
