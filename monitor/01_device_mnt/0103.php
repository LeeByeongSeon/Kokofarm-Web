<?
include_once("../inc/top.php");

include_once("../../common/php_module/common_func.php");

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
						<form id="searchFORM" class="form-inline" onsubmit="return false;">
							<button type="button" class="btn btn-primary btn-sm" onClick="actionBtn('allCamera')"><span class="glyphicon glyphicon-search"></span>&nbsp;&nbsp;전체</button>&nbsp;
							<button type="button" class="btn btn-warning btn-sm" onClick="actionBtn('inCamera')"><span class="glyphicon glyphicon-search"></span>&nbsp;&nbsp;입추</button>&nbsp;
							<button type="button" class="btn btn-danger  btn-sm" onClick="actionBtn('outCamera')"><span class="glyphicon glyphicon-search"></span>&nbsp;&nbsp;출하</button>
						</form>
					</div>

					<div id="ipCameras">

					</div>
					
				</div>
						
			</div>
		</div>
	</div>
</article>
<?
include_once("WindowPopup.html");
?>
<?
include_once("../inc/bottom.php");
?>

<script language="javascript">

	$(document).ready(function(){
		
		hide_dong = true;

		actionBtn("allCamera");

		call_tree_view("", act_grid_data);
		set_tree_search(act_grid_data);
	});

	function actionBtn(e){
		switch(e){
			case "allCamera":
				var dataArr = {}; 
					dataArr['oper'] = 'allCamera';
				$.ajax({
					url:'0103_action.php',
					data:dataArr,
					cache:false,
					type:'post',
					dataType:'json',
					success: function(data) {
						$("#ipCameras").html(data.ipCameras);
					}
				});
				break;
			
			case "inCamera":
				var dataArr = {}; 
					dataArr['oper'] = 'inCamera';
				$.ajax({
					url:'0103_action.php',
					data:dataArr,
					cache:false,
					type:'post',
					dataType:'json',
					success: function(data) {
						$("#ipCameras").html(data.ipCameras);
					}
				});
				break;
			
			case "outCamera":
				var dataArr = {}; 
					dataArr['oper'] = 'outCamera';
				$.ajax({
					url:'0103_action.php',
					data:dataArr,
					cache:false,
					type:'post',
					dataType:'json',
					success: function(data) {
						$("#ipCameras").html(data.ipCameras);
					}
				});
				break;
		}
	}
		
	// 트리뷰 버튼 클릭시 리로드 이벤트
	// function act_grid_data(action){
	// 	switch(action){
	// 		default:
	// 			actionBtn(action);
	// 			break;
	// 	}
	// };

</script>