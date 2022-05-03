<?
include_once("../inc/top.php");

$dong_list_html="";

//onClick='move_dong(\"".$val["fdDongid"]."\")'

foreach($init_data as $val){
	$dong_list_html .= "<div class='row'>";
	$dong_list_html .= "	<div class='col-xs-12'>";
	$dong_list_html .= "		<div class='jarviswidget jarviswidget-color-white no-padding mb-3' data-widget-editbutton='false' data-widget-colorbutton='false' data-widget-deletebutton='false' data-widget-fullscreenbutton='false' data-widget-togglebutton='false'>";
	$dong_list_html .= "			<div class='widget-body no-padding form-inline move_dong' style='border-radius: 10px; border : 4px solid #eee; border-top: 0;' onClick='move_dong(\"".$val["fdDongid"]."\")'>";
	$dong_list_html .= "				<div class='col-xs-2 text-center no-padding'><p><span class='fong-md font-weight-bold' style='font-size:20px'>".$val["fdDongid"]."동</span></p><span id=''>".$val["interm"]."일령</span></div>";
	$dong_list_html .= "				<div class='col-xs-3 text-center no-padding'><p><span class='fong-md font-weight-bold' style='font-size:12px' >평균중량</span></p><span class='font-lg text-danger font-weight-bold'>".sprintf('%0.1f', $val["beAvgWeight"])."g</span></div>";
	//$dong_list_html .= "				<div class='col-xs-1 text-center no-padding'><i class='fa fa-circle text-success'></i></div>";

	if($val["cmOutdate"] != ""){
		$dong_list_html .= "			<div class='col-xs-3 text-center no-padding'>
											<span class='font-lg text-danger font-weight-bold'>출하상태</span>
										</div>";
	}
	// 사료빈 데이터가 있으면
	else if($val["sfDongid"] == ""){
		$dong_list_html .= "			<div class='col-xs-3 text-center no-padding'>
											<p><span class='fong-md font-weight-bold' style='font-size:12px' >평균온도</span></p>
											<span class='font-lg font-weight-bold'>".sprintf('%0.1f', $val["beAvgTemp"])."℃</span>
										</div>";
	}
	else{
		// 사료빈 이미지 넣기
		$dong_list_html .= "				<div class='col-xs-3 text-center no-padding'><img src='";
		if($val["sfFeed"]>0){
			$per = round($val["sfFeed"] / $val["sfFeedMax"] * 100);
		}
		if($per <= 10)						$dong_list_html .= "../images/feed-00.png'";
		else if($per > 10 && $per <= 35)	$dong_list_html .= "../images/feed-01.png'";
		else if($per > 35 && $per <= 65)	$dong_list_html .= "../images/feed-02.png'";
		else if($per > 65 && $per <= 90)	$dong_list_html .= "../images/feed-03.png'";
		else if($per > 90)					$dong_list_html .= "../images/feed-04.png'";
		$dong_list_html .= "' style='width:40px'> <p><span class='fong-md font-weight-bold' style='font-size:12px'>" . $val["sfFeed"] . "(Kg)</span></p> </div>";
	}

	$dong_list_html .= "				<div class='col-xs-1 text-center no-padding'><i class='fa fa-circle text-success'></i></div>";

	$live_count = $val["cmInsu"] - $val["cmDeathCount"] - $val["cmCullCount"] - $val["cmThinoutCount"];

	$dong_list_html .= "				<div class='col-xs-3 text-center no-padding'><p><span class='fong-md font-weight-bold' style='font-size:12px'>생존수 : ".$live_count."</span></p>";
	$dong_list_html .= 					"<button class='btn btn-default move_breed' onClick='move_breed(\"".$val["fdDongid"]."\")' style='border-color:white'><i class='fa fa-pencil-square-o font-lg text-secondary'></i></button></div>"; 
	$dong_list_html .= "</div></div></div></div>";
}

?>

