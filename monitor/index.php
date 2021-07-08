<!DOCTYPE html>
<html>
<head>
<title>KOKOFARM RENEWAL</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  	<link rel="stylesheet" href="../../common/library/fonts/font.css"> <!--Google fonts-->
	
	<script src="../common/library/jquery/jquery.min.js"></script>						<!-- jQuery -->
	<script src="../common/library/jquery/jquery-ui-1.10.3.min.js"></script>				<!-- jQuery UI-->
	<script src="../common/library/bootstrap/bootstrap.min.js"></script>					<!-- BOOTSTRAP JS -->
	<script src="../common/library/smartwidgets/jarvis.widget.min.js"></script>			<!-- JARVIS WIDGETS -->
	
	<!-- BOOTSTRAP CSS -->
	<link rel="stylesheet" type="text/css" media="screen" href="../common/library/bootstrap/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" media="screen" href="../common/library/fonts/font-awesome.min.css"> 

	<!--common-->
	<script src="../common/js_module/common_func.js"></script>

	<style>
	body
	{
		font-family: 'NanumSquare', sans-serif;
		background-color: #E8E6E6;
	}
	#loginArea
	{
		position:absolute;
		top:25%;
		left:27%;
		width:45%;
		height:297px;
		background-color: white;
		border-radius: 20px;
	}
	#loginLogo
	{
		position:absolute;
		top:18.5%;
		left:26.5%;
	}
	#loginImg
	{
		float:left;
		width:350px;
		height: inherit;
		background-image: url(./images/img_expected01.jpg);
		background-repeat: no-repeat;
		border-radius: 20px 0px 0px 20px;
	}
	#login_form
	{
		float:right;
		width:350px;
		height: inherit;
		margin-right: 85px;
		margin-top:5px;
		padding:15px;
	}
	#login_form font
	{
		font-size: 17px;
		color:#7C7A7A;
	}
	#login_form h1
	{
		font-weight: bold;
		color:orange;
	}
	a:link{color:orange;text-decoration: none;}
	a:visited{ color: gray; text-decoration: none;}
	a:hover{ color: orange; text-decoration: none;}
	#login_form button
	{
		float:right;
		width:320px;
	}
	#loginFooter
	{
		clear:both;
	}
	#loginFooter p
	{
		font-size:13px;
		color:gray;
	}
	input[type=password] 
	{
		font-family: "Geogia";
		&::placeholder {font-family: "NanumSquare";}
	}
	@media screen and (max-width:787px)
	{
		#loginLogo
		{
			margin:auto;
		}
		#loginArea
		{
			margin: auto;
			left:15%;
			width:70%;
			height:250px;
			border-radius: 10px;
		}
		#loginImg
		{
			display: none;
		}
		#login_form
		{
			margin: 5px 0px 0px 0px;
		}
	}
	</style>
</head>
<body>
	<img src="./images/logo.png" id="loginLogo" class="animate__animated animate__fadeIn">
	<div id="loginArea" class="animate__animated animate__fadeIn">
		<div id="loginImg">

		</div><!--loginImg-->
		<div id="login_form">
			<h1>Login&nbsp;<font>[육계 - 생육관제 V3.0]</font></h1>
			<p><input class="form-control" name="id" type="text" placeholder="아이디" maxlength="20" size="20"></p>
			<p><input class="form-control" name="pw" type="password" placeholder="비밀번호" maxlength="20" size="20"></p>
			<button class="btn btn-success" type="button" id="btn_login">로그인</button><br><br>
			<p><a href="">kokoFarm 홈페이지</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="">보고서 버전으로 가기</a></p>
		</div><!--login_form-->
		<div id="loginFooter">
			<p>kokoFarm : 계사 생육관제 모니터링 시스템<br>Copyright© 2019 EMOTION Co., Ltd. All rights reserved.</p>
		</div><!--loginFooter-->
	</div><!--loginArea-->

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

</body>
</html>

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