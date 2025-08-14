<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Models\Product\Booking;
use App\Models\Product\Cart;
use App\Models\Product\Order;
use App\Models\Product\Product;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class ProductsController extends Controller
{

    public function singleProduct($id){
        $product = Product::find($id);

        $relatedProducts= Product::where('type' ,$product->type)
        ->where('id' , '!=' , $id)->take('4')
        ->orderBy('id' , 'desc')
        ->get();

        //checking for products in cart

        $checkingInCart=Cart::where('pro_id',$id)->where('user_id',Auth::user()->id)
        ->count();

        return view('products.productsingle',compact('product','relatedProducts' , 'checkingInCart'));
    }

    public function addCart(Request $request, $id) {
    $addCart = Cart::create([
        "pro_id" => $request->pro_id,
        "name" => $request->name,
        "image" => $request->image,
        "price" => $request->price,
        "user_id" => Auth::user()->id
    ]);


        return Redirect::route('product.single',$id)->with(['success'=>"product added to cart successfully"]);
    }

    public function cart(){
        $cartProducts=Cart::where('user_id',Auth::user()->id)
        ->orderBy('id','desc')->get();

        $totalPrice=Cart::where('user_id' , Auth::user()->id)
        ->sum('price');

        return view('products.cart',compact('cartProducts','totalPrice'));
    }

    public function deleteProductCart($id){
       $deleted = Cart::where('pro_id', $id)
        ->where('user_id', Auth::id())
        ->delete();

    $newTotal = Cart::where('user_id', Auth::id())->sum('price');


    if ($newTotal <= 0) {
        Session::forget('price');
    } else {
        Session::put('price', $newTotal);
    }

    if ($deleted) {
        return redirect()->route('cart')->with([
            'deleted' => "Product deleted from cart successfully"
        ]);
    } else {
        return redirect()->route('cart')->with([
            'error' => "Product not found or could not be deleted"
        ]);
    }
}

    public function prepareCheckout(Request $request) {
        $value = $request->price;

        Session::put('price', $value);

        $newPrice = Session::get('price');

        if ($newPrice > 0) {
            return Redirect::route('checkout');
        }
        else{
           return abort(403);
        }
    }

    public function checkout(){
        return view('products.checkout');
    }
   public function storeCheckout(Request $request) {
    $checkout = Order::create($request->all());

    echo "Welcome to paypal payment";

    }
    public function BookTables(Request $request) {

        Request()->validate([
        "first_name" => "required|max:40",
        "last_name" => "required|max:40",
        "date" => "required",
        "time" => "required",
        "phone" => "required|max:40",
        "message" => "required",
        ]);

    if ($request->date > date('n/j/Y')) {
        $bookTables = Booking::create($request->all());
    }
    if(isset($bookTables)){
        return Redirect::route('home')->with(['booking'=>"you booked a table successfully"]);
    }
    else {
        return Redirect::route('home')->with(['date' => "invalide date, choose a date in the future"]);
    }
}

    public function menu(){
        $desserts=Product::select()->where("type" , "desserts")->get();
        $drinks=Product::select()->where("type" , "drinks")->get();



        return view('products.menu' , compact('desserts','drinks'));
    }


}