<!--농장 전체 평균-->
<div class='row' id="row_summary" >
	<div class="col-xs-12">
		<div class="jarviswidget jarviswidget-color-white no-padding mb-3" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
			<header style="border-radius: 10px 10px 0px 0px; border : 4px solid #eee; border-bottom: 0; background-color: #0c6ad0;">
				<div class="widget-header" style="max-width: 100%;">
					<h2 class="font-weight-bold text-white avg"><i class="fa fa-home"></i>&nbsp;<span class="font-weight-bold" id="summary_farm_name">농장</span> 현황&nbsp;
						<span class="font-sm badge bg-orange">총 <span id="summary_dong_count"> 0 </span>개 동</span>
					</h2>
				</div>
			</header>
			<div class="widget-body p-1" style="border-radius: 0px 0px 10px 10px; border : 4px solid #eee; border-top: 0;">
				<div class="col-xs-12 d-flex align-items-center pt-3 mb-1">
					<div class="col-xs-3 float-left text-center p-1">
						<span class="font-md text-secondary">최소<br><span class="font-md font-weight-bold" id="summary_min_weight"></span></span>
					</div>
					<div class="col-xs-6 float-center text-center no-padding">
						<span class="font-weight-bold" style="font-size: 20px">전체 평균중량</span><br>
						<span class="font-weight-bold text-danger" style="font-size: 45px" id="summary_farm_weight">-</span>
						<!-- <span class="font-weight-bold text-secondary" style="font-size:15px;">입추일<br><span id="summary_indate"> - </span></span> -->
					</div>
					<div class="col-xs-3 float-right text-center p-1">
						<span class="font-md text-secondary">최대<br><span class="font-md font-weight-bold" id="summary_max_weight"></span></span>
					</div>
				</div>
				<div class="col-xs-12 text-center mb-3">
					<span class="text-secondary font-md">동별 표준 편차&nbsp;<span class="font-weight-bold" id="summary_farm_diff">0</span></span>
				</div>

				<div style="clear:both"></div><hr style="margin-top:10px; margin-bottom: 10px">

				<div class="col-xs-12 text-center mb-3">
					<span class="font-md">총 입추 수 : &nbsp;<span class="font-weight-bold" id="summary_comein_count">0</span></span>
				</div>
				<div class="col-xs-12 text-center d-flex align-items-center mb-3">
					<div class="col-xs-4 no-padding">
						<div class="col-xs-12 no-padding">
							<span class="font-md"><p>생존 수</p><span class="font-md" id="summary_live_count">0</span></span>
						</div>
					</div>
					<div class="col-xs-3 no-padding">
						<div class="col-xs-12 no-padding">
							<span class="font-md"><p>생존율</p><span class="font-md" id="summary_live_percent">99.1%</span></span>
						</div>
					</div>
					<div class="col-xs-5 no-padding">
						<div class="col-xs-12"><span class="font-md float-left">폐사 수&nbsp;<span id="summary_death_count">0</span></span></div>
						<div class="col-xs-12"><span class="font-md float-left">도태 수&nbsp;<span id="summary_cull_count">0</span></span></div>
						<div class="col-xs-12"><span class="font-md float-left">솎기 수&nbsp;<span id="summary_thinout_count">0</span></span></div>
					</div>
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
					<h2 class="font-weight-bold text-white feeder"><i class="fa fa-info-circle"></i>&nbsp;급이량 및 급수량
						<!-- <span class="font-sm badge bg-orange">마리당 급이량 : <span id="total_per_feed"> 0 </span>g</span> -->
					</h2>	
				</div>
				<div class="widget-toolbar ml-auto">
					<div class="btn-group">
						<button type="button" class="btn btn-xs btn-light text-primary btn_display_toggle" style="height: 25px">&nbsp;<i class="fa fa-plus"></i>&nbsp;</button>
					</div>
				</div>
			</header>
			<div class="widget-body p-3 feed_data_body" style="border-radius: 0px 0px 10px 10px; border : 4px solid #eee; border-top: 0; padding:0.5rem;">
				<div class="col-xs-12 d-flex align-items-center justify-content-between no-padding">
					<div class="col-xs-6 no-padding text-center">
						<span class="font-md text-secondary">수 당 급이량 <br><span class="font-md text-danger font-weight-bold" id="total_per_feed"></span></span>
					</div>
					<div class="col-xs-6 no-padding text-center">
						<span class="font-md text-secondary">수 당 급수량 <br><span class="font-md text-primary font-weight-bold" id="total_per_water"></span></span>
					</div>
				</div>

				<div style="clear:both"></div><hr style="margin-top:10px; margin-bottom: 10px">

				<div class="col-xs-12 d-flex align-items-center justify-content-between no-padding">
					<div class="col-xs-3 no-padding text-center">
						<img id="feed_img" src="../images/feed-04.png" style="width: 7rem;"><br>
						<div class="carousel-caption mb-4"><h3 class="font-weight-bold text-secondary" id="summary_feed_percent">-%</h3></div>
						<div class="col-xs-12 text-center no-padding"><span>사료잔량 <span id="summary_feed_remain">-</span>(Kg)</span></div>
					</div>
					<div class="col-xs-3 no-padding text-right">
						<span style="font-size:12px">전체</span>(kg)<br><span id="summary_all_feed" style="font-size:21px">-</span>
					</div>
					<div class="col-xs-3 no-padding text-right">
						<span style="font-size:12px">오늘</span>(kg)<br><span id="summary_curr_feed" style="font-size:21px">-</span>
					</div>
					<div class="col-xs-3 no-padding text-right">
						<span style="font-size:12px">전일</span>(kg)<br><span id="summary_prev_feed" style="font-size:21px">-</span>
					</div>
				</div>

				<div style="clear:both"></div><hr style="margin-top:10px; margin-bottom: 10px">

				<div  class="col-xs-12 d-flex align-items-center justify-content-between no-padding">
					<div class="col-xs-3 no-padding text-center">
						<img src="../images/water-02.png" style="width: 5rem;"><br><span></span>
					<div class="col-xs-12 text-center no-padding"><span>시간당 급수량 <span id="summary_water_per_hour">-</span>(L)</span></div>
					</div>
					<div class="col-xs-3 no-padding text-right">
						<span style="font-size:12px">전체</span>(L)<br><span id="summary_all_water" style="font-size:21px">-</span>
					</div>
					<div class="col-xs-3 no-padding text-right">
						<span style="font-size:12px">오늘</span>(L)<br><span id="summary_curr_water" style="font-size:21px">-</span>
					</div>
					<div class="col-xs-3 no-padding text-right">
						<span style="font-size:12px">전일</span>(L)<br><span id="summary_prev_water" style="font-size:21px">-</span>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?=$dong_list_html?>

