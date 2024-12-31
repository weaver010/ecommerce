<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Auth;

class OrderController extends Controller
{
    public function orders(){
        $orders = Order::with('orders_products')->where('user_id',Auth::user()->id)->orderBy('created_at','DESC')->get();
        $orders = json_decode(json_encode($orders));
        /*echo "<pre>"; print_r($orders); die;*/
        return view('front.orders.orders')->with(compact('orders'));
    }

    public function orderDetails($id){
        $orderDetails = Order::with('orders_products','user','log')->where('_id',$id)->first()->toArray();
        /*$orderDetails = json_decode(json_encode($orderDetails));*/
        //echo "<pre>"; print_r($orderDetails); die;
        return view('front.orders.order_details')->with(compact('orderDetails'));
    }

}
