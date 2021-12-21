<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Room;
use Auth;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $posts = Room::orderBy('id','DESC')->where('created_by', Auth::user()->id);
        if(empty($request->search))
        {            
            $posts = $posts;
        }
        else{
            $search = $request->search;
            $posts = $posts->where('room_type', 'LIKE',"%{$search}%");
        }
        $posts = $posts->paginate(15);
        $response = [
            'pagination' => [
                'total' => $posts->total(),
                'per_page' => $posts->perPage(),
                'current_page' => $posts->currentPage(),
                'last_page' => $posts->lastPage(),
                'from' => $posts->firstItem(),
                'to' => $posts->lastItem()
            ],
            'rooms' => $posts
        ];
        return response()->json($response);
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
        // dd($request);
        $this->validate($request, [
            'room_type' => 'required',
        ]);

        return Room::create([
           'room_type' => $request['room_type'],
           'slug' => str_replace(' ', '-', strtolower($request['room_type'])).'-'.rand(1000,9999),
           'room_no' => $request['room_no'],
           'no_of_bed' => $request['no_of_bed'],
           'price' => $request['price'],
           'is_active' => '1',
           'date' => date("Y-m-d"),
           'date_np' => $this->helper->date_np_con(),
           'time' => date("H:i:s"),
           'created_by' => Auth::user()->id,
        ]);
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
        $rooms = Room::findOrFail($id);
        return response()->json([
            'rooms'=>$rooms
        ],200);
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
        $this->validate($request, [
            'room_type' => 'required',
        ]);
        $rooms = Room::findOrFail($id);
        $rooms->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $rooms = Room::findOrFail($id);
        $rooms->delete();
        return ['message'=>'ok'];
    }
}
