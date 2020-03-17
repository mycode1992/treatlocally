@extends('frontend.layouts.frontlayout')

@section('content')


<style type="text/css">
	.errors{
	  font-size: 14px;
	}
	.errors::-webkit-input-placeholder { /* Chrome/Opera/Safari */
	 color: red !important;
	}
	.errors::-moz-placeholder { /* Firefox 19+ */
	 color: red !important;
	}
	.errors:-ms-input-placeholder { /* IE 10+ */
	 color: red;
	}
	.errors:-moz-placeholder { /* Firefox 18- */
	 color: red !important;
	}
	
	</style>
<!-- about-start -->

<section class="tl-contact tl-about">
	<div class="tl-contact-banner">
		<div class="tl-parallax" style="background-image: url({{url('/public')}}/tl_admin/upload/blog_banner/{{$data['blogimg'][0]['tl_blogbanner_image']}});"></div>
		
		
		<div class="tl-caption-title">
			<div class="tl-title wow fadeIn" data-wow-delay="0.3s">{{$data['blogimg'][0]['tl_blogbanner_title']}}</div>
		</div>
	</div>

	<div class="container">
		<div class="tl-blog-main tl-blog-detail">
			<div class="row">
				<div class="col-md-8 col-sm-8 col-xs-12">
					<div class="tl-blog-detail-main">
						<div class="tl-blog-detail-img">
							<img src="{{url('/public')}}/tl_admin/upload/blog/{{$data['detail'][0]['tl_blog_image']}}" alt="" class="img-responsive">
						</div>
						<div class="tl-blog-detail-text">
							<div class="time-title">{{$data['detail'][0]['tl_blog_addby']}} / {{date('d F Y ', strtotime($data['detail'][0]['tl_blog_updated_at']))}}</div>
							<div class="heading">{{$data['detail'][0]['tl_blog_title']}}</div>

							<article>
								<?php echo $data['detail'][0]['tl_blog_description'];?>
							</article>

							<div class="tl-blog-share">
								<div class="heading">Share Post</div>
								<ul>
									<li><a href="javascript:void(0)" onclick="return submitAndShare();" title="Facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>

									<li><a href="javascript:void(0)" onclick="tw_share('{{$data['detail'][0]['tl_blog_title']}}')" title="Twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
									<li><a href="https://plus.google.com/share?url={{url('/public')}}/tl_admin/upload/blog/{{$data['detail'][0]['tl_blog_image']}}" target="_blank"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>

								
								</ul>
							</div>
						</div>
					</div>
				</div>

				<div class="col-md-4 col-sm-4 col-xs-12">
					<div class="tl-blog-rightpanel">
						<div class="tl-blog-search">
							<div class="heading">Search Blog</div>
							<form action="" method="POST" onsubmit="return blogsearch();">
								<label for="">
									<input type="text" name="searchitem" id="searchitem" class="form-control" placeholder="Search">
									<input type="hidden" name="_token" value="{{ csrf_token()}}">
								</label>
								<label for="">
									<button type="submit" class="hvr-sweep-to-right">Search</button>
								</label>
							</form>
						</div>

						<div class="tl-blog-recentpost">
							<div class="heading">Recent Posts</div>
                            @foreach($data['recentblog'] AS $value)
							<div class="tl-blog-flexbox">
								<a href="{{url('/blog-detail')}}/<?=$value->tl_blog_id?>" onclick="return viewcount(<?=$value->tl_blog_id?>)">
									<div class="tl-blog-recentpost-img">
										<img src="{{url('/public')}}/tl_admin/upload/blog/{{ $value->tl_blog_image }}" alt="" class="img-responsive">
									</div>
									<div class="tl-blog-recentpost-text">
										{{$value->tl_blog_title}}
									</div>
									
								</a>
							</div>

						@endforeach	
						<input type="hidden" name="_token" value="{{ csrf_token()}}">		
						
								
						</div>

						<div class="tl-blog-trendingpost">
							<div class="heading">Trending Post</div>	

							<div class="tl-blog-trending-slide">
								<div class="trendingslider">
									@foreach($data['viewcount'] AS $value)
								<?php
								  $blogid = $value->tl_blogview_blogid;  
								 
								  $viewblog = DB::table('tbl_tl_blog')
									->select('tl_blog_title','tl_blog_image','tl_blog_id')
									->where('tl_blog_id',$blogid)->get();
									$viewblog = json_decode(json_encode($viewblog), True);
								?>
									<div>
										<div class="trendingslider-cols">
											<a href="{{url('/blog-detail')}}/<?=$viewblog[0]['tl_blog_id']?>" onclick="return viewcount(<?=$viewblog[0]['tl_blog_id']?>)">
												<div class="trendingslider-cols-img">
													<img src="{{url('/public')}}/tl_admin/upload/blog/{{ $viewblog[0]['tl_blog_image'] }}" alt="" class="img-responsive">
												</div>
												<div class="trendingslider-cols-text">
													<div class="trendingslider-cols-text-title">
														{{$viewblog[0]['tl_blog_title']}}
													</div>
													<div class="trendingslider-cols-time">
															{{date('d F Y ', strtotime($value->tl_blogview_update_at))}}
													</div>
												</div>
											</a>
										</div>
									</div>
									@endforeach
								
								</div>
							</div>
						</div> 

					</div>
				</div>
			</div>
		</div>
	</div>


