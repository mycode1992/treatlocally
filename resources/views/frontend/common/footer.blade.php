<!-- footer-start -->
<style type="text/css">
.errorssubscribe{
  font-size: 14px;
}
.errorssubscribe::-webkit-input-placeholder { /* Chrome/Opera/Safari */
 color: red !important;
}
.errorssubscribe::-moz-placeholder { /* Firefox 19+ */
 color: red !important;
}
.errorssubscribe:-ms-input-placeholder { /* IE 10+ */
 color: red;
}
.errorssubscribe:-moz-placeholder { /* Firefox 18- */
 color: red !important;
}

</style>
<?php 

		$social_links = DB::table('tbl_tl_social_link')->select('tl_social_link_id', 'tl_social_link_facebook','tl_social_link_twitter','tl_social_link_youtube','tl_social_link_insta')->where('tl_social_link_id','1')->get();

		if (strpos($social_links[0]->tl_social_link_facebook, 'http') !== false) {
			   $facebook_link=$social_links[0]->tl_social_link_facebook;
			}
			else{
				$facebook_link='https://'.$social_links[0]->tl_social_link_facebook;
			}

	if (strpos($social_links[0]->tl_social_link_twitter, 'http') !== false) {
		   $tw_link=$social_links[0]->tl_social_link_twitter;
		}
		else{
			$tw_link='https://'.$social_links[0]->tl_social_link_twitter;
		}

	if (strpos($social_links[0]->tl_social_link_youtube, 'http') !== false) {
		   $utube_link=$social_links[0]->tl_social_link_youtube;
		}
		else{
			$utube_link='https://'.$social_links[0]->tl_social_link_youtube;
		}
if (strpos($social_links[0]->tl_social_link_insta, 'http') !== false) {
		   $insta_link=$social_links[0]->tl_social_link_insta;
		}
		else{
			$insta_link='https://'.$social_links[0]->tl_social_link_insta;
		}




	
	  
		 $data = session()->all();
	//	 print_r($data); 
		 $data_key = array_keys($data); 
		 //print_r($data_key); 
		// echo count($data_key); 
		if(count($data_key)>'3'){
		//	echo $data_key[3]; exit;
		$session_all=Session::get($data_key[3]);
	      $userid = $session_all['userid'];
	       $userdata =  DB::table('users')->select('name')->where('userid',$userid)->get();
								 
		}
		else {
			$session_all = false;
		}
	?>

