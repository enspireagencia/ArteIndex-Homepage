<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pieces;
use App\Models\PrivateRoom;
use App\Models\Collection;
use App\Models\PrivateRoomPieces;
use App\Models\Country;
use App\Models\Inbox;
use App\Models\MyPost;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Mail;
use Auth;
use Session;
class HomeController extends Controller
{

    public function pieces_lists($slug){
        try {
            $data = PrivateRoom::select('*')->where('slug',$slug)->first();
            if(isset($data)){
                $page_description = isset($data->description) ? $data->description : $data->name;
                $page_title = 'Private Room';
                $page_url = url('/rooms_pieces_lists/'. $data->slug);
                $page_type = $page_title.' Private room';
                $seo_data = set_seo($page_title,$page_description,$page_url,$page_type,'');
                if((Auth::check() && Auth::id()==$data->user_id) || $data->show_public_show_status == 1){
                    if((Auth::check() && Auth::id()==$data->user_id)){
                        return view('pages.pieces_lists',compact('data','seo_data'));
                    }elseif($data->show_public_protected == 1){
                        if($data->show_public_protected == 1 && $data->show_public_password == Session::get('room_password') && $data->slug == Session::get('room_slug')){
                            return view('pages.pieces_lists',compact('data','seo_data'));
                        }
                        return view('pages.room_protection',compact('data'));
                    }elseif($data->show_public_protected == 0){
                        return view('pages.pieces_lists',compact('data','seo_data'));
                    }
                    Session::forget('room_password');
                    Session::forget('room_slug');
                    return redirect('/');
                }
            }else{
                abort(404);
            }
            return redirect('/');
        } catch (\Throwable $th) {
            abort(404);
        }

    }

    public function pieces_detail($slug,$id)
    {
        try {
            $data = PrivateRoom::select('*')->where('slug',$slug)->first();
            if(isset($data)){
                $pieces = Pieces::with('pieces_images')->where('id',decrypt($id))->first();
                $coll = explode(',',$pieces->collections_id);
                $collections = Collection::whereIn('id',$coll)->get();
                if((Auth::check() && Auth::id()==$data->user_id) || $data->show_public_show_status == 1){
                    $page_description = isset($pieces->description) ? $pieces->description : $pieces->title;
                    $page_title = 'Pieces Detail';
                    $page_url = url('rooms_pieces_detail/' . $data->slug . '/' . encrypt($pieces->id) );
                    $page_type = $page_title.' Pieces detail';
                    if(isset($pieces->pieces_images[0]->url)){
                        $thumimage=asset_image_display($pieces->pieces_images[0]->url,"images/pieces/");
                    }
                    $page_image = $thumimage;
                    $seo_data = set_seo($page_title,$page_description,$page_url,$page_type,$page_image);
                    if((Auth::check() && Auth::id()==$data->user_id)){
                        return view('pages.pieces_detail',compact('data','pieces','collections','seo_data'));
                    }elseif($data->show_public_protected == 1){
                    if($data->show_public_protected == 1 && $data->show_public_password == Session::get('room_password') && $data->slug == Session::get('room_slug')){
                        return view('pages.pieces_detail',compact('data','pieces','collections','seo_data'));
                    }
                    return view('pages.room_protection',compact('data'));
                    }elseif($data->show_public_protected == 0){
                        $pieces = Pieces::with('pieces_images')->where('id',decrypt($id))->first();
                        $coll = explode(',',$pieces->collections_id);
                        $collections = Collection::whereIn('id',$coll)->get();
                        return view('pages.pieces_detail',compact('data','pieces','collections','seo_data'));
                    }
                    Session::forget('room_password');
                    Session::forget('room_slug');
                    return redirect('/');
                }
            }else{
                abort(404);
            }
               
        } catch (\Throwable $th) {
            //throw $th;
            abort(404);
        }
     }

