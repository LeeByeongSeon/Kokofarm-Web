<?
	include_once("../common/php_module/common_func.php");

	$farmID = check_str($_REQUEST["farmID"]);
	$dongID = check_str($_REQUEST["dongID"]);

	// 농장 정보 확인
	$select_query = "SELECT fd.*, cm.*, be.*, rc.rcStatus, sf.sfFarmid, so.soFarmid, 
					IFNULL(DATEDIFF(current_date(), cm.cmIndate) + 1, 0) AS interm FROM farm_detail AS fd
					JOIN buffer_sensor_status AS be ON be.beFarmid = fd.fdFarmid AND be.beDongid = fd.fdDongid
					JOIN comein_master AS cm ON cm.cmCode = be.beComeinCode
					LEFT JOIN request_calculate AS rc ON rc.rcCode = be.beComeinCode AND rcStatus IN ('R', 'A', 'W', 'C')
					LEFT JOIN set_feeder AS sf ON sf.sfFarmid = fd.fdFarmid AND sf.sfDongid = fd.fdDongid
                    LEFT JOIN set_outsensor AS so ON so.soFarmid = fd.fdFarmid AND so.soDongid = fd.fdDongid
					WHERE fd.fdFarmid = \"" .$farmID. "\" AND fd.fdDongid = \"" .$dongID. "\"";

	$init_data = get_select_data($select_query);

	// 메뉴창에 급이, 외기 표시 조정 변수
	$exist_feed = false;
	$exist_out  = false;
	
	if(count($init_data) > 0){		// 데이터가 있으면

		$farm_code   = $init_data[0]['cmCode']; 
		$farm_name   = $init_data[0]['fdName'];  // 농장 이름
		$farm_interm = $init_data[0]['interm'];  // 농장 일령
		$indate = $init_data[0]['cmIndate'];	 // 농장 입추일

		$farm_indate = substr($indate, 0, 10);
		$farm_devi = sprintf('%0.1f',$init_data[0]['beDevi']);	 	// 표준편차
		$farm_vc   = sprintf('%0.1f',$init_data[0]['beVc']);		// 변이계수
		$farm_avg  = sprintf('%0.1f',$init_data[0]['beAvgWeight']); // 평균중량
		$farm_avg_time  = $init_data[0]['beAvgWeightDate']; // 평균중량 산출 시간
		$farm_lat  = $init_data[0]['fdGpslat'];  // GPSlat
		$farm_lng  = $init_data[0]['fdGpslng'];	 // GPSlng
		$farm_status = $init_data[0]['beStatus'];
		$request_status = $init_data[0]['rcStatus'];

		//현재 URL 확인 및 메뉴출력
		$curr_url	= $_SERVER["PHP_SELF"];
		$arr_url	= explode("/",$curr_url);
		$depth1_url = $arr_url[sizeof($arr_url)-2];
		$depth2_url = $arr_url[sizeof($arr_url)-1];
		$add_url 	= "?farmID=".$farmID."&dongID=".$dongID;

		if($init_data[0]["fdFarmid"] == $init_data[0]["sfFarmid"]){ $exist_feed = true; }
		if($init_data[0]["fdFarmid"] == $init_data[0]["soFarmid"]){ $exist_out = true; }

		//메뉴 구성
		$menu_struct = array();
		$menu_struct[] = array("0101.php".$add_url, "요약현황", "icon-01.png");
		$menu_struct[] = array("0102.php".$add_url, "IoT저울", "icon-02.png");
		if($exist_feed){ $menu_struct[] = array("0103.php".$add_url, "급이/급수", "icon-04.png"); }
		if($exist_out){ $menu_struct[] = array("0104.php".$add_url, "외기환경", "icon-03.png"); }
		$menu_struct[] = array("0105.php".$add_url, "재산출 요청", "icon-05.png");
		
		// 상단 메뉴 html 동적 생성
		$top_menu_html = "";
		foreach($menu_struct as $menu){

			$top_menu_html .= "<li style='border-radius:10px; width: 150px;'>
					<a href='" . $menu[0]. "' class='" .($depth1_url == $menu[0] ? "active" : ""). " font-lg font-weight-bold text-secondary'>
						<img src='../images/" . $menu[2]. "' style='width: 150px'>
						<div class='text-center' style='position: absolute; top: 110px; width:150px'>" .$menu[1]. "</div>
					</a></li>" ; 
		}
		
	}
	else{		// 데이터 없으면, 계정이 존재하지 않는 경우
		// 오류 페이지로 이동
		echo("<script>location.replace('./error.php')</script>");
	}
	
?>

<!DOCTYPE html>

