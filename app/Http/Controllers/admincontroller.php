<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\category;
use App\Models\color;
use App\Models\polish;
use App\Models\collection;
use App\Models\product;
use App\Models\productimg;
use App\Models\producttype;
use App\Models\productcol;
use App\Models\user;
use App\Models\order;
use App\Models\orderdetail;
use App\Models\coupon;
use App\Models\review;
use App\Models\size;

use Carbon\Carbon;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;


class admincontroller extends Controller
{
    public function managedashboard(){
        $orders = order::take(5)->get();
        $ordercount = order::all()->count();
        $ordersum = order::all()->sum('price');
        
        $todayordersum = order::whereDate('created_at', Carbon::today())
                        ->sum('price');
        $todayordercount = order::whereDate('created_at', Carbon::today())
                        ->count();
        return view('admin.dashboard')->with('recentsales',$orders)->with('ordercount',$ordercount)->with('ordersum',$ordersum)->with('todayordercount',$todayordercount)->with('todayordersum',$todayordersum);
    }
    
    public function adminlogin(Request $req){
        $req->validate([
            'admin_email' => 'required | email',
            'admin_password'=> 'required | min:8'
        ]);

        $data=user::where('email',$req->admin_email)->where('user_type',1)->first();


        if(empty($data)){
            return back()->with('adminloginmessage', 'Wrong Email or Password');
        }

        if(Hash::check($req->admin_password, $data->password)){
            $req->session()->put('adminid', $data->user_id);
            $req->session()->put('adminname', $data->f_name);
            return redirect('/adminpanel');
        }
        else{
            return back()->with('adminloginmessage', 'Wrong Email or Password');
        }
    }

    public function showCategories(){
        $categories = category::where('delete_flag',0)->get();
        return view('admin.categories')->with('categories',$categories);
    }

    public function addCategory(Request $req){
        $item= new category;

        $item->category_name = $req->category_name;

        $destinationPath = 'imageUploads';
        $categoryImage = date('YmdHis') . "." . $req->category_image->extension();
        $req->category_image->move(public_path($destinationPath), $categoryImage);
            
      	if (isset($req->homescreen)) {
            $item->homescreen = 1;
        } else {
            $item->homescreen = 0;
        }
        
        $item->category_img = $categoryImage;
        $item->delete_flag = 0;

        $item->save();

        return redirect('/adminpanel/managecategories');
    }

    public function deleteCategory($category_id){

        category::where('category_id', $category_id)
                ->update(['delete_flag' => 1]);

        return redirect('/adminpanel/managecategories');
    }

    public function gotoeditCategory($category_id){
        $category = category::where('category_id', $category_id)
                ->first();
        return view('admin.editcategory')->with('category',$category);
    }

    public function editCategory(Request $req){

      	if (isset($req->homescreen)) {
            $homescreen = 1;
        } else {
            $homescreen = 0;
        }
      
        if ($req->category_image == NULL) {
            category::where('category_id',$req->category_id)
                        ->update([
                          	'category_name' => $req->category_name,
                            'homescreen'    => $homescreen
                          ]);
        }else{
            $destinationPath = 'imageUploads';
            $categoryImage = date('YmdHis') . "." . $req->category_image->extension();
            $req->category_image->move(public_path($destinationPath), $categoryImage);

            category::where('category_id',$req->category_id)
                        ->update(['category_name' => $req->category_name,
                                  'category_img' => $categoryImage
                                ]);
        }

        return redirect('/adminpanel/managecategories');
    }

    public function showProducts(){
        $products = product::where('delete_flag',0)->get();
        return view('admin.products')->with('products',$products);
    }

    public function getDataAddproduct(){
        $categories = category::where('delete_flag',0)->get();
        $colors = color::where('delete_flag',0)->get();
        $polishes = polish::where('delete_flag',0)->get();
        $collections = collection::where('delete_flag',0)->get();
        $sizes = size::where('delete_flag',0)->get();
        return view('admin.addproduct')->with('categories',$categories)
                                        ->with('colors',$colors)
                                        ->with('polishes',$polishes)
                                        ->with('collections',$collections)
                                        ->with('sizes',$sizes);
    }

