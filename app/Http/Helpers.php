<?php
use Illuminate\Support\Facades\Storage;

//float number format
if (! function_exists('float_number_format')) {
    function float_number_format($number) {
         return number_format($number, 1, '.', '');
    }
}


//Spaces get image
if (! function_exists('asset_image_display')) {
    function asset_image_display($image,$path) {
        if($image!="" && $path!=""){
            if (Storage::disk('spaces')->exists($path.$image)) {
                return Storage::disk('spaces')->url($path.$image);
            }
            return asset('images/default_image_1.jpg');
          }
          return asset('images/default_image_1.jpg');
    }
}


//Spaces get image
if (! function_exists('asset_image_put')) {
    function asset_image_put($image,$path,$type) {
        if($image!="" && $path!="" && $type!=""){
            $stripped = $image->getClientOriginalName();
            $filename = pathinfo($stripped, PATHINFO_FILENAME);
            $extension = pathinfo($stripped, PATHINFO_EXTENSION);
            $profile_image = $type.'-'.str_slug($filename,'-').'-'.time().'.'.$extension;
            Storage::disk('spaces')->putFileAs($path,$image ,$profile_image,'public');
            if (Storage::disk('spaces')->exists($path. $profile_image)) {
                return  $profile_image;
            }
            return null;
          }
          return null;
    }
}


//Spaces get image
if (! function_exists('asset_image_delete')) {
    function asset_image_delete($image,$path) {
        if($image!="" && $path!=""){
            if (Storage::disk('spaces')->exists($path.$image)) {
                Storage::disk('spaces')->delete($path.$image);
            }
          }
    }
}


//Spaces get image path
if (! function_exists('asset_image_path')) {
    function asset_image_path() {
        $url= Storage::disk('spaces')->url('/');
        return rtrim($url,"/");
    }
}

//SEO function
if (! function_exists('set_seo')) {
    function set_seo($title,$description,$url,$page_type,$page_image) {
        return ['title'=>$title,'description'=>$description,'url'=>$url,'type'=>$page_type,'image'=>$page_image];
    }
}



?>
