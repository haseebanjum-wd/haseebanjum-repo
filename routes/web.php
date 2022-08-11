<?php

use Illuminate\Support\Facades\Route;
use App\Models\Products;
use App\Models\User;
use App\Models\orders;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/getOrders', function(){
    $user = User::find(1);
    $user->products;
});


Route::get('/getOrders', function(){

    $order = orders::with('orderDetails.products')->get();
    
    
});