<html lang="en-us" class="smart-style-6">
<head>
	<title>꼬꼬팜 :: KOKOFARM4</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@500&display=swap">
  	<!-- <link rel="stylesheet" href="../common/library/fonts/font.css"> Google fonts -->
	
	<script src="../common/library/jquery/jquery.min.js"></script>						<!-- jQuery -->
	<script src="../common/library/jquery/jquery-ui-1.10.3.min.js"></script>				<!-- jQuery UI-->
	<script src="../common/library/bootstrap/bootstrap.min.js"></script>					<!-- BOOTSTRAP JS -->
	
	<!-- FAVICONS -->
	<link rel="shortcut icon" href="../images/icon.png" type="image/x-icon">
	<link rel="icon" href="../images/icon.png" type="image/x-icon">
	
	<!-- BOOTSTRAP CSS -->
	<link rel="stylesheet" type="text/css" media="screen" href="../common/library/bootstrap/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" media="screen" href="../common/library/fonts/font-awesome.min.css"> 

	<!--editable Table-->
	<script src='../common/library/editable_table/mindmup-editabletable.js'></script>
	<script src='../common/library/editable_table/numeric-input-example.js'></script>
	<script src="../common/library/editable_table/external/adamwdraper/numeral.min.js"></script>
	
	<!-- jQuery Grid -->
	<script src="../common/library/jqgrid/jquery.jqGrid.min.js" type="text/javascript"></script>     	<!--JQGrid-->
	<script src="../common/library/jqgrid/i18n/grid.locale-kr.js" type="text/javascript"></script>  		<!--JQGrid:Language-->
	<link rel="stylesheet" type="text/css" href="../common/library/jqgrid/ui.jqgrid-bootstrap.css">  	<!--JQGrid:CSS--->

	<!--amChart-->
	<script src="../common/library/amchart/amcharts.js" type="text/javascript"></script>
	<script src="../common/library/amchart/serial.js" type="text/javascript"></script>
	<script src="../common/library/amchart/lang/ko.js" type="text/javascript"></script>

	<!--Template CSS-->
	<link rel="stylesheet" media="screen, print" href="../common/library/vendors/vendors.bundle.css">
	<link rel="stylesheet" media="screen, print" href="../common/library/app/app.bundle.css">

	<!-- date & time picker-->
	<link rel="stylesheet" href="../common/library/bootstrap_datepicker/datepicker.css">
	<link rel="stylesheet" href="../common/library/bootstrap_clockpicker/bootstrap-clockpicker.css">

	<!--BOOTSTRAP Table-->
	<link rel="stylesheet" href="../common/library/bootstrap_table/bootstrap-table.css"/>

	<!--common-->
	<script src="../common/js_module/common_func.js"></script>
	