<!-- <div class="row" id="">
	<div class="col-xs-12">
		<div class="jarviswidget jarviswidget-color-white no-padding mb-3" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
			<div class="widget-body no-padding form-inline" style="border-radius: 10px; border : 4px solid #eee; border-top: 0;">
				<div class="col-xs-2 text-center"><p><span class="fong-md font-weight-bold" style="font-size:15px">동</span></p><span id="">일령</span></div>
				<div class="col-xs-4 text-center"><span class="font-lg text-danger font-weight-bold">평균체중</span></div>
				<div class="col-xs-1 text-center"><i class='fa fa-circle text-success'></i></div>
				<div class="col-xs-3 text-center"><img src='../images/feed-00.png' style='width:40px'></div>
				<div class="col-xs-2 text-center"><button class='btn btn-default' onClick='set_breed_data()' style='border-color:white'><i class="fa fa-pencil-square-o font-lg text-secondary"></i></button></div>
			</div>
		</div>
	</div>
</div> -->

<!--차트-->
<div class="row">
	<div class="col-xs-12">
		<div class="jarviswidget jarviswidget-color-white no-padding mb-3" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">							
			<header style="border-radius: 10px 10px 0px 0px; border : 4px solid #eee; border-bottom: 0; background-color: #0c6ad0;">
				<div class="widget-header">	
					<h2 class="font-weight-bold text-white"><i class="fa fa-bar-chart-o"></i>&nbsp;동별 평균중량 비교</h2>	
				</div>
				<div class="widget-toolbar ml-auto">
					<div class="btn-group">
						<button type="button" class="btn btn-xs btn-light text-primary btn_display_toggle" style="height: 25px">&nbsp;<i class="fa fa-minus"></i>&nbsp;</button>
					</div>
				</div>
			</header>
			<div class="widget-body no-padding dong_weight_chart" style="border-radius: 0px 0px 10px 10px; border : 4px solid #eee; border-top: 0;">
				<div class="col-xs-12 no-padding">
					<div id="dong_weight_chart" style="height: 260px;"></div>
				</div>
			</div>
		</div>
	</div>
</div>

