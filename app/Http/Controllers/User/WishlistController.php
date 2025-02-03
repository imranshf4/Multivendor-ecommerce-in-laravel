<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function AddToWishlist(Request $request, $product_id)
    {
        if (Auth::check()) {
            $exists = Wishlist::where('user_id', Auth::id())->where('product_id', $product_id)->first();
            if (!$exists) {
                Wishlist::insert([
                    'user_id' => Auth::id(),
                    'product_id' => $product_id,
                    'created_at' => Carbon::now(),
                ]);
                return response()->json(['success' => 'Successfully added on your Wishlist']);
            } else {
                return response()->json(['error' => 'This Product is already added on your Wishlist']);
            }
        } else {
            return response()->json(['error' => 'At first Login your Account.']);
        }
    } //end method

    public function AllWishlist()
    {
        return view('frontend.wishlist.view_wishlist');
    } //end method

    public function GetWishlistProduct()
    {

        $wishlist = Wishlist::with('product')->where('user_id', Auth::id())->latest()->get();

        $wishQty = $wishlist->count();

        return response()->json(['wishlist' => $wishlist, 'wishQty' => $wishQty]);
    } // End Method

    public function WishlistRemove($id)
    {
        Wishlist::where('user_id', Auth::id())->where('id', $id)->delete();
        return response()->json(['success' => 'Successfully Product Remove']);
    } // End Method
}
