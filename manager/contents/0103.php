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

<style>
#cameraIcon {
	position:absolute;
	max-width:100%; max-height:100%;
	width:auto; height:auto;
	margin:auto;
	top:0; bottom:0; left:0; right:0;
}
</style>

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

<!--실시간 평균-->
<div class="row" id="row_summary" >
	<div class="col-xs-12">
		<div class="jarviswidget jarviswidget-color-white no-padding mb-3" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
			<header style="border-radius: 10px 10px 0px 0px; border : 4px solid #eee; border-bottom: 0; background-color: #0c6ad0;">
				<div class="widget-header" style="max-width: 100%;">	
					<h2 class="font-weight-bold text-white avg"><i class="fa fa-clock-o"></i>&nbsp;실시간 평균&nbsp;
						<span class="font-sm badge bg-orange">입추 <span id="summary_indate"> - </span> </span>
						<span class="font-sm badge bg-orange"><span id="summary_intype"></span><span id="summary_insu"></span></span>
					</h2>	
				</div>
			</header>
			<div class="widget-body p-1" style="border-radius: 0px 0px 10px 10px; border : 4px solid #eee; border-top: 0;">
				<div class="col-xs-3 float-left text-center px-1 pt-4">
					<img class="img-reponsive henImage">
					<div class="carousel-caption henInterm"><span class="font-weight-bold" style="font-size: 25px"> <span id="summary_interm"></span>일 </span></div>
				</div>
				<div class="col-xs-6 text-center no-padding" style="margin-top: 7%">
					<span class="font-weight-bold text-danger" style="font-size: 17px">실시간 평균중량</span><br>
					<span class="font-weight-bold text-danger" style="margin-top: 20%; font-size: 47px" id="summary_avg_weight">-</span>
					<!-- <span class="font-weight-bold text-secondary" style="font-size:15px;">입추일<br><span id="summary_indate"> - </span></span> -->
				</div>
				<div class="col-xs-3 float-right text-center p-1" style="margin-top: 5%">
					<span class="font-weight-bold text-secondary" style="font-size: 18px">표준편차<br><span id="summary_devi"></span></span><br>
					<span class="font-weight-bold text-secondary" style="font-size: 18px">변이계수<br><span id="summary_vc"></span></span>
				</div>
				<div class="col-xs-12 d-flex flex-row justify-content-around no-padding">
					<div class="col-xs-4 p-2 text-center"><span class="text-secondary" style="font-size: 18px;">최소평체</span><br><span style="font-size: 23px" id="summary_min_avg_weight">-</span></div>
					<div class="col-xs-4 p-2 text-center"><span class="text-secondary" style="font-size: 18px;">현재평체</span><br><span style="font-size: 23px" id="summary_curr_avg_weight">-</span></div>
					<div class="col-xs-4 p-2 text-center"><span class="text-secondary" style="font-size: 18px;">최대평체</span><br><span style="font-size: 23px" id="summary_max_abg_weight">-</span></div>
				</div>
			</div>	
		</div>
	</div>
</div>

<!--예측평체-->
<div class="row" id="row_avg_esti">
	<div class="col-xs-12">
		<div class="jarviswidget jarviswidget-color-white no-padding mb-3" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">							
			<header style="border-radius: 10px 10px 0px 0px; border : 4px solid #eee; border-bottom: 0; background-color: #0c6ad0;">
				<div class="widget-header">	
					<h2 class="font-weight-bold text-white"><i class="fa fa-calendar"></i>&nbsp;예측평체&nbsp;
					<span class="font-sm badge bg-orange">16일령 이후 표시</span>
				</h2>	
				</div>
			</header>
			<div class="widget-body p-2" style="border-radius: 0px 0px 10px 10px; border : 4px solid #eee; border-top: 0;">
				<div class="d-flex flex-row justify-content-around">
					<div class="col-xs-4 p-2 text-center border-right"><span style="font-size: 14px;"><span id="summary_date_term1"></span>(<span id="summary_day_term1"></span>)</span><p><span style="font-size: 27px;" class="text-secondary" id="summary_day_1"></span></p><span style="font-size: 13px;" id="summary_day_inc1"></span></div>
					<div class="col-xs-4 p-2 text-center border-right"><span style="font-size: 14px;"><span id="summary_date_term2"></span>(<span id="summary_day_term2"></span>)</span><p><span style="font-size: 27px;" class="text-secondary" id="summary_day_2"></span></p><i class="fa fa-plus text-green"></i>&nbsp;&nbsp;<span style="font-size: 13px;" id="summary_day_inc2"></span></div>
					<div class="col-xs-4 p-2 text-center"><span style="font-size: 14px;"><span id="summary_date_term3"></span>(<span id="summary_day_term3"></span>)</span><p><span style="font-size: 27px;" class="text-secondary" id="summary_day_3"></span></p><i class="fa fa-plus text-info"></i>&nbsp;&nbsp;<span style="font-size: 13px;" id="summary_day_inc3"></span></div>
				</div>
			</div>
		</div>
	</div>
