<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductsAttribute;
use App\Models\ProductsFilter;
use App\Models\RecentlyViewedItem;
use App\Models\Brand;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\User;
use App\Models\DeliveryAddress;
use App\Models\Country;
use App\Models\Order;
use App\Models\OrdersProduct;
use App\Models\ShippingCharge;
use Session;
use DB;
use Auth;

class ProductController extends Controller
{
    public function listing(Request $request){
        $url = Route::getFacadeRoot()->current()->uri();
        $categoryCount = Category::where(['url'=>$url,'status'=>1])->count();
        if($categoryCount>0){
            /*echo "exists"; die;*/

            // Get Category Details
            $categoryDetails = Category::categoryDetails($url);

            // Get Products
            $categoryProducts = Product::with(['brand','images'])->whereIn('category_id',$categoryDetails['catIds'])->where('status',1);

             // Products Sorting Filter Results
            if(isset($request['sort']) && !empty($request['sort'])){
                if($request['sort']=="product_latest"){
                    $categoryProducts->orderby('created_at','desc');
                }else if($request['sort']=="lowest_price"){
                    $categoryProducts->orderby('final_price','asc');
                }else if($request['sort']=="highest_price"){
                    $categoryProducts->orderby('final_price','desc');
                }else if($request['sort']=="best_selling"){
                    $categoryProducts->where('is_bestseller','Yes');
                }else if($request['sort']=="featured_items"){
                    $categoryProducts->where('is_featured','Yes');
                }else if($request['sort']=="discounted_items"){
                    $categoryProducts->where('product_discount','>',0);
                }else{
                    $categoryProducts->orderby('created_at','desc');
                }
            }

            // Colors Filter
            if(isset($request['color']) && !empty($request['color'])){
                     $colors = explode('~',$request['color']);
                     $categoryProducts->wherein('family_color',$colors);
            }

            // Sizes Filter
            if(isset($request['size']) && !empty($request['size'])){
                $sizes = explode('~',$request['size']);
                $getProductIds = ProductsAttribute::select('product_id')->whereIn('size',$sizes)->pluck('product_id')->toArray();
                $categoryProducts->wherein('_id',$getProductIds); 
            }

            // Brands Filter
            if(isset($request['brand']) && !empty($request['brand'])){
                $brands = explode('~',$request['brand']);
                $getBrandIds = Brand::select('_id')->whereIn('brand_name',$brands)->pluck('_id')->toArray();
                $categoryProducts->whereIn('brand_id',$getBrandIds);
            }

            // Price Filter
            if(isset($request['price']) && !empty($request['price'])){
                $request['price'] = str_replace("~","-",$request['price']);
                $prices = explode('-',$request['price']);
                $count = count($prices); 
                //var_dump($prices[0]);
                $categoryProducts->whereBetween('final_price', [(int)$prices[0], (int)$prices[$count-1]]);
            }

            // Dynamic Filters
            $filterTypes = ProductsFilter::filterTypes();
            foreach($filterTypes as $filter){
                if($request->$filter){
                    $explodeFilterVals = explode('~', $request->$filter);
                    $categoryProducts = $categoryProducts->whereIn(strtolower($filter),$explodeFilterVals);
                }
            }

            $categoryProducts = $categoryProducts->paginate(6);
            $categoryProducts = $categoryProducts->appends(request()->except('page'));
            //dd($categoryProducts);

            if($request->ajax()){
                return response()->json([
                    'view' => (String)View::make('front.products.ajax_products_listing')->with(compact('categoryDetails','categoryProducts','url'))
                ]);
            }else{
                return view('front.products.listing')->with(compact('categoryDetails','categoryProducts','url'));
            }

        }else if(isset($_REQUEST['product']) && !empty($_REQUEST['product'])){
                $search_product = $_REQUEST['product'];
                $categoryDetails['breadcrumbs'] = $search_product;
                $categoryDetails['catDetails']['category_name'] = $search_product;
                $categoryDetails['catDetails']['description'] = "Search Results for ".$search_product;

                $categoryProducts = Product::with('brand')->where(function($query)use($search_product){
                    $query->where('product_name','like','%'.$search_product.'%')
                    ->orWhere('product_code','like','%'.$search_product.'%')
                    ->orWhere('description','like','%'.$search_product.'%')
                    ->orWhere('product_color','like','%'.$search_product.'%');
                })->where('status',1);
                $categoryProducts = $categoryProducts->get();

                $page_name = "Search Resuls";
                return view('front.products.listing')->with(compact('categoryDetails','categoryProducts','page_name'));
            }else{
                abort(404);
        }
    }

