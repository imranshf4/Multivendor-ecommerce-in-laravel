<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class SliderController extends Controller
{
    public function AllSlider()
    {
        $sliders = Slider::orderBy('id', 'ASC')->latest()->get();
        return view('backend.slider.all_slider', compact('sliders'));
    } //End Method

    public function AddSlider()
    {
        return view('backend.slider.add_slider');
    } //End Method

    public function StoreSlider(Request $request)
    {


        $takeImg = $request->file('slider_image');

        $manager = new ImageManager(new Driver());
        $image = $manager->read($takeImg);
        $name_gen = hexdec(uniqid()) . '.' . $takeImg->getClientOriginalExtension();
        $image = $image->resize(2376, 807);

        $image->toJpeg(80)->save(base_path('public/upload/slider/' . $name_gen));
        $image_url = 'upload/slider/' . $name_gen;

        Slider::insert([
            'slider_title' => $request->slider_title,
            'short_title' => $request->short_title,
            'slider_image' => $image_url,
        ]);

        $notification = array(
            'message' => 'Slider Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.slider')->with($notification);
    } //End Method

    public function EditSlider($id)
    {
        $sliders = Slider::findOrFail($id);
        return view('backend.slider.edit_slider', compact('sliders'));
    } //End Method

    public function UpdateSlider(Request $request)
    {
        $id = $request->id;
        $old_image = $request->old_image;

        if ($request->file('slider_image')) {
            $takeImg = $request->file('slider_image');

            $manager = new ImageManager(new Driver());
            $image = $manager->read($takeImg);
            $name_gen = hexdec(uniqid()) . '.' . $takeImg->getClientOriginalExtension();
            $image = $image->resize(2376, 807);

            $image->toJpeg(80)->save(base_path('public/upload/slider/' . $name_gen));
            $image_url = 'upload/slider/' . $name_gen;

            if (file_exists($old_image)) {
                unlink($old_image);
            }

            Slider::findOrFail($id)->update([
                'slider_title' => $request->slider_title,
                'short_title' => $request->short_title,
                'slider_image' => $image_url,
            ]);

            $notification = array(
                'message' => 'Slider with Image Updated Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('all.slider')->with($notification);
        } else {

            Slider::findOrFail($id)->update([
                'slider_title' => $request->slider_title,
                'short_title' => $request->short_title,
            ]);

            $notification = array(
                'message' => 'Slider without Image Updated Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('all.slider')->with($notification);
        } //End else


    } //End Method

    public function DeleteSlider($id){
        $Slider = Slider::findOrFail($id);
        $img = $Slider->slider_image;
        unlink($img);

        Slider::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Slider Delete Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }//End Method
}
