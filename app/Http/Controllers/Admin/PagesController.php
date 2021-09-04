<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PrivateRoom;
use App\Models\Country;
use App\Models\Status;
use App\Models\Collection;
use App\Models\ArtType;
use App\Models\Pieces;
use App\Models\Location;
use App\Models\MyPost;
use App\Models\Inbox;
use App\Models\Edition;
use App\Models\Runs;
use App\Models\Contact;
use Auth;
use Yajra\DataTables\DataTables;
use Spatie\Analytics\Period;

class PagesController extends Controller
{
    public function index()
    {
        $page_title = 'Dashboard';
        $user = User::with('user_status')->where('id',Auth::id())->first();
        // Inbox list
        $inbox_list = Inbox::with('user')->where('user_id',Auth::id())->with('pieces_detail')->with('private_room')->orderBy('id', 'desc')->take(8)->get();

        // Total count of all records
        $total_pieces = Pieces::where('user_id',Auth::id())->count();
        $total_edition = Edition::where('user_id',Auth::id())->count();
        $total_run = Runs::where('user_id',Auth::id())->count();
        $total_collection = Collection::where('user_id',Auth::id())->count();
        $total_location = Location::where('user_id',Auth::id())->count();
        $total_privateRoom = PrivateRoom::where('user_id',Auth::id())->count();
        $total_contact = Contact::where('user_id',Auth::id())->count();
        $total_inbox = Inbox::where('user_id',Auth::id())->count();
        $total = [
        'total_pieces'=>$total_pieces,
        'total_edition'=>$total_edition,
        'total_run'=>$total_run,
        'total_collection'=>$total_collection,
        'total_location'=>$total_location,
        'total_privateRoom'=>$total_privateRoom,
        'total_contact'=>$total_contact,
        'total_inbox'=>$total_inbox
        ];

        // Total views from google analytics
        $analyticsData = \Analytics::fetchVisitorsAndPageViews(Period::years(4));
        $private_room_views = 0;
        $pieces_views = 0;
        $profile_views = 0;
        $post_views = 0;
        $views = [];
        if(isset($analyticsData) && count($analyticsData) > 0){
            foreach($analyticsData as $key => $analytics){
                if($analytics['pageTitle'] == 'Arte index | Private Room'){
                    $private_room_views = $analytics['visitors'];
                }
                if($analytics['pageTitle'] == 'Arte index | Pieces Detail' || $analytics['pageTitle'] == 'Arte index | Profile Pieces Detail'){
                    $pieces_views = $analytics['visitors'];
                }
                if($analytics['pageTitle'] == 'Arte index | Profile'){
                    $profile_views = $analytics['visitors'];
                }
                if($analytics['pageTitle'] == 'Arte index | Post Detail'){
                    $post_views = $analytics['visitors'];
                }
            }
            $views = [
                'private_room_views'=>$private_room_views,
                'pieces_views'=>$pieces_views,
                'profile_views'=>$profile_views,
                'post_views'=>$post_views
            ];
        }

        //Google map 
        $location_list = [];
        $pieces_locations = Pieces::with('location')->with('location.country_list')->where('user_id',Auth::id())->get();
        if (isset($pieces_locations) && count($pieces_locations) > 0) {
            foreach ($pieces_locations as $key => $pieces_location) {
                if(isset($pieces_location->location)){
                    if(isset($pieces_location->location->country_list->name)){
                        $country_name = $pieces_location->location->country_list->name;
                    }else{
                        $country_name = '';
                    }
                    $location = $pieces_location->location;
                    $location_value = $location->address_line_1.", ".$location->address_line_2.", ".$location->city.", ".$location->state.", ".$country_name;
                    $location_list[] = $location_value;
                }
            }
        }
        return view('pages.dashboard', compact('page_title','user','inbox_list','total','views','location_list'));
    }

    public function profile()
    {
        $user = User::with('user_status')->with('profile')->where('id',Auth::id())->first();
        $countries = Country::all();
        return view('pages.users.profile',compact('user','countries'));
    }

    public function about()
    {
        $user = User::with('user_status')->where('id',Auth::id())->first();
        return view('pages.users.about',compact('user'));
    }

    public function integrations()
    {
        $user = User::with('user_status')->where('id',Auth::id())->first();
        return view('pages.users.integrations',compact('user'));
    }

