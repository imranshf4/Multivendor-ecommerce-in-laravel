<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Contact;
use App\Models\MultiImage;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Parser\Multiple;

class IndexController extends Controller
{
    public function Index()
    {
        $skip_category_0 = Category::skip(0)->first();
        $skip_product_0 = Product::where('status', 1)->where('category_id', $skip_category_0->id)->orderBy('id', 'ASC')->limit(5)->get();
        //dd($skip_category_0);
        //dd($skip_product_0);

        $skip_category_2 = Category::skip(2)->first();
        $skip_product_2 = Product::where('status', 1)->where('category_id', $skip_category_2->id)->orderBy('id', 'ASC')->limit(5)->get();

        $skip_category_1 = Category::skip(1)->first();
        $skip_product_1 = Product::where('status', 1)->where('category_id', $skip_category_1->id)->orderBy('id', 'ASC')->limit(5)->get();

        $hot_deals = Product::where('hot_deals', 1)->where('discount_price', '!=', NULL)->orderBy('id', 'ASC')->limit(3)->get();

        $special_offer = Product::where('special_offer', 1)->where('discount_price', '!=', NULL)->orderBy('id', 'ASC')->limit(3)->get();

        $special_deals = Product::where('special_deals', 1)->orderBy('id', 'ASC')->limit(3)->get();

        $recently_added = Product::where('status', 1)->orderBy('id', 'ASC')->limit(3)->latest()->get();

        return view('frontend.index', compact('skip_category_0', 'skip_product_0', 'skip_category_2', 'skip_product_2', 'skip_category_1', 'skip_product_1', 'hot_deals', 'special_offer', 'special_deals', 'recently_added'));
    } // End Method 

    public function ProductDetails($id, $slug)
    {
        $product = Product::findOrFail($id);

        $color = $product->product_color;
        $product_color = explode(',', $color);

        $size = $product->product_size;
        $product_size = explode(',', $size);

        $category_id = $product->category_id;
        $relatedProduct = Product::where('category_id', $category_id)->where('id', '!=', $id)->orderBy('id', 'ASC')->limit(4)->get();

        $multiImage = MultiImage::where('product_id', $id)->get();
        return view('frontend.product.product_details', compact('product', 'product_color', 'product_size', 'multiImage', 'relatedProduct'));
    } // End Method 

    public function vendorDetails($id)
    {
        $vendor = User::findOrFail($id);
        $vProduct = Product::where('vendor_id', $id)->paginate(15);
        return view('frontend.vendor.vendor_details', compact('vendor', 'vProduct'));
    } // End Method 

    public function AllVendor()
    {
        $vendors = User::where('status', 'active')->where('role', 'vendor')->paginate(8);
        //$allvendor = User::where('status','active')->where('role','vendor')->latest()->paginate(3);
        return view('frontend.vendor.all_vendor', compact('vendors'));
    } // End Method 

    public function CatWiseProduct(Request $request, $id, $slug)
    {
        $products = Product::where('status', 1)->where('category_id', $id)->orderBy('id', 'ASC')->paginate(15);
        $categories = Category::orderBy('category_name', 'ASC')->get();
        $breadcat = Category::where('id', $id)->first();
        $newProduct = Product::orderBy('id', 'DESC')->limit(3)->get();
        return view('frontend.product.category_product', compact('products', 'categories', 'breadcat', 'newProduct'));
    } // End Method 

    public function SubCatWiseProduct(Request $request, $id, $slug)
    {
        $products = Product::where('status', 1)->where('subcategory_id', $id)->orderBy('id', 'ASC')->paginate(15);
        $subcategories = SubCategory::orderBy('subcategory_name', 'ASC')->get();
        $categories = Category::orderBy('category_name', 'ASC')->get();
        $breadsubcat = SubCategory::where('id', $id)->first();
        $newProduct = Product::orderBy('id', 'DESC')->limit(3)->get();
        return view('frontend.product.sub_category_product', compact('products', 'subcategories', 'breadsubcat', 'newProduct', 'categories'));
    } // End Method 

    public function ProductViewAjax($id)
    {
        $product = Product::with('category', 'brand')->findOrFail($id);

        $color = $product->product_color;
        $product_color = explode(',', $color);

        $size = $product->product_size;
        $product_size = explode(',', $size);

        return response()->json(array(
            'product' => $product,
            'color' => $product_color,
            'size' => $product_size,
        ));
    } // End Method 

    public function ProductSearch(Request $request)
    {
        $request->validate(['search' => "required"]);

        $item = $request->search;
        $categories = Category::orderBy('category_name', 'ASC')->get();
        $products = Product::where('product_name', 'LIKE', "%$item%")->get();
        $newProduct = Product::orderBy('id', 'DESC')->limit(3)->get();
        return view('frontend.product.search', compact('products', 'item', 'categories', 'newProduct'));
    } // End Method 

    public function ContactUs(){
        return view('frontend.contact.contact');
    }//End Method

    public function ContactStore(Request $request){

        $id = Auth::user()->id;

        Contact::insert([
            'name' => $request->name,
            'user_id' => $id,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'subject' => $request->subject,
            'message' => $request->message,
            'created_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Contact Added Successfully',
            'alert-type' => 'success'
        );

        return redirect()->to('/')->with($notification);
    }//End Method

    public function PendingContact(){
        $penContact = Contact::where('status',0)->get();
        return view('backend.contact.pending_contact',compact('penContact'));
    }//End Method

    public function AcceptedContact($id){
        Contact::findOrFail($id)->update([
            'status' => 1
        ]);
        $notification = array(
            'message' => 'Contact Accepted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }//End Method

    public function AllAcceptedContact(){
        $acceptContact = Contact::where('status',1)->get();
        return view('backend.contact.accepted_contact',compact('acceptContact'));
    }//End Method

    public function DeleteContact($id){
        Contact::findOrFail($id)->delete();
        $notification = array(
            'message' => 'Contact Deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }//End Method


}
