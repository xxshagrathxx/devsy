<?php

namespace App\Http\Controllers\core;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use Illuminate\Http\Request;

use Image;

class SettingsController extends Controller
{
    public function edit() 
    {
        $settings = Settings::pluck('value', 'key');
        return view('pages.settings.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'logo' => 'mimes:jpeg,png,jpg,webp,gif,svg|max:2048',
            'favicon' => 'mimes:jpeg,png,jpg,webp,gif,svg|max:512',
        ],[
            'image.mimes' => 'The image must be of type (jpeg,png,jpg,webp,gif,svg)',
            'image.max' => 'The image size cannot be larger than 2MB',
            'favicon.mimes' => 'The image must be of type (jpeg,png,jpg,webp,gif,svg)',
            'favicon.max' => 'The image size cannot be larger than 512KB',
        ]);

        foreach($request->all() as $key => $value) {
            if($key == '_token')
                continue;

            if($key == 'logo'){
                if($value == null) {
                    continue;
                } else {                        
                    $image = $request->file('logo');
                    $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
                    Image::make($image)->resize(150, 44)->save('uploads/logo/' . $name_gen);
                    $value = $name_gen;
                }
            }

            if($key == 'favicon'){
                if($value == null) {
                    continue;
                } else {                        
                    $image = $request->file('favicon');
                    $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
                    Image::make($image)->resize(32, 32)->save('uploads/favicon/' . $name_gen);
                    $value = $name_gen;
                }
            }

            Settings::where('key', $key)->update([
                'value' => $value,
            ]);
        }

        $notification = array(
			'message' => 'Settings updated successfully !!',
			'alert-type' => 'success'
		);

		return redirect()->back()->with($notification);
    }
}