    public function detail($id){
        $productCount = Product::where('status',1)->where('_id',$id)->count();
        if($productCount==0){
            abort(404);
        }
        $productDetails = Product::with('category','brand','attributes_front','images')->find($id)->toArray();
        /*dd($productDetails);*/
        // Get Category Details
        $categoryDetails = Category::categoryDetails($productDetails['category']['url']);

        // Get Group Products (Product Colors)
        $groupProducts = array();
        if(!empty($productDetails['group_code'])){
            $groupProducts = Product::select('id','family_color')->where('id','!=',$id)->where(['group_code'=>$productDetails['group_code'],'status'=>1])->get()->toArray();
            /*dd($groupProducts);*/
        }

        // Get Total Stock of the Product
        $total_stock = ProductsAttribute::where('product_id',$id)->sum('stock');

        // Get Related Products
        $relatedProducts = Product::with('brand','images')->where('category_id',$productDetails['category']['_id'])->where('_id','!=',$id)->limit(4)->get()->toArray();

        // Set Session for Recently Viewed Items
        if(empty(Session::get('session_id'))){
            $session_id = md5(uniqid(rand(), true));
        }else{
            $session_id = Session::get('session_id');
        }

        Session::put('session_id',$session_id);

        // Insert product in recently_viewed_items collection if not already exists
        $countRecentlyViewedItems = RecentlyViewedItem::where(['product_id'=>$id,'session_id'=>$session_id])->count();
        if($countRecentlyViewedItems==0){
            RecentlyViewedItem::insert(['product_id'=>$id,'session_id'=>$session_id]);
        }

        // Get Recently Viewed Products Ids
        $recentProductsIds = RecentlyViewedItem::select('product_id')->where('product_id','!=',$id)->where('session_id',$session_id)->get()->take(4)->pluck('product_id');
        /*dd($recentProductsIds);*/

        // Get Recently Viewed Products
        $recentlyViewedProducts = Product::with('brand','images')->whereIn('_id',$recentProductsIds)->get()->toArray();
        /*dd($recentlyViewedProducts);*/

        return view('front.products.detail')->with(compact('productDetails','categoryDetails','groupProducts','total_stock','relatedProducts','relatedProducts','recentlyViewedProducts'));
    }

    public function getAttributePrice(Request $request){
        if($request->ajax()){
            $data = $request->all();
            /*echo "<pre>"; print_r($data); die;*/
            $getAttributePrice = Product::getAttributePrice($data['product_id'],$data['size']);
            /*echo "<pre>"; print_r($getAttributePrice); die;*/
            return $getAttributePrice;
        }
    }

    public function addToCart(Request $request){
        if($request->isMethod('post')){
            $data =  $request->all();
            /*echo "<pre>"; print_r($data); die;*/

             // Forget the coupon sessions
            Session::forget('couponAmount');
            Session::forget('couponCode');
            
            //Check Product Stock
            $productStock = ProductsAttribute::productStock($data['product_id'],$data['size']);   
            if($data['qty'] > $productStock){
                $message = "Required Quantity is not available!";
                return response()->json(['status'=>false,'message'=>$message]);
            }

            //Check Product Status
            $productStatus = Product::productStatus($data['product_id']); 
            if($productStatus == 0){
                $message = "Product is not available!";
                return response()->json(['status'=>false,'message'=>$message]);
            }

            // Generate Session Id if not exists
            $session_id = Session::get('session_id');
            if(empty($session_id)){
                $session_id = Session::getId();
                Session::put('session_id',$session_id);
            }

            // Check Product if already exists in the User Cart
            if(Auth::check()){
                // User is logged in
                $user_id = Auth::user()->id;
                $countProducts = Cart::where(['product_id'=>$data['product_id'],'product_size'=>$data['size'],'user_id'=>$user_id])->count();
            }else{
                // User is not logged in
                $user_id = 0;
                $countProducts = Cart::where(['product_id'=>$data['product_id'],'product_size'=>$data['size'],'session_id'=>$session_id])->count();
            }

            if($countProducts>0){
                $message = "Product already exists in Cart!";
                return response()->json(['status'=>false,'message'=>$message]);
            }

            // Save Product in carts table
            $item = new Cart;
            $item->session_id = $session_id;
            if(Auth::check()){
                $item->user_id = Auth::user()->id;
            }
            $item->product_id = $data['product_id'];
            $item->product_size = $data['size'];
            $item->product_qty = (int)$data['qty'];
            $item->save();
            $totalCartItems = totalCartItems();
            $getCartItems = getCartItems();
            $message = 'Product added successfully in Cart! <a style="text-decoration:underline !important;" href="/cart">View Cart</a>';
            return response()->json(['status'=>true,'message'=>$message,'product_id'=>$data['product_id'],'totalCartItems'=>$totalCartItems,
                'minicartview'=>(String)View::make('front.products.mini_cart')->with(compact('getCartItems'))
            ]);
        }
    }

