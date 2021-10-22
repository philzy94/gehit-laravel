<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return  Category::with('SubCategory')->get();
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
            'skill_category' => 'required|string|min:3|unique:categories'
        ]);

            $category = new Category;
            $category->skill_category = $request->skill_category;


            if($category->save()){
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
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'skill_category' => 'required|string|min:3',

        ]);
        $category = Category::find($id);

        if($category){


                if($category->skill_category != $request->skill_category){
                    $this->validate($request,[
                        'skill_category' => 'string|min:3|unique:categories',

                    ]);
                    $category->skill_category = $request->skill_category;

                }

                if($category->save()){
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
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        Category::destroy($id);

        /* try {
            if(Category::destroy($id)){
                return response()->json("Successfully Deleted", 200);
                }

                else{
                    throw ValidationException::withMessages([
                        'Error' => ['An error Occur']
                    ]);
                }

        } catch (\Exception  $e) {
            return $e->getMessage();


        } */
    }
}
