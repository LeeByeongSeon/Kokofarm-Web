<?
include_once("../inc/top.php")
?>

<!--현재 외기환경 센서정보-->	
<div class="row" id="row_outsensor">
	<div class="col-xs-12">
		<div class="jarviswidget jarviswidget-color-white no-padding mb-3" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">							
			<header style="border-radius: 10px 10px 0px 0px; border : 4px solid #eee; border-bottom: 0; background-color: #0c6ad0;">
				<div class="widget-header">	
					<h2 class="font-weight-bold text-white sensor"><i class="fa fa-info-circle"></i>&nbsp;외기환경 센서</h2>	
				</div>
			</header>
			<div class="widget-body p-2" style="border-radius: 0px 0px 10px 10px; border : 4px solid #eee; border-top: 0;">
				<div class="col-xs-6 p-2 border-bottom border-right">
					<div class="col-xs-4 no-padding"><img src="../images/temp.png"><br><span></span></div>
					<div class="col-xs-8 no-padding text-right">온도(℃)<br><span id="extra_out_temp" style="font-size:28px">-</span></div>
				</div>
				<div class="col-xs-6 p-2 border-bottom">
					<div class="col-xs-4 no-padding"><img src="../images/humi.png"><br><span></span></div>
					<div class="col-xs-8 no-padding text-right">습도(％)<br><span id="extra_out_humi" style="font-size:28px">-</span></div>
				</div>
				<div class="col-xs-6 p-2 border-bottom border-right">
					<div class="col-xs-4 no-padding"><img src="../images/nh3.png"><br><span></span></div>
					<div class="col-xs-8 no-padding text-right">암모니아(ppm)<br><span id="extra_out_nh3" style="font-size:28px">-</span></div>
				</div>
				<div class="col-xs-6 p-2 border-bottom">
					<div class="col-xs-4 no-padding"><img src="../images/h2s.png"><br><span></span></div>
					<div class="col-xs-8 no-padding text-right">황화수소(ppm)<br><span id="extra_out_h2s" style="font-size:28px">-</span></div>
				</div>
				<div class="col-xs-6 p-2 border-bottom border-right">
					<div class="col-xs-4 no-padding"><img src="../images/pm10.png"><br><span></span></div>
					<div class="col-xs-8 no-padding text-right">미세먼지<br><span id="extra_out_dust" style="font-size:28px">-</span></div>
				</div>
				<div class="col-xs-6 p-2 border-bottom">
					<div class="col-xs-4 no-padding"><img src="../images/pm2.5.png"><br><span></span></div>
					<div class="col-xs-8 no-padding text-right">초미세먼지<br><span id="extra_out_udust" style="font-size:28px">-</span></div>
				</div>
				<div class="col-xs-6 p-2 border-bottom border-right">
					<div class="col-xs-4 no-padding"><img src="../images/wind-direction.png"><br><span></span></div>
					<div class="col-xs-8 no-padding text-right">풍향<br><span id="extra_out_direction" style="font-size:25px">-</span></div>
				</div>
				<div class="col-xs-6 p-2 border-bottom">
					<div class="col-xs-4 no-padding"><img src="../images/wind.png"><br><span></span></div>
					<div class="col-xs-8 no-padding text-right">풍속(m/s)<br><span id="extra_out_wind" style="font-size:28px">-</span></div>
				</div>
				<div class="col-xs-6 p-2 border-right">
					<div class="col-xs-4 no-padding text-center"><img src="../images/solar.png"><br><span></span></div>
					<div class="col-xs-8 no-padding text-right"><span style="font-size:15px">일사량</span>(W/㎡)<br><span id="extra_out_solar" style="font-size:28px">-</span></div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-xs-12">
		<div class="jarviswidget jarviswidget-color-white no-padding mb-3" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">							
			<header style="border-radius: 10px 10px 0px 0px; border : 4px solid #eee; border-bottom: 0; background-color: #0c6ad0;">
				<div class="widget-header">	
					<h2 class="font-weight-bold text-white"><i class="fa fa-bar-chart-o"></i>&nbsp;오늘 외기환경 변화</h2>	
				</div>
			</header>
			<div class="widget-body no-padding" style="border-radius: 0px 0px 10px 10px; border : 4px solid #eee; border-top: 0;">
				<div class="widget-body-toolbar">
					<div class="btn-group">
						<button type="button" class="btn btn-default btn-sm" onClick="get_sensor('chart_temp_humi', 'today');">
							<i class="fa fa-sun-o text-danger"></i>&nbsp;&nbsp;온/습도
						</button>
						<button type="button" class="btn btn-default btn-sm" onClick="get_sensor('chart_gas', 'today');">
							<i class="fa fa-warning text-warning"></i>&nbsp;&nbsp;악취
						</button>
						<button type="button" class="btn btn-default btn-sm" onClick="get_sensor('chart_dust', 'today');">
							<i class="fa fa-cloud text-secondary"></i>&nbsp;&nbsp;미세먼지
						</button>
						<button type="button" class="btn btn-default btn-sm" onClick="get_sensor('chart_wind', 'today');">
							<i class="fa fa-flag text-primary"></i>&nbsp;&nbsp;풍향/풍속
						</button>
					</div>
				</div>
				<div id="today_outsensor_chart" style="height: 260px;"></div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-xs-12">
		<div class="jarviswidget jarviswidget-color-white no-padding mb-3" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">							
			<header style="border-radius: 10px 10px 0px 0px; border : 4px solid #eee; border-bottom: 0; background-color: #0c6ad0;">
				<div class="widget-header">	
					<h2 class="font-weight-bold text-white"><i class="fa fa-bar-chart-o"></i>&nbsp;일령별 외기환경 변화</h2>	
				</div>
			</header>
			<div class="widget-body no-padding" style="border-radius: 0px 0px 10px 10px; border : 4px solid #eee; border-top: 0;">
			<div class="widget-body-toolbar">
					<div class="btn-group">
						<button type="button" class="btn btn-default btn-sm" onClick="get_sensor('chart_temp_humi', 'daily');">
							<i class="fa fa-sun-o text-danger"></i>&nbsp;&nbsp;온/습도
						</button>
						<button type="button" class="btn btn-default btn-sm" onClick="get_sensor('chart_gas', 'daily');">
							<i class="fa fa-warning text-warning"></i>&nbsp;&nbsp;악취
						</button>
						<button type="button" class="btn btn-default btn-sm" onClick="get_sensor('chart_dust', 'daily');">
							<i class="fa fa-cloud text-secondary"></i>&nbsp;&nbsp;미세먼지
						</button>
						<button type="button" class="btn btn-default btn-sm" onClick="get_sensor('chart_wind', 'daily');">
							<i class="fa fa-flag text-primary"></i>&nbsp;&nbsp;풍향/풍속
						</button>
					</div>
				</div>
				<div id="daily_outsensor_chart" style="height: 260px;"></div>
			</div>
		</div>
	</div>