</div>

<!--현재 센서별 평균정보-->	
<div class="row" id="row_cell_avg">
	<div class="col-xs-12">
		<div class="jarviswidget jarviswidget-color-white no-padding mb-3" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">							
			<header style="border-radius: 10px 10px 0px 0px; border : 4px solid #eee; border-bottom: 0; background-color: #0c6ad0;">
				<div class="widget-header">	
					<h2 class="font-weight-bold text-white sensor"><i class="fa fa-info-circle"></i>&nbsp;저울 센서별 평균</h2>	
				</div>
			</header>
			<div class="widget-body p-2" style="border-radius: 0px 0px 10px 10px; border : 4px solid #eee; border-top: 0;">
				<div class="col-xs-6 p-2 border-bottom border-right">
					<div class="col-xs-4 no-padding" style="text-align:center"><img src="../images/temp.png" style="height:66px; width:66px;"><br><span></span></div>
					<div class="col-xs-8 no-padding" style="text-align:right"><span style="font-size:15px">온도</span>(℃)<br><span id="summary_avg_temp" style="font-size:27px">-</span></div>
				</div>
				<div class="col-xs-6 p-2 border-bottom">
					<div class="col-xs-4 no-padding" style="text-align:center"><img src="../images/humi.png" style="height:66px; width:66px;"><br><span></span></div>
					<div class="col-xs-8 no-padding" style="text-align:right"><span style="font-size:15px">습도</span>(％)<br><span id="summary_avg_humi" style="font-size:27px">-</span></div>
				</div>
				<div class="col-xs-6 p-2 border-bottom border-right">
					<div class="col-xs-4 no-padding" style="text-align:center"><img src="../images/co2.png" style="height:66px; width:66px;"><br><span></span></div>
					<div class="col-xs-8 no-padding" style="text-align:right"><span style="font-size:13px">이산화탄소</span>(ppm)<br><span id="summary_avg_co2" style="font-size:27px">-</span></div>
				</div>
				<div class="col-xs-6 p-2 border-bottom">
					<div class="col-xs-4 no-padding" style="text-align:center"><img src="../images/nh3.png" style="height:66px; width:66px;"><br><span></span></div>
					<div class="col-xs-8 no-padding" style="text-align:right"><span style="font-size:15px">암모니아</span>(ppm)<br><span id="summary_avg_nh3" style="font-size:27px">-</span></div>
				</div>
				<div class="col-xs-6 p-2 border-right">
					<div class="col-xs-4 no-padding" style="text-align:center"><img src="../images/pm10.png" style="height:66px; width:66px;"><br><span></span></div>
					<div class="col-xs-8 no-padding" style="text-align:right"><span style="font-size:15px">미세먼지</span><br><span id="summary_avg_dust" style="font-size:27px">-</span></div>
				</div>
				<div class="col-xs-6 p-2">
					<div class="col-xs-4 no-padding" style="text-align:center"><img src="../images/lux.png" style="height:66px; width:66px;"><br><span></span></div>
					<div class="col-xs-8 no-padding" style="text-align:right"><span style="font-size:15px">조도</span>(lux)<br><span id="summary_avg_light" style="font-size:27px">-</span></div>
				</div>
			</div>
		</div>
	</div>
</div>

