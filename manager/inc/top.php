<?
	include_once("../common/php_module/common_func.php");

	$mgrID = isset($_REQUEST["mgrID"]) ? $_REQUEST["mgrID"] : "";
	$mgrPW = isset($_REQUEST["mgrPW"]) ? $_REQUEST["mgrPW"] : "";
	
	// 관리자 정보 확인
	$select_query = "SELECT * FROM manager WHERE mgrID = \"" .$mgrID. "\" AND mgrPW = \"" .$mgrPW. "\"";

	$init_data = get_select_data($select_query);
	
	// url 체크
	$curr_url = $_SERVER["PHP_SELF"];
	$splited_url = explode("/", $curr_url);
	$depth_1_url = $splited_url[sizeof($splited_url) - 1];
	$add_url = "?mgrID=" .$mgrID. "&mgrPW=" .$mgrPW;

	if(count($init_data) > 0){
		$_SESSION["mgrID"] = $mgrID;
		$_SESSION["mgrPW"] = $mgrPW;
	
	} else { // 데이터가 없거나 계정이 존재하지않는 경우 오류페이지로 이동
		echo("<script>location.replace('./error.php')</script>");
	}
	
	// 메뉴 구성
	$menu_struct = array(
		array("0101.php", "농장별 장치현황"),
		array("0102.php", "농장현황"),
		array("0103.php", "동별현황"),
		array("0104.php", "IoT저울"),
		array("0105.php", "급이/급수"),
		array("0106.php", "외기환경"),
		array("0107.php", "사육정보"),
		array("0108.php", "농장별 출하내역"),
		array("0109.php", "재산출 요청 관리"),
	);

	// 상단 메뉴 html 동적 생성
	$top_menu_html = "";
	foreach($menu_struct as $value){
		for($i=0; $i<=count($menu_struct)-1; $i++){
			if($menu_struct[$i][0]==$value[0]){
				if($depth_1_url==$menu_struct[$i][0]){
					$top_menu_html .= "<li class='active'><a href='javascript:void(0)' onClick=\" location.href='".$menu_struct[$i][0]."".$add_url."'\" style='color: #494949;'>".$menu_struct[$i][1]."</a></li>"; //userID,userPW 임시
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
	<title>KOKOFARM MANAGER</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=4.0, user-scalable=yes">
  	<!--<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,500,700">-->
  	<link rel="stylesheet" href="../common/library/fonts/font.css"> <!--Google fonts-->
	
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
	*{-webkit-text-size-adjust:none;}
</style>
</head>

<body class="smart-style-6 sa-fixed-header" style="background-color: whitesmoke">

	<div class="sa-wrapper">

		<header class="sa-page-header" style="background-color: whitesmoke;">
			<div class="sa-header-container h-100">
				<div class="d-table d-table-fixed h-100 w-100">
					<div class="sa-logo-space d-table-cell h-100">
						<div class="flex-row d-flex align-items-center h-100">
							<a href="javascript:void(0)" onClick="location.href='0101.php<?=$add_url?>'"><img alt="KOKOFARM" src="../images/logo.png" class="sa-logo img-responsive"></a>&nbsp;
							<span class="badge bg-orange" style="margin-top: 3.5%">manager</span>
						</div>  
					</div>
					<div class="d-table-cell h-100 w-25 align-middle">
						<div class="sa-header-menu">
							<div class="d-flex align-items-center w-100">
                    
								<div class="ml-auto sa-header-right-area">
							
									<button class="btn btn-default sa-btn-icon sa-sidebar-hidden-toggle" onclick="SAtoggleClass(this, 'body', 'sa-hidden-menu')" type="button"><span class="fa fa-reorder" style="color: #0c6ad0;"></span></button>
			
								</div>
							
							</div>          
						</div>
					</div>
				</div>
			</div>
		</header>

		<div class="sa-page-body">

			<!--오른쪽 상세메뉴-->
			<div class="sa-aside-left bg-color-whitesmoke" style="width: 45%; z-index: 100; position: fixed; background-color: whitesmoke;">
				<div class="sa-left-menu-outer">
					<ul class="metismenu sa-left-menu" id="menu1">
						<?=$top_menu_html?>
					</ul>
				</div>
			</div>
		
			<div class="sa-content-wrapper m-0">
        
				<div class="sa-content p-1">

					<div class="d-flex w-100">
						<section id="widget-grid" class="w-100">