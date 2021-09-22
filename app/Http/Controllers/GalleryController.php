<?php

namespace App\Http\Controllers;
use Illuminate\Validation\ValidationException;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class GalleryController extends Controller
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

            'photos' => 'required|mimes:png,jpg,jpeg|max:2000',
        ]);

        if($request->hasFile('photos')){

            $user = auth('api')->user();
             $filename = $user->id.date('dmyHis').'.png';
             $request->photos->storeAs('images/gallery', $filename, 'public');

             $gallery = new Gallery;
             $gallery->organization_detail_id = $user->profile->organizationDetail[0]->id; // company or business id. Note that the organization_detail_id varies, so ensure that it is edited to be dynamic when the feature of allowing artisan to add multiple business is allowed.
             $gallery->photos = asset('/storage/images/gallery/'. $filename);
             $gallery->user_id = auth('api')->user()->id;

             if($gallery->save()){
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
     * Display the specified resource.
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function show($id) // expecting an organization_detail_id which is a foreign key in the gallery table
    {
        return response()->json(Gallery::where('organization_detail_id', $id)->get(), 200);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */


    public function update(Request $request,  $id)
    {


        $this->validate($request,[
            'photos' => 'required|mimes:png,jpg,jpeg|max:2000',
        ]);


        $galleryUpdate = Gallery::find($id);

            //return $galleryUpdate;
        if($galleryUpdate){
            if($galleryUpdate->user_id == auth('api')->user()->id){

                if($request->hasFile('photos')){

                    $photos = implode("/", array_slice(explode("/",$galleryUpdate->photos), 3));  // Value is not URL but directory old file path

                        if(File::exists($photos)) {
                            File::delete($photos);
                        }

                        $user = auth('api')->user();
                        $filename = $user->id.date('dmyHis').'.png';
                        $request->photos->storeAs('images/gallery', $filename, 'public');
                        $galleryUpdate->photos = asset('/storage/images/gallery/'. $filename);

                    }

            }
            else{
                throw ValidationException::withMessages([
                    'error' => ['You are not allow to update this  image']
                ]);
             }
            }
            $galleryUpdate->save();
            return response()->json("Successful", 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
        {       $galleryDelete = Gallery::find($id);
                $photos = implode("/", array_slice(explode("/",$galleryDelete->photos), 3));  // Value is not URL but directory old file path

            if($galleryDelete->user_id == auth('api')->user()->id){

                if(File::exists($photos)) {
                File::delete($photos);
                }
                Gallery::destroy($id);
                return response()->json("Successfully Deleted", 200);
                }
                else{
                    throw ValidationException::withMessages([
                        'error' => ['You are not allow to update this  image']
                    ]);
                 }

    }
}
