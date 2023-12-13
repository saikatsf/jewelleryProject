<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\admincontroller;
use App\Http\Controllers\allcontroller;

use App\Models\producttype;
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

/* FRONTEND */
Route::get('/gets',function(){
    dd(session()->all() );
});


Route::get('/temp', function () {
    return view('temp');
});

Route::post('/ccavResponseHandler', [allController::class,'ccavResponseHandler']);

Route::get('/',[allController::class,'managehome']);
Route::get('/product/{product_id}', [allController::class,'getproductdetails']);
Route::get('/getSize', [allController::class,'getSize']);
Route::get('/productlist', [allController::class,'getproductlist']);

Route::post('/loginuser',[allController::class,'userloginfunc']);
Route::post('/registeruser',[allController::class,'userregisterfunc']);
Route::post('/verifyotp',[allController::class,'verifyotp']);

Route::get('/forgotpasswordpage',[allController::class,'forgotpasswordpage']);
Route::post('/forgotpasswordotp',[allController::class,'forgotpasswordotp']);
Route::post('/forgotpasswordotpverify',[allController::class,'forgotpasswordotpverify']);
Route::post('/forgotpasswordchange',[allController::class,'forgotpasswordchange']);

Route::get('/Ulogin/google',[allController::class,'redirectToGoogle']);
Route::get('Ulogin/google/callback',[allController::class,'handleGoogleCallback']);


Route::get('/addtocart/{product_id}/{type_id}', [allController::class,'addtocart']);
Route::get('/increasecart/{product_id}/{type_id}', [allController::class,'increasecart']);
Route::get('/decreasecart/{product_id}/{type_id}', [allController::class,'decreasecart']);
Route::get('/removecart/{product_id}/{type_id}', [allController::class,'removecart']);
Route::get('/cart', [allController::class,'getcart']);

Route::get('/TermsAndConditions',[allController::class,'terms']);
Route::get('/PrivacyPolicy',[allController::class,'privacy']);
Route::get('/ShippingPolicy',[allController::class,'shipping']);
Route::get('/ReturnPolicy',[allController::class,'returns']);
Route::get('/ContactUs',[allController::class,'contact']);
Route::get('/AboutUs',[allController::class,'about']);

Route::post('/contactformsubmit',[allController::class,'contactformsubmit']);

Route::Group(['middleware' => ['userNotLoggedIn']],function(){

    Route::get('/checkout', [allController::class,'getcheckoutprice']);
    Route::post('/checkoutorder', [allController::class,'checkoutorder']);
    Route::get('/buynow/{product_id}/{type_id}', [allController::class,'buynow']);
    Route::get('/orderconfirm', [allController::class,'orderconfirm']);
    Route::get('/getorders', [allController::class,'getorders']);
    Route::get('/getaddress/{pin_code}', [allController::class,'getaddress']);

    Route::get('/payment/{order_no}', [allController::class,'payment']);
  

    Route::get('/review/{order_detail_id}', [allController::class,'review']);
    Route::post('/reviewsubmit', [allController::class,'reviewsubmit']);

    Route::get('/logoutuser',function(){
        if(session()->has('userid')){
            session()->flush();
        }
        return redirect('/');
    });
    

});



/* ADMIN PANEL */

Route::Group(['middleware' => ['adminLoggedIn']],function(){
    Route::view('/adminpanel/signin','admin.signin');
    Route::post('/adminpanel/login',[AdminController::class,'adminlogin']);
});

