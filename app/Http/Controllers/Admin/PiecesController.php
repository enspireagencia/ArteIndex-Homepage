<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Collection;
use App\Models\Location;
use App\Models\Pieces;
use App\Models\PiecesImage;
use App\Models\Dimension;
use App\Models\Duration;
use App\Models\Frame;
use App\Models\Papersize;
use App\Models\Weight;
use App\Models\ArtType;
use App\Models\Runs;
use App\Models\Status;
use App\Models\Works;
use App\Models\Edition;
use App\Models\PrivateRoomPieces;
use Auth;
use Yajra\DataTables\DataTables;

class PiecesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Pieces::with('pieces_images')->where('user_id',Auth::id())->select('*')->get();

            return Datatables::of($data)->addIndexColumn()
            ->addColumn('price', function($row){
                if(isset($row->price)){
                    return $row->price;
                }else{
                    return '-';
                }
            })
            ->addColumn('pieces_images', function($row){
                if(isset($row->pieces_images) && count($row->pieces_images)>0){
                    $image = '<div class="parent-container-'.$row->id.'">';
                    foreach($row->pieces_images as $key => $images){
                        if($key==0){
                            $hide_class = '';
                        }else{
                            $hide_class = 'hide_image';
                        }
                        $image.= '<a href="'.asset_image_display($images->url,"images/pieces/").'" class="'.$hide_class.'"><img src="'.asset_image_display($images->url,"images/pieces/").'" width="50%" /></a>';
                    }
                    $image.='</div>';
                }else{
                    $image ='<div class="parent-container-'.$row->id.'">
                                <a href="'.url("/media/users/blank.png").'"><img src="'.url("/media/users/blank.png").'" width="50%" /></a>
                            </div>';
                }
                return $image;
              })
            ->addColumn('status', function($row){
                $status_array = Status::all();
                $select = '<select class="form-control form-control-solid change_pieces_status">';
                foreach($status_array as $key => $status_val){
                    if($row->status_id == $status_val->id){
                        $selected = 'selected';
                    }else{
                        $selected = '';
                    }
                    $select.= '<option value="'.$status_val->id.'" '.$selected.' pieces_id="'.$row->id.'">'.$status_val->status.'</option>';
                }
                $select.='</select>';
                $select.= '<input type="hidden" class="pieces_hidden_id" value="'.$row->id.'" />';
                return $select;
              })
            ->addColumn('action', function($row){
            $btn = '<div class="">
                <a href="'.route('pieces.edit',encrypt($row->id)).'" class="btn btn-primary font-weight-bold btn-pill mr-2">'.__('buttons.backend.general.crud.edit').'</a>
                <a href="#" class="btn btn-danger font-weight-bold btn-pill mr-2" onClick="pieceDelete('.$row->id.')"> '.__('buttons.backend.general.crud.delete').'</a>
                <a href="'.route('pieces.show',encrypt($row->id)).'" class="btn btn-success font-weight-bold btn-pill mr-2">'.__('buttons.backend.general.crud.view').'</a>
                </div>';
            return $btn;
            })
            ->rawColumns(['action','pieces_images','status'])
            ->make(true);
        }
        $page_title = 'Pieces';
        $page_description = 'Some description for the page';
        $user = User::with('user_status')->where('id',Auth::id())->first();
        return view('pages.pieces.index', compact('page_title', 'page_description','user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = User::with('user_status')->where('id',Auth::id())->first();
        $collections = Collection::with('user')->where('user_id',Auth::id())->get();
        $locations = Location::with('user')->where('user_id',Auth::id())->get();
        $art_types = ArtType::all();
        $status = Status::all();
        return view('pages.pieces.create',compact('user','collections','locations','art_types','status'));
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
        $request->validate([
            'title' => 'required',
        ]);
        try {
            if(isset($request['creation_date']) && $request['creation_date']['date'] && $request['creation_date']['month'] && $request['creation_date']['year']){
                $creation_date = date('Y-m-d',strtotime($request['creation_date']['date']."-".$request['creation_date']['month']."-".$request['creation_date']['year']));
            }else{
                $creation_date = date('Y-m-d H:m:s');
            }
            $piece_creation_date_is_circa = isset($request['piece_creation_date_is_circa']) && $request['piece_creation_date_is_circa']=='1'?true:false;
            $piece_framed = isset($request['piece_framed']) && $request['piece_framed']=='1'?true:false;
            $piece_signed = isset($request['piece_signed']) && $request['piece_signed']=='1'?true:false;
            $piece_public = isset($request['piece_public']) && $request['piece_public']=='1'?true:false;
            if(isset($request['collections_id'])){
                $collections_id = implode(",",$request['collections_id']);
            }else{
                $collections_id = null;
            }
            if(isset($request['tag_list']) && $request['tag_list']!=''){
                $tag = json_decode($request['tag_list']);
                foreach ($tag as $key => $value) {
                    $tag_array[] = $value->value;
                }
                $tag_array = json_encode($tag_array);
            }else{
                $tag_array = null;
            }
            if(isset($request['pieces_id']) && $request['pieces_id']!=''){
                $pieces = Pieces::where('id',$request['pieces_id'])->where('user_id',Auth::id())->first();
                $pieces->title = $request['title'];
                $pieces->price = $this->getCustomPrice($request['price']);
                $pieces->wholesale_price = $this->getCustomPrice($request['wholesale_price']);
                $pieces->medium = $request['medium'];
                $pieces->subject_matter = $request['subject_matter'];
                $pieces->tag_list = $tag_array;
                $pieces->creation_date = $creation_date;
                $pieces->inventory_number = $request['inventory_number'];
                $pieces->description = $request['description'];
                $pieces->notes = $request['notes'];
                $pieces->signatures = $request['signatures'];
                $pieces->linkToPurchasePiece = $request['linkToPurchasePiece'];
                $pieces->artType_id = $request['artType_id'];
                $pieces->dimension_id = $request['dimension_id'];
                $pieces->weight_id = $request['weight_id'];
                $pieces->paper_id = $request['paper_id'];
                $pieces->frame_id = $request['frame_id'];
                $pieces->status_id = isset($request['status_id']) && $request['status_id']=='' ? '2' : $request['status_id'];
                $pieces->location_id = $request['location_id'];
                $pieces->collections_id = $collections_id;
                $pieces->artist_id = $request['artist_id'];
                $pieces->slug =  $this->create_slug($request['title']);
                $pieces->user_id = Auth::id();
                $pieces->piece_creation_date_is_circa = $piece_creation_date_is_circa;
                $pieces->piece_framed = $piece_framed;
                $pieces->piece_signed = $piece_signed;
                $pieces->piece_public = $piece_public;
                $pieces->save();

                //Image
                if(isset($request['document']) && count($request['document'])>0){
                    $documents = $request['document'];
                    foreach ($documents as $key => $document) {
                        $url = $document;
                        PiecesImage::create([
                            'url' => $url,
                            'piece_id' => $pieces->id,
                        ]);
                    }
                }
                //dimension

                $dimension = Dimension::where('pieces_id',$pieces->id)->first();
                if(isset($dimension)){
                    $dimension->length = $request['dimension']['height'];
                    $dimension->width = $request['dimension']['width'];
                    $dimension->depth = $request['dimension']['depth'];
                    $dimension->save();
                }else{
                    if(isset($request['dimension']) && isset($request['dimension']['height']) || isset($request['dimension']['width']) || isset($request['dimension']['depth'])){
                        Dimension::create([
                            'length' => $request['dimension']['height'],
                            'width' => $request['dimension']['width'],
                            'depth' => $request['dimension']['depth'],
                            'pieces_id' => $pieces->id,
                        ]);
                    }
                }


                //frame
                $frame = Frame::where('pieces_id',$pieces->id)->first();
                if(isset($frame)){
                    $frame->height = $request['framed']['height'];
                    $frame->width = $request['framed']['width'];
                    $frame->depth = $request['framed']['depth'];
                    $frame->save();
                }else{
                    if(isset($request['framed']) && isset($request['framed']['height']) || isset($request['framed']['width']) || isset($request['framed']['depth'])){
                        Frame::create([
                            'height' => $request['framed']['height'],
                            'width' => $request['framed']['width'],
                            'depth' => $request['framed']['depth'],
                            'pieces_id' => $pieces->id,
                        ]);
                    }
                }


                //papersize
                $papersize = Papersize::where('pieces_id',$pieces->id)->first();
                if (isset($papersize)) {
                    $papersize->height = $request['paper']['height'];
                    $papersize->width = $request['paper']['width'];
                    $papersize->save();
                }else{
                    if (isset($request['paper']) && isset($request['paper']['height']) || isset($request['paper']['width'])) {
                        Papersize::create([
                        'height' => $request['paper']['height'],
                        'width' => $request['paper']['width'],
                        'pieces_id' => $pieces->id,
                    ]);
                    }
                }


                //duration
                $duration = Duration::where('pieces_id',$pieces->id)->first();
                if (isset($duration)) {
                    $duration->hours = $request['duration']['hours'];
                    $duration->minutes = $request['duration']['minutes'];
                    $duration->second = $request['duration']['seconds'];
                    $duration->save();
                }else{
                    if (isset($request['duration']) && isset($request['duration']['hours']) || isset($request['duration']['minutes']) || isset($request['duration']['seconds'])) {
                        Duration::create([
                        'hours' => $request['duration']['hours'],
                        'minutes' => $request['duration']['minutes'],
                        'second' => $request['duration']['seconds'],
                        'pieces_id' => $pieces->id,
                        ]);
                    }
                }


                //weight
                $weight = Weight::where('pieces_id',$pieces->id)->first();
                if (isset($duration)) {
                    $weight->weight = $request['weight']['weight'];
                    $weight->save();
                }else{
                    if(isset($request['weight']) && isset($request['weight']['weight'])) {
                        Weight::create([
                            'weight' => $request['weight']['weight'],
                            'pieces_id' => $pieces->id,
                        ]);
                    }
                }

                if(isset($request['collection_name']) && $request['collection_name']!=''){
                    $collection_value = Collection::create([
                        'collection_name' => $request['collection_name'],
                        'pieces_id' => $pieces->id,
                        'user_id'=> Auth::id(),
                    ]);
                    $pieces = Pieces::where('id',$request['pieces_id'])->where('user_id',Auth::id())->first();
                    if(isset($pieces->collections_id)){
                        $a = explode(",",$pieces->collections_id);
                        $a[] = (string) $collection_value->id;
                        $pieces->collections_id = implode(",",array_unique($a));
                    }else{
                        $pieces->collections_id = $collection_value->id;
                    }
                    $pieces->save();
                }
                if(isset($request['location_name']) && $request['location_name']!=''){
                    $location_values = Location::create([
                        'name' => $request['location_name'],
                        'pieces_id' => $pieces->id,
                        'user_id'=> Auth::id(),
                    ]);
                    $pieces = Pieces::where('id',$request['pieces_id'])->where('user_id',Auth::id())->first();
                    $pieces->location_id = $location_values->id;
                    $pieces->save();
                }
                return response()->json(['status'=>'success','message'=>__('string.backend.create.pieces.pieces_updated_successfully'),'type'=>'2']);
            }else{

                $pieces =  Pieces::create([
                    'title' => $request['title'],
                    'price' => $this->getCustomPrice($request['price']),
                    'wholesale_price' => $this->getCustomPrice($request['wholesale_price']),
                    'medium' => $request['medium'],
                    'subject_matter' => $request['subject_matter'],
                    'tag_list' => $tag_array,
                    'creation_date' => $creation_date,
                    'inventory_number' => $request['inventory_number'],
                    'description' => $request['description'],
                    'notes' => $request['notes'],
                    'signatures' => $request['signatures'],
                    'linkToPurchasePiece' => $request['linkToPurchasePiece'],
                    'artType_id' => $request['artType_id'],
                    'dimension_id' => $request['dimension_id'],
                    'weight_id' => $request['weight_id'],
                    'paper_id' => $request['paper_id'],
                    'frame_id' => $request['frame_id'],
                    'status_id' => isset($request['status_id']) && $request['status_id']=='' ? '2' : $request['status_id'],
                    'location_id' => $request['location_id'],
                    'collections_id' => $collections_id,
                    'artist_id' => $request['artist_id'],
                    'user_id' => Auth::id(),
                    'slug' => $this->create_slug($request['title']),
                    'piece_creation_date_is_circa' => $piece_creation_date_is_circa,
                    'piece_framed' => $piece_framed,
                    'piece_signed' => $piece_signed,
                    'piece_public' => $piece_public,
                ]);
                if(isset($request['document']) && count($request['document'])>0){
                    $documents = $request['document'];
                    foreach ($documents as $key => $document) {
                        $url = $document;
                        PiecesImage::create([
                            'url' => $url,
                            'piece_id' => $pieces->id,
                        ]);
                    }
                }
                // dimension
                if(isset($request['dimension']) && isset($request['dimension']['height']) && isset($request['dimension']['width']) && isset($request['dimension']['depth'])){
                    Dimension::create([
                        'length' => $request['dimension']['height'],
                        'width' => $request['dimension']['width'],
                        'depth' => $request['dimension']['depth'],
                        'pieces_id' => $pieces->id,
                    ]);
                }
                // duration
                if(isset($request['duration']) && isset($request['duration']['hours']) && isset($request['duration']['minutes']) && isset($request['duration']['seconds'])){
                    Duration::create([
                        'hours' => $request['duration']['hours'],
                        'minutes' => $request['duration']['minutes'],
                        'second' => $request['duration']['seconds'],
                        'pieces_id' => $pieces->id,
                    ]);
                }
                // frame
                if(isset($request['framed']) && isset($request['framed']['height']) && isset($request['framed']['width']) && isset($request['framed']['depth'])){
                    Frame::create([
                        'height' => $request['framed']['height'],
                        'width' => $request['framed']['width'],
                        'depth' => $request['framed']['depth'],
                        'pieces_id' => $pieces->id,
                    ]);
                }
                // frame
                if(isset($request['paper']) && isset($request['paper']['height']) && isset($request['paper']['width'])){
                    Papersize::create([
                        'height' => $request['paper']['height'],
                        'width' => $request['paper']['width'],
                        'pieces_id' => $pieces->id,
                    ]);
                }
                // weight
                if(isset($request['weight']) && isset($request['weight']['weight'])){
                    Weight::create([
                        'weight' => $request['weight']['weight'],
                        'pieces_id' => $pieces->id,
                    ]);
                }
                if(isset($request['collection_name']) && $request['collection_name']!=''){
                    $collection_value = Collection::create([
                        'collection_name' => $request['collection_name'],
                        'pieces_id' => $pieces->id,
                        'user_id'=> Auth::id(),
                    ]);
                    $pieces = Pieces::where('id',$pieces->id)->where('user_id',Auth::id())->first();
                    if(isset($pieces->collections_id)){
                        $a = explode(",",$pieces->collections_id);
                        $a[] = (string) $collection_value->id;
                        $pieces->collections_id = implode(",",array_unique($a));
                    }else{
                        $pieces->collections_id = $collection_value->id;
                    }
                    $pieces->save();
                }
                if(isset($request['location_name']) && $request['location_name']!=''){
                    $location_values = Location::create([
                        'name' => $request['location_name'],
                        'pieces_id' => $pieces->id,
                        'user_id'=> Auth::id(),
                    ]);
                    $pieces = Pieces::where('id',$pieces->id)->where('user_id',Auth::id())->first();
                    $pieces->location_id = $location_values->id;
                    $pieces->save();
                }
                return response()->json(['status'=>'success','message'=>__('string.backend.create.pieces.pieces_created_successfully'),'type'=>'1']);
            }
        } catch (\Throwable $th) {
            //throw $th;
            dd($th);
        }
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        $pieces = Pieces::with('pieces_images')->where('id',decrypt($id))->where('user_id',Auth::id())->first();

        if(isset($pieces)){
            $coll = explode(',',$pieces->collections_id);
            $collections = Collection::whereIn('id',$coll)->where('user_id',Auth::id())->get();
            $page_title = 'Show Pieces Details';
            $page_description = 'Some description for the Pieces';
            $user = User::with('user_status')->where('id',Auth::id())->first();

            $run_details = array();

            $size['key'] = 'Size (h w d)';
            $size['value'] = isset($pieces->dimension)?float_number_format($pieces->dimension->length)."X".float_number_format($pieces->dimension->width)."X".float_number_format($pieces->dimension->depth)." in" : '-';

            $duration['key'] = 'Duration (h:m:s)';
            $duration['value'] = isset($pieces->duration)?$pieces->duration->hours." : ".$pieces->duration->minutes." : ".$pieces->duration->second : '-';

            $medium['key'] = 'Medium';
            $medium['value'] = $pieces->medium ?? '-';

            $subject_matter['key'] = 'Subject matter';
            $subject_matter['value'] = $pieces->subject_matter ?? '-';

            $type['key'] = 'Type';
            $type['value'] = $pieces->art_type->name ?? '-';

            $papersize['key'] = 'Paper Size (h w)';
            $papersize['value'] = isset($pieces->paper_size)?float_number_format($pieces->paper_size->height)."X".float_number_format($pieces->paper_size->width)." in": '-';

            $weight['key'] = 'Weight';
            $weight['value'] = isset($pieces->weight)?float_number_format($pieces->weight->weight, 1, '.', '')." lbs" : '-';

            $price['key'] = 'Price';
            $price['value'] = $pieces->price ?? '-';

            $wholesale_price['key'] = 'Wholesale Price';
            $wholesale_price['value'] = $pieces->wholesale_price ?? '-';

            $createdate['key'] = 'Creation Date';
            $createdate['value'] = isset($pieces->creation_date)?date('F jS, Y',strtotime($pieces->creation_date)):'-';

            $inventory_number['key'] = 'Inventory Number';
            $inventory_number['value'] = $pieces->inventory_number ?? '-';


            $status['key'] = 'status';
            $status['value'] = isset($pieces->status)?$pieces->status->status:'-';

            array_push($run_details,$size);
            array_push($run_details,$duration);
            array_push($run_details,$medium);
            array_push($run_details,$subject_matter);
            array_push($run_details,$papersize);
            array_push($run_details,$weight);
            array_push($run_details,$type);
            array_push($run_details,$price);
            array_push($run_details,$wholesale_price);
            array_push($run_details,$createdate);
            array_push($run_details,$inventory_number);
            array_push($run_details,$status);

            return view('pages.pieces.show', compact('page_title', 'page_description','user','pieces','run_details','collections'));
        }else{
            return abort(404);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pieces = Pieces::with('pieces_images')->where('id',decrypt($id))->where('user_id',Auth::id())->first();
        if(isset($pieces)){
            $pieces['year'] = date('Y',strtotime($pieces->creation_date));
            $pieces['month'] = date('m',strtotime($pieces->creation_date));
            $pieces['date'] = date('d',strtotime($pieces->creation_date));

            $dimension = Dimension::where('pieces_id',$pieces->id)->first();
            $pieces['pieces_dimension_height'] = isset($dimension->length)?$dimension->length:'';
            $pieces['pieces_dimension_width'] = isset($dimension->width)?$dimension->width:'';
            $pieces['pieces_dimension_depth'] = isset($dimension->depth)?$dimension->depth:'';

            $frame = Frame::where('pieces_id',$pieces->id)->first();
            $pieces['pieces_frame_height'] = isset($frame->height)?$frame->height:'';
            $pieces['pieces_frame_width'] = isset($frame->width)?$frame->width:'';
            $pieces['pieces_frame_depth'] = isset($frame->depth)?$frame->depth:'';

            $papersize = Papersize::where('pieces_id',$pieces->id)->first();
            $pieces['pieces_papersize_height'] = isset($papersize->height)?$papersize->height:'';
            $pieces['pieces_papersize_width'] = isset($papersize->width)?$papersize->width:'';

            $duration = Duration::where('pieces_id',$pieces->id)->first();
            $pieces['pieces_duration_hours'] = isset($duration->hours)?$duration->hours:'';
            $pieces['pieces_duration_minutes'] = isset($duration->minutes)?$duration->minutes:'';
            $pieces['pieces_duration_second'] = isset($duration->second)?$duration->second:'';

            $weight = Weight::where('pieces_id',$pieces->id)->first();
            $pieces['pieces_weight_weight'] = isset($weight->weight)?$weight->weight:'';

            $user = User::with('user_status')->where('id',Auth::id())->first();
            $collections = Collection::with('user')->where('user_id',Auth::id())->get();
            $locations = Location::with('user')->where('user_id',Auth::id())->get();
            $art_types = ArtType::all();
            $status = Status::all();
            return view('pages.pieces.create',compact('user','collections','locations','art_types','status','pieces'));
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
        $pieces = Pieces::with('pieces_images')->where('id',$id)->where('user_id',Auth::id())->first();
        if(isset($pieces)){
            if(isset($pieces->pieces_images) && count($pieces->pieces_images)>0){
                //Image remove
                foreach ($pieces->pieces_images as $key => $image) {
                    if(isset($image->url)){
                        $pathpieces='images/pieces/';
                        asset_image_delete($image->url,$pathpieces);
                    }
                    PiecesImage::find($image->id)->delete();

                }
            }
            //delete all private room pieces
            PrivateRoomPieces::where('piece_id',$id)->delete();
            // Remove Run/Reproduction
            Runs::where('piece_id',$id)->delete();
            // Remove Works
            Works::where('piece_id',$id)->delete();
            Pieces::find($id)->delete();

        }
        return response()->json(['status'=>'success','message'=>__('string.backend.create.pieces.pieces_deleted_successfully')]);
    }

    public function uploadPiecesImage(Request $request)
    {
        $file = $request->file('file');
        $pathpieces='images/pieces/';
        $pieces=asset_image_put( $file, $pathpieces,"pieces");
        return response()->json([
            'name'          => $pieces,
            'original_name' => $pieces,
        ]);
    }
    public function removePiecesImage(Request $request)
    {
        if(isset($request->id)){
            PiecesImage::find($request->id)->delete();
        }
        $pathpieces='images/pieces/';
        asset_image_delete($request->name,$pathpieces);
        return response()->json(['status'=>'success','message'=>__('string.backend.create.pieces.image_removed_successfully')]);
    }
    public function changePiecesStatus(Request $request)
    {
        try {
            $status = $request->status;
            $pieces_id = $request->pieces_id;
            $pieces = Pieces::where('id',$pieces_id)->where('user_id',Auth::id())->first();
            $pieces['status_id'] = $status;
            $pieces->save();
            return response()->json(['status'=>'success','message'=>__('string.backend.create.pieces.status_changed')]);
        } catch (\Throwable $th) {
            //throw $th;
            dd($th);
        }
    }
    public function changePiecesPublic(Request $request)
    {
        try {
            $pieces_public_val = isset($request->pieces_public_val) && $request->pieces_public_val==0 ? 1 : 0;
            $pieces_id = $request->pieces_id;
            $pieces = Pieces::where('id',$pieces_id)->where('user_id',Auth::id())->first();
            $pieces['piece_public'] = $pieces_public_val;
            $pieces->save();
            return response()->json(['status'=>'success','message'=>__('string.backend.create.pieces.saved')]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['status'=>'error','message'=>'Something is wrong!']);
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

    public function getRunWork_By_PiecesId(Request $request){
        if ($request->ajax()) {
            $id = $request->get('id');
            $data = Runs::select('*')->where('user_id',Auth::id())->where('piece_id',$id)->get();
            return Datatables::of($data)->addIndexColumn()
            ->addColumn('run', function($row){
                $run='';
                $run='<a href="'.route('runs.show',$row->id).'" class="label label-lg label-light-primary label-inline">'.$row->name.'</a>';
                return $run;
            })
            ->addColumn('details', function($row){
                $details = '';
                if(isset($row->prints_count)){
                    $details.= '<b>Prints:</b> '.$row->prints_count.'</br>';
                }else{
                    $details.= '<b>Prints:</b> </br>';
                }
                if(isset($row->medium)){
                    $details.= '<b>Medium:</b> '.$row->medium.'</br>';
                }else{
                    $details.= '<b>Medium:</b> </br>';
                }
                $details.= '<b>Size:</b> '.float_number_format($row->size_height).'X'.float_number_format($row->size_width).'X'.float_number_format($row->size_depth).' in </br>';
                if(isset($row->signed)){
                    $details.= '<b>Signed:</b> '.$row->signed.'</br>';
                }else{
                    $details.= '<b>Signed:</b> </br>';
                }
                    $details.= '<b>Number In Location:</b> '.Works::where('run_id',$row->id)->where('piece_id',$row->piece_id)->where('location_id','!=',0)->where('user_id',Auth::id())->count().'</br>';

                $details.= '<b>Number Sold:</b> 0</br>';

                return $details;
            })
            ->rawColumns(['run','details'])
            ->make(true);
        }else{
            abort(404);
        }
    }

    public function getEdition_By_PiecesId(Request $request){
        if ($request->ajax()) {
            $id = $request->get('id');
            $data = Edition::select('*')->where('user_id',Auth::id())->where('piece_id',$id)->get();
            return Datatables::of($data)->addIndexColumn()
            ->addColumn('editions', function($row){
                $run='';
                $run='<a href="'.route('editions.show',$row->id).'" class="label label-lg label-light-primary label-inline">'.$row->name.'</a>';
                return $run;
            })
            ->rawColumns(['editions'])
            ->make(true);
        }else{
            abort(404);
        }
    }

    public function getLocation_By_PiecesId(Request $request){
        if ($request->ajax()) {
            $id = $request->get('location_id');
            $data = Location::select('*')->where('user_id',Auth::id())->where('id',$id)->get();
            return Datatables::of($data)->addIndexColumn()
            ->addColumn('location', function($row){
                $run='';
                $run='<a href="'.route('locations.index',$row->id).'" class="label label-lg label-light-primary label-inline">'.$row->name.'</a>';
                return $run;
            })
            ->rawColumns(['location'])
            ->make(true);
        }else{
            abort(404);
        }
    }

    function create_slug($slug) {
        $slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', strtolower($slug)));
        $data = Pieces::select('*')->where('slug',$slug)->first();
        if(isset($data)){
            return preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $slug)).'-'.rand(1,1000);
        }else{
            return preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $slug));
        }
    }

}
