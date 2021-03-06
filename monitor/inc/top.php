<?
	include_once("../common/php_module/common_func.php");

	$mgr_id    = $_SESSION["mgr_id"];
	$mgr_name  = $_SESSION["mgr_name"];
	$mgr_type  = $_SESSION["mgr_type"];
	$mgr_group = $_SESSION["mgr_group"];
	
	if(strlen($mgr_id)<=3 || strlen($mgr_name)<=3 || strlen($mgr_type)<=3 || strlen($mgr_group)<=3){
		echo ("<script>location.href='../00_login/index.php'</script>");
	}
	
	//메뉴 구성
	$menu_struct = array(
		//장치현황
		array("01_device_mnt", "0101.php", "KKF-1", "KKF-2", "Y", "fa fa-lg fa-fw fa-home"),
		array("01_device_mnt", "0102.php", "KKF-1", "KKF-3", "", ""),
		array("01_device_mnt", "0103.php", "KKF-1", "KKF-4", "", ""),
		
		//농장현황
		array("02_farm_mnt", "0202.php", "KKF-5", "KKF-6", "", ""),
		array("02_farm_mnt", "0201.php", "KKF-5", "KKF-7", "Y", "fa fa-lg fa-fw fa-bar-chart-o"),
		array("02_farm_mnt", "0203.php", "KKF-5", "KKF-8", "", ""),
		array("02_farm_mnt", "0204.php", "KKF-5", "KKF-9", "", ""),
		array("02_farm_mnt", "0205.php", "KKF-5", "KKF-10", "", ""),
		array("02_farm_mnt", "0206.php", "KKF-5", "KKF-11", "", ""),
		
		//계정관리
		array("03_account_mgr", "0301.php", "KKF-12", "KKF-13", "Y", "fa fa-lg fa-fw fa-group"),
		array("03_account_mgr", "0302.php", "KKF-12", "KKF-14", "", ""),
		array("03_account_mgr", "0303.php", "KKF-12", "KKF-15", "", ""),
		
		//장치관리
		array("04_device_mgr", "0401.php", "KKF-16", "KKF-17", "Y", "fa fa-lg fa-fw fa-video-camera"),
		array("04_device_mgr", "0402.php", "KKF-16", "KKF-18", "", ""),
		array("04_device_mgr", "0403.php", "KKF-16", "KKF-19", "", ""),
		array("04_device_mgr", "0404.php", "KKF-16", "KKF-20", "", ""),

		//옵션관리
		array("05_option_mgr", "0501.php", "KKF-21", "KKF-22", "Y", "fa fa-lg fa-fw fa-cog"),
		array("05_option_mgr", "0502.php", "KKF-21", "KKF-23", "", ""),
	);
  
    //현재 URL 확인 및 메뉴출력
    $curr_url = $_SERVER["PHP_SELF"];        
	$splited_url = explode("/", $curr_url);
    $depth_1_url = $splited_url[sizeof($splited_url) - 2];  
	$depth_2_url = $splited_url[sizeof($splited_url) - 1];
	
	// 상단 메뉴 html 동적 생성
    $top_menu_html = "";
    foreach($menu_struct as $value){
		switch ($value[4]){
			case "Y":
				if($depth_1_url == $value[0]){
					$top_menu_html .= "<li class='active'>";
					$top_menu_html .= " <a class='has-arrow' href='#'><span class='" .$value[5]. "'></span><span class='menu-item-parent'><span class='" .$value[2]. "'></span></a>";
					$top_menu_html .= "   <ul aria-expanded='true' class='sa-sub-nav collapse'>";
				}
				else{
					$top_menu_html .= "<li class=''>";
					$top_menu_html .= " <a class='has-arrow' href='#'><span class='" .$value[5]. "'></span><span class='menu-item-parent'><span class='" .$value[2]. "'></span></a>";
					$top_menu_html .= "   <ul aria-expanded='true' class='sa-sub-nav collapse'>";
				}

				//서브메뉴 for문
				for($i=0; $i<=count($menu_struct)-1; $i++){
					if($menu_struct[$i][0]==$value[0]){
						if($depth_1_url==$menu_struct[$i][0] && $depth_2_url==$menu_struct[$i][1]){
							$top_menu_html .= "<li class='active'><a href='javascript:void(0)' onClick=\" location.href='../" . $menu_struct[$i][0] . "/" . $menu_struct[$i][1] . "' \"><span class='". $menu_struct[$i][3] ."'><span></a></li>";
						}
						else{
							$top_menu_html .= "<li class=''><a href='javascript:void(0)' onClick=\" location.href='../" . $menu_struct[$i][0] . "/" . $menu_struct[$i][1] . "' \"><span class='" . $menu_struct[$i][3] . "'><span></a></li>";
						}
					}
				}
				$top_menu_html .= "   </ul>";
				$top_menu_html .= "</li>";
			break;

			case 'N':
				if($depth_1_url == $value[0]){
					$top_menu_html .= "<li class='active'>";
					$top_menu_html .= " <a href='javascript:void(0)' onclick=\" location.href='../" . $value[0] . "/" . $value[1] . "' \"><span class='" .$value[5]. "'></span><span class='menu-item-parent'>".$value[3]."</span></a>";
					$top_menu_html .= "</li>";
				}
				else{
					$top_menu_html .= "<li class=''>";
					$top_menu_html .= " <a href='javascript:void(0)' onclick=\" location.href='../" . $value[0] . "/" . $value[1] . "' \"><span class='" .$value[5]. "'></span><span class='menu-item-parent'>".$value[3]."</span></a>";
					$top_menu_html .= "</li>";
				}
			break;
		}
	}

	//header 제목
	$title_html = "";
	foreach ($menu_struct as $value){
		if($depth_1_url == $value[0] && $depth_2_url == $value[1]){
			$title_html .= "<h4 class='page-header'><i class='fa-fw fa fa-th-large text-orange'></i>&nbsp;<span class='" .$value[2]. " font-sm font-weight-bold'></span><span style='color:#455a64'> <i class='fa-fw fa fa-angle-right'></i> <b><span class='" .$value[3]. "'></span></b></span></h4>";
		}
	}

	$query = "SELECT 
				   COUNT(*) AS cnt_all, 
				   COUNT(IF(beStatus = 'O', beStatus, null)) AS cnt_out, 
				   COUNT(IF(beStatus = 'E', beStatus, null)) AS cnt_err, 
				   COUNT(IF(beStatus = 'W', beStatus, null)) AS cnt_wait 
			  FROM buffer_sensor_status";

	$cnt_data = get_select_data($query)[0];
	$cnt_out = number_format($cnt_data["cnt_out"]);
	$cnt_in = number_format($cnt_data["cnt_all"]) - $cnt_out;
	$cnt_err = number_format($cnt_data["cnt_err"]);
	$cnt_wait = number_format($cnt_data["cnt_wait"]);
	
