<?
	include_once("../../common/php_module/common_func.php");

	$userID = check_str($_REQUEST["userID"]);
	$userPW = check_str($_REQUEST["userPW"]);

	// farm 정보와 일치하는지 확인
	$select_sql = "SELECT fFarmid, fName FROM farm WHERE fID = \"$userID\" AND fPW = \"$userPW\"";                          
	$select_get_data = get_select_data($select_sql);

	$farmID   = $select_get_data[0]["fFarmid"];
	$farmName = $select_get_data[0]["fName"];

	if(!empty($farmID)) {
		// farmid를 통해 farm_detail 농장,동,농장명 가져옴
		$str_sql  = "SELECT fdFarmid, fdDongid, fdName FROM farm_detail WHERE fdFarmid = \"$farmID\"";
		$chk_data = get_select_data($str_sql);

		$fd_Name = $chk_data[0]["fdName"];
		$fd_Farm = $chk_data[0]["fdFarmid"];
		$fd_Dong = $chk_data[0]["fdDongid"];

		$nav_menu = "";

		foreach($chk_data as $val) {
			// farm_detail의 농장id, 동id를 통해 농장마다 소유하고 있는 동 나열
			$str_sql2 = "SELECT cmCode, IFNULL(DATEDIFF(current_date(), cmIndate)+1, 0) AS inTERM
				 		 FROM comein_master
				 		 WHERE cmFarmid='".$val["fdFarmid"]."' AND cmDongid='".$val["fdDongid"]."' AND IFNULL(LENGTH(cmIndate), 0) >= 4 AND IFNULL(LENGTH(cmOutdate), 0) <= 4";
			$get_data2 = get_select_data($str_sql2);

			$cmCode  	= $get_data2[0]["cmCode"];		 //등록코드
			$inTERM  	= $get_data2[0]["inTERM"];		 //일령

			$nav_menu .= "<a class='dropdown-item' href='#' data-farmID='".$val["fdFarmid"]."' data-dongID='".$val["fdDongid"]."' data-cmCode='".$cmCode."'>".$val["fdName"]."</a>";
		}

		//상단에 나타낼 정보
		$str_sql3 = "SELECT beAvgWeight, beStatus, beSensorDate FROM buffer_sensor_status WHERE beFarmid = \"$fd_Farm\" AND beDongid = \"$fd_Dong\"";
		$get_avg  = get_select_data($str_sql3);

		$aWeight 	= $get_avg[0]["beAvgWeight"];	 //평균중량
		$avg_weight = sprintf('%0.1f',$aWeight);
		$now_status = $get_avg[0]["beStatus"];	 	 //I:입추 O:출하 E:에러 W:대기(에러) 상태
		$final_date = $get_avg[0]["beSensorDate"]; 	 //최종 데이터 수집시간
	}
	
	//메뉴 구성
	$menu_struct = array(
		array("0101.php", "요약현황"),
		array("0102.php", "IoT저울"),
		array("0103.php", "급이/급수"),
		array("0104.php", "외기환경"),
		array("0105.php", "재산출 요청"),
		array("0106.php", "출하내역"),
		array("1001.php", "설정"),
	);

	$curr_url = $_SERVER["PHP_SELF"];
	$splited_url = explode("/", $curr_url);
	$depth_1_url = $splited_url[sizeof($splited_url) - 1];
	$add_url = "?userID=$userID&userPW=$userPW";

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
							<h3 class="text-white font-weight-normal" style="margin:0">&nbsp;<?=$farmName?></h3>
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
									<a class="nav-link dropdown-toggle border" style="width: 138.64px; text-align: center;" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										<span><?=$fd_Name?></span>
									</a>
									<div class="dropdown-menu" aria-labelledby="navbarDropdown" style="min-width: 138.64px;">
										<?=$nav_menu?>
									</div>
								</li>
								<li class="nav-item">
									<a class="nav-link" style="width: 100px; text-align: center; cursor: default;" href="#">일령 - <span id="summary_interm"><?=$inTERM?></span>일</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" style="width: 100px; text-align: center; cursor: default;" href="#">평체 - <?=$avg_weight?>g</a>
								</li>
							</ul>
						</div>
					</nav>

					<div class="d-flex w-100">
						<section id="widget-grid" class="w-100">
						
							<!--출하상태 표시 div-->
							<div class="row alarm" style="display : none;">
								<input type="hidden" name="now_status" value="<?=$now_status?>">
							</div>
							
							<div class="row error_alarm" style="display : none;">
								<h5 class='font-weight-bold text-center text-danger'> 최종 수집시간 : <span><?=$final_date?></span></h5>
							</div>