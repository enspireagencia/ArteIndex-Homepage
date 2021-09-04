{{-- Extends layout --}}
@extends('layout.front')
{{-- Content --}}
@section('content')
<div class="login login-2 login-signin-on d-flex flex-column flex-lg-row flex-column-fluid bg-white" id="kt_login">
   <div class="login-aside order-2 order-lg-1 d-flex flex-row-auto position-relative overflow-hidden">
      <div class="d-flex flex-column-fluid flex-column justify-content-between py-9 px-7 py-lg-13 px-lg-35">
         <a href="#" class="text-center pt-2">
         <img src="/media/logos/logo-letter-7.png" class="max-h-75px" alt="">
         </a>
         <div class="d-flex flex-column-fluid flex-column flex-center">
            <div class="login-form login-signin py-11">
               <form class="form fv-plugins-bootstrap fv-plugins-framework" method="POST" id="login_signin_form">
               @csrf
                  <div class="text-center pb-8">
                     <h2 class="font-weight-bolder text-dark font-size-h2 font-size-h1-lg">Sign In</h2>
                     <span class="text-muted font-weight-bold font-size-h4">Or
                     <a href="" class="text-primary font-weight-bolder" id="kt_login_signup">Create An Account</a></span>
                  </div>
                  <div class="form-group fv-plugins-icon-container">
                     <label class="font-size-h6 font-weight-bolder text-dark">Email</label>
                     <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg" type="email" name="email" id="login-email"  required>
                     <div class="fv-plugins-message-container"></div>
                  </div>
                  <div class="form-group fv-plugins-icon-container">
                     <div class="d-flex justify-content-between mt-n5">
                        <label class="font-size-h6 font-weight-bolder text-dark pt-5">Password</label>
                        <!-- <a href="javascript:;" class="text-primary font-size-h6 font-weight-bolder text-hover-primary pt-5" id="kt_login_forgot">Forgot Password ?</a> -->
                     </div>
                     <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg" type="password" name="password" required id="login-password">
                     <div class="fv-plugins-message-container"></div>
                  </div>
                  <div class="text-center pt-2">
                     
                     <input id="login_signin_btn" class="btn btn-dark font-weight-bolder font-size-h6 px-8 py-4 my-3" value="Sign In" />
                     
                  </div>
                  <input type="hidden">
                  <div></div>
               </form>
            </div>
            <div class="login-form login-signup pt-11">
               <form class="form fv-plugins-bootstrap fv-plugins-framework" method="POST" action="{{ route('register') }}" id="kt_login_signup_form">
               @csrf
                  <div class="text-center pb-8">
                     <h2 class="font-weight-bolder text-dark font-size-h2 font-size-h1-lg">Sign Up</h2>
                     <p class="text-muted font-weight-bold font-size-h4">Enter your details to create your account</p>
                  </div>
                  <div class="form-group fv-plugins-icon-container">
                     <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg font-size-h6" type="text" placeholder="Enter Name" name="name" autocomplete="off">
                     <div class="fv-plugins-message-container"></div>
                  </div>
                  <div class="form-group fv-plugins-icon-container">
                     <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg font-size-h6" type="email" placeholder="Email" name="email" autocomplete="off">
                     <div class="fv-plugins-message-container"></div>
                  </div>
                  <div class="form-group fv-plugins-icon-container">
                     <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg font-size-h6" type="password" placeholder="Password" name="password" autocomplete="off">
                     <div class="fv-plugins-message-container"></div>
                  </div>
                  <div class="form-group fv-plugins-icon-container">
                     <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg font-size-h6" type="password" placeholder="Confirm password" name="password_confirmation" autocomplete="off">
                     <div class="fv-plugins-message-container"></div>
                  </div>
                  <div class="form-group fv-plugins-icon-container">
                    @php
                        $status = App\Models\UserStatus::get();
                    @endphp
            
                    <div class="mt-4">
                        <select id="user_role" name="user_role" class="form-control form-control-solid h-auto py-7 px-6 rounded-lg font-size-h6">
                            @foreach($status as $status_val)
                                @if($status_val->id != 1)
                                    <option value="{{$status_val->id}}"> {{$status_val->status}} </option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                  </div>
                  <div class="form-group d-flex flex-wrap flex-center pb-lg-0 pb-3">
                  <input type="submit" id="kt_login_signup_submit" class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mx-4" value="Submit">
                     <button type="button" id="kt_login_signup_cancel" class="btn btn-light-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mx-4">Cancel</button>
                  </div>
                  <div></div>
               </form>
            </div>
            <div class="login-form login-forgot pt-11">
               <form class="form fv-plugins-bootstrap fv-plugins-framework" novalidate="novalidate" id="kt_login_forgot_form">
                  <div class="text-center pb-8">
                     <h2 class="font-weight-bolder text-dark font-size-h2 font-size-h1-lg">Forgotten Password ?</h2>
                     <p class="text-muted font-weight-bold font-size-h4">Enter your email to reset your password</p>
                  </div>
                  <div class="form-group fv-plugins-icon-container">
                     <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg font-size-h6" type="email" placeholder="Email" name="email" autocomplete="off">
                     <div class="fv-plugins-message-container"></div>
                  </div>
                  <div class="form-group d-flex flex-wrap flex-center pb-lg-0 pb-3">
                     <button type="button" id="kt_login_forgot_submit" class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mx-4">Submit</button>
                     <button type="button" id="kt_login_forgot_cancel" class="btn btn-light-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mx-4">Cancel</button>
                  </div>
                  <div></div>
               </form>
            </div>
         </div>
         
      </div>
   </div>
   <div class="content order-1 order-lg-2 d-flex flex-column w-100 pb-0" style="background-color: #B1DCED;">
      <div class="d-flex flex-column justify-content-center text-center pt-lg-40 pt-md-5 pt-sm-5 px-lg-0 pt-5 px-7">
         <h3 class="display4 font-weight-bolder my-7 text-dark" style="color: #986923;">Amazing Wireframes</h3>
         <p class="font-weight-bolder font-size-h2-md font-size-lg text-dark opacity-70">User Experience &amp; Interface Design, Product Strategy
            <br>Web Application SaaS Solutions
         </p>
      </div>
      <div class="content-img d-flex flex-row-fluid bgi-no-repeat bgi-position-y-bottom bgi-position-x-center" style="background-image: url(/media/svg/illustrations/login-visual-2.svg);"></div>
   </div>
</div>
@endsection
