<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\Exhibition;
use Auth;
use Yajra\DataTables\DataTables;
use App\Models\User;
use App\Models\Pieces;
use Carbon\Carbon;
use DB;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Schedule::select('*')->with('exhibition_detail')->where('user_id',Auth::id())->orderBy('remainder_date','asc');
            return Datatables::of($data)->addIndexColumn()
            ->filter(function ($instance) use ($request) {
                if (!empty($request->get('select_filter'))) {
                    if($request->get('select_filter') == 1){
                        $instance->where(function($w){
                            $w->where('remainder_date', '<', Carbon::now()->subDays());
                        });
                    }
                    if($request->get('select_filter') == 2){
                        $instance->where(function($w){
                            $w->whereBetween('remainder_date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                        });
                    }
                    if($request->get('select_filter') == 3){
                        $previous_week = strtotime("+1 week +1 day");
                        $start_week = strtotime("last monday",$previous_week);
                        $end_week = strtotime("next sunday",$start_week);
                        $start_week = date("Y-m-d",$start_week);
                        $end_week = date("Y-m-d",$end_week);
                        $instance->where(function($w) use($start_week, $end_week){
                            $w->whereBetween('remainder_date', [$start_week, $end_week]);
                        });
                    }
                    if($request->get('select_filter') == 4){
                        $instance->where(function($w){
                            $w->whereMonth('remainder_date', '=', Carbon::now()->addMonth()->month);
                        });
                    }
                    if($request->get('select_filter') == 5){
                        $instance->where(function($w){
                            $w->whereYear('remainder_date', '=', Carbon::now()->addYear()->year);
                        });
                    }
                }
            })
            ->addColumn('remainder_date', function($row){
                if($row->remainder_date > date('Y-m-d')){
                    return '<span>'.$row->remainder_date.'</span>';
                }else{
                    return '<span class="red-color">'.$row->remainder_date.'</span>';
                }
            })
            ->addColumn('message', function($row){
                $exhibition_name = isset($row->exhibition_detail->name) ? $row->exhibition_detail->name : '';
                if($exhibition_name){
                    $exhibition = '<a href="'.route('exhibitions.show',$row->exhibition_id).'">'.$exhibition_name.'</a>';
                }else{
                    $exhibition = '';
                }
                if($row->status == 1){
                    return '<strike>'.$row->message."</strike> ".$exhibition.' <span class="label label-lg label-light-success label-inline font-weight-bold py-4">'.__('buttons.backend.general.crud.done').'</span>';
                }else{
                    return $row->message." ".$exhibition;
                }
            })
            ->addColumn('action', function($row){
                if(!isset($row->exhibition_detail)){
                    $edit_exhibition = '<a href="'.route('schedule.edit',$row->id).'" class="btn btn-primary font-weight-bold btn-pill mr-2">'.__('buttons.backend.general.crud.edit').'</a>';
                    if($row->status == 0){
                        $status_schedule = '<button class="btn btn-warning font-weight-bold btn-pill mr-2" onclick="statusSchedule('.$row->id.')"> '.__('buttons.backend.general.crud.complete').' </button>';
                    }else{
                        $status_schedule = '';
                    }
                }else{
                    $edit_exhibition = '';
                    $status_schedule = '';
                }

                $btn = '<div class="">
                    '.$edit_exhibition.'
                    '.$status_schedule.'
                    <a href="#" class="btn btn-danger font-weight-bold btn-pill mr-2" onClick="scheduleDelete('.$row->id.')"> '.__('buttons.backend.general.crud.delete').'</a>
                    </div>';
                return $btn;
            })
            ->rawColumns(['action','message','remainder_date'])
            ->make(true);
        }
        $page_title = 'Schedule';
        $page_description = 'Some description for the page';
        $user = User::with('user_status')->where('id',Auth::id())->first();
        return view('pages.schedule.index', compact('page_title', 'page_description','user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = User::with('user_status')->where('id',Auth::id())->first();
        return view('pages.schedule.create',compact('user'));
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
            'remainder_date' => 'required',
            'message' => 'required',
        ]);
        try {
            if (isset($request['schedule_id']) && $request['schedule_id']!='') {
                $status = isset($request['status']) && $request['status']=='1'?true:false;
                $schedule = Schedule::where('id',$request['schedule_id'])->where('user_id',Auth::id())->first();
                $schedule->remainder_date = $request['remainder_date'];
                $schedule->message = $request['message'];
                $schedule->status = $status;
                $schedule->save();
                return response()->json(['status'=>'success','message'=>__('string.backend.create.schedule.schedule_updated_successfully'),'type'=>'2']);
            }else{
                $schedule_value = Schedule::create([
                    'remainder_date' => $request['remainder_date'],
                    'message' => $request['message'],
                    'user_id' => Auth::id(),
                    'status' => 0,
                ]);
                return response()->json(['status'=>'success','message'=>__('string.backend.create.schedule.schedule_added_successfully'),'type'=>'1']);
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
        $schedule = Schedule::where('id',$id)->where('user_id',Auth::id())->first();
        if(isset($schedule)){
            $user = User::with('user_status')->where('id',Auth::id())->first();
            return view('pages.schedule.create',compact('user','schedule'));
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
        $schedule = Schedule::where('id',$id)->where('user_id',Auth::id())->first();
        if(isset($schedule)){
            Schedule::find($id)->delete();
            $exhibition = Exhibition::where('id',$schedule['exhibition_id'])->where('user_id',Auth::id())->first();
            if(isset($exhibition)){
                if($schedule->message == 'Start Date for Exhibition'){
                    $exhibition->start_date = null;
                }
                if($schedule->message == 'End Date for Exhibition'){
                    $exhibition->end_date = null;
                }
                if($schedule->message == 'Reception Date for Exhibition'){
                    $exhibition->reception_date = null;
                }
                if($schedule->message == 'Submission Deadline for Exhibition'){
                    $exhibition->submission_deadline = null;
                }
                if($schedule->message == 'Notification Date for Exhibition'){
                    $exhibition->notification_date = null;
                }
                if($schedule->message == 'Delivery Date for Exhibition'){
                    $exhibition->delivery_date = null;
                }
                if($schedule->message == 'Pickup Date for Exhibition'){
                    $exhibition->pickup_date = null;
                }
                $exhibition->save();
            }
        }
        return response()->json(['status'=>'success','message'=>__('string.backend.create.schedule.schedule_deleted_successfully')]);
    }
    public function changeScheduleStatus(Request $request)
    {
       $status = $request->status;
       $id = $request->schedule_id;
       $data = Schedule::where('id', $id)->where('user_id',Auth::id())->first();
       $data->status = $status;
       $data->save();
       return response()->json(['status'=>'success','message'=>__('string.backend.create.schedule.completed_reminder')]);
    }
}
