<?
	include_once("../../common/php_module/common_func.php");

	$userID = check_str($_REQUEST["userID"]);
	$userPW = check_str($_REQUEST["userPW"]);

	// 농장 정보 확인
	$select_query = "SELECT f.fID, f.fPW, f.fName, fd.*, be.beStatus, be.beComeinCode, be.beAvgWeight, be.beAvgWeightDate, rc.rcStatus, sf.sfFarmid, so.soFarmid, 
					IFNULL(DATEDIFF(current_date(), cm.cmIndate) + 1, 0) AS interm FROM farm AS f 
					JOIN farm_detail AS fd ON fd.fdFarmid = f.fFarmid 
					JOIN buffer_sensor_status AS be ON be.beFarmid = fd.fdFarmid AND be.beDongid = fd.fdDongid 
					JOIN comein_master AS cm ON cm.cmCode = be.beComeinCode 
					LEFT JOIN request_calculate AS rc ON rc.rcCode = be.beComeinCode AND rcStatus IN ('R', 'A', 'W', 'C') 
					LEFT JOIN set_feeder AS sf ON sf.sfFarmid = fd.fdFarmid AND sf.sfDongid = fd.fdDongid 
                    LEFT JOIN set_outsensor AS so ON so.soFarmid = fd.fdFarmid AND so.soDongid = fd.fdDongid 
					WHERE f.fID = \"" .$userID. "\" AND f.fPW = \"" .$userPW. "\"";

	$init_data = get_select_data($select_query);

	// url 체크
	$curr_url = $_SERVER["PHP_SELF"];
	$splited_url = explode("/", $curr_url);
	$depth_1_url = $splited_url[sizeof($splited_url) - 1];
	$add_url = "?userID=" .$userID. "&userPW=" .$userPW ;

	// 메뉴창에 급이, 외기 표시 조정 변수
	$exist_feed = false;
	$exist_out = false;
	
	if(count($init_data) > 0){		// 데이터가 있으면
		$select_html = "";

		foreach($init_data as $val){
			
			// 페이지 따라 존재하는 동만 셀렉트에 표현
			$test = $val["fdFarmid"];
			switch($depth_1_url){
				case "0103.php":
					$test = $val["sfFarmid"];
					break;
				case "0104.php":
					$test = $val["soFarmid"];
					break;
			}

			if($val["fdFarmid"] != $test){ continue; }		// 급이 급수 및 외기환경 페이지에서 존재하지 않는 동은 제외함

			$select_html .= "<option id='dong_item' value=\"" . $val["beComeinCode"] . "\" ";
			$select_html .= "rcStatus=\"" . $val["rcStatus"] . "\", interm=\"" . $val["interm"] . "\", beAvgWeightDate=\"" . $val["beAvgWeightDate"] . "\", ";
			$select_html .= "beAvgWeight=\"" . sprintf('%0.1f', $val["beAvgWeight"]) . "\", beStatus=\"" . $val["beStatus"] . "\">" . $val["fdName"];
			$select_html .= "</option>";

			if($val["fdFarmid"] == $val["sfFarmid"]){ $exist_feed = true; }
			if($val["fdFarmid"] == $val["soFarmid"]){ $exist_out = true; }
		}
	}
	else{		// 데이터 없으면, 계정이 존재하지 않는 경우
		// 오류 페이지로 이동
	}
	
	//메뉴 구성
	$menu_struct = array();
	$menu_struct[] = array("0101.php", "요약현황");
	$menu_struct[] = array("0102.php", "IoT저울");
	if($exist_feed){ $menu_struct[] = array("0103.php", "급이/급수"); }
	if($exist_out){ $menu_struct[] = array("0104.php", "외기환경"); }
	$menu_struct[] = array("0105.php", "재산출 요청");
	$menu_struct[] = array("0106.php", "출하내역");
	$menu_struct[] = array("1001.php", "설정");

	// 상단 메뉴 html 동적 생성
    $top_menu_html = "";
    foreach($menu_struct as $value){
		for($i=0; $i<=count($menu_struct)-1; $i++){
			if($menu_struct[$i][0]==$value[0]){
				if($depth_1_url==$menu_struct[$i][0]){
					$top_menu_html .= "<li class='active'><a href='javascript:void(0)' onClick=\" location.href='".$menu_struct[$i][0]."".$add_url."'\">".$menu_struct[$i][1]."</a></li>"; //userID,userPW 임시
				}
				else{
					$top_menu_html .= "<li class=''><a href='javascript:void(0)' onClick=\" location.href='".$menu_struct[$i][0]."".$add_url."'\">".$menu_struct[$i][1]."</a></li>";
				}
			}
		}
	}

	// 농장 이름 선택 시 요약 화면으로 복귀
	$farm_name = "<a href='javascript:void(0)' class='text-white font-weight-normal' style='margin:0; font-size:18px' onClick=\" location.href='0101.php".$add_url."'\">".$init_data[0]["fName"]."</a>";
	
