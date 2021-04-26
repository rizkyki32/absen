<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use Illuminate\Http\Request;
use DataTables;
use DB;

class LeaveController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function json()
    {
        $data = Leave::select('*');
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {

                $btn = '<div class="btn btn-group"><a href="' . route('leave.edit', [$row->id]) . '" class="btn btn-warning">Edit</a><a href="#" data-title="' . $row->leave_name . '" class="btn btn-danger swal-confirm" onclick="deleteConfirmation(' . $row->id . ')"><form class="d-inline" action="' . route('leave.destroy', $row->id) . '" id="delete' . $row->id . '" method="POST">
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
        return view('leave.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('leave.create');
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
            "leave_name" => "required",
        ])->validate();

        $leave_name = $request->get('leave_name');

        $leave = new \App\Models\Leave;
        $leave->leave_name = $leave_name;
    
        $leave->save();

        return redirect()->route('leave.create')->with('status', 'Leave successfully created');
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
        $leave_row = \App\Models\Leave::findOrFail($id);
        return view('leave.edit', ['leave' => $leave_row]);
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
        $leave_name = $request->get('leave_name');

        $leave = \App\Models\Leave::findOrFail($id);

        \Validator::make($request->all(), [
            "leave_name" => "required",
        ])->validate();

        $leave->leave_name = $leave_name;

        $leave->save();

        return redirect()->route('leave.edit', [$id])->with('status', 'Leave successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $leave = \App\Models\Leave::findOrFail($id);

        $leave->delete();

        return redirect('leave')
            ->with('status', 'Shift successfully delete');
    }
}
