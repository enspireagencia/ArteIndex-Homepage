
{{-- Extends layout --}}
@extends('layout.default')

{{-- Content --}}
@section('content')
    <div class="d-flex flex-column-fluid">
    
        <div class="container">
            <div class="card mb-5">
                <div class="card-header">
                    <h2><strong>My Profile</strong></h2>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8">
                            <input type="text" class="form-control  form-control-solid" id="public_url" value="{{url('/profile/'.Auth::user()->user_unique_id)}}" readonly/>
                        </div>
                        <div class="col-lg-4">
                            <a href="javascript:void(0)" class="mr-2" onclick="copyToClipboard('#public_url')"><i class="icon-2x text-success ki ki-copy"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex flex-row">
            
                <div class="flex-row-auto offcanvas-mobile w-300px w-xl-350px" id="kt_profile_aside">
                    
                    @include('pages.users.profile_sidebar') 
                    
                </div>
            
            
                <div class="flex-row-fluid ml-lg-8">
                
                    <div class="card card-custom gutter-b">
                        <div class="card-header py-3">
                            <div class="card-title align-items-start flex-column">
                                <h3 class="card-label font-weight-bolder text-dark">@lang('label.backend.admin.profile_setting.public_setting') </h3>
                                <span class="text-muted font-weight-bold font-size-sm mt-1" id="setting-lbl-text"></span>
                            </div>
                            <div class="card-toolbar">
                            <div class="form-group">
                                    <div class="checkbox-inline">
                                        <label class="checkbox checkbox">
                                        <input type="checkbox" class="changeProfilePublic" name="make_my_profile_public">
                                        <span></span><h5>@lang('label.backend.admin.profile_setting.make_my_profile_public')</h5></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <form class="form" id="public-contect">
                        @if(isset($user->profile) && $user->profile->make_my_profile_public !== 1)
                            <div class="card-body">
                                <div class="form-group row" > 
                                    <div class="col-lg-12 col-xl-12">
                                        <label class="col-form-label"><b>@lang('string.backend.admin.profile_setting.what_public_rofile')</b></label>
                                        <p>@lang('string.backend.admin.profile_setting.public_profile_place_share_artwork_online')</p>
                                        <p>@lang('string.backend.admin.profile_setting.features_stunning_portfolio_works_about/CV_share').</p>
                                        <p>@lang('string.backend.admin.profile_setting.you_choose_public_private_click_above_options')</p>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </form>
                    </div>
                    <div class="card card-custom gutter-b" id="pub_profile">
                        <div class="card-header align-items-center border-0 mt-4">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="font-weight-bolder text-dark">@lang('label.backend.admin.profile_setting.your_public_profile')</span>
                            </h3>
                        </div>
                        <div class="card-body pt-4">
                            <div class="form-group row">
                                <div class="col-lg-12 col-xl-12">
                                    <label class="col-form-label"><a target="_blank" href="{{url('/profile/'.Auth::user()->user_unique_id)}}">{{url('/profile/'.Auth::user()->user_unique_id)}}</a></label>
                                    <div class="mt-5">
                                        <span><label class="label label-light-warning label-inline font-weight-bold label-lg">Note:</label>@lang('string.backend.admin.profile_setting.you_free_trial')</span></br>
                                        <span>@lang('string.backend.admin.profile_setting.view_and_share_your_public_profile')</span>
                                    </div>
                                    <div class="mt-5">
                                    <a type="reset" class="btn btn-info mr-2">@lang('buttons.backend.general.click_here_subscribe')</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card card-custom gutter-b" id="pub_option">
                        <div class="card-header align-items-center border-0 mt-4">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="font-weight-bolder text-dark">@lang('label.backend.admin.profile_setting.public_profile_options')</span>
                            </h3>
                        </div>
                        <div class="card-body pt-4 row">
                            <div class="col-xl-6 col-lg-6">
                                <div class="form-group">
                                    <label>@lang('string.backend.admin.profile_setting.default_piece_order_Profile')</label>
                                    <select class="form-control form-control-solid select_change_user_profile_setting" name="show_public_piece_order" id="user_public_piece_order">
                                        <option value="">@lang('string.backend.admin.profile_setting.select_piece_order')</option>
                                        <option value="name_desc"  @if(isset($show_public_piece_order) && $show_public_piece_order =='name_desc' ) selected @endif>Title (z-a)</option>
                                        <option value="price_asc" @if(isset($show_public_piece_order) && $show_public_piece_order =='price_asc' ) selected @endif>Price (low)</option>
                                        <option value="price_desc" @if(isset($show_public_piece_order) && $show_public_piece_order =='price_desc' ) selected @endif>Price (high)</option>
                                        <option value="inventory_number_asc" @if(isset($show_public_piece_order) && $show_public_piece_order =='inventory_number_asc' ) selected @endif>Inventory Number (low)</option>
                                        <option value="inventory_number_desc" @if(isset($show_public_piece_order) && $show_public_piece_order =='inventory_number_desc' ) selected @endif>Inventory Number (high)</option>
                                        <option value="size_asc" @if(isset($show_public_piece_order) && $show_public_piece_order =='size_asc' ) selected @endif>Size (smallest)</option>
                                        <option value="size_desc" @if(isset($show_public_piece_order) && $show_public_piece_order =='size_desc' ) selected @endif>Size (largest)</option>
                                        <option value="creation_date_desc" @if(isset($show_public_piece_order) && $show_public_piece_order =='creation_date_desc' ) selected @endif>Creation Date (recent)</option>
                                        <option value="creation_date_asc" @if(isset($show_public_piece_order) && $show_public_piece_order =='creation_date_asc' ) selected @endif>Creation Date (old)</option>
                                        <option value="date_added_desc" @if(isset($show_public_piece_order) && $show_public_piece_order =='date_added_desc' ) selected @endif>Date Added (recent)</option>
                                        <option value="date_added_asc" @if(isset($show_public_piece_order) && $show_public_piece_order =='date_added_asc' ) selected @endif>Date Added (old)</option>
                                        <option value="type_asc" @if(isset($show_public_piece_order) && $show_public_piece_order =='type_asc' ) selected @endif>Type (a-z)</option>
                                        <option value="type_desc" @if(isset($show_public_piece_order) && $show_public_piece_order =='type_desc' ) selected @endif>Type (z-a)</option>
                                        <option value="public_piece_daily_random" @if(isset($show_public_piece_order) && $show_public_piece_order =='public_piece_daily_random' ) selected @endif>Randomize Daily</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <div class="checkbox-inline">
                                        <label class="checkbox checkbox">
                                        <input class="chk_change_user_profile_setting" {{$show_public_show_prices}} type="checkbox" name="show_public_show_prices" id="user_public_show_prices">
                                        <span></span>@lang('string.backend.admin.profile_setting.show_prices')</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="checkbox-inline">
                                        <label class="checkbox checkbox">
                                        <input class="chk_change_user_profile_setting" type="checkbox" {{$show_public_show_sales}} name="show_public_show_sales" id="user_public_show_sales">
                                        <span></span>@lang('string.backend.admin.profile_setting.show_sold_status_and_filtering')</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="checkbox-inline">
                                        <label class="checkbox checkbox">
                                        <input class="chk_change_user_profile_setting" type="checkbox" {{$show_public_show_status}} name="show_public_show_status" id="user_public_show_status">
                                        <span></span>@lang('string.backend.admin.profile_setting.show_all_statuses')</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="checkbox-inline">
                                        <label class="checkbox checkbox">
                                        <input class="chk_change_user_profile_setting" {{$show_public_show_collections}} type="checkbox" name="show_public_show_collections" id="user_public_show_collections">
                                        <span></span>@lang('string.backend.admin.profile_setting.show_collections')</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="checkbox-inline">
                                        <label class="checkbox checkbox">
                                        <input class="chk_change_user_profile_setting" type="checkbox" {{$show_public_show_creation_date}} name="show_public_show_creation_date" id="user_public_show_creation_date">
                                        <span></span>@lang('string.backend.admin.profile_setting.show_creation_date')</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="checkbox-inline">
                                        <label class="checkbox checkbox">
                                        <input class="chk_change_user_profile_setting" type="checkbox" {{$show_public_show_both_sizes}} name="show_public_show_both_sizes" id="user_public_show_both_sizes">
                                        <span></span>@lang('string.backend.admin.profile_setting.show_size_centimeters_inches')</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="checkbox-inline">
                                        <label class="checkbox checkbox">
                                        <input class="chk_change_user_profile_setting" type="checkbox" {{$show_public_show_additional_images}} name="show_public_show_additional_images" id="user_public_show_additional_images">
                                        <span></span>@lang('string.backend.admin.profile_setting.show_additional_images')</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="checkbox-inline">
                                        <label class="checkbox checkbox">
                                        <input class="chk_change_user_profile_setting" type="checkbox" {{$show_public_show_inventory_numbers}} name="show_public_show_inventory_numbers" id="user_public_show_inventory_numbers">
                                        <span></span>@lang('string.backend.admin.profile_setting.show_inventory_numbers')</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="checkbox-inline">
                                        <label class="checkbox checkbox">
                                        <input class="chk_change_user_profile_setting" type="checkbox" {{$show_public_show_editions}} name="show_public_show_editions" id="user_public_show_editions">
                                        <span></span>@lang('string.backend.admin.profile_setting.show_runs/reproductions_available')</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="checkbox-inline">
                                        <label class="checkbox checkbox">
                                        <input class="chk_change_user_profile_setting" type="checkbox" {{$show_public_show_shadows}} name="show_public_show_shadows" id="user_public_show_shadows">
                                        <span></span>@lang('string.backend.admin.profile_setting.show_drop_shadows_thumbnails')</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="checkbox-inline">
                                        <label class="checkbox checkbox">
                                        <input class="chk_change_user_profile_setting" type="checkbox" {{$show_public_show_shadows}} name="show_public_show_other_work" id="user_public_show_other_work">
                                        <span></span>@lang('string.backend.admin.profile_setting.show_suggested_individual_piece_pages')</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="checkbox-inline">
                                        <label class="checkbox checkbox">
                                        <input class="chk_change_user_profile_setting" type="checkbox" {{$show_public_show_discovery_link}} name="show_public_show_discovery_link" id="user_public_show_discovery_link">
                                        <span></span>@lang('string.backend.admin.profile_setting.show_link_discovery_page_profile')</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>@lang('string.backend.admin.profile_setting.pieces_display_page')</label>
                                    <select class="form-control form-control-solid select_change_user_profile_setting" name="show_public_pieces_per_page" id="user_public_pieces_per_page">
                                        <option value="10" @if(isset($show_public_pieces_per_page) && $show_public_pieces_per_page =='10' ) selected @endif>10</option>
                                        <option value="25" @if(isset($show_public_pieces_per_page) && $show_public_pieces_per_page =='25' ) selected @endif>25</option>
                                        <option value="50" @if(isset($show_public_pieces_per_page) && $show_public_pieces_per_page =='50' ) selected @endif>50</option>
                                        <option value="100" @if(isset($show_public_pieces_per_page) && $show_public_pieces_per_page =='100' ) selected @endif>100</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6">
                                <div class="form-group">
                                    <div class="checkbox-inline">
                                        <label class="checkbox checkbox">
                                        <input class=" chk_change_user_profile_setting" type="checkbox" {{$show_public_protected}} name="show_public_protected" id="user_public_protected">
                                        <span></span>@lang('string.backend.admin.profile_setting.password_protect_your_public_profile')</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <p class="">
                                        @lang('string.backend.admin.profile_setting.this_public_profile_password_below_access_it')
                                    </p>
                                </div>
                                <div class="form-group">
                                <label class="col-form-label">@lang('string.backend.admin.profile_setting.password_profile_page')</label>
                                <div class="form-group row">
                                    <div class="col-lg-12 col-xl-12">
                                        <input class="form-control form-control-lg form-control-solid select_change_user_profile_setting" name="show_public_password" value="{{$show_public_password}}" id="user_public_password" type="text" >
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                </div>
                                <div class="form-group">
                                    <label>@lang('string.backend.admin.profile_setting.contact_settings')</label>
                                    <div class="checkbox-inline">
                                        <label class="checkbox checkbox">
                                        <input class="chk_change_user_profile_setting" type="checkbox" {{$show_public_show_inquire}} name="show_public_show_inquire" id="user_public_show_inquire">
                                        <span></span>@lang('string.backend.admin.profile_setting.show_inquire_button_on_pieces')</label>
                                    </div>
                                    <div class="checkbox-inline">
                                        <label class="checkbox checkbox">
                                        <input class="chk_change_user_profile_setting" type="checkbox" {{$show_public_show_purchase}} name="show_public_show_purchase" id="user_public_show_purchase">
                                        <span></span>@lang('string.backend.admin.profile_setting.show_purchase_button_applicable_pieces')</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>@lang('string.backend.admin.profile_setting.public_location_settings')<</label>
                                    <div class="checkbox-inline">
                                        <label class="checkbox checkbox">
                                        <input class="chk_change_user_profile_setting" type="checkbox" {{$show_public_show_location}} name="show_public_show_location" id="user_public_show_location">
                                        <span></span>@lang('string.backend.admin.profile_setting.show_piece_current_location')</label>
                                    </div>
                                    <div class="checkbox-inline">
                                        <label class="checkbox checkbox">
                                        <input class="chk_change_user_profile_setting" type="checkbox" {{$show_public_show_location_address}} name="show_public_show_location_address" id="user_public_show_location_address">
                                        <span></span>@lang('string.backend.admin.profile_setting.show_address_piece_locations')<</label>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            
            </div>
        
        </div>
    </div>
