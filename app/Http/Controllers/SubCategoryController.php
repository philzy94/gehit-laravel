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

                if( $subCategory->category_id != $request->category){
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
