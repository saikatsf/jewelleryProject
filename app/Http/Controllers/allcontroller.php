<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Models\user;
use App\Models\category;
use App\Models\color;
use App\Models\polish;
use App\Models\collection;
use App\Models\product;
use App\Models\producttype;
use App\Models\productcol;
use App\Models\cart;
use App\Models\order;
use App\Models\ordertemp;
use App\Models\orderdetail;
use App\Models\coupon;
use App\Models\review;
use App\Models\reviewimage;
use App\Models\size;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Carbon\Carbon;
use Mail;

use Razorpay\Api\Api;
use Session;
use Validator;
use Input;


class allcontroller extends Controller
{
    public function __construct(){
        $categories = category::where('delete_flag',0)->take(8)->get();
        View::share('categories',$categories);
    }

	public function terms(){
        return view('terms');
    }
    public function privacy(){
        return view('privacy');
    }
    public function shipping(){
        return view('shipping');
    }
    public function returns(){
        return view('returns');
    }
    public function contact(){
        return view('contact');
    }
  	public function about(){
        return view('about');
    }
    public function managehome(){

        $p = producttype::select('product_id')
                        ->selectRaw('sum(quantity) as qty')
                        ->groupBy('product_id')
                        ->having('qty','>','0')
                        ->get();
        $pro_arr = array();
        foreach($p as $pros){
            array_push($pro_arr,$pros->product_id);
        }
		
        $hs_categories = category::where('homescreen',1)->where('delete_flag',0)->get();
      
        $products = product::where('delete_flag',0)
                            ->whereIn('product_id',$pro_arr)
                            ->orderByDesc('product_id')
                            ->take(6)->get();

        $bestsellers = product::where('delete_flag',0)
                            ->whereIn('product_id',$pro_arr)
                            ->orderByDesc('popularity')
                            ->take(6)->get();

        $reviews = review::where('approved',1)->where('delete_flag',0)->orderByDesc('review_id')->take(3)->get();

        return view('home')->with('hs_categories',$hs_categories)
          					->with('newproducts',$products)
                            ->with('bestsellers',$bestsellers)
                            ->with('reviews',$reviews);
    }

    public function userregisterfunc(Request $req){

        if (is_numeric($req->user_email_register)) {

            $req->validate([
                'user_fname_register' => 'required | regex:/^[a-zA-Z\s]*$/',
                'user_lname_register' => 'required | regex:/^[a-zA-Z\s]*$/',
                'user_email_register' => 'required | digits:10 | unique:user_master,email',
                'user_password_register'=> 'required | min:8'
            ]);

            $currentuser = new user;
            
            $currentuser->user_type=2;
            $currentuser->f_name=$req->user_fname_register;
            $currentuser->l_name=$req->user_lname_register;
            $currentuser->email=$req->user_email_register;
            $currentuser->password=Hash::make($req->user_password_register);
            $currentuser->otp_verified=1;
            $currentuser->save();
            
            $lastID = user::where('email',$req->user_email_register)->first();

            $req->session()->put('userid', $lastID->user_id);
            $req->session()->put('username', $lastID->f_name);

            return redirect('/');
        }
       $req->validate([
            'user_fname_register' => 'required | regex:/^[a-zA-Z\s]*$/',
            'user_lname_register' => 'required | regex:/^[a-zA-Z\s]*$/',
            'user_email_register' => 'required | email | unique:user_master,email',
            'user_password_register'=> 'required | min:8'
        ]);

        $currentuser = new user;
        
        $otp = rand(1000,9999);
        $currentuser->user_type=2;
        $currentuser->f_name=$req->user_fname_register;
        $currentuser->l_name=$req->user_lname_register;
        $currentuser->email=$req->user_email_register;
        $currentuser->password=Hash::make($req->user_password_register);
        $currentuser->otp=$otp;
        $currentuser->otp_verified=0;
        $currentuser->save();

        $username = $currentuser->f_name;
        $useraddress = $currentuser->email;
       

        require base_path("vendor/autoload.php");
      	
        $mail = new PHPMailer(true);
        $mail->SMTPDebug = 0;                                      
        $mail->isSMTP();
        $mail->Host       = env('MAIL_HOST');                        
        $mail->SMTPAuth   = true;                                  
        $mail->Username   = env('MAIL_ID');                  
        $mail->Password   = env('MAIL_PASS');                             
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
        $mail->Port       = 587;
        $mail->setFrom(env('MAIL_ID'),env('APP_NAME')); 
        $mail->addAddress($useraddress);
        $mail->isHTML(false);
        $mail->Subject =  'Registration OTP';
        $mail->Body    = 'Your Otp for registration is '.$otp;
        $dt = $mail->send();

        return redirect('/')->with('otpmessage', 'OTP Sent Successfully')->with('verifyemail', $useraddress);

        
    }

    public function verifyotp(Request $req){
        $req->validate([
            'user_verify_email' => 'required | email',
            'user_verify_otp' => 'required | digits:4',
        ]);

        $checkotp = user::where('email',$req->user_verify_email)
                        ->where('otp',$req->user_verify_otp)
                        ->first();
                     
        if ($checkotp == NUll) {
            return redirect('/')->with('otpmessage', 'Wrong OTP')->with('verifyemail', $req->user_verify_email);
        }
        else{
            user::where('email',$req->user_verify_email)
                        ->where('otp',$req->user_verify_otp)
                        ->update(['otp_verified'=>1]);

            $req->session()->put('userid', $checkotp->user_id);
            $req->session()->put('username', $checkotp->f_name);

            return redirect('/');
        }
    }

