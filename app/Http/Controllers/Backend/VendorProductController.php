<?php

namespace App\Http\Controllers\Backend;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\MultiImage;
use App\Models\SubCategory;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendorProductController extends Controller
{
    public function VendorAllProduct(){

        $id = Auth::user()->id;
        $products = Product::where('vendor_id',$id)->latest()->get();
        return view('vendor.backend.product.vendor_all_product',compact('products'));
    } // End Method

    public function VendorAddProcuct()
    {
        $brands = Brand::orderBy('id', 'ASC')->latest()->get();
        $categories = Category::orderBy('id', 'ASC')->latest()->get();

        return view('vendor.backend.product.vendor_add_product', compact('brands', 'categories'));
    } //End Method

    public function VendorGetSubCategory($category_id){
        $subcat = SubCategory::where('category_id',$category_id)->orderBy('category_id','ASC')->latest()->get();
        return json_encode($subcat);
    }//End Method

    public function VendorStoreProcuct(Request $request)
    {
        $takeImg = $request->file('product_thambnail');

        $manager = new ImageManager(new Driver());
        $image = $manager->read($takeImg);
        $name_gen = hexdec(uniqid()) . '.' . $takeImg->getClientOriginalExtension();
        $image = $image->resize(800, 800);

        $image->toJpeg(80)->save(base_path('public/upload/products/thambnail/' . $name_gen));
        $save_url = 'upload/products/thambnail/' . $name_gen;

        $product_id = Product::insertGetId([

            'brand_id' => $request->brand_id,
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'product_name' => $request->product_name,
            'product_slug' => strtolower(str_replace(' ', '-', $request->product_name)),

            'product_code' => $request->product_code,
            'product_qty' => $request->product_qty,
            'product_tags' => $request->product_tags,
            'product_size' => $request->product_size,
            'product_color' => $request->product_color,

            'selling_price' => $request->selling_price,
            'discount_price' => $request->discount_price,
            'short_descp' => $request->short_descp,
            'long_descp' => $request->long_descp,

            'hot_deals' => $request->hot_deals,
            'featured' => $request->featured,
            'special_offer' => $request->special_offer,
            'special_deals' => $request->special_deals,

            'product_thambnail' => $save_url,
            'vendor_id' => Auth::user()->id,
            'status' => 1,
            'created_at' => Carbon::now(),

        ]);

        // Multiple Image Upload From her //////
        $images = $request->file('multi_img');
        foreach ($images as $takeImg) {
            $manager = new ImageManager(new Driver());
            $img = $manager->read($takeImg);
            $makeName = hexdec(uniqid()) . '.' . $takeImg->getClientOriginalExtension();
            $img = $img->resize(800, 800);

            $img->toJpeg(80)->save(base_path('public/upload/products/multi_imgs/' . $makeName));
            $uploadPath = 'upload/products/multi_imgs/' . $makeName;

            MultiImage::insert([
                'product_id' => $product_id,
                'photo_name' => $uploadPath,
                'created_at' => Carbon::now(),
            ]);
        } //End Multiple Image Upload From her //////

        $notification = array(
            'message' => 'Vendor Product Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('vendor.all.product')->with($notification);
    } //End Method

    public function VendorEditProduct($id)
    {
        $multiImages = MultiImage::where('product_id', $id)->get();
        $subcategory = SubCategory::latest()->get();
        $brands = Brand::latest()->get();
        $categories = Category::latest()->get();
        $subcategory = SubCategory::latest()->get();
        $products = Product::findOrFail($id);
        return view('vendor.backend.product.vendor_edit_product', compact('multiImages', 'brands', 'categories', 'products', 'subcategory'));
    } // End Method 

    public function VendorUpdateProduct(Request $request)
    {
        $product_id = $request->id;
        Product::findOrFail($product_id)->update([

            'brand_id' => $request->brand_id,
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'product_name' => $request->product_name,
            'product_slug' => strtolower(str_replace(' ', '-', $request->product_name)),

            'product_code' => $request->product_code,
            'product_qty' => $request->product_qty,
            'product_tags' => $request->product_tags,
            'product_size' => $request->product_size,
            'product_color' => $request->product_color,

            'selling_price' => $request->selling_price,
            'discount_price' => $request->discount_price,
            'short_descp' => $request->short_descp,
            'long_descp' => $request->long_descp,

            'hot_deals' => $request->hot_deals,
            'featured' => $request->featured,
            'special_offer' => $request->special_offer,
            'special_deals' => $request->special_deals,

            'status' => 1,
            'created_at' => Carbon::now(),

        ]);


        $notification = array(
            'message' => 'Vendor Product Updated Without Image Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('vendor.all.product')->with($notification);
    } // End Method 

    public function VendorUpdateProductImage(Request $request)
    {

        $product_id = $request->id;
        $old_img = $request->old_img;


        $takeImg = $request->file('product_thambnail');

        $manager = new ImageManager(new Driver());
        $image = $manager->read($takeImg);
        $name_gen = hexdec(uniqid()) . '.' . $takeImg->getClientOriginalExtension();
        $image = $image->resize(800, 800);

        $image->toJpeg(80)->save(base_path('public/upload/products/thambnail/' . $name_gen));
        $save_url = 'upload/products/thambnail/' . $name_gen;

        if (file_exists($old_img)) {
            @unlink($old_img);
        }

        Product::findOrFail($product_id)->update([
            'product_thambnail' => $save_url,
            'updated_at' => Carbon::now(),
        ]);


        $notification = array(
            'message' => 'Vendor Product Image Thumbnail Updated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    } // End Method 

    public function VendorUpdateProductMultitImage(Request $request)
    {
        $imgs = $request->multi_img;

        foreach ($imgs as $id => $image) {
            $delImg = MultiImage::findOrFail($id);
            unlink($delImg->photo_name);

            // Multiple Image Upload From her //////
            $images = $request->file('multi_img');
            foreach ($images as $takeImg) {
                $manager = new ImageManager(new Driver());
                $img = $manager->read($takeImg);
                $makeName = hexdec(uniqid()) . '.' . $takeImg->getClientOriginalExtension();
                $img = $img->resize(800, 800);

                $img->toJpeg(80)->save(base_path('public/upload/products/multi_imgs/' . $makeName));
                $uploadPath = 'upload/products/multi_imgs/' . $makeName;

                MultiImage::where('id', $id)->update([
                    'photo_name' => $uploadPath,
                    'updated_at' => Carbon::now(),
                ]);
            } //End Multiple Image Upload From her //////
        } //End Foraeach

        $notification = array(
            'message' => 'Vendor Product MultiImage Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    } // End Method 

    public function VendorDeleteProcuct($id)
    {
        $product = Product::findOrFail($id);
        unlink($product->product_thambnail);
        Product::findOrFail($id)->delete();

        $oldImages = MultiImage::where('product_id',$id)->get();
        foreach($oldImages as $oldImage){
            unlink($oldImage->photo_name);
        }
        
        MultiImage::where('product_id',$id)->delete();

        $notification = array(
            'message' => 'Vendor Product Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function VendorDeleteProductMultitImage($id)
    {
        $oldImage = MultiImage::findOrFail($id);

        @unlink($oldImage->photo_name);
        MultiImage::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Vendor Product MultiImage Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    } // End Method 

    public function VendorInactiveProduct($id)
    {
        Product::findOrFail($id)->update([
            'status' => 0
        ]);
        $notification = array(
            'message' => 'Vendor Product Inactive Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    } // End Method 

    public function VendorActiveProduct($id)
    {
        Product::findOrFail($id)->update([
            'status' => 1
        ]);
        $notification = array(
            'message' => 'Vendor Product Active Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    } // End Method 
}