</div>

<?
include_once("../inc/bottom.php")
?>

<script language="javascript">

	var today_data = null;
	var daily_data = null;

	function get_dong_data(){
		get_buffer();
		get_all();
		get_today();
	};

	function get_buffer(){
		let data_arr = {};
		data_arr["oper"] = "get_buffer";	
		data_arr["cmCode"] = top_code;	//등록코드
		
		$.ajax({
			url:'0104_action.php',
			data:data_arr,
			cache:false,
			type:'post',
			dataType:'json',
			success: function(data){
				// 급이, 급수, 외기 창 표시할지 선택
				$.each(data.extra, function(key, val){	$("#" + key).html(val); });
			}
		});
	};

	function get_all(){
		
		let data_arr = {};
		data_arr["oper"]   = "get_all";
		data_arr["cmCode"] = top_code;

		$.ajax({
			url:'0104_action.php',
			type:'post',
			cache:false,
			data:data_arr,
			dataType:'json',
			success: function(data){
				daily_data = data;
				draw_select_chart("daily_outsensor_chart", data.chart_temp_humi, "세로-Bar", "Y", "N", 12, "hh");
			}
		});
	};

	function get_today(){
		
		let data_arr = {};
		data_arr["oper"]   = "get_today";
		data_arr["cmCode"] = top_code;

		$.ajax({
			url:'0104_action.php',
			type:'post',
			cache:false,
			data:data_arr,
			dataType:'json',
			success: function(data){
				today_data = data;
				draw_select_chart("today_outsensor_chart", data.chart_temp_humi, "세로-Bar", "Y", "N", 12, "hh");
			}
		});
	};

	function get_sensor(chart_name, type){
		let use_div = null;
		let use_data = null;
		switch(type){
			case "today":
				use_div = "today_outsensor_chart";
				use_data = today_data;
				break;
			case "daily":
				use_div = "daily_outsensor_chart";
				use_data = daily_data;
				break;
		}

		if(use_data != null){
			draw_select_chart(use_div, use_data[chart_name], "세로-Bar", "Y", "N", 12, "hh");
		}
	}


</script>