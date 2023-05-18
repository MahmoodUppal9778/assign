<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function brand(){
     	 return $this->belongsTo(Brand::class, 'brand_id','id');
    }

    public function model(){
     	 return $this->belongsTo(Modelsection::class, 'model_id','id');
    }

}
