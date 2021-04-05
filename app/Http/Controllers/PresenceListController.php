<?php

namespace App\Http\Controllers;

use App\Models\PresenceList;
use Illuminate\Http\Request;
use DataTables;

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

                $btn = '<a href="'.route('presence_list.show', [$row->id]).'" class="edit btn btn-primary btn-sm">View</a>';

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
    public function edit(PresenceList $presenceList)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PresenceList  $presenceList
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PresenceList $presenceList)
    {
        //
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
}
