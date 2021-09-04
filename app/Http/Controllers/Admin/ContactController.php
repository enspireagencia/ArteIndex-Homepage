<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Location;
use App\Models\User;
use App\Models\Group;
use Illuminate\Http\Request;
use Auth;
use File;
use Yajra\DataTables\DataTables;

class ContactController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Contact::get();
            return Datatables::of($data)->addIndexColumn()
            ->addColumn('image', function($row){
                $image = '<img src="'.asset_image_display($row->default_image,"images/contact/").'" style="width:50%;" class="mb-2 img-thumbnail" />';
                return $image;
              })
              ->addColumn('phone', function($row){
                return
                '<p> job Title : ' .$row->job_title. '</p>
                <p> Company : '.$row->company_name. '<p>
                <p> Phone : '.$row->phone. '<p>
                <p> Work Phone : '.$row->work_phone. '<p>
                <p> Mobile Phone : '.$row->mobile_phone. '<p>
                <p> Email : '.$row->email. '<p>
                <p> Secondary : '.$row->secondary_email. '<p>
                <p> Website : '.$row->website. '<p>';

              })

              ->addColumn('address', function($row){
                return
                '<p> Address 1 : ' .$row->address1. '</p>
                <p> Address 2 : '.$row->address2. '<p>
                <p> City : '.$row->city. '<p>
                <p> State : '.$row->state. '<p>
                <p> Country : '.$row->country. '<p>
                <p> Zip : '.$row->zip. '<p>';
              })


            ->addColumn('action', function($row){
            $btn = '<div class="">
                <a href="'.route('contact.edit',encrypt($row->id)).'" class="btn btn-primary font-weight-bold btn-pill mr-2">'.__('buttons.backend.general.crud.edit').'</a>
                <a href="#" class="btn btn-danger font-weight-bold btn-pill mr-2" onClick="editionsDelete('.$row->id.')"> '.__('buttons.backend.general.crud.delete').'</a>
                <a href="'.route('contact.show',encrypt($row->id)).'" class="btn btn-success font-weight-bold btn-pill mr-2">View</a>
                </div>';
            return $btn;
            })
            ->rawColumns(['image','action', 'phone',  'address'])
            ->make(true);
        }

        $user = User::with('user_status')->where('id',Auth::id())->first();

        return view('pages.contact.index', compact('user'));
    }


    public function create()
    {
        $user = User::with('user_status')->where('id',Auth::id())->first();
        $group = Group::where('user_id',Auth::id())->get();
        $locations = Location::with('user')->where('user_id',Auth::id())->get();
        return view('pages.contact.create', compact('locations', 'group','user'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
        ]);
        try {


            if(isset($request['creation_date']) && $request['creation_date']['date'] && $request['creation_date']['month'] && $request['creation_date']['year']){
                $creation_date = date('Y-m-d',strtotime($request['creation_date']['date']."-".$request['creation_date']['month']."-".$request['creation_date']['year']));
            }else{
                $creation_date = date('Y-m-d H:m:s');
            }

            if(isset($request['dath_date']) && $request['dath_date']['date'] && $request['dath_date']['month'] && $request['dath_date']['year']){
                $dath_date = date('Y-m-d',strtotime($request['dath_date']['date']."-".$request['dath_date']['month']."-".$request['dath_date']['year']));
            }else{
                $dath_date = date('Y-m-d H:m:s');
            }


            if(isset($request['contact_id']) && $request['contact_id']!=''){
                if ($request->hasFile('default_image')){
                    //upload contact
                    $pathcontact='images/contact/';
                    $default_image=asset_image_put($request->default_image, $pathcontact,"contacts");

                     //remove old reportheader
                    if($default_image!=null && isset($request->old_image) && $request->old_image!=''){
                        asset_image_delete($request->old_image,$pathcontact);
                    }
                    $contact = Contact::find($request->contact_id);
                    $contact->default_image =$default_image;
                    $contact->save();
                }
                if(isset($request['group_id'])){
                    $group_id = implode(",",$request['group_id']);
                }else{
                    $group_id = null;
                }

                $contact = Contact::where('id',$request['contact_id'])->where('user_id',Auth::id())->first();
                $contact->first_name = $request['first_name'];
                $contact->last_name = $request['last_name'];
                $contact->title = $request['title'];
                $contact->phone = $request['phone'];
                $contact->work_phone = $request['work_phone'];
                $contact->mobile_phone = $request['mobile_phone'];
                $contact->email = $request['email'];
                $contact->secondary_email = $request['secondary_email'];
                $contact->website = $request['website'];
                $contact->company_name = $request['company_name'];
                $contact->job_title = $request['job_title'];
                $contact->address1 = $request['address1'];
                $contact->address2 = $request['address2'];
                $contact->city = $request['city'];
                $contact->state = $request['state'];
                $contact->zip = $request['zip'];
                $contact->country = $request['country'];
                $contact->secondary_address1 = $request['secondary_address1'];
                $contact->secondary_address2 = $request['secondary_address2'];
                $contact->secondary_city = $request['secondary_city'];
                $contact->secondary_state = $request['secondary_state'];
                $contact->secondary_zip = $request['secondary_zip'];
                $contact->secondary_country = $request['secondary_country'];
                $contact->location_id = $request['location_id'];
                $contact->bio = $request['bio'];
                $contact->notes = $request['notes'];
                $contact->nationality = $request['nationality'];
                $contact->spouse_first_name = $request['spouse_first_name'];
                $contact->spouse_last_name = $request['spouse_last_name'];
                $contact->creation_date = $creation_date;
                $contact->dath_date = $dath_date;
                $contact->group_id = $group_id;
                $contact->save();
                return response()->json(['status'=>'success','message'=>__('string.backend.create.contact.contact_updated_successfully'),'type'=>'2']);
            }else{
                $default_image="";
                if ($request->hasFile('default_image')) {
                    //upload contact
                    $pathcontact='images/contact/';
                    $default_image=asset_image_put($request->default_image, $pathcontact,"contacts");
                }
                if(isset($request['group_id'])){
                    $group_id = implode(",",$request['group_id']);
                }else{
                    $group_id = null;
                }

                $contact = Contact::create([
                    'default_image'=> $default_image,
                    'first_name' => $request['first_name'],
                    'last_name' => $request['last_name'],
                    'title' => $request['title'],
                    'phone' => $request['phone'],
                    'work_phone' => $request['work_phone'],
                    'mobile_phone' => $request['mobile_phone'],
                    'email' => $request['email'],
                    'secondary_email' => $request['secondary_email'],
                    'website' => $request['website'],
                    'company_name' => $request['company_name'],
                    'job_title' => $request['job_title'],
                    'address1' => $request['address1'],
                    'address2' => $request['address2'],
                    'city' => $request['city'],
                    'state' => $request['state'],
                    'zip' => $request['zip'],
                    'country' => $request['country'],
                    'secondary_address1' => $request['secondary_address1'],
                    'secondary_address2' => $request['secondary_address2'],
                    'secondary_city' => $request['secondary_city'],
                    'secondary_state' => $request['secondary_state'],
                    'secondary_zip' => $request['secondary_zip'],
                    'secondary_country' => $request['secondary_country'],
                    'group_id' => $request['groups'],
                    'location_id' => $request['location_id'],
                    'bio' => $request['bio'],
                    'notes' => $request['notes'],
                    'nationality' => $request['nationality'],
                    'spouse_first_name' => $request['spouse_first_name'],
                    'spouse_last_name' => $request['spouse_last_name'],
                    'creation_date' => $creation_date,
                    'group_id' => $group_id,
                    'dath_date' => $dath_date,
                    'slug' => Auth::user()->name.'-'.preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request['first_name'])).'-'.str_random(5),
                    'user_id' => Auth::id(),
                ]);

                return response()->json(['status'=>'success','message'=>__('string.backend.create.contact.contact_created_successfully'),'type'=>'1']);
            }

        } catch (\Throwable $th) {
            // throw $th;
            return response()->json(['status'=>'eroor','message'=>'Something want wrong']);
        }
    }


    public function show($id)
    {
        $user = User::with('user_status')->where('id',Auth::id())->first();
        try {
           $data = Contact::with('location')->where('id', decrypt($id))->where('user_id',Auth::id())->first();
           $groups="";
           if(isset($data->group_id)){
               foreach (explode(",",$data->group_id) as $value) {
                   $valgrp=Group::where('id',$value)->first()->group_name ?? "";
                   if($valgrp!=""){
                    $groups .="<u>".$valgrp."</u> ,";
                   }
               }
                $groups=rtrim($groups, ',');
           }
           return view('pages.contact.show', compact('data','user','groups'));
        } catch (\Throwable $th) {
            //throw $th;
            abort(404);
        }
    }

    public function edit($id)
    {
        $user = User::with('user_status')->where('id',Auth::id())->first();
        $locations = Location::with('user')->where('user_id',Auth::id())->get();
        $contact = Contact::where('id',decrypt($id))->where('user_id',Auth::id())->first();
        $group = Group::where('user_id',Auth::id())->get();
        if(isset($contact)){
            if(isset($contact)){
                $contact['year'] = date('Y',strtotime($contact->dath_date));
                $contact['month'] = date('m',strtotime($contact->dath_date));
                $contact['date'] = date('d',strtotime($contact->dath_date));
            }
            return view('pages.contact.create',compact('contact', 'group', 'locations','user'));
        }else{
            abort(404);
        }
    }


    public function update(Request $request, Contact $contact)
    {

    }


    public function destroy($id)
    {
        $contact = Contact::where('id',$id)->where('user_id',Auth::id())->first();
        if(isset($contact)){
            if(isset($contact->default_image)){
                $pathcontact='images/contact/';
                asset_image_delete($contact->default_image,$pathcontact);
            }
            Contact::find($id)->delete();
        }
        return response()->json(['status'=>'success','message'=>__('string.backend.create.contact.contact_deleted_successfully')]);
    }

}