<?php  $segment_url = Request::segment(1); 
if($segment_url != 'search'){
?>


<footer>
	<div class="container">
		<div class="col-sm-4 col-md-4 col-xs-12 wow fadeIn" data-wow-delay="0.3s">
			<div class="tl-footer-cols">
				<div class="tl-footer-img">
					<img src="{{url('/public')}}/frontend/img/logo.png" alt="" class="img-responsive">
				</div>
				<div class="tl-footer-text">
					<p>Feel free to <span>Contact us</span> at
					<a href="mailto:info@treatlocally.com">info@treatlocally.com</a> with any questions
					or for more info.</p>
				</div>
			</div>
		</div>

		<div class="col-sm-4 col-md-4 col-xs-12 wow fadeIn" data-wow-delay="0.6s">
			<div class="tl-footer-linking">
				<div class="tl-footer-heading">Main Links</div>
				<ul>
				   <?php if($session_all==false){  ?>
						<li><a href="{{url('user/account')}}">My Account</a></li>
						<li><a href="{{url('merchant-signin')}}">Merchant Log-In</a></li>
					<?php } ?>
					<li><a href="{{url('blog')}}">Blog</a></li>
					<li><a href="{{url('contact')}}">Contact</a></li>
					<li><a href="{{url('about-us')}}">About Us</a></li>
					<li><a href="{{url('FAQ')}}">Faq’s</a></li>
					<li><a href="{{url('terms&condition')}}">Terms And Conditions</a></li>
					<li><a href="{{url('privacy-policy')}}">Privacy Policy</a></li>
				</ul>
			</div>		
		</div>

		<div class="col-sm-4 col-md-4 col-xs-12 wow fadeIn" data-wow-delay="0.9s">
			<div class="tl-footer-newsletter newsletter-desktop">

					<div class="tl-footer-heading">Follow us</div>
					<div class="tl-footer-social">
						<a href="{{$facebook_link}}" title="Facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a>
						<a href="{{$insta_link}}" title="Twitter"><i class="fa fa-instagram" aria-hidden="true"></i></a>
					</div>	

				{{-- <div class="tl-footer-heading">Newsletter</div>
				<p>Join our newsletter to keep yourself informed about offers and updates.</p>

				<form method="post" action="#" onsubmit="return AddSubscribe();">
				<input type="hidden" name="_token" value="{{ csrf_token()}}">
					<label for="">
						<input type="text" placeholder="Enter e-mail" class="form-control" id="subscribeemail" name="subscribeemail" maxlength="80">
					</label>
					<label for="">
						<button type="submit" class="hvr-sweep-to-right">Subscribe</button>
					</label>
					<div id="errormsgsubscribe" style="font-size: 15px;text-align: center;"></div>
				</form> --}}
			</div>

			<div class="tl-footer-newsletter tl-newsletter-followus-icon newsletter-mobile">
				<div class="tl-footer-heading">Follow us</div>
				<div class="tl-footer-social">
					<a href="{{$facebook_link}}" title="Facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a>
					<a href="{{$insta_link}}" title="Twitter"><i class="fa fa-instagram" aria-hidden="true"></i></a>
				</div>	
			</div>

		</div>

	</div>

<div class="tl-copyright wow fadeIn" data-wow-delay="1.2s">
	<div class="tl-footer-social">
		<a href="{{$facebook_link}}" title="Facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a>
		<a href="{{$tw_link}}" title="Twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a>
		<a href="{{$utube_link}}" title="Youtube"><i class="fa fa-youtube-play" aria-hidden="true"></i></a>
		<a href="{{$social_links[0]->tl_social_link_insta}}"><i class="fa fa-instagram" aria-hidden="true"></i></a>
	</div>
	<p class="text-center">Copyright © <?php echo  date("Y"); ?> <a href="http://treatlocally.karmatechprojects.com/" target="_blank"> treatlocally.com </a>. All rights reserved.</p>
</div>	
</footer>
<?php } ?>
<script type="text/javascript">
function AddSubscribe()
{
	var subscribeemail =document.getElementById("subscribeemail").value.trim();
	var _token = $('input[name=_token]').val();
    var strUserEml=subscribeemail.toLowerCase();
  	var filter=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/;
  if(subscribeemail=="")
  {

       document.getElementById('subscribeemail').style.border='#ff0000';
       document.getElementById("subscribeemail").focus();
       $('#subscribeemail').attr("placeholder", "Please enter e-mail");
       $("#subscribeemail").addClass( "errorssubscribe" );
       return false;
  }
  else if(!filter.test(strUserEml)) 
  {

	   document.getElementById('subscribeemail').style.border='#ff0000';
	   document.getElementById("subscribeemail").focus();
	   $('#subscribeemail').val('');
	   $('#subscribeemail').attr("placeholder", "Invalid e-mail id");
	   $("#subscribeemail").addClass( "errorssubscribe" );
	   return false;
  }
  else
  {
     document.getElementById("subscribeemail").style.border = "";     
       
  }
    

    var form = new FormData();
        form.append('subscribeemail', strUserEml);
				form.append('_token', _token);
    $.ajax({    
	    type: 'POST',
	    url: "{{url('/subscribesubmit')}}",
	    data: form,
	    cache: false,
	    contentType: false,
	    processData: false,
	    success:function(response) 
	    {
	    	 

	      console.log(response);
	       var status=response.status;
	      var msg=response.msg;
	      if(status=='200')
	      {
	         $("#subscribeemail").removeClass( "errorssubscribe" );
				//	$("#subscribeemail").addClass( "errorssubscribe" );
	         $("#subscribeemail").val('');
	         //document.getElementById("errormsgsubscribe").innerHTML=msg;
					 $('#subscribeemail').attr("placeholder", msg);
	       //  document.getElementById("subscribeemail").style.color = "#278428";
				 document.getElementById("subscribeemail").style.color = "";
	         setTimeout(function() { document.getElementById("subscribeemail").innerHTML=''; }, 2000);
	      }
	      else if(status=='401')
	      {
					$("#subscribeemail").addClass( "errorssubscribe" );
	         document.getElementById("subscribeemail").style.color = "#ff0000";
	        //  document.getElementById("subscribeemail").innerHTML=response.msg ;
					$("#subscribeemail").val('');
					 $('#subscribeemail').attr("placeholder", msg);
					 setTimeout(function() { 
						//  document.getElementById("subscribeemail").innerHTML=''; 
						$('#subscribeemail').attr("placeholder", "");
						$("#subscribeemail").removeClass( "errorssubscribe" );
						document.getElementById("subscribeemail").style.color = "";
						 
						 }, 2000);
	      }
	    
	    }

     });
     return false;
 
}// end of function
</script>

<!-- footer-end -->
<?php if($segment_url != 'search'){ ?>
<a href="#"  class="scrollToTop">Back to top <i class="fa fa-angle-up" aria-hidden="true"></i></a>
<?php } ?>
<script src="{{url('/public')}}/frontend/js/jquery.min.js"></script>
<script src="{{url('/public')}}/frontend/js/slick.js"></script>
<script src="{{url('/public')}}/frontend/js/bootstrap.min.js"></script>
<script src="{{url('/public')}}/frontend/js/wow.min.js"></script>
<script src="{{url('/public')}}/frontend/js/jarallax.js"></script>
<script src="{{url('/public')}}/frontend/js/bootstrap-datepicker.js"></script>
<script src="{{url('/public')}}/frontend/js/bootstrap-select.min.js"></script>
<script src="{{url('/public')}}/frontend/js/view-bigimg.js"></script>

