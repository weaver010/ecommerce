<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CmsController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Front\ProductController as ProductFrontController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Front\IndexController;
use App\Http\Controllers\Front\UserController as UserFrontController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Front\AddressController;
use App\Http\Controllers\Front\OrderController as OrderFrontController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Front\PaypalController;
use App\Http\Controllers\Admin\ShippingController;
use App\Models\Category;

Route::get('/', function () {
    return view('welcome');
});

// Send Link of PDF Invoice in Shipped Email
Route::get('orders/invoice/download/{id}',[App\Http\Controllers\Admin\OrderController::class,'printPDFInvoice']);

Route::prefix('/admin')->namespace('App\Http\Controllers\Admin')->group(function(){
    Route::match(['get','post'],'login',[AdminController::class,'login']);
    Route::group(['middleware'=>['admin']],function(){
        Route::match(['get','post'],'dashboard',[AdminController::class,'dashboard']);
        Route::match(['get','post'],'update-password',[AdminController::class,'updatePassword']);
        Route::post('check-current-password',[AdminController::class,'checkCurrentPassword']);
        Route::match(['get','post'],'update-admin-details',[AdminController::class,'updateAdminDetails']);
        Route::get('logout',[AdminController::class,'logout']);

        // CMS Pages
        Route::get('cms-pages',[CmsController::class,'index']);
        Route::post('update-cms-page-status',[CmsController::class,'update']);
        Route::match(['get','post'],'add-edit-cms-page/{id?}',[CmsController::class,'edit']);
        Route::get('delete-cms-page/{id}','CmsController@destroy');

        // Sub-Admins
        Route::get('subadmins',[AdminController::class,'subadmins']);
        Route::post('update-subadmin-status',[AdminController::class,'updateSubadminStatus']);
        Route::get('delete-subadmin/{id}',[AdminController::class,'deleteSubadmin']);
        Route::match(['get','post'],'add-edit-subadmin/{id?}',[AdminController::class,'addEditSubadmin']);
        Route::match(['get','post'],'/update-role/{id}','AdminController@updateRole');

        // Categories
        Route::get('categories',[CategoryController::class,'categories']);
        Route::post('update-category-status',[CategoryController::class,'updateCatgoryStatus']);
        Route::get('delete-category/{id}',[CategoryController::class,'deleteCategory']);
        Route::match(['get','post'],'add-edit-category/{id?}',[CategoryController::class,'addEditCategory']);
        Route::get('delete-category-image/{id}',[CategoryController::class,'deleteCategoryImage']);

        // Products
        Route::get('products',[ProductController::class,'products']);
        Route::post('update-product-status',[ProductController::class,'updateProductStatus']);
        Route::get('delete-product/{id}',[ProductController::class,'deleteProduct']);
        Route::match(['get','post'],'add-edit-product/{id?}',[ProductController::class,'addEditProduct']);
        Route::get('delete-product-video/{id}',[ProductController::class,'deleteProductVideo']);
        Route::get('delete-product-image/{id?}',[ProductController::class,'deleteProductImage']);

        // Attributes
        Route::post('update-attribute-status',[ProductController::class,'updateAttributeStatus']);
        Route::get('delete-attribute/{id?}',[ProductController::class,'deleteAttribute']);

        // Brands
        Route::get('brands',[BrandController::class,'brands']);
        Route::post('update-brand-status',[BrandController::class,'updateBrandStatus']);
        Route::get('delete-brand/{id?}',[BrandController::class,'deleteBrand']);
        Route::match(['get','post'],'add-edit-brand/{id?}',[BrandController::class,'addEditBrand']);
        Route::get('delete-brand-image/{id?}',[BrandController::class,'deleteBrandImage']);
        Route::get('delete-brand-logo/{id?}',[BrandController::class,'deleteBrandLogo']);

        // Banners
        Route::get('banners',[BannerController::class,'banners']);
        Route::post('update-banner-status',[BannerController::class,'updateBannerStatus']);
        Route::get('delete-banner/{id}',[BannerController::class,'deleteBanner']);
        Route::match(['get','post'],'add-edit-banner/{id?}','BannerController@addEditBanner');

        // Coupons
        Route::get('coupons',[CouponController::class,'coupons']);
        Route::post('update-coupon-status',[CouponController::class,'updateCouponStatus']);
        Route::match(['get','post'],'add-edit-coupon/{id?}',[CouponController::class,'addEditCoupon']);
        Route::get('delete-coupon/{id?}',[CouponController::class,'deleteCoupon']);

        // Users
        Route::get('users',[UserController::class,'users']);
        Route::post('update-user-status',[UserController::class,'updateUserStatus']);

        // Orders
        Route::get('orders',[OrderController::class,'orders']);

        // Order Detail
        Route::get('orders/{id}',[OrderController::class,'orderDetails']);

        // Update Order Status
        Route::post('update-order-status',[OrderController::class,'updateOrderStatus']);

        // Order Invoice
        Route::get('view-order-invoice/{id}',[OrderController::class,'viewOrderInvoice']);

        // Print PDF Invoice
        Route::get('print-pdf-invoice/{id}',[OrderController::class,'printPDFInvoice']);

        // Shipping Charges
        Route::get('shipping-charges',[ShippingController::class,'shippingCharges']);
        Route::match(['get','post'],'edit-shipping-charges/{id}',[ShippingController::class,'editShippingCharges']);
        Route::post('update-shipping-status',[ShippingController::class,'updateShippingStatus']);
    });
});