?>
<!DOCTYPE html>

<html lang="en-us" class="smart-style-6">
<head>
	<title>KOKOFARM MONITOR</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
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
		.tree_view
		{
			position: fixed;
		}
		@media screen and (max-width : 768px){
			.tree_view
			{
				position: relative;
			}
		}

		.ui-jqgrid .ui-jqgrid-bdiv {
			position: relative; 
			margin: 0em; 
			padding:0; 
			overflow-x:hidden; 
			overflow-y:auto; 
		}
	</style>

</head>

<body class="smart-style-6 sa-menu-on-top sa-fixed-header sa-fixed-navigation">
  	<!-- BEGIN .sa-wrapper -->
  	<div class="sa-wrapper">
        
        <header class="sa-page-header">
			<div class="sa-header-container h-100">
				<div class="d-table d-table-fixed h-100 w-100">

					<div class="sa-logo-space d-table-cell h-100">
						<div class="flex-row d-flex align-items-center h-100">
							<a class="sa-logo-link" href="../01_device_mnt/0101.php" title="KOKOFARM"><img alt="KOKOFARM" src="../images/logo.png" class="sa-logo"></a>
						</div>  
					</div>

					<div class="d-table-cell h-100 w-100 align-middle">
						<div class="sa-header-menu">
							<div class="d-flex align-items-center w-100">
								<div class="ml-auto sa-header-right-area">
									<div class="form-inline text-dark font-weight-bold">
										<!-- <button type="button" onClick="change_lang('en')">EN</button> -->
										<i class="glyphicon glyphicon-user"></i><span>&nbsp;&nbsp;<?=$mgr_name?> - <?=$mgr_type?></span>&nbsp;&nbsp;&nbsp;&nbsp;
										<a class="btn-sm text-secondary" href="../00_login/index_action.php?oper=logout" title="logout" role="button">&nbsp;Logout&nbsp;<i class="glyphicon glyphicon-log-out"></i></a>
									</div>
								</div>
							</div>          
						</div>
					</div>

				</div>
			</div>
        </header>	<!-- END .sa-page-header -->

		<!-- BEGIN .sa-page-body -->
		<div class="sa-page-body">
		
			<!-- 메뉴바 -->
			<div class="sa-aside-left">
				<div class="sa-left-menu-outer">
					<!-- 상단메뉴 ul -->
					<ul class="metismenu sa-left-menu float-left" id="menu1">
						<?=$top_menu_html?>
					</ul>
					<!-- 오류표시 ul -->
					<ul class="metismenu sa-left-menu sa-sparks float-right" style="margin-top: revert;">
						<li class="sparks-info">
							<h5 class="text-white">
								<!-- <div><span class="top-info-today font-sm">오늘</span> : <?=date("Y-m-d")?></div> -->
								<div><span class="font-sm"><?=date("Y-m-d")?></span></div>
								<span class="text-white"><i class="fa fa-clock-o text-orange-dark"></i><span class="text-white" id="clock_now" style="display: inline"></span></span>
							</h5>
						</li>
						<li class="sparks-info">
							<h5 class="text-white"><span class="KKF-24 font-sm">입추(동)</span><span class="text-white"><i class="fa fa-home text-orange-dark"></i>&nbsp;<?=$cnt_in?></span></h5>
						</li>
						<li class="sparks-info">
							<h5 class="text-white"><span class="KKF-25 font-sm">오류(동)</span><span class="text-white"><i class="fa fa-check-square text-orange-dark"></i>&nbsp;<?=$cnt_err?></span></h5>
						</li>
						<li class="sparks-info">
							<h5 class="text-white"><span class="KKF-26 font-sm">출하대기(동)</span><span class="text-white"><i class="fa fa-plus-square text-orange-dark"></i>&nbsp;<?=$cnt_wait?></span></h5>
						</li>
						<li class="sparks-info">
							<h5 class="text-white"><span class="KKF-27 font-sm">출하(동)</span><span class="text-white"><i class="fa fa-minus-square text-orange-dark"></i>&nbsp;<?=$cnt_out?></span></h5>
						</li>
					</ul>
				</div>
			</div>

      		<!-- BEGIN .sa-content-wrapper -->
      		<div class="sa-content-wrapper">
        
				<div class="sa-content">
					<div class="d-flex w-75 home-header">

						<!--화면 Title-->
						<div>
							<?=$title_html?>
						</div>

					</div><!--END .d-flex w-100 home-header-->

					<div class="d-flex w-100">
						<section id="widget-grid" class="w-100">

							<!--농장 트리뷰-->
							<article class="col-xl-2 tree_view no-padding" id="treeView" style='display:none;'>
								<div class="col-xl-12 float-left no-padding">
									
									<div class="jarviswidget jarviswidget-color-darken no-padding" id="wid-id-13" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
										<header>
											<div class="widget-header">
												<span class="widget-icon"> <i class="fa fa-list"></i> </span>
												<h2><span class="KKF-28">농가 목록<span></h2>
											</div>
											<div class="widget-toolbar ml-auto" style="cursor: default">
												<span class='badge badge-primary'> </span>&nbsp;<span class="KKF-29">입추</span>
												<span class='badge badge-danger'> </span>&nbsp;<span class="KKF-30">출하</span>
											</div>
										</header>
							
										<div class="widget-body">

											<!--농장 트리뷰 검색필드-->
											<div class="widget-body-toolbar bg-white" style="padding-top:10px; padding-left:20px;">
												<form class="form-inline" id="form_tree_search" role="form" onsubmit="return false;">
													<div class="col-xl-12 input-group">
														<input type="text" class="form-control" name="text_tree_search" placeholder="농장 이름" max-length="20">&nbsp;
														<button type="button" class="btn btn-default btn-sm btn-labeled" id="btn_tree_search" style="margin-top: 1px"><span class="btn-label"><i class="fa fa-search text-primary"></i></span><span class="KKF-31">검색</span></button>
													</div>
												</form>
											</div>

											<div class="custom-scroll table-responsive" style="height: 580px; padding-top: 10px;">

												<!--농장 트리뷰 body 부분-->
												<div class="tree smart-form" id="tree-body" style="margin-left:20px; color:#6c757d;">
													<!-- <ul>
														<li>
															<span class="tree-content" id="KF0006"><i class="fa fa-lg fa-folder-open"></i> 농장 이름</span>
															<ul>
																<li>
																	<span class="tree-content" id="KF0006|01">01 동</span>
																</li>
																<li>
																	<span class="tree-content" id="KF0006|02">02 동</span>
																</li>
																<li>
																	<span class="tree-content" id="KF0006|03">03 동</span>
																</li>
															</ul>
														</li>
													</ul> -->
												</div>  <!-- END #tree smart-form -->
											</div> <!-- END .custom-scroll table-responsive -->
										</div> <!-- END .widget-body -->
									</div> <!-- END .jarviswidget -->
								</div> <!--농장 트리뷰 end-->
							</article>