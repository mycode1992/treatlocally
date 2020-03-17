@extends('frontend.layouts.frontlayout')

@section('content')

<style>
  footer{
    display: none !important;
  }
</style>

<section class="dos-login tl-subscribe">
  <div class="container">
    <div class="dos-align-center">
      <div class="dos-login-main">
        @if($token_status=='1')
          <div class="form-title">Thanks!</div>
            <p class="text-center">
                You have successfully subscribed for the TreatLocally newsletter.
                <!-- You have successfully unsubscribed from TreatLocally. newsletter! -->

            </p>
        @endif
        @if($token_status=='2')
        <div class="form-title"></div>
       <p class="text-center">Sorry! Your are already subscribed for the TreatLocally. newsletter.</p>
        @endif
        @if($token_status=='3')
        <div class="form-title">Sorry!</div>
       <p class="text-center">Invalid url</p>
        @endif
       
        
        
      </div>
    </div>
  </div>
</section>

 @endsection

