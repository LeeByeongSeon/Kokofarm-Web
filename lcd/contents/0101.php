<?
	include_once("../inc/top.php");
?>

<!--1일차/2일차/3일자 중량-->
<div class="row" id="row_avg_esti" style="margin-top:-25px">
	<div class="col-sm-12 no-padding">
		<div class="jarviswidget jarviswidget-color-white" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-togglebutton="false">
			<header style="border-radius: 15px 15px 0px 0px; border : 4px solid #E6E6E6; border-bottom: 0; background-image: url(../images/bgcolor.png); background-repeat: no-repeat; background-size: cover">
				<h2 class="text-white font-weight-bold">예측평체</h2>
			</header>
			<div class="widget-body p-2" style="border-radius: 0px 0px 15px 15px; border : 4px solid #E6E6E6; border-top: 0;">
				<div class="row">
					<div class="col-sm-4">
						<div class="alert alert-secondary text-center mb-3 font-lg" style="border-radius: 10px; border: 0;" role="alert"><span id="summary_date_term1"></span>&nbsp;(<span id="summary_day_term1"></span>)</div>
						<div class="text-center" style="font-size:28px;margin-top:-10px"><span id="summary_day_1">0</span>&nbsp;g</div>
						<div class="text-center" style="font-size:18px;color:gray"> <span id="summary_day_inc1">0</span></div>
					</div>
					<div class="col-sm-4" style="border-left:1px solid #EEEEEE;border-right:1px solid #EEEEEE">
						<div class="alert alert-primary text-center mb-3 font-lg" style="border-radius: 10px; border: 0;" role="alert"><span id="summary_date_term2"></span>&nbsp;(<span id="summary_day_term2"></span>)</div>
						<div class="text-center" style="font-size:28px;margin-top:-10px"><span id="summary_day_2">0</span>&nbsp;g</div>
						<div class="text-center" style="font-size:18px;color:gray"><span class="widget-icon"> <i class="fa fa-plus text-primary"></i> </span> <span id="summary_day_inc2">0</span></div>
					</div>
					<div class="col-sm-4">
						<div class="alert alert-info text-center mb-3 font-lg" style="border-radius: 10px; border: 0;" role="alert"><span id="summary_date_term3"></span>&nbsp;(<span id="summary_day_term3"></span>)</div>
						<div class="text-center" style="font-size:28px;margin-top:-10px"><span id="summary_day_3">0</span>&nbsp;g</div>
						<div class="text-center" style="font-size:18px;color:gray"><span class="widget-icon"> <i class="fa fa-plus text-primary"></i> </span> <span id="summary_day_inc3">0</span></div>
					</div>
				</div><!--row-->

			</div><!--widget-body-->
		</div><!--widget-->
	</div><!--col-xs-12-->
</div><!--row-->

<!--현재센서 평균정보-->
<div class="row" id="row_cell_avg" style="margin-top:-25px">
	<div class="col-sm-12 no-padding">
		<div class="jarviswidget jarviswidget-color-white" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-togglebutton="false">
			<header style="border-radius: 15px 15px 0px 0px; border : 4px solid #E6E6E6; border-bottom: 0; background-image: url(../images/bgcolor.png); background-repeat: no-repeat; background-size: cover">
				<h2 class="text-white font-weight-bold">환경센서 평균정보</h2>
			</header>
			<div class="widget-body" style="border-radius: 0px 0px 15px 15px; border : 4px solid #E6E6E6; border-top: 0; min-height:0;">
				<div class="row">
					<div class="col-sm-3" style="border-right:1px solid #C2C2C2">
						<div class="col-sm-4 no-padding text-center"><img src="../images/temp.png"><br><span id="curr_avg_temp_alert"></span></div>
						<div class="col-sm-8 no-padding text-right"><span style="font-size:18px">온도</span><br><span id="summary_avg_temp" style="font-size:28px">0</span>(℃)</div>
					</div>
					<div class="col-sm-3" style="border-right:1px solid #C2C2C2">
						<div class="col-sm-4 no-padding text-center"><img src="../images/drop.png"><br><span id="curr_avg_humi_alert"></span></div>
						<div class="col-sm-8 no-padding text-right"><span style="font-size:18px">습도</span><br><span id="summary_avg_humi" style="font-size:28px">0</span>(％)</div>
					</div>
					<div class="col-sm-3" style="border-right:1px solid #C2C2C2">
						<div class="col-sm-4 no-padding text-center"><img src="../images/co2.png"><br><span id="curr_avg_co2_alert"></span></div>
						<div class="col-sm-8 no-padding text-right"><span style="font-size:18px">이산화탄소</span><br><span id="summary_avg_co2" style="font-size:28px">0</span>(ppm)</div>
					</div>
					<div class="col-sm-3">
						<div class="col-sm-4 no-padding text-center"><img src="../images/nh3.png"><br><span id="curr_avg_nh3_alert"></span></div>
						<div class="col-sm-8 no-padding text-right"><span style="font-size:18px">암모니아</span><br><span id="summary_avg_nh3" style="font-size:28px">0</span>(ppm)</div>
					</div>
				</div><!--row-->

			</div><!--widget-body-->
		</div><!--widget-->
	</div><!--col-sm-12-->
