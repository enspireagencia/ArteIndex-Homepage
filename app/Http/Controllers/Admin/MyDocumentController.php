<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MyDocument;
use App\Models\DocumentType;
use Auth;
use Yajra\DataTables\DataTables;
use App\Models\User;
use App\Models\Pieces;
use App\Models\Contact;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use Illuminate\Database\Eloquent\Builder;


class MyDocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        if ($request->ajax()) {
            $data = MyDocument::select('*')->with('document_type')
            ->where('user_id',Auth::id());
            return Datatables::of($data)->addIndexColumn()
            ->filter(function ($instance) use ($request) {
                if (!empty($request->get('type'))) {
                    $type = $request->get('type');
                    $instance->whereHas('type', function ($w) use($type) {
                        $w->where('name', $type);
                    });  
                }
            })
            ->addColumn('type', function($row){
                if(isset($row['document_type'])){
                    return $row['document_type']['name'];
                };
            })
            ->addColumn('action', function($row){
                $varid="'#p".$row->id."'";
                $docid="'".$row->id."'";
                $name="'".$row->name."'";
                $btn = '<div class="">
                <input type="hidden" class="form-control form-control-solid" id="p'.$row->id.'" value='.asset_image_display($row->file_url,"images/mydocument/").' readonly/>
                <a href="#" class="btn btn-primary font-weight-bold btn-pill mr-2 dropdown-toggle"
                    data-toggle="dropdown" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> '.__('datatables.backend.list.documents.action').' </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <a class="dropdown-item" href="'.asset_image_display($row->file_url,"images/mydocument/").'" target="_blank">'.__('buttons.backend.general.crud.view').'</a>
                        <a class="dropdown-item" href="'.route('document.download',encrypt($row->id)).'" >'.__('buttons.backend.general.download').'</a>
                        <a class="dropdown-item" href="javascript:void(0)" onclick="copyToClipboard('.$varid.')">'.__('buttons.backend.general.copy_url').'</a>
                        <a class="dropdown-item" href="javascript:void(0)" onclick="shereUrl('.$docid.','.$name.')">'.__('buttons.backend.general.share').'</a>
                        <a class="dropdown-item" href="'.route('documents.edit',encrypt($row->id)).'">'.__('buttons.backend.general.crud.edit').'</a>
                    </div>
                </div>';
                return $btn;
            })
            ->rawColumns(['action','pieces_count'])
            ->make(true);
        }
        $page_title = 'MyDocument';
        $page_description = 'Some description for the page';
        $contacts = Contact::where('user_id',Auth::id())->get();
        $user = User::with('user_status')->where('id',Auth::id())->first();
        // total document
        $total_resume = MyDocument::where('type_id',1)->where('user_id',Auth::id())->count();
        $total_bio = MyDocument::where('type_id',2)->where('user_id',Auth::id())->count();
        $total_statement = MyDocument::where('type_id',3)->where('user_id',Auth::id())->count();
        $total_proposal = MyDocument::where('type_id',4)->where('user_id',Auth::id())->count();
        $total_press = MyDocument::where('type_id',5)->where('user_id',Auth::id())->count();
        $total_other = MyDocument::where('type_id',6)->where('user_id',Auth::id())->count();

        $total = [
            'total_resume'=>$total_resume,
            'total_bio'=>$total_bio,
            'total_statement'=>$total_statement,
            'total_proposal'=>$total_proposal,
            'total_press'=>$total_press,
            'total_other'=>$total_other
        ];
        return view('pages.documents.index', compact('page_title', 'page_description','user','contacts','total'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = User::with('user_status')->where('id',Auth::id())->first();
        $document_type = DocumentType::all();
        return view('pages.documents.create',compact('user','document_type'));
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
            
            if (isset($request['document_id']) && $request['document_id']!='') {

                if ($request->hasFile('file')){
                    //upload my document
                    $pathpost='images/mydocument/';
                    $default_image=asset_image_put($request->file, $pathpost,"mydocument");
                    //remove old my document
                    if($default_image!=null && isset($request->old_image) && $request->old_image!=''){
                        asset_image_delete($request->old_image,$pathpost);
                    }
                    $document = MyDocument::find($request['document_id']);
                    $document->file_url =$default_image;
                    $document->save();
                }
                $document = MyDocument::where('id',$request['document_id'])->where('user_id',Auth::id())->first();
                $document->name = $request['name'];
                $document->description = $request['description'];
                $document->type_id = $request['type_id'];
                $document->date = $request['date'];
                $document->save();
                return response()->json(['status'=>'success','message'=>__('string.backend.create.documents.document_updated_successfully'),'type'=>'2']);
            }else{
                $default_image=null;
                if ($request->hasFile('file')) {
                      //upload my post
                      $pathpost='images/mydocument/';
                      $default_image=asset_image_put($request->file, $pathpost,"mydocument");
                }
                $document_value = MyDocument::create([
                    'name' => $request['name'],
                    'user_id' => Auth::id(),
                    'description' => $request['description'],
                    'type_id' => $request['type_id'],
                    'file_url' => $default_image,
                    'date' => $request['date'],
                ]);
                
                return response()->json(['status'=>'success','message'=>__('string.backend.create.documents.document_added_successfully'),'type'=>'1']);
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
        $document = MyDocument::where('id',decrypt($id))->where('user_id',Auth::id())->first();
        if(isset($document)){
            $user = User::with('user_status')->where('id',Auth::id())->first();
            $document_type = DocumentType::all();
            return view('pages.documents.create',compact('user','document','document_type'));
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
        $document = MyDocument::where('id',$id)->where('user_id',Auth::id())->first();
        if(isset($document)){   
            MyDocument::find($id)->delete();
        }
        return response()->json(['status'=>'success','message'=>__('string.backend.create.documents.documents_deleted_successfully')]);
    }

    public function shareDocumentUrl(Request $request){
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
              $doc_id = $request->document_shere_id;
              $document = MyDocument::find($doc_id);
              $url = asset_image_display($document['file_url'],"images/mydocument/");
              $array = array(
                  'view' =>'pages.mail.share_document_url',
                  'subject' =>Auth()->user()->name.' shared a Document with you:'.' - '.$document->name,
                  'from' =>env('MAIL_USERNAME'),
                  'from_name' =>Auth()->user()->name,
                  'data' =>array('name'=> $document->name,'url'=>$url,'user_name'=>Auth()->user()->name,'sender_mail'=>Auth()->user()->email,'message'=>$request->message)
                );
            foreach ($emails as $key => $email) {
                try {
                    if (isset($email) && $email!='' && $email!=null) {
                        Mail::to($email)->send(new SendMail($array));
                    }
                } catch (\Exception $e) {
                    dd($e);
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
    public function getDownload($id){
        $document = MyDocument::where('id',decrypt($id))->where('user_id',Auth::id())->first();
        $file = asset_image_display($document['file_url'],"images/mydocument/");
        $fileContent = file_get_contents($file);
        $ext = pathinfo($file, PATHINFO_EXTENSION);
        $filename = time().rand(5,10000).'.'.$ext;
        $response = response($fileContent, 200, [
        'Content-Type' => 'application/json',
        'Content-Disposition' => 'attachment; filename="'.$filename.'"',
        ]);
        return $response;
    }
}