<!--일일 급이 / 급수량-->
<div class="row" id="row_feed_water">
	<div class="col-xs-12">
		<div class="jarviswidget jarviswidget-color-white no-padding mb-3" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">							
			<header style="border-radius: 10px 10px 0px 0px; border : 4px solid #eee; border-bottom: 0; background-color: #0c6ad0;">
				<div class="widget-header">	
					<h2 class="font-weight-bold text-white feeder"><i class="fa fa-info-circle"></i>&nbsp;급이 및 급수</h2>	
				</div>
				<div class="widget-toolbar ml-auto">
					<div class="btn-group">
						<button type="button" class="btn btn-xs btn-light text-primary btn_display_toggle" style="height: 25px">&nbsp;<i class="fa fa-minus"></i>&nbsp;</button>
					</div>
				</div>
			</header>
			<div class="widget-body pt-3" style="border-radius: 0px 0px 10px 10px; border : 4px solid #eee; border-top: 0; padding:1rem;">
				<div class="col-xs-12 d-flex align-items-center justify-content-between no-padding">
					<div class="col-xs-6 no-padding text-center">
						<span class="font-md text-secondary">수 당 급이량 <br><span class="font-md text-danger font-weight-bold" id="dong_per_feed"></span></span>
					</div>
					<div class="col-xs-6 no-padding text-center">
						<span class="font-md text-secondary">수 당 급수량 <br><span class="font-md text-primary font-weight-bold" id="dong_per_water"></span></span>
					</div>
				</div>

				<div style="clear:both"></div><hr style="margin-top:10px; margin-bottom: 10px">

				<div class="col-xs-4 no-padding" style="margin-bottom: 15px">
					<div class="col-xs-12 text-center no-padding"><img id="feed_img" src="../images/feed-00.png" style="width: 7rem;"><br>
						<div class="carousel-caption"><h3 class="font-weight-bold m-0 pb-3 text-secondary" id="extra_feed_percent">-%</h3></div>
					</div>
					<div class="col-xs-12 text-center no-padding"><span>사료잔량 <span id="extra_feed_remain">-</span>(Kg)</span></div>
				</div>
				<div class="col-xs-4 no-padding" style="margin-top: 25px">
					<div class="col-xs-12 no-padding text-right"><span style="font-size:15px">오늘 급이량</span>(Kg)<br><span id="extra_curr_feed" style="font-size:28px">-</span></div>
				</div>
				<div class="col-xs-4 no-padding" style="margin-top: 25px">
					<div class="col-xs-12 no-padding text-right"><span style="font-size:15px">전일 급이량</span>(Kg)<br><span id="extra_prev_feed" style="font-size:28px">-</span></div>
				</div>
				<div style="clear:both"></div><hr style="margin-top:0px">
				<div class="col-xs-4 no-padding" style="margin-top: 5px">
					<div class="col-xs-12 text-center"><img src="../images/water-02.png" style="width: 6rem;"><br><span></span></div>
					<div class="col-xs-12 text-center no-padding"><span>시간당 급수량 <span id="extra_water_per_hour">-</span>(L)</span></div>
				</div>
				<div class="col-xs-4 no-padding" style="margin-top: 15px">
					<div class="col-xs-12 no-padding text-right"><span style="font-size:15px">오늘 급수량</span>(L)<br><span id="extra_curr_water" style="font-size:28px">-</span></div>
				</div>
				<div class="col-xs-4 no-padding" style="margin-top: 15px">
					<div class="col-xs-12 no-padding text-right"><span style="font-size:15px">전일 급수량</span>(L)<br><span id="extra_prev_water" style="font-size:28px">-</span></div>
				</div>
			</div>
		</div>
	</div>
</div>

