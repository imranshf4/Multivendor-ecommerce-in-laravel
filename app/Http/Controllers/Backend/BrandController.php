<?php

namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function AllBrand(){
        $brands = Brand::latest()->get(); 
        return view('backend.brand.all_brand',compact('brands'));
    }//End Method

    public function AddBrand(){
        return view('backend.brand.add_brand');
    }//End Method

    public function StoreBrand(Request $request){
        $image = $request->file('brand_image');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        //Image::make($image)->resize(300.300)->save('upload/brand/'.$name_gen);
        $image_url = 'upload/brand/'.$name_gen;
        $image->move(public_path('upload/brand/'),$name_gen);
        Brand::insert([
            'brand_name' => $request->brand_name,
            'brand_slug' => strtolower(str_replace(' ','-',$request->brand_name)),
            'brand_image' => $image_url,
        ]);

        $notification = array(
            'message' => 'Brand Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.brand')->with($notification);
        
    }//End Method

    public function EditBrand($id){
        $brands = Brand::findOrFail($id);
        return view('backend.brand.edit_brand',compact('brands'));
    }

    public function UpdateBrand(Request $request){
        $brand_id = $request->id;
        $old_image = $request->old_image;

        if($request->file('brand_image')){
            $image = $request->file('brand_image');
            
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            //Image::make($image)->resize(300.300)->save('upload/brand/'.$name_gen);
            $image_url = 'upload/brand/'.$name_gen;
            $image->move(public_path('upload/brand/'),$name_gen);

            if(file_exists($old_image)){
                unlink($old_image);
            }

            Brand::findOrFail($brand_id)->update([
                'brand_name' => $request->brand_name,
                'brand_slug' => strtolower(str_replace(' ','-',$request->brand_name)),
                'brand_image' => $image_url,
            ]);
    
            $notification = array(
                'message' => 'Brand with Image Updated Successfully',
                'alert-type' => 'success'
            );
    
            return redirect()->route('all.brand')->with($notification);
        }else{

            Brand::findOrFail($brand_id)->update([
                'brand_name' => $request->brand_name,
                'brand_slug' => strtolower(str_replace(' ','-',$request->brand_name)),
            ]);
    
            $notification = array(
                'message' => 'Brand without Image Updated Successfully',
                'alert-type' => 'success'
            );
    
            return redirect()->route('all.brand')->with($notification);
        }//End else

        
    }//End Method

    public function DeleteBrand($id){
        $brand = Brand::findOrFail($id);
        $img = $brand->brand_image;
        unlink($img);

        Brand::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Brand Delete Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }//End Method
}