<!--차트-->
<div class="row">
	<div class="col-xs-12">
		<div class="jarviswidget jarviswidget-color-white no-padding mb-3" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">							
			<header style="border-radius: 10px 10px 0px 0px; border : 4px solid #eee; border-bottom: 0; background-color: #0c6ad0;">
				<div class="widget-header">	
					<h2 class="font-weight-bold text-white"><i class="fa fa-bar-chart-o"></i>&nbsp;동별 급이량 비교</h2>	
				</div>
				<div class="widget-toolbar ml-auto">
					<div class="btn-group">
						<button type="button" class="btn btn-xs btn-light text-primary btn_display_toggle" style="height: 25px">&nbsp;<i class="fa fa-plus"></i>&nbsp;</button>
					</div>
				</div>
			</header>
			<div class="widget-body no-padding dong_feed_chart" style="border-radius: 0px 0px 10px 10px; border : 4px solid #eee; border-top: 0;">
				<div class="col-xs-12 no-padding">
					<div id="dong_feed_chart" style="height: 260px;"></div>
				</div>
			</div>
		</div>
	</div>
</div>

<!--차트-->
<div class="row">
	<div class="col-xs-12">
		<div class="jarviswidget jarviswidget-color-white no-padding mb-3" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">							
			<header style="border-radius: 10px 10px 0px 0px; border : 4px solid #eee; border-bottom: 0; background-color: #0c6ad0;">
				<div class="widget-header">	
					<h2 class="font-weight-bold text-white"><i class="fa fa-bar-chart-o"></i>&nbsp;동별 급수량 비교</h2>	
				</div>
				<div class="widget-toolbar ml-auto">
					<div class="btn-group">
						<button type="button" class="btn btn-xs btn-light text-primary btn_display_toggle" style="height: 25px">&nbsp;<i class="fa fa-plus"></i>&nbsp;</button>
					</div>
				</div>
			</header>
			<div class="widget-body no-padding dong_water_chart" style="border-radius: 0px 0px 10px 10px; border : 4px solid #eee; border-top: 0;">
				<div class="col-xs-12 no-padding">
					<div id="dong_water_chart" style="height: 260px;"></div>
				</div>
			</div>
		</div>
	</div>
</div>

<?
include_once("../inc/bottom.php")
?>