    public function cart(){
        $getCartItems = getCartItems();
        /*echo "<pre>"; print_r($getCartItems); die;*/
        return view('front.products.cart')->with(compact('getCartItems'));
    }

    public function updateCartItemQty(Request $request){
        if($request->ajax()){
            $data = $request->all();
            /*echo "<pre>"; print_r($data); die;*/

             // Forget the coupon sessions
            Session::forget('couponAmount');
            Session::forget('couponCode');

            // Get Cart Details
            $cartDetails = Cart::find($data['cartid']);

            // Get Available Product Stock
            $availableStock = ProductsAttribute::select('stock')->where(['product_id'=>$cartDetails['product_id'],'size'=>$cartDetails['product_size']])->first()->toArray();
            /*echo "<pre>"; print_r($availableStock); die;*/

            // Check if desired Stock from user is available
            if($data['qty']>$availableStock['stock']){
                $getCartItems = getCartItems();
                return response()->json([
                    'status'=>false,
                    'message'=>'Product Stock is not available',
                    'view'=>(String)View::make('front.products.cart_items')->with(compact('getCartItems'))
                ]);    
            }

            // Check if product size is available
            $availableSize = ProductsAttribute::where(['product_id'=>$cartDetails['product_id'],'size'=>$cartDetails['product_size'],'status'=>1])->count();
            if($availableSize==0){
                $getCartItems = getCartItems();
                return response()->json([
                    'status'=>false,
                    'message'=>'Product Size is not available. Please remove this Product and choose another one!',
                    'view'=>(String)View::make('front.products.cart_items')->with(compact('getCartItems'))
                ]);    
            }

            // Update the Qty
            Cart::where('_id',$data['cartid'])->update(['product_qty'=>(int)$data['qty']]);

            // Get Updated Cart Items
            $getCartItems = getCartItems();
            $totalCartItems = totalCartItems();

            // Return the Updated Cart Item via Ajax
            return response()->json([
                'status'=>true,
                'totalCartItems'=>$totalCartItems,
                'view'=>(String)View::make('front.products.cart_items')->with(compact('getCartItems')),
                'minicartview'=>(String)View::make('front.products.mini_cart')->with(compact('getCartItems'))
            ]);
        }
    }

    public function deleteCartItem(Request $request){
        if($request->ajax()){
            $data = $request->all();

             // Forget the coupon sessions
            Session::forget('couponAmount');
            Session::forget('couponCode');
            
            Cart::where('_id',$data['cartid'])->delete();
            $getCartItems = getCartItems();
            $totalCartItems = totalCartItems();
            return response()->json([
                'totalCartItems'=>$totalCartItems,
                'view' => (String)View::make('front.products.cart_items')->with(compact('getCartItems')),
                'minicartview'=>(String)View::make('front.products.mini_cart')->with(compact('getCartItems'))
            ]);
        }
    }

