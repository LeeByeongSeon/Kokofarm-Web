<?
	include_once("../../common/php_module/common_func.php");

	$mgrID = check_str($_REQUEST["mgrID"]);
	$mgrPW = check_str($_REQUEST["mgrPW"]);

	if(!empty($mgrID)) {
		
	}
	
	//메뉴 구성
	$menu_struct = array(
		array("0101.php", "농장별 장치현황"),
		array("0102.php", "농장별 세부현황"),
		array("0103.php", "농장별 출하내역"),
		array("0104.php", "재산출 요청 관리"),
		array("1001.php", "설정")
	);

	$curr_url = $_SERVER["PHP_SELF"];
	$splited_url = explode("/", $curr_url);
	$depth_1_url = $splited_url[sizeof($splited_url) - 1];
	$add_url = "?mgrID=$mgrID&mgrPW=$mgrPW";

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
							<img alt="KOKOFARM" src="../images/logo.png" class="sa-logo img-responsive">
							&nbsp;<span class="badge badge-secondary">manager</span>
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

					<div class="d-flex w-100">
						<section id="widget-grid" class="w-100">