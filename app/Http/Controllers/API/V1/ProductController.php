<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use Validator;

class ProductController extends Controller
{
    //
	public function index(){
		$products = Product::all();
		return response()->json(['status'=>1,'message'=>'All products', 'data'=>$products]);    	
	}

	public function show($id){
		$product = Product::find($id);
		if(!is_null($product)){
           return response()->json(['status'=>1,'message'=>'Products details', 'data'=>$product]);
		}else{
           return response()->json(['status'=>'fail','errors'=>'Product Not Found','code'=>1001],422);
		}
		
	}

	public function store(Request $request){

		$validator = Validator::make($request->all(), [
			'name' => 'required|max:255',
			'price' => 'required',
			'discount' => 'required',
			'sku' => 'required|unique:products|max:30',
		]);

		if($validator->fails()){
			$errors = "";
			foreach($validator->errors()->all() as $error){
				$errors.=" ".$error;
			}
			return response()->json(['status'=>'fail','errors'=>$validator->errors()->all(),'code'=>1],422);
		}

		$product = new Product();
		$product->name = $request->name;
		$product->price = $request->price;
		$product->discount = $request->discount;
		$product->sku = $request->sku;
		$product->description = $request->description;

		try{

			$product->save();
			return response()->json(['status'=>'success','message'=>'Products saved successfully','data'=>$product],200);

		}catch(\Exception $e){
			return response()->json(array('status'=>'fail','error'=>$e->getMessage(),'code'=>2),422);
		}

	}

	public function update(Request $request, $id){

		$validator = Validator::make($request->all(), [
			'name' => 'required|max:255',
			'price' => 'required',
			'discount' => 'required',
			'sku' => 'required|max:30',
		]);

		if($validator->fails()){
			$errors = "";
			foreach($validator->errors()->all() as $error){
				$errors.=" ".$error;
			}
			return response()->json(['status'=>'fail','errors'=>$validator->errors()->all(),'code'=>1],422);
		}

		$product = Product::find($id);
		$product->name = $request->name;
		$product->price = $request->price;
		$product->discount = $request->discount;
		$product->sku = $request->sku;
		$product->description = $request->description;

		try{

			$product->save();
			return response()->json(['status'=>'success','message'=>'Products updated successfully','data'=>$request->all()],200);

		}catch(\Exception $e){
			return response()->json(array('status'=>'fail','error'=>$e->getMessage(),'code'=>2),422);
		}

	}

	public function destroy(Request $request, $id){
		$product = Product::find($id);
		try{
			$product->delete();
			return response()->json(['status'=>'success','message'=>'Products delete successfully','data'=>$product],200);
		}catch(\Exception $e){
			return response()->json(array('status'=>'fail','error'=>$e->getMessage(),'code'=>2),422);
		}	

	}
}
