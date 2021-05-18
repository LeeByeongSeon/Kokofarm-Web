<?
	include_once("../common/common_func.php");
	
	$userID=chkCHAR($_REQUEST["userID"]);
	$userPW=chkCHAR($_REQUEST["userPW"]);

	//01-유효한 ID/PW인지를 확인
	$strSql="SELECT fFarmid,fName FROM farm WHERE fID='$userID' AND fPW='$userPW'";
	$getData=multiFindData($strSql,localDB_Conn);

	$farmID=$getData[0]["fFarmid"];	//농장ID
	$farmNAME=$getData[0]["fName"];	//농장명

	if(!empty($farmID)){
		$strSql="SELECT fdFarmid, fdDongid, fdName FROM farm_detail WHERE fdFarmid='$farmID'"; 
		$getData=multiFindData($strSql,localDB_Conn);
		foreach($getData as $Val){
			$strSql="SELECT cmCode,IFNULL(DATEDIFF(current_date(),cmIndate)+1,0) as inTERM
					 FROM comein_master
					 WHERE cmFarmid='" . $Val["fdFarmid"] . "' AND cmDongid='" . $Val["fdDongid"] . "' AND IFNULL(LENGTH(cmIndate),0)>=4 AND IFNULL(LENGTH(cmOutdate),0)<=4";
			$chkData=multiFindData($strSql,localDB_Conn);
			$cmCode=$chkData[0]["cmCode"];
			$inTERM=$chkData[0]["inTERM"];
			
			if(!empty($cmCode) && !empty($inTERM)) {
				$menuHTML .="<li><a data-farmID='" . $Val["fdFarmid"] . "' data-dongID='" . $Val["fdDongid"] . "' data-chkInOutCode='" . $cmCode . "'>" . $Val["fdName"] . " <span class='interm-num'><span class='inTREM'>" . $inTERM . "</span>일</sapn></a></li>";
				$swiperHTML .="<div class='swiper-slide'></div>";
			}
			else{
				$menuHTML .="<li><a data-farmID='" . $Val["fdFarmid"] . "' data-dongID='" . $Val["fdDongid"] . "' data-chkInOutCode=''>" . $Val["fdName"] . " <span class='interm-num' style='background:gray'>출하</span></a></li>";
				$swiperHTML .="<div class='swiper-slide'></div>";
			}
		}
		//추가메뉴
		$menuHTML .="<li><a data-farmID='" . $Val["fdFarmid"] . "' data-dongID='None' data-chkInOutCode='search'>출하내역 <span class='interm-num'>검색</sapn></a></li>";
		$swiperHTML .="<div class='swiper-slide'></div>";
	}
	else{
		$menuHTML .="<li><a data-farmID='' data-dongID='' data-chkInOutCode=''>1동</a></li>
					 <li><a data-farmID='' data-dongID='' data-chkInOutCode=''>2동</a></li>
					 <li><a data-farmID='' data-dongID='' data-chkInOutCode=''>3동</a></li>";
		$swiperHTML ="<div class='swiper-slide'>slide1</div>
			 		  <div class='swiper-slide'>slide2</div>
					  <div class='swiper-slide'>slide3</div>";
	}
?>

<!DOCTYPE html>
<html lang="ko">
	<head>
		<meta charset="utf-8">
		<title>꼬꼬팜 :: KOKOFARM4</title>
		<meta name="description" content="">
		<meta name="author" content="">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
		
		<!-- #CSS Links -->
		<!-- Basic Styles -->
		<link rel="stylesheet" type="text/css" media="screen" href="../library/bootstrap/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" media="screen" href="../library/fonts/font-awesome.min.css">


		<!-- #FAVICONS -->
		<link rel="shortcut icon" href="../images/icon.png" type="image/x-icon">
		<link rel="icon" href="../images/icon.png" type="image/x-icon">


		<!-- smartadmin Styles : Caution! DO NOT change the order -->
		<link rel="stylesheet" type="text/css" media="screen" href="../library/smartadmin/smartadmin-production-plugins.min.css">
		<link rel="stylesheet" type="text/css" media="screen" href="../library/smartadmin/smartadmin-production.min.css">
		<link rel="stylesheet" type="text/css" media="screen" href="../library/smartadmin/smartadmin-skins.min.css">

		<!-- JQuery + Bootstrap -->
		<script src="../library/jquery/jquery.min.js"></script>					<!-- jQuery -->
		<script src="../library/jquery/jquery-ui-1.10.3.min.js"></script>			<!-- jQuery UI-->
		<script src="../library/bootstrap/bootstrap.min.js"></script>				<!-- BOOTSTRAP JS -->

		<!--Bootsteap Table-->
		<link rel="stylesheet" href="../library/bootstrap_table/bootstrap-table.css"/>
		<script src="../library/bootstrap_table/bootstrap-table.js"></script>

		<!--amChart-->
		<script src="../library/amchart/amcharts.js" type="text/javascript"></script>
		<script src="../library/amchart/serial.js" type="text/javascript"></script>
		<script src="../library/amchart/lang/ko.js" type="text/javascript"></script>

		<!--swiper-->
		<script src="../library/swiper/swiper.min.js"></script>
		<link rel="stylesheet" href="../library/swiper/swiper.min.css"/>


		<!-- myDefined JS+CSS -->
		<script src="../library/my_define/my_define.js"></script>					<!-- my Defined JS-->
		<link rel="stylesheet" href="../library/my_define/my_define.css"/>		    <!-- my Defined CSS-->
	</head>
	<body>

		<header class="navbar-fixed-top">
			<div class="top-block">
				<img src="../images/logo2.png">
				<span class='label label-default' style='position:absolute;top:26px;left:160px'>ver 5.5</span>
				<p class="pull-right" style="padding-top:12px"><?=$farmNAME?></p>
			</div>
			<div class="top-menu">
				<div class="menu-block">
					<ul>
						<?=$menuHTML?>
					</ul>
				</div>
			</div>
		</header>

		<div class="swiper-container">
			<div class="swiper-wrapper">


				<!--공사중-->
				<div class="col-xs-12" style="margin-top:40px">
					<div class="jarviswidget jarviswidget-color-green" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-togglebutton="false">
						<header>
							<span class="widget-icon"> <i class="fa fa-bar-chart-o"></i> </span>
							<h2>공사중 안내</h2>
						</header>
						<div class="widget-body">
							<div class="row">
								<div class="col-xs-12">
									<center>
									<h1>서버 업데이트 공사중</h1>

									<h5>기간 : 2021.02.04(목) ~ 02.08(월)</h5>
									<h5>이용에 불편을 드려 죄송합니다.</h5>
									<h5>기존 상태를 유지 부탁드립니다.</h5>
									</center>
								</div>
							</div>
						</div><!--widget-body-->
					</div><!--widget-->
				</div><!--col-xs-12-->

			</div>
		</div>


	</body>
</html>