    public function addProduct(Request $req){
        $item= new product;
        $item->product_name = $req->product_name;
        $item->description = $req->description;
        $item->category_id = $req->product_category;
        $item->price = $req->price;
        $item->discount = $req->discount;
        $item->popularity = 0;
        $item->del_days_min = $req->del_days_min;
        $item->del_days_max = $req->del_days_max;

        if (isset($req->del_charges)) {
            $item->delivery_charges = 1;
        } else {
            $item->delivery_charges = 0;
        }
        
        $item->delete_flag = 0;

        $item->save();

        
        $lastID = product::where('product_name',$req->product_name)->latest()->first();

        foreach ($req->color as $key => $value) {
            $item = new producttype;

            $item->product_id = $lastID->product_id;
            $item->product_color = $value;
            $item->product_polish = $req->polish[$key];
            $item->product_size = $req->size[$key];
            $item->quantity = $req->quantity[$key];
            $item->delete_flag = 0;

            $item->save();

        }
        if ($req->collection != NULL) {
            foreach ($req->collection as $value) {

                $item = new productcol;
    
                $item->product_id = $lastID->product_id;
                $item->collection_id = $value;
                $item->delete_flag = 0;
    
                $item->save();
    
            }
        }
        

        if ($req->hasFile('product_image')) {

            $destinationPath = 'imageUploads';

            foreach($req->file('product_image') as $image) {
                
                $newimage= new productimg;

                
                $random_num = mt_rand(100,999);
                $productImage = date('YmdHis') .$random_num."." . $image->extension();
                $image->move(public_path($destinationPath), $productImage);

                $newimage->product_id = $lastID->product_id;
                $newimage->product_img = $productImage;
                $newimage->delete_flag = 0;

                $newimage->save();
            }
        }

        return redirect('/adminpanel/manageproducts');
    }

    public function deleteProduct($product_id){

        product::where('product_id', $product_id)
                ->update(['delete_flag' => 1]);

        return redirect('/adminpanel/manageproducts');
    }
    
    public function gotoeditProduct($product_id){
        $product = product::where('product_id', $product_id)
                ->first();
        
        $categories = category::where('delete_flag',0)->get();
        $colors = color::where('delete_flag',0)->get();
        $polishes = polish::where('delete_flag',0)->get();
        $collections = collection::where('delete_flag',0)->get();
        $sizes = size::where('delete_flag',0)->get();
        return view('admin.editproduct')->with('product',$product)
                                        ->with('categories',$categories)
                                        ->with('colors',$colors)
                                        ->with('polishes',$polishes)
                                        ->with('collections',$collections)
                                        ->with('sizes',$sizes);
    }

    public function editProduct(Request $req){

        if (isset($req->del_charges)) {
            $delivery_charges = 1;
        } else {
            $delivery_charges = 0;
        }

        product::where('product_id',$req->product_id)
                    ->update(['product_name' => $req->product_name,
                                'description' => $req->description,
                                'category_id' => $req->product_category,
                                'price' => $req->price,
                                'discount' => $req->discount,
                                'del_days_min' => $req->del_days_min,
                                'del_days_max' => $req->del_days_max,
                                'delivery_charges' => $delivery_charges
                            ]);
        
        foreach ($req->color as $key => $value) {
            
            $oldproduct = producttype::where('product_id',$req->product_id)
                                     ->where('product_color',$value)
                                     ->where('product_polish',$req->polish[$key])
                                     ->where('product_size',$req->size[$key])
                                     ->where('delete_flag',0)
                                     ->first();
            if(!$oldproduct){
                $item = new producttype;

                $item->product_id = $req->product_id;
                $item->product_color = $value;
                $item->product_polish = $req->polish[$key];
                $item->product_size = $req->size[$key];
                $item->quantity = $req->quantity[$key];
                $item->delete_flag = 0;

                $item->save();
            } else{
                $oldquantity = $oldproduct->quantity;
                $newquantity = $oldquantity + $req->quantity[$key];
                producttype::where('product_id',$req->product_id)
                                     ->where('product_color',$value)
                                     ->where('product_polish',$req->polish[$key])
                                     ->where('product_size',$req->size[$key])
                                     ->where('delete_flag',0)
                                     ->update(['quantity' => $newquantity]);
            }
        }
      
        productcol::where('product_id',$req->product_id)->delete();

        if ($req->collection != NULL) {
            foreach ($req->collection as $value) {

                $item = new productcol;
    
                $item->product_id = $req->product_id;
                $item->collection_id = $value;
                $item->delete_flag = 0;
    
                $item->save();
    
            }
        }
        if ($req->hasFile('product_image')) {

            $destinationPath = 'imageUploads';

            foreach($req->file('product_image') as $image) {
                
                $newimage= new productimg;

                
                $random_num = mt_rand(100,999);
                $productImage = date('YmdHis') .$random_num."." . $image->extension();
                $image->move(public_path($destinationPath), $productImage);

                $newimage->product_id = $req->product_id;
                $newimage->product_img = $productImage;
                $newimage->delete_flag = 0;

                $newimage->save();
            }
        }
        

        return redirect('/adminpanel/manageproducts');
    }

    public function removeProductImage($product_img_id){

        productimg::where('product_img_id', $product_img_id)
                ->update(['delete_flag' => 1]);

        return back();
    }

    public function removeProductType($product_type_id){

        producttype::where('product_type_id', $product_type_id)
                ->update(['delete_flag' => 1]);

        return back();
    }

    public function manageorders(){
        $orders = order::get();
        return view('admin.orders')->with('orders',$orders);
    }

    public function getorderdetail($order_no){
        $orderdetails = orderdetail::where('order_no',$order_no)->get();
        return view('admin.orderdetail')->with('orderdetails',$orderdetails);
    }

