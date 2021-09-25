<?php

namespace App\Http\Controllers;

use Illuminate\Validation\ValidationException;
use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $this->validate($request,[
            'location' => 'required|string|min:3|unique:locations',
            'state_id' => 'required|numeric',

        ]);

            $location = new Location;
            $location->location = $request->location;
            $location->state_id = $request->state_id;


            if($location->save()){
                return response()->json('Successful', 200);
            }
            else{
                throw ValidationException::withMessages([
                    'Error' => ['An error Occured while trying to save location']
                ]);
            }




    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function show(Location $location)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function edit(Location $location)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'location' => 'required',

            ]);
        $location = Location::find($id);

        if($location){


                if($location->location != $request->location){
                    $this->validate($request,[
                    'location' => 'string|min:3|unique:locations',

                    ]);
            $location->location = $request->location;

                }

                if( $location->state_id != $request->state_id){
                    $this->validate($request,[
                        'state_id' => 'numeric',
                    ]);

                    $location->state_id = $request->state_id;

                }

                    if($location->save()){
                        return response()->json('Successful', 200);
                    }
                    else{
                        throw ValidationException::withMessages([
                            'Error' => ['An error Occured while trying to update location']
                        ]);
                    }

            }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Location::destroy($id);
        return response()->json("Successfully Deleted", 200);
    }
}
