<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
use File;
use App\Models\MyPost;
use Illuminate\Http\Request;

class MyPostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = User::with('user_status')->where('id',Auth::id())->first();
        return view('pages.users.mypost.create',compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);
        $status = isset($request['status']) && $request['status']=='1'?true:false;

        try {
            if(isset($request['post_id']) && $request['post_id']!=''){
                if(isset($request->post_image_remove) && $request->post_image_remove==1){
                    $pathpost='images/profile/mypost/';
                    asset_image_delete($request->old_image,$pathpost);
                    $myPost = MyPost::find($request->post_id);
                    $myPost->image =Null;
                    $myPost->save();
                }
                if ($request->hasFile('image')){
                      //upload my post
                      $pathpost='images/profile/mypost/';
                      $default_image=asset_image_put($request->image, $pathpost,"mypost");
                       //remove old my post
                      if($default_image!=null && isset($request->old_image) && $request->old_image!=''){
                          asset_image_delete($request->old_image,$pathpost);
                      }
                    $myPost = MyPost::find($request->post_id);
                    $myPost->image =$default_image;
                    $myPost->save();
                }

                $myPost = MyPost::where('id',$request['post_id'])->where('user_id',Auth::id())->first();
                $myPost->title = $request['title'];
                $myPost->subheader = $request['subheader'];
                $myPost->body = $request['body'];
                $myPost->post_date = $request['post_date'];
                $myPost->slug = $this->create_slug($request['title']);
                $myPost->status = $status;
                $myPost->save();
                return response()->json(['status'=>'success','message'=> 'Post Updated Successfully.','type'=>'2']);
           }else{
            $default_image=null;
            if ($request->hasFile('image')) {
                  //upload my post
                  $pathpost='images/profile/mypost/';
                  $default_image=asset_image_put($request->image, $pathpost,"mypost");
            }
            MyPost::create([
                'title' => $request['title'],
                'subheader' => $request['subheader'],
                'body' => $request['body'],
                'post_date' => $request['post_date'],
                'status' => $status,
                'image' => $default_image,
                'slug' => $this->create_slug($request['title']),
                'user_id' => Auth::id(),
            ]);
            return response()->json(['status'=>'success','message'=>'Post Created Successfully.', 'type'=>'1']);
           }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MyPost  $myPost
     * @return \Illuminate\Http\Response
     */
    public function show(MyPost $myPost, $id)
    {

        try {
            $user = User::with('user_status')->where('id',Auth::id())->first();
            $myPost = MyPost::where('id',decrypt($id))->where('user_id',Auth::id())->first();
            if(isset($myPost)){
                return view('pages.users.mypost.show', compact('myPost','user'));
            }else{
                abort(404);
            }
        } catch (\Throwable $th) {
            //throw $th;
            abort(404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MyPost  $myPost
     * @return \Illuminate\Http\Response
     */
    public function edit(MyPost $myPost, $id)
    {
        try {
            $myPost = MyPost::where('id',decrypt($id))->where('user_id',Auth::id())->first();
            $user = User::with('user_status')->where('id',Auth::id())->first();
            if(isset($myPost)){
                return view('pages.users.mypost.create', compact('myPost','user'));
            }else{
                abort(404);
            }
        } catch (\Throwable $th) {
            //throw $th;
            abort(404);
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MyPost  $myPost
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MyPost $myPost)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MyPost  $myPost
     * @return \Illuminate\Http\Response
     */
    public function destroy(MyPost $myPost, $id)
    {
        $myPost = MyPost::where('id',$id)->where('user_id',Auth::id())->first();
        if(isset($myPost)){
            if(isset($myPost->image)){
                $pathpost='images/profile/mypost/';
                asset_image_delete($myPost->image,$pathpost);
            }
        }
        $myPost->delete();
        return response()->json(['status'=>'success','message'=>__('string.backend.create.mypost.mypost_deleted_successfully')]);
    }

    public function change_published(Request $request)
    {
        try {
            $status = $request->status;
            $room_id = $request->room_id;
            $proom = MyPost::where('id',$room_id)->where('user_id',Auth::id())->first();
            $proom->status = $status;
            $proom->save();
            return response()->json(['status'=>'success','message'=>__('string.backend.create.mypost.status_changed')]);
        } catch (\Throwable $th) {
            throw $th;
            //abort(404);
        }
    }
    public function CkEditorImageUpload(Request $request)
    {
        if($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName.'_'.time().'.'.$extension;
             //upload my post
             $pathpost='images/profile/mypost/body/';
             $default_image=asset_image_put($request->upload, $pathpost,"body");
             $image = asset_image_display($default_image,"images/profile/mypost/body/");
              //remove old my post
             if($default_image!=null && isset($request->old_image) && $request->old_image!=''){
                 asset_image_delete($request->old_image,$pathpost);
             }
             return response()->json(['fileName'=>$fileName,'uploaded'=>1,'url'=>$image]);
        }
    }

    function create_slug($slug) {
        $slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', strtolower($slug)));
        $data = MyPost::select('*')->where('slug',$slug)->first();
        if(isset($data)){
            return preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $slug)).'-'.rand(1,1000);
        }else{
            return preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $slug));
        }
    }
}
