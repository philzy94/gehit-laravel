<?php

namespace App\Http\Controllers;

use App\Models\OrganizationDetail;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\File;



class OrganizationDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Category::with('OrganizationDetai')->get();
            return OrganizationDetail::all();

    }

    public function show()
    {
        return auth('api')->user()->profile->OrganizationDetail;

        if (auth('api')->user()){

            return auth('api')->user()->profile->OrganizationDetail;

            }


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
            'organization_name' => 'required|string|min:3|unique:organization_details',
            'about_organization' => 'required|string',
            'contact_address' => 'required|string',
            'logo' => 'required|mimes:png,jpg,jpeg|max:2000',
            'category' => 'required|numeric',
            'sub_category' => 'required|numeric',
            'state' => 'required|numeric',
            'location' => 'required|numeric',
        ]);

        if($request->hasFile('logo')){
           // $extension = $request->logo->getClientOriginalExtension();
           $user = auth('api')->user();
            $filename = $user->id.$user->profile->id.date('dmyHis').'.png';
            $request->logo->storeAs('images/organization_logo', $filename, 'public');
            //return asset('/storage/images/profile/'. $filename);

            $OrganizationDetail = new OrganizationDetail;
            $OrganizationDetail->organization_name = $request->organization_name;
            $OrganizationDetail->about_organization = $request->about_organization;
            $OrganizationDetail->contact_address = $request->contact_address;
            $OrganizationDetail->logo = asset('/storage/images/organization_logo/'. $filename);
            $OrganizationDetail->profile_id = $user->profile->id;
            $OrganizationDetail->category_id = $request->category;
            $OrganizationDetail->sub_category_id = $request->sub_category;
            $OrganizationDetail->state_id = $request->state;
            $OrganizationDetail->location_id = $request->location;

            if($OrganizationDetail->save()){
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {


        $this->validate($request,[
            'organization_name' => 'required|string|min:3',
            'about_organization' => 'required|string',
            'contact_address' => 'required|string',
            'category' => 'required|numeric',
            'sub_category' => 'required|numeric',
            'state' => 'required|numeric',
            'location' => 'required|numeric',
        ]);

        $organizationDetailUpdate = OrganizationDetail::find($id);

        if($organizationDetailUpdate){
                if($request->hasFile('logo')){
                    $this->validate($request,[
                        'logo' => 'mimes:png,jpg,jpeg|max:2000',
                    ]);

                    $logo = implode("/", array_slice(explode("/",$organizationDetailUpdate->photos), 3));  // Value is not URL but directory old file path

                    if(File::exists($logo)) {
                        File::delete($logo);
                    }

                    $user = auth('api')->user();
                    $filename = $user->id.$user->profile->id.date('dmyHis').'.png';
                    $request->logo->storeAs('images/organization_logo', $filename, 'public');
                    $organizationDetailUpdate->logo = asset('/storage/images/organization_logo/'. $filename);
                }

                if($organizationDetailUpdate->organization_name != $request->organization_name){
                    $this->validate($request,[
                        'organization_name' => 'unique:organization_details',

                    ]);
                    $organizationDetailUpdate->organization_name = $request->organization_name;
                }

                $organizationDetailUpdate->about_organization = $request->about_organization;
                $organizationDetailUpdate->contact_address = $request->contact_address;
                $organizationDetailUpdate->category_id = $request->category;
                $organizationDetailUpdate->sub_category_id = $request->sub_category;
                $organizationDetailUpdate->state_id = $request->state;
                $organizationDetailUpdate->location_id = $request->location;

                    $organizationDetailUpdate->save();
                    return response()->json("Successful", 200);
            }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Organization  $organization
     * @return \Illuminate\Http\Response
     */
    /* public function show($id)
    {

        return OrganizationDetail::where('profile_id', $id)->get();

        // return OrganizationDetail::where('profile_id', 42)->get();

        //OrganizationDetail::find($id);
        //auth('api')->user()->profile->OrganizationDetail;
    } */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function edit(OrganizationDetail $organization)
    {
        //
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrganizationDetail $organization)
    {
        //
    }
}
