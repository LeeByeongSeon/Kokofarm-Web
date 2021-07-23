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
		<div class="jarviswidget jarviswidget-color-white no-padding" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
			<header style="border-radius: 10px 10px 0 0">
				<div class="widget-header">	
					<h2 class="font-weight-bold text-primary avg"><i class="fa fa-clock-o text-success"></i>&nbsp;&nbsp;실시간 평균&nbsp;
						<span class="badge badge-primary"> <span id="summary_intype"></span> <span id="summary_insu"></span> </span>
					</h2>	
				</div>
			</header>
			<div class="widget-body shadow" style="border-radius: 0 0 10px 10px; padding:0.5rem">
				<div class="col-xs-4 float-left text-center">
					<img class="p-2 img-reponsive henImage">
					<div class="p-4 carousel-caption"><h1 class="font-weight-bold"> <span id="summary_interm"></span>일 </h1></div>
				</div>
				<div class="col-xs-4">
					<h1 class="font-weight-bold text-danger text-center" style="margin-top: 20%" id="summary_avg_weight"></h1>
					<h5 class="font-weight-bold text-secondary text-center"><small>입추일<br><span id="summary_indate"> - </span></small></h5>
				</div>
				<div class="col-xs-4 float-right">
					<h5 class="font-weight-bold text-secondary text-center"><small>표준편차<br><span id="summary_devi"></span></small></h5>
					<h5 class="font-weight-bold text-secondary text-center"><small>변이계수<br><span id="summary_vc"></span></small></h5>
				</div>
				<div class="col-xs-12 d-flex flex-row justify-content-around no-padding">
					<div class="p-3 text-center"><h4 class="font-weight-bold"><small>최소중량</small><br><span id="summary_min_avg_weight"></span></h4></div>
					<div class="p-3 text-center"><h4 class="font-weight-bold"><small>평균중량</small><br><span id="summary_curr_avg_weight"></span></h4></div>
					<div class="p-3 text-center"><h4 class="font-weight-bold"><small>최대중량</small><br><span id="summary_max_abg_weight"></span></h4></div>
				</div>
			</div>	
		</div>
	</div>
</div>

<!--예측평체-->
<div class="row" id="row_avg_esti">
	<div class="col-xs-12">
		<div class="jarviswidget jarviswidget-color-white no-padding" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">							
			<header style="border-radius: 10px 10px 0 0;">
				<div class="widget-header">	
					<h2 class="font-weight-bold text-primary"><i class="fa fa-calendar text-success"></i>&nbsp;&nbsp;예측평체&nbsp;
					<span class="badge badge-primary">16일령 이후 표시</span>
				</h2>	
				</div>
			</header>
			<div class="widget-body shadow" style="border-radius: 0 0 10px 10px">
				<div class="d-flex flex-row justify-content-around">
					<div class="p-3 text-center"><h4 style="font-weight:bold"><small>어제 <span id="summary_day_term1"></span></small><br><span class="text-secondary" id="summary_day_1"></span><br><small id="summary_day_inc1"></small></h4></div>
					<div class="p-3 text-center"><h4 style="font-weight:bold"><small>내일 <span id="summary_day_term2"></span></small><br><span class="text-success" id="summary_day_2"></span><br><small id="summary_day_inc2"></small></h4></div>
					<div class="p-3 text-center"><h4 style="font-weight:bold"><small>모레 <span id="summary_day_term3"></span></small><br><span class="text-info" id="summary_day_3"></span><br><small id="summary_day_inc3"></small></h4></div>
				</div>
			</div>
		</div>
	</div>
</div>

<!--현재 센서별 평균정보-->	
<div class="row" id="row_cell_avg">
	<div class="col-xs-12">
		<div class="jarviswidget jarviswidget-color-white no-padding" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">							
			<header style="border-radius: 10px 10px 0 0">
				<div class="widget-header">	
					<h2 class="font-weight-bold text-primary sensor"><i class="fa fa-info-circle text-warning"></i>&nbsp;&nbsp;현재 저울 센서별 평균정보</h2>	
				</div>
			</header>
			<div class="widget-body shadow" style="border-radius: 0 0 10px 10px; padding:1rem">
				<div class="col-xs-6">
					<div class="col-xs-3 no-padding" style="text-align:center"><img src="../images/temp.png" style="width: 1rem;"><br><span></span></div>
					<div class="col-xs-9 no-padding" style="text-align:right">온도(℃)<br><span id="curr_avg_temp" style="font-size:28px">0</span></div>
					<div style="clear:both"></div><hr style="margin-top:0px">
				</div>
				<div class="col-xs-6">
					<div class="col-xs-3 no-padding" style="text-align:center"><img src="../images/drop.png" style="width: 4rem;"><br><span></span></div>
					<div class="col-xs-9 no-padding" style="text-align:right">습도(％)<br><span id="curr_avg_humi" style="font-size:28px">0</span></div>
					<div style="clear:both"></div><hr style="margin-top:0px">
				</div>
				<div class="col-xs-6">
					<div class="col-xs-3 no-padding" style="text-align:center"><img src="../images/co2.png" style="width: 4rem;"><br><span></span></div>
					<div class="col-xs-9 no-padding" style="text-align:right">이산화탄소(ppm)<br><span id="curr_avg_co2" style="font-size:28px">0</span></div>
				</div>
				<div class="col-xs-6">
					<div class="col-xs-3 no-padding" style="text-align:center"><img src="../images/nh3.png" style="width: 5rem;"><br><span></span></div>
					<div class="col-xs-9 no-padding" style="text-align:right">암모니아(ppm)<br><span id="curr_avg_nh3" style="font-size:28px">0</span></div>
					<div style="clear:both"></div>
				</div>
			</div>
		</div>
	</div>