</div><!--row-->

<!--일일 급이 / 급수량-->
<div class="row" id="row_feed_water">
	<div class="col-sm-12 no-padding" style="margin-top:-25px;">
		<div class="jarviswidget jarviswidget-color-white no-padding" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">							
			<header style="border-radius: 15px 15px 0px 0px; border : 4px solid #E6E6E6; border-bottom: 0; background-image: url(../images/bgcolor.png); background-repeat: no-repeat; background-size: cover">
				<div class="widget-header">	
					<h2 class="font-weight-bold text-white feeder">급이 및 급수 정보</h2>	
				</div>
			</header>
			<div class="widget-body pt-3" style="border-radius: 0px 0px 15px 15px; border : 4px solid #E6E6E6; border-top: 0; min-height:0;">

				<div class="col-sm-3 no-padding text-center" style="border-right:1px solid #C2C2C2">
					<span class="font-md text-secondary">표준 FCR <br><span class="font-md font-weight-bold" id="total_fcr"></span></span>
				</div>
				<div class="col-sm-3 no-padding text-center" style="border-right:1px solid #C2C2C2">
					<span class="font-md text-secondary">FCR 기반 중량 <br><span class="font-md text-danger font-weight-bold" id="total_fcr_weight"></span></span>
				</div>
				<div class="col-sm-3 no-padding text-center" style="border-right:1px solid #C2C2C2">
					<span class="font-md text-secondary">수 당 급이량 <br><span class="font-md font-weight-bold" id="dong_per_feed"></span></span>
				</div>
				<div class="col-sm-3 no-padding text-center">
					<span class="font-md text-secondary">수 당 급수량 <br><span class="font-md text-primary font-weight-bold" id="dong_per_water"></span></span>
				</div>
				

				<div style="clear:both"></div><hr style="margin-top:10px; margin-bottom: 10px">

				<div class="col-sm-2 no-padding">
					<div class="col-sm-12 text-center"><img id="feed_img" src="../images/feed-04.png" style="width: 8rem;"><br>
						<div class="carousel-caption" style="text-shadow: none;"><h3 class="font-weight-bold m-0 pb-3 text-secondary" id="extra_feed_percent">-%</h3></div>
					</div>
					<div class="col-sm-12 text-center no-padding"><span>사료잔량 <span id="extra_feed_remain">-</span>(Kg)</span></div>
				</div>
				<div class="col-sm-2 no-padding">
					<div class="col-sm-12 text-right"><span style="font-size: 15px">오늘<br>급이량(㎏)</span><br><span id="extra_curr_feed" style="font-size:28px">-</span></div>
				</div>
				<div class="col-sm-2 no-padding" style="border-right:1px solid #C2C2C2">
					<div class="col-sm-12 text-right"><span style="font-size: 15px">전일<br>급이량(㎏)</span><br><span id="extra_prev_feed" style="font-size:28px">-</span></div>
				</div>
				<div class="col-sm-2 no-padding" style="margin-top: 2px">
					<div class="col-sm-12 text-center"><img src="../images/water-02.png" style="width: 6rem;"><br><span></span></div>
					<div class="col-sm-12 text-center no-padding"><span>시간당 급수량 <span id="extra_water_per_hour">-</span>(L)</span></div>
				</div>
				<div class="col-sm-2 no-padding">
					<div class="col-sm-12 text-right"><span style="font-size: 15px">오늘<br>급수량(L)</span><br><span id="extra_curr_water" style="font-size:28px">-</span></div>
				</div>
				<div class="col-sm-2 no-padding">
					<div class="col-sm-12 text-right"><span style="font-size: 15px">전일<br>급수량(L)</span><br><span id="extra_prev_water" style="font-size:28px">-</span></div>
				</div>
			</div>
		</div>
	</div>
