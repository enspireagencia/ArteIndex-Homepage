<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Location;
use App\Models\Country;
use App\Models\Pieces;
use App\Models\Works;
use App\Models\Contact;
use Auth;
use Yajra\DataTables\DataTables;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Location::select('*')->where('user_id',Auth::id())->get();
            return Datatables::of($data)->addIndexColumn()
            ->addColumn('pieces', function($row){
                $pieces = Pieces::where('location_id', $row->id)->where('user_id',Auth::id())->get();
                if(count($pieces)){
                    return count($pieces);
                }else{
                    return 0;
                }
            })
            ->addColumn('reproductions', function($row){
                $works = Works::where('location_id', $row->id)->where('user_id',Auth::id())->count();
                return $works;
            })
            ->addColumn('sales', function($row){
                return 0;
            })
            ->addColumn('address', function($row){
                $a1 = isset($row->address_line_1) ? $row->address_line_1: "";
                $a2 = isset($row->address_line_2) ? $row->address_line_2: "";
                return $a1 . " <br> " . $a2;
            })
            ->addColumn('contact', function($row){
                $contact = '';
                if(isset($row->phone)){
                    $contact.= 'Phone: '.$row->phone.'</br>';
                }
                if(isset($row->fax)){
                    $contact.= 'Fax: '.$row->fax;
                }
                return $contact;
            })
            ->addColumn('action', function($row){
            $btn = '<div class="">
                <a href="'.route('locations.edit',$row->id).'" class="btn btn-primary font-weight-bold btn-pill mr-2">'.__('buttons.backend.general.crud.edit').'</a>
                <a href="#" class="btn btn-danger font-weight-bold btn-pill mr-2" onClick="locationDelete('.$row->id.')"> '.__('buttons.backend.general.crud.delete').'</a>
                <a href="'.route('locations.show',encrypt($row->id)).'" class="btn btn-success font-weight-bold btn-pill mr-2">'.__('buttons.backend.general.crud.view').'</a>
                </div>';
            return $btn;
            })
            ->rawColumns(['pieces','reproductions','sales','address','contact','action'])
            ->make(true);
        }
        $page_title = 'Locations';
        $page_description = 'Some description for the location';
        $user = User::with('user_status')->where('id',Auth::id())->first();
        $countries = Country::get();
        return view('pages.locations.index', compact('page_title', 'page_description','user','countries'));
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
        return view('pages.locations.create',compact('user', 'countries'));
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
            'name' => 'required',
        ]);
        try {
            if(isset($request['location_id']) && $request['location_id']!=''){
                $location = Location::where('id',$request['location_id'])->where('user_id',Auth::id())->first();
                $location->name = $request['name'];
                $location->website = $request['website'];
                $location->email = $request['email'];
                $location->phone = $request['phone'];
                $location->fax = $request['fax'];
                $location->notes = $request['notes'];
                $location->address_line_1 = $request['address_line_1'];
                $location->address_line_2 = $request['address_line_2'];
                $location->city = $request['city'];
                $location->state = $request['state'];
                $location->country = $request['country'];
                $location->zipcode = $request['zip'];
                $location->save();
                return response()->json(['status'=>'success','message'=>__('string.backend.create.locations.location_updated_successfully'),'type'=>'2']);
            }else{
                Location::create([
                    'name' => $request['name'],
                    'website' => $request['website'],
                    'email' => $request['email'],
                    'phone' => $request['phone'],
                    'fax' => $request['fax'],
                    'notes' => $request['notes'],
                    'address_line_1' => $request['address_line_1'],
                    'address_line_2' => $request['address_line_2'],
                    'city' => $request['city'],
                    'state' => $request['state'],
                    'country' => $request['country'],
                    'zipcode' => $request['zip'],
                    'user_id' => Auth::id(),
                ]);
                return response()->json(['status'=>'success','message'=>__('string.backend.create.locations.location_created_successfully'),'type'=>'1']);
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
    public function show(Request $request,$id)
    {

        $user = User::with('user_status')->where('id',Auth::id())->first();
        if ($request->ajax()) {
            $data = Contact::where('location_id',decrypt($id))->get();
            return Datatables::of($data)->addIndexColumn()
            ->addColumn('image', function($row){
                  $image = '<a href="#" data-fancybox data-caption="'.$row->default_image.'"><img src="'.asset_image_display($row->default_image,"images/contact/").'" style="width:50%;" class="mb-2 img-thumbnail" /></a>';
                  return $image;
            })
            ->addColumn('information', function($row){
                if(isset($row->first_name)){
                    return $row->first_name;
                }
            })
            ->addColumn('contact', function($row){
                if(isset($row->job_title) || ($row->company_name) || ($row->phone) || ($row->work_phone)
                    || ($row->mobile_phone) || ($row->email) || ($row->secondary_email) || ($row->website)){
                    return
                        '<p> job Title : ' .$row->job_title. '</p>
                        <p> Company : '.$row->company_name. '<p>
                        <p> Phone : '.$row->phone. '<p>
                        <p> Work Phone : '.$row->work_phone. '<p>
                        <p> Mobile Phone : '.$row->mobile_phone. '<p>
                        <p> Email : '.$row->email. '<p>
                        <p> Secondary : '.$row->secondary_email. '<p>
                        <p> Website : '.$row->website. '<p>';
                } else{
                    return
                        '<p> job Title : -  </p>
                        <p> Company : - <p>
                        <p> Phone : - <p>
                        <p> Work Phone : - <p>
                        <p> Mobile Phone : - <p>
                        <p> Email : - <p>
                        <p> Secondary : - <p>
                        <p> Website :  - <p>';

                }
            })

            ->addColumn('address', function($row){
                return
                '<p> Address 1 : ' .$row->address1. '</p>
                <p> Address 2 : '.$row->address2. '<p>
                <p> City : '.$row->phone. '<p>
                <p> State : '.$row->state. '<p>
                <p> Country : '.$row->country. '<p>
                <p> Zip : '.$row->zip. '<p>';
              })

            ->rawColumns(['information', 'image', 'contact', 'address'])
            ->make(true);
        }
        $data = Location::with('contact')->where('id',decrypt($id))->where('user_id',Auth::id())->first();
        return view('pages.locations.show',compact('data','user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $location = Location::where('id',$id)->where('user_id',Auth::id())->first();
        $countries = Country::get();
        $user = User::with('user_status')->where('id',Auth::id())->first();
        if(isset($location)){
            return view('pages.locations.create',compact('user','countries','location'));
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
        $location = Location::where('id',$id)->where('user_id',Auth::id())->first();
        if(isset($location)){
            Location::find($id)->delete();
            Pieces::where('location_id', $location->id)->update([
                'location_id' => null
            ]);
        }
        return response()->json(['status'=>'success','message'=>__('string.backend.create.locations.location_deleted_successfully')]);
    }


}