?>

<!DOCTYPE html>

<html lang="en-us" class="smart-style-6">
<head>
	<title>KOKOFARM RENEWAL</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  	<!--<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,500,700">-->
  	<link rel="stylesheet" href="../../common/library/fonts/font.css"> <!--Google fonts-->
	
	<script src="../../common/library/jquery/jquery.min.js"></script>						<!-- jQuery -->
	<script src="../../common/library/jquery/jquery-ui-1.10.3.min.js"></script>				<!-- jQuery UI-->
	<script src="../../common/library/bootstrap/bootstrap.min.js"></script>					<!-- BOOTSTRAP JS -->
	<script src="../../common/library/smartwidgets/jarvis.widget.min.js"></script>			<!-- JARVIS WIDGETS -->
	<script src="../../common/library/plugin/sparkline/jquery.sparkline.min.js"></script>	<!-- SPARKLINES -->
	
	<!-- FAVICONS -->
	<link rel="shortcut icon" href="../images/icon.png" type="image/x-icon">
	<link rel="icon" href="../images/icon.png" type="image/x-icon">
	
	<!-- BOOTSTRAP CSS -->
	<link rel="stylesheet" type="text/css" media="screen" href="../../common/library/bootstrap/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" media="screen" href="../../common/library/fonts/font-awesome.min.css"> 

	<!--editable Table-->
	<script src='../../common/library/editable_table/mindmup-editabletable.js'></script>
	<script src='../../common/library/editable_table/numeric-input-example.js'></script>
	<script src="../../common/library/editable_table/external/adamwdraper/numeral.min.js"></script>
	
	<!-- jQuery Grid -->
	<script src="../../common/library/jqgrid/jquery.jqGrid.min.js" type="text/javascript"></script>     	<!--JQGrid-->
	<script src="../../common/library/jqgrid/i18n/grid.locale-kr.js" type="text/javascript"></script>  		<!--JQGrid:Language-->
	<link rel="stylesheet" type="text/css" href="../../common/library/jqgrid/ui.jqgrid-bootstrap.css">  	<!--JQGrid:CSS--->

	<!--amChart-->
	<script src="../../common/library/amchart/amcharts.js" type="text/javascript"></script>
	<script src="../../common/library/amchart/serial.js" type="text/javascript"></script>
	<script src="../../common/library/amchart/lang/ko.js" type="text/javascript"></script>

	<!-- myDefined JS-->
	<script src="../../common/library/my_define/my_define.js"></script>
	<link rel="stylesheet" type="text/css" href="../../common/library/my_define/my_define.css">

	<!--Template CSS-->
	<link rel="stylesheet" media="screen, print" href="../../common/library/vendors/vendors.bundle.css">
	<link rel="stylesheet" media="screen, print" href="../../common/library/app/app.bundle.css">
	<link rel="stylesheet" type="text/css" href="../../common/library/pages/homepage.css">
	<link rel="stylesheet" type="text/css" href="../../common/library/pages/forms.css">
	<link rel="stylesheet" type="text/css" href="../../common/library/pages/buttons.css">

	<!-- date & time picker-->
	<link rel="stylesheet" href="../../common/library/bootstrap_datepicker/datepicker.css">
	<link rel="stylesheet" href="../../common/library/bootstrap_clockpicker/bootstrap-clockpicker.css">
	<script src="../../common/library/bootstrap_datepicker/bootstrap-datepicker.js" type="text/javascript"></script>
	<script src="../../common/library/bootstrap_clockpicker/bootstrap-clockpicker.js" type="text/javascript"></script>

	<!--BOOTSTRAP Table-->
	<link rel="stylesheet" href="../../common/library/bootstrap_table/bootstrap-table.css"/>

	<!--common-->
	<script src="../../common/js_module/common_func.js"></script>
	
