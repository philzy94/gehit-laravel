<?php

namespace App\Http\Controllers;

use App\Models\State;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;

class StateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return  State::with('Location')->get();
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
            'state' => 'required|string|min:3|unique:states'
        ]);

            $state = new State;
            $state->state = $request->state;


            if($state->save()){
                return response()->json('Successful', 200);
            }
            else{
                throw ValidationException::withMessages([
                    'Error' => ['An error Occur']
                ]);
            }



    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\State  $state
     * @return \Illuminate\Http\Response
     */
    public function show(State $state)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\State  $state
     * @return \Illuminate\Http\Response
     */
    public function edit(State $state)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\State  $state
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'state' => 'required|string|min:3',

        ]);
        $state = state::find($id);

        if($state){


                if($state->state != $request->state){
                    $this->validate($request,[
                        'state' => 'string|min:3|unique:states'

                    ]);
                    $state->state = $request->state;

                }

                if($state->save()){
                    return response()->json('Successful', 200);
                }
                else{
                    throw ValidationException::withMessages([
                        'Error' => ['An error Occur']
                    ]);
                }
            }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\State  $state
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            if(State::destroy($id)){
                return response()->json("Successfully Deleted", 200);
                }

                else{
                    throw ValidationException::withMessages([
                        'Error' => ['An error Occur']
                    ]);
                }

        } catch (\Exception  $e) {
            return $e->getMessage();


        }
    }
}