Route::Group(['middleware' => ['adminNotLoggedIn']],function(){
    Route::get('/adminpanel',[adminController::class,'managedashboard']);
    Route::get('/adminpanel/orders', [adminController::class,'manageorders']);
    Route::get('/adminpanel/orderdetail/{order_id}', [adminController::class,'getorderdetail']);

    Route::view('/adminpanel/addcategorypage','admin.addcategory');
    Route::get('/adminpanel/managecategories',[AdminController::class,'showCategories']);
    Route::post('/adminpanel/addCategory',[admincontroller::class,'addCategory']);
    Route::get('/adminpanel/deleteCategory/{category_id}',[admincontroller::class,'deleteCategory']);
    Route::get('/adminpanel/editCategory/{category_id}',[admincontroller::class,'gotoeditCategory']);
    Route::post('/adminpanel/editCategory',[admincontroller::class,'editCategory']);


    Route::get('/adminpanel/addproductpage',[AdminController::class,'getDataAddproduct']);
    Route::get('/adminpanel/manageproducts',[AdminController::class,'showProducts']);
    Route::post('/adminpanel/addProduct',[admincontroller::class,'addProduct']);
    Route::get('/adminpanel/deleteProduct/{product_id}',[admincontroller::class,'deleteProduct']);
    Route::get('/adminpanel/editProduct/{product_id}',[admincontroller::class,'gotoeditProduct']);
    Route::post('/adminpanel/editProduct',[admincontroller::class,'editProduct']);
    Route::get('/removeproductimage/{product_img_id}',[admincontroller::class,'removeProductImage']);
    Route::get('/removeproducttype/{product_type_id}',[admincontroller::class,'removeProductType']);

    Route::view('/adminpanel/addcouponpage','admin.addcoupon');
    Route::get('/adminpanel/managecoupons',[AdminController::class,'showCoupons']);
    Route::post('/adminpanel/addCoupon',[admincontroller::class,'addCoupon']);
    Route::get('/adminpanel/deleteCoupon/{coupon_id}',[admincontroller::class,'deleteCoupon']);
    Route::get('/adminpanel/editCoupon/{coupon_id}',[admincontroller::class,'gotoeditCoupon']);
    Route::post('/adminpanel/editCoupon',[admincontroller::class,'editCoupon']);

    Route::get('/adminpanel/managereviews',[AdminController::class,'showReviews']);

    Route::get('/adminpanel/managecolors',[AdminController::class,'showColors']);
    Route::view('/adminpanel/addcolorpage','admin.addcolor');
    Route::post('/adminpanel/addColor',[admincontroller::class,'addColor']);
    Route::get('/adminpanel/editColor/{color_id}',[admincontroller::class,'gotoeditColor']);
    Route::post('/adminpanel/editColor',[admincontroller::class,'editColor']);
    Route::get('/adminpanel/deleteColor/{color_id}',[admincontroller::class,'deleteColor']);

    Route::get('/adminpanel/managepolishes',[AdminController::class,'showPolishes']);
    Route::view('/adminpanel/addpolishpage','admin.addpolish');
    Route::post('/adminpanel/addPolish',[admincontroller::class,'addPolish']);
    Route::get('/adminpanel/editPolish/{polish_id}',[admincontroller::class,'gotoeditPolish']);
    Route::post('/adminpanel/editPolish',[admincontroller::class,'editPolish']);

    Route::get('/adminpanel/managecollections',[AdminController::class,'showCollections']);
    Route::view('/adminpanel/addcollectionpage','admin.addcollection');
    Route::post('/adminpanel/addCollection',[admincontroller::class,'addCollection']);
    Route::get('/adminpanel/editCollection/{collection_id}',[admincontroller::class,'gotoeditCollection']);
    Route::post('/adminpanel/editCollection',[admincontroller::class,'editCollection']);

    Route::get('/adminpanel/managesizes',[AdminController::class,'showSizes']);
    Route::view('/adminpanel/addsizepage','admin.addsize');
    Route::post('/adminpanel/addSize',[admincontroller::class,'addSize']);
    Route::get('/adminpanel/editSize/{size_id}',[admincontroller::class,'gotoeditSize']);
    Route::post('/adminpanel/editSize',[admincontroller::class,'editSize']);

    Route::get('/changeorderstatus/{orderdetail_id}',[admincontroller::class,'changeorderstatus']);
    Route::get('/changeapprovalstatus/{review_id}',[admincontroller::class,'changeapprovalstatus']);
    Route::get('/adminpanel/logoutadmin',function(){
        if(session()->has('adminid')){
            session()->pull('adminid');
            session()->pull('adminname');
        }
        return redirect('/adminpanel/signin');
    });
});

