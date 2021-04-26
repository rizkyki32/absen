<?php

namespace App\Http\Controllers;

use App\Models\PresenceHistory;
use Illuminate\Http\Request;
use DB;
use DataTables;

class PresenceHistoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
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
                $data = PresenceHistory::select('*')->where('id_department', $request->filter_department_id)->get();                
            }else if(!empty($request->filter_user_id)){
                $data = PresenceHistory::select('*')->where('id_user', $request->filter_user_id)->get();
            } else {
                $data = PresenceHistory::select('*')->get();
            }
            return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('presence_history.index');
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
        //
    }
}
