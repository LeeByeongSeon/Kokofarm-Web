<?
include_once("../inc/top.php");

include_once("../common/php_module/common_func.php");

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
			<div class="jarviswidget jarviswidget-color-gray-dark" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
				<header>
					<div class="widget-header">	
						<h2><i class="fa fa-video-camera"></i>&nbsp;IP Camera 확인 (농장이름-동)</h2>	
					</div>
					<div class="widget-toolbar ml-auto" style="cursor: default">
						<span class='badge bg-green'>&nbsp;</span>&nbsp;입추
						<span class='badge bg-gray'>&nbsp;</span>&nbsp;출하
					</div>
				</header>
				
				<div class="widget-body no-padding">
					<div class="widget-body-toolbar">
						<form id="search_form" class="form-inline" onsubmit="return false;">
							<button type="button" class="btn btn-labeled btn-default btn-sm" onClick="get_camera_list('all')"><span class="btn-label"><i class="fa fa-search"></i></span>전체</button>&nbsp;
							<button type="button" class="btn btn-labeled btn-success btn-sm" onClick="get_camera_list('in')"><span class="btn-label"><i class="fa fa-search"></i></span>입추</button>&nbsp;
							<button type="button" class="btn btn-labeled btn-secondary btn-sm" onClick="get_camera_list('out')"><span class="btn-label"><i class="fa fa-search"></i></span>출하</button>
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
	

</script>