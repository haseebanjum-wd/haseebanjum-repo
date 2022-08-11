<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Models\Products;
use App\Models\User;
use App\Models\orders;

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

Route::get('/getProduct/{feature}', function($feature){
    $products = '';
    if ($feature == 'true') {
        $products = Products::where([
            'feature'=> 1
        ])->get();
    }else {
        $products = Products::all();
    }
    return response()->json($products);
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


Route::post('/order', function(Request $req){
    $userData = $req['userData'];
    $orderProducts = [];
    $user = User::create([
        'name'=> $userData['fullname'],
        'email'=> $userData['email'],
    ]);

    $order = $user->orders()->create([
        'total_price'=> $req['totalPrice'],
        'status'=> 'Pending'
    ]);
    foreach ($req['cartProducts'] as $key => $value) {
        $orderProducts[] = [
            'product_id'=> $value['id'],
            'quantity'=> $value['quantity'],
            'price'=> $value['unitPrice'],
        ];
    }
    
    $order->orderDetails()->createMany($orderProducts); 
    
    return response()->json(['status'=> true], 200);
    
});

Route::get('/getOrders', function(){
    $order = orders::with('orderDetails.products')->get();
    return response()->json($order, 200);
});

Route::post('/orderStatuschange', function(Request $req){
    $orderUpdateStatus = orders::where('id', $req->orderId)
      ->update([
        'status' =>  $req->status ? 'Delivered' : 'Pending'
        ]
    );
      return response()->json($req->status, 200);
});

Route::post('/feature', function(Request $req){
    $featureStatus = $req->feature == true ? '1' : '0';
    $prodUpdate = Products::where('id', $req->productId)
        ->update([
        'feature'=> $featureStatus 
    ]);

    return response()->json($featureStatus);
});

