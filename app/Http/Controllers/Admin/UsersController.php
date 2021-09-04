<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MyProfile;
use App\Models\PrivateRoom;
use App\Models\User;
use Auth;

class UsersController extends Controller
{
    public function userProfile(Request $request)
    {

        $request->validate([
            'profile_image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'logo.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'report_header.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        try {
            $profile = MyProfile::where('user_id',Auth::id())->first();
            if(!empty($request->profile_image)){
				request()->validate([
					'profile_image' => 'required',
                    'profile_image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
				]);
                //upload profile
                $path='images/profile/profileimage/';
                $profile_image=asset_image_put($request->profile_image, $path,"profile");
                //remove old profile
                if($profile_image!=null && isset($profile->profile_image) && $profile->profile_image!=''){
                    asset_image_delete($profile->profile_image,$path);
                }
            }else{
                if(!empty($profile->id)){
                    $profile_image = MyProfile::where('id', $profile->id)->value('profile_image');
                }else{
                    $profile_image ='';
                }
            }
            if(!empty($request->logo)){
				request()->validate([
					'logo' => 'required',
                    'logo.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
				]);
                //upload logo
                $pathlogo='images/profile/logo/';
                $logo=asset_image_put($request->logo, $pathlogo,"logo");
                //remove old logo
                if($logo!=null && isset($profile->logo) && $profile->logo!=''){
                    asset_image_delete($profile->logo,$pathlogo);
                }
            }else{
                if(!empty($profile->id)){
                    $logo = MyProfile::where('id', $profile->id)->value('logo');
                }else{
                    $logo ='';
                }
            }
            if(!empty($request->report_header)){
				request()->validate([
					'report_header' => 'required',
                    'report_header.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
				]);

                //upload reportheader
                $pathreportheader='images/profile/reportheader/';
                $report_header=asset_image_put($request->report_header, $pathreportheader,"report-header");
                //remove old reportheader
                if($report_header!=null && isset($profile->report_header) && $profile->report_header!=''){
                    asset_image_delete($profile->report_header,$pathreportheader);
                }
            }else{
                    if(!empty($profile->id)){
                        $report_header = MyProfile::where('id', $profile->id)->value('report_header');
                    }else{
                        $report_header ='';
                    }
            }
            $all = $request->all();
            $all['profile_image'] = $profile_image;
            $all['logo'] = $logo;
            $all['report_header'] = $report_header;
            $all['user_id'] = Auth::id();

            MyProfile::updateOrCreate(['user_id' => Auth::id()], $all);

            //Update User name
            $user = User::where('id',Auth::id())->first();
            $user['name'] = $all['name']? $all['name'] : '';
            $user->save();

            return response()->json(['status'=>'success','message'=>'Profile Updated Successfully.']);
        } catch (\Throwable $th) {
            dd($th);
        }
    }
    public function userAbout(Request $request)
    {
        $request->validate([
            'about_page_cover_photo.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'short_bio' => 'required',
            'biography' => 'required',
            'statement' => 'required',
        ]);
        try {
            $profile = MyProfile::where('user_id',Auth::id())->first();
            if(!empty($request->about_page_cover_photo)){
				request()->validate([
					'about_page_cover_photo' => 'required',
                    'about_page_cover_photo.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
				]);
				$stripped = $request->about_page_cover_photo->getClientOriginalName();
				$filename = pathinfo($stripped, PATHINFO_FILENAME);
				$extension = pathinfo($stripped, PATHINFO_EXTENSION);
				$about_page_cover_photo = 'about-'.str_slug($filename,'-').'-'.time().'.'.$extension;
				$request->about_page_cover_photo->move(public_path('images/profile/aboutpagecoverphoto'), $about_page_cover_photo);
                //remove old image
                if(isset($profile->about_page_cover_photo) && $profile->about_page_cover_photo!=''){
                    unlink(public_path('images/profile/aboutpagecoverphoto/'.$profile->about_page_cover_photo));
                }
            }else{
                if(!empty($profile->id)){
                    $about_page_cover_photo = MyProfile::where('id', $profile->id)->value('about_page_cover_photo');
                }else{
                    $about_page_cover_photo ='';
                }

            }
            $all = $request->all();
            $all['about_page_cover_photo'] = $about_page_cover_photo;
            $all['user_id'] = Auth::id();
            MyProfile::updateOrCreate(['user_id' => Auth::id()], $all);
            return response()->json(['status'=>'success','message'=>'Profile Updated Successfully.']);
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    public function changeMakeMyProfilePublic(Request $request)
    {
        try {
            $all = $request->all();
            MyProfile::updateOrCreate(['user_id' => Auth::id()], $all);
            return response()->json(['status'=>'success','message'=>'Saved']);
        } catch (\Throwable $th) {
            //throw $th;
            dd($th);
        }
    }
    public function getUserProfile(Request $request)
    {
        try {
            $profile = MyProfile::where('user_id',Auth::id())->first();
            return response()->json(['status'=>'success','data'=>$profile]);
        } catch (\Throwable $th) {
            //throw $th;
            dd($th);
        }
    }
    public function changePublicProfileOption(Request $request)
    {
        try {

            $all[$request->field] = isset($request->check) && $request->check=='1'? true : false;
            PrivateRoom::updateOrCreate(['user_id' => Auth::id()], $all);
            return response()->json(['status'=>'success','message'=>'Saved']);
        } catch (\Throwable $th) {
            //throw $th;
            dd($th);
        }
    }
    public function changePublicProfileOptionSelect(Request $request)
    {
        try {

            $all[$request->field] = isset($request->value)? $request->value : '';
            PrivateRoom::updateOrCreate(['user_id' => Auth::id()], $all);
            return response()->json(['status'=>'success','message'=>'Saved']);
        } catch (\Throwable $th) {
            //throw $th;
            dd($th);
        }
    }
}
