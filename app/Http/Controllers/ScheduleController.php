<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Imports\SchedulesImport;

use DB;
use DataTables;
use App\Jobs\ImportJob;

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
        return Datatables::of($data)->order(function ($query) {
            $query->orderBy('id', 'desc');
        })->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '<a href="' . route('schedule.edit', [$row->id]) . '" class="btn btn-primary">Edit</a>
                
                <a href="#" data-title="' . $row->title . '" class="btn btn-danger swal-confirm" onclick="deleteConfirmation(' . $row->id . ')">
                <form class="d-inline" action="' . route('schedule.destroy', $row->id) . '" id="delete' . $row->id . '" method="POST">
                    ' . csrf_field() . '
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
        $month = $request->get('month');
        // validasi
        $this->validate($request, [
            'file' => 'required|mimes:csv,xls,xlsx',
            'month' => 'required'
        ]);

        // upload file / get file
        $file = $request->file('file');

        // membuat nama file unik
		$nama_file = rand().$file->getClientOriginalName();

		// upload ke folder file_siswa di dalam folder public
		$file->move('file_schedule',$nama_file);

        // import file
        Excel::import(new SchedulesImport($month), public_path('/file_schedule/'.$nama_file));  
        //MENGHAPUS FILE EXCEL YANG TELAH DI-UPLOAD
        // unlink(public_path('/file_schedule/'.$nama_file)); 
        return redirect('/schedule_manage')->with('status', 'Import data berhasil!');
    }

    public function user_json(Request $request)
    {
        if ($request->get('type')) {
            if ($request->get('type') == "userData") {
                $sqlQuery = DB::table('users')->get();
                foreach($sqlQuery as $row){
                    $output[] = [
                        'nip' => $row->nip,
                        'name' => $row->name,
                    ];
                }
                echo json_encode($output); 
            }
        }
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
            "nip" => "required",
            "id_schedule_type" => "required",
            "start" => "required",
        ])->validate();

        $nip = $request->get('nip');
        $id_schedule_type = $request->get('id_schedule_type');
        $start = $request->get('start');

        $new_schedule = new \App\Models\Schedule;
        $new_schedule->nip = $nip;
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
        $users = DB::table('users')->get();
        $schedule_types = DB::table('schedule_types')->get();
        $schedule_to_edit = \App\Models\Schedule::findOrFail($id);

        return view('schedule.edit', ['users' => $users, 'schedule_types' => $schedule_types, 'schedule' => $schedule_to_edit]);
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
        $nip = $request->get('nip');
        $id_schedule_type = $request->get('id_schedule_type');
        $start = $request->get('start');

        $schedule = \App\Models\Schedule::findOrFail($id);

        \Validator::make($request->all(), [
            "nip" => "required",
            "id_schedule_type" => "required",
            "start" => "required",
        ])->validate();

        $schedule->nip = $nip;
        $schedule->id_schedule_type = $id_schedule_type;
        $schedule->start = $start;

        $schedule->save();

        return redirect()->route('schedule.edit', [$id])->with('status', 'Schedule successfully updated');
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
