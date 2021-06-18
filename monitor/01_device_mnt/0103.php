<?
include_once("../inc/top.php");

include_once("../../common/php_module/common_func.php");

// $ip = "175.202.54.174";
// $port = "15001";
// $url = "/stw-cgi/video.cgi?msubmenu=stream&action=view&Profile=1&CodecType=MJPEG&Resolution=640x480&FrameRate=60&CompressionLevel=10";
// $id = "admin";
// $pw = "kokofarm5561";
// $test_url = "../../common/php_module/camera_func.php?ip=" .$ip. "&port=" .$port. "&url=" .urlencode($url). "&id=" .$id. "&pw=" .$pw;

// var_dump($test_url);

?>

<style>
	img {
		opacity: 1.0;
		filter: alpha(opacity=100);
		cursor:pointer;
	}
	img:hover {
		opacity: 0.5;
		filter: alpha(opacity=40);
	}
</style>

<!--IP Camera 확인-->
<article class="col-xl-10 float-right">
	<div class="row">
		<div class="col-xl-12 ">
			<div class="jarviswidget jarviswidget-color-teal" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
				<header>
					<div class="widget-header">	
						<h2><i class="fa fa-video-camera"></i>&nbsp;&nbsp;&nbsp;IP Camera 확인 (농장이름-동)</h2>	
					</div>
				</header>
				
				<div class="widget-body no-padding">
					<div class="widget-body-toolbar">
						<form id="search_form" class="form-inline" onsubmit="return false;">
							<button type="button" class="btn btn-primary btn-sm" onClick="get_camera_list('all')"><span class="glyphicon glyphicon-search"></span>&nbsp;&nbsp;전체</button>&nbsp;
							<button type="button" class="btn btn-success btn-sm" onClick="get_camera_list('in')"><span class="glyphicon glyphicon-search"></span>&nbsp;&nbsp;입추</button>&nbsp;
							<button type="button" class="btn btn-danger  btn-sm" onClick="get_camera_list('out')"><span class="glyphicon glyphicon-search"></span>&nbsp;&nbsp;출하</button>
						</form>
					</div>

					<div id="camera_grid">

					</div>
					
				</div>
						
			</div>
		</div>
	</div>
</article>
<?
include_once("../inc/bottom.php");
?>

<script language="javascript">

	var open_window;
	var open_url = "";

	$(document).ready(function(){
		
		hide_dong = true;

		call_tree_view("", get_camera_list);
		set_tree_search(get_camera_list);
	});

	function get_camera_list(comm){
		var data_arr = {}; 
		data_arr['oper'] = 'get_camera_grid';
		data_arr['comm'] = comm;
		$.ajax({
			url:'0103_action.php', data:data_arr, cache:false, type:'post', dataType:'json',
			success: function(data) {
				$("#camera_grid").html(data.camera_grid_data);
			}
		});
	};
	
	// 카메라 선택 시 팝업창 띄움
	function camera_popup(name, avg_weight, img_url){

		let pop_width = 1024;
		let pop_height = 800;

		let pop_left = Math.ceil(( window.screen.width - pop_width ) / 2);
		let pop_top = Math.ceil(( window.screen.height - pop_height ) / 2);

		let options = "width=" + pop_width + ", height=" + pop_height + ", left=" + pop_left + ", top=" + pop_top

		open_url = img_url;
		open_window = window.open("camera_popup.php?title=" + name, "camera_popup", options);
	};

	function camera_load(img_obj){
		// 팝업창 닫히면 
		open_window.onbeforeunload = function(){
			img_obj.onload = function(){"";};
			img_obj.setAttribute("src", "");
		};   

		// 이미지가 로드되면
		img_obj.onload = function(){
			img_obj.setAttribute("src", open_url + "&date=" + (new Date()).getTime());
		};

		// 이미지 로드 중 에러 발생시
		img_obj.onerror = function(){
			img_obj.setAttribute("src", "../images/noimage.jpg");
			img_obj.onload = function(){"";};
		};

		// 첫 이미지 로드
		img_obj.setAttribute("src", open_url + "&date=" + (new Date()).getTime());
	};

</script>