</div>

<!--현재 외기환경 센서 정보-->
<div class="row" id="row_outsensor" style="margin-top: -25px; display: none;">
	<div class="col-sm-12 no-padding">
		<div class="jarviswidget jarviswidget-color-white no-padding" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">							
			<header style="border-radius: 15px 15px 0 0; border : 4px solid #E6E6E6; border-bottom: 0; background-image: url(../images/bgcolor.png); background-repeat: no-repeat; background-size: cover">
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

<!--1번/2번/3번 저울 , 급이/급수 있으면 급이/급수 보이게--->
<div class="row" id="row_cell_data" style="margin-top:-25px;">
	<div class="col-sm-12 no-padding">
		<div class="jarviswidget jarviswidget-color-light" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-togglebutton="false">
			<header style="border-radius: 15px 15px 0px 0px; border : 4px solid #E6E6E6; border-bottom: 0; background-image: url(../images/bgcolor.png); background-repeat: no-repeat; background-size: cover">
				<h2 class="text-white font-weight-bold">현재 센서상태</h2>
			</header>
			<div class="widget-body p-1" style="border-radius: 0px 0px 15px 15px; border : 4px solid #E6E6E6; border-top: 0;">
				<div class="row">
					<div class="col-sm-12">
						<table id="cell_status_table" data-page-list="[]" data-pagination="false" data-page-list="false" data-page-size="10" data-toggle="table" style="font-size:18px">
							<thead>
								<tr>
									<th data-field='f1' data-visible="true">저울</th>
									<th data-field='f2' data-visible="true">중량</th>
									<th data-field='f3' data-visible="true">온도</th>
									<th data-field='f4' data-visible="true">습도</th>
									<th data-field='f5' data-visible="true">CO2</th>
									<th data-field='f6' data-visible="true">NH3</th>
								</tr>
							</thead>
						</table>
					</div><!--col-xs-12-->
				</div><!--row-->
			</div><!--widget-body-->
		</div><!--widget-->
	</div><!--col-xs-12-->
</div><!--row-->

<!--평균중량 변화추이 Chart 외기 있으면 외기-->
<div class="row" id="row_avg_weight" style="margin-top:-25px;">
	<div class="col-sm-12 no-padding">
		<div class="jarviswidget jarviswidget-color-blueDark" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-togglebutton="false">
			<header style="border-radius: 15px 15px 0 0; border : 4px solid #E6E6E6; border-bottom: 0; background-image: url(../images/bgcolor.png); background-repeat: no-repeat; background-size: cover">
				<h2 class="text-white font-weight-bold">일령별 평균중량 변화추이</h2>
			</header>
			<div class="widget-body" style="border-radius: 0 0 10px 10px; border : 4px solid #E6E6E6; border-top: 0;">
				<div id="avg_weight_chart" style="height:300px; width : 100%;"></div>
			</div><!--widget-body-->
		</div><!--widget-->
	</div>
</div>

<!--IP 카메라-->
<!-- <div class="row" id="row_camera_view" style="margin-top:-25px;">
	<div class="col-sm-12 no-padding">
		<div class="jarviswidget jarviswidget-color-blueDark" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-togglebutton="false">
			<header style="border-radius: 15px 15px 0 0; border : 4px solid #E6E6E6; border-bottom: 0; background-image: url(../images/bgcolor.png); background-repeat: no-repeat">
				<h2 class="font-weight-bold text-white"><i class="fa fa-camera"></i>&nbsp;IP 카메라</h2>	
			</header>
			<div class="widget-body" style="border-radius: 0px 0px 10px 10px; border : 4px solid #E6E6E6; border-top: 0;" id="camera_zone">

			</div>
		</div>
	</div>
</div> -->

<?
	include_once("../inc/bottom.php");
?>