    public function userloginfunc(Request $req){

        if (is_numeric($req->user_email_login)) {
        
            $req->validate([
                'user_email_login' => 'required | digits:10',
                'user_password_login'=> 'required | min:8'
            ]);
        } else{
            $req->validate([
                'user_email_login' => 'required | email',
                'user_password_login'=> 'required | min:8'
            ]);
        }
        
        $data=user::where('email',$req->user_email_login)
                    ->where('user_type',2)
                    ->where('otp_verified',1)
                    ->first();


        if(empty($data)){
            return back()->with('loginmessage', 'Wrong Email or Password');
        }

        if(Hash::check($req->user_password_login, $data->password)){
            $req->session()->put('userid', $data->user_id);
            $req->session()->put('username', $data->f_name);

            if (session()->has('cart')) {

                $allcart = session('cart'); 

                for ($i=0; $i < count($allcart); $i++) { 

                    $cartProduct = cart::where('user_id',session('userid'))
                                    ->where('product_id',$allcart[$i]['product_id'])
                                    ->where('product_type_id',$allcart[$i]['product_type_id'])
                                    ->where('delete_flag',0)
                                    ->first();

                    if($cartProduct != NULL){

                        $quantity = $cartProduct->quantity + $allcart[$i]['quantity'];
                        cart::where('user_id',session('userid'))
                                ->where('product_id',$allcart[$i]['product_id'])
                                ->where('product_type_id',$allcart[$i]['product_type_id'])
                                ->update(['quantity'=> $quantity]);
                        
                    } else {
                        $newcartProduct = new cart;

                        $newcartProduct->user_id = $data->user_id;
                        $newcartProduct->product_id = $allcart[$i]['product_id'];
                        $newcartProduct->product_type_id = $allcart[$i]['product_type_id'];
                        $newcartProduct->quantity = $allcart[$i]['quantity'];
                        $newcartProduct->delete_flag = 0;

                        $newcartProduct->save();

                    }
                }
            }

            $cart_list = cart::where('user_id',session('userid'))->where('delete_flag',0)->get();
            Session()->forget('cart');

            foreach ($cart_list as $item) {
                $cart = [
                    'product_id' => $item->product_id,
                    'product_type_id' => $item->product_type_id,
                    'quantity' => $item->quantity,
                ];
                Session()->push('cart', $cart);
            }


            return back();
        }
        else{
            return back()->with('loginmessage', 'Wrong Email or Password');
        }

    }

