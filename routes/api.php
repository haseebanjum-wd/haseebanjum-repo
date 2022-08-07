<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Models\Products;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/getProduct', function(Request $req){
    return response()->json(Products::all());
});

Route::post('/addProduct', function (Request $req) {
    $prodStatus = Products::create([
        'product_title'=> $req->productTitle,
        'product_description'=> $req->productDescription,
        'product_price'=> $req->productPrice,
        'product_image'=> $req->productImage
    ]);
    return response()->json($prodStatus);
});

Route::post('/updateProduct', function (Request $req) {
    $prodUpdate = Products::where('id', $req->productId)
      ->update([
        'product_title'=> $req->productTitle,
        'product_description'=> $req->productDescription,
        'product_price'=> $req->productPrice,
        'product_image'=> $req->productImage
    ]);

    return response()->json($prodUpdate);
});

Route::get('/delProduct/{id}', function($id){
    $productDelStatus = Products::destroy($id);
    return response()->json($productDelStatus);
});

Route::post('/getUser', function(Request $req){
    $users = User::where([
        ['email','=', $req->email ],
        ['password','=', $req->password ]
    ])->first();
    if ($users) {
        return response()->json($users, 200);
    }   
    return response()->json(['status'=> false,'message'=> 'No User Found'], 404);
});

