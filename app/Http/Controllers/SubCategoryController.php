<?php

namespace App\Http\Controllers;

use App\Models\SubCategory;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{

    public function store(Request $request)
    {
        $this->validate($request,[
            'sub_category' => 'required|string|min:3|unique:sub_categories',
            'category' => 'required|numeric',

        ]);

            $subCategory = new SubCategory;
            $subCategory->sub_category = $request->sub_category;
            $subCategory->category_id = $request->category;


            if($subCategory->save()){
                return response()->json('Successful', 200);
            }
            else{
                throw ValidationException::withMessages([
                    'Error' => ['An error Occur']
                ]);
            }




    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
        
  
        $SubCategory = SubCategory::where('category_id', $id)->orderBy('sub_category')->get();
        if($SubCategory)
        {
            return response()->json($SubCategory, 200);
            //return response()->json(Profile::find(auth('api')->user()->profile->id), 200);
        }
        else{
            throw ValidationException::withMessages([
                'Error' => ['An error Occured while trying to get SubCategory or SubCategory does not exist']
            ]);
        
        }
    }
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'sub_category' => 'required',


            ]);
        $subCategory = SubCategory::find($id);

        if($subCategory){


                if($subCategory->sub_category != $request->sub_category){
                    $this->validate($request,[
                    'sub_category' => 'string|min:3|unique:sub_categories',

                    ]);

                    $subCategory->sub_category = $request->sub_category;
                }

                if( $subCategory->category_id != $request->category && $request->state_id != ""){
                    $this->validate($request,[
                        'category' => 'numeric|required',
                    ]);

                    $subCategory->category_id = $request->category;

                }

                    if($subCategory->save()){
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
     * @param  \App\Models\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        SubCategory::destroy($id);
        return response()->json("Successfully Deleted", 200);
    }
}
