<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Calendar;
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
    public function index()
    {

        //
        return view('schedule.index');
    }

    public function calendar(Request $request)
    {
        //
        $events = [];
        $data = DB::table('calendar_view')->where('nip','=',$request->nip)->get();

        if($data->count()) {
            foreach ($data as $key => $value) {
                $events[] = Calendar::event(
                    $value->title,
                    true,
                    new \DateTime($value->start),
                    new \DateTime($value->start),
                    $value->id,
                    // Add color and link on event
	                [
	                    'color' => $value->backgroundColor,
	                    'border' => $value->borderColor,
	                    // 'url' => 'pass here url and any route',
	                ]
                );
            }
        }
        $calendar = Calendar::addEvents($events);
        return view('schedule.calendar', compact('calendar'));
    }

    public function schedule_json()
    {
        $data = DB::table('calendar_view');
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('is_open', function ($row) {
                if($row->is_open == '1'){
                    return 'Ya';
                } else {
                    return 'Tidak';
                }
            })
            ->addColumn('action', function ($row) {
                $btn = '<div class="btn btn-group"><a href="' . route('schedule.edit', [$row->id]) . '" class="btn btn-warning">Edit</a>
                
                <a href="#" data-title="' . $row->title . '" class="btn btn-danger swal-confirm" onclick="deleteConfirmation(' . $row->id . ')">
                <form class="d-inline" action="' . route('schedule.destroy', $row->id) . '" id="delete' . $row->id . '" method="POST">
                    ' . csrf_field() . '
                    <input type="hidden" name="_method" value="DELETE">
                </form>
                    Delete
                </a></div>';
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
        // MENGHAPUS FILE EXCEL YANG TELAH DI-UPLOAD
        // unlink(public_path('/file_schedule/'.$nama_file)); 
        return redirect('/schedule_manage')->with('status', 'Import data berhasil!');
    }

    public function user_json(Request $request)
    {
        if ($request->get('type')) {
            if ($request->get('type') == "department_data") {
                $sqlQuery = DB::table('departments')->get();
                foreach ($sqlQuery as $row) {
                    $output[] = [
                        'id' => $row->id,
                        'name' => $row->department_name,
                    ];
                }
                echo json_encode($output);
            } else {
                $id_department = $request->get('id_department');
                $sqlQuery = DB::table('users')->where('id_department', $id_department)->get();
                foreach ($sqlQuery as $row) {
                    $output[] = [
                        'id' => $row->id,
                        'name' => $row->name
                    ];
                }
                echo json_encode($output);
            }
        }
    }
    // public function user_json(Request $request)
    // {
    //     if ($request->get('type')) {
    //         if ($request->get('type') == "userData") {
    //             $sqlQuery = DB::table('users')->get();
    //             foreach($sqlQuery as $row){
    //                 $output[] = [
    //                     'nip' => $row->nip,
    //                     'name' => $row->name,
    //                 ];
    //             }
    //             echo json_encode($output); 
    //         }
    //     }
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = DB::table('users')->get();
        $schedule_type = DB::table('schedule_types')->get();
        $shift = DB::table('shifts')->get();
        return view('schedule.create', ['users' => $users, 'schedule_type' => $schedule_type, 'shift' => $shift]);
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
            "is_open" => "required",
        ])->validate();

        $nip = $request->get('nip');
        $id_schedule_type = $request->get('id_schedule_type');
        $start = $request->get('start');
        $is_open = $request->get('is_open');

        $new_schedule = new \App\Models\Schedule;
        $new_schedule->nip = $nip;
        $new_schedule->id_schedule_type = $id_schedule_type;
        $new_schedule->start = $start;
        $new_schedule->is_open = $is_open;
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
        $is_open = $request->get('is_open');

        $schedule = \App\Models\Schedule::findOrFail($id);

        \Validator::make($request->all(), [
            "nip" => "required",
            "id_schedule_type" => "required",
            "start" => "required",
            "is_open" => "required",
        ])->validate();

        $schedule->nip = $nip;
        $schedule->id_schedule_type = $id_schedule_type;
        $schedule->start = $start;
        $schedule->is_open = $is_open;

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
