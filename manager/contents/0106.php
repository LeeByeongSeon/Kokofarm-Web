<?
include_once("../inc/top.php");

$inout = isset($_REQUEST["inout"]) ? $_REQUEST["inout"] : "입추";
$code = isset($_REQUEST["code"]) ? $_REQUEST["code"] : "";
//$name = isset($_REQUEST["name"]) ? $_REQUEST["name"] : "";

$list_query = "SELECT be.beStatus, be.beComeinCode, fd.fdName FROM buffer_sensor_status AS be 
				LEFT JOIN farm_detail AS fd ON fd.fdFarmid = be.beFarmid AND fd.fdDongid = be.beDongid ORDER BY fdName ASC";

$result = get_select_data($list_query);

$list_combo = array();

// 입출하 상태에 따라 콤보박스 생성
foreach($result as $row){
	$option = "<option value=\"" . $row["fdName"] . "\" comein_code=\"" . $row["beComeinCode"] . "\" " .($row["beComeinCode"] == $code ? "selected" : ""). ">" . $row["fdName"] . "</option>";
	
	if($row["beStatus"] == "O"){
		$list_combo["out"] .= $option;
	}
	else{
		$list_combo["in"] .= $option;
	}

	$list_combo["all"] .= $option;
}

$view_list_combo = "<select class=\"form-control w-auto\" name=\"search_list\">";
switch($inout){
	case "":
		$view_list_combo .= $list_combo["all"];
		break;
	case "입추":
		$view_list_combo .= $list_combo["in"];
		break;
	case "출하":
		$view_list_combo .= $list_combo["out"];
		break;
}
$view_list_combo .= "</select>";		// 처음에 출력될 콤보

$list_combo = json_encode($list_combo);	// javascript 에서 활용할 콤보 배열

$inout_combo = "<select class=\"form-control w-auto\" name=\"search_inout\">
					<option value='' " .($inout == "" ? "selected" : ""). ">전체</option>
					<option value='입추' " .($inout == "입추" ? "selected" : ""). ">입추</option>
					<option value='출하' " .($inout == "출하" ? "selected" : ""). ">출하</option>
				</select>";

?>

<div class="row">
	<div class="col-xs-12">
		<div class="jarviswidget jarviswidget-color-white no-padding mb-1" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
			<div class="widget-body border" style="padding:0.5rem; min-height: 0;">
				<form id="search_form" class="form-inline mr-auto" onsubmit="return false;">&nbsp;&nbsp;
					<span class="font-weight-bold text-primary"><i class="fa fa-home"></i>&nbsp;&nbsp;농장 검색 : </span>&nbsp;&nbsp;
					<?=$inout_combo?>&nbsp;&nbsp;
					<?=$view_list_combo?>
					<!-- <button type="button" class="btn btn-primary btn-sm" onClick="search_action('search')"><span class="fa fa-check"></span>&nbsp;&nbsp;확인</button>&nbsp;&nbsp; -->
				</form>
			</div>	
		</div>
	</div>
</div>

<!--출하상태 표시 div-->		
<div class="card border-danger mb-4 mx-auto d-none" id="top_status_info">
	<div class="card-header font-weight-bold text-primary pl-2"><i class="fa fa-bell-o text-orange swing animated"></i> 상태 알림</div>
	<div class="card-body">
		<table class="table-borderless w-100 text-center" style="line-height: 2.5rem;">
			<tr>
				<td colspan="2" id="top_status_msg"></td>
			</tr>
			<tr>
				<td class="w-50 font-md text-secondary" id="top_time_info"></td><td class="w-50 font-md text-danger font-weight-bold" id="top_last_time"></td>
			</tr>
			<tr>
				<td class="w-50 font-md text-secondary" id="top_avg_info"></td><td class="w-50 font-md text-danger font-weight-bold" id="top_last_avg"></td>
			</tr>
		</table>
	</div>
</div>

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

	var sensor_chart_data = null;

    var comein_code = "";
	var list_combo = "";

	var today_data = null;
	var daily_data = null;

	$(document).ready(function(){

		$(".btn_display_toggle").off("click").on("click", function(){

			//$(this).children("i").toggleClass("fa-minus").toggleClass("fa-plus");
			$(this).parents(".jarviswidget").children(".widget-body").toggle();
		});

		list_combo = <?=$list_combo?>;
		
		// 입출하 콤보박스 설정
		let cookie_inout = get_cookie("inout");
		if(cookie_inout != null){
			$("#search_form [name=search_inout]").val(cookie_inout);

			switch(cookie_inout){
				default:
					$("#search_form [name=search_list]").html(list_combo["all"]);
					break;
				case "입추":
					$("#search_form [name=search_list]").html(list_combo["in"]);
					break;
				case "출하":
					$("#search_form [name=search_list]").html(list_combo["out"]);
					break;

			}
		}

		// 선택된 동 콤보박스 설정
		let cookie_code = get_cookie("code");
		if(cookie_code != null){
			comein_code = cookie_code;
			$("#search_form [name=search_list]").val(get_cookie("name"));
		}
		else{
			comein_code = $("#search_form [name=search_list] option:selected").attr("comein_code");
			set_cookie("code", comein_code, 1);
		}

		get_dong_data();

	});

	$("#search_form [name=search_inout]").off("change").on("change", function(){		// off로 이벤트 중복을 방지함
		let inout = $("#search_form [name=search_inout] option:selected").val();

		set_cookie("inout", inout, 1);

		switch(inout){
			default:
				$("#search_form [name=search_list]").html(list_combo["all"]);
				break;
			case "입추":
				$("#search_form [name=search_list]").html(list_combo["in"]);
				break;
			case "출하":
				$("#search_form [name=search_list]").html(list_combo["out"]);
				break;

		}
	});

	$("#search_form [name=search_list]").off("change").on("change", function(){		// off로 이벤트 중복을 방지함
		comein_code = $("#search_form [name=search_list] option:selected").attr("comein_code");
		let name = $("#search_form [name=search_list] option:selected").val();
		set_cookie("code", comein_code, 1);
		set_cookie("name", name, 1);

		get_dong_data();
	});

	function get_dong_data(){
		get_buffer();
		get_all();
		get_today();
	};

	function get_buffer(){
		let data_arr = {};
		data_arr["oper"] = "get_buffer";	
		data_arr["cmCode"] = comein_code;	//등록코드
		
		$.ajax({
			url:'0106_action.php',
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
		data_arr["cmCode"] = comein_code;

		$.ajax({
			url:'0106_action.php',
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
		data_arr["cmCode"] = comein_code;

		$.ajax({
			url:'0106_action.php',
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