<!--현재 외기환경 센서 정보-->
<div class="row" id="row_outsensor">
	<div class="col-xs-12">
		<div class="jarviswidget jarviswidget-color-white no-padding mb-3" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">							
			<header style="border-radius: 10px 10px 0px 0px; border : 4px solid #eee; border-bottom: 0; background-color: #0c6ad0;">
				<div class="widget-header">	
					<h2 class="font-weight-bold text-white sensor"><i class="fa fa-info-circle"></i>&nbsp;외기환경 센서</h2>	
				</div>
				<div class="widget-toolbar ml-auto">
					<div class="btn-group">
						<button type="button" class="btn btn-xs btn-light text-primary btn_display_toggle" style="height: 25px">&nbsp;<i class="fa fa-minus"></i>&nbsp;</button>
					</div>
				</div>
			</header>
			<div class="widget-body p-2" style="border-radius: 0px 0px 10px 10px; border : 4px solid #eee; border-top: 0; display: none;">
				<div class="col-xs-6 p-2 border-bottom border-right">
					<div class="col-xs-4 no-padding text-center text-danger"><img src="../images/temp.png"><br><span></span></div>
					<div class="col-xs-8 no-padding text-right"><span style="font-size:15px">온도</span>(℃)<br><span id="extra_out_temp" style="font-size:28px">-</span></div>
				</div>
				<div class="col-xs-6 p-2 border-bottom">
					<div class="col-xs-4 no-padding text-center"><img src="../images/humi.png"><br><span></span></div>
					<div class="col-xs-8 no-padding text-right"><span style="font-size:15px">습도</span>(％)<br><span id="extra_out_humi" style="font-size:28px">-</span></div>
				</div>
				<div class="col-xs-6 p-2 border-bottom border-right">
					<div class="col-xs-4 no-padding text-center"><img src="../images/nh3.png"><br><span></span></div>
					<div class="col-xs-8 no-padding text-right"><span style="font-size:15px">암모니아</span>(ppm)<br><span id="extra_out_nh3" style="font-size:28px">-</span></div>
				</div>
				<div class="col-xs-6 p-2 border-bottom">
					<div class="col-xs-4 no-padding text-center"><img src="../images/h2s.png"><br><span></span></div>
					<div class="col-xs-8 no-padding text-right"><span style="font-size:15px">황화수소</span>(ppm)<br><span id="extra_out_h2s" style="font-size:28px">-</span></div>
				</div>
				<div class="col-xs-6 p-2 border-bottom border-right">
					<div class="col-xs-4 no-padding text-center"><img src="../images/pm10.png"><br><span></span></div>
					<div class="col-xs-8 no-padding text-right"><span style="font-size:15px">미세먼지</span><br><span id="extra_out_dust" style="font-size:28px">-</span></div>
				</div>
				<div class="col-xs-6 p-2 border-bottom">
					<div class="col-xs-4 no-padding text-center"><img src="../images/pm2.5.png"><br><span></span></div>
					<div class="col-xs-8 no-padding text-right"><span style="font-size:15px">초미세먼지</span><br><span id="extra_out_udust" style="font-size:28px">-</span></div>
				</div>
				<div class="col-xs-6 p-2 border-right border-bottom">
					<div class="col-xs-4 no-padding text-center"><img src="../images/wind-direction.png"><br><span></span></div>
					<div class="col-xs-8 no-padding text-right"><span style="font-size:15px">풍향</span><br><span id="extra_out_direction" style="font-size:25px">-</span></div>
				</div>
				<div class="col-xs-6 p-2 border-bottom">
					<div class="col-xs-4 no-padding text-center"><img src="../images/wind.png"><br><span></span></div>
					<div class="col-xs-8 no-padding text-right"><span style="font-size:15px">풍속</span>(m/s)<br><span id="extra_out_wind" style="font-size:28px">-</span></div>
				</div>
				<div class="col-xs-6 p-2 border-right">
					<div class="col-xs-4 no-padding text-center"><img src="../images/solar.png"><br><span></span></div>
					<div class="col-xs-8 no-padding text-right"><span style="font-size:15px">일사량</span>(W/㎡)<br><span id="extra_out_solar" style="font-size:28px">-</span></div>
				</div>
			</div>
		</div>
	</div>
</div>

<!--IP 카메라-->
<div class="row" id="row_camera_view" >
	<div class="col-xs-12">
		<div class="jarviswidget jarviswidget-color-white no-padding mb-3" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">							
			<header style="border-radius: 10px 10px 0px 0px; border : 4px solid #eee; border-bottom: 0; background-color: #0c6ad0;">
				<div class="widget-header">	
					<h2 class="font-weight-bold text-white"><i class="fa fa-camera"></i>&nbsp;IP 카메라</h2>	
				</div>
			</header>
			<div class="widget-body" style="border-radius: 0px 0px 10px 10px; border : 4px solid #eee; border-top: 0; padding:1rem" id="camera_zone">

			</div>
		</div>
	</div>
</div>

<?
include_once("../inc/bottom.php")
?>

