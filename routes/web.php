<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ModelSectionController;
use App\Http\Controllers\ItemController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');

});

//Routes for Brand Section

Route::controller(BrandController::class)->group(function(){

   Route::get('/all/brand', 'index')->name('brand.index');
   Route::post('/brand/store', 'BrandStore')->name('brand.store');
   Route::post('/brand/update', 'BrandUpdate')->name('brand.update');

   Route::get('/delete/brand/{id}', 'BrandDelete')->name('delete.brand');

});


//Routes for Model Section

Route::controller(ModelSectionController::class)->group(function(){

   Route::get('/all/modelsection', 'index')->name('modelsection.index');
   Route::post('/modelsection/store', 'ModelSectionStore')->name('modelsection.store');
   Route::post('/modelsection/update', 'ModelSectionUpdate')->name('modelsection.update');

   Route::get('/delete/modelsection/{id}', 'ModelSectionDelete')->name('delete.modelsection');

});


Route::controller(ItemController::class)->group(function(){

   Route::get('/all/item', 'index')->name('item.index');

   Route::get('/particularmodel/item/{id}', 'getParticularModel')->name('item.getParticularModel');
   Route::get('/item/pdf', 'createPDF')->name('item.create.pdf');

   Route::post('/item/store', 'ItemStore')->name('item.store');
   Route::post('/item/update', 'ItemUpdate')->name('item.update');

   Route::get('/delete/item/{id}', 'ItemDelete')->name('item.delete');

});
