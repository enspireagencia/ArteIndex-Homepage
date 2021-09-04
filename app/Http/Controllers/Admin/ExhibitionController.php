<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Country;
use App\Models\Location;
use App\Models\Schedule;
use App\Models\Pieces;
use Auth;
use File;
use App\Models\Exhibition;
use App\Models\ExhibitionPieces;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ExhibitionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Exhibition::with('location')->with('country_name')->select('*')->where('user_id',Auth::id())->get();
            return Datatables::of($data)->addIndexColumn()
            ->addColumn('name', function($row){
                $location_name = isset($row->location->name) ? $row->location->name: '-';
                return
                '<h5>' .$row->name. '</h5>
                <p> Online Solo Exhibition at <a href="'.route('locations.show',encrypt($row->location_id)).'" >'.$location_name. '</a><p>
                <p> Website : <a href="'.$row->website.'" target="_blank">Link</a><p>
                <p> Email : '.$row->email. '<p>';
            })
            ->addColumn('detail', function($row){
                $total_assign_pieces = ExhibitionPieces::where('user_id',Auth::id())->where('exhibition_id',$row->id)->count();
                return
                '<p> Works Submitted: '.$total_assign_pieces.'</p>
                <p> Submission Deadline: '. $row->submission_deadline . '<p>
                <p> Delivery Date: '.$row->delivery_date. '<p>
                <p> Notification Date: '.$row->notification_date. '<p>
                <p> Start Date: '.$row->start_date. '<p>
                <p> End Date: '.$row->end_date. '<p>
                <p> Reception Date: '.$row->reception_date. '<p>
                <p> Pickup Date: '.$row->pickup_date. '<p>
                <p> Curator: '.$row->curator. '<p>
                <p> Juror: '.$row->juror. '<p>';
            })
            ->addColumn('address', function($row){
                $country_name = isset($row->country_name) ? $row->country_name->name:'-';
                return
                '<p> Address 1 : ' .$row->address_line1. '</p>
                <p> Address 2 : '.$row->address_line2. '<p>
                <p> City : '.$row->city. '<p>
                <p> State : '.$row->state. '<p>
                <p> Country : '.$country_name. '<p>
                <p> Zip : '.$row->zip. '<p>';
            })
            ->addColumn('action', function($row){
            $btn = '<div class="">
                <a href="'.route('exhibitions.edit',$row->id).'" class="btn btn-primary font-weight-bold btn-pill mr-2">'.__('buttons.backend.general.crud.edit').'</a>
                <a href="#" class="btn btn-danger font-weight-bold btn-pill mr-2" onClick="exhibitionDelete('.$row->id.')"> '.__('buttons.backend.general.crud.delete').'</a>
                <a href="'.route('exhibitions.show',$row->id).'" class="btn btn-success font-weight-bold btn-pill mr-2"> '.__('buttons.backend.general.crud.view').'</a>
                </div>';
            return $btn;
            })
            ->rawColumns(['action','name','address','detail'])
            ->make(true);
        }
        $page_title = 'Exhibition';
        $page_description = 'Some description for the page';
        $user = User::with('user_status')->where('id',Auth::id())->first();
        return view('pages.exhibitions.index', compact('page_title', 'page_description','user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = User::with('user_status')->where('id',Auth::id())->first();
        $countries = Country::get();
        $locations = Location::with('user')->where('user_id',Auth::id())->get();
        return view('pages.exhibitions.create',compact('user','countries','locations'));
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
        $is_create_location_records = isset($request['is_create_location_records_for_pieces_accepted_to_this_show']) && $request['is_create_location_records_for_pieces_accepted_to_this_show']=='1'?true:false;

        try {
            if(isset($request['exhibition_id']) && $request['exhibition_id']!=''){
                $exhibition = Exhibition::where('id',$request['exhibition_id'])->where('user_id',Auth::id())->first();
                $exhibition->name = $request['name'];
                $exhibition->show_type = $request['show_type'];
                $exhibition->solo_group_show = $request['solo_group_show'];
                $exhibition->description = $request['description'];
                $exhibition->phone = $request['phone'];
                $exhibition->email = $request['email'];
                $exhibition->website = $request['website'];
                $exhibition->fee = $request['fee'];
                $exhibition->curator = $request['curator'];
                $exhibition->juror = $request['juror'];
                $exhibition->location_type = $request['location_type'];
                $exhibition->location_id = $request['location_id'];
                $exhibition->is_create_location_records_for_pieces_accepted_to_this_show = $is_create_location_records;
                $exhibition->address_line1 = $request['address_line_1'];
                $exhibition->address_line2 = $request['address_line_2'];
                $exhibition->city = $request['city'];
                $exhibition->state = $request['state'];
                $exhibition->zip = $request['zip'];
                $exhibition->country = $request['country'];
                $exhibition->start_date = $request['exhibition_start'];
                $exhibition->end_date = $request['exhibition_end'];
                $exhibition->reception_date = $request['reception_date'];
                $exhibition->submission_deadline = $request['submission_deadline'];
                $exhibition->notification_date = $request['notification_date'];
                $exhibition->delivery_date = $request['delivery_date'];
                $exhibition->pickup_date = $request['pickup_date'];
                $exhibition->notes = $request['notes'];
                $exhibition->user_id = Auth::id();
                $exhibition->save();
                // Start Date
                $exhibition_start = Schedule::where('exhibition_id',$request['exhibition_id'])->where('message','Start Date for Exhibition')->where('user_id',Auth::id())->first();
                if($exhibition_start && $request['exhibition_start']){
                    $exhibition_start->remainder_date = $request['exhibition_start'];
                    $exhibition_start->save();
                }else if($request['exhibition_start'] == null){
                    $exhibition_start = Schedule::where('exhibition_id',$request['exhibition_id'])->where('message','Start Date for Exhibition')->where('user_id',Auth::id())->first();
                    if(isset($exhibition_start)){
                        $exhibition_start->delete();
                    }
                }else{
                    if($request['exhibition_start']){
                        $schedule = Schedule::create([
                            'message' => "Start Date for Exhibition",
                            'remainder_date'=> $request['exhibition_start'],
                            'user_id'=> Auth::id(),
                            'exhibition_id'=> $request['exhibition_id'],
                        ]);
                    }
                }
                // End Date
                $exhibition_end = Schedule::where('exhibition_id',$request['exhibition_id'])->where('message','End Date for Exhibition')->where('user_id',Auth::id())->first();
                if($exhibition_end && $request['exhibition_end']){
                    $exhibition_end->remainder_date = $request['exhibition_end'];
                    $exhibition_end->save();
                }else if($request['exhibition_end'] == null){
                    $exhibition_end = Schedule::where('exhibition_id',$request['exhibition_id'])->where('message','End Date for Exhibition')->where('user_id',Auth::id())->first();
                    if(isset($exhibition_end)){
                        $exhibition_end->delete();
                    }
                }else{
                    if ($request['exhibition_end']) {
                        $schedule = Schedule::create([
                            'message' => "End Date for Exhibition",
                            'remainder_date'=> $request['exhibition_end'],
                            'user_id'=> Auth::id(),
                            'exhibition_id'=> $request['exhibition_id'],
                        ]);
                    }
                }
                // Reception Date
                $reception_date = Schedule::where('exhibition_id',$request['exhibition_id'])->where('message','Reception Date for Exhibition')->where('user_id',Auth::id())->first();
                if($reception_date && $request['reception_date']){
                    $reception_date->remainder_date = $request['reception_date'];
                    $reception_date->save();
                }else if($request['reception_date'] == null){
                    $reception_date = Schedule::where('exhibition_id',$request['exhibition_id'])->where('message','Reception Date for Exhibition')->where('user_id',Auth::id())->first();
                    if(isset($reception_date)){
                        $reception_date->delete();
                    }
                }else{
                    if ($request['reception_date']) {
                        $schedule = Schedule::create([
                            'message' => "Reception Date for Exhibition",
                            'remainder_date'=> $request['reception_date'],
                            'user_id'=> Auth::id(),
                            'exhibition_id'=> $request['exhibition_id'],
                        ]);
                    }
                }
                // Submission Deadline
                $submission_deadline = Schedule::where('exhibition_id',$request['exhibition_id'])->where('message','Submission Deadline for Exhibition')->where('user_id',Auth::id())->first();
                if($submission_deadline && $request['submission_deadline']){
                    $submission_deadline->remainder_date = $request['submission_deadline'];
                    $submission_deadline->save();
                }else if($request['submission_deadline'] == null){
                    $submission_deadline = Schedule::where('exhibition_id',$request['exhibition_id'])->where('message','Submission Deadline for Exhibition')->where('user_id',Auth::id())->first();
                    if(isset($submission_deadline)){
                        $submission_deadline->delete();
                    }
                }else{
                    if ($request['submission_deadline']) {
                        $schedule = Schedule::create([
                            'message' => "Submission Deadline for Exhibition",
                            'remainder_date'=> $request['submission_deadline'],
                            'user_id'=> Auth::id(),
                            'exhibition_id'=> $request['exhibition_id'],
                        ]);
                    }
                }
                // Notification Date
                $notification_date = Schedule::where('exhibition_id',$request['exhibition_id'])->where('message','Notification Date for Exhibition')->where('user_id',Auth::id())->first();
                if($notification_date && $request['notification_date']){
                    $notification_date->remainder_date = $request['notification_date'];
                    $notification_date->save();
                }else if($request['notification_date'] == null){
                    $notification_date = Schedule::where('exhibition_id',$request['exhibition_id'])->where('message','Notification Date for Exhibition')->where('user_id',Auth::id())->first();
                    if(isset($notification_date)){
                        $notification_date->delete();
                    }
                }else{
                    if ($request['notification_date']) {
                        $schedule = Schedule::create([
                            'message' => "Notification Date for Exhibition",
                            'remainder_date'=> $request['notification_date'],
                            'user_id'=> Auth::id(),
                            'exhibition_id'=> $request['exhibition_id'],
                        ]);
                    }
                }
                // Delivery Date
                $delivery_date = Schedule::where('exhibition_id',$request['exhibition_id'])->where('message','Delivery Date for Exhibition')->where('user_id',Auth::id())->first();
                if($delivery_date && $request['delivery_date']){
                    $delivery_date->remainder_date = $request['delivery_date'];
                    $delivery_date->save();
                }else if($request['delivery_date'] == null){
                    $delivery_date = Schedule::where('exhibition_id',$request['exhibition_id'])->where('message','Delivery Date for Exhibition')->where('user_id',Auth::id())->first();
                    if(isset($delivery_date)){
                        $delivery_date->delete();
                    }
                }else{
                    if ($request['delivery_date']) {
                        $schedule = Schedule::create([
                            'message' => "Delivery Date for Exhibition",
                            'remainder_date'=> $request['delivery_date'],
                            'user_id'=> Auth::id(),
                            'exhibition_id'=> $request['exhibition_id'],
                        ]);
                    }
                }
                // Pickup Date
                
                $pickup_date = Schedule::where('exhibition_id',$request['exhibition_id'])->where('message','Pickup Date for Exhibition')->where('user_id',Auth::id())->first();
                if($pickup_date && $request['pickup_date']){
                    $pickup_date->remainder_date = $request['pickup_date'];
                    $pickup_date->save();
                }else if($request['pickup_date'] == null){
                    $pickup_date = Schedule::where('exhibition_id',$request['exhibition_id'])->where('message','Pickup Date for Exhibition')->where('user_id',Auth::id())->first();
                    if(isset($pickup_date)){
                        $pickup_date->delete();
                    }
                }else{
                    if ($request['pickup_date']) {
                        $schedule = Schedule::create([
                            'message' => "Pickup Date for Exhibition",
                            'remainder_date'=> $request['pickup_date'],
                            'user_id'=> Auth::id(),
                            'exhibition_id'=> $request['exhibition_id'],
                        ]);
                    }
                }
                if(isset($request['location_name']) && $request['location_name']!=''){
                    $location_values = Location::create([
                        'name' => $request['location_name'],
                        'user_id'=> Auth::id(),
                    ]);
                    $exhibition = Exhibition::where('id',$request['exhibition_id'])->where('user_id',Auth::id())->first();
                    $exhibition->location_id = $location_values->id;
                    $exhibition->save();
                }
                return response()->json(['status'=>'success','message'=>__('string.backend.create.exhibitions.exhibition_updated_successfully'),'type'=>'2']);
           }else{
            $Exhibition = Exhibition::create([
                'name' => $request['name'],
                'show_type' => $request['show_type'],
                'solo_group_show' => $request['solo_group_show'],
                'description' => $request['description'],
                'phone' => $request['phone'],
                'email' => $request['email'],
                'website' => 'http://'.$request['website'],
                'fee' => $request['fee'],
                'curator' => $request['curator'],
                'juror' => $request['juror'],
                'location_type' => $request['location_type'],
                'location_id' => $request['location_id'],
                'is_create_location_records_for_pieces_accepted_to_this_show' => $is_create_location_records,
                'address_line1' => $request['address_line_1'],
                'address_line2' => $request['address_line_2'],
                'city' => $request['city'],
                'state' => $request['state'],
                'zip' => $request['zip'],
                'country' => $request['country'],
                'start_date' => $request['exhibition_start'],
                'end_date' => $request['exhibition_end'],
                'reception_date' => $request['reception_date'],
                'submission_deadline' => $request['submission_deadline'],
                'notification_date' => $request['notification_date'],
                'delivery_date' => $request['delivery_date'],
                'pickup_date' => $request['pickup_date'],
                'notes' => $request['notes'],
                'user_id' => Auth::id(),
            ]);
            // Start Date
            if($request['exhibition_start']){
                $schedule = Schedule::create([
                    'message' => "Start Date for Exhibition",
                    'remainder_date'=> $request['exhibition_start'],
                    'user_id'=> Auth::id(),
                    'exhibition_id'=> $Exhibition->id,
                ]);
            }
            // End Date
            if($request['exhibition_end']){
                $schedule = Schedule::create([
                    'message' => "End Date for Exhibition",
                    'remainder_date'=> $request['exhibition_end'],
                    'user_id'=> Auth::id(),
                    'exhibition_id'=> $Exhibition->id,
                ]);
            }
            // Reception Date
            if($request['reception_date']){
                $schedule = Schedule::create([
                    'message' => "Reception Date for Exhibition",
                    'remainder_date'=> $request['reception_date'],
                    'user_id'=> Auth::id(),
                    'exhibition_id'=> $Exhibition->id,
                ]);
            }
            // Submission Deadline
            if($request['submission_deadline']){
                $schedule = Schedule::create([
                    'message' => "Submission Deadline for Exhibition",
                    'remainder_date'=> $request['submission_deadline'],
                    'user_id'=> Auth::id(),
                    'exhibition_id'=> $Exhibition->id,
                ]);
            }
            // Notification Date
            if($request['notification_date']){
                $schedule = Schedule::create([
                    'message' => "Notification Date for Exhibition",
                    'remainder_date'=> $request['notification_date'],
                    'user_id'=> Auth::id(),
                    'exhibition_id'=> $Exhibition->id,
                ]);
            }
            // Delivery Date
            if($request['delivery_date']){
                $schedule = Schedule::create([
                    'message' => "Delivery Date for Exhibition",
                    'remainder_date'=> $request['delivery_date'],
                    'user_id'=> Auth::id(),
                    'exhibition_id'=> $Exhibition->id,
                ]);
            }
            // Pickup Date
            if($request['pickup_date']){
                $schedule = Schedule::create([
                    'message' => "Pickup Date for Exhibition",
                    'remainder_date'=> $request['pickup_date'],
                    'user_id'=> Auth::id(),
                    'exhibition_id'=> $Exhibition->id,
                ]);
            }
            
            if(isset($request['location_name']) && $request['location_name']!=''){
                $location_values = Location::create([
                    'name' => $request['location_name'],
                    'user_id'=> Auth::id(),
                ]);
                $exhibition = Exhibition::where('id',$Exhibition['id'])->where('user_id',Auth::id())->first();
                $exhibition->location_id = $location_values->id;
                $exhibition->save();
            }
            return response()->json(['status'=>'success','message'=>__('string.backend.create.exhibitions.exhibition_created_successfully'), 'type'=>'1']);
           }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Exhibition  $exhibitions
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $exhibitionPieces = ExhibitionPieces::where('user_id',Auth::id())->where('exhibition_id',$id)->get();
            if(isset($exhibitionPieces) && count($exhibitionPieces) > 0){
                foreach($exhibitionPieces as $pieces) {
                    $pieces_id[] = $pieces->pieces_id;
                }
                $pieces = Pieces::whereNotIn('id', $pieces_id)->where('user_id',Auth::id())->get();
            }else{
                $pieces = Pieces::where('user_id',Auth::id())->get();
            }
            $user = User::with('user_status')->where('id',Auth::id())->first();
            $exhibitions = Exhibition::with('location')->with('country_name')->where('id',$id)->where('user_id',Auth::id())->first();
            $total_submitted_works = ExhibitionPieces::where('exhibition_id',$id)->where('user_id',Auth::id())->count();
            $total_pending_works = ExhibitionPieces::where('exhibition_id',$id)->where('status',1)->where('user_id',Auth::id())->count();
            $total_accepted_works = ExhibitionPieces::where('exhibition_id',$id)->where('status',2)->where('user_id',Auth::id())->count();
            $total_non_accepted_works = ExhibitionPieces::where('exhibition_id',$id)->where('status',3)->where('user_id',Auth::id())->count();
            if(isset($exhibitions)){
                return view('pages.exhibitions.show', compact('exhibitions','user','pieces','total_submitted_works','total_pending_works','total_accepted_works','total_non_accepted_works'));
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
     * @param  \App\Models\Exhibition  $exhibitions
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $exhibition = Exhibition::where('id',$id)->where('user_id',Auth::id())->first();
            $user = User::with('user_status')->where('id',Auth::id())->first();
            $countries = Country::get();
            $locations = Location::with('user')->where('user_id',Auth::id())->get();
            if(isset($exhibition)){
                return view('pages.exhibitions.create', compact('exhibition','user','countries','locations'));
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
     * @param  \App\Models\Exhibition  $exhibitions
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Exhibition $exhibitions)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Exhibition  $exhibitions
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Exhibition = Exhibition::where('id',$id)->where('user_id',Auth::id())->first();
        $ExhibitionPieces = ExhibitionPieces::where('exhibition_id',$id)->where('user_id',Auth::id())->delete();
        $Exhibition->delete();

        return response()->json(['status'=>'success','message'=>__('string.backend.create.exhibitions.exhibition_deleted_successfully')]);
    }

    // assign pieces
    public function assignPieces(Request $request)
    {
        $request->validate([
            'pieces_id' => 'required',
        ]);
        try {
            if(isset($request['award_name'])){
                $is_award = true;
            }else{
                $is_award = false;
            }
            $ExhibitionPieces = ExhibitionPieces::create([
                'pieces_id' => $request['pieces_id'],
                'status' => $request['status'],
                'exhibition_id' => $request['exhibition_id'],
                'award_name' => $request['award_name'],
                'is_award' => $is_award,
                'user_id' => Auth::id(),
            ]);
            return response()->json(['status'=>'success','message'=>__('string.backend.create.exhibitions.pieces_assigned_successfully'), 'type'=>'1']);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    // get pieces by Exhibition
    public function getAssignPiecesByExhibitions(Request $request, $exhibitions_id){
        if ($request->ajax()) {
            $id = $exhibitions_id;
            $data = ExhibitionPieces::with('pieces')->select('*')->where('user_id',Auth::id())->where('exhibition_id',$id)->get();
            return Datatables::of($data)->addIndexColumn()
            ->addColumn('pieces_detail', function($row){
                if(isset($row->pieces)){
                    return $row->pieces->title;
                }else{
                    return '-';
                }
            })
            ->addColumn('status', function($row){
                $status1 = $row->status==1 ? 'selected-button-color' : '';
                $status2 = $row->status==2 ? 'selected-button-color' : '';
                $status3 = $row->status==3 ? 'selected-button-color' : '';
                $btn = '<div class="">
                    <button type="button" class="btn btn-sm btn-outline-primary mr-2 '.$status1.'" onClick="changeStatus('.$row->id.',1)">Submitted</button>
                    <button type="button" class="btn btn-sm btn-outline-primary mr-2 '.$status2.'" onClick="changeStatus('.$row->id.',2)">Accepted</button>
                    <button type="button" class="btn btn-sm btn-outline-primary mr-2 '.$status3.'" onClick="changeStatus('.$row->id.',3)">Not Accepted</button>
                    </div>';
                return $btn;
            })
            ->addColumn('award_name', function($row){
                return $row->award_name;
            })
            ->addColumn('action', function($row){
                $btn = '<div class="">
                    <a href="#" class="btn btn-danger font-weight-bold btn-pill mr-2" onClick="exhibitionPiecesDelete('.$row->id.')"> '.__('buttons.backend.general.crud.delete').'</a>
                    </div>';
                return $btn;
                })
            ->rawColumns(['editions','action','status','award_name'])
            ->make(true);
        }else{
            abort(404);
        }
    }
    public function changeExhibitionsPiecesStatus(Request $request)
    {
        try {
            $status = $request->status;
            $exhibitions_id = $request->exhibitions_id;
            $ExhibitionPieces = ExhibitionPieces::where('id',$exhibitions_id)->where('user_id',Auth::id())->first();
            $ExhibitionPieces['status'] = $status;
            $ExhibitionPieces->save();
            return response()->json(['status'=>'success','message'=>__('string.backend.create.pieces.saved')]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['status'=>'error','message'=>'Something is wrong!']);
        }
    }
    public function removeExhibitionsPieces(Request $request)
    {
        try {
            $exhibitions_pieces_id = $request->exhibitions_id;
            $ExhibitionPieces = ExhibitionPieces::where('id',$exhibitions_pieces_id)->where('user_id',Auth::id())->first();
            $ExhibitionPieces->delete();
            return response()->json(['status'=>'success','message'=>__('string.backend.create.exhibitions.exhibition_pieces_deleted_successfully')]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['status'=>'error','message'=>'Something is wrong!']);
        }
    }
    // Copy Exhibition
    public function copyExhibitions(Request $request)
    {
        try {
            $exhibitions_id = $request->exhibitions_id;
            $ExhibitionPieces = Exhibition::where('id',$exhibitions_id)->where('user_id',Auth::id())->first();
            if (strpos($ExhibitionPieces['name'], '(copy)') !== false) {
                $name = $ExhibitionPieces['name'];
            }else{
                $name = $ExhibitionPieces['name'].' (copy)';
            }
            Exhibition::create([
                'fee' => $ExhibitionPieces['fee'],
                'website' => $ExhibitionPieces['website'],
                'email' => $ExhibitionPieces['email'],
                'fee' => $ExhibitionPieces['fee'],
                'phone' => $ExhibitionPieces['phone'],
                'address_line1' => $ExhibitionPieces['address_line1'],
                'address_line2' => $ExhibitionPieces['address_line2'],
                'city' => $ExhibitionPieces['city'],
                'state' => $ExhibitionPieces['state'],
                'zip' => $ExhibitionPieces['zip'],
                'country' => $ExhibitionPieces['country'],
                'show_type' => $ExhibitionPieces['show_type'],
                'solo_group_show' => $ExhibitionPieces['solo_group_show'],
                'description' => $ExhibitionPieces['description'],
                'notes' => $ExhibitionPieces['notes'],
                'location_id' => $ExhibitionPieces['location_id'],
                'name' => $name,
                'user_id' => Auth::id(),
            ]);
            return response()->json(['status'=>'success','message'=>__('string.backend.create.exhibitions.exhibition_copied_successfully')]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['status'=>'error','message'=>'Something is wrong!']);
        }
    }
}
