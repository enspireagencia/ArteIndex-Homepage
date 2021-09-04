<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Inbox;
use App\Models\Collection;
use App\Models\User;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use Auth;
class InboxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()) {
            $data = Inbox::with('user')->where('archive_id', 0)->where('user_id',Auth::id())->with('pieces_detail')->with('private_room')->get();
            return Datatables::of($data)->addIndexColumn()

            ->addColumn('message_info', function($row){
                $message = '';
                if($row->type==1){
                    $message .='<p><i class="far fa-envelope"></i>  Pieces Inquiry </p>
                         <p> '.substr($row->message, 0, 100).' </p>';
                }else{
                    $message .='<p><i class="far fa-envelope"></i>  Message</p>
                         <p> '.substr($row->message, 0, 100).' </p>';
                }
                return $message;
                
            })

            ->addColumn('sender_info', function($row){
                return
                '<p>'.$row->name.'</p>
                 <p>'.$row->email.'</p>
                 <p>'.$row->phone.'</p>';
            })
            ->addColumn('details', function($row){
                $details = '';
                if ($row->type==1) {
                    if (isset($row->private_room)) {
                        $date = date("F j, Y",strtotime($row->created_at));
                        $details .= '<span>'.$date.' </span></br> <a href="'.route('rooms_pieces_lists', $row->private_room->slug).'" target="_blank"> from PrivateRoom </a>';
                    }else{
                        $date = date("F j, Y",strtotime($row->created_at));
                        $details .= '<span>'.$date.' </span></br> <a href="'.route('profile', $row->user->user_unique_id).'" target="_blank"> from Profile </a>';
                    }
                }else{
                        $date = date("F j, Y",strtotime($row->created_at));
                        $details .= '<span>'.$date.' </span></br> <a href="'.route('profile', $row->user->user_unique_id).'" target="_blank"> from Profile </a>';
                }
                return $details;
            })

            ->addColumn('action', function($row){
                $btn = '';
                if($row->type==1){
                    $varid="'#p".$row->id."'";
                    $btn = '<div class="">
                    <a href="'.route('inbox.show',encrypt($row->id)).'" class="btn btn-success font-weight-bold btn-pill mr-2">View</a>
                    <input type="hidden" class="form-control form-control-solid" id="p'.$row->id.'" value='.$row->email.' readonly/>
                    <a href="#" class="btn btn-primary font-weight-bold btn-pill mr-2 dropdown-toggle"
                        data-toggle="dropdown" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Replay </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="mailto:'.$row->email.' ?subject=Piece Inquiry for artwork '.$row->pieces_detail->title.'" target="_blank">Direct Email</a>
                            <a class="dropdown-item" href="https://mail.google.com/mail/?view=cm&fs=1&tf=1&to='.$row->email.' &su=Piece Inquiry for artwork '.$row->pieces_detail->title.'" target="_blank">Gmail</a>
                            <a class="dropdown-item" href="https://outlook.live.com/owa/#subject=Piece Inquiry for artwork '.$row->pieces_detail->title.'&to='.$row->email.'" target="_blank">Outlook</a>
                            <a class="dropdown-item" href="https://compose.mail.yahoo.com/?to='.$row->email.'&subj=Piece Inquiry for artwork '.$row->pieces_detail->title.'" target="_blank">Yahoo</a>
                            <a class="dropdown-item" href="javascript:void(0)" onclick="copyToClipboard('.$varid.')">Copy Email Address</a>
                        </div>
                    <button class="btn btn-warning font-weight-bold btn-pill mr-2" onclick="archive('.$row->id.')"> Archive </button>
                    <a href="#" class="btn btn-danger font-weight-bold btn-pill mr-2" onClick="inboxDelete('.$row->id.')"> '.__('buttons.backend.general.crud.delete').'</a>
                    </div>';
                }else{
                    $varid="'#p".$row->id."'";
                    $btn = '<div class="">
                    <a href="'.route('inbox.show',encrypt($row->id)).'" class="btn btn-success font-weight-bold btn-pill mr-2">View</a>
                    <input type="hidden" class="form-control form-control-solid" id="p'.$row->id.'" value='.$row->email.' readonly/>
                    <a href="#" class="btn btn-primary font-weight-bold btn-pill mr-2 dropdown-toggle"
                        data-toggle="dropdown" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Replay </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="mailto:'.$row->email.' ?subject=Message for artwork '.$row->user->name.'" target="_blank">Direct Email</a>
                            <a class="dropdown-item" href="https://mail.google.com/mail/?view=cm&fs=1&tf=1&to='.$row->email.' &su=Message for artwork '.$row->user->name.'" target="_blank">Gmail</a>
                            <a class="dropdown-item" href="https://outlook.live.com/owa/#subject=Message for artwork '.$row->user->name.'&to='.$row->email.'" target="_blank">Outlook</a>
                            <a class="dropdown-item" href="https://compose.mail.yahoo.com/?to='.$row->email.'&subj=Message for artwork '.$row->user->name.'" target="_blank">Yahoo</a>
                            <a class="dropdown-item" href="javascript:void(0)" onclick="copyToClipboard('.$varid.')">Copy Email Address</a>
                        </div>
                    <button class="btn btn-warning font-weight-bold btn-pill mr-2" onclick="archive('.$row->id.')"> Archive </button>
                    <a href="#" class="btn btn-danger font-weight-bold btn-pill mr-2" onClick="inboxDelete('.$row->id.')"> '.__('buttons.backend.general.crud.delete').'</a>
                    </div>';
                }
               
                return $btn;
            })

