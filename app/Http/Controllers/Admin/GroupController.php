<?php


namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\User;
use Auth;
use Yajra\DataTables\DataTables;

class GroupController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Group::get();
            return Datatables::of($data)->addIndexColumn()
            ->addColumn('action', function($row){
            $btn = '<div class="">
                <a href="'.route('group.edit',$row->id).'" class="btn btn-primary font-weight-bold btn-pill mr-2">'.__('buttons.backend.general.crud.edit').'</a>
                <a href="#" class="btn btn-danger font-weight-bold btn-pill mr-2" onClick="editionsDelete('.$row->id.')"> '.__('buttons.backend.general.crud.delete').'</a>
                </div>';
            return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        $user = User::with('user_status')->where('id',Auth::id())->first();
        return view('pages.group.index',compact('user'));
    }


    public function create()
    {
        $user = User::with('user_status')->where('id',Auth::id())->first();
        return view('pages.group.create',compact('user'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'group_name' => 'required',
        ]);

        try {
            if(isset($request['group_id']) && $request['group_id']!=''){
                //dd("Frfrf");
                $group = Group::where('id',$request['group_id'])->where('user_id',Auth::id())->first();
                $group->group_name = $request['group_name'];
                $group->save();
                return response()->json(['status'=>'success','message'=>__('string.backend.create.group.group_updated_successfully'),'type'=>'2']);
            }else{
                //dd("tbyhyh");
                Group::create([
                    'group_name' => $request['group_name'],
                    'user_id' => Auth::id(),
                ]);
                return response()->json(['status'=>'success','message'=>__('string.backend.create.group.group_created_successfully'),'type'=>'1']);
            }
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['status'=>'eroor','message'=>'Something want wrong']);
        }
    }


    public function show(Group $group)
    {
        //
    }


    public function edit($id)
    {
        try {
            $user = User::with('user_status')->where('id',Auth::id())->first();
            $group = Group::where('id',$id)->where('user_id',Auth::id())->first();
            return view('pages.group.create', compact('group','user'));
        } catch (\Throwable $th) {
            //throw $th;
            abort(404);
        }

    }


    public function update(Request $request, Group $group)
    {
        //
    }


    public function destroy($id)
    {
        $group = Group::where('id',$id)->where('user_id',Auth::id())->first();
        $group->delete();
        return response()->json(['status'=>'success','message'=>__('string.backend.create.group.group_deleted_successfully')]);
    }
}