@endsection
{{-- Scripts Section --}}
@section('scripts')
<script>
$(document).ready(function(){

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: "{{ route('admin.get_user_profile') }}",
        method: 'GET',
        success: function(data)
        {
            if(data.status == 'success'){
                if(data.data.make_my_profile_public==1){
                    $(".changeProfilePublic").prop("checked", true);
                    $('#pub_profile').show();
                    $('#pub_option').show();
                    $('#setting-lbl-text').html('Your Profile is <b class="text-success">Public</b>.');
                }else{
                    $(".changeProfilePublic").prop("checked", false);
                    $('#pub_profile').hide();
                    $('#pub_option').hide();
                    $('#setting-lbl-text').html('By default, all of your information is private.<br /> If you want to activate your Public Profile, please check the box below for more options.');
                }
            }
        },
    });
    $(".changeProfilePublic").on("change", function(event){
        event.preventDefault();
        var ischecked= $(this).is(':checked');
        if(!ischecked){
            $('#setting-lbl-text').html('By default, all of your information is private.<br /> If you want to activate your Public Profile, please check the box below for more options.')
            $('#pub_profile').hide();
            $('#pub_option').hide();
            $('#public-contect').html('<div class="card-body"><div class="form-group row" >  <div class="col-lg-12 col-xl-12"><label class="col-form-label"><b>What is a Public Profile?</b></label><p>The Public Profile is a place for you to share your artwork online. It is linked directly to your inventory in Artwork Archive so it\'s always the most up-to-date representation of your art.</p><p>It features a stunning Portfolio of your works, an About/CV page for you to share your story, and a News section for you to post updates to your audience.</p><p>You choose what\'s public or private, and can even password protect the page if you\'d like. Click "Make your profile public" above to see more options.</p></div></div></div>');
            var check = 0;
        }else{
            $('#setting-lbl-text').html('Your Profile is <b class="text-success">Public</b>.')
            $('#pub_profile').show();
            $('#pub_option').show();
            $('#public-contect').html('');
            var check = 1;
        }
        $.ajax({
            url: "{{ route('admin.change_make_my_profile_public') }}",
            method: 'POST',
            data: {"make_my_profile_public":check},
            success: function(data)
            {
                if(data.status == 'success'){
                    toastr.options.positionClass = "toast-bottom-left";
                    toastr.success(data.message)
                }
            },
        });
    });
    //Profile Option
    $(".chk_change_user_profile_setting").on("change", function(event){
        var field = $(this).attr('name');
        var ischecked= $(this).is(':checked');
        if (!ischecked) {
            var check = 0;
        }else{
            var check = 1;
        }
        $.ajax({
            url: "{{ route('admin.change_public_profile_option') }}",
            method: 'POST',
            data: {"field":field,'check':check},
            success: function(data)
            {
                if(data.status == 'success'){
                    toastr.options.positionClass = "toast-bottom-left";
                    toastr.success(data.message)
                }
            },
        });
        console.log("field "+ field + "----check"+check);
    });
    $(".select_change_user_profile_setting").on("change", function(event){
        var field = $(this).attr('name');
        var value= $(this).val();
        $.ajax({
            url: "{{ route('admin.change_public_profile_option_select') }}",
            method: 'POST',
            data: {"field":field,'value':value},
            success: function(data)
            {
                if(data.status == 'success'){
                    toastr.options.positionClass = "toast-bottom-left";
                    toastr.success(data.message)
                }
            },
        });
        console.log("field "+ field + "----check"+check);
    });
});
function copyToClipboard(element) {
		console.log(element);
		var $temp = $("<input>");
		$("body").append($temp);
		$temp.val($(element).val()).select();
		document.execCommand("copy");
		$temp.remove();
		toastr.options.positionClass = "toast-bottom-left";
		toastr.success("{{__('string.backend.common.copied_url')}}")
	}
</script>
@endsection
