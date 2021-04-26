<?php

namespace App\Http\Controllers;

use App\Models\PresenceList;
use Illuminate\Http\Request;
use DataTables;
use DB;

class PresenceListController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function json()
    {
        $id_user = \Auth::user()->id;
        $data = PresenceList::select('*')->where('id_user', $id_user);
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {

                $btn = '<div class="btn btn-group"><a href="' . route('presence_list.show', [$row->id]) . '" class="btn btn-primary">Show</a><a href="' . route('presence_list.edit', [$row->id]) . '" class="btn btn-warning">Edit</a></div>';
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
        return view('presence_list.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PresenceList  $presenceList
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $presenceList = \App\Models\PresenceList::findOrFail($id);
        return view('presence_list.show', ['presence_row' => $presenceList]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PresenceList  $presenceList
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $shiftType = \App\Models\Shift::select('*')->get();
        $scheduleType = \App\Models\ScheduleType::select('*')->get();
        $presenceList = \App\Models\PresenceList::findOrFail($id);
        return view('presence_list.edit', ['presenceList' => $presenceList, 'scheduleType' => $scheduleType,'shiftType' => $shiftType]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PresenceList  $presenceList
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $date_time = $request->get('date_time');
        $note = $request->get('note');
        $status = $request->get('status');
        
        \Validator::make($request->all(), [
            "date_time" => "required",
            "status" => "required",
            "note" => "required",
        ])->validate();

        $presence = \App\Models\Presence::findOrFail($id);
        $presence->date_time = $date_time;
        $presence->note = $note;
        $presence->status = $status;

        DB::table('presence_histories')->insert([
            'id_presence' => $id,
            'date_time_old' => $presence->getOriginal('date_time'),
            'date_time_new' => $date_time,
            'status_old' => $presence->getOriginal('status'),
            'status_new' => $status,
        ]);

        $presence->save();

        return redirect()->route('presence_list.edit', [$id])->with('status', 'Presence successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PresenceList  $presenceList
     * @return \Illuminate\Http\Response
     */
    public function destroy(PresenceList $presenceList)
    {
        //
    }

    public function department_json(Request $request)
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

    public function search_json(Request $request)
    {
        if (request()->ajax()) 
        { 
            if(!empty($request->filter_department_id)){
                $data = PresenceList::select('*')->where('id_department', $request->filter_department_id)->get();                
            }else if(!empty($request->filter_user_id)){
                $data = PresenceList::select('*')->where('id_user', $request->filter_user_id)->get();
            } else {
                $data = PresenceList::select('*')->get();
            }
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {

                $btn = '<div class="btn btn-group"><a href="' . route('presence_list.show', [$row->id]) . '" class="btn btn-primary">Show</a><a href="' . route('presence_list.edit', [$row->id]) . '" class="btn btn-warning">Edit</a></div>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
    }

    public function search()
    {
        //
        return view('presence_list.search');
    }
}
