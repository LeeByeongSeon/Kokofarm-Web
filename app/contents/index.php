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

		<!--Bootstrap Datepicker-->
		<script src="../library/bootstrap_datepicker/bootstrap-datepicker.js" type="text/javascript"></script>
		<link rel="stylesheet" href="../library/bootstrap_datepicker/datepicker.css">

		<!--Bootstrap Clockpicker-->
		<script src="../library/bootstrap_clockpicker/src/clockpicker.js" type="text/javascript"></script>
		<link rel="stylesheet" href="../library/bootstrap_clockpicker/src/clockpicker.css">

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
				<?=$swiperHTML?>
			</div>
		</div>

		<!-- Modal-->
		<!-- <div id="modalPopup" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="top:20%">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h4 id="modalTitle" class="modal-title">Modal title</h4>
					</div>
					<div id="modalBody" class="modal-body">
						<p>One fine body…</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" data-dismiss="modal">닫기</button>
					</div>
				</div>
			</div>
		</div> -->

		<!--confirmModal-->
		<div id="confirmModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog" style="top:20%">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h4 id="confirmModalTitle" class="modal-title" style="font-weight:bold;">Modal title</h4>
					</div>
					<div id="confirmModalBody" class="modal-body">
						<p>body</p>
					</div>
					<div class="modal-footer">
						<form id="confirm_check" onsubmit="return false;">
							<input type="checkbox" style="float:left;" name="invisible" value="">
							<label id="confirmModalCheckLabel" style="position:relative; top:3px; font-size:13px; font-weight:bold; float:left;"></label>
						</form>
						<button type="button" class="btn btn-primary" data-dismiss="modal" id="confirm_ok">확인</button>
						<button type="button" class="btn btn-danger" data-dismiss="modal" id="confirm_cancle">취소</button>
					</div>
				</div><!--modal-content -->
			</div><!--modal-dialog -->
		</div><!--confirmModal -->

	</body>
</html>

<script language="javascript">
	var farmID="";
	var dongID="";
	var	chkInOutCode="";

	var swiper = new Swiper('.swiper-container', {
		slidesPerView: 1,
		spaceBetween: 20,
		loop: false,
		/*autoHeight:true,*/
		init:false,
		initialSlide:0
	});

	$(document).ready(function(){
		swiper.init();
	});


	//swiper 최초시작 이벤트
	swiper.on('init', function() {	pageLoader();	});
	//swiper change 이벤트
	swiper.on('slideChange',function(){	pageLoader();	});


	//해당 페이지 호출
	function pageLoader(){
		var selectMenu=$(".menu-block > ul > li").eq(swiper.realIndex).find("a");	//선택한 메뉴
		selectMenu.trigger('click');

		var farmID=selectMenu.attr("data-farmID");			   //농장ID
		var dongID=selectMenu.attr("data-dongID");			   //동ID
		var chkInOutCode=selectMenu.attr("data-chkInOutCode"); //입추코드
		var addURL="?farmID=" + farmID + "&dongID=" + dongID + "&chkInOutCode=" + chkInOutCode;

		//입추인 경우
		if(farmID!=="" && dongID!=="" && chkInOutCode!==""){
			if(dongID==="None" && chkInOutCode==="search"){
				$(".swiper-slide [id]").prop('id','newId');//ID변경
				$(".swiper-slide").eq(swiper.realIndex).load("search.php" + addURL);	//출하내역 검색
			}
			else{
				$(".swiper-slide [id]").prop('id','newId');//ID변경
				$(".swiper-slide").eq(swiper.realIndex).load("chkin.php" + addURL);
			}
		}
		//출하인 경우
		if(farmID!=="" && dongID!=="" && chkInOutCode===""){
			$(".swiper-slide [id]").prop('id','newId');//ID변경
			$(".swiper-slide").eq(swiper.realIndex).load("chkout.php" + addURL);
		}
		//잘못된 ID/PW인 경우
		if(farmID==="" && dongID==="" && chkInOutCode===""){
			$(".swiper-slide").eq(swiper.realIndex).load("wrong.html");
		}

	}


	$(".menu-block ul li").click(function(){
		$(".menu-block ul li a").removeClass("on");
		$(this).find("a").addClass("on");
		//location.reload(); //화면새로고침
		if($(this).prev().offset()){
			$('.menu-block ul').animate({scrollLeft : ($('.menu-block ul').scrollLeft()+$(this).prev().offset().left)}, 400);
		}else{
			$('.menu-block ul').animate({scrollLeft : 0}, 400);
		}
		swiper.slideTo( $(this).index() );
	});



	

</script>


