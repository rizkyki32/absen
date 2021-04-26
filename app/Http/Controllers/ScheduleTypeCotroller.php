<?php

namespace App\Http\Controllers;

use App\Models\ScheduleType;
use Illuminate\Http\Request;

use DataTables;

class ScheduleTypeCotroller extends Controller
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

    public function json()
    {
        $data = ScheduleType::select('*');
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {

                $btn = '<div class="btn btn-group"><a href="' . route('schedule_type.edit', [$row->id]) . '" class="btn btn-warning">Edit</a><a href="#" data-title="' . $row->schedule_type_name . '" class="btn btn-danger swal-confirm" onclick="deleteConfirmation(' . $row->id . ')">
                <form class="d-inline" action="' . route('schedule_type.destroy', $row->id) . '" id="delete' . $row->id . '" method="POST">
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('schedule_type.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('schedule_type.create');
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
            "schedule_type_name" => "required",
            "backgroundColor" => "required",
            "borderColor" => "required",
        ])->validate();

        $schedule_type_name = $request->get('schedule_type_name');
        $backgroundColor = $request->get('backgroundColor');
        $borderColor = $request->get('borderColor');

        $schedule_type = new \App\Models\ScheduleType;
        $schedule_type->schedule_type_name = $schedule_type_name;
        $schedule_type->backgroundColor = $backgroundColor;
        $schedule_type->borderColor = $borderColor;
        $schedule_type->save();

        return redirect()->route('schedule_type.create')->with('status', 'Schedule type successfully created');
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
        $schedule_type = \App\Models\ScheduleType::findOrFail($id);

        return view('schedule_type.edit', ['scheduleType' => $schedule_type]);
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
        $schedule_type_name = $request->get('schedule_type_name');
        $backgroundColor = $request->get('backgroundColor');
        $borderColor = $request->get('borderColor');

        $schedule_type = \App\Models\ScheduleType::findOrFail($id);

        \Validator::make($request->all(), [
            "schedule_type_name" => "required",
            "backgroundColor" => "required",
            "borderColor" => "required",
        ])->validate();

        $schedule_type->schedule_type_name = $schedule_type_name;
        $schedule_type->backgroundColor = $backgroundColor;
        $schedule_type->borderColor = $borderColor;

        $schedule_type->save();

        return redirect()->route('schedule_type.edit', [$id])->with('status', 'Schedule type successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $scheduleType = \App\Models\ScheduleType::findOrFail($id);

        $scheduleType->delete();

        return redirect('schedule_type')
            ->with('status', 'Schedule successfully delete');
    }
}
