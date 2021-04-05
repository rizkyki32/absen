<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PresenceInController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
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
        $id_user = \Auth::user()->id;
        $user_date_now = \App\Models\Presence::where('id_user',$id_user)->where('date_time','LIKE','%'.date('Y-m-d').'%')->where('status','IN')->first();
        return view('presence_in.index', ['presence' => $user_date_now]);
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
     
        \Validator::make($request->all(), [
            "image" => "required",
            "latitude" => "required",
            "longitude" => "required"
        ])->validate();

        $image = $request->get('image');
        $latitude = $request->get('latitude');
        $longitude = $request->get('longitude');
        $folderPath = public_path() . '/presence_uploads/';
        $image_parts = explode(";base64,", $image);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $fileName = uniqid() . '.png';
        $file = $folderPath . $fileName;
        file_put_contents($file, $image_base64);
        
        $new_presence = new \App\Models\Presence;
        $new_presence->id_user = \Auth::user()->id;
        $new_presence->photo = $fileName;
        $new_presence->latitude = $latitude;
        $new_presence->longitude = $longitude;
        $new_presence->date_time = date("Y-m-d H:i:s");
        $new_presence->status = 'IN';
        $new_presence->save();
        return redirect()->route('presence_in.index')->with('status', 'Berhasil melakukan absen masuk!'); 
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