</section>
<?php $segment2 =  Request::segment(2); 
$blogDesData=$data['detail'][0]['tl_blog_description'];
$blogDesData=strip_tags($blogDesData);
$blogDesData=substr($blogDesData, 0, 100);
?>
<script>
		function tw_share(title)
		{  
		  var url="{{url('/')}}/blog-detail/{{$segment2}}";
		window.open('https://twitter.com/intent/tweet?button_hashtag=Treatlocally '+title+' '+' '+url,'_blank');
		  
		}    
		</script>

<!-- about-end -->

<!-- facebook code-->
<script src="{{url('/')}}/public/frontend/js/fbcustom.js"></script>	
<script>
function submitAndShare()
{  

var title = '';
var description = '';
var image = '';
title = "{{$data['detail'][0]['tl_blog_title']}}";
description = "<?php echo $blogDesData;?>";
image = "{{url('/public')}}/tl_admin/upload/blog/{{$data['detail'][0]['tl_blog_image']}}";
var urlpath='';	
// and finally share it
urlpath='{{url('/')}}/blog-detail/{{$segment2}}';	

//shareOverrideOGMeta(window.location.href,title,description,image);	
shareOverrideOGMeta(urlpath,title,description,image);	
return false;
}

function shareOverrideOGMeta(overrideLink, overrideTitle, overrideDescription, overrideImage)
{
    console.log(overrideLink);
FB.ui({
method: 'share_open_graph',
action_type: 'og.shares',
action_properties: JSON.stringify({
object: {
'og:url': overrideLink,
'og:title': overrideTitle,
'og:description': overrideDescription,
'og:image': overrideImage,

}
})
},
function (response) {
// Action after response
});
}

function blogsearch()
{
	
	// document.getElementById("errormsg").innerHTML='';
	var searchitem =document.getElementById("searchitem").value.trim();
//	var _token = $('input[name=_token_search]').val();
	
	
    if(searchitem=="")
    {
      document.getElementById('searchitem').style.border='1px solid #ff0000';
      document.getElementById("searchitem").focus();
      $('#searchitem').val('');
	  $('#searchitem').attr("placeholder", "Please enter search keyword");
      $("#searchitem").addClass( "errors" );
      return false;
    }
    else
    {
      document.getElementById("searchitem").style.border = "";   
	}
	controller_url="{{url('/blog/')}}/"+searchitem;
	window.location=controller_url;




	// window.history.replaceState({}, document.title, "/" + controller_url);

//	window.history.pushState('', '', controller_url);
	//$('#searchitem').attr("placeholder", "fdghgfnj");
	return false;

}


	function viewcount(blogid){
        var _token = $('input[name=_token]').val();
		$.ajax({
			method: "POST",
			url: "{{url('/blogviewcount/')}}",
			data: { blogid:blogid, _token: _token}
			})
			.done(function( response ) {
			 console.log(response); return false;
			console.log(response[0]);
			
			$('#readmoremod').click();
			$('#readmoremsg').text(response[0].tl_contactus_message);

			});

	}
	
</script>

 @endsection