{{-- 
<script>
var viewer = new ViewBigimg();

var viewimg1 = document.getElementById('viewimg1')
 viewimg1.onclick = function (e) {
 	var imgTag = $('.tl-temp1 img').attr('src');

 viewer.show(imgTag);

 }

 var viewimg2 = document.getElementById('viewimg2')
 viewimg2.onclick = function (e) {
 	var imgTag = $('.tl-temp2 img').attr('src');
	
 viewer.show(imgTag);

 }


var viewimg3 = document.getElementById('viewimg3')
 viewimg3.onclick = function (e) {
 	var imgTag = $('.tl-temp3 img').attr('src');
 	
 viewer.show(imgTag);

 }

</script> --}}
<script>
 new WOW().init();

$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
}); 
</script> 

<script>




setTimeout(function(){ 
$('.tlflip-slide').slick({
  centerMode: false,
  infinite: true,
  slidesToShow:1,
  dots:true,
  arrows:false,
});


}, 1000);

</script>

<script>
$('.trendingslider').slick({
  centerMode: false,
  slidesToShow: 1,
  dots:true,
  responsive: [
    {
      breakpoint: 768,
      settings: {
        dots:true,
        slidesToShow: 1
      }
    },
    {
      breakpoint: 480,
      settings: {
        dots:true,
        slidesToShow: 1
      }
    }
  ]
});
</script>

<script type="text/javascript">
$(function (){
    $('.scrollToTop').bind("click", function () {
        $('html, body').animate({ scrollTop: 0 }, 1200);
        return false;
    });

});

$( window ).scroll(function() {
  
  if($(this).scrollTop()>=100){
    $('.scrollToTop').fadeIn(500);
  }else{
    $('.scrollToTop').fadeOut(500);
  }
  //$( "span" ).css( "display", "inline" ).fadeOut( "slow" );
});
</script>

<script>
	$(function(){
		var date = new Date();
		date.setDate(date.getDate());
		$('#datepicker').datepicker({
		   format: 'dd/mm/yyyy',
		   autoclose: true,
		   startDate: date
     	})

	});

	// $('.datepicker').datepicker({
	// 	format: 'dd/mm/yyyy',
	// 	minDate:0
	// })

$(document).ready(function(){	
var str = document.location.href;
var str1 = str.split("#");
var ot;
if(str1[1]=='works'){
  ot = document.getElementById('works').offsetTop;
  $('html, body').animate({ scrollTop: ot - 85 }, 1000);
}
  $('.downArrow').click(function() {
    var target = $(this.hash);
    console.log(target);
    var dd = document.getElementById('works').offsetTop
    console.log("dd:  "+dd)
    console.log("target.offset().top: "+target.offset().top)
    if (target.length == 0) target = $('a[name="' + this.hash.substr(1) + '"]');
    $('html, body').animate({ scrollTop: target.offset().top - 85 }, 1000);
    return false;
      }); 
});

</script>

<script>
	$(document).on('click.bs.dropdown.data-api', '.dropdown.keep-inside-clicks-open', function (e) {
		e.stopPropagation();
	});
</script>

<?php
//$url = $_SERVER['REQUEST_URI'];
//echo $url;
  // if($url == '/'){
?>
<script>
// $(document).ready(function(){
//   $(window).scroll(function(){
//   	var scroll = $(window).scrollTop();
// 	  if (scroll > 0) {
// 	  $(".activebg").addClass("active-white");
// 	  }

// 	  else{
// 	  $(".activebg").removeClass("active-white");
// 	  }
//   });
// });



  		$(window).scroll(function () {
  			var sc = $(window).scrollTop()
  			if (sc > 100) {
  				$(".activebg").addClass("active-white")
  			} else {
  				$(".activebg").removeClass("active-white")
  			}
  		});






//logout-dropdown-start
$(function(){
$(".dropdownlogout").hover(            
        function() {
            $('.dropdown-logout', this).stop( true, true ).fadeIn("fast");
            $(this).toggleClass('open');
            //$('b', this).toggleClass("caret caret-up");                
        },
        function() {
            $('.dropdown-logout', this).stop( true, true ).fadeOut("fast");
            $(this).toggleClass('open');
            //$('b', this).toggleClass("caret caret-up");                
        });
});
// logout-dropdown-end
</script>
<script type="text/javascript">
	(function($){
	$(document).ready(function(){
		$('ul.dropdown-menu [data-toggle=dropdown]').on('click', function(event) {
			event.preventDefault(); 
			event.stopPropagation(); 
			$(this).parent().siblings().removeClass('open');
			$(this).parent().toggleClass('open');
		});
	});
})(jQuery);
/* http://www.bootply.com/nZaxpxfiXz */
</script>
 <script>
 $(document).ready(function(){
			$('.tl-mobileview a').click(function() {
      			$(this).addClass('active').siblings().removeClass('active');
			});
			});
		</script>


<?php
 //  }
?>