Route::namespace('App\Http\Controllers\Front')->group(function(){
    Route::get('/', [IndexController::class, 'index']);

    // Listing/Categories Routes
    $catUrls = Category::select('url')->where('status',1)->get()->pluck('url')->toArray();
    /*dd($catUrls); die;*/
    foreach ($catUrls as $key => $url) {
        Route::get('/'.$url,[ProductFrontController::class,'listing']);
    }

    // Product Detail Page
    Route::get('product/{id}',[ProductFrontController::class,'detail']);

    // Get Product Attribute Price
    Route::post('get-attribute-price',[ProductFrontController::class,'getAttributePrice']);

    // Add to Cart
    Route::post('/add-to-cart',[ProductFrontController::class,'addToCart']);

    // Shopping Cart Route
    Route::get('/cart',[ProductFrontController::class,'cart']);

    // Update Cart Item Quantity
    Route::post('update-cart-item-qty',[ProductFrontController::class,'updateCartItemQty']);

    // Delete Cart Item
    Route::post('delete-cart-item',[ProductFrontController::class,'deleteCartItem']);

    // Empty Cart
    Route::post('empty-cart',[ProductFrontController::class,'emptyCart']);

    // User Login
    Route::match(['get','post'],'/user/login',[UserFrontController::class,'loginUser']);

    // User Register
    Route::match(['get','post'],'/user/register',[UserFrontController::class,'registerUser']);

    // User Logout
    Route::get('user/logout',[UserFrontController::class,'logoutUser']);

    // User Confirm Account
    Route::match(['GET','POST'],'user/confirm/{code}',[UserFrontController::class,'confirmAccount']);

    // User Login
    Route::post('user/login',[UserFrontController::class,'loginUser'])->name('login');

    // Forgot Password
    Route::match(['get','post'],'user/forgot-password',[UserFrontController::class,'forgotPassword']);

    // Reset Password
    Route::match(['get','post'],'user/reset-password/{code?}',[UserFrontController::class,'resetPassword']);

    // Search Products
    Route::get('/search-products',[ProductFrontController::class,'listing']);

    Route::group(['middleware'=>['auth']],function(){

        // Apply Coupon
        Route::post('/apply-coupon',[ProductFrontController::class,'applyCoupon']);

        // User Account
        Route::match(['get','post'],'user/account',[UserFrontController::class,'account']);

        // Change Password
        Route::match(['get','post'],'user/change-password',[UserFrontController::class,'changePassword']);

        // Checkout
        Route::match(['GET','POST'],'/checkout',[ProductFrontController::class,'checkout']);

        // Save Delivery Address
        Route::post('save-delivery-address',[AddressController::class,'saveDeliveryAddress']);

        // Get Delivery Address
        Route::post('get-delivery-address',[AddressController::class,'getDeliveryAddress']);

        // Delete Delivery Address
        Route::post('remove-delivery-address',[AddressController::class,'removeDeliveryAddress']);

        // Set Default Delivery Address
        Route::post('set-default-delivery-address',[AddressController::class,'setDefaultDeliveryAddress']);

        // Order Thanks Page
        Route::get('/thanks',[ProductFrontController::class,'thanks']);

        // Users Orders
        Route::get('/user/orders',[OrderFrontController::class,'orders']);

        // User Order Details
        Route::get('/user/orders/{id}',[OrderFrontController::class,'orderDetails']);

        // Paypal
        Route::get('/paypal',[PaypalController::class,'paypal']);
        Route::post('/pay',[PaypalController::class,'pay'])->name('payment');
        Route::get('success',[PaypalController::class,'success']);
        Route::get('error',[PaypalController::class,'error']);

    });

});
    