    public function emptyCart(Request $request){
        if($request->ajax()){
            $data = $request->all();
            if(Auth::check()){
                // If the user is logged in, check from Auth (user_id)
                $user_id = Auth::user()->id;
                Cart::where('user_id',$user_id)->delete();
            }else{
                // If the user is not logged in, check from Session (session_id)
                $session_id = Session::get('session_id');
                Cart::where('session_id',$session_id)->delete();
            }
            $getCartItems = getCartItems();
            $totalCartItems = totalCartItems();
            return response()->json([
                'totalCartItems'=>$totalCartItems,
                'view' => (String)View::make('front.products.cart_items')->with(compact('getCartItems')),
                'minicartview'=>(String)View::make('front.products.mini_cart')->with(compact('getCartItems'))
            ]);
        }
    }

    public function applyCoupon(Request $request){
        if($request->ajax()){
            $data = $request->all();
            Session::forget('couponAmount');
            Session::forget('couponCode');
            /*echo "<pre>"; print_r($data); die;*/

            // Get Updated Cart Items
            $getCartItems = getCartItems();

            // Get Total Cart Items
            $totalCartItems = totalCartItems();

            $couponCount = Coupon::where('coupon_code',$data['code'])->count();
            if($couponCount==0){
                return response()->json([
                'status'=>false,
                'totalCartItems'=>$totalCartItems,
                'message'=>'The coupon is not valid!',
                'view'=>(String)View::make('front.products.cart_items')->with(compact('getCartItems')),
                'minicartview'=>(String)View::make('front.products.mini_cart')->with(compact('getCartItems'))
                ]);
            }else{
                // Check for other coupon conditions

                // Get Coupon Details
                $couponDetails = Coupon::where('coupon_code',$data['code'])->first();

                // if coupon is inactive
                if($couponDetails->status==0){
                    $error_message = "The coupon is not active!";
                }

                // if coupon is expired
                $expiry_date = $couponDetails->expiry_date;
                $current_date = date('Y-m-d');
                if($expiry_date<$current_date){
                    $error_message = "The coupon is expired!";
                }

                // Check if Coupon is for Single or Multiple Times
                if($couponDetails->coupon_type=="Single Times"){
                        // Check in Orders table if coupon already availed by the user 
                        $couponCount = Order::where(['coupon_code'=>$data['code'],'user_id'=>Auth::user()->id])->count();
                       if($couponCount>=1){
                             $message = 'This coupon code is already availed by you!';
                       }
                }

                // Get all selected categories from coupon
                $catArr = explode(",",$couponDetails->categories);

                // Get all selected brands from coupon
                $brandsArr = explode(",",$couponDetails->brands);

                // Get all selected users from coupon
                $usersArr = explode(",",$couponDetails->users);

                foreach ($usersArr as $key => $user) {
                    $getUserID = User::select('_id')->where('email',$user)->first()->toArray();
                    $usersID[] = $getUserID['_id'];
                }

                // Check if any cart item does not belong to coupon category, brand and user
                $total_amount = 0;
                foreach ($getCartItems as $key => $item) {

                    // Check if any cart item does not belong to coupon category
                    if(!in_array($item['product']['category_id'],$catArr)){
                        $error_message = "The coupon code is not for one of the selected products.";
                    }

                    // Check if any cart item does not belong to coupon brand
                    if(!in_array($item['product']['brand_id'],$brandsArr)){
                        $error_message = "The coupon code is not for one of the selected products.";
                    }

                    // Check if any cart item does not belong to coupon user
                    if(count($usersArr)>0){
                        if(!in_array($item['user_id'],$usersID)){
                            $error_message = "The coupon code is not for you. Try again with valid coupon code!";
                        }    
                    }

                    $getAttributePrice = Product::getAttributePrice($item['product_id'],$item['product_size']);

                    $total_amount = $total_amount + ($getAttributePrice['final_price'] * $item['product_qty']);
                }

                // if error message is there
                if(isset($error_message)){
                    return response()->json([
                    'status'=>false,
                    'totalCartItems'=>$totalCartItems,
                    'message'=>$error_message,
                    'view'=>(String)View::make('front.products.cart_items')->with(compact('getCartItems')),
                    'minicartview'=>(String)View::make('front.products.mini_cart')->with(compact('getCartItems'))
                    ]);    
                }else{
                    // Apply Coupon if coupon code is correct

                    // Check if Coupon Amount type is Fixed or Percentage
                    if($couponDetails->amount_type=="Fixed"){
                        $couponAmount = $couponDetails->amount;
                    }else{
                        $couponAmount = $total_amount * ($couponDetails->amount/100);
                    }

                    $grand_total = $total_amount - $couponAmount;

                    // Add Coupon Code & Amount in Session Variables
                    Session::put('couponAmount',$couponAmount);
                    Session::put('couponCode',$data['code']);

                    $message = "Coupon Code successfully applied. You are availing discount!";

                    return response()->json([
                    'status'=>true,
                    'totalCartItems'=>$totalCartItems,
                    'couponAmount'=>$couponAmount,
                    'grand_total'=>$grand_total,
                    'message'=>$message,
                    'view'=>(String)View::make('front.products.cart_items')->with(compact('getCartItems')),
                    'minicartview'=>(String)View::make('front.products.mini_cart')->with(compact('getCartItems'))
                    ]);
                }

            }
        }
    }

