<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Models\Item;
use App\Models\Modelsection;
use App\Models\Brand;
use Illuminate\Http\Request;
use Carbon\Carbon;
use PDF;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $itemData = Item::latest()->get();// get all brand data
        return view('assignment1.view_all_item', compact('itemData')); 

    }


 // Fetch records
   public function getParticularModel($id){
//     dd($id);   
     $modelData['data'] = ModelSection::select('id','name')->where('brand_id',$id)
                    ->get();
//        dd($modelData);
        return response()->json($modelData);

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
    public function ItemStore(Request $request)
    {
        //

        $validateInput = Validator::make($request->all(),[
            'itemname' => 'required|max:100|regex:/^[a-zA-Z0-9\s]*$/',
            'amount' => 'required|integer|digits_between:2,6',
            'brandid' => 'required|exists:brands,id',
            'modelAdd' => 'nullable|exists:modelsections,id',
 
        ],

        [
        'itemname.required' => 'Item Name is required',
        'itemname.max' => 'Item Name is off maximum length of 100 characters',

        'itemname.regex' => 'You are Enter an Invalid Item Name',
        'amount.required' => 'Amount is required',
        'amount.integer' => 'You are Enter an Invalid Amount, Only Numeric value is allowed',
        'amount.digits_between' => 'Please Enter digits between 2 to 6',
       'brandid.required' => 'Please select Brand for Item',
       'brandid.exists' => 'Brand is Invalid, Please refresh the page and select the brand carefully',
       'modelAdd.exists' => 'Model is Invalid, Please refresh the page and select the Model carefully',

        
    ]
    );

        if ($validateInput->fails())
        {     

         return redirect()->back()->withErrors($validateInput);

        }

        if(empty($request->modelAdd))
        {
            $itemAdd = new Item;
            $itemAdd->name = $request->itemname;
            $itemAdd->amount = $request->amount;
            $itemAdd->brand_id = $request->brandid;
            $itemAdd->model_id = $request->modelAdd;
            $itemAdd->added_on = Carbon::now()->toDateString();
            $itemAdd->created_at = Carbon::now();
            if($itemAdd->save())
            {

                $brandUpdate = Brand::findOrFail($request->brandid);
                $brandUpdate->items_count = $brandUpdate->items_count + 1;
                $brandUpdate->updated_at = Carbon::now();
                $brandUpdate->save();  

            }

        }
        else
        {
//            dd($request->all());
 

            //Create Item Instance
            $itemAdd = new Item;
            $itemAdd->name = $request->itemname;
            $itemAdd->amount = $request->amount;
            $itemAdd->brand_id = $request->brandid;
            $itemAdd->model_id = $request->modelAdd;
            $itemAdd->added_on = Carbon::now()->toDateString();
            $itemAdd->created_at = Carbon::now();
            if($itemAdd->save())
            {
                $modelSectionUpdate = ModelSection::findOrFail($request->modelAdd);
                $modelSectionUpdate->items_count = $modelSectionUpdate->items_count + 1;
                $modelSectionUpdate->updated_at = Carbon::now();
                $modelSectionUpdate->save();

                $brandUpdate = Brand::findOrFail($request->brandid);
                $brandUpdate->items_count = $brandUpdate->items_count + 1;
                $brandUpdate->updated_at = Carbon::now();
                $brandUpdate->save();  

            }



        }

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Item $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function ItemUpdate(Request $request)
    {
        //

        $validateInput = Validator::make($request->all(),[
        'edititemid' => 'required|exists:items,id',    
        'edititemname' => 'required|max:100|regex:/^[a-zA-Z0-9\s]*$/',
        'editamount' => 'required|integer|digits_between:2,6',
        'editbrandid' => 'required|exists:brands,id',
        'editmodelAdd' => 'nullable|exists:modelsections,id',
 
        ],

        [
            'edititemid.required' => 'Something went wrong',
            'edititemid.exists' => 'Dont change data by inspection method',
            'edititemname.required' => 'Item Name is required',
            'edititemname.max' => 'Item Name is off maximum length of 100 characters',

            'edititemname.regex' => 'You are Enter an Invalid Item Name',
            'editamount.required' => 'Amount is required',
            'editamount.integer' => 'You are Enter an Invalid Amount, Only Numeric value is allowed',
            'editamount.digits_between' => 'Please Enter digits between 2 to 6',
            'editbrandid.required' => 'Please select Brand for Item',
            'editbrandid.exists' => 'Brand is Invalid, Please refresh the page and select the brand carefully',
            'editmodelAdd.exists' => 'Model is Invalid, Please refresh the page and select the Model carefully',

        
    ]
    );

        if ($validateInput->fails())
        {     

         return redirect()->back()->withErrors($validateInput);

        }

//        dd($request->all());
        $oldItemRecord = Item::findOrFail($request->edititemid);
        $oldModelIdPerserve = $oldItemRecord->model_id;
        $oldBrandIdPerserve = $oldItemRecord->brand_id;

//rename only name and amount
        if($oldItemRecord->brand_id == $request->editbrandid && $oldItemRecord->model_id == $request->editmodelAdd)
        {
                $oldItemRecord->name = $request->edititemname;
                $oldItemRecord->amount = $request->editamount;
                $oldItemRecord->updated_at = Carbon::now();
    //        dd($request->all());

                $oldItemRecord->save();

        }

        else{
//Only model is changed brand is same

                     if($oldBrandIdPerserve == $request->editbrandid)
                    {       
                        $oldItemRecord->name = $request->edititemname;
                        $oldItemRecord->amount = $request->editamount;
                        $oldItemRecord->model_id = $request->editmodelAdd;
                        $oldItemRecord->updated_at = Carbon::now();
                    //for updating items count in model
                        if($oldItemRecord->save()){
                            $oldModelRecord = ModelSection::findOrFail($oldModelIdPerserve);
                            $oldModelRecord->items_count = $oldModelRecord->items_count - 1;
                            $oldModelRecord->updated_at = Carbon::now();
                            $oldModelRecord->save();

                            $updatedModelRecord = ModelSection::findOrFail($request->editmodelAdd);
                            $updatedModelRecord->items_count = $updatedModelRecord->items_count + 1;
                            $updatedModelRecord->updated_at = Carbon::now();                            
                            $updatedModelRecord->save();

                        }


                     }   
                     else if($oldBrandIdPerserve != $request->editbrandid){
                        //for non empty model 
//                        dd($request->all());
                        if(!empty($request->editmodelAdd)){
//                        dd("Not");
                                $oldItemRecord->name = $request->edititemname;
                                $oldItemRecord->amount = $request->editamount;
                                $oldItemRecord->brand_id = $request->editbrandid;
                                $oldItemRecord->model_id = $request->editmodelAdd;
                                $oldItemRecord->updated_at = Carbon::now();
                            //for updating items count in model


                                $oldItemRecord->save();
//                        dd($oldModelIdPerserve);

                                    $oldModelRecord = ModelSection::findOrFail($oldModelIdPerserve);
                                    $oldModelRecord->items_count = $oldModelRecord->items_count - 1;
                                    $oldModelRecord->updated_at = Carbon::now();                                    
                                    $oldModelRecord->save();

                                    $updatedModelRecord = ModelSection::findOrFail($request->editmodelAdd);
                                    $updatedModelRecord->items_count = $updatedModelRecord->items_count + 1;
                                    $updatedModelRecord->updated_at = Carbon::now();
                                    $updatedModelRecord->save();

                            //for updating items count in brand
                                    $oldBrandRecord = Brand::findOrFail($oldBrandIdPerserve);
                                    $oldBrandRecord->items_count = $oldBrandRecord->items_count - 1;
                                    $oldBrandRecord->updated_at = Carbon::now();                                    
                                    $oldBrandRecord->save();

                                    $updatedBrandRecord = Brand::findOrFail($request->editbrandid);
                                    $updatedBrandRecord->items_count = $updatedBrandRecord->items_count + 1;
                                    $oldBrandRecord->updated_at = Carbon::now();                                    
                                    $updatedBrandRecord->save();
                                 }
                 //for empty model but with new brand
                            else{

                                     $oldItemRecord->name = $request->edititemname;
                                    $oldItemRecord->amount = $request->editamount;
                                    $oldItemRecord->brand_id = $request->editbrandid;
                                    $oldItemRecord->model_id = Null;
                                    $oldItemRecord->updated_at = Carbon::now();
                                    $oldItemRecord->save();
                                

//                                dd('YES');
 
//decrement the previous model item count
                                   if(!empty($oldModelIdPerserve))     
                                    { 
                                        $oldModelRecord = ModelSection::findOrFail($oldModelIdPerserve);
                                        $oldModelRecord->items_count = $oldModelRecord->items_count - 1;
                                        $oldModelRecord->updated_at = Carbon::now();                                    
                                        $oldModelRecord->save();
                                    }                                    
//                                dd('YES');

                                    $oldBrandRecord = Brand::findOrFail($oldBrandIdPerserve);
                                    $oldBrandRecord->items_count = $oldBrandRecord->items_count - 1;
                                    $oldBrandRecord->updated_at = Carbon::now();                                    
                                    $oldBrandRecord->save();
                                    $updatedBrandRecord = Brand::findOrFail($request->editbrandid);
                                    $updatedBrandRecord->items_count = $updatedBrandRecord->items_count + 1;
                                    $oldBrandRecord->updated_at = Carbon::now();                                    
                                    $updatedBrandRecord->save();

                                

                            }          

                        }




                     }

    return redirect()->back();
    }

//Generatepdf 
   public function createPDF() {
      // retreive all records from db
      $data = Item::all();
      // share data to view
      view()->share('item',$data);
      $pdf = PDF::loadView('assignment1.pdf_view', compact('data'));
      // download PDF file with download method
      return $pdf->download('pdf_file.pdf');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function ItemDelete($id)
    {
        //
        $itemFetch = Item::findOrFail($id);
//Decrement item count from Brand        
        $brandFetch = Brand::findOrFail($itemFetch->brand_id);
        $brandFetch->items_count = $brandFetch->items_count - 1;
        $brandFetch->updated_at = Carbon::now();

//Decrement Item Count from Models        
        $modelFetch = ModelSection::findOrFail($itemFetch->model_id);
        $modelFetch->items_count = $modelFetch->items_count - 1;
        $modelFetch->updated_at = Carbon::now();

        $itemFetch->delete();
        $brandFetch->save();
        $modelFetch->save(); 
       return redirect()->back(); 

    }
       
}