    public function my_posts(Request $request, $id, $filter)
    {
        $filterval="";
        if(isset($filter)){
            if($filter == "all"){
                $filterval="";
            }elseif($filter=="published"){
                $filterval= "1";
            }elseif($filter=="draft"){
                $filterval= "0";
            }
        }

        if ($request->ajax()) {
            $data = MyPost::select('*')->where('user_id',Auth::id());
            if($filterval!=""){
                $data->where('status',$filterval);
            }
            $data=$data->get();
            return Datatables::of($data)->addIndexColumn()

            ->addColumn('image', function($row){
                if($row->image!=""){
                  $image = '<img src="'.asset_image_display($row->image,"images/profile/mypost/").'"  class="mb-2 img-thumbnail" />';
                }else{
                  $image = '<img src="'.asset('images/default_image_1.jpg').'" class="mb-2 img-thumbnail" />';
                }
                return $image;
            })

            ->addColumn('title', function($row){
                if($row->title){
                    return $row->title;
                }
            })

            ->addColumn('status', function($row){
                $select = '<select class="form-control form-control-solid change_room_status">';
                $select.= '<option value="1" '.(($row->status == 1)?'selected':'').' room_id="'.$row->id.'">Published</option>';
                $select.= '<option value="0" '.(($row->status == 0)?'selected':'').' room_id="'.$row->id.'">Unpublished</option>';
                $select.='</select>';
                $select.= '<input type="hidden" class="room_hidden_id" value="'.$row->id.'" />';
                return $select;
            })

            ->addColumn('action', function($row){
                $btn = '<div class="">
                    <a href="#" class="btn btn-primary font-weight-bold btn-pill mr-2 dropdown-toggle"
                     data-toggle="dropdown" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Action </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="'.route('posts.show', encrypt($row->id)).'"> Preview  </a>
                            <a class="dropdown-item" href="'.route('posts.edit', encrypt($row->id)).'"> Edit </a>
                            <a class="dropdown-item" href="#" onClick="postDelete('.$row->id.')"> Delete </a>
                        </div>
                    </div>';
                return $btn;
            })

            ->rawColumns(['action', 'image', 'status'])
            ->make(true);
        }
        $user = User::with('user_status')->where('id',Auth::id())->first();
        return view('pages.users.mypost.my_posts',compact('user', 'filter'));
    }

