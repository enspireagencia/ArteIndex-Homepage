<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Edition;
use App\Models\EditionWorks;
use App\Models\Pieces;
use Auth;
use Yajra\DataTables\DataTables;

class EditionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Edition::select('*')->where('user_id',Auth::id())->get();
            return Datatables::of($data)->addIndexColumn()
            ->addColumn('works', function($row){
                $works = '';
                if(isset($row->initial_pieces)){
                    $works.= $row->initial_pieces;
                }
                if(isset($row->initial_proofs)){
                    $works.= '('.$row->initial_proofs.' proofs)';
                }
                return $works;
            })
            ->addColumn('sold', function($row){
                return 0;
            })
            ->addColumn('in_location', function($row){
                $data = EditionWorks::where('edition_id',$row->id)->where('piece_id',$row->piece_id)->where('location_id','!=',0)->where('user_id',Auth::id())->count();
                return $data;
            })
            ->addColumn('action', function($row){
            $btn = '<div class="">
                <a href="'.route('editions.edit',$row->id).'" class="btn btn-primary font-weight-bold btn-pill mr-2">'.__('buttons.backend.general.crud.edit').'</a>
                <a href="#" class="btn btn-danger font-weight-bold btn-pill mr-2" onClick="editionsDelete('.$row->id.')"> '.__('buttons.backend.general.crud.delete').'</a>
                <a href="'.route('editions.show',$row->id).'" class="btn btn-success font-weight-bold btn-pill mr-2">View</a>
                </div>';
            return $btn;
            })
            ->rawColumns(['works','sold','sales','in_location','action'])
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
        $user = User::with('user_status')->where('id',Auth::id())->first();
        $pieces = Pieces::where('user_id',Auth::id())->get();
        return view('pages.editions.create',compact('user', 'pieces'));
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
        if (isset($request['editions_id']) && $request['editions_id']!='') {
            $request->validate([
                'name' => 'required',
            ]);
        }else{
            $request->validate([
                'piece_id' => 'required',
                'name' => 'required',
                'initial_pieces' => 'required',
            ]);
        }
        try {
            $open_edition = isset($request['open_edition']) && $request['open_edition']=='true'?true:false;
            $limited_seats = isset($request['limited_seats']) && $request['limited_seats']=='true'?true:false;
            if(isset($request['editions_id']) && $request['editions_id']!=''){
                $editions = Edition::where('id',$request['editions_id'])->where('user_id',Auth::id())->first();
                if ($request->hasFile('default_image')) {
                    //upload editions
                    $patheditions='images/editions/';
                    $default_image=asset_image_put($request->default_image, $patheditions,"editions");
                    //remove old editions
                    if($default_image!=null && isset($editions->default_image) && $editions->default_image!=''){
                        asset_image_delete($editions->default_image,$patheditions);
                    }
                }else{
                    $default_image=$editions->default_image;
                }
                $editions = Edition::where('id',$request['editions_id'])->where('user_id',Auth::id())->first();
                $editions->name = $request['name'];
                $editions->open_edition = $open_edition;
                $editions->default_image = $default_image;
                $editions->limited_seats = $limited_seats;
                $editions->limitied_edition_number = $request['limitied_edition_number'];
                $editions->description = $request['description'];
                $editions->notes = $request['notes'];
                $editions->save();
                return response()->json(['status'=>'success','message'=>'Edition Updated Successfully.','type'=>'2']);
            }else{
                $default_image="";
                if ($request->hasFile('default_image')) {
                    $patheditions='images/editions/';
                    $default_image=asset_image_put($request->default_image, $patheditions,"editions");
                }
                $editions = Edition::create([
                    'name' => $request['name'],
                    'default_image'=> $default_image,
                    'open_edition' => $open_edition,
                    'limited_seats' =>$limited_seats,
                    'initial_pieces' => $request['initial_pieces'],
                    'initial_proofs' => $request['initial_proofs'],
                    'limitied_edition_number' => $request['limitied_edition_number'],
                    'description' => $request['description'],
                    'notes' => $request['notes'],
                    'piece_id' => $request['piece_id'],
                    'user_id' => Auth::id(),
                ]);
                for($i=1;$i<=$request['initial_pieces'];$i++){
                    EditionWorks::create([
                        'edition_id' => $editions->id,
                        'piece_id' => $request['piece_id'],
                        'user_id' => Auth::id(),
                        'location_id' => 0,
                    ]);
                }
                return response()->json(['status'=>'success','message'=>'Edition Created Successfully.','type'=>'1']);
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
        $editions = Edition::with('pieces_detail')->with('pieces_images')->where('user_id',Auth::id())->where('id',$id)->first();
        if(isset($editions)){
            $page_title = 'Show Edition';
            $page_description = 'Some description for the Edition';
            $user = User::with('user_status')->where('id',Auth::id())->first();
            return view('pages.editions.show', compact('page_title', 'page_description','user','editions'));
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
        $editions = Edition::where('id',$id)->where('user_id',Auth::id())->first();
        $user = User::with('user_status')->where('id',Auth::id())->first();
        $pieces = Pieces::where('user_id',Auth::id())->get();
        if(isset($editions)){
            return view('pages.editions.create',compact('user','pieces','editions'));
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
        $editions = Edition::where('id',$id)->where('user_id',Auth::id())->first();
        if(isset($editions)){
            if(isset($editions->default_image)){
                $patheditions="/images/editions/";
                asset_image_delete($editions->default_image,$patheditions);
            }
            EditionWorks::where('edition_id',$editions->id)->where('user_id',Auth::id())->delete();
            Edition::find($id)->delete();
        }
        return response()->json(['status'=>'success','message'=>'Edition deleted successfully.']);
    }

    public function removeEditionsImage($id)
    {
        $edition = Edition::where('id',$id)->where('user_id',Auth::id())->first();
        if(isset($edition)){
            //Image remove
            if(isset($edition->default_image)){
                $patheditions="/images/editions/";
                asset_image_delete($edition->default_image,$patheditions);
                $edition->default_image = null;
                $edition->save();
            }

        }
        return response()->json(['status'=>'success','message'=>"Default image removed successfully"]);
    }
}
