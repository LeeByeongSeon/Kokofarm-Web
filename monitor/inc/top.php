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
		//장치 현황
		array("01_device_mnt", "0101.php", "장치현황", "요약 현황", "Y", "fa fa-lg fa-fw fa-home"),
		array("01_device_mnt", "0102.php", "장치현황", "동별 세부 현황", "", ""),
		array("01_device_mnt", "0103.php", "장치현황", "IP 카메라 현황", "", ""),
		
		//농장 현황
		array("02_farm_mnt", "0201.php", "농장현황", "입출하 관리", "Y", "fa fa-lg fa-fw fa-bar-chart-o"),
		array("02_farm_mnt", "0202.php", "농장현황", "전국 농장 현황", "", ""),
		array("02_farm_mnt", "0203.php", "농장현황", "동별 세부 현황", "", ""),
		array("02_farm_mnt", "0204.php", "농장현황", "출하이력", "", ""),
		array("02_farm_mnt", "0205.php", "농장현황", "재산출 요청 관리", "", ""),
		array("02_farm_mnt", "0206.php", "농장현황", "결함 및 A/S 관리", "", ""),
		
		//계정 관리
		array("03_account_mgr", "0301.php", "계정관리", "농장 계정 관리", "Y", "fa fa-lg fa-fw fa-group"),
		array("03_account_mgr", "0302.php", "계정관리", "농장별 동 관리", "", ""),
		array("03_account_mgr", "0303.php", "계정관리", "관리자 계정 관리", "", ""),
		
		//장치 관리
		array("04_device_mgr", "0401.php", "장치관리", "IoT 저울 관리", "Y", "fa fa-lg fa-fw fa-video-camera"),
		array("04_device_mgr", "0402.php", "장치관리", "IP 카메라 관리", "", ""),
		array("04_device_mgr", "0403.php", "장치관리", "PLC 관리", "", ""),
		array("04_device_mgr", "0404.php", "장치관리", "급이/급수/외기 관리", "", ""),

		//옵션 관리
		array("05_option_mgr", "0501.php", "옵션관리", "상세 옵션 관리", "Y", "fa fa-lg fa-fw fa-cog"),
		array("05_option_mgr", "0502.php", "옵션관리", "PLC Unit ID 관리", "", ""),
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
					$top_menu_html .= " <a class='has-arrow' href='#'><span class='" .$value[5]. "'></span><span class='menu-item-parent'>" .$value[2]. "</span></a>";
					$top_menu_html .= "   <ul aria-expanded='true' class='sa-sub-nav collapse'>";
				}
				else{
					$top_menu_html .= "<li class=''>";
					$top_menu_html .= " <a class='has-arrow' href='#'><span class='" .$value[5]. "'></span><span class='menu-item-parent'>" .$value[2]. "</span></a>";
					$top_menu_html .= "   <ul aria-expanded='true' class='sa-sub-nav collapse'>";
				}

				//서브메뉴 for문
				for($i=0; $i<=count($menu_struct)-1; $i++){
					if($menu_struct[$i][0]==$value[0]){
						if($depth_1_url==$menu_struct[$i][0] && $depth_2_url==$menu_struct[$i][1]){
							$top_menu_html .= "<li class='active'><a href='javascript:void(0)' onClick=\" location.href='../" . $menu_struct[$i][0] . "/" . $menu_struct[$i][1] . "' \">". $menu_struct[$i][3] ."</a></li>";
						}
						else{
							$top_menu_html .= "<li class=''><a href='javascript:void(0)' onClick=\" location.href='../" . $menu_struct[$i][0] . "/" . $menu_struct[$i][1] . "' \">" . $menu_struct[$i][3] . "</a></li>";
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
			$title_html .= "<h4 class='page-header'><i class='fa-fw fa fa-th-list'></i> " .$value[2]. "<span style='color:#455a64'> <i class='fa-fw fa fa-angle-right'></i> <b>" .$value[3]. "</b></span></h4>";
		}
	}
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
									<div class="form-inline text-secondary">
										<spa><i class="glyphicon glyphicon-user"></i></i>&nbsp;&nbsp;<?=$mgr_name?> - <?=$mgr_type?></span>&nbsp;&nbsp;&nbsp;&nbsp;
										<a class="btn-sm text-secondary" href="../00_login/index_action.php?oper=logout" title="logout" role="button"> Logout <i class="glyphicon glyphicon-log-out"></i></a>
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
							<h5>
								<div id="clockDate">오늘 : 2021-07-28</div>
								<span id="clockTime" class="text-secondary"><i class="fa fa-clock-o"></i>&nbsp;11:20:45</span>
							</h5>
						</li>
						<li class="sparks-info">
							<h5> 입추(수) <span class="text-blue"><i class="fa fa-plus-square"></i>&nbsp;<?=number_format($inSU)?></span></h5>
						</li>
						<li class="sparks-info">
							<h5> 폐사(수) <span class="text-red"><i class="fa fa-minus-square"></i>&nbsp;<?=number_format($deathSU)?></span></h5>
						</li>
						<li class="sparks-info">
							<h5> 생존(수) <span class="text-green-dark"><i class="fa fa-pencil-square"></i>&nbsp;<?=number_format($remainSU)?></span></h5>
						</li>
						<li class="sparks-info">
							<h5> 입추동(수) <span class="text-blue-dark"><i class="fa fa-home"></i>&nbsp;<?=number_format($inCntSU)?></span></h5>
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
												<h2>농가 목록 </h2>
											</div>
											<div class="widget-toolbar ml-auto" style="cursor: default">
												<span class='badge bg-green'>&nbsp;</span>&nbsp;입추
												<span class='badge bg-gray'>&nbsp;</span>&nbsp;출하
											</div>
										</header>
							
										<div class="widget-body">

											<!--농장 트리뷰 검색필드-->
											<div class="widget-body-toolbar bg-white" style="padding-top:10px; padding-left:20px;">
												<form class="form-inline" id="form_tree_search" role="form" onsubmit="return false;">
													<div class="input-group">
														<input type="text" class="form-control" name="text_tree_search" placeholder="농장 이름" max-length="20">&nbsp;
														<button type="button" class="btn btn-primary btn-sm btn-labeled" id="btn_tree_search" style="margin-top: 1px"><span class="btn-label"><i class="fa fa-search"></i></span>검색</button>
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