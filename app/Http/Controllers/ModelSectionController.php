<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Models\Modelsection;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Item;
use Carbon\Carbon;

class ModelSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $modelData = ModelSection::latest()->get();// get all brand data
        return view('assignment1.view_all_model', compact('modelData')); 

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
    public function ModelSectionStore(Request $request)
    {
//        dd($request->all());
        //
        $validateInput = Validator::make($request->all(),[

        'modelname' => 'required|max:100|regex:/^[a-zA-Z\s]*$/',
        'brandid' => 'required|exists:brands,id',
        ],

        [
        'modelname.required' => 'Model Name is required',
        'modelname.max' => 'Model Name is off maximum length of 100 characters',

        'modelname.regex' => 'You are Enter an Invalid Model Name, Only alphabatical Model name is allowed',
        'brandid.required' => 'Brand Name is required',
        'brandid.exists' => 'Brand is Invalid, Please refresh the page and select the brand carefully',


    ]
    );

        if ($validateInput->fails())
        {     

         return redirect()->back()->withErrors($validateInput);

        }


        //validating our input to alphabets only
 
        $modelNew = new ModelSection; // for insertion of new Model: Creating a Model Instance
        $modelNew->name = $request->modelname;
        $modelNew->brand_id = $request->brandid;
         // Assign values
        $modelNew->created_at = Carbon::now(); // Assign Current time

        if($modelNew->save())
        {
            //Update count of Model in brands Table
            $brand = Brand::findOrFail($request->brandid);
            $oldModelCount = $brand->model_count;
            $brand->model_count = $oldModelCount + 1;
            $brand->save();
            
            return redirect()->route('modelsection.index');
        }

        else

        {
            return redirect()->back();
        }    

    }

    /**
     * Display the specified resource.
     */
    public function show(ModelSection $modelSection)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ModelSection $modelSection)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function ModelSectionUpdate(Request $request)
    {
        //
        $validateInput = Validator::make($request->all(),[
        'modelid' => 'required|max:100|exists:modelsections,id',    
        'datamodelname' => 'required|max:100|regex:/^[a-zA-Z\s]*$/',
        'brandid' => 'required|exists:brands,id',
        ],

        [
        'modelid.exists' => 'Your info is invalid',    
        'datamodelname.required' => 'Model Name is required',
        'datamodelname.max' => 'Model Name is off maximum length of 100 characters',

        'datamodelname.regex' => 'You are Enter an Invalid Model Name, Only alphabatical Model name is allowed',
        'brandid.required' => 'Brand Name is required',
        'brandid.exists' => 'Brand is Invalid, Please refresh the page and select the brand carefully',


    ]
    );

        if ($validateInput->fails())
        {     
         return redirect()->back()->withErrors($validateInput);

        }


        //validating our input to alphabets only
 
        $modelUpdate = ModelSection::findOrFail($request->modelid); // for updation of existing Model:Assigning a Model Instance

//Preserve it for count of model
        $modelPreserveBrandId = $modelUpdate->brand_id;
//        dd($request->brandid);
        $modelUpdate->name = $request->datamodelname;
        $modelUpdate->brand_id = $request->brandid;
         // Assign values
        $modelUpdate->updated_at = Carbon::now(); // Assign Current time

        if($modelUpdate->save())
        {

            if($modelPreserveBrandId == $request->brandid)
            {
  //              dd($modelPreserveBrandId);
            }
            else
            {     
                //Update count of Model in brands Table
                $brandOld = Brand::findOrFail($modelPreserveBrandId);
                $oldModelCount = $brandOld->model_count;
                $brandOld->model_count = $oldModelCount - 1;
//                dd($brandOld);
                $brandOld->save();

                $brandNew = Brand::findOrFail($request->brandid);
                $oldModelCount = $brandNew->model_count;
                $brandNew->model_count = $oldModelCount + 1;
                $brandNew->save();


             }   
            return redirect()->route('modelsection.index');
        }

        else

        {
            return redirect()->back();
        }    


    }

    /**
     * Remove the specified resource from storage.
     */
    public function ModelSectionDelete($id)
    {
        //
        $modelDelete = ModelSection::findOrFail($id);
        $getBrandId = $modelDelete->brand_id;
        //First Decrement the count of model from brand table then delete it
        $brandModelDelete = Brand::findOrFail($modelDelete->brand_id);
        $brandModelDelete->model_count = $brandModelDelete->model_count - 1;

//Fetch item associated with that brand to delete
        $itemDelete = Item::where('model_id',$id);

//Demote the item count from brands item count  
        $brandAssociated = Brand::findOrFail($getBrandId);
        $brandAssociated->items_count = $brandAssociated->items_count - 1;
        $brandAssociated->updated_at = Carbon::now();
        $brandAssociated->save();

        if($brandModelDelete->save())
        {
            $modelDelete->delete();
            $itemDelete->delete();
        }
            return redirect()->back();

    }
}
