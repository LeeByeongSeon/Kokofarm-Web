<?
	include_once("../common/common_func.php");

	$farmID=chkCHAR($_REQUEST["farmID"]);	//농장ID
	$dongID=chkCHAR($_REQUEST["dongID"]);	//동ID
	$chkInOutCode=chkCHAR($_REQUEST["chkInOutCode"]); //입추코드
?>
	<style>
		#cameraIcon {
				position:absolute;
				max-width:100%; max-height:100%;
				width:auto; height:auto;
				margin:auto;
				top:0; bottom:0; left:0; right:0;
		}
	</style>

	<!--요약자료--->
	<div class="row">
		<div class="col-xs-12">
			<div class="well">
				<div class="col-xs-3 no-padding" style="text-align:center;">
					<img class="henImage" src="../images/block-icon-scale1.png" width="80px" height="90px">
					<div style="position:absolute;top:30px;color:white;font-size:20px;width:100%;"><span id="summaryInterm">0</span>일</div>
				</div>
				<div class="col-xs-5 no-padding" style="text-align:center;">
					<font style="font-size:20px">현재평균중량</font><br>
					<p style="padding-top:10px;font-size:38px" class="text-danger slideInRight fast animated"><strong><span id="summaryAvgWeight">0</span></strong></p>
				</div>
				<div class="col-xs-4 no-padding" style="font-size:18px">
					<div class="pull-right" style="text-align:right">
						표준편차<br><span id="summaryDevi">0</span><br>
						변이계수<br><span id="summaryVc">0</span>
					</div>
				</div>
				<div style="clear:both"></div>
			</div><!--well-->
		</div><!--col-xs-12-->
	</div><!--row--->

	<div class="row" style="padding-top:-10px">
		<div class="col-xs-12">
			<div class="jarviswidget jarviswidget-color-purple" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-togglebutton="false">
				<header>
					<span class="widget-icon"> <i class="fa fa-align-justify"></i> </span>
					<h2>출하상태</h2>
				</header>
				<div class="widget-body">
					<div style="width:100%;text-align:center;font-size:20px">
						<p style='color:red'>출하상태</p>
						<p>현재 출하된 동입니다.</p>
						<p>화면이 지속되면 관리자에게 문의 바랍니다.</p>			
					</div>
				</div><!--widget-body-->
			</div><!--widget-->
		</div><!--col-xs-12-->

		
		<!--IP 카메라 -->
		<div class="col-xs-12" style="margin-top:-10px">
			<div class="jarviswidget jarviswidget-color-purple" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-togglebutton="false">
				<header>
					<span class="widget-icon"> <i class="fa fa-camera"></i> </span>
					<h2>IP 카메라</h2>
				</header>
				<div class="widget-body">
					<div class="row">
						<div class="col-xs-12">
							<img id="cameraDIV" src="../images/noimage.jpg" onError=" $(this).attr('src','../images/noimage.jpg'); $('#cameraIcon').hide(); " onClick="cameraClose();" width="100%">
							<img id="cameraIcon" src="../images/play.png" class="fadeIn animated" onClick="cameraPlayBtn();">
						</div>
					</div>
				</div><!--widget-body-->
			</div><!--widget-->
		</div><!--col-xs-12-->


	</div><!--row-->



<script language="javascript">

	$(document).ready(function(){
		cameraImg.onload="";  //카메라 종료
		$("html, body").animate({scrollTop :0}, 0); //페이지를 상단으로 올림
		getData("<?=$farmID?>","<?=$dongID?>","<?=$chkInOutCode?>");
	});


	function getData(farmID,dongID,chkInOutCode){
		var dataArr={}; dataArr['oper']="chkOut"; dataArr['farmID']=farmID; dataArr['dongID']=dongID;  dataArr['chkInOutCode']=chkInOutCode;
		$.ajax({url:'common_action.php',data:dataArr,cache:false,type:'post',dataType:'json',
			success: function(data) {

				//카메라 URL 받아오기
				$("#cameraDIV").attr("src",data.cameraURL);
			}
		});
	}

	//카메라 구동
	function cameraPlayBtn(){
		var imgURL=$("#cameraDIV").attr("src");
		$("#cameraIcon").hide();
		cameraStart(imgURL);
	}

	function cameraClose(){
		cameraImg.onload="";
		$("#cameraIcon").show();
		return false;
	}

</script>
