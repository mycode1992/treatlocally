@extends('frontend.layouts.frontlayout')

@section('content')

<!-- about-start -->

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



<section class="tl-contact tl-about">
	<div class="tl-contact-banner">
		<div class="tl-parallax" style="background-image: url({{url('/public')}}/tl_admin/upload/blog_banner/{{$blogimg[0]['tl_blogbanner_image']}});"></div>
		
		
		<div class="tl-caption-title">
			<div class="tl-title wow fadeIn" data-wow-delay="0.3s">{{$blogimg[0]['tl_blogbanner_title']}}</div>
		</div>
	</div>

	<div class="container">
		<div class="tl-blog-main">
			<div class="row">
			   <?php
				 if(count($data)>0){
			   ?>
				<div class="col-md-8 col-sm-8 col-xs-12">
						@foreach($data AS $data_val)
						<div class="col-md-6 col-sm-6 col-xs-12">
							<div class="tl-blog-cols">
								<div class="tl-blog-cols-img">
									<img src="{{url('/public')}}/tl_admin/upload/blog/{{ $data_val->tl_blog_image }}" alt="" class="img-responsive">
								</div>
								<div class="tl-blog-cols-text">
									<div class="tl-heading">{{ $data_val->tl_blog_title }}</div>
									<div class="tl-time">{{date('d F Y ', strtotime($data_val->tl_blog_created_at))}}</div>
									<div class="tl-detail">
										<?php
											$string = $data_val->tl_blog_description;
									//	echo	$string_word_count =  str_word_count($string); // exit;
											if(strlen($string) > 100){
												$stringCut = substr($string, 0, 100);
												$endPoint = strrpos($stringCut, ' ');
												$string = $endPoint? substr($stringCut, 0, $endPoint):substr($stringCut, 0);
												//$string .= '... <a href="#" onclick="return readmore('.$data_val->tl_blog_id.')">Read More</a>';
												echo $string.' ....';
											}
											else{
												echo  $string;
											}
											 
									     ?>
									</div>

									<div class="tl-blog-readmore">
										<a href="{{url('/blog-detail')}}/<?=$data_val->tl_blog_id?>" onclick="return viewcount(<?=$data_val->tl_blog_id?>)" class="hvr-sweep-to-right">Read More</a>
									</div>
								</div>
							</div>
						</div>
						@endforeach

						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="tl-blog-pagination">
								<div class="tl-blog-pagination-number">	{{ $data->links() }}</div>
								
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

							
							@foreach($recentblog AS $value)
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
									@foreach($viewcount AS $value)
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

				

			<?php } else{
				echo '<span class="no-data">No data found</span>';
			}?>

			</div>
		</div>
	</div>


</section>

<script type="text/javascript">
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

	//////////////////////submit search form///////////////
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
	return false;

}


</script>

<!-- about-end -->

 @endsection