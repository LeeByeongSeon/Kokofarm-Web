<?
include_once("../inc/top.php")
?>

<!--현재 외기환경 센서 정보-->
<div class="row" id="row_outsensor" style="margin-top: -25px;">
	<div class="col-sm-12 no-padding">
		<div class="jarviswidget jarviswidget-color-white no-padding" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">							
			<header style="border-radius: 15px 15px 0 0; border : 4px solid #E6E6E6; border-bottom: 0; background-image: url(../images/bgcolor.png); background-repeat: no-repeat">
				<div class="widget-header">	
					<h2 class="font-weight-bold text-white sensor">외기환경 센서 정보</h2>	
				</div>
			</header>
			<div class="widget-body" style="border-radius: 0px 0px 15px 15px; border : 4px solid #E6E6E6; border-top: 0; padding:0.5rem">
				<div class="col-sm-3">
					<div class="col-sm-4 no-padding text-center text-danger"><img src="../images/temp.png"><br><span></span></div>
					<div class="col-sm-8 no-padding text-right"><span style="font-size: 18px">온도</span><br><span id="extra_out_temp" style="font-size:28px">0</span>(℃)</div>
					<div style="clear:both"></div><hr style="margin-top:0px">
				</div>
				<div class="col-sm-3">
					<div class="col-sm-4 no-padding text-center"><img src="../images/drop.png"><br><span></span></div>
					<div class="col-sm-8 no-padding text-right"><span style="font-size: 18px">습도</span><br><span id="extra_out_humi" style="font-size:28px">0</span>(％)</div>
					<div style="clear:both"></div><hr style="margin-top:0px">
				</div>
				<div class="col-sm-3">
					<div class="col-sm-4 no-padding text-center"><img src="../images/nh3.png"><br><span></span></div>
					<div class="col-sm-8 no-padding text-right"><span style="font-size: 18px">암모니아</span><br><span id="extra_out_nh3" style="font-size:28px">0</span>(ppm)</div>
					<div style="clear:both"></div><hr style="margin-top:0px">
				</div>
				<div class="col-sm-3">
					<div class="col-sm-4 no-padding text-center"><img src="../images/h2s.png"><br><span></span></div>
					<div class="col-sm-8 no-padding text-right"><span style="font-size: 18px">황화수소</span><br><span id="extra_out_h2s" style="font-size:28px">0</span>(ppm)</div>
					<div style="clear:both"></div><hr style="margin-top:0px">
				</div>
				<div class="col-sm-3">
					<div class="col-sm-4 no-padding text-center"><img src="../images/pm10.png"><br><span></span></div>
					<div class="col-sm-8 no-padding text-right"><span style="font-size: 18px">미세먼지</span><br><span id="extra_out_dust" style="font-size:28px">0</span>(㎍/㎥)</div>
					<div style="clear:both"></div>
				</div>
				<div class="col-sm-3">
					<div class="col-sm-4 no-padding text-center"><img src="../images/pm2.5.png"><br><span></span></div>
					<div class="col-sm-8 no-padding text-right"><span style="font-size: 18px">초미세먼지</span><br><span id="extra_out_udust" style="font-size:28px">0</span>(㎍/㎥)</div>
					<div style="clear:both"></div>
				</div>
				<div class="col-sm-3">
					<div class="col-sm-4 no-padding text-center"><img src="../images/wind-direction.png"><br><span></span></div>
					<div class="col-sm-8 no-padding text-right"><span style="font-size: 18px">풍향</span><br><span id="extra_out_direction" style="font-size:25px">0</span></div>
					<div style="clear:both"></div>
				</div>
				<div class="col-sm-3">
					<div class="col-sm-4 no-padding text-center"><img src="../images/wind.png"><br><span></span></div>
					<div class="col-sm-8 no-padding text-right"><span style="font-size: 18px">풍속</span><br><span id="extra_out_wind" style="font-size:28px">0</span>(m/s)</div>
					<div style="clear:both"></div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-xs-12 no-padding" style="margin-top:-25px;">
		<div class="jarviswidget jarviswidget-color-white no-padding" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">							
			<header style="border-radius: 15px 15px 0 0; border : 4px solid #E6E6E6; border-bottom: 0; background-image: url(../images/bgcolor.png); background-repeat: no-repeat">
				<div class="widget-header">	
					<h2 class="font-weight-bold text-white">오늘 외기환경 변화</h2>	
				</div>
			</header>
			<div class="widget-body" style="border-radius: 0px 0px 15px 15px; border : 4px solid #E6E6E6; border-top: 0;">
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
	<div class="col-xs-12 no-padding" style="margin-top:-25px;">
		<div class="jarviswidget jarviswidget-color-white no-padding" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">							
			<header style="border-radius: 15px 15px 0px 0px; border : 4px solid #E6E6E6; border-bottom: 0; background-image: url(../images/bgcolor.png); background-repeat: no-repeat">
				<div class="widget-header">	
					<h2 class="font-weight-bold text-white">일령별 외기환경 변화</h2>	
				</div>
			</header>
			<div class="widget-body" style="border-radius: 0px 0px 15px 15px; border : 4px solid #E6E6E6; border-top: 0;">
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

	$(document).ready(function(){
		load_data();
	});

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
				draw_select_chart("today_outsensor_chart", data.chart_temp_humi, "세로-Bar", "Y", "N", 12, "mm");
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
			draw_select_chart(use_div, use_data[chart_name], "세로-Bar", "Y", "N", 12, "mm");
		}
	}


</script>