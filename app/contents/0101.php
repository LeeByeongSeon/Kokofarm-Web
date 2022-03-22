<?
include_once("../inc/top.php");
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
						<button type="button" class="btn btn-xs btn-light text-primary btn_display_toggle" style="height: 25px">&nbsp;<i class="fa fa-plus"></i>&nbsp;</button>
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

	$(document).ready(function(){

		$(".btn_display_toggle").off("click").on("click", function(){

			$(this).children("i").toggleClass("fa-minus").toggleClass("fa-plus");
			$(this).parents(".jarviswidget").children(".widget-body").toggle();
		});
	});

	function get_dong_data(){
		
		let data_arr = {};
		data_arr["oper"] = "get_buffer";	//등록코드
		data_arr["cmCode"] = top_code;	//등록코드
		
		$.ajax({
			url:'0101_action.php',
			data:data_arr,
			cache:false,
			type:'post',
			dataType:'json',
			success: function(data){

				// $("#row_feed_water").hide();
				// $("#row_outsensor").hide();

				if(top_be_status != "O"){

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


				}
				
				//카메라
				$("#camera_zone").html(data.camera_zone);

			},
			error: function(request,status,error){
				//alert("STATUS : "+request.status+"\n"+"ERROR : "+error);
			}
		});
	}

</script>