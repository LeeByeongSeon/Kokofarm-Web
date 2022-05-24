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

<!--일일 급이 / 급수량-->
<div class="row" id="row_feed_water">
	<div class="col-xs-12">
		<div class="jarviswidget jarviswidget-color-white no-padding mb-3" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">							
			<header style="border-radius: 10px 10px 0px 0px; border : 4px solid #eee; border-bottom: 0; background-color: #0c6ad0;">
				<div class="widget-header">	
					<h2 class="font-weight-bold text-white feeder"><i class="fa fa-info-circle"></i>&nbsp;급이량 및 급수량
						<!-- <span class="font-sm badge bg-orange">마리당 급이량 : <span id="total_per_feed"> 0 </span>g</span> -->
					</h2>	
				</div>
				<div class="widget-toolbar ml-auto">
					<div class="btn-group">
						<button type="button" class="btn btn-xs btn-light text-primary btn_display_toggle" style="height: 25px">&nbsp;<i class="fa fa-minus"></i>&nbsp;</button>
					</div>
				</div>
			</header>
			<div class="widget-body p-3" style="border-radius: 0px 0px 10px 10px; border : 4px solid #eee; border-top: 0; padding:0.5rem;">
				<div class="col-xs-12 d-flex align-items-center justify-content-between no-padding">
					<div class="col-xs-6 no-padding text-center">
						<span class="font-md text-secondary">수 당 급이량 <br><span class="font-md text-danger font-weight-bold" id="dong_per_feed"></span></span>
					</div>
					<div class="col-xs-6 no-padding text-center">
						<span class="font-md text-secondary">수 당 급수량 <br><span class="font-md text-primary font-weight-bold" id="dong_per_water"></span></span>
					</div>
				</div>

				<div style="clear:both"></div><hr style="margin-top:10px; margin-bottom: 10px">

				<div class="col-xs-12 d-flex align-items-center justify-content-between no-padding">
					<div class="col-xs-3 no-padding text-center">
						<img id="feed_img" src="../images/feed-04.png" style="width: 7rem;"><br>
						<div class="carousel-caption mb-4"><h3 class="font-weight-bold text-secondary" id="extra_feed_percent">-%</h3></div>
						<div class="col-xs-12 text-center no-padding"><span>사료잔량 <span id="extra_feed_remain">-</span>(Kg)</span></div>
					</div>
					<div class="col-xs-3 no-padding text-right">
						<span style="font-size:12px">전체</span>(kg)<br><span id="extra_all_feed" style="font-size:21px">-</span>
					</div>
					<div class="col-xs-3 no-padding text-right">
						<span style="font-size:12px">오늘</span>(kg)<br><span id="extra_curr_feed" style="font-size:21px">-</span>
					</div>
					<div class="col-xs-3 no-padding text-right">
						<span style="font-size:12px">전일</span>(kg)<br><span id="extra_prev_feed" style="font-size:21px">-</span>
					</div>
				</div>

				<div style="clear:both"></div><hr style="margin-top:10px; margin-bottom: 10px">

				<div  class="col-xs-12 d-flex align-items-center justify-content-between no-padding">
					<div class="col-xs-3 no-padding text-center">
						<img src="../images/water-02.png" style="width: 5rem;"><br><span></span>
					<div class="col-xs-12 text-center no-padding"><span>시간당 급수량 <span id="extra_water_per_hour">-</span>(L)</span></div>
					</div>
					<div class="col-xs-3 no-padding text-right">
						<span style="font-size:12px">전체</span>(L)<br><span id="extra_all_water" style="font-size:21px">-</span>
					</div>
					<div class="col-xs-3 no-padding text-right">
						<span style="font-size:12px">오늘</span>(L)<br><span id="extra_curr_water" style="font-size:21px">-</span>
					</div>
					<div class="col-xs-3 no-padding text-right">
						<span style="font-size:12px">전일</span>(L)<br><span id="extra_prev_water" style="font-size:21px">-</span>
					</div>
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
					<h2 class="font-weight-bold text-white"><i class="fa fa-bar-chart-o"></i>&nbsp;오늘 급이량 변화</h2>	
				</div>
			</header>
			<div class="widget-body no-padding" style="border-radius: 0px 0px 10px 10px; border : 4px solid #eee; border-top: 0;">
				<div id="today_feed_chart" style="height: 260px;"></div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-xs-12">
		<div class="jarviswidget jarviswidget-color-white no-padding mb-3" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">							
			<header style="border-radius: 10px 10px 0px 0px; border : 4px solid #eee; border-bottom: 0; background-color: #0c6ad0;">
				<div class="widget-header">	
					<h2 class="font-weight-bold text-white"><i class="fa fa-bar-chart-o"></i>&nbsp;일령별 급이량 변화</h2>	
				</div>
				<div class="widget-toolbar ml-auto">
					<button type="button" class="btn btn-xs btn-default" style="height: 25px" onClick="send_excel_data('일령별급이량')"><span class="fa fa-file-excel-o"></span>&nbsp;Excel</button>
				</div>
			</header>
			<div class="widget-body no-padding" style="border-radius: 0px 0px 10px 10px; border : 4px solid #eee; border-top: 0;">
				<div id="daily_feed_chart" style="height: 260px;"></div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-xs-12">
		<div class="jarviswidget jarviswidget-color-white no-padding mb-3" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">							
			<header style="border-radius: 10px 10px 0px 0px; border : 4px solid #eee; border-bottom: 0; background-color: #0c6ad0;">
				<div class="widget-header">	
					<h2 class="font-weight-bold text-white"><i class="fa fa-bar-chart-o"></i>&nbsp;오늘 급수량 변화</h2>	
				</div>
			</header>
			<div class="widget-body no-padding" style="border-radius: 0px 0px 10px 10px; border : 4px solid #eee; border-top: 0;">
				<div id="today_water_chart" style="height: 260px;"></div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-xs-12">
		<div class="jarviswidget jarviswidget-color-white no-padding mb-3" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">							
			<header style="border-radius: 10px 10px 0px 0px; border : 4px solid #eee; border-bottom: 0; background-color: #0c6ad0;">
				<div class="widget-header">	
					<h2 class="font-weight-bold text-white"><i class="fa fa-bar-chart-o"></i>&nbsp;일령별 급수량 변화</h2>	
				</div>
				<div class="widget-toolbar ml-auto">
					<button type="button" class="btn btn-xs btn-default" style="height: 25px" onClick="send_excel_data('일령별급수량')"><span class="fa fa-file-excel-o"></span>&nbsp;Excel</button>
				</div>
			</header>
			<div class="widget-body no-padding" style="border-radius: 0px 0px 10px 10px; border : 4px solid #eee; border-top: 0;">
				<div id="daily_water_chart" style="height: 260px;"></div>
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

	$(document).ready(function(){

		$(".btn_display_toggle").off("click").on("click", function(){

			//$(this).children("i").toggleClass("fa-minus").toggleClass("fa-plus");
			$(this).parents(".jarviswidget").children(".widget-body").toggle();
		});

		list_combo = <?=$list_combo?>;

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
		get_feed_per_count();
	};

	function get_buffer(){
		let data_arr = {};
		data_arr["oper"] = "get_buffer";	
		data_arr["cmCode"] = comein_code;	//등록코드
		
		$.ajax({
			url:'0105_action.php',
			data:data_arr,
			cache:false,
			type:'post',
			dataType:'json',
			success: function(data){
				$.each(data.extra, function(key, val){	$("#" + key).html(val); });

				let per = data.extra.extra_feed_percent;
				per = parseInt(per);
				if(per <= 10){ 				document.getElementById("feed_img").setAttribute("src", "../images/feed-00.png"); }
				if(per > 10 && per <= 35){ 	document.getElementById("feed_img").setAttribute("src", "../images/feed-01.png"); }
				if(per > 35 && per <= 65){ 	document.getElementById("feed_img").setAttribute("src", "../images/feed-02.png"); }
				if(per > 65 && per <= 90){ 	document.getElementById("feed_img").setAttribute("src", "../images/feed-03.png"); }
				if(per > 90){ 				document.getElementById("feed_img").setAttribute("src", "../images/feed-04.png"); }
			}
		});
	};

	function get_all(){
		
		let data_arr = {};
		data_arr["oper"]   = "get_all";
		data_arr["cmCode"] = comein_code;

		$.ajax({
			url:'0105_action.php',
			type:'post',
			cache:false,
			data:data_arr,
			dataType:'json',
			success: function(data){

				sensor_chart_data = data;

				let params = {};
				params["graph_color"] = ["#FF9900","#2FB5F0","#109618","#990099"];
				params["font_size"] = 12;
				params["is_zoom"] = true;
				params["period"] = "DD";
				params["date_format"] = "YYYY-MM-DD";
				//draw_bar_line_chart("daily_feed_chart", data.chart_feed, "Y", "N", 12, "DD");
				//draw_bar_line_chart("daily_water_chart", data.chart_water, "Y", "N", 12, "DD", "#2FB5F0");
				draw_chart("daily_feed_chart", data.chart_feed_daily, params);
				params["graph_color"] = ["#2FB5F0","#FF9900","#109618","#990099"];
				draw_chart("daily_water_chart", data.chart_water_daily, params);
			}
		});
	};

	function get_today(){
		
		let data_arr = {};
		data_arr["oper"]   = "get_today";
		data_arr["cmCode"] = comein_code;

		$.ajax({
			url:'0105_action.php',
			type:'post',
			cache:false,
			data:data_arr,
			dataType:'json',
			success: function(data){
				draw_bar_line_chart("today_feed_chart", data.chart_feed, "Y", "N", 12, "hh");
				draw_bar_line_chart("today_water_chart", data.chart_water, "Y", "N", 12, "hh", "#2FB5F0");
			}
		});
	};

	function send_excel_data(title){

		let date_time = get_now_datetime();
		let header = [];
		let json_data = [];

		let target_data = [];

		switch(title){
			case "일령별급이량":
				header = ["날짜", "급이량(kg)"];
				target_data = sensor_chart_data["chart_feed_daily"];
				//json_data = JSON.stringify(sensor_chart_data["chart_feed_daily"]);
				break;

			case "일령별급수량":
				header = ["날짜", "급수량(L)"];
				target_data = sensor_chart_data["chart_water_daily"];
				break;
		}

		for(let idx in target_data){
			let row = target_data[idx];
			let n = 1;
			let data = {};
			for(let key in row){
				data["f" + n] = row[key];
				n++;
			}
			json_data.push(data);
		}

		json_data = JSON.stringify(json_data);

		title = $("#search_form [name=search_list] option:selected").val() + "_" + comein_code + "_" + title;

		window.Android.convert_excel(date_time + "_" + title + ".xls", header, json_data);
	}

	function get_feed_per_count(){
		
		let data_arr = {};
		data_arr["oper"] = "get_feed_per_count";
		data_arr["cmCode"] = comein_code;		//등록코드
		
		$.ajax({
			url:'0105_action.php',
			data:data_arr,
			cache:false,
			type:'post',
			dataType:'json',
			success: function(data){

				$("#dong_per_feed").html(data.dong_per_feed + "g");
				$("#dong_per_water").html(data.dong_per_water + "L");
			},
			error: function(request,status,error){
				//alert("STATUS : "+request.status+"\n"+"ERROR : "+error);
			}
		});
	};

</script>