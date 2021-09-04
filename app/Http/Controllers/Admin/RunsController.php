<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Runs;
use App\Models\Works;
use App\Models\Pieces;
use Auth;
use Yajra\DataTables\DataTables;

class RunsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Runs::select('*')->where('user_id',Auth::id())->get();
            return Datatables::of($data)->addIndexColumn()
            ->addColumn('works', function($row){
                $works = '';
                if(isset($row->prints_count)){
                    $works.= $row->prints_count;
                }
                if(isset($row->proofs_count)){
                    $works.= '('.$row->proofs_count.' proofs)';
                }
                return $works;
            })
            ->addColumn('sold', function($row){
                return 0;
            })
            ->addColumn('in_location', function($row){
                $data = Works::where('run_id',$row->id)->where('piece_id',$row->piece_id)->where('location_id','!=',0)->where('user_id',Auth::id())->count();
                return $data;
            })
            ->addColumn('action', function($row){
            $btn = '<div class="">
                <a href="'.route('runs.edit',$row->id).'" class="btn btn-primary font-weight-bold btn-pill mr-2">'.__('buttons.backend.general.crud.edit').'</a>
                <a href="#" class="btn btn-danger font-weight-bold btn-pill mr-2" onClick="runsDelete('.$row->id.')"> '.__('buttons.backend.general.crud.delete').'</a>
                <a href="'.route('runs.show',$row->id).'" class="btn btn-success font-weight-bold btn-pill mr-2">View</a>
                </div>';
            return $btn;
            })
            ->rawColumns(['works','sold','sales','in_location','action'])
            ->make(true);
        }
        $page_title = 'Runs or Reprodction';
        $page_description = 'Some description for the Runs or Reprodction';
        $user = User::with('user_status')->where('id',Auth::id())->first();
        return view('pages.runs.index', compact('page_title', 'page_description','user'));
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
        return view('pages.runs.create',compact('user', 'pieces'));
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
        if (isset($request['runs_id']) && $request['runs_id']!='') {
            $request->validate([
                'name' => 'required',
            ]);
        }else{
            $request->validate([
                'piece_id' => 'required',
                'name' => 'required',
                'prints_count' => 'required',
            ]);
        }
        try {
            $signed = isset($request['signed']) && $request['signed']=='1'?true:false;
            if(isset($request['runs_id']) && $request['runs_id']!=''){
                $runs = Runs::where('id',$request['runs_id'])->where('user_id',Auth::id())->first();
                $runs->name = $request['name'];
                $runs->creation_date = $request['creation_date'];
                $runs->medium = $request['medium'];
                $runs->cost = $request['cost'];
                $runs->size_height = $request['size_height'];
                $runs->size_width = $request['size_width'];
                $runs->size_depth = $request['size_depth'];
                $runs->notes = $request['notes'];
                $runs->signed = $signed;
                $runs->save();
                return response()->json(['status'=>'success','message'=>'Run Updated Successfully.','type'=>'2']);
            }else{
                $runs = Runs::create([
                    'name' => $request['name'],
                    'creation_date' => $request['creation_date'],
                    'medium' => $request['medium'],
                    'cost' => $request['cost'],
                    'prints_count' => $request['prints_count'],
                    'sales_price' => $request['sales_price'],
                    'proofs_count' => $request['proofs_count'],
                    'size_height' => $request['size_height'],
                    'size_width' => $request['size_width'],
                    'size_depth' => $request['size_depth'],
                    'signed' => $signed,
                    'notes' => $request['notes'],
                    'piece_id' => $request['piece_id'],
                    'user_id' => Auth::id(),
                ]);
                for($i=1;$i<=$request['prints_count'];$i++){
                    Works::create([
                        'run_id' => $runs->id,
                        'piece_id' => $request['piece_id'],
                        'user_id' => Auth::id(),
                        'location_id' => 0,
                    ]);
                }
                return response()->json(['status'=>'success','message'=>'Run Created Successfully.','type'=>'1']);
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
        $runs = Runs::with('pieces_detail')->with('pieces_images')->where('user_id',Auth::id())->where('id',$id)->first();
        if(isset($runs)){
            $page_title = 'Show Runs or Reprodction';
            $page_description = 'Some description for the Runs or Reprodction';
            $user = User::with('user_status')->where('id',Auth::id())->first();
    
            $run_details = array();
            if(isset($runs->creation_date)){
                $medium['key'] = 'Print Date';
                $medium['value'] = isset($runs->creation_date)?date('F jS, Y',strtotime($runs->creation_date)):'-'; 
            }
            $medium['key'] = 'Medium';
            $medium['value'] = isset($runs->medium)?$runs->medium:'-';
            $size['key'] = 'Size (h w d)';
            $size['value'] = isset($runs->size_height) && isset($runs->size_width) && isset($runs->size_depth)?$runs->size_height.'.0 X '.$runs->size_width.'.0 X '.$runs->size_depth.'.0':'-';
            $signed['key'] = 'Signed';
            $signed['value'] = isset($runs->signed) && $runs->signed=='1'?'Yes':'No';
            $cost['key'] = 'Your Cost';
            $cost['value'] = isset($runs->cost)?$runs->cost:'-';
            $works['key'] = 'Total Works';
            $works['value'] = isset($runs->prints_count)?$runs->prints_count:'-';
            $proofs['key'] = 'Total Proofs';
            $proofs['value'] = isset($runs->proofs_count)?$runs->proofs_count:'-';
            $location['key'] = 'Number In Location';
            $location['value'] = 0;
            $sold['key'] = 'Number Sold';
            $sold['value'] = 0;
            array_push($run_details,$medium);
            array_push($run_details,$size);
            array_push($run_details,$signed);
            array_push($run_details,$cost);
            array_push($run_details,$works);
            array_push($run_details,$proofs);
            array_push($run_details,$location);
            array_push($run_details,$sold);
            return view('pages.runs.show', compact('page_title', 'page_description','user','runs','run_details'));
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
        $runs = Runs::where('id',$id)->where('user_id',Auth::id())->first();
        $user = User::with('user_status')->where('id',Auth::id())->first();
        $pieces = Pieces::where('user_id',Auth::id())->get();
        if(isset($runs)){
            return view('pages.runs.create',compact('user','pieces','runs'));
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
        $runs = Runs::where('id',$id)->where('user_id',Auth::id())->first();
        if(isset($runs)){
            Works::where('run_id',$runs->id)->where('user_id',Auth::id())->delete();
            Runs::find($id)->delete();
        }
        return response()->json(['status'=>'success','message'=>'Runs deleted successfully.']);
    }
}
