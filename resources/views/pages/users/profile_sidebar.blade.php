<div class="card card-custom card-stretch">

	<div class="card-body pt-15">

		<div class="text-center mb-10">
			<div class="symbol symbol-60 symbol-circle symbol-xl-90">
				<div class="symbol-label" style="background-image:url({{isset($user->profile->profile_image)? asset_image_display($user->profile->profile_image,'images/profile/profileimage/') : url("/media/users/blank.png")}})"></div>
				<i class="symbol-badge symbol-badge-bottom bg-success"></i>
			</div>
			<h4 class="font-weight-bold my-2">{{isset($user->name)? $user->name : ""}}</h4>
			<div class="text-muted mb-2">{{isset($user->user_status)? $user->user_status->status : ""}}</div>
			<span class="label label-light-success label-inline font-weight-bold label-lg">Active</span>
		</div>


		<a href="{{route('user.profile',Auth::user()->user_unique_id)}}" class="btn btn-hover-light-primary font-weight-bold py-3 px-6 mb-2 text-center btn-block {{ request()->is('user/*/profile') ? 'active' : '' }}"> @lang('menus.backend.admin.profile_info') </a>
		<a href="{{route('user.about',Auth::user()->user_unique_id)}}" class="btn btn-hover-light-primary font-weight-bold py-3 px-6 mb-2 text-center btn-block {{ request()->is('user/*/about') ? 'active' : '' }}">@lang('menus.backend.admin.about')</a>
		<a href="{{route('user.public_setting',Auth::user()->user_unique_id)}}" class="btn btn-hover-light-primary font-weight-bold py-3 px-6 mb-2 text-center btn-block {{ request()->is('user/*/public_setting') ? 'active' : '' }}">@lang('menus.backend.admin.profile_settings')</a>
		<a href="{{route('user.public_pieces',Auth::user()->user_unique_id)}}" class="btn btn-hover-light-primary font-weight-bold py-3 px-6 mb-2 text-center btn-block {{ request()->is('user/*/public_pieces') ? 'active' : '' }}">@lang('menus.backend.admin.public_pieces')</a>
        <a href="{{route('user.my_posts',[Auth::user()->user_unique_id,'all'])}}" class="btn btn-hover-light-primary font-weight-bold py-3 px-6 mb-2 text-center btn-block {{ request()->is('user/*/my_posts/all') ? 'active' : '' }} {{ request()->is('user/*/my_posts/published') ? 'active' : '' }} {{ request()->is('user/*/my_posts/draft') ? 'active' : '' }}  {{ request()->is('posts/create') ? 'active' : '' }} {{ request()->is('posts/*/edit') ? 'active' : '' }}">@lang('menus.backend.admin.my_posts')</a>
		<a href="{{route('user.integrations',Auth::user()->user_unique_id)}}" class="btn btn-hover-light-primary font-weight-bold py-3 px-6 mb-2 text-center btn-block {{ request()->is('user/*/integrations') ? 'active' : '' }}">@lang('menus.backend.admin.integrations')</a>

	</div>

</div>