<style>
	*{-webkit-text-size-adjust:none; color:#4C4C4C}
	@import url('https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@500&display=swap');
</style>
</head>

<body class="sa-fixed-header">
	<div class="sa-wrapper">

		<header class="sa-page-header shadow-none" style="border: 0; background-color: white;">
			<div class="sa-header-container h-100">
				<div class="d-table d-table-fixed h-100 w-100">
					<div class="sa-logo-space d-table-cell h-100">
						<div class="flex-row d-flex align-items-center h-100">
							<img alt="KOKOFARM" src="../images/logo2.png" class="sa-logo img-responsive" style="width: 150px">&nbsp;&nbsp;&nbsp;
							<span class="badge badge-info" style="margin-top: 5%">ver 5.5</span>
						</div>
					</div>
					<div class="d-table-cell h-100" style="width:20%; vertical-align: bottom;">
						<div class="progress progress-striped active" rel="tooltip" data-original-title="0%" data-placement="bottom" style="margin-bottom: 4%">
							<div id="state_bar" class="progress-bar bg-primary" role="progressbar" style="width: 0%">0 %</div>
						</div>
					</div>
					<div class="d-table-cell h-100" style="width:40%">
						<div class="sa-header-menu">
							<div class="d-flex align-items-center w-100">
								<div class="ml-auto sa-header-right-area font-xl font-weight-bold" style="color:#4C4C4C">
									<?=$farm_name?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</header>

		<div class="sa-page-body px-3 bg-white">

			<!--상단메뉴-->
			<div class="sa-aside-left d-sm-block w-100" style="position: fixed; padding:0; left:0; top:49px; height:100px; z-index: 101; background : white;">
				<div class="sa-left-menu-outer" style="background-color: white;">
					<ul class="d-flex flex-row justify-content-between text-center pt-1 px-3" id="menu1">
						<?=$top_menu_html?>
					</ul>
				</div>
			</div>
		
			<div class="sa-content-wrapper" style="margin:0">
				<div class="sa-content no-padding">
					<div class="d-flex w-100">
						<section id="widget-grid" class="w-100">

							<div class="container-fluid" style="margin-top:180px">

								<!--알람 메시지--->
								<div class="row mb-5" id="top_request_row" style="margin-top:-30px; display:none;">
									<div class="col-sm-12 no-padding">
										<div class="alert alert-danger text-center m-0 font-weight-bold fadeIn animated" role="alert" id="top_request_info" style="font-size:18px;">
											message
										</div>
									</div>
								</div>

								<!--출하상태 표시 div-->
								<div class="row mb-5 d-none" id="top_status_info" style="margin-top:-30px;">
									<div class="col-sm-12 no-padding">
										<div class="card" style="border-radius: 15px; border: 4px solid #E6E6E6;">
											<div class="card-header font-weight-bold text-primary pl-2" style="border-radius: 15px 15px 0 0;"><i class="fa fa-bell-o text-orange swing animated"></i> 상태 알림</div>
											<div class="card-body p-2" style="border-bottom: 0">
												<table class="table-borderless w-100 text-center" style="line-height: 2.5rem;">
													<tr>
														<td class="text-secondary" colspan="2" id="top_status_msg"></td>
													</tr>
													<tr>
														<td class="w-50 font-xl text-secondary" id="top_time_info"></td><td class="w-50 font-xl text-danger font-weight-bold" id="top_last_time"></td>
													</tr>
													<tr>
														<td class="w-50 font-xl text-secondary" id="top_avg_info"></td><td class="w-50 font-xl text-danger font-weight-bold" id="top_last_avg"></td>
													</tr>
												</table>
											</div>
											<div class="card-footer bg-transparent text-right no-padding" id="top_notice" style="border-top: 0"></div>
										</div>
									</div>
								</div>

								<div class="row" style="margin-top:-30px">

									<!--실시간 평균중량-->
									<div class="col-sm-6 no-padding">
										<div class="jarviswidget jarviswidget-color-white no-padding" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
											<div class="widget-body" style="border-radius: 15px; border: 4px solid #E6E6E6; width: 380px; height: 136.5px;">
												<div class="col-sm-4 float-left text-center no-padding">
													<img class="img-reponsive henImage no-padding" src="../images/hen-scale1.png">
													<div class="carousel-caption henInterm" style="text-shadow: none;"><h1 class="font-weight-bold text-white"><?=$farm_interm?>일</h1></div>
												</div>
												<div class="col-sm-5 d-flex flex-column pt-3 px-0">
													<span class="font-weight-bold text-secondary text-center" style="font-size:15px">실시간 평균중량(g)</span>
													<span class="font-weight-bold text-orange text-center" style="font-size:40px"><?=$farm_avg?></span>
													<span class="font-weight-bold text-secondary text-center" style="font-size: 15px">입추일 : <?=$farm_indate?></span>
												</div>
												<div class="col-sm-3 float-right d-flex flex-column p-1">
													<span class="font-lg text-secondary text-right">표준편차<br><span class="text-right"><?=$farm_devi?></span></span>
													<span class="font-lg text-secondary text-right">변이계수<br><span class="text-right"><?=$farm_vc?></span></span>
												</div>
											</div>
										</div>
									</div>

									<!--실시간 시간 및 날씨-->
									<div class="col-sm-6 no-padding">
										<div class="jarviswidget jarviswidget-color-white no-padding" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
											<div class="widget-body d-flex flex-wrap float-right" style="height: 136.5px; border-radius: 15px; border: 4px solid #E6E6E6; width: 380px">
												<div class="col-sm-12 d-flex align-items-center"><span class="font-xl text-right w-100" id="clock_now"></span></div>
												<div class="col-sm-12 d-flex align-items-center">
													<div class="col-sm-3 no-padding text-center">
														<img id="weather_icon" src="">
													</div>
													<div class="col-sm-3 no-padding text-right">
														<span class="font-lg text-secondary p-1">온도<br><span class="text-right" id="weather_temp">0</span>℃</span>
													</div>
													<div class="col-sm-3 no-padding text-right">
														<span class="font-lg text-secondary p-1">습도<br><span class="text-right" id="weather_humi">0</span>％</span>
													</div>
													<div class="col-sm-3 no-padding text-right">
														<span class="font-lg text-secondary p-1">풍속<br><span class="text-right" id="weather_wind">0</span>㎧</span>
													</div>
												</div>
											</div>
										</div>
									</div>

								</div>