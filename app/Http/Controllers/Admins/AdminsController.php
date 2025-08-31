<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\Admin\Admin;
use App\Models\Product\Booking;
use App\Models\Product\Order;
use App\Models\Product\Product;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class AdminsController extends Controller
{
    public function viewLogin(){
        return view('admins.login');
    }

    public function checkLogin(Request $request){
        $remember_me = $request->has('remember_me') ? true : false;

        if (auth()->guard('admin')->attempt(['email' => $request->input("email"), 'password' => $request->input("password")], $remember_me)) {

            return redirect() -> route('admins.dashboard');
        }
        return redirect()->back()->with(['error' => 'error logging in']);
    }

    public function index(){
        $productsCount = Product::select()->count();
        $ordersCount = Order::select()->count();
        $bookingsCount = Booking::select()->count();
        $adminsCount = Admin::select()->count();

    return view('admins.index' , compact('productsCount' , 'ordersCount',
    'bookingsCount' , 'adminsCount'));
    }

    public function DisplayAllAdmins(){
        $allAdmins = Admin::select()->orderBy('id' , 'desc')->get();

        return view('admins.show' , compact('allAdmins'));
    }

    public function createAdmins(){
        return view('admins.create');
    }

    public function storeAdmins(Request $request){
        Request()->validate([
            "name"=>"required|max:40",
            "email"=>"required|max:40",
            "password"=>"required|max:40"
        ]);
        $storeAdmins = Admin::Create([
            "name"=>$request->username,
            "email" =>$request->email ,
            "password"=>Hash::make($request->password)
        ]);
        if($storeAdmins){
             return Redirect::route('all.admins')->with(['success'=>"admin created successfully"]);
        }
    }
    public function DisplayAllOrders(){

        $allOrders = Order::select()->orderBy('id' , 'desc')->get();

        return view('admins.allorders' , compact('allOrders'));
    }

    public function editOrder($id){
        $order = Order::find($id);
        return view('admins.editorder' , compact('order'));
    }

    public function updateOrder(Request $request , $id){
        $order = Order::find($id);
        $order->update($request->all());
        if($order){
         return Redirect::route('all.orders')->with(['update'=>"Order#".$order->id.": Status Changed successfully"]);
        }
    }
    public function deleteOrder($id){
        $order = Order::find($id);
        $order->delete();
        if($order)
         return Redirect::route('all.orders')->with(['delete'=>"Order#".$order->id.": Deleted successfully"]);
    }

}