     public function rooms_protection(Request $request){
        $request->validate([
            'password' => 'required',
        ]);
        try {
            $data = PrivateRoom::select('*')->where('slug',$request->slug)->where('show_public_password',$request->password)->first();
            if($data){
                Session::put('room_password',$data->show_public_password);
                Session::put('room_slug',$data->slug);
                return response()->json(['status'=>'success','message'=>"You entered in room successfully"]);
            }
            return response()->json(['status'=>'error','message'=>'Password is wrong!']);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['status'=>'error','message'=>'Something is wrong!']);
        }
     }


     public function pieces_inquiry(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'message' => 'required',
        ]);
        try {
            $pieces = Pieces::with('pieces_images')->where('id',$request->piece_id)->first();
            $user = User::select('*')->where('id',$pieces->user_id)->first();
            $inquiry = Inbox::create([
                'pieces_id'=> $request->piece_id,
                'name' => $request->name,
                'email' => $request->email,
                'phone'=>$request->phone,
                'message' => $request->message,
                'private_room_id'=>$request->private_room_id,
                'user_id'=>$pieces->user_id,
                'type'=>1,
            ]);
           
            $view_message_url = url('inbox/' . encrypt($inquiry->id) );
            $view_inbox_url = url('inbox');
            $array = array(
                'view' =>'pages.mail.inquiry',
                'subject' =>"Inbox: A new Piece Inquiry from ".$request->name,
                'from' =>"chandubhaigorji@gmail.com",
                'from_name' =>$user->name,
                'data' =>array('view_message_url'=>$view_message_url,'view_inbox_url'=>$view_inbox_url,'user_name'=>$user->name,'name'=>$request->name,'sender_mail'=>$request->email,'message'=>$request->message)
            );
            
            try {
                Mail::to($pieces->user->email)->send(new SendMail($array));
            } catch (\Exception $e) {
                //throw $e;
                return response()->json(['status'=>'error','message'=>'Something is wrong!']);
            }
          return response()->json(['status'=>'success','message'=>"Your Inquiry Submited successfully"]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['status'=>'error','message'=>'Something is wrong!']);
        }
     }
     public function profile_view($slug){
        try {
            $data = User::with('profile')->select('*')->where('user_unique_id',$slug)->first();
            $pieces = Pieces::with('pieces_images')->where('piece_public',1)->where('user_id',$data->id)->get();
            $posts = MyPost::where('status',1)->where('post_date','<=',date('Y-m-d'))->where('user_id',$data->id)->get();
            if(isset($data) && isset($data->profile)){
                $page_description = isset($data->profile->short_bio) ? $data->profile->short_bio : $data->profile->biography;
                $page_title = 'Profile';
                $page_url = url('/profile/'.$data->user_unique_id);
                $page_type = $page_title.' Profile';
                $seo_data = set_seo($page_title,$page_description,$page_url,$page_type,'');
                if($data->profile->make_my_profile_public==1){
                    if((Auth::check() && Auth::id()==$data->id)){
                        if((Auth::check() && Auth::id()==$data->id)){
                            return view('pages.profile',compact('data','pieces','posts','seo_data'));
                        }
                        return redirect('/');
                    }else{
                        return view('pages.profile',compact('data','pieces','posts','seo_data'));
                    }
                }else{
                    return redirect('/pieces');  
                }
            }else{
                return redirect('/');  
            }
            return redirect('/');
        } catch (\Throwable $th) {
            abort(404);
        }
    }

    public function profile_pieces_detail($profile_slug, $piece_slug){
        try {
            $pieces = Pieces::with('pieces_images')->where('slug',$piece_slug)->where('piece_public',1)->first();
            if(isset($pieces)){
                $data = User::select('*')->where('user_unique_id',$profile_slug)->first();
                $page_description = isset($pieces->description) ? $pieces->description : $pieces->title;
                $page_title = 'Profile Pieces Detail';
                $page_url = url('profile/' . $data->user_unique_id . '/artwork/' . $pieces->slug );
                $page_type = $page_title.' Profile Pieces Detail';
                if(isset($pieces->pieces_images[0]->url)){
                    $thumimage=asset_image_display($pieces->pieces_images[0]->url,"images/pieces/");
                }
                $page_image = $thumimage;
                $seo_data = set_seo($page_title,$page_description,$page_url,$page_type,$thumimage);
                $coll = explode(',',$pieces->collections_id);
                $collections = Collection::whereIn('id',$coll)->get();
                
                if (isset($data) && isset($data->profile)) {
                    if($data->profile->make_my_profile_public==1){
                        if ((Auth::check() && Auth::id()==$data->id)) {
                            if ((Auth::check() && Auth::id()==$data->id)) {
                                return view('pages.profile_pieces_detail', compact('data', 'pieces', 'collections','seo_data'));
                            }
                            return redirect('/');
                        }else{
                            return view('pages.profile_pieces_detail', compact('data', 'pieces', 'collections','seo_data'));
                        }
                    }else{
                        return redirect('/pieces');  
                    }
                }else{
                    return redirect('/');
                }
                return redirect('/');
            }else{
                abort(404);
            }
        } catch (\Throwable $th) {
            abort(404);
        }
    }

    public function pieces_profile_inquiry(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'message' => 'required',
        ]);
        try {
            $user = User::select('*')->where('user_unique_id',$request->profile_slug)->first();
            $inquiry = Inbox::create([
                'pieces_id'=> $request->piece_id,
                'name' => $request->name,
                'email' => $request->email,
                'phone'=>$request->phone,
                'message' => $request->message,
                'private_room_id'=>$request->private_room_id,
                'user_id'=>$user->id,
                'type'=>2,
            ]);
            $view_message_url = url('inbox/' . encrypt($inquiry->id) );
            $view_inbox_url = url('inbox');
            $array = array(
                'view' =>'pages.mail.profile_inquiry',
                'subject' =>"Inbox: A new Message from ".$request->name,
                'from' =>"chandubhaigorji@gmail.com",
                'from_name' =>$user->name,
                'data' =>array('view_message_url'=>$view_message_url,'view_inbox_url'=>$view_inbox_url,'user_name'=>$user->name,'name'=>$request->name,'sender_mail'=>$request->email,'message'=>$request->message)
            );
            try {
                Mail::to($user->email)->send(new SendMail($array));
            } catch (\Exception $e) {
                //throw $e;
                return response()->json(['status'=>'error','message'=>'Something is wrong!']);
            }
          return response()->json(['status'=>'success','message'=>"Your Inquiry Submited successfully"]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['status'=>'error','message'=>'Something is wrong!']);
        }
     }
     public function profile_post_detail($profile_slug, $post_slug){
        try {
            $post = MyPost::where('slug',$post_slug)->where('status',1)->first();
            if(isset($post)){
                $data = User::select('*')->where('user_unique_id',$profile_slug)->first();
                $page_description = isset($post->body) ? $post->body : $post->body;
                $page_title = 'Post Detail';
                $page_url = url('profile/' . $data->user_unique_id . '/news/' . $post->slug );
                $page_type = $page_title.' Post Detail';
                if(isset($post->image)){
                    $thumimage=asset_image_display($post->image,"images/profile/mypost/");
                }
                $page_image = $thumimage;
                $seo_data = set_seo($page_title,$page_description,$page_url,$page_type,$thumimage);
                if (isset($data) && isset($data->profile)) {
                    if($data->profile->make_my_profile_public==1){
                        if((Auth::check() && Auth::id()==$data->id)){
                            if((Auth::check() && Auth::id()==$data->id)){
                                return view('pages.profile_post_detail',compact('data','post','seo_data'));
                            }
                            return redirect('/');
                        }else{
                            return view('pages.profile_post_detail',compact('data','post','seo_data'));
                        }
                    }else{
                        if ((Auth::check())) {
                            return redirect('/pieces');  
                        }
                    }
                }else{
                    return redirect('/');
                }
                return redirect('/');
            }else{
                abort(404);
            }
        } catch (\Throwable $th) {
            abort(404);
        }
    }
}