            ->rawColumns(['action', 'image', 'message_info', 'sender_info', 'details'])
            ->make(true);
        }
        $data = Inbox::with('pieces_detail')->with('private_room')->get();
        $user = User::with('user_status')->where('id',Auth::id())->first();
        return view('pages.inbox.index', compact('data','user'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Inbox  $inbox
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $inbox = Inbox::where('id', decrypt($id))->with('pieces_detail')->first();
        $user = User::with('user_status')->where('id',Auth::id())->first();
        if(isset($inbox->pieces_detail)){
            $coll = explode(',',$inbox->pieces_detail->collections_id);
            $collections = Collection::whereIn('id',$coll)->where('user_id',Auth::id())->get();
            return view('pages.inbox.show', compact('inbox', 'collections','user'));
        }else{
            return view('pages.inbox.show', compact('inbox','user'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Inbox  $inbox
     * @return \Illuminate\Http\Response
     */
    public function edit(Inbox $inbox)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Inbox  $inbox
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Inbox $inbox)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Inbox  $inbox
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $inbox = Inbox::where('id', $id)->with('pieces_detail')->first();
        $inbox->delete();
        return response()->json(['status'=>'success','message'=>__('string.backend.create.inbox.inbox_deleted_successfully')]);
    }

    public function archive(Request $request)
    {
       $status = $request->status;
       $id = $request->archive_id;
       $data = Inbox::where('id', $id)->where('user_id',Auth::id())->first();
       $data->archive_id = $status;
       $data->save();
       return response()->json(['status'=>'success','message'=>"Archive Created Successfully."]);
    }

    public function unarchivess(Request $request)
    {
        if($request->ajax()) {
            $data = Inbox::with('user')->where('archive_id', 1)->where('user_id',Auth::id())->with('pieces_detail')->with('private_room')->get();
            return Datatables::of($data)->addIndexColumn()
            ->addColumn('message_info', function($row){
                $message = '';
                if($row->type==1){
                    $message .='<p><i class="far fa-envelope"></i>  Pieces Inquiry </p>
                         <p> '.substr($row->message, 0, 100).' </p>';
                }else{
                    $message .='<p><i class="far fa-envelope"></i>  Message</p>
                         <p> '.substr($row->message, 0, 100).' </p>';
                }
                return $message;
            })

            ->addColumn('sender_info', function($row){
                return
                '<p>'.$row->name.'</p>
                 <p>'.$row->email.'</p>
                 <p>'.$row->phone.'</p>';
            })

            ->addColumn('details', function($row){
                $details = '';
                if ($row->type==1) {
                    if (isset($row->private_room)) {
                        $date = date("F j, Y",strtotime($row->created_at));
                        $details .= '<span>'.$date.' </span></br> <a href="'.route('rooms_pieces_lists', $row->private_room->slug).'" target="_blank"> from PrivateRoom </a>';
                    }else{
                        $date = date("F j, Y",strtotime($row->created_at));
                        $details .= '<span>'.$date.' </span></br> <a href="'.route('profile', $row->user->user_unique_id).'" target="_blank"> from Profile </a>';
                    }
                }else{
                        $date = date("F j, Y",strtotime($row->created_at));
                        $details .= '<span>'.$date.' </span></br> <a href="'.route('profile', $row->user->user_unique_id).'" target="_blank"> from Profile </a>';
                }
                return $details;
                
            })

            ->addColumn('action', function($row){
                if($row->type==1){
                    $varid="'#p".$row->id."'";
                    $btn = '<div class="">
                    <a href="'.route('inbox.show',encrypt($row->id)).'" class="btn btn-success font-weight-bold btn-pill mr-2">View</a>
                    <input type="hidden" class="form-control form-control-solid" id="p'.$row->id.'" value='.$row->email.' readonly/>
                        <a href="#" class="btn btn-primary font-weight-bold btn-pill mr-2 dropdown-toggle"
                        data-toggle="dropdown" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Replay </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item" href="mailto:'.$row->email.' ?subject=Piece Inquiry for artwork '.$row->pieces_detail->title.'" target="_blank">Direct Email</a>
                                <a class="dropdown-item" href="https://mail.google.com/mail/?view=cm&fs=1&tf=1&to='.$row->email.' &su=Piece Inquiry for artwork '.$row->pieces_detail->title.'" target="_blank">Gmail</a>
                                <a class="dropdown-item" href="https://outlook.live.com/owa/#subject=Piece Inquiry for artwork '.$row->pieces_detail->title.'&to='.$row->email.'" target="_blank">Outlook</a>
                                <a class="dropdown-item" href="http://compose.mail.yahoo.com/?to='.$row->email.'&subj=Piece Inquiry for artwork '.$row->pieces_detail->title.'" target="_blank">Yahoo</a>
                                <a class="dropdown-item" href="javascript:void(0)" onclick="copyToClipboard('.$varid.')">Copy Email Address</a>
                            </div>
                        <button class="btn btn-warning font-weight-bold btn-pill mr-2" onclick="archive('.$row->id.')"> UnArchive </button>
                        <a href="#" class="btn btn-danger font-weight-bold btn-pill mr-2" onClick="inboxDelete('.$row->id.')"> '.__('buttons.backend.general.crud.delete').'</a>
                        </div>';
                }else{
                    $varid="'#p".$row->id."'";
                    $btn = '<div class="">
                    <a href="'.route('inbox.show',encrypt($row->id)).'" class="btn btn-success font-weight-bold btn-pill mr-2">View</a>
                    <input type="hidden" class="form-control form-control-solid" id="p'.$row->id.'" value='.$row->email.' readonly/>
                    <a href="#" class="btn btn-primary font-weight-bold btn-pill mr-2 dropdown-toggle"
                        data-toggle="dropdown" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Replay </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="mailto:'.$row->email.' ?subject=Message for artwork '.$row->user->name.'" target="_blank">Direct Email</a>
                            <a class="dropdown-item" href="https://mail.google.com/mail/?view=cm&fs=1&tf=1&to='.$row->email.' &su=Message for artwork '.$row->user->name.'" target="_blank">Gmail</a>
                            <a class="dropdown-item" href="https://outlook.live.com/owa/#subject=Message for artwork '.$row->user->name.'&to='.$row->email.'" target="_blank">Outlook</a>
                            <a class="dropdown-item" href="https://compose.mail.yahoo.com/?to='.$row->email.'&subj=Message for artwork '.$row->user->name.'" target="_blank">Yahoo</a>
                            <a class="dropdown-item" href="javascript:void(0)" onclick="copyToClipboard('.$varid.')">Copy Email Address</a>
                        </div>
                        <button class="btn btn-warning font-weight-bold btn-pill mr-2" onclick="archive('.$row->id.')"> UnArchive </button>
                    <a href="#" class="btn btn-danger font-weight-bold btn-pill mr-2" onClick="inboxDelete('.$row->id.')"> '.__('buttons.backend.general.crud.delete').'</a>
                    </div>';
                }
                return $btn;
            })

            ->rawColumns(['action', 'image', 'message_info', 'sender_info', 'details'])
            ->make(true);
        }
        $user = User::with('user_status')->where('id',Auth::id())->first();
        return view('pages.inbox.indexes',compact('user'));
    }
}