    public function redirectToGoogle(){
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(Request $req){

        $socUser = Socialite::driver('google')->user();

        $data=user::where('email',$socUser->email)->first();

        if($data && $data->provider_id != $socUser->id){
            return redirect('/')->with('loginmessage', 'An account is already registered with this email');
        }

        if(!$data){
            $currentuser = new user;
        
            $currentuser->user_type=2;
            $currentuser->f_name=$socUser->name;
            $currentuser->l_name=$socUser->name;
            $currentuser->email=$socUser->email;
            $currentuser->provider_id=$socUser->id;
            $currentuser->otp_verified=1;

            $currentuser->save();

            $lastID = user::where('email',$socUser->email)->first();
        
            $req->session()->put('userid', $lastID->user_id);
            $req->session()->put('username', $lastID->f_name);
            
        }
        else{
            $req->session()->put('userid', $data->user_id);
            $req->session()->put('username', $data->f_name);
        }

        if (session()->has('cart')) {

            $allcart = session('cart'); 

            for ($i=0; $i < count($allcart); $i++) { 

                $cartProduct = cart::where('user_id',session('userid'))
                ->where('product_id',$allcart[$i]['product_id'])
                ->where('product_type_id',$allcart[$i]['product_type_id'])
                ->where('delete_flag',0)
                ->first();

                if($cartProduct != NULL){

                    $quantity = $cartProduct->quantity + $allcart[$i]['quantity'];
                    cart::where('user_id',session('userid'))
                            ->where('product_id',$allcart[$i]['product_id'])
                            ->where('product_type_id',$allcart[$i]['product_type_id'])
                            ->update(['quantity'=> $quantity]);
                    
                } else {
                    $newcartProduct = new cart;

                    $newcartProduct->user_id = $data->user_id;
                    $newcartProduct->product_id = $allcart[$i]['product_id'];
                    $newcartProduct->product_type_id = $allcart[$i]['product_type_id'];
                    $newcartProduct->quantity = $allcart[$i]['quantity'];
                    $newcartProduct->delete_flag = 0;

                    $newcartProduct->save();

                }
            }
        }

        $cart_list = cart::where('user_id',session('userid'))->where('delete_flag',0)->get();
            Session()->forget('cart');
            
            foreach ($cart_list as $item) {
                $cart = [
                    'product_id' => $item->product_id,
                    'product_type_id' => $item->product_type_id,
                    'quantity' => $item->quantity,
                ];
                Session()->push('cart', $cart);
            }

        return redirect('/');

    }

    public function forgotPasswordPage(){
        return view('forgotpasswordpage');
    }

    public function forgotpasswordotp(Request $req){

        $req->validate([
            'user_email_forgot' => 'required | email'
        ]);
        $useraddress = $req->user_email_forgot;
        $data=user::where('email',$useraddress)
                    ->where('user_type',2)
                    ->where('otp_verified',1)
                    ->first();

        if(empty($data)){
            return back()->with('forgotmessage', 'Email does Not Exist');
        }
        $otp = rand(1000,9999);
        $data=user::where('email',$useraddress)->update(['otp'=>$otp]);

        require base_path("vendor/autoload.php");
      	
        $mail = new PHPMailer(true);
        $mail->SMTPDebug = 0;                                      
        $mail->isSMTP();
        $mail->Host       = env('MAIL_HOST');                        
        $mail->SMTPAuth   = true;                                  
        $mail->Username   = env('MAIL_ID');                  
        $mail->Password   = env('MAIL_PASS');                             
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
        $mail->Port       = 587;
        $mail->setFrom(env('MAIL_ID'),env('APP_NAME')); 
        $mail->addAddress($useraddress);
        $mail->isHTML(false);
        $mail->Subject =  'Forgot Password OTP';
        $mail->Body    = 'Your Otp for Changing Password is '.$otp;
        $dt = $mail->send();

        return view('forgotpasswordotppage')->with('forgototpmessage', 'OTP Sent Successfully')->with('verifyemail', $useraddress);
    }

    public function forgotpasswordotpverify(Request $req){


        $validator = Validator::make($req->all(), [
            'user_email_forgot' => 'required | email',
            'user_otp_forgot' => 'required | digits:4'
        ]);
        
        if ($validator->fails()) {
            return view('forgotpasswordotppage')->withErrors($validator)->with('verifyemail', $req->user_email_forgot);
        }

        $checkotp = user::where('email',$req->user_email_forgot)
                        ->where('otp',$req->user_otp_forgot)
                        ->first();
                     
        if ($checkotp == NUll) {
            return view('forgotpasswordotppage')->with('forgototpmessage', 'Wrong OTP')->with('verifyemail', $req->user_email_forgot);
        }
        else{
            return view('forgotpasswordchangepage')->with('useremail', $req->user_email_forgot);
        }
    }

    public function forgotpasswordchange(Request $req){

        $validator = Validator::make($req->all(), [
            'user_email' => 'required|email',
            'password' => 'required|confirmed|min:8',
            'password_confirmation' => 'required|min:8'
        ]);
        
        if ($validator->fails()) {
            return view('forgotpasswordchangepage')->withErrors($validator)->with('useremail', $req->user_email);
        }
        
        user::where('email',$req->user_email)
                    ->update(['password'=>Hash::make($req->password)]);


        return redirect('/');
    }

    public function getproductdetails($product_id){
        
        $prodID = Crypt::decrypt($product_id);
        
        $product_detail = product::where('product_id',$prodID)->first();

        $product_types = producttype::where('product_id',$prodID)->where('delete_flag',0)->groupBy('product_color','product_polish')->get();

        $product_qty = producttype::where('product_id',$prodID)->sum('quantity');

        return view('productdetails')->with('product_detail',$product_detail)
                                        ->with('product_types',$product_types)
                                        ->with('quantity',$product_qty);
    }

    public function getSize(Request $req){
        $product_id = Crypt::decrypt($req->input('product_id'));
        $type_id = $req->input('type_id');

        $product_type = producttype::where('product_type_id',$type_id)->first();
        $product_color = $product_type->product_color;
        $product_polish = $product_type->product_polish;

        $sizes = producttype::where('product_id',$product_id)
                            ->where('product_color',$product_color)
                            ->where('product_polish',$product_polish)
                            ->where('delete_flag',0)
                            ->get();
        
        $html ='';
        if ( ! $sizes->isEmpty() ) {
            $i = 0;
            foreach($sizes as $item){

                if ($item->quantity > 0 && $item->product_size != 0){
                    $html = $html.'<div class="col-12 col-sm-6 col-lg-4">';
                    
                   if ($i == 0) {
                    $html = $html.'<input type="radio" id="s'.$item->product_type_id.'" name="size_select" value="'.$item->product_type_id.'" checked>';
                   }else{
                    $html = $html.'<input type="radio" id="s'.$item->product_type_id.'" name="size_select" value="'.$item->product_type_id.'">';
                   }
                    
                    $html = $html.'<label for="s'.$item->product_type_id.'"> <span class="fw-bold">'.$item->getsize->size.'</span> </label> </div>';   
                    $i++;
                }

            }
        }
        
        return response()->json(['html' => $html]);

    }

    public function getproductlist(Request $req){

        $colors = color::where('delete_flag',0)->get();
        $polishes = polish::where('delete_flag',0)->get();
        $collections = collection::where('delete_flag',0)->get();
        $sizes = size::where('delete_flag',0)->get();

        $p = producttype::select('product_id')
                        ->selectRaw('sum(quantity) as qty')
                        ->groupBy('product_id')
                        ->having('qty','>','0')
                        ->get();
        $pro_arr = array();
        foreach($p as $pros){
            array_push($pro_arr,$pros->product_id);
        }
        $searchtext = NULL;
        
        if ($req->has('search')) {

            $searchtext = $req->input('search');

            $product_list = product::where('product_name', 'LIKE', '%'.$searchtext.'%')
                            ->whereIn('product_id',$pro_arr)
                            ->where('delete_flag',0)
                            ->get();
        }
        else{
            $product_list = product::whereIn('product_id',$pro_arr)
                        ->where('delete_flag',0)
                        ->orderByDesc('product_id')
                        ->get();
        }
        
        $category_id = NULL;
        if ($req->input('category')) {

            $category_id = $req->input('category');

            $catID = Crypt::decrypt($category_id);

            if($catID != 0){
              $product_list = $product_list->where('category_id',$catID);
            }

        }

        $sort_by= "none";
        if ($req->input('sortby')) {

            $sort_by = $req->input('sortby');

            if ($sort_by == 'latest') {
                $product_list = $product_list->sortByDesc('product_id');
            } elseif ($sort_by == 'popular') {
                $product_list = $product_list->sortByDesc('popularity');
            } elseif ($sort_by == 'low2high') {
                $product_list = $product_list->sortBy('price');
            } elseif ($sort_by == 'high2low') {
                $product_list = $product_list->sortByDesc('price');
            }
        }

        $price_filter = "none";
        if ($req->input('pricefilter')) {
            
            $price_filter = $req->input('pricefilter');

            if ($price_filter == 'type1') {
                $product_list = $product_list->whereBetween('price', [0, 500]);
            } elseif ($price_filter == 'type2') {
                $product_list = $product_list->whereBetween('price', [0, 1000]);
            } elseif ($price_filter == 'type3') {
                $product_list = $product_list->whereBetween('price', [0, 2000]);
            } elseif ($price_filter == 'type4') {
                $product_list = $product_list->whereBetween('price', [0, 3000]);
            } elseif ($price_filter == 'type5') {
                $product_list = $product_list->whereBetween('price', [0, 5000]);
            }
        }

        $color_filter = "none";
        if (!empty($req->input('colorfilter'))) {

            $color_filter = $req->input('colorfilter');

            $get_products = producttype::whereIn('product_color',$color_filter)->where('quantity','>',0)->where('delete_flag',0)->get();

            $id_arr = array();
            foreach ( $get_products as $value) {
                array_push( $id_arr, $value->product_id );
            }

            $product_list = $product_list->whereIn('product_id',$id_arr);

        }

        $polish_filter = "none";
        if (!empty($req->input('polishfilter'))) {

            $polish_filter = $req->input('polishfilter');

            $get_products = producttype::whereIn('product_polish',$polish_filter)->where('quantity','>',0)->where('delete_flag',0)->get();

            $id_arr = array();
            foreach ( $get_products as $value) {
                array_push( $id_arr, $value->product_id );
            }

            $product_list = $product_list->whereIn('product_id',$id_arr);

        }

        $collection_filter = "none";
        if (!empty($req->input('collectionfilter'))) {

            $collection_filter = $req->input('collectionfilter');

            $get_products = productcol::whereIn('collection_id',$collection_filter)->where('delete_flag',0)->get();

            $id_arr = array();
            foreach ( $get_products as $value) {
                array_push( $id_arr, $value->product_id );
            }

            $product_list = $product_list->whereIn('product_id',$id_arr);

        }

        $size_filter = "none";
        if (!empty($req->input('sizefilter'))) {

            $size_filter = $req->input('sizefilter');

            $get_products = producttype::whereIn('product_size',$size_filter)->where('quantity','>',0)->where('delete_flag',0)->get();

            $id_arr = array();
            foreach ( $get_products as $value) {
                array_push( $id_arr, $value->product_id );
            }

            $product_list = $product_list->whereIn('product_id',$id_arr);

        }

        $del_charges = "both";
        if (!empty($req->input('delcharges'))) {

            $del_charges = $req->input('delcharges');

            if ($del_charges == 'on') {
                $product_list = $product_list->where('delivery_charges',1);
            } elseif ($del_charges == 'off') {
                $product_list = $product_list->where('delivery_charges',0);
            }


        }
        
        return view('productslist')->with('product_list',$product_list)
                                    ->with('category_id',$category_id)
                                    ->with('searchtext',$searchtext)
                                    ->with('sortby',$sort_by)
                                    ->with('pricefilter',$price_filter)
                                    ->with('colorfilter',$color_filter)
                                    ->with('polishfilter',$polish_filter)
                                    ->with('collectionfilter',$collection_filter)
                                    ->with('sizefilter',$size_filter)
                                    ->with('colors',$colors)
                                    ->with('polishes',$polishes)
                                    ->with('collections',$collections)
                                    ->with('sizes',$sizes)
                                    ->with('delcharges',$del_charges);
        
    }

    public function addtocart($product_id,$type_id){
        $prodID = Crypt::decrypt($product_id);

        if(session()->has('userid')){
            $cartProduct = cart::where('user_id',session('userid'))
                        ->where('product_id',$prodID)
                        ->where('product_type_id',$type_id)
                        ->where('delete_flag',0)
                        ->first();

            if($cartProduct != NULL){

                $quantity = $cartProduct->quantity + 1;
                cart::where('user_id',session('userid'))
                        ->where('product_id',$prodID)
                        ->where('product_type_id',$type_id)
                        ->update(['quantity'=> $quantity]);
                
            } else {
                $newcartProduct = new cart;

                $newcartProduct->user_id = session('userid');
                $newcartProduct->product_id = $prodID;
                $newcartProduct->product_type_id = $type_id;
                $newcartProduct->quantity = 1;
                $newcartProduct->delete_flag = 0;
                $newcartProduct->save();

            }
            
            
        }
        if (session()->has('cart')) {

            $allcart = session('cart');

            for ($i=0; $i < count($allcart); $i++) { 

                if($allcart[$i]['product_id'] == $prodID && $allcart[$i]['product_type_id'] == $type_id){
                    
                    $allcart[$i]['quantity'] = $allcart[$i]['quantity'] + 1;
                    session()->put('cart',$allcart);

                    return redirect('/cart');
                }
            }
        }
        
        $cart = [
            'product_id' => $prodID,
            'product_type_id' => $type_id,
            'quantity' => 1,
        ];
        Session()->push('cart', $cart);
        

        return redirect('/cart');
    }

    public function removecart($product_id,$type_id){
        $prodID = Crypt::decrypt($product_id);

        $allcart = session('cart');

        for ($i=0; $i < count($allcart); $i++) { 

            if($allcart[$i]['product_id'] == $prodID && $allcart[$i]['product_type_id'] == $type_id){
                
                unset($allcart[$i]);
                $newallcart = array_values($allcart);

                session()->put('cart',$newallcart);
            }
        }

        if (session()->has('userid')) {

            cart::where('product_id',$prodID)
                ->where('product_type_id',$type_id)
                ->where('user_id',session('userid'))
                ->update(['delete_flag'=>1]);
        }

        

        return redirect('/cart')->with('success','product removed');
    }

    public function increasecart($product_id,$type_id){

        $prodID = Crypt::decrypt($product_id);

        $allcart = session('cart');

        for ($i=0; $i < count($allcart); $i++) { 

            if($allcart[$i]['product_id'] == $prodID && $allcart[$i]['product_type_id'] == $type_id){
                
                $allcart[$i]['quantity'] = $allcart[$i]['quantity'] + 1;

                session()->put('cart',$allcart);
            }
        }

        if (session()->has('userid')) {

            $cart = cart::where('product_id',$prodID)
                    ->where('product_type_id',$type_id)
                    ->where('user_id',session('userid'))
                    ->first();

            $quantity = $cart->quantity + 1;

            cart::where('product_id',$prodID)
                    ->where('product_type_id',$type_id)
                    ->where('user_id',session('userid'))
                    ->update(['quantity' => $quantity]);
        }
        

        return redirect('/cart')->with('success','product quantity increased');
    }

    public function decreasecart($product_id,$type_id){

        $prodID = Crypt::decrypt($product_id);

        $allcart = session('cart');

        for ($i=0; $i < count($allcart); $i++) { 

            if($allcart[$i]['product_id'] == $prodID && $allcart[$i]['product_type_id'] == $type_id){

                if ( $allcart[$i]['quantity'] > 1) {

                    $allcart[$i]['quantity'] = $allcart[$i]['quantity'] - 1;

                    session()->put('cart',$allcart);

                }
                else{
                    unset($allcart[$i]);
                    $newallcart = array_values($allcart);

                    session()->put('cart',$newallcart);
                }
                
            }
        }

        if (session()->has('userid')) {

            $cart = cart::where('product_id',$prodID)
                    ->where('product_type_id',$type_id)
                    ->where('user_id',session('userid'))
                    ->first();

            if ($cart->quantity > 1) {

                $quantity = $cart->quantity - 1;
            
                cart::where('product_id',$prodID)
                        ->where('product_type_id',$type_id)
                        ->where('user_id',session('userid'))
                        ->update(['quantity' => $quantity]);
            }else{
                cart::where('product_id',$prodID)
                        ->where('product_type_id',$type_id)
                        ->where('user_id',session('userid'))
                        ->update(['delete_flag' => 1]);
            }

        }
        return redirect('/cart')->with('success','product quantity decreased');
    }

    public function getorders(){
        
        $myorders = order::where('user_id',session('userid'))->get();
        $order_nos = array();

        foreach($myorders as $item){
            array_push($order_nos,$item->order_no);
        }
        $orderdetails = orderdetail::whereIn('order_no',$order_nos)->get();

        return view('orders')->with('myorders',$orderdetails);
    }

    public function getcart(){
        
        $cart_list = array();
        if (session()->has('cart')) {

            $allcart = session('cart'); 

            for ($i=0; $i < count($allcart); $i++) { 

                $product_detail = $this->getproduct($allcart[$i]['product_id']);
                $product_type_detail = $this->getproducttype($allcart[$i]['product_type_id']);

                if ($product_type_detail->product_size == 0) {
                    $product_size = 0;
                } else {
                    $product_size = $product_type_detail->getsize->size;
                }
                
                

                $cart = [
                    'product_id'            => $allcart[$i]['product_id'],
                    'product_type_id'       => $allcart[$i]['product_type_id'],
                    'product_type_name'     => $product_type_detail->getcolor->color." + ".$product_type_detail->getpolish->polish,
                    'product_size'          => $product_size,
                    'image'                 => $product_detail->coverimage->product_img,
                    'name'                  => $product_detail->product_name,
                    'stock'                 => $product_type_detail->quantity,
                    'price'                 => $product_detail->price,
                    'mrp'                   => intval(100 / ( 100 - $product_detail->discount) * $product_detail->price ),
                    
                    'quantity'      => $allcart[$i]['quantity'],
                ];
                array_push($cart_list,$cart);
            }
        }
        return view('cartpage')->with('cart_list',$cart_list);
    }

    public function getproduct($product_id){
        $product_detail = product::where('product_id',$product_id)->first();
        return $product_detail;
    }

    public function getproducttype($product_type_id){
        $product_type_detail = producttype::where('product_type_id',$product_type_id)->first();
        return $product_type_detail;
    }

    public function buynow($product_id,$type_id){
        return redirect('/checkout?directorder_id='.$product_id.'&type_id='.$type_id);
    }

    public function getcheckoutprice(Request $req){

        if ($req->has('coupon_code')) {

            $coupon_detail = coupon::where('coupon_code',$req->input('coupon_code'))
                                ->where('delete_flag',0)
                                ->first();
            if ($coupon_detail == NULL) {
                $discount_amt = 0;
            }
            else{
                $discount_amt = $coupon_detail->discount;
            }
        }
        else{
            $discount_amt = 0;
        }

        $directorder = array();
        $directorder = [
            'product_id' => 0,
            'product_type_id' => 0
        ];

        if($req->has('directorder_id')){

            $directorder_id = Crypt::decrypt($req->input('directorder_id'));

            if($directorder_id != 0 ){

                $products = product::where('product_id',$directorder_id)->get();
                
                $type_id = $req->input('type_id');

                $product_type_detail = $this->getproducttype($type_id);

                $product_type_name = "( ".ucfirst($product_type_detail->getcolor->color)." + ".ucfirst($product_type_detail->getpolish->polish)." ) ";
                if ($product_type_detail->product_size != 0){
                    $product_type_name = $product_type_name." ( Size : ".$product_type_detail->getsize->size." )";
                }
                $directorder = [
                    'product_id'        => $directorder_id,
                    'product_type_id'   => $type_id,
                    'product_type_name' => $product_type_name
                ];

            }
            else{
                $products = cart::where('user_id',session('userid'))->where('delete_flag',0)->get();
            }
        }
        else{
            $products = cart::where('user_id',session('userid'))->where('delete_flag',0)->get();
        }
        
        return view('checkout')->with('products',$products)->with('directorder',$directorder)->with('discount_amt',$discount_amt);
    }

    public function getaddress($pin_code){
        $data = file_get_contents('http://www.postalpincode.in/api/pincode/'.$pin_code);
        $data = json_decode($data);
        

        if (isset($data->PostOffice[0])) {
            $address_arr = [
                'city' => $data->PostOffice[0]->Taluk,
                'state' => $data->PostOffice[0]->State
            ];
            echo json_encode($address_arr);
        }
        else{
            echo "none";
        }
    } 

    public function checkoutorder(Request $req){

        $directorder_id = Crypt::decrypt($req->directorder_id);
        $directorder_type_id = Crypt::decrypt($req->directorder_type_id);

        if( $directorder_id != 0){

            $singleproduct = product::where('product_id',$directorder_id)->first();
            $totalPrice = $singleproduct->price;
            if ( $singleproduct->delivery_charges == 0) {
                $delivery_charge = 0;
            }else {
                $delivery_charge = 80;
            }

        }
        else{
            $products = cart::where('user_id',session('userid'))->where('delete_flag',0)->get();
            $totalPrice = 0;
            $delivery_charge = 80;
            foreach($products as $item){
                if($item->product_detail->delivery_charges == 0){
                    $delivery_charge = 0;
                }
                $singleprice = $item->product_detail->price * $item->quantity;
                $totalPrice = $totalPrice + $singleprice;
            }
        }

        $order_number = mt_rand(1000,9999);
        $d1           = date("YmdHis");
        $order_number = $order_number.$d1;

        if($req->payment_mode == 1){
            
            $neworder = new order;
            $neworder->order_no = $order_number;
            $neworder->user_id = session('userid');
            $neworder->name = $req->user_name;
            $neworder->mobile = $req->user_mobile;
            $neworder->address = $req->user_address;
            $neworder->city = $req->user_city;
            $neworder->state = $req->user_state;
            $neworder->pin = $req->user_pin;
            $neworder->landmark = $req->user_landmark;
            $neworder->payment_mode = $req->payment_mode;
            $neworder->price = $totalPrice - intval($totalPrice * $req->discount_amt / 100) + $delivery_charge;

            $neworder->save();
            
            $lastID = order::where('user_id',session('userid'))->latest()->first();

        }else{
            $newtemporder = new ordertemp;
            $newtemporder->order_no = $order_number;
            $newtemporder->user_id = session('userid');
            $newtemporder->name = $req->user_name;
            $newtemporder->mobile = $req->user_mobile;
            $newtemporder->address = $req->user_address;
            $newtemporder->city = $req->user_city;
            $newtemporder->state = $req->user_state;
            $newtemporder->pin = $req->user_pin;
            $newtemporder->landmark = $req->user_landmark;
            $newtemporder->payment_mode = $req->payment_mode;
            $newtemporder->price = $totalPrice - intval($totalPrice * $req->discount_amt / 100) + $delivery_charge;
          
          	if( $directorder_id != 0){
                $newtemporder->directorder = 1;
            }else{
                $newtemporder->directorder = 0;
            }

            $newtemporder->save();
            
            $lastID = ordertemp::where('user_id',session('userid'))->latest()->first();
        }

        if($directorder_id != 0){
            $neworderdtl = new orderdetail;

            $neworderdtl->order_no = $lastID->order_no;
            $neworderdtl->product_id = $directorder_id;
            $neworderdtl->product_type_id = $directorder_type_id;
            $neworderdtl->quantity = 1;
            $neworderdtl->price = $singleproduct->price;
            $neworderdtl->order_status = 0;
            $neworderdtl->review_status = 0;

            $neworderdtl->save();

            $getproduct = product::where('product_id',$directorder_id)->first();
            $newPopularity = ($getproduct->popularity + 1);
            product::where('product_id',$directorder_id)->update(['popularity' => $newPopularity]);

            $getproducttype = producttype::where('product_id',$directorder_id)
                                        ->where('product_type_id',$directorder_type_id)
                                        ->first();
            $newQuantity = ($getproducttype->quantity - 1);
            producttype::where('product_id',$directorder_id)
                    ->where('product_type_id',$directorder_type_id)
                    ->update(['quantity' => $newQuantity]);
        }
        else{
            foreach($products as $item){


                $getproducttype = producttype::where('product_id',$item->product_id)
                                            ->where('product_type_id',$item->product_type_id)
                                            ->first();
                if($item->quantity > $getproducttype->quantity){

                    $item->quantity = $getproducttype->quantity;
                }                        
                $newQuantity = ($getproducttype->quantity - $item->quantity);
                producttype::where('product_id',$item->product_id)
                        ->where('product_type_id',$item->product_type_id)
                        ->update(['quantity' => $newQuantity]);


                $neworderdtl = new orderdetail;
    
                $neworderdtl->order_no = $lastID->order_no;
                $neworderdtl->product_id = $item->product_id;
                $neworderdtl->product_type_id = $item->product_type_id;
                $neworderdtl->quantity =  $item->quantity;
                $neworderdtl->price = $item->product_detail->price;
                $neworderdtl->order_status = 0;
                $neworderdtl->review_status = 0;

                $neworderdtl->save();
                
                
                $getproduct = product::where('product_id',$item->product_id)->first();
                $newPopularity = ($getproduct->popularity + 1);
                product::where('product_id',$item->product_id)->update(['popularity' => $newPopularity]);
                

                
            }
            
        }
        
        if ($req->payment_mode == 1) {
            return redirect('/');
        } else {
            $orderNo = Crypt::encrypt($lastID->order_no);
            return redirect('/payment/'.$orderNo);
        }
        
    }
    
    public function payment($order_no){
        $orderNo = Crypt::decrypt($order_no);
        $order = ordertemp::where('order_no', $orderNo)->first();
        //session()->put('order_no',$order->order_no);

        $working_key='C8F4F191936A953063771352DCB78650';//Shared by CCAVENUES
        $access_code='AVIX12KA50BR26XIRB';//Shared by CCAVENUES

        $merchant_data='tid='.time().'&merchant_id=2010928&order_id='.$order->order_no.'&amount='.$order->price.'&currency=INR&redirect_url=https://www.jhumstaacreations.com/ccavResponseHandler&cancel_url=https://www.jhumstaacreations.com/ccavResponseHandler&language=EN';

        $merchant_data=$merchant_data.'&billing_name='.$order->name.'&billing_address='.$order->address.'&billing_city='.$order->city.'&billing_state='.$order->state.'&billing_zip='.$order->pin.'&billing_country=India&billing_tel='.$order->mobile.'&billing_email=abc@mail.com';

        $encrypted_data = $this->encrypt($merchant_data,$working_key);
      
		?>
			<form method="post" name="redirect" action="https://secure.ccavenue.com/transaction/transaction.do?command=initiateTransaction"> 
				<?php
				echo "<input type=hidden name=encRequest value=$encrypted_data>";
				echo "<input type=hidden name=access_code value=$access_code>";
				?>
			</form>
			<div class="payment-loader-container">
              <div class="payment-loader">
                <div class="payment-circle">
                  <div class="payment-inner-circle">
                  </div>
                  <h1>
                    ₹
                  </h1>
                </div>
              </div>
            </div>
			<style>
				=animation($animation)
                  -webkit-animation: $animation
                  animation: $animation

                =keyframes($animationName)
                  @-webkit-keyframes #{$animationName}
                    @content

                  @-moz-keyframes #{$animationName}
                    @content

                  @-o-keyframes #{$animationName}
                    @content

                  @keyframes #{$animationName}
                    @content

                +keyframes(pulsate)
                  0%
                    transform: scale(.75)
                  50%
                    transform: scale(1.75)
                  100%
                    transform: scale(.75)

                +keyframes(rotate)
                  0%
                    transform: rotate(0deg)
                  100%
                    transform: rotate(360deg)

                .payment-loader-container
                  margin: 25vh auto 0
                  .payment-loader
                    width: 125px
                    height: 125px
                    margin: 0 auto
                    .payment-circle
                      text-align: center
                      width: 100%
                      height: 100%
                      border-radius: 50%
                      border: 5px solid lightgray
                      .payment-inner-circle
                        position: relative
                        left: -12.5%
                        top: 35%
                        width: 125%
                        height: 25%
                        background-color: white
                        +animation(rotate 2s infinite linear)
                      h1
                        position: relative
                        color: darkgray
                        top: -.25em
                        font-family: 'Raleway'
                        +animation(pulsate 1.25s infinite ease)
			</style>
			<script language='javascript'>document.redirect.submit();</script>
		<?php
        
    }

    

    public function ccavResponseHandler(Request $req) {
        $workingKey='C8F4F191936A953063771352DCB78650';		//Working Key should be provided here.
        //$encResponse=$_POST["encResp"];			           //This is the response sent by the CCAvenue Server
        $encResponse=$req->encResp;
        echo "here -> ".$encResponse;
        $rcvdString=$this->decrypt($encResponse,$workingKey);		//Crypto Decryption used as per the specified working key.
        $decryptValues=explode('&', $rcvdString);
        $dataSize=sizeof($decryptValues);
      
        for($i = 0; $i < $dataSize; $i++) {
          
            $information=explode('=',$decryptValues[$i]);
          
          	if($information[0] == 'order_id'){
            	$order_id = $information[1];
            }elseif($information[0] == 'order_status'){
            	$order_status = $information[1];
            }elseif($information[0] == 'tracking_id'){
            	$tracking_id = $information[1];
            }elseif($information[0] == 'bank_ref_no'){
            	$bank_ref_no = $information[1];
            }
        }
      
      	$this->orderconfirm($order_id,$order_status,$tracking_id,$bank_ref_no);
      	
        return redirect('/getorders');
    }

    public function encrypt($plainText,$key) {
        $key = $this->hextobin(md5($key));
        $initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
        $openMode = openssl_encrypt($plainText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $initVector);
        $encryptedText = bin2hex($openMode);
        return $encryptedText;
    }
    
    public function decrypt($encryptedText,$key) {
        $key = $this->hextobin(md5($key));
        $initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
        $encryptedText = $this->hextobin($encryptedText);
        $decryptedText = openssl_decrypt($encryptedText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $initVector);
        return $decryptedText;
    }

    public function hextobin($hexString) { 
        $length = strlen($hexString); 
        $binString="";   
        $count=0; 
        while($count<$length) 
        {       
            $subString =substr($hexString,$count,2);           
            $packedString = pack("H*",$subString); 
            if ($count==0)
            {
                $binString=$packedString;
            } 
            
            else 
            {
                $binString.=$packedString;
            } 
            
            $count+=2; 
        } 
            return $binString; 
    }
    
    public function orderconfirm($order_id,$order_status,$tracking_id,$bank_ref_no){
      	
      	if($order_status==="Success")
        {
            $orderdetails = ordertemp::where('order_no',$order_id)->first();

            $neworder = new order;
            $neworder->order_no = $orderdetails->order_no;
            $neworder->user_id = $orderdetails->user_id;
            $neworder->name = $orderdetails->name;
            $neworder->mobile = $orderdetails->mobile;
            $neworder->address = $orderdetails->address;
            $neworder->city = $orderdetails->city;
            $neworder->state = $orderdetails->state;
            $neworder->pin = $orderdetails->pin;
            $neworder->landmark = $orderdetails->landmark;
            $neworder->payment_mode = $orderdetails->payment_mode;
            $neworder->price = $orderdetails->price;
          	$neworder->tracking_id = $tracking_id;
          	$neworder->bank_ref_no = $bank_ref_no;

            $neworder->save();
          
          	
          	$data=user::where('user_id',$orderdetails->user_id)->first();
          
          	Session()->put('userid', $data->user_id);
            Session()->put('username', $data->f_name);

            if ($orderdetails->directorder == 0) {
                cart::where('user_id',session('userid'))->where('delete_flag',0)->update(['delete_flag' => 1]);
            }
          
          	$cart_list = cart::where('user_id',session('userid'))->where('delete_flag',0)->get();

            foreach ($cart_list as $item) {
                $cart = [
                    'product_id' => $item->product_id,
                    'product_type_id' => $item->product_type_id,
                    'quantity' => $item->quantity,
                ];
                Session()->push('cart', $cart);
            }
            
        }
        else if($order_status==="Aborted")
        {
            echo "<br>Thank you for shopping with us.We will keep you posted regarding the status of your order through e-mail";
        
        }
        else if($order_status==="Failure")
        {
            echo "<br>Thank you for shopping with us.However,the transaction has been declined.";
        }
        else
        {
            echo "<br>Security Error. Illegal access detected";
        
        }
        
    }

    public function review($order_detail_id){
        return view('reviewpage')->with('order_detail_id',$order_detail_id);
    }

    public function reviewsubmit(Request $req){
        
        $oID = Crypt::decrypt($req->order_detail_id);

        orderdetail::where('orderDetail_id',$oID)
                    ->update(['review_status' => 1]);

        $order = orderdetail::where('orderDetail_id',$oID)->first();

        $newreview = new review;
        $newreview->user_id = session('userid');
        $newreview->orderDetail_id = $oID;
        $newreview->product_id = $order->product_id;
        $newreview->review = $req->review;
        $newreview->rating = $req->rating;
        $newreview->approved = 0;
        $newreview->delete_flag = 0;
        $newreview->save();

        $lastID = review::where('orderDetail_id',$oID)->latest()->first();

        if ($req->hasFile('review_image')) {

            $destinationPath = 'imageUploads';

            foreach($req->file('review_image') as $image) {
                
                $newimage= new reviewimage;

                
                $random_num = mt_rand(100,999);
                $reviewImage = "R".date('YmdHis') .$random_num."." . $image->extension();
                $image->move(public_path($destinationPath), $reviewImage);

                $newimage->review_id = $lastID->review_id;
                $newimage->review_img = $reviewImage;
                $newimage->delete_flag = 0;

                $newimage->save();
            }
        }
        return redirect('/getorders');

    }

    public static function getRating($product_id){
        
        $rating = review::where('product_id',$product_id)
                        ->where('approved',1)
                        ->avg('rating');
        return intval($rating);
    }

    public function contactformsubmit(Request $req){
        
        $name = $req->user_name;
        $email = $req->user_email;
        $message = $req->user_message;

        require base_path("vendor/autoload.php");
      	
        $mail = new PHPMailer(true);
        $mail->SMTPDebug = 0;                                      
        $mail->isSMTP();
        $mail->Host       = env('MAIL_HOST');                        
        $mail->SMTPAuth   = true;                                  
        $mail->Username   = env('MAIL_ID');                  
        $mail->Password   = env('MAIL_PASS');                             
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
        $mail->Port       = 587;
        $mail->setFrom(env('MAIL_ID'),env('APP_NAME')); 
        $mail->addAddress('saikatf2021@gmail.com');
        $mail->isHTML(false);
        $mail->Subject =  'Contact Form Submission';
        $mail->Body    = 'Name : '.$name.'. Email : '.$email.'. Message : '.$message;
        $dt = $mail->send();

        return back()->with('message', 'Success');
    }

}
