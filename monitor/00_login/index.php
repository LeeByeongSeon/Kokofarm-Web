<?
$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'],0,2);

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

	<!--Template CSS-->
	<link rel="stylesheet" media="screen, print" href="../common/library/vendors/vendors.bundle.css">
	<link rel="stylesheet" media="screen, print" href="../common/library/app/app.bundle.css">

	<!--common-->
	<script src="../common/js_module/common_func.js"></script>
<style>
	@media screen and (max-width:767px){
		.logo_img{
			margin: auto;
		}
	}
</style>
</head>
<body>

	<div class="sa-wrapper">
		<div class="sa-page-body">
			<div class="sa-content-wrapper">
				<div class="d-flex flex-column-reverse w-100 h-50 align-items-center">
					<div class="row w-100 justify-content-center">
						<div class="d-flex col-xl-5 bg-white no-padding fadeIn animated align-items-center" style="border-radius: 20px">
							<div class="col-xl-5 no-padding d-none d-xl-block">
								<img class="img-reponsive" src="../images/img_expected01.jpg" style="border-radius: 20px 0 0 20px;" alt="코코팜">
								<!-- <div class="carousel-caption"><img src="./images/logo.png" style="padding-bottom: 50px; margin-left: 50px;"></div> -->
							</div>
							<div class="col-xl-7 p-3" id="login_form">
								<table class="w-75 m-auto">
									<tr><td><h1 class="font-weight-bold text-orange"><span class="KKF-195">로그인</span> <small> [<span class="KKF-196">육계 - 생육관제 v3.0</span>]</small></h1></td></tr>
									<tr><td><input class="form-control mb-2" type="text"     name="id" placeholder=" 아이디"   maxlength="20" size="20" onkeyup="login_enter()"></td></tr>
									<tr><td><input class="form-control mb-2" type="password" name="pw" placeholder=" 비밀번호" maxlength="20" size="20" onkeyup="login_enter()"></td></tr>
									<tr><td><button class="btn btn-success w-100 mb-2" id="btn_login" type="submit"><i class="glyphicon glyphicon-log-in"></i>&nbsp;&nbsp;<span class="KKF-195">로그인</span>&nbsp;&nbsp;</button></td></tr>
									<tr><td><a class="text-secondary" href="http://kokofarm.co.kr" target="_blank"><i class="fa fa-angle-double-right"></i> <span class="KKF-197">kokoFarm 홈페이지</span></a></td></tr>
								</table>
							</div>
						</div>
					</div>
					<div class="row w-100 justify-content-center">
						<div class="col-xl-5 no-padding">
							<img class="img-reponsive logo_img" src="../images/logo.png" alt="코코팜">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!--Modal Alert-->
	<div id="modal_alert" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="top:20%">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 id="modal_alert_title" class="modal-title float-right">Modal title</h4>
					<button type="button" class="close float-left" data-dismiss="modal" aria-hidden="true">×</button>
				</div>
				<div id="modal_alert_body" class="modal-body">
					<p>One fine body…</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" data-dismiss="modal">닫기</button>
				</div>
			</div><!--modal-content -->
		</div><!--modal-dialog -->
	</div><!--modal -->
	
	<footer class="border-top border-warning sa-page-footer bg-white"> <!-- BEGIN .sa-page-footer -->
		<div class="d-flex align-items-center w-100 h-100">
			<div class="footer-left">
				<span class="text-secondary">KOKOFARM <span class="hidden-xs"> : <span class="KKF-198">계사 생육관제 모니터링 시스템 Copyright</span></span> © 2019 EMOTION Co., Ltd. All rights reserved.</span>
			</div>
		</div>
	</footer> <!-- END .sa-page-footer -->

</body>
</html>

<script src="../common/library/vendors/vendors.bundle.js"></script>
<script src="../common/library/app/app.bundle.js"></script>

<script language="javascript">

	$(document).ready(function(){

		$("#btn_login").click(function() {
			var data_arr = {}; 
			data_arr['oper'] = "login";
			data_arr['id'] = $("#login_form [name=id]").val();
			data_arr['pw'] = $("#login_form [name=pw]").val();

			$.ajax({url:'index_action.php', data:data_arr, cache:false, type:'post', dataType:'json',
				success: function(data) {
					switch(data.msg){
						default:
							popup_alert("로그인 실패", "아이디 또는 비밀번호가 틀립니다.<br>다시 시도해 주시기 바랍니다.");
							break;
						case "error":
							$("#login_form [name=id]").val("");
							$("#login_form [name=pw]").val("");
							popup_alert("로그인 실패", "아이디 또는 비밀번호가 틀립니다.<br>다시 시도해 주시기 바랍니다.");
							break;

						case "ok":
							window.location = data.url;
							break;
					}
				}
			});
			return false;
		});

		change_lang(curr_lang);

	});

	// enter 누르고 로그인
	function login_enter(){
		if(window.event.keyCode == 13){
			var data_arr = {}; 
			data_arr['oper'] = "login";
			data_arr['id'] = $("#login_form [name=id]").val();
			data_arr['pw'] = $("#login_form [name=pw]").val();

			$.ajax({url:'index_action.php', data:data_arr, cache:false, type:'post', dataType:'json',
				success: function(data) {
					switch(data.msg){
						default:
							popup_alert("로그인 실패", "아이디 또는 비밀번호가 틀립니다.<br>다시 시도해 주시기 바랍니다.");
							break;
						case "error":
							$("#login_form [name=id]").val("");
							$("#login_form [name=pw]").val("");
							popup_alert("로그인 실패","아이디 또는 비밀번호가 틀립니다.<br>다시 시도해 주시기 바랍니다.");
							break;

						case "ok":
							window.location = data.url;
							break;
					}
				}
			});
			return false;
		}
	}

	var get_lang = get_lang().split("-"); // ko-KR
	var curr_lang = get_lang[0];		  // ko
	
	// 현재 local language 가져옴
	function get_lang(){
		return navigator.language || navigator.userLanguage;
	}

	// 번역
	function change_lang(lang){
		$.getJSON("../common/kkf_lang/KKF_lang.json", function(data){
			$.each(data, function(idx, obj){
				switch(lang){
					case "ko" :
						$("."+idx).html(obj.KR);
						break;
					case "en" :
						$("."+idx).html(obj.EN);
						break;
				}
			})
		});
	}

</script>