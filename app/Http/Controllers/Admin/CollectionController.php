<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Collection;
use Auth;
use Yajra\DataTables\DataTables;
use App\Models\User;
use App\Models\Pieces;

class CollectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Collection::select('*')->where('user_id',Auth::id())->get();
            return Datatables::of($data)->addIndexColumn()
            ->addColumn('pieces_count', function($row){
                $pieces = Pieces::where('user_id',Auth::id())->get();
                $cnt = 0;
                if (isset($pieces) && count($pieces)>0) {
                    foreach ($pieces as $key => $value) {
                        $collections_id = explode(",", $value->collections_id);
                        if (($key = array_search($row->id, $collections_id)) !== false) {
                            $cnt++;
                        }
                    }
                }
                return $cnt; 
            })
            ->addColumn('action', function($row){
            $btn = '<div class="">
                <a href="'.route('collections.edit',$row->id).'" class="btn btn-primary font-weight-bold btn-pill mr-2">'.__('buttons.backend.general.crud.edit').'</a>
                <a href="#" class="btn btn-danger font-weight-bold btn-pill mr-2" onClick="collectionDelete('.$row->id.')"> '.__('buttons.backend.general.crud.delete').'</a>
                </div>';
            return $btn;
            })
            ->rawColumns(['action','pieces_count'])
            ->make(true);
        }
        $page_title = 'Collection';
        $page_description = 'Some description for the page';
        $user = User::with('user_status')->where('id',Auth::id())->first();
        return view('pages.collections.index', compact('page_title', 'page_description','user'));
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
        return view('pages.collections.create',compact('user','pieces'));
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
            'collection_name' => 'required',
        ]);
        try {
            if(isset($request['pieces_id'])){
                $pieces_id = implode(",",$request['pieces_id']);
            }else{
                $pieces_id = null;
            }
            
            $hide_from_public = isset($request['hide_from_public']) && $request['hide_from_public']=='1'?true:false;
            if (isset($request['collection_id']) && $request['collection_id']!='') {
                $collection = Collection::where('id',$request['collection_id'])->where('user_id',Auth::id())->first();
                $collection->collection_name = $request['collection_name'];
                $collection->description = $request['description'];
                $collection->hide_from_public = $hide_from_public;
                $collection->save();
                
                if(isset($pieces_id)){
                    $piecesremove = Pieces::where('user_id',Auth::id())->whereNotIn('id',$request['pieces_id'])->get();
                        if(isset($piecesremove) && count($piecesremove)>0){
                            foreach ($piecesremove as $key => $value) {
                                $collections_id = explode(",",$value->collections_id);
                                if (($key = array_search($collection->id, $collections_id)) !== false) {
                                    unset($collections_id[$key]);
                                }
                                if(isset($collections_id)){
                                    $value->collections_id = implode(",",array_unique($collections_id));
                                }else{
                                    $value->collections_id = $collection->id;
                                }
                            $value->save();
                        }              
                    }
    
                    $pieces = Pieces::where('user_id',Auth::id())->whereIn('id',$request['pieces_id'])->get();
                    if(isset($pieces)){
                        foreach ($pieces as $key => $value) {
                            $collections_id = explode(",",$value->collections_id);
                            if(isset($value->collections_id) && $value->collections_id!=''){
                                $a = explode(",",$value->collections_id);
                                $a[] = (string) $collection->id;
                                $value->collections_id = implode(",",array_unique($a));
                            }else{
                                $value->collections_id = $collection->id;
                            }
                            $value->save();
                        }              
                    }
                }else{
                    $pieces = Pieces::where('user_id',Auth::id())->get();
                    if (isset($pieces) && count($pieces)>0) {
                        foreach ($pieces as $key => $value) {
                            $collections_id = explode(",", $value->collections_id);
                            if (($key = array_search($collection->id, $collections_id)) !== false) {
                                unset($collections_id[$key]);
                            }
                            if (isset($collections_id)) {
                                $value->collections_id = implode(",", array_unique($collections_id));
                            } else {
                                $value->collections_id = $collection->id;
                            }
                            $value->save();
                        }
                    }
                }
                

                return response()->json(['status'=>'success','message'=>__('string.backend.create.collections.collection_updated_successfully'),'type'=>'2']);
            }else{
                $collection_value = Collection::create([
                    'collection_name' => $request['collection_name'],
                    'user_id' => Auth::id(),
                    'description' => $request['description'],
                    'hide_from_public' => $hide_from_public,
                ]);
                if (isset($pieces_id)) {
                    $pieces = Pieces::where('user_id',Auth::id())->whereIn('id',$request['pieces_id'])->get();
                    if(isset($pieces)){
                        foreach ($pieces as $key => $value) {
                            if(isset($value->collections_id) && $value->collections_id!=''){
                                $collections_id = explode(",",$value->collections_id);
                                $a = explode(",",$value->collections_id);
                                $a[] = (string) $collection_value->id;
                                $value->collections_id = implode(",",array_unique($a));
                            }else{
                                $value->collections_id = $collection_value->id;
                            }
                            $value->save();
                        }              
                    }
                }
                
                return response()->json(['status'=>'success','message'=>__('string.backend.create.collections.collection_added_successfully'),'type'=>'1']);
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
        $collection = Collection::where('id',$id)->where('user_id',Auth::id())->first();
        if(isset($collection)){
            $user = User::with('user_status')->where('id',Auth::id())->first();
            $pieces = Pieces::where('user_id',Auth::id())->get();
            return view('pages.collections.create',compact('user','collection','pieces'));
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
        $collection = Collection::where('id',$id)->where('user_id',Auth::id())->first();
        if(isset($collection)){
            $pieces = Pieces::where('user_id',Auth::id())->get();
            if (isset($pieces) && count($pieces)>0) {
                foreach ($pieces as $key => $value) {
                    $collections_id = explode(",", $value->collections_id);
                    if (($key = array_search($collection->id, $collections_id)) !== false) {
                        unset($collections_id[$key]);
                    }
                    if (isset($collections_id)) {
                        $value->collections_id = implode(",", array_unique($collections_id));
                    } else {
                        $value->collections_id = $collection->id;
                    }
                    $value->save();
                }
            }    
            Collection::find($id)->delete();
        }
        return response()->json(['status'=>'success','message'=>__('string.backend.create.collections.collections_deleted_successfully')]);
    }
}
