<?
include_once("../inc/top.php")
?>
	
<div class="row">
	<div class="col-xs-12">
		<div class="jarviswidget jarviswidget-color-white no-padding" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">							
			<header style="border-radius: 10px 10px 0 0">
				<div class="widget-header">	
					<h2 class="font-weight-bold text-primary"><i class="fa fa-bar-chart-o text-warning"></i>&nbsp;&nbsp;오늘 급이량 변화</h2>	
				</div>
			</header>
			<div class="widget-body shadow" style="border-radius: 0 0 10px 10px; padding:0.5rem">
				<div id="today_feed_chart" style="height: 260px;"></div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-xs-12">
		<div class="jarviswidget jarviswidget-color-white no-padding" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">							
			<header style="border-radius: 10px 10px 0 0">
				<div class="widget-header">	
					<h2 class="font-weight-bold text-primary"><i class="fa fa-bar-chart-o text-warning"></i>&nbsp;&nbsp;일령별 급이량 변화</h2>	
				</div>
			</header>
			<div class="widget-body shadow" style="border-radius: 0 0 10px 10px; padding:0.5rem">
				<div id="daily_feed_chart" style="height: 260px;"></div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-xs-12">
		<div class="jarviswidget jarviswidget-color-white no-padding" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">							
			<header style="border-radius: 10px 10px 0 0">
				<div class="widget-header">	
					<h2 class="font-weight-bold text-primary"><i class="fa fa-bar-chart-o text-warning"></i>&nbsp;&nbsp;오늘 급수량 변화</h2>	
				</div>
			</header>
			<div class="widget-body shadow" style="border-radius: 0 0 10px 10px; padding:0.5rem">
				<div id="today_water_chart" style="height: 260px;"></div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-xs-12">
		<div class="jarviswidget jarviswidget-color-white no-padding" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">							
			<header style="border-radius: 10px 10px 0 0">
				<div class="widget-header">	
					<h2 class="font-weight-bold text-primary"><i class="fa fa-bar-chart-o text-warning"></i>&nbsp;&nbsp;일령별 급수량 변화</h2>	
				</div>
			</header>
			<div class="widget-body shadow" style="border-radius: 0 0 10px 10px; padding:0.5rem">
				<div id="daily_water_chart" style="height: 260px;"></div>
			</div>
		</div>
	</div>
</div>


<?
include_once("../inc/bottom.php")
?>

<script language="javascript">

	var comein_code = "";

	$(document).ready(function(){
		load_data();
	});

	function get_dong_data(cmCode, beStatus){
		comein_code = cmCode;
		get_all();
		get_today();
	};

	function get_all(){
		
		let data_arr = {};
		data_arr["oper"]   = "get_all";
		data_arr["cmCode"] = comein_code;

		$.ajax({
			url:'0103_action.php',
			type:'post',
			cache:false,
			data:data_arr,
			dataType:'json',
			success: function(data){
				draw_bar_line_chart("daily_feed_chart", data.chart_feed, "Y", "N", 12, "DD");
				draw_bar_line_chart("daily_water_chart", data.chart_water, "Y", "N", 12, "DD");
			}
		});
	}

	function get_today(){
		
		let data_arr = {};
		data_arr["oper"]   = "get_today";
		data_arr["cmCode"] = comein_code;

		$.ajax({
			url:'0103_action.php',
			type:'post',
			cache:false,
			data:data_arr,
			dataType:'json',
			success: function(data){
				draw_bar_line_chart("today_feed_chart", data.chart_feed, "Y", "N", 12, "mm");
				draw_bar_line_chart("today_water_chart", data.chart_water, "Y", "N", 12, "mm");
			}
		});
	}
</script>