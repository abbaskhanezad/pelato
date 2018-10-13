<?php

namespace App\Http\Controllers;

use App\CenterAttribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoomAttributeController extends Controller
{
    /**
     * Display a listing of the room attributes.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CenterAttribute $room_attribute, Request $request)
    {
        $room_attributes = CenterAttribute::whereType('room')->paginate(10);
        if ($request->is('*/edit')) {
            $edit = true;
        }else{
            $edit = false;
        }
        return view('room_attribute.index', compact('room_attributes', 'edit', 'room_attribute'));
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
     * Store a newly created room attribute in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'name' => 'required|string',
        ]);
        $request->merge(['type' => 'room']);
        CenterAttribute::create($request->all());
        return redirect()->back()->with(flash_message("ویژگی اتاق با موفقیت افزوده شد.","success"));
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
    public function edit(CenterAttribute $centerAttribute)
    {

    }

    /**
     * Update the specified room attribute in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CenterAttribute $room_attribute)
    {
        Validator::make($request->all(), [
            'name' => 'required|string',
        ]);
        $room_attribute->update($request->all());
        return redirect()->back()->with(flash_message("ویژگی اتاق با موفقیت ویرایش شد.","success"));
    }

    /**
     * Remove the specified attribute from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(CenterAttribute $room_attribute)
    {
        $room_attribute->delete();
        return redirect()->back()->with(flash_message("ویژگی اتاق با موفقیت حذف شد.","success"));
    }
}
