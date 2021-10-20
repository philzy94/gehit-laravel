<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;


class ProfileController extends Controller
{


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'Full_name' => 'required|min:3',
            'Phone_number' => 'required|numeric|digits:11|unique:profiles',
            'Profile_photo' => 'required|mimes:png,jpg, jpeg|max:2000',
        ]);

        if($request->hasFile('Profile_photo')){
           // $extension = $request->Profile_photo->getClientOriginalExtension();
            $filename = auth('api')->user()->id.'.png';
            $request->Profile_photo->storeAs('images/profile', $filename, 'public');
            //return asset('/storage/images/profile/'. $filename);

            $profile = new Profile;
            $profile->Full_name = $request->Full_name;
            $profile->Phone_number = $request->Phone_number;
            $profile->Profile_photo = asset('/storage/images/profile/'. $filename);
            $profile->user_id = auth('api')->user()->id;

            $profile->save();
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        if(Profile::where('user_id', auth('api')->user()->id)->first())
        {

            return response()->json(auth('api')->user()->profile, 200);
            //return response()->json(Profile::find(auth('api')->user()->profile->id), 200);
        }
        else{
            return response()->json(null, 200);
        
        }

    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request,[
            'Full_name' => 'required|min:3',
            'Phone_number' => 'required|numeric|digits:11',

        ]);

            $profile = Profile::find(auth('api')->user()->profile->id);
            $profile->Full_name = $request->Full_name;
            if($request->Phone_number != $profile->Phone_number){
                $this->validate($request,[
                    'Phone_number' => 'required|numeric|digits:11|unique:profiles',

                ]);
                $profile->Phone_number = $request->Phone_number;
            }
            if($request->hasFile('Profile_photo')){

                $this->validate($request,[
                    'Profile_photo' => 'mimes:png,jpg, jpeg|max:2000',
                ]);
                $filename = auth('api')->user()->id.'.png';
                $request->Profile_photo->storeAs('images/profile', $filename, 'public');
                $profile->Profile_photo = asset('/storage/images/profile/'. $filename);
            }
            $profile->save();
            return response()->json("Successful", 200);
    }


}
