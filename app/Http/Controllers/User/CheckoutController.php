<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ShipDistrict;
use App\Models\ShipState;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function DistrictGetAjax($division_id)
    {
        $ship = ShipDistrict::where('division_id', $division_id)->orderBy('district_name', 'ASC')->get();
        return json_encode($ship);
    } // End Method 

    public function StateGetAjax($district_id)
    {
        $ship = ShipState::where('district_id', $district_id)->orderBy('state_name', 'ASC')->get();
        return json_encode($ship);
    } // End Method 

    public function CheckoutStore(Request $request){
        $data = array();
        $data['shipping_name'] = $request->shipping_name;
        $data['shipping_email'] = $request->shipping_email;
        $data['shipping_phone'] = $request->shipping_phone;
        $data['post_code'] = $request->post_code;   

        $data['division_id'] = $request->division_id;
        $data['district_id'] = $request->district_id;
        $data['state_id'] = $request->state_id;
        $data['shipping_address'] = $request->shipping_address;
        $data['notes'] = $request->notes; 
        $data['transaction_id'] = $request->transaction_id; 
        $data['shipping_cost'] = $request->shipping_cost; 
        $cartTotal = Cart::total() + $request->shipping_cost;

        if ($request->payment_option == 'bkash') {
            return view('frontend.payment.bkash',compact('data','cartTotal'));
         }elseif ($request->payment_option == 'rocket'){
             return 'rocket Page';
         }else{
             return view('frontend.payment.cash',compact('data','cartTotal'));
         }
    }// End Method 

    
}