<style>
	*{-webkit-text-size-adjust:none;}
</style>
</head>

<body class="smart-style-6 sa-fixed-header">

	<div class="sa-wrapper">

		<header class="sa-page-header">
			<div class="sa-header-container h-100">
				<div class="d-table d-table-fixed h-100 w-100">
					<div class="sa-logo-space d-table-cell h-100">
						<div class="flex-row d-flex align-items-center h-100">
							<img alt="KOKOFARM" src="../images/icon.png" class="sa-logo img-responsive" style="width: fit-content; height: fit-content">
							&nbsp;&nbsp;&nbsp;<?=$farm_name?>
						</div>  
					</div>
					<div class="d-table-cell h-100 w-100 align-middle">
						<div class="sa-header-menu">
							<div class="d-flex align-items-center w-100">
                    
								<div class="ml-auto sa-header-right-area">
							
									<button class="btn btn-default sa-btn-icon sa-sidebar-hidden-toggle" onclick="SAtoggleClass(this, 'body', 'sa-hidden-menu')" type="button"><span class="fa fa-reorder"></span></button>
			
								</div>
							
							</div>          
						</div>
					</div>
				</div>
			</div>
		</header>

		<div class="sa-page-body">

			<!--오른쪽 상세메뉴-->
			<div class="sa-aside-left" style="width:40%; background-color: whitesmoke; z-index: 100;">
				<div class="sa-left-menu-outer">
					<ul class="metismenu sa-left-menu" id="menu1">
						<?=$top_menu_html?>
					</ul>
				</div>
			</div>
		
			<div class="sa-content-wrapper" style="margin:0">
        
				<div class="sa-content no-padding">
					
					<nav class="navbar navbar-expand-lg navbar-light bg-light form-group">
						<div class="navbar-collapse">
							<ul class="navbar-nav justify-content-between" style="flex-direction: row">
								<li class="nav-item dropdown">
									<!-- <div class="dropdown-menu" aria-labelledby="navbarDropdown" style="min-width: 138.64px;">
									</div> -->
									<select class="form-select form-select-lg" id="top_select" aria-label="dong select">
										<?=$select_html?>
									</select>

								</li>
								<li class="nav-item">
									<a class="nav-link" style="width: 100px; text-align: center; cursor: default;" href="#">일령 - <span id="top_interm"></span>일</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" style="width: 100px; text-align: center; cursor: default;" href="#">평체 - <span id="top_avg"></span>g</a>
								</li>
							</ul>
						</div>
					</nav>

					<div class="d-flex w-100">
						<section id="widget-grid" class="w-100">
						
							<!--출하상태 표시 div-->
							<div class="row" id="top_status_info" style="display:none;">
								<div class="col-xs-12" id="top_status_msg"></div>
								<div class="col-xs-12"><h5 class='font-weight-bold text-center text-danger' id="top_last_time" ></span></h5></div>
								<div class="col-xs-12"><h5 class='font-weight-bold text-center text-danger' id="top_last_avg" ></span></h5></div>
							</div>
							
							<!-- <div class="row" style="display:none;">
								<h5 class='font-weight-bold text-center text-danger' id="top_last_time" ></span></h5>
								<h5 class='font-weight-bold text-center text-danger' id="top_last_avg" ></span></h5>
							</div> -->
							
							<!--알람 메시지--->
							<div class="row">
								<div class="col-xs-12">
									<div class="alert alert-danger" role="alert" id="top_request_info" style="text-align:center; margin:0; font-size:18px; display:none;">
										message
									</div>
								</div>
							</div><!--row--->