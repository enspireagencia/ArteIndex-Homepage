
{{-- Extends layout --}}
@extends('layout.default')

{{-- Content --}}
@section('content')
<div class="d-flex flex-column-fluid">
	<div class="container">
		<div class="d-flex flex-row p-3">
			<div class="flex-row-auto offcanvas-mobile w-250px w-xxl-350px" id="kt_profile_aside">
				@include('pages.users.profile_sidebar')
			</div>

                <div class="flex-row-fluid ml-lg-8">
                    <div class="card card-custom card-stretch">
                        <div class="card-header py-3">
                            <div class="card-title align-items-start flex-column">
                                <h3 class="card-label font-weight-bolder text-dark">User Post Preview</h3>
                            </div>
                            <div class="card-title align-items-end flex-column">
                                <a href="{{route('user.my_posts',[Auth::user()->user_unique_id,'all'])}}" class="btn btn-primary font-weight-bolder font-size-sm">
                                    <svg width="24px" height="24px" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                       <!-- Generator: Sketch 50.2 (55047) - http://www.bohemiancoding.com/sketch -->
                                       <title>Stockholm-icons / Media / Backward</title>
                                       <desc>Created with Sketch.</desc>
                                       <defs></defs>
                                       <g id="Stockholm-icons-/-Media-/-Backward" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                          <rect id="bound" x="0" y="0" width="24" height="24"></rect>
                                          <path d="M11.0879549,18.2771971 L17.8286578,12.3976203 C18.0367595,12.2161036 18.0583109,11.9002555 17.8767943,11.6921539 C17.8622027,11.6754252 17.8465132,11.6596867 17.8298301,11.6450431 L11.0891271,5.72838979 C10.8815919,5.54622572 10.5656782,5.56679309 10.3835141,5.7743283 C10.3034433,5.86555116 10.2592899,5.98278612 10.2592899,6.10416552 L10.2592899,17.9003957 C10.2592899,18.1765381 10.4831475,18.4003957 10.7592899,18.4003957 C10.8801329,18.4003957 10.9968872,18.3566309 11.0879549,18.2771971 Z" id="Path-10" fill="#FFFFFF" opacity="0.3" transform="translate(14.129645, 12.002277) scale(-1, 1) translate(-14.129645, -12.002277) "></path>
                                          <path d="M5.08795487,18.2771971 L11.8286578,12.3976203 C12.0367595,12.2161036 12.0583109,11.9002555 11.8767943,11.6921539 C11.8622027,11.6754252 11.8465132,11.6596867 11.8298301,11.6450431 L5.08912711,5.72838979 C4.8815919,5.54622572 4.56567821,5.56679309 4.38351414,5.7743283 C4.30344325,5.86555116 4.25928988,5.98278612 4.25928988,6.10416552 L4.25928988,17.9003957 C4.25928988,18.1765381 4.48314751,18.4003957 4.75928988,18.4003957 C4.88013293,18.4003957 4.99688719,18.3566309 5.08795487,18.2771971 Z" id="Path-10-Copy" fill="#FFFFFF" transform="translate(8.129645, 12.002277) scale(-1, 1) translate(-8.129645, -12.002277) "></path>
                                       </g>
                                    </svg>
                                    Back</a>


                            </div>

                        </div>

                    <div class="row p-3">
                        <div class="col-lg-4">
                            <div class="card card-custom card-stretch gutter-b">
                                <div class="card-body d-flex flex-column">
                                    <div class="card card-custom overlay">
                                        <div class="card-body p-0">
                                            <div class="overlay-wrapper parent-container">

                                                <img class="contact_img w-100" src="{{asset_image_display($myPost->image,"images/profile/mypost/")}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-8">
                            <div class="post_detail card card-custom gutter-b  p-5">
                                <ul>
                                    <li> Title : <span> {{$myPost->title}} </span>
                                    <li> Sub Header : <span> {{$myPost->subheader}} </span>
                                    <li> Post Date : <span> {{$myPost->post_date}} </span>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="description p-5" >
                        <h5><strong> Description : </strong><hr></h5><p> {!!$myPost->body!!} </p>
                    </div>
                </div>
			</div>
		</div>
	</div>
</div>
@endsection
<style>
.description figure.image img{
    width:100%
}
.post_detail li{
    list-style: none;
    font-size:15px;
    font-weight: 500;
    margin-bottom:10px;
}
.post_detail li span{
    font-weight: 400;
}
.dialogs {
    width: 100%;
    max-width: 33em;
    margin: 4em auto 0;
}
.dialogs > div {
    border: 1px solid #CCC;
    border-right-color: #999;
    border-left-color: #999;
    border-bottom-color: #BBB;
    border-top: #B00100 solid 4px;
    border-top-left-radius: 9px;
    border-top-right-radius: 9px;
    background-color: white;
    padding: 7px 12% 0;
    box-shadow: 0 3px 8px rgb(50 50 50 / 17%);
}
h1 {
    font-size: 100%;
    color: #730E15;
    line-height: 1.5em;
}
.dialogs > p {
    margin: 0 0 1em;
    padding: 1em;
    background-color: #F7F7F7;
    border: 1px solid #CCC;
    border-right-color: #999;
    border-left-color: #999;
    border-bottom-color: #999;
    border-bottom-left-radius: 4px;
    border-bottom-right-radius: 4px;
    border-top-color: #DADADA;
    color: #666;
    box-shadow: 0 3px 8px rgb(50 50 50 / 17%);
}
body{
    text-align:center;
}
</style>