<script language="javascript">

	var comein_code = "";
	var list_combo = "";

	$(document).ready(function(){

		$(".btn_display_toggle").off("click").on("click", function(){

			//$(this).children("i").toggleClass("fa-minus").toggleClass("fa-plus");
			$(this).parents(".jarviswidget").children(".widget-body").toggle();
		});

		list_combo = <?=$list_combo?>;

		// 입출하 콤보박스 설정
		let cookie_inout = get_cookie("inout");

		if("<?=$inout?>" == "" && cookie_inout != null){
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
		else{
			set_cookie("inout", "<?=$inout?>", 1);
		}

		// 선택된 동 콤보박스 설정
		let cookie_code = get_cookie("code");
		if("<?=$code?>" == "" && cookie_code != null){
			comein_code = cookie_code;
			$("#search_form [name=search_list]").val(get_cookie("name"));
		}
		else{
			comein_code = $("#search_form [name=search_list] option:selected").attr("comein_code");
			let name = $("#search_form [name=search_list] option:selected").val();
			set_cookie("code", comein_code, 1);
			set_cookie("name", name, 1);
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
		
		let data_arr = {};
		data_arr["oper"] = "get_buffer";	//등록코드
		data_arr["cmCode"] = comein_code;	//등록코드
		
		$.ajax({
			url:'0103_action.php',
			data:data_arr,
			cache:false,
			type:'post',
			dataType:'json',
			success: function(data){

				// $("#row_feed_water").hide();
				// $("#row_outsensor").hide();
				let status = data.summary.summary_status;

				if(status != "O"){

					$("#row_summary").show();
					$("#row_avg_esti").show();
					$("#row_cell_avg").show();

					//일령
					let interm = data.summary.summary_interm;

					//일령기간별 이미지
					// if(interm <= 10){ $(".henImage").attr("src","../images/hen-scale1.png");  $(".henInterm").addClass("p-4");}
					// if(interm >= 11 && interm <= 20){ $(".henImage").attr("src","../images/hen-scale2.png");  $(".henInterm").addClass("p-2");}
					// if(interm >= 21){ $(".henImage").attr("src","../images/hen-scale3.png"); $(".henInterm").addClass("p-2"); }
					if(interm <= 10){ $(".henImage").attr("src","../images/hen-scale1.png");}
					if(interm >= 11 && interm <= 20){ $(".henImage").attr("src","../images/hen-scale2.png");}
					if(interm >= 21){ $(".henImage").attr("src","../images/hen-scale3.png");}

					//각 요약정보[summary]
					$.each(data.summary, function(key, val){	$("#" + key).html(val); });

					//어제평균중량 산출 시간 표현
					let prev_date = data.summary.summary_day_inc1;
					prev_date = prev_date.length > 15 ? "기준 " + prev_date.substr(11, 2) + "시 " + prev_date.substr(14, 2) + "분" : "-";
					$("#summary_day_inc1").html(prev_date);

					// 급이, 급수, 외기 창 표시할지 선택
					$.each(data.extra, function(key, val){	$("#" + key).html(val); });
					if(data.extra.hasOwnProperty("extra_curr_feed")){
						
						let per = data.extra.extra_feed_percent;
						per = parseInt(per);
						if(per <= 10){ 				document.getElementById("feed_img").setAttribute("src", "../images/feed-00.png"); }
						if(per > 10 && per <= 35){ 	document.getElementById("feed_img").setAttribute("src", "../images/feed-01.png"); }
						if(per > 35 && per <= 65){ 	document.getElementById("feed_img").setAttribute("src", "../images/feed-02.png"); }
						if(per > 65 && per <= 90){ 	document.getElementById("feed_img").setAttribute("src", "../images/feed-03.png"); }
						if(per > 90){ 				document.getElementById("feed_img").setAttribute("src", "../images/feed-04.png"); }

						//$("#row_feed_water").show();
						//$("#row_feed_water").find(".btn_display_toggle").children("i").removeClass("fa-plus").addClass("fa-minus");
						$("#row_feed_water").find(".widget-body").show();
					}
					if(data.extra.hasOwnProperty("extra_out_temp")){
						//$("#row_outsensor").show();

						//$("#row_outsensor").find(".btn_display_toggle").children("i").removeClass("fa-plus").addClass("fa-minus");
						$("#row_outsensor").find(".widget-body").show();
					}

				}
				else{
					$("#row_summary").hide();
					$("#row_avg_esti").hide();
					$("#row_cell_avg").hide();
					$("#row_feed_water").hide();
					$("#row_outsensor").hide();

					$("#top_status_info").removeClass('d-none');
					$("#top_status_msg").html("<h3 class='font-weight-bold text-center text-secondary no-margin'>현재 <span class='text-danger'>'출하 상태'</span>입니다</h3>").show();
					$("#top_time_info").html("<i class='fa fa-clock-o text-secondary'></i> 최종 출하 시간 : ");
					$("#top_last_time").html(data.summary.summary_avg_time);
					$("#top_avg_info").html("<i class='fa fa-database text-secondary'></i> 최종 평균 중량 : ");
					$("#top_last_avg").html(data.summary.summary_avg_weight + "g");
				}
				
				//카메라
				$("#camera_zone").html(data.camera_zone);

			},
			error: function(request,status,error){
				//alert("STATUS : "+request.status+"\n"+"ERROR : "+error);
			}
		});

		get_feed_per_count();
	}

	function get_feed_per_count(){
		
		let data_arr = {};
		data_arr["oper"] = "get_feed_per_count";
		data_arr["cmCode"] = comein_code;		//등록코드
		
		$.ajax({
			url:'0103_action.php',
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