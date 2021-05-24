<!DOCTYPE html>
<html>
<head>
	<title>kokofarm 예시-[로그인]</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<style>
@import url(https://cdn.jsdelivr.net/gh/moonspam/NanumSquare@1.0/nanumsquare.css);
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
#loginForm
{
	float:right;
	width:350px;
	height: inherit;
	margin-right: 85px;
	margin-top:5px;
	padding:15px;
}
#loginForm font
{
	font-size: 17px;
	color:#7C7A7A;
}
#loginForm h1
{
	font-weight: bold;
	color:orange;
}
a:link{color:orange;text-decoration: none;}
a:visited{ color: gray; text-decoration: none;}
a:hover{ color: orange; text-decoration: none;}
#loginForm button
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
	#loginForm
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
		<div id="loginForm">
			<h1>Login&nbsp;<font>[육계 - 생육관제 V3.0]</font></h1>
			<p><input class="form-control" type="text" placeholder="아이디" maxlength="20" size="20" required></p>
			<p><input class="form-control" type="password" placeholder="비밀번호" maxlength="20" size="20" required></p>
			<button class="btn btn-success" type="button" onclick="location.href='./01_summary/0101.php'">로그인</button><br><br>
			<p><a href="">kokoFarm 홈페이지</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="">보고서 버전으로 가기</a></p>
		</div><!--loginForm-->
		<div id="loginFooter">
			<p>kokoFarm : 계사 생육관제 모니터링 시스템<br>Copyright© 2019 EMOTION Co., Ltd. All rights reserved.</p>
		</div><!--loginFooter-->
	</div><!--loginArea-->
</body>
</html>