</div>

<!--일일 급이 / 급수량-->
<div class="row" id="row_feed_water">
	<div class="col-xs-12">
		<div class="jarviswidget jarviswidget-color-white no-padding" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">							
			<header style="border-radius: 10px 10px 0 0">
				<div class="widget-header">	
					<h2 class="font-weight-bold text-primary feeder"><i class="fa fa-info-circle text-warning"></i>&nbsp;&nbsp;일일 급이 / 급수량</h2>	
				</div>
			</header>
			<div class="widget-body shadow" style="border-radius: 0 0 10px 10px; padding:1rem">
				<div class="col-xs-9">
					<div class="col-xs-5" style="text-align:right">일일 급수량<br><span id="summary_day_water" style="font-size:28px">0</span></div>
					<div class="col-xs-7 no-padding" style="text-align:center"></div>
				</div>
				<div class="col-xs-3">
					<div class="col-xs-6 no-padding" style="text-align:center"><img src="../images/temp.png" style="width: 1rem;"><br><span></span></div>
				</div>
				<div style="clear:both"></div><hr style="margin-top:0px">
				<div class="col-xs-9">
					<div class="col-xs-5" style="text-align:right">일일 급이량<br><span id="summary_day_feed" style="font-size:28px">0</span></div>
					<div class="col-xs-7 no-padding" style="text-align:center"></div>
				</div>
				<div class="col-xs-3">
					<div class="col-xs-6 no-padding" style="text-align:center"><img src="../images/temp.png" style="width: 1rem;"><br><span></span></div>
				</div>
			</div>
		</div>
	</div>
</div>

<!--현재 외기환경 센서 정보-->
<div class="row" id="">
	<div class="col-xs-12">
		<div class="jarviswidget jarviswidget-color-white no-padding" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">							
			<header style="border-radius: 10px 10px 0 0">
				<div class="widget-header">	
					<h2 class="font-weight-bold text-primary sensor"><i class="fa fa-info-circle text-warning"></i>&nbsp;&nbsp;외기환경 센서 정보</h2>	
				</div>
			</header>
			<div class="widget-body shadow" style="border-radius: 0 0 10px 10px; padding:1rem">
				<div class="col-xs-6">
					<div class="col-xs-3 no-padding text-center text-danger"><img src="../images/temp.png" style="width: 1rem;"><br><span></span></div>
					<div class="col-xs-9 no-padding text-right">온도(℃)<br><span id="" style="font-size:28px">0</span></div>
					<div style="clear:both"></div><hr style="margin-top:0px">
				</div>
				<div class="col-xs-6">
					<div class="col-xs-3 no-padding text-center"><img src="../images/drop.png" style="width: 4rem;"><br><span></span></div>
					<div class="col-xs-9 no-padding text-right">습도(％)<br><span id="" style="font-size:28px">0</span></div>
					<div style="clear:both"></div><hr style="margin-top:0px">
				</div>
				<div class="col-xs-6">
					<div class="col-xs-4 no-padding text-center"><img src="../images/nh3.png" style="width: 5rem;"><br><span></span></div>
					<div class="col-xs-8 no-padding text-right">암모니아(ppm)<br><span id="" style="font-size:28px">0</span></div>
					<div style="clear:both"></div><hr style="margin-top:0px">
				</div>
				<div class="col-xs-6">
					<div class="col-xs-3 no-padding text-center"><img src="../images/h2s.png" style="width: 5rem;"><br><span></span></div>
					<div class="col-xs-9 no-padding text-right">황화수소(ppm)<br><span id="" style="font-size:28px">0</span></div>
					<div style="clear:both"></div><hr style="margin-top:0px">
				</div>
				<div class="col-xs-6">
					<div class="col-xs-4 no-padding text-center"><img src="../images/pm10.png" style="width: 10rem;"><br><span></span></div>
					<div class="col-xs-8 no-padding text-right">미세먼지(㎍/㎥)<br><span id="" style="font-size:28px">0</span></div>
					<div style="clear:both"></div><hr style="margin-top:0px">
				</div>
				<div class="col-xs-6">
					<div class="col-xs-4 no-padding text-center"><img src="../images/pm2.5.png" style="width: 10rem;"><br><span></span></div>
					<div class="col-xs-8 no-padding text-right">초미세먼지(㎍/㎥)<br><span id="" style="font-size:28px">0</span></div>
					<div style="clear:both"></div><hr style="margin-top:0px">
				</div>
				<div class="col-xs-6">
					<div class="col-xs-3 no-padding text-center"><img src="../images/wind-direction.png" style="width: 6rem;"><br><span></span></div>
					<div class="col-xs-9 no-padding text-right">풍향<br><span id="" style="font-size:28px">0</span></div>
					<div style="clear:both"></div>
				</div>
				<div class="col-xs-6">
					<div class="col-xs-3 no-padding text-center"><img src="../images/wind.png" style="width: 3.5rem;"><br><span></span></div>
					<div class="col-xs-9 no-padding text-right">풍속(m/s)<br><span id="" style="font-size:28px">0</span></div>
					<div style="clear:both"></div>
				</div>
			</div>
		</div>
	</div>
