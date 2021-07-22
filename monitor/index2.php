<!DOCTYPE html>

<html lang="en-us" class="smart-style-6">
<head>
	<title>KOKOFARM RENEWAL</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  	<!--<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,500,700">-->
  	<link rel="stylesheet" href="../common/library/fonts/font.css"> <!--Google fonts-->
	
	<script src="../common/library/jquery/jquery.min.js"></script>						<!-- jQuery -->
	<script src="../common/library/jquery/jquery-ui-1.10.3.min.js"></script>				<!-- jQuery UI-->
	<script src="../common/library/bootstrap/bootstrap.min.js"></script>					<!-- BOOTSTRAP JS -->
	<script src="../common/library/smartwidgets/jarvis.widget.min.js"></script>			<!-- JARVIS WIDGETS -->
	<script src="../common/library/plugin/sparkline/jquery.sparkline.min.js"></script>	<!-- SPARKLINES -->
	
	<!-- FAVICONS -->
	<link rel="shortcut icon" href="./images/icon.png" type="image/x-icon">
	<link rel="icon" href="./images/icon.png" type="image/x-icon">
	
	<!-- BOOTSTRAP CSS -->
	<link rel="stylesheet" type="text/css" media="screen" href="../common/library/bootstrap/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" media="screen" href="../common/library/fonts/font-awesome.min.css">

	<!-- myDefined JS-->
	<link rel="stylesheet" type="text/css" href="../common/library/my_define/my_define.css">

	<!--Template CSS-->
	<link rel="stylesheet" media="screen, print" href="../common/library/vendors/vendors.bundle.css">
	<link rel="stylesheet" media="screen, print" href="../common/library/app/app.bundle.css">
	<link rel="stylesheet" type="text/css" href="../common/library/pages/homepage.css">
	<link rel="stylesheet" type="text/css" href="../common/library/pages/forms.css">
	<link rel="stylesheet" type="text/css" href="../common/library/pages/buttons.css">

	<!--common-->
	<script src="../common/js_module/common_func.js"></script>

</head>
<body>

	<div class="sa-wrapper">
		<div class="sa-page-body">
			<div class="sa-content-wrapper">
				<div class="d-flex w-100 justify-content-center">
					<div class="col-md-6 no-padding no-margin rounded-lg bg-white justify-content-center">
						<div class="card">
							<div class="row no-gutters">
								<div class="col-md-5">
								<img src="./images/img_expected01.jpg" class="card-img" alt="kokoFarm">
								</div>
								<div class="col-md-2"></div>
								<div class="col-md-5 mt-5">
									<div class="card-body" sytle="border: 0;">
										<h1 class="card-title text-warning"><i>Login</i>&nbsp;<small>[육계 - 생육관제 V3.0]</small></h1>
										<input class="form-control" name="id" placeholder="아이디" maxlength="20" size="20" type="text">
										<input class="form-control" name="pw" placeholder="비밀번호" maxlength="20" size="20" type="password">
										<button class="btn btn-success w-100" id="btn_login"> 로그인 </button>
										<p><small><a class="text-secondary" href="http://kokofarm.co.kr" target="_blank"><i class="fa fa-angle-double-right"></i> kokoFarm 홈페이지</a></small></p>
										<p><small><a class="text-secondary" href="http://report.kokofarm.co.kr" target="_blank"><i class="fa fa-angle-double-right"></i> 보고서 버전으로 이동</a></small></p>
									</div>
								</div>
							</div>
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

	
	<footer class="sa-page-footer"> <!-- BEGIN .sa-page-footer -->
		<div class="d-flex align-items-center w-100 h-100">
			<div class="footer-left">
				<span class="txt-color-white">KOKOFARM <span class="hidden-xs"> : 계사 생육관제 모니터링 시스템 Copyright</span> © 2019 EMOTION Co., Ltd. All rights reserved.</span>
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
							popup_alert("오류", "통신오류입니다.<br>다시 시도해 주시기 바랍니다");
							break;
						case "error":
							$("#login_form [name=id]").val("");
							$("#login_form [name=pw]").val("");
							popup_alert("오류","아이디 또는 비밀번호가 틀립니다.<br>다시 시도해 주시기 바랍니다.");
							break;

						case "ok":
							window.location = data.url;
							break;
					}
				}
			});
			return false;
		});
	});

</script>