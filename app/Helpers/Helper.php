<?php
use App\Models\Cart;

function totalCartItems(){
	if(Auth::check()){
		$user_id = Auth::user()->id;
		$totalCartItems = Cart::where('user_id',$user_id)->sum('product_qty');
	}else{
		$session_id = Session::get('session_id');
		$totalCartItems = Cart::where('session_id',$session_id)->sum('product_qty');
	}
	return $totalCartItems;
}

function getCartItems(){
    if(Auth::check()){
        $getCartItems = Cart::with('product')->orderby('id','desc')->where('user_id',Auth::user()->id)->get()->toArray();  
    }else{
        $getCartItems = Cart::with('product')->orderby('id','desc')->where('session_id',Session::get('session_id'))->get()->toArray(); 
    }
    return $getCartItems;
} 