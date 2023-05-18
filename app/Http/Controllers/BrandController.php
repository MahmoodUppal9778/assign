<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Item;
use App\Models\Modelsection;
use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\UpdateBrandRequest;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $brandData = Brand::latest()->get();// get all brand data
        return view('assignment1.view_all_brand', compact('brandData')); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function BrandStore(Request $request)
    {
        //
        $validateInput = Validator::make($request->all(),[
            'brandname' => 'required|max:100|regex:/^[a-zA-Z\s]*$/',
        ],

        [
        'brandname.required' => 'Brand Name is required',
        'brandname.max' => 'Brand Name is off maximum length of 100 characters',

        'brandname.regex' => 'You are Enter an Invalid Brand Name, Only alphabatical brand name is allowed',
    ]
    );

        if ($validateInput->fails())
        {     

         return redirect()->back()->withErrors($validateInput);

        }

        //validating our input to alphabets only

        $brand = new Brand; // for insertion of new brand: Creating a Brand Instance
        $brand->name = $request->brandname; // Assign value
        $brand->created_at = Carbon::now(); // Assign Current time

        if($brand->save())
        {
    
            return redirect()->route('brand.index');
        }

        else

        {
            return redirect()->back();
        }    

    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function BrandUpdate(Request $request, Brand $brand)
    {
        //
            $validateInput = Validator::make($request->all(),[
            'brandid' => 'required|exists:brands,id', //ensure id is not changed by inpect method    
            'databrandname' => 'required|max:100|regex:/^[a-zA-Z\s]*$/',
        ],

        [
            'databrandname.required' => 'Brand Name is required',
            'databrandname.max' => 'Brand Name is off maximum length of 100 characters',

            'databrandname.regex' => 'You are Enter an Invalid Brand Name, Only alphabatical brand name is allowed',
        ]
);

        if ($validateInput->fails())
        {     

         return redirect()->back()->withErrors($validateInput);

        }
            

        //validating our input to alphabets only
        $editBrand = Brand::findOrFail($request->brandid); // for update of existing brand: calling a already created Brand Instance
        $editBrand->name = $request->databrandname; // Assign value
        $editBrand->updated_at = Carbon::now(); // Assign Current time

        if($editBrand->save())
        {
            return redirect()->route('brand.index');
        }

        else

        {
            return redirect()->back();
        }    


    }

    /**
     * Remove the specified resource from storage.
     */
    public function BrandDelete($id)
    {
        //find and softdelete that id
        $idPreserve = $id;
        Brand::findOrFail($idPreserve)->delete();
//        $brand->delete();
        //Asspciated models
        Modelsection::where('brand_id',$idPreserve)->delete();
        Item::where('brand_id', $idPreserve)->delete();
//      dd($model);
        return redirect()->route('brand.index');
    }
}
