<?
include_once("../inc/top.php");
?>

<div class="row">
	<div class="col-xs-12">
		<div class="jarviswidget jarviswidget-color-white no-padding" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
			<div class="widget-body" style="padding:0.5rem; min-height: 0;">
				<form id="search_form" class="form-inline mr-auto" onsubmit="return false;">&nbsp;&nbsp;
					<span class="font-weight-bold text-primary"><i class="fa fa-home"></i>&nbsp;&nbsp;농장 검색 : </span>&nbsp;&nbsp;
					<!--임시 select-->
					<select class="form-control w-auto">
						<option>전체</option>
						<option>입추</option>
						<option>출하</option>
					</select>&nbsp;&nbsp;
					<select class="form-control w-auto">
						<option>고산 1농 - 1동</option>
					</select>&nbsp;&nbsp;
					<button type="button" class="btn btn-primary btn-sm" onClick="search_action('search')"><span class="fa fa-check"></span>&nbsp;&nbsp;확인</button>&nbsp;&nbsp;
				</form>
			</div>	
		</div>
	</div>
</div>

<!--실시간 평균-->
<div class="row">
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
					<img class="p-2 img-reponsive henImage" src="../images/hen-scale1.png">
					<div class="p-4 carousel-caption"><h1 class="font-weight-bold"> <span id="summary_in_term"></span>일 </h1></div>
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
<div class="row avg_weight">
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
<div class="row">
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
<div class="row" id="row_feed_water" style="display: none;">
	<div class="col-xs-12">
		<div class="jarviswidget jarviswidget-color-white no-padding" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">							
			<header style="border-radius: 10px 10px 0 0">
				<div class="widget-header">	
					<h2 class="font-weight-bold text-primary feeder"><i class="fa fa-info-circle text-warning"></i>&nbsp;&nbsp;급이 및 급수 정보</h2>	
				</div>
			</header>
			<div class="widget-body shadow pt-3" style="border-radius: 0 0 10px 10px; padding:1rem; height: 250px">
				<div class="col-xs-4 no-padding" style="margin-bottom: 15px">
					<div class="col-xs-12 text-center"><img src="../images/feed-04.png" style="width: 8rem;"><br>
						<div class="carousel-caption"><h3 class="font-weight-bold m-0 pt-4 text-secondary" id="extra_feed_percent">100%</h3></div>
					</div>
				</div>
				<div class="col-xs-4" style="margin-bottom: 15px">
					<div class="col-xs-12 text-right">일일 급이량<br><span id="extra_curr_feed" style="font-size:28px">0</span></div>
				</div>
				<div class="col-xs-4" style="margin-bottom: 15px">
					<div class="col-xs-12 text-right">전일 급이량<br><span id="extra_prev_feed" style="font-size:28px">0</span></div>
				</div>
				<div style="clear:both"></div><hr style="margin-top:0px">
				<div class="col-xs-4 no-padding" style="margin-top: 10px">
					<div class="col-xs-12 text-center"><img src="../images/water-02.png" style="width: 6rem;"><br><span></span></div>
				</div>
				<div class="col-xs-4" style="margin-top: 10px">
					<div class="col-xs-12 text-right">일일 급수량<br><span id="extra_curr_water" style="font-size:28px">0</span></div>
				</div>
				<div class="col-xs-4" style="margin-top: 10px">
					<div class="col-xs-12 text-right">전일 급수량<br><span id="extra_prev_water" style="font-size:28px">0</span></div>
				</div>
			</div>
		</div>
	</div>
</div>

<!--현재 외기환경 센서 정보-->
<div class="row" id="row_outsensor" style="display: none;">
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
					<div class="col-xs-9 no-padding text-right">온도(℃)<br><span id="extra_out_temp" style="font-size:28px">0</span></div>
					<div style="clear:both"></div><hr style="margin-top:0px">
				</div>
				<div class="col-xs-6">
					<div class="col-xs-3 no-padding text-center"><img src="../images/drop.png" style="width: 4rem;"><br><span></span></div>
					<div class="col-xs-9 no-padding text-right">습도(％)<br><span id="extra_out_humi" style="font-size:28px">0</span></div>
					<div style="clear:both"></div><hr style="margin-top:0px">
				</div>
				<div class="col-xs-6">
					<div class="col-xs-4 no-padding text-center"><img src="../images/nh3.png" style="width: 5rem;"><br><span></span></div>
					<div class="col-xs-8 no-padding text-right">암모니아(ppm)<br><span id="extra_out_nh3" style="font-size:28px">0</span></div>
					<div style="clear:both"></div><hr style="margin-top:0px">
				</div>
				<div class="col-xs-6">
					<div class="col-xs-3 no-padding text-center"><img src="../images/h2s.png" style="width: 5rem;"><br><span></span></div>
					<div class="col-xs-9 no-padding text-right">황화수소(ppm)<br><span id="extra_out_h2s" style="font-size:28px">0</span></div>
					<div style="clear:both"></div><hr style="margin-top:0px">
				</div>
				<div class="col-xs-6">
					<div class="col-xs-4 no-padding text-center"><img src="../images/pm10.png" style="width: 10rem;"><br><span></span></div>
					<div class="col-xs-8 no-padding text-right">미세먼지(㎍/㎥)<br><span id="extra_out_dust" style="font-size:28px">0</span></div>
					<div style="clear:both"></div><hr style="margin-top:0px">
				</div>
				<div class="col-xs-6">
					<div class="col-xs-4 no-padding text-center"><img src="../images/pm2.5.png" style="width: 10rem;"><br><span></span></div>
					<div class="col-xs-8 no-padding text-right">초미세먼지(㎍/㎥)<br><span id="extra_out_udust" style="font-size:28px">0</span></div>
					<div style="clear:both"></div><hr style="margin-top:0px">
				</div>
				<div class="col-xs-6">
					<div class="col-xs-3 no-padding text-center"><img src="../images/wind-direction.png" style="width: 6rem;"><br><span></span></div>
					<div class="col-xs-9 no-padding text-right">풍향<br><span id="extra_out_direction" style="font-size:28px">0</span></div>
					<div style="clear:both"></div>
				</div>
				<div class="col-xs-6">
					<div class="col-xs-3 no-padding text-center"><img src="../images/wind.png" style="width: 3.5rem;"><br><span></span></div>
					<div class="col-xs-9 no-padding text-right">풍속(m/s)<br><span id="extra_out_wind" style="font-size:28px">0</span></div>
					<div style="clear:both"></div>
				</div>
			</div>
		</div>
	</div>
</div>

<!--IP 카메라-->
<div class="row">
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