<script language="javascript">

	$(document).ready(function(){

		$("#top_navbar").hide();

		$(".btn_display_toggle").off("click").on("click", function(){
			$(this).children("i").toggleClass("fa-plus").toggleClass("fa-minus");
			$(this).parents(".jarviswidget").children(".widget-body").toggle(function(e){
				if($(this).parents(".jarviswidget").children(".widget-body").css("display") === "none" ){
					$(this).prev("header").css("background", "#A6ACAF");
				} else {
					$(this).prev("header").css("background", "#0c6ad0");
				}
			});
		});
		
		// 동별 이동과 사육일지 이동 클릭이벤트 분리
		$(".move_dong").children().find(".move_breed").click(function(e){
			return false;
		});
	});

	function get_dong_data(){
		
		let data_arr = {};
		data_arr["oper"] = "get_buffer";
		data_arr["cmCode"] = top_code;		//등록코드
		
		$.ajax({
			url:'0000_action.php',
			data:data_arr,
			cache:false,
			type:'post',
			dataType:'json',
			success: function(data){

				//각 요약정보[summary]
				$.each(data.summary, function(key, val){	$("#" + key).html(val); });

				$("#summary_farm_name").html(data.summary.farm_name);
				$("#summary_dong_count").html(data.summary.dong_count);

				let per = data.summary.summary_feed_percent;
				per = parseInt(per);
				if(per <= 10){ 				document.getElementById("feed_img").setAttribute("src", "../images/feed-00.png"); }
				if(per > 10 && per <= 35){ 	document.getElementById("feed_img").setAttribute("src", "../images/feed-01.png"); }
				if(per > 35 && per <= 65){ 	document.getElementById("feed_img").setAttribute("src", "../images/feed-02.png"); }
				if(per > 65 && per <= 90){ 	document.getElementById("feed_img").setAttribute("src", "../images/feed-03.png"); }
				if(per > 90){ 				document.getElementById("feed_img").setAttribute("src", "../images/feed-04.png"); }

				let dong_weight_chart = [];
				let dong_feed_chart = [];
				let dong_water_chart = [];

				let len = data.weight_chart.length;
				for(let i=0; i<len; i++){
					dong_weight_chart[i] = data.weight_chart[len - i - 1];
					dong_feed_chart[i] = data.feed_chart[len - i - 1];
					dong_water_chart[i] = data.water_chart[len - i - 1];

					let feed = data.feed_chart[i]["급이량"];
					let water = data.water_chart[i]["급수량"];
				}

				// 급이 급수 없으면 안보이게
				if(data.set_feeder_id == ""){
					// 급이량 및 급수량
					$(".feed_data_body").css("display", "none").prev("header").css("background", "#A6ACAF");
					
					// 동별 급이량 비교, 급수량 비교
					$(".dong_feed_chart").css("display", "none").prev("header").css("background", "#A6ACAF");
					$(".dong_water_chart").css("display", "none").prev("header").css("background", "#A6ACAF");
				}

				simple_chart("dong_weight_chart", dong_weight_chart, "#6E6E6E");
				simple_chart("dong_feed_chart", dong_feed_chart, "#FF9900");
				simple_chart("dong_water_chart", dong_water_chart, "#2FB5F0");

			},
			error: function(request,status,error){
				//alert("STATUS : "+request.status+"\n"+"ERROR : "+error);
			}
		});

		get_feed_per_count();
	};

	function get_feed_per_count(){
		
		let data_arr = {};
		data_arr["oper"] = "get_feed_per_count";
		data_arr["cmCode"] = top_code;		//등록코드
		
		$.ajax({
			url:'0000_action.php',
			data:data_arr,
			cache:false,
			type:'post',
			dataType:'json',
			success: function(data){
				$("#total_per_feed").html(data.total_per_feed + "g");
				$("#total_per_water").html(data.total_per_water + "L");
			},
			error: function(request,status,error){
				//alert("STATUS : "+request.status+"\n"+"ERROR : "+error);
			}
		});
	};

	function simple_chart(chart_id, chart_data, graph_color){
		if(chart_data.length <= 0){ return false; }

		let graph_json = [];
		let category = "";
		let graph_cnt = -1;

		let font_size = 12;

		for(key in chart_data[0]){
			graph_cnt++;
			if(graph_cnt == 0) { 
				category = key; 
			}
			else{
				let graph_obj = {};
				graph_obj["title"] = key;
				graph_obj["valueField"] = key;
				graph_obj["balloonText"] = "<font style='font-size:" + font_size + "px'><b>[[title]]</b><br>[[[value]]]</font>";	/*마우스 Over Label*/

				// if(is_label === "Y"){
				// 	graph_obj["labelText"]="[[value]]";					/*Bar 상단에 value 출력*/
				// 	graph_obj["bullet"] = "round";						/*꼭지점*/
				// 	graph_obj["bulletSize"] = 4;						/*차트 꼭지점 Size*/
				// 	graph_obj["useLineColorForBulletBorder"] = "true";	/*꼭지점*/
				// }

				graph_obj["lineColor"] = graph_color;
				graph_obj["type"] = "column";					/*차트모양*/
				graph_obj["lineAlpha"] = 1;
				graph_obj["fillAlphas"] = 1;
				graph_obj["lineThickness"] = 0.3;					/*라인굵기*/ // 2022-03-11 라인굵기 수정
				graph_obj["bulletBorderThickness"] = 3;
				graph_obj["labelText"]="[[value]]";					/*Bar 상단에 value 출력*/

				graph_json.push(graph_obj);
			}
		}

		//차트옵션 정하기
		let chart_option = {"type": "serial", "theme": "light", "language":"ko", "marginRight":20, "fontSize":font_size,
							"dataProvider": chart_data, "categoryField":category, "graphs": graph_json,
							"legend":{"bulletType":"round", "valueWidths":"false", "useGraphSettings":true, "color":"black", "align":"center"}
		};

		//차트 그리기
		let chart = AmCharts.makeChart(chart_id, chart_option);
	};

	function move_dong(dong){
		location.href = "0101.php<?=$add_url?>&request_dong=" + dong;
	};

	function move_breed(dong){
		location.href = "0105.php<?=$add_url?>&request_dong=" + dong;
	};

</script>