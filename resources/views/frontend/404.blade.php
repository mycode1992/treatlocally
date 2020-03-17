@extends('frontend.layouts.frontlayout')

@section('content')

<!-- about-start -->


<!-- <div class="container">
	<div class="tl-error">
		<div class="tl-error-img">
			<img src="{{url('/public')}}/frontend/img/404.jpg" alt="" class="img-responsive">
		</div>
		<div class="tl-error-text">
			<p>Page not found <i class="fa fa-search" aria-hidden="true"></i></p>
			<p>We are sorry but the page you are looking for does not exist.</p>
		</div>
	</div>
</div> -->


<div class="error-contaienr">
	
	<div class="error-area-container">
			<div class="eror-logo"><img src="http://treatlocally.karmatechprojects.com/public/frontend/img/logo.png" alt="" class="img-responsive "></div>
			<div class="error-area-box">
				<div class="error-img"><img src="http://treatlocally.karmatechprojects.com/public/frontend/img/404.svg" alt="" class="img-responsive "></div>
					<h3>PAGE NOT FOUND</h3>
					<p>it seems that the page your are <br>looking for is lost</p>
					<div class="go-home-btn"><a href="#">GO TO HOME</a></div>
			</div>
	</div>
		

</div>

<!-- about-end -->

<style type="text/css">
	.error-contaienr {
		background: #eff1f7;
		min-height: 600px;
	}
	.error-area-container {
  
    color: #000;
    max-width: 400px;
    width: 100%;
     margin: auto;
  position: absolute;
  top: 50%; left: 50%;
  -webkit-transform: translate(-50%,-50%);
      -ms-transform: translate(-50%,-50%);
          transform: translate(-50%,-50%);

}
.error-area-box {
    background: #fff;
    text-align: center;
    padding: 40px 0 20px 0;
    margin: 20px 0;
}
.error-area-box h3 {
    font-weight: bold;
    font-size: 26px;
}
.go-home-btn a {
    background: #000;
    padding: 10px;
    display: block;
    max-width: 140px;
    margin: 35px auto;
    text-decoration: none;
    color: #fff;
    cursor: pointer;
}
.go-home-btn a:hover{
    background: #01008b;
    -webkit-transition: all 0.5s;
    -o-transition: all 0.5s;
    transition: all 0.5s;	
}
.error-img img {
    width: 50%;
    text-align: center;
    margin: auto;
}
.eror-logo img {
    text-align: center;
    margin: auto;
    width: 50%;
}
</style>
 @endsection