    public function public_pieces(Request $request)
    {
        $status = Status::all();
        $collections = Collection::where('user_id',Auth::id())->get();
        $types = ArtType::all();
        $subject_matters = Pieces::where('user_id',Auth::id())->where('subject_matter','!=','')->select('subject_matter')->get();
        $mediums = Pieces::where('user_id',Auth::id())->where('medium','!=','')->select('medium')->get();
        $locations = Location::where('user_id',Auth::id())->get();
        $user = User::with('user_status')->where('id',Auth::id())->first();

        if ($request->ajax()) {
            $data = Pieces::with('pieces_images')->where('user_id',Auth::id())->select('*');
            return Datatables::of($data)->addIndexColumn()
            ->filter(function ($instance) use ($request) {
                if (!empty($request->get('select_status'))) {
                    $select_status = $request->get('select_status');
                    $instance->where(function($w) use($select_status){
                        $w->where('status_id', 'like', "%$select_status%");
                    });
                }
                if (!empty($request->get('select_collection'))) {
                    $select_collection = $request->get('select_collection');
                    $instance->where(function($w) use($select_collection){
                        $w->whereRaw("find_in_set($select_collection,collections_id)");
                    });
                }
                if (!empty($request->get('select_type'))) {
                    $select_type = $request->get('select_type');
                    $instance->where(function($w) use($select_type){
                        $w->where('artType_id',$select_type);
                    });
                }
                if (!empty($request->get('select_subject_matter'))) {
                    $select_subject_matter = $request->get('select_subject_matter');
                    $instance->where(function($w) use($select_subject_matter){
                        $w->where('subject_matter',$select_subject_matter);
                    });
                }
                if (!empty($request->get('select_medium'))) {
                    $select_medium = $request->get('select_medium');
                    $instance->where(function($w) use($select_medium){
                        $w->where('medium',$select_medium);
                    });
                }
                if (!empty($request->get('select_location'))) {
                    $select_location = $request->get('select_location');
                    $instance->where(function($w) use($select_location){
                        $w->where('location_id',$select_location);
                    });
                }
                if (!empty($request->get('select_public_status')) || $request->get('select_public_status')!='') {
                    $select_public_status = $request->get('select_public_status');
                    $instance->where(function($w) use($select_public_status){
                        $w->where('piece_public',$select_public_status);
                    });
                }
            })
            ->addColumn('price', function($row){
                if(isset($row->price)){
                    return '$'.$row->price.'.00';
                }else{
                    return '-';
                }
            })
            ->addColumn('pieces_images', function($row){
                if(isset($row->pieces_images) && count($row->pieces_images)>0){
                    $image = '<div class="parent-container-'.$row->id.'">';
                    foreach($row->pieces_images as $key => $images){
                        if($key==0){
                            $hide_class = '';
                        }else{
                            $hide_class = 'hide_image';
                        }
                        $image.= '<a href="'.asset_image_display($images->url,"images/pieces/").'" class="'.$hide_class.'"><img src="'.asset_image_display($images->url,"images/pieces/").'" width="50%" /></a>';
                    }
                    $image.='</div>';
                }else{
                    $image ='<div class="parent-container-'.$row->id.'">
                                <a href="'.url("/media/users/blank.png").'"><img src="'.url("/media/users/blank.png").'" width="50%" /></a>
                            </div>';
                }
                return $image;
              })
            ->addColumn('status', function($row){
                $status_array = Status::all();
                $select = '<select class="form-control form-control-solid change_pieces_status">';
                foreach($status_array as $key => $status_val){
                    if($row->status_id == $status_val->id){
                        $selected = 'selected';
                    }else{
                        $selected = '';
                    }
                    $select.= '<option value="'.$status_val->id.'" '.$selected.' pieces_id="'.$row->id.'">'.$status_val->status.'</option>';
                }
                $select.='</select>';
                $select.= '<input type="hidden" class="pieces_hidden_id" value="'.$row->id.'" />';
                return $select;
              })
            ->addColumn('action', function($row){
                if($row->piece_public==0){
                    $button_name = 'Not Public';
                    $class_name = 'btn-danger';
                }else{
                    $button_name = 'Public';
                    $class_name = 'btn-success';
                }
                $btn = '<div class="">
                    <a href="#" class="btn '.$class_name.' with-color font-weight-bold btn-pill mr-2 change_pieces_public change_pieces_public_'.$row->id.'" data-id="'.$row->id.'" data-value="'.$row->piece_public.'" >'.$button_name.'</a>
                </div>';
            return $btn;
            })
            ->rawColumns(['action','pieces_images','status'])
            ->make(true);
        }
        return view('pages.users.public_pieces',compact('user','status','collections','types','subject_matters','mediums','locations'));
    }