<script language="javascript">

	function get_data(){

		let data_arr = {};
		data_arr["oper"] = "get_buffer"; 
		data_arr["cmCode"] = top_code;	 //등록코드
		
		$.ajax({
			url:'0101_action.php',
			data:data_arr,
			cache:false,
			type:'post',
			dataType:'json',
			success: function(data){

				$("#row_feed_water").hide(); // 급이급수
				$("#row_outsensor").hide();  // 외기환경

				if(top_be_status != "O"){	// 출하가 아닌 경우

					get_cell_data();

					//각 요약정보[summary]
					$.each(data.summary, function(key, val){	$("#" + key).html(val); });

					//어제평균중량 산출 시간 표현
					let prev_date = data.summary.summary_day_inc1;
					prev_date = prev_date.length > 15 ? "기준 " + prev_date.substr(11, 2) + "시 " + prev_date.substr(14, 2) + "분" : "-";
					$("#summary_day_inc1").html(prev_date);

					// 급이/급수 데이터가 있으면 [1,2,3 저울 데이터 hide] [급이/급수 show]
					$.each(data.extra, function(key, val){	$("#" + key).html(val); });
					if(data.extra.hasOwnProperty("extra_curr_feed")){

						get_feed_per_count();
						
						let per = data.extra.extra_feed_percent;
						per = parseInt(per);
						if(per <= 10){ 				document.getElementById("feed_img").setAttribute("src", "../images/feed-00.png"); }
						if(per > 10 && per <= 35){ 	document.getElementById("feed_img").setAttribute("src", "../images/feed-01.png"); }
						if(per > 35 && per <= 65){ 	document.getElementById("feed_img").setAttribute("src", "../images/feed-02.png"); }
						if(per > 65 && per <= 90){ 	document.getElementById("feed_img").setAttribute("src", "../images/feed-03.png"); }
						if(per > 90){ 				document.getElementById("feed_img").setAttribute("src", "../images/feed-04.png"); }

						$("#row_feed_water").show(); // 급이급수
						$("#row_avg_weight").hide();
						//$("#row_cell_data").hide();  // 1,2,3 저울 데이터
					}
					else{
						get_avg_data();
					}

					// 외기환경데이터가 있으면 [평균중량 변화추이 hide] [외기환경 show]
					if(data.extra.hasOwnProperty("extra_out_temp")){
						$("#row_outsensor").show();  // 외기환경
						$("#row_avg_weight").hide(); // 평균중량
					}

				}
				else{
					$("#row_avg_esti").hide(); // 예측평체
					$("#row_cell_avg").hide(); // 환경센서
					$("#row_cell_data").hide();
					$("#row_avg_weight").hide(); // 평균중량
				}

				//카메라
				//$("#camera_zone").html(data.camera_zone);

			},
			error: function(request,status,error){
				//alert("STATUS : "+request.status+"\n"+"ERROR : "+error);
			}
		});
	};

	// 현재 저울 상태
	function get_cell_data(){

		let data_arr = {};
			data_arr['oper'] = "get_cell_status";
			data_arr['cmCode'] = top_code;

		$.ajax({
			url:'0101_action.php',
			data:data_arr,
			cache:false,
			type:'post',
			dataType:'json',
			success: function(data){
				$("#cell_status_table").bootstrapTable('load', data.cell_data);
			}
		});
	};
	
	// 평균중량
	function get_avg_data(){
		
		let data_arr = {}; 
		data_arr['oper']   = "get_avg_weight"
		data_arr["cmCode"] = top_code;	//등록코드
		data_arr['term']   = "day";
		
		$.ajax({
			url:'0101_action.php',
			data:data_arr,
			cache:false,
			type:'post',
			dataType:'json',
			success: function(data) {
				data.avg_weight_chart = convert_amchart_time(data.avg_weight_chart, "일령");
				console.log(data.avg_weight_chart);
				draw_select_chart("avg_weight_chart", data.avg_weight_chart, "영역차트", "Y", "N", 12, "hh");
				//$("#avg_weight_chart").css({ 'height':'300px', 'width':'100%' }); // amChart 'call' 오류 임시제어(?)
			}
		});
	};

	function get_feed_per_count(){
		
		let data_arr = {};
		data_arr["oper"] = "get_feed_per_count";
		data_arr["cmCode"] = top_code;		//등록코드
		
		$.ajax({
			url:'0101_action.php',
			data:data_arr,
			cache:false,
			type:'post',
			dataType:'json',
			success: function(data){

				$("#dong_per_feed").html(data.dong_per_feed + "g");
				$("#dong_per_water").html(data.dong_per_water + "L");

				$("#total_fcr_weight").html(data.total_fcr_weight + "g");
				$("#total_fcr").html(data.total_fcr);

				// $("#fcr_slider").data("ionRangeSlider").update({
				// 	from: data.total_fcr,
				// });
				// set_select_fcr(data.total_fcr);

			},
			error: function(request,status,error){
				//alert("STATUS : "+request.status+"\n"+"ERROR : "+error);
			}
		});
	};

</script>