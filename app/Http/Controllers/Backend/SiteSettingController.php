<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Seo;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class SiteSettingController extends Controller
{
    public function SiteSetting()
    {
        $setting = SiteSetting::find(1);
        return view('backend.setting.display_site_setting', compact('setting'));
    }

    public function SiteSettingUpdate(Request $request)
    {
        $id = $request->id;
        $old_image = $request->old_image;

        if ($request->file('logo')) {
            $takeImg = $request->file('logo');

            $manager = new ImageManager(new Driver());
            $image = $manager->read($takeImg);
            $name_gen = hexdec(uniqid()) . '.' . $takeImg->getClientOriginalExtension();
            $image = $image->resize(180, 56);

            $image->toJpeg(80)->save(base_path('public/upload/logo/' . $name_gen));
            $save_url = 'upload/logo/' . $name_gen;

            if (file_exists($old_image)) {
                unlink($old_image);
            }

            SiteSetting::findOrFail($id)->update([
                'support_phone' => $request->support_phone,
                'phone_one' => $request->phone_one,
                'email' => $request->email,
                'company_address' => $request->company_address,
                'facebook' => $request->facebook,
                'twitter' => $request->twitter,
                'youtube' => $request->youtube,
                'copyright' => $request->copyright,
                'logo' => $save_url,
            ]);

            $notification = array(
                'message' => 'Site Setting with Image Updated Successfully',
                'alert-type' => 'success'
            );

            return redirect()->back()->with($notification);
        } else {

            SiteSetting::findOrFail($id)->update([
                'support_phone' => $request->support_phone,
                'phone_one' => $request->phone_one,
                'email' => $request->email,
                'company_address' => $request->company_address,
                'facebook' => $request->facebook,
                'twitter' => $request->twitter,
                'youtube' => $request->youtube,
                'copyright' => $request->copyright,
            ]);

            $notification = array(
                'message' => 'Site Setting without Image Updated Successfully',
                'alert-type' => 'success'
            );

            return redirect()->back()->with($notification);
        } //End else


    } //End Method

    ////////// seo setting /////////
    public function SeoSetting()
    {
        $seo = Seo::find(1);
        return view('backend.seo.display_seo_setting', compact('seo'));
    } //End Method

    public function SeoSettingUpdate(Request $request)
    {
        $id = $request->id;


        Seo::findOrFail($id)->update([
            'meta_title' => $request->meta_title,
            'meta_author' => $request->meta_author,
            'meta_keyword' => $request->meta_keyword,
            'meta_description' => $request->meta_description,
        ]);

        $notification = array(
            'message' => 'Seo Setting Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    } //End Method
}
