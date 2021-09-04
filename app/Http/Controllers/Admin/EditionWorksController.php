<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Edition;
use App\Models\EditionWorks;
use App\Models\Pieces;
use Auth;
use Yajra\DataTables\DataTables;

class EditionWorksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $edition_id = $request->get('editions_id');
            $data = EditionWorks::with('edition_detail')->select('*')->where('user_id',Auth::id())->where('edition_id',$edition_id)->get();
            return Datatables::of($data)->addIndexColumn()
            ->addColumn('default_image', function($row){
                if(isset($row->edition_detail->default_image)){
                    $image = '<div class="parent-container-'.$row->id.'">';
                    $image.= '<a href="'.asset_image_display($row->edition_detail->default_image,"images/editions/").'"><img src="'.asset_image_display($row->edition_detail->default_image,"images/editions/").'" width="50%" /></a>';
                }else{
                    $image ='<div class="parent-container-'.$row->id.'">
                                <a href="'.url("/media/users/blank.png").'"><img src="'.url("/media/users/blank.png").'" width="50%" /></a>
                            </div>';
                }
                return $image;
            })
            ->addColumn('location', function($row){
                $location = '';
                $location_array = Location::where('user_id',Auth::id())->get();
                $select = '<select class="form-control form-control-solid assign_edition_inventory_location" data-id="'.$row->id.'">';
                $select.= '<option value="">Assign Location</option>';
                if($row->location_id == 0){
                    $selected_int = 'selected';
                }else{
                    $selected_int = '';
                }
                $select.= '<option value="0" '.$selected_int.'>Your Inventory</option>';
                foreach($location_array as $key => $location_val){
                    if($row->location_id == $location_val->id){
                        $selected = 'selected';
                    }else{
                        $selected = '';
                    }
                    $select.= '<option value="'.$location_val->id.'" '.$selected.' pieces_id="'.$row->id.'">'.$location_val->name.'</option>';
                }
                $select.='</select>';

                $location.=$select;
                return $location;
            })
            ->addColumn('details', function($row){
                $details = '';
                if(isset($row->price)){
                    $details.= '<b>Price:</b> '.$row->price.'</br>';
                }else{
                    $details.= '<b>Price:</b> </br>';
                }
                if(isset($row->inventory_number)){
                    $details.= '<b>Inv:</b> '.$row->inventory_number.'</br>';
                }else{
                    $details.= '<b>Inv:</b> </br>';
                }
                if(isset($row->wholesale_price)){
                    $details.= '<b>Wholesale Price:</b> '.$row->wholesale_price.'</br>';
                }else{
                    $details.= '<b>Wholesale Price:</b> </br>';
                }
                return $details;
            })
            ->addColumn('action', function($row){
            $btn = '<div class="">
                <a href="javascript:void(0);" class="btn btn-primary font-weight-bold btn-pill mr-2 editPopup" data-id="'.$row->id.'">'.__('buttons.backend.general.crud.edit').'</a>
                <a href="#" class="btn btn-danger font-weight-bold btn-pill mr-2" onClick="worksDelete('.$row->id.')"> '.__('buttons.backend.general.crud.delete').'</a>
                <a href="javascript:void(0);" class="btn btn-info font-weight-bold btn-pill mr-2 viewPopup" data-id="'.$row->id.'">'.__('buttons.backend.general.crud.view').'</a>
                </div>';
            return $btn;
            })
            ->rawColumns(['details','location','default_image','action'])
            ->make(true);
        }
        $page_title = 'Edition';
        $page_description = 'Some description for the Edition';
        $user = User::with('user_status')->where('id',Auth::id())->first();
        return view('pages.editions.index', compact('page_title', 'page_description','user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            if(isset($request['work_id']) && $request['work_id']!=''){
                $works = EditionWorks::where('id',$request['work_id'])->where('user_id',Auth::id())->first();
                $works->inventory_number = $request['inventory_number'];
                $works->price = $this->getCustomPrice($request['price']);
                $works->wholesale_price = $this->getCustomPrice($request['wholesale_price']);
                $works->notes = $request['notes'];
                $works->save();
                return response()->json(['status'=>'success','message'=>'Edition Works Updated Successfully.','edition_id'=>$works->edition_id]);
            }else{
                return response()->json(['status'=>'error','message'=>'Something is wrong!']);
            }
        } catch (\Throwable $th) {
            //throw $th;
            dd($th);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $works = EditionWorks::where('id',$id)->where('user_id',Auth::id())->first();
        if(isset($works)){
            $editions = Edition::where('id',$works->edition_id)->where('user_id',Auth::id())->first();
            if($editions->prints_count>=1){
                $editions->prints_count = $editions->prints_count-1;
                $editions->save();
            }
            EditionWorks::find($id)->delete();
        }
        return response()->json(['status'=>'success','message'=>'Edition Works deleted successfully.']);
    }

    public function getEditionWorks(Request $request)
    {
        $id = $request->work_id;
        if(isset($id)){
            $works = EditionWorks::with('edition_detail')->with('pieces_detail')->with('location_detail')->where('id',$id)->where('user_id',Auth::id())->first();
            return response()->json(['status'=>'success','data'=>$works]);
        }
    }

    public function assignInventoryLocation(Request $request)
    {
        try {
            $location_id = $request->location_id;
            $work_id = $request->work_id;
            EditionWorks::where('id', $work_id)->where('user_id',Auth::id())->update([
                'location_id' => $location_id
            ]);
            return response()->json(['status'=>'success','message'=>'Added edition to location']);
        } catch (\Throwable $th) {
            //throw $th;
            dd($th);
        }
    }

    public function getCustomPrice($price_val)
    {

        if(isset($price_val)){
            $price = explode('.',$price_val);
            if(isset($price[1]) && strlen($price[1])<=3){
                $amount = str_replace("$","",str_replace(",","",$price[0]));
                return "$".number_format($amount, 2);
            }else{
                $amount = str_replace("$","",str_replace(",","",$price_val));
                return "$".number_format($amount, 2);
            }
        }
    }
}