    public function changeorderstatus($orderdetail_id){

        $order = orderdetail::where('orderDetail_id', $orderdetail_id)->first();
        
        $orderstatus = $order->order_status;
        if ($orderstatus == 1) {
            $neworderstatus = 0;
        } else {
            $neworderstatus = 1;
        }
        
        $order = orderdetail::where('orderDetail_id', $orderdetail_id)->update(['order_status' => $neworderstatus]);

        return back();
    }

    public function showCoupons(){
        $coupons = coupon::where('delete_flag',0)->get();
        return view('admin.coupons')->with('coupons',$coupons);
    }

    public function addCoupon(Request $req){
        $item= new coupon;

        $item->coupon_code = $req->coupon_code;
        
        $item->discount = $req->discount;
        $item->delete_flag = 0;

        $item->save();

        return redirect('/adminpanel/managecoupons');
    }

    public function deleteCoupon($coupon_id){

        coupon::where('coupon_id', $coupon_id)
                ->update(['delete_flag' => 1]);

        return redirect('/adminpanel/managecoupons');
    }

    public function gotoeditCoupon($coupon_id){
        $coupon = coupon::where('coupon_id', $coupon_id)
                ->first();
        return view('admin.editcoupon')->with('coupon',$coupon);
    }

    public function editCoupon(Request $req){

        coupon::where('coupon_id',$req->coupon_id)
                    ->update(['coupon_code' => $req->coupon_code,
                                'discount' =>  $req->discount
                            ]);

        return redirect('/adminpanel/managecoupons');
    }

    public function showReviews(){
        $reviews = review::where('delete_flag',0)->get();
        return view('admin.reviews')->with('reviews',$reviews);
    }

    public function changeapprovalstatus($review_id){

        $review = review::where('review_id', $review_id)->first();
        
        $reviewstatus = $review->approved;
        if ($reviewstatus == 1) {
            $newreviewstatus = 0;
        } else {
            $newreviewstatus = 1;
        }
        
        review::where('review_id', $review_id)->update(['approved' => $newreviewstatus]);

        return back();
    }

    public function showColors(){
        $colors = color::where('delete_flag',0)->get();
        return view('admin.colors')->with('colors',$colors);
    }

    public function addColor(Request $req){
        $item = new color;

        $item->color = $req->color;
        $item->delete_flag = 0;

        $item->save();

        return redirect('/adminpanel/managecolors');
    }

    public function gotoeditColor($color_id){
        $color = color::where('color_id', $color_id)
                ->first();
        return view('admin.editcolor')->with('color',$color);
    }

    public function editColor(Request $req){

        color::where('color_id',$req->color_id)
                    ->update(['color' => $req->color]);

        return redirect('/adminpanel/managecolors');
    }

  	public function deleteColor($color_id){

        color::where('color_id', $color_id)
                ->update(['delete_flag' => 1]);

        return redirect('/adminpanel/managecolors');
    }
  
    public function showPolishes(){
        $polishes = polish::where('delete_flag',0)->get();
        return view('admin.polishes')->with('polishes',$polishes);
    }

    public function addPolish(Request $req){
        $item = new polish;

        $item->polish = $req->polish;
        $item->delete_flag = 0;

        $item->save();

        return redirect('/adminpanel/managepolishes');
    }
    
    public function gotoeditPolish($polish_id){
        $polish = polish::where('polish_id', $polish_id)
                ->first();
        return view('admin.editpolish')->with('polish',$polish);
    }

    public function editPolish(Request $req){

        polish::where('polish_id',$req->polish_id)
                    ->update(['polish' => $req->polish]);

        return redirect('/adminpanel/managepolishes');
    }

    public function showCollections(){
        $collections = collection::where('delete_flag',0)->get();
        return view('admin.collections')->with('collections',$collections);
    }

    public function addCollection(Request $req){
        $item = new collection;

        $item->collection = $req->collection;
        $item->delete_flag = 0;

        $item->save();

        return redirect('/adminpanel/managecollections');
    }
    
    public function gotoeditCollection($collection_id){
        $collection = collection::where('collection_id', $collection_id)
                ->first();
        return view('admin.editcollection')->with('collection',$collection);
    }

    public function editCollection(Request $req){

        collection::where('collection_id',$req->collection_id)
                    ->update(['collection' => $req->collection]);

        return redirect('/adminpanel/managecollections');
    }

    public function showSizes(){
        $sizes = size::where('delete_flag',0)->get();
        return view('admin.sizes')->with('sizes',$sizes);
    }

    public function addSize(Request $req){
        $item = new size;

        $item->size = $req->size;
        $item->delete_flag = 0;

        $item->save();

        return redirect('/adminpanel/managesizes');
    }

    public function gotoeditSize($size_id){
        $size = size::where('size_id', $size_id)
                ->first();
        return view('admin.editsize')->with('size',$size);
    }

    public function editSize(Request $req){

        size::where('size_id',$req->size_id)
                    ->update(['size' => $req->size]);

        return redirect('/adminpanel/managesizes');
    }
    
}
