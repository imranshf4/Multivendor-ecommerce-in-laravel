<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function AllCategory(){
        $categorys = Category::orderBy('id','ASC')->latest()->get(); 
        return view('backend.category.all_category',compact('categorys'));
    }//End Method

    public function AddCategory(){
        return view('backend.category.add_category');
    }//End Method

    public function StoreCategory(Request $request){

        //print_r($request->all());
        $image = $request->file('category_image');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        //Image::make($image)->resize(300,300)->save('upload/category/'.$name_gen);
        $image_url = 'upload/category/'.$name_gen;
        $image->move(public_path('upload/category/'),$name_gen);
        Category::insert([
            'category_name' => $request->category_name,
            'category_slug' => strtolower(str_replace(' ','-',$request->category_name)),
            'category_image' => $image_url,
        ]);

        $notification = array(
            'message' => 'Category Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.category')->with($notification);
        
    }//End Method

    public function EditCategory($id){
        $categorys = Category::findOrFail($id);
        return view('backend.category.edit_category',compact('categorys'));
    }//End Method

    public function Updatecategory(Request $request){
        $category_id = $request->id;
        $old_image = $request->old_image;

        if($request->file('category_image')){
            $image = $request->file('category_image');
            
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            //Image::make($image)->resize(300.300)->save('upload/category/'.$name_gen);
            $image_url = 'upload/category/'.$name_gen;
            $image->move(public_path('upload/category/'),$name_gen);

            if(file_exists($old_image)){
                unlink($old_image);
            }

            Category::findOrFail($category_id)->update([
                'category_name' => $request->category_name,
                'category_slug' => strtolower(str_replace(' ','-',$request->category_name)),
                'category_image' => $image_url,
            ]);
    
            $notification = array(
                'message' => 'Category with Image Updated Successfully',
                'alert-type' => 'success'
            );
    
            return redirect()->route('all.category')->with($notification);
        }else{

            Category::findOrFail($category_id)->update([
                'category_name' => $request->category_name,
                'category_slug' => strtolower(str_replace(' ','-',$request->category_name)),
            ]);
    
            $notification = array(
                'message' => 'Category without Image Updated Successfully',
                'alert-type' => 'success'
            );
    
            return redirect()->route('all.category')->with($notification);
        }//End else

        
    }//End Method

    public function DeleteCategory($id){
        $Category = Category::findOrFail($id);
        $img = $Category->category_image;
        unlink($img);

        Category::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Category Delete Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }//End Method
}