</div>

<!--IP 카메라-->
<div class="row" id="row_camera_view" >
	<div class="col-xs-12">
		<div class="jarviswidget jarviswidget-color-white no-padding" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">							
			<header style="border-radius: 10px 10px 0 0">
				<div class="widget-header">	
					<h2 class="font-weight-bold text-primary"><i class="fa fa-camera text-primary"></i>&nbsp;&nbsp;IP 카메라</h2>	
				</div>
			</header>
			<div class="widget-body shadow" style="border-radius: 0 0 10px 10px; padding:1rem" id="camera_zone">

			</div>
		</div>
	</div>
</div>

<?
include_once("../inc/bottom.php")
?>

<script language="javascript">
	
	var open_window;
	var open_url = "";

	$(document).ready(function(){

		load_data();

	});

	function get_dong_data(){
		
		let data_arr = {};
		data_arr["cmCode"] = top_code;	//등록코드
		
		$.ajax({
			url:'0101_action.php',
			data:data_arr,
			cache:false,
			type:'post',
			dataType:'json',
			success: function(data){

				if(top_be_status != "O"){

					$("#row_summary").show();
					$("#row_avg_esti").show();
					$("#row_cell_avg").show();
					//$("#row_feed_water").show();

					//일령
					let interm = data.summary.summary_interm;

					//일령기간별 이미지
					if(interm <= 10){ $(".henImage").attr("src","../images/hen-scale1.png"); }
					if(interm >= 11 && interm <= 20){ $(".henImage").attr("src","../images/hen-scale2.png"); }
					if(interm >= 21){ $(".henImage").attr("src","../images/hen-scale3.png"); }

					//각 요약정보[summary]
					$.each(data.summary, function(key,val){	$("#" + key).html(val); });

					//어제평균중량 산출 시간 표현
					let prev_date = data.summary.summary_day_inc1;
					prev_date = prev_date.length > 15 ? "기준 " + prev_date.substr(11, 2) + "시 " + prev_date.substr(14, 2) + "분" : "-";
					$("#summary_day_inc1").html(prev_date);
				}
				else{
					$("#row_summary").hide();
					$("#row_avg_esti").hide();
					$("#row_cell_avg").hide();
					$("#row_feed_water").hide();
				}
				
				//카메라
				$("#camera_zone").html(data.camera_zone);

			},
			error: function(request,status,error){
				//alert("STATUS : "+request.status+"\n"+"ERROR : "+error);
			}
		});
	}

	// 카메라 선택 시 팝업창 띄움
	function camera_popup(name, img_url){

		let pop_width = 1024;
		let pop_height = 800;

		let pop_left = Math.ceil(( window.screen.width - pop_width ) / 2);
		let pop_top = Math.ceil(( window.screen.height - pop_height ) / 2);

		let options = "width=" + pop_width + ", height=" + pop_height + ", left=" + pop_left + ", top=" + pop_top

		open_url = img_url;
		open_window = window.open("camera_popup.php?title=" + name, "camera_popup", options);
	};

	// 카메라 이미지 불러오기 팝업창에서 실행
	function camera_load(img_obj){
		// 팝업창 닫히면 
		open_window.onbeforeunload = function(){
			img_obj.onload = function(){"";};
			img_obj.setAttribute("src", "");
		};   

		// 이미지가 로드되면
		img_obj.onload = function(){
			img_obj.setAttribute("src", open_url + "&date=" + (new Date()).getTime());
		};

		// 이미지 로드 중 에러 발생시
		img_obj.onerror = function(){
			img_obj.setAttribute("src", "../images/noimage.jpg");
			img_obj.onload = function(){"";};
		};

		// 첫 이미지 로드
		img_obj.setAttribute("src", open_url + "&date=" + (new Date()).getTime());
	};

	function camera_close(img_obj){
		img_obj.setAttribute("src", "../images/noimage.jpg");
		img_obj.onload = function(){"";};

		open_window.close();
	};

</script>