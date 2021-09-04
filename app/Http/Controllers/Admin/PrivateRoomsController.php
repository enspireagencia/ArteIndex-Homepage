<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pieces;
use App\Models\PrivateRoom;
use App\Models\PrivateRoomPieces;
use App\Models\Country;
use App\Models\Contact;
use Auth;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\DataTables;
class PrivateRoomsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = PrivateRoom::select('*')->where('user_id',Auth::id())->get();

            return Datatables::of($data)->addIndexColumn()
            ->addColumn('name', function($row){
             return $row->name ?? "-";
            })
            ->addColumn('url', function($row){
                $url="";
                if(isset($row->slug)){
                $varid="'#p".$row->id."'";
                $roomid="'".$row->id."'";
                $roomname="'".$row->name."'";
                $url = '<div class="row"><div class="col-lg-8">
                <input type="text" class="form-control  form-control-solid" id="p'.$row->id.'" value="'.route('rooms_pieces_lists',$row->slug).'" readonly/>
                </div>
                <div class="col-lg-4">
                <a href="javascript:void(0)" class="mr-2" onclick="copyToClipboard('.$varid.')"><i class="icon-2x text-success ki ki-copy"></i></a>
                <a href="javascript:void(0)" class="mr-1" onclick="shereUrl('.$roomid.','.$roomname.')"><i class="icon-2x text-primary fas fa-share-alt-square"></i></a>
                </div>
                </div>
                </div>
                ';
                }
            return $url;
            })
            ->addColumn('piecescount', function($row){
               return $row->private_rooom_pieces->count();
            })
            ->addColumn('status', function($row){
                $select = '<select class="form-control form-control-solid change_room_status">';
                $select.= '<option value="1" '.(($row->show_public_show_status == 1)?'selected':'').' room_id="'.$row->id.'">Published</option>';
                $select.= '<option value="0" '.(($row->show_public_show_status == 0)?'selected':'').' room_id="'.$row->id.'">Unpublished</option>';
                $select.='</select>';
                $select.= '<input type="hidden" class="room_hidden_id" value="'.$row->id.'" />';
                return $select;
            })
            ->addColumn('password', function($row){
                if($row->show_public_password != ""){
                    return '<span class="label label-lg label-light-success label-inline font-weight-bold py-4">Protected</span>';
                }else{
                    return '<span class="label label-lg label-light-danger  label-inline font-weight-bold py-4">unprotected</span>';

                }
            })
            ->addColumn('action', function($row){
                $btn="";
                if(isset($row->slug)){
                $btn = '<div class="">
                <a href="'.route('private_rooms.edit',encrypt($row->id)).'" class="btn btn-primary font-weight-bold btn-pill mr-2">'.__('buttons.backend.general.crud.edit').'</a>
                <a href="#" class="btn btn-danger font-weight-bold btn-pill mr-2" onClick="privateroomDelete('.$row->id.')"> '.__('buttons.backend.general.crud.delete').'</a>
                <a href="'.route('rooms_pieces_lists',$row->slug).'" class="btn btn-success font-weight-bold btn-pill mr-2">'.__('buttons.backend.general.crud.view').'</a>

                </div>';
                }
            return $btn;
            })
            ->rawColumns(['name','url','piecescount','status','password','action'])
            ->make(true);
        }
        $page_title = 'Private Rooms';
        $page_description = 'Some description for the Private Rooms';
        $user = User::with('user_status')->where('id',Auth::id())->first();
        $contacts = Contact::where('user_id',Auth::id())->get();
        $countries = Country::get();
        return view('pages.privatrooms.index', compact('page_title', 'page_description','user','countries','contacts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $user = User::with('user_status')->where('id',Auth::id())->first();
        $pieces = Pieces::where('user_id',Auth::id())->get();
        return view('pages.privatrooms.create',compact('user', 'pieces'));
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
            'name' => 'required',
        ]);
        try {

            $show_public_show_prices = isset($request['show_public_show_prices']) && $request['show_public_show_prices']=='1'?1:0;
            $show_public_show_location = isset($request['show_public_show_location']) && $request['show_public_show_location']=='1'?1:0;
            $show_public_show_wholesale_prices = isset($request['show_public_show_wholesale_prices']) && $request['show_public_show_wholesale_prices']=='1'?1:0;
            $show_public_show_inventory_numbers = isset($request['show_public_show_inventory_numbers']) && $request['show_public_show_inventory_numbers']=='1'?1:0;
            $show_public_show_creation_date = isset($request['show_public_show_creation_date']) && $request['show_public_show_creation_date']=='1'?1:0;
            $show_public_show_both_sizes = isset($request['show_public_show_both_sizes']) && $request['show_public_show_both_sizes']=='1'?1:0;
            $show_public_show_additional_images = isset($request['show_public_show_additional_images']) && $request['show_public_show_additional_images']=='1'?1:0;
            $show_public_show_subject_matter = isset($request['show_public_show_subject_matter']) && $request['show_public_show_subject_matter']=='1'?1:0;
            $show_public_show_collections = isset($request['show_public_show_collections']) && $request['show_public_show_collections']=='1'?1:0;
            $show_public_show_sales = isset($request['show_public_show_sales']) && $request['show_public_show_sales']=='1'?1:0;
            $show_public_show_inquire = isset($request['show_public_show_inquire']) && $request['show_public_show_inquire']=='1'?1:0;
            $show_public_show_purchase = isset($request['show_public_show_purchase']) && $request['show_public_show_purchase']=='1'?1:0;
            $show_public_show_status = isset($request['show_public_show_status']) && $request['show_public_show_status']=='1'?1:0;
            $show_public_password = isset($request['show_public_password']) && $request['show_public_password']!=""?1:0;
            $show_public_show_piece_order = isset($request['show_public_show_piece_order']) && $request['show_public_show_piece_order']!=""?1:0;
            $show_public_show_shadows = isset($request['show_public_show_shadows']) && $request['show_public_show_shadows']=='1'?1:0;

            if(isset($request['privateroom_id']) && $request['privateroom_id']!=''){

                $privateroom = PrivateRoom::where('id',$request['privateroom_id'])->where('user_id',Auth::id())->first();
                $privateroom->name=$request['name'];
                $privateroom->description=$request['description'];
                $privateroom->show_public_show_prices=$show_public_show_prices;
                $privateroom->show_public_show_location=$show_public_show_location;
                $privateroom->show_public_show_wholesale_prices=$show_public_show_wholesale_prices;
                $privateroom->show_public_show_inventory_numbers=$show_public_show_inventory_numbers;
                $privateroom->show_public_show_creation_date=$show_public_show_creation_date;
                $privateroom->show_public_show_both_sizes=$show_public_show_both_sizes;
                $privateroom->show_public_show_additional_images=$show_public_show_additional_images;
                $privateroom->show_public_show_subject_matter=$show_public_show_subject_matter;
                $privateroom->show_public_show_collections=$show_public_show_collections;
                $privateroom->show_public_show_sales=$show_public_show_sales;
                $privateroom->show_public_show_inquire=$show_public_show_inquire;
                $privateroom->show_public_show_purchase=$show_public_show_purchase;
                $privateroom->show_public_piece_order=$request['show_public_show_piece_order'];
                $privateroom->show_public_show_piece_order=$show_public_show_piece_order;
                $privateroom->show_public_show_status=$show_public_show_status;
                $privateroom->show_public_protected=$show_public_password;
                $privateroom->show_public_password=$request['show_public_password'];
                $privateroom->show_public_show_shadows=$show_public_show_shadows;
                $privateroom->save();
                //delete all room pieces for reinsert
                PrivateRoomPieces::where('private_room_id',$privateroom->id)->delete();
                if(isset($privateroom) && !empty($request['pieces_id'])){
                    foreach ($request['pieces_id'] as $key => $value) {
                        PrivateRoomPieces::create([
                            'private_room_id' => $privateroom->id,
                            'piece_id' => $value
                         ]);
                    }
                }
                return response()->json(['status'=>'success','message'=>__('string.backend.create.private_rooms.private_rooms_updated_successfully'),'type'=>'2']);

            }else{
                $privateroom_value = PrivateRoom::create([
                    'name' => $request['name'],
                    'description' => $request['description'],
                    'show_public_show_prices' => $show_public_show_prices,
                    'show_public_show_location' => $show_public_show_location,
                    'show_public_show_wholesale_prices' => $show_public_show_wholesale_prices,
                    'show_public_show_inventory_numbers' => $show_public_show_inventory_numbers,
                    'show_public_show_creation_date' => $show_public_show_creation_date,
                    'show_public_show_both_sizes' => $show_public_show_both_sizes,
                    'show_public_show_additional_images' => $show_public_show_additional_images,
                    'show_public_show_subject_matter' => $show_public_show_subject_matter,
                    'show_public_show_collections' => $show_public_show_collections,
                    'show_public_show_sales' => $show_public_show_sales,
                    'show_public_show_inquire' => $show_public_show_inquire,
                    'show_public_show_purchase' => $show_public_show_purchase,
                    'show_public_show_piece_order' => $show_public_show_piece_order,
                    'show_public_piece_order'=>$request['show_public_show_piece_order'],
                    'show_public_show_status' => $show_public_show_status,
                    'show_public_protected' => $show_public_password,
                    'show_public_show_shadows' => $show_public_show_shadows,
                    'show_public_password' =>  $request['show_public_password'],
                    'slug' => str_replace(' ', '-', Auth::user()->name).'-'.preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request['name'])).'-'.str_random(5),
                    'user_id' => Auth::id()
                ]);
                if(isset($privateroom_value) && !empty($request['pieces_id'])){
                        foreach ($request['pieces_id'] as $key => $value) {
                            PrivateRoomPieces::create([
                                'private_room_id' => $privateroom_value->id,
                                'piece_id' => $value
                             ]);
                        }
                }

                return response()->json(['status'=>'success','message'=>__('string.backend.create.private_rooms.private_rooms_created_successfully'),'type'=>'1']);
            }

        } catch (\Throwable $th) {
            //throw $th;
            abort(404);
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


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::with('user_status')->where('id',Auth::id())->first();
        $pieces = Pieces::where('user_id',Auth::id())->get();
        $privateroom = PrivateRoom::where('id',decrypt($id))->where('user_id',Auth::id())->first();
        if(isset($privateroom)){
            return view('pages.privatrooms.create',compact('privateroom','pieces','user'));
        }else{
            abort(404);
        }
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
            if(PrivateRoom::find($id)->delete()){
                PrivateRoomPieces::where('private_room_id',$id)->delete();
                return response()->json(['status'=>'success','message'=>'Room deleted successfully.']);
            }
            return response()->json(['status'=>'error','message'=>'Something want wrong!']);
    }

    //remove privateroom
    public function changeRoomStatus(Request $request)
    {
        try {
            $status = $request->status;
            $room_id = $request->room_id;
            $proom = PrivateRoom::where('id',$room_id)->where('user_id',Auth::id())->first();
            $proom->show_public_show_status = $status;
            $proom->save();
            return response()->json(['status'=>'success','message'=>__('string.backend.create.private_rooms.status_changed')]);
        } catch (\Throwable $th) {
            //throw $th;
            abort(404);
        }
    }

    public function shareURL(Request $request){
        try {
            if(isset($request->email_list) && !empty($request->email_list)){
              foreach (json_decode($request->email_list) as  $mailval) {
                $emails[]=$mailval->value;
              }
              if(isset($request->contact_email)){
                foreach ($request->contact_email as  $contact) {
                    $emails[]=$contact;
                  }
              }
              if(isset($request->self_copy_email) && $request->self_copy_email == 1){
                $emails[]=Auth()->user()->email;
              }
              $room = $request->privateroom_shere_id;
              $privateroom = PrivateRoom::find($room);
              $url = route('rooms_pieces_lists',$privateroom->slug);
              $array = array(
                  'view' =>'pages.mail.shareurl',
                  'subject' =>Auth()->user()->name.' shared a Private Room with you:'.' - '.$privateroom->name,
                  'from' =>env('MAIL_USERNAME'),
                  'from_name' =>Auth()->user()->name,
                  'data' =>array('room_name'=> $privateroom->name,'room_url'=>$url,'user_name'=>Auth()->user()->name,'sender_mail'=>Auth()->user()->email,'message'=>$request->message)
                );
              foreach ($emails as $key => $email) {
                try {
                    Mail::to($email)->send(new SendMail($array));
                } catch (\Exception $e) {
                    //dd($e);
                }
            }
              return response()->json(['status'=>'success','message'=>__('string.backend.common.mail_send_successfully')]);
            }
            return response()->json(['status'=>'error','message'=>__('string.backend.common.select_email_address')]);
        } catch (\Throwable $th) {
            throw $th;
            abort(404);
        }
    }


    public function pieces_detail()
    {
        $user = User::with('user_status')->where('id',Auth::id())->first();
        return view('pages.pieces_detail',compact('user'));
    }

    public function pieces_lists($slug){
        try {
            $user = User::with('user_status')->where('id',Auth::id())->first();
            $data = PrivateRoom::select('*')->where('slug',$slug)->get();
            return view('pages.pieces_lists',compact('user','data'));
        } catch (\Throwable $th) {
            abort(404);
        }

    }
}