    public function public_setting()
    {
        $private_rooms = PrivateRoom::with('user')->where('user_id',Auth::id())->first();
        $show_public_piece_order = isset($private_rooms) && $private_rooms->show_public_piece_order ? $private_rooms->show_public_piece_order:'';
        $show_public_show_prices = isset($private_rooms) && $private_rooms->show_public_show_prices == 1 ? 'checked' : '';
        $show_public_show_sales = isset($private_rooms) && $private_rooms->show_public_show_sales == 1 ? 'checked' : '';
        $show_public_show_status = isset($private_rooms) && $private_rooms->show_public_show_status == 1 ? 'checked' : '';
        $show_public_show_collections = isset($private_rooms) && $private_rooms->show_public_show_collections == 1 ? 'checked' : '';
        $show_public_show_creation_date = isset($private_rooms) && $private_rooms->show_public_show_creation_date == 1 ? 'checked' : '';
        $show_public_show_both_sizes = isset($private_rooms) && $private_rooms->show_public_show_both_sizes == 1 ? 'checked' : '';
        $show_public_show_additional_images = isset($private_rooms) && $private_rooms->show_public_show_additional_images == 1 ? 'checked' : '';
        $show_public_show_inventory_numbers = isset($private_rooms) && $private_rooms->show_public_show_inventory_numbers == 1 ? 'checked' : '';
        $show_public_show_editions = isset($private_rooms) && $private_rooms->show_public_show_editions == 1 ? 'checked' : '';
        $show_public_show_shadows = isset($private_rooms) && $private_rooms->show_public_show_shadows == 1 ? 'checked' : '';
        $show_public_show_other_work = isset($private_rooms) && $private_rooms->show_public_show_other_work == 1 ? 'checked' : '';
        $show_public_show_discovery_link = isset($private_rooms) && $private_rooms->show_public_show_discovery_link == 1 ? 'checked' : '';
        $show_public_pieces_per_page = isset($private_rooms) && $private_rooms->show_public_pieces_per_page ? $private_rooms->show_public_pieces_per_page : '';
        $show_public_protected = isset($private_rooms) && $private_rooms->show_public_protected == 1 ? 'checked' : '';
        $show_public_password = isset($private_rooms) && $private_rooms->show_public_password ? $private_rooms->show_public_password : '';
        $show_public_show_inquire = isset($private_rooms) && $private_rooms->show_public_show_inquire == 1 ? 'checked' : '';
        $show_public_show_purchase = isset($private_rooms) && $private_rooms->show_public_show_purchase == 1 ? 'checked' : '';
        $show_public_show_location = isset($private_rooms) && $private_rooms->show_public_show_location == 1 ? 'checked' : '';
        $show_public_show_location_address = isset($private_rooms) && $private_rooms->show_public_show_location_address == 1 ? 'checked' : '';
        $user = User::with('user_status')->with('profile')->where('id',Auth::id())->first();
        return view('pages.users.public_setting',compact('user','show_public_piece_order','show_public_show_prices','show_public_show_sales','show_public_show_status','show_public_show_collections','show_public_show_creation_date','show_public_show_both_sizes','show_public_show_additional_images','show_public_show_inventory_numbers','show_public_show_editions','show_public_show_shadows','show_public_show_other_work','show_public_show_discovery_link','show_public_pieces_per_page','show_public_protected','show_public_password','show_public_show_inquire','show_public_show_purchase','show_public_show_location','show_public_show_location_address'));
    }

    /**
     * Demo methods below
     */

    // Datatables
    public function datatables()
    {
        $page_title = 'Datatables';
        $page_description = 'This is datatables test page';

        return view('pages.datatables', compact('page_title', 'page_description'));
    }

    // KTDatatables
    public function ktDatatables()
    {
        $page_title = 'KTDatatables';
        $page_description = 'This is KTdatatables test page';

        return view('pages.ktdatatables', compact('page_title', 'page_description'));
    }

    // Select2
    public function select2()
    {
        $page_title = 'Select 2';
        $page_description = 'This is Select2 test page';

        return view('pages.select2', compact('page_title', 'page_description'));
    }

    // jQuery-mask
    public function jQueryMask()
    {
        $page_title = 'jquery-mask';
        $page_description = 'This is jquery masks test page';

        return view('pages.jquery-mask', compact('page_title', 'page_description'));
    }

    // custom-icons
    public function customIcons()
    {
        $page_title = 'customIcons';
        $page_description = 'This is customIcons test page';

        return view('pages.icons.custom-icons', compact('page_title', 'page_description'));
    }

    // flaticon
    public function flaticon()
    {
        $page_title = 'flaticon';
        $page_description = 'This is flaticon test page';

        return view('pages.icons.flaticon', compact('page_title', 'page_description'));
    }

    // fontawesome
    public function fontawesome()
    {
        $page_title = 'fontawesome';
        $page_description = 'This is fontawesome test page';

        return view('pages.icons.fontawesome', compact('page_title', 'page_description'));
    }

    // lineawesome
    public function lineawesome()
    {
        $page_title = 'lineawesome';
        $page_description = 'This is lineawesome test page';

        return view('pages.icons.lineawesome', compact('page_title', 'page_description'));
    }

    // socicons
    public function socicons()
    {
        $page_title = 'socicons';
        $page_description = 'This is socicons test page';

        return view('pages.icons.socicons', compact('page_title', 'page_description'));
    }

    // svg
    public function svg()
    {
        $page_title = 'svg';
        $page_description = 'This is svg test page';

        return view('pages.icons.svg', compact('page_title', 'page_description'));
    }

    // Quicksearch Result
    public function quickSearch()
    {
        return view('layout.partials.extras._quick_search_result');
    }
}