    public function checkout(Request $request){

        // Get User Cart Items
        $getCartItems = getCartItems();

        if(count($getCartItems)==0){
            $message = "Shopping Cart is empty! Please add products to checkout.";
            return redirect('cart')->with('error_message',$message);
        }

        if($request->isMethod('post')){
            $data = $request->all();
            /*print_r($data); die;*/

            $deliveryAddressCount = DeliveryAddress::where('user_id',Auth::user()->id)->count();
            if($deliveryAddressCount==0){
                return redirect()->back()->with('error_message','Please add your Delivery Address!');
            }

            if(empty($data['payment_gateway'])){
                $message = "Please select Payment Method!";
                return redirect()->back()->with('error_message',$message);
            }

            if(!isset($data['agree'])){
                $message = "Please agree to T&C!";
                return redirect()->back()->with('error_message',$message);
            }

            // Check for Default Delivery Address
            $deliveryAddressDefaultCount = DeliveryAddress::where('user_id',Auth::user()->id)->where('is_default',1)->count();
            if($deliveryAddressDefaultCount==0){
                return redirect()->back()->with('error_message','Please select your Delivery Address');
            }else{
                $deliveryAddress = DeliveryAddress::where('user_id',Auth::user()->id)->where('is_default',1)->first()->toArray();  
                //dd($deliveryAddress);
            }

            // Set Payment Method as COD and Order Status as New if COD is selected from user otherwise set Payment Method as Prepaid and Order Status as Pending
            if($data['payment_gateway']=="COD"){
                $payment_method = "COD";
                $order_status = "New";
            }else if($data['payment_gateway']=="Bank Transfer"){
                $payment_method = "Prepaid";
                $order_status = "Pending";
            }else if($data['payment_gateway']=="Check"){
                $payment_method = "Prepaid";
                $order_status = "Pending";
            }else if($data['payment_gateway']=="Paypal"){
                $payment_method = "Prepaid";
                $order_status = "Pending";
            }else{
                $payment_method = "Prepaid";
                $order_status = "Pending";
            }

            // Get User Cart Items
            $getCartItems = getCartItems();

            // Fetch Order Total Price
            $total_price = 0;
            foreach($getCartItems as $item){
                $getAttributePrice = Product::getAttributePrice($item['product_id'],$item['product_size']);
                $total_price = $total_price + ($getAttributePrice['final_price'] * $item['product_qty']);
            }

            // Get Shipping Charges
            $shipping_charges = 0;

            $shipping_charges = ShippingCharge::getShippingCharges($deliveryAddress['country']);

            // Calculate Grand Total
            $grand_total = $total_price + $shipping_charges - Session::get('couponAmount');

            // Insert Grand Total in Session Variable
            Session::put('grand_total',$grand_total);

            // Insert Order Details
            $order = new Order;
            $order->user_id = Auth::user()->id;
            $order->name = $deliveryAddress['name'];
            $order->address = $deliveryAddress['address'];
            $order->city = $deliveryAddress['city'];
            $order->state = $deliveryAddress['state'];
            $order->country = $deliveryAddress['country'];
            $order->pincode = $deliveryAddress['pincode'];
            $order->mobile = $deliveryAddress['mobile'];
            $order->email = Auth::user()->email;
            $order->shipping_charges = $shipping_charges;
            $order->coupon_code = Session::get('couponCode');
            $order->coupon_amount = Session::get('couponAmount');
            $order->order_status = $order_status;
            $order->payment_method = $payment_method;
            $order->payment_gateway = $data['payment_gateway'];
            $order->grand_total = $grand_total;
            $order->save();

            // Insert Ordered Product Details
            foreach($getCartItems as $item){
                $cartItem = new OrdersProduct;
                $cartItem->order_id = $order->id;
                $cartItem->user_id = Auth::user()->id;
                $getProductDetails = Product::select('product_code','product_name','product_color')->where('_id',$item['product_id'])->first()->toArray();
                /*dd($getProductDetails);*/
                $cartItem->product_id = $item['product_id'];
                $cartItem->product_code = $getProductDetails['product_code'];
                $cartItem->product_name = $getProductDetails['product_name'];
                $cartItem->product_color = $getProductDetails['product_color'];
                $cartItem->product_size = $item['product_size'];
                $cartItem->product_sku = ProductsAttribute::getAttributeSKU($item['product_id'],$item['product_size']);
                $getAttributePrice = Product::getAttributePrice($item['product_id'],$item['product_size']);
                $cartItem->product_price = $getAttributePrice['final_price'];
                $cartItem->product_qty = $item['product_qty'];
                $cartItem->save();

                 if($data['payment_gateway']=="COD" || $data['payment_gateway']=="Bank Transfer" || $data['payment_gateway']=="Check"){
                    // Reduce Stock Script Starts
                    $getProductStock = ProductsAttribute::productStock($item['product_id'],$item['product_size']);
                    $newStock = $getProductStock - $item['product_qty'];
                    ProductsAttribute::where(['product_id'=>$item['product_id'],'size'=>$item['product_size']])->update(['stock' => $newStock]);
                    // Reduce Stock Script Ends
                }

            }

            // Insert Order id in Session Variable
            Session::put('order_id',$order->id);

            if($data['payment_gateway']=="COD" || $data['payment_gateway']=="Bank Transfer" || $data['payment_gateway']=="Check"){

                // Send Order Email
                $orderDetails = Order::with('orders_products')->where('_id',$order->id)->first()->toArray();
                /*echo "<pre>"; print_r($orderDetails); die;*/

                // Send Order Email
                $email = Auth::user()->email;
                $messageData = [
                    'email' => $email,
                    'name' => Auth::user()->name,
                    'order_id' => $order->id,
                    'orderDetails' => $orderDetails
                ];
                Mail::send('emails.order',$messageData,function($message) use($email){
                    $message->to($email)->subject('Order Placed');
                });

                if($data['payment_gateway']=="COD"){
                    return redirect('/thanks');   
                }else if($data['payment_gateway']=="Bank Transfer"){
                    return redirect('/thanks?order=bank');
                }else if($data['payment_gateway']=="Check"){
                    return redirect('/thanks?order=check');
                }
                
            }else if($data['payment_gateway']=="Paypal"){
                // Paypal - Redirect user to paypal page after saving order
                return redirect('/paypal');
            }else{
                echo "Other Prepaid Methods Coming Soon"; die;
            }

        }

        // Get User Cart Items
        $getCartItems = getCartItems();
        // Get User Delivery Addresses
        $deliveryAddresses = DeliveryAddress::deliveryAddresses();
        // Get All Countries
        $countries = Country::where('status',1)->get()->toArray();


        // Get Shipping Charges from Default Delivery Address
        $addressCount = DeliveryAddress::where(['user_id'=>Auth::user()->id,'is_default'=>1])->count();
        if($addressCount>0){
            $defaultDeliveryAddress = DeliveryAddress::where(['user_id'=>Auth::user()->id,'is_default'=>1])->first()->toArray();
            // Get Shipping Charges
            $shipping_charges = ShippingCharge::getShippingCharges($defaultDeliveryAddress['country']);
        }else{
            $shipping_charges = 0;
        }

        return view('front.products.checkout')->with(compact('getCartItems','deliveryAddresses','countries','shipping_charges'));
    }

    public function thanks(){
        if(Session::has('order_id')){
            // Empty the User Cart
            Cart::where('user_id',Auth::user()->id)->delete();
            return view('front.products.thanks');    
        }else{
            return redirect('/cart');
        }        
    }

}
