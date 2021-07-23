<?
include_once("../inc/top.php")
?>

<!--현재 외기환경 센서정보-->	
<div class="row" id="">
	<div class="col-xs-12">
		<div class="jarviswidget jarviswidget-color-white no-padding" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">							
			<header style="border-radius: 10px 10px 0 0">
				<div class="widget-header">	
					<h2 class="font-weight-bold text-primary sensor"><i class="fa fa-info-circle text-warning"></i>&nbsp;&nbsp;현재 외기환경 센서 정보</h2>	
				</div>
			</header>
			<div class="widget-body shadow" style="border-radius: 0 0 10px 10px; padding:1rem">
				<div class="col-xs-6">
					<div class="col-xs-3 no-padding text-center text-danger"><img src="../images/temp.png" style="width: 1rem;"><br><span></span></div>
					<div class="col-xs-9 no-padding text-right">온도(℃)<br><span id="" style="font-size:28px">0</span></div>
					<div style="clear:both"></div><hr style="margin-top:0px">
				</div>
				<div class="col-xs-6">
					<div class="col-xs-3 no-padding text-center"><img src="../images/drop.png" style="width: 4rem;"><br><span></span></div>
					<div class="col-xs-9 no-padding text-right">습도(％)<br><span id="" style="font-size:28px">0</span></div>
					<div style="clear:both"></div><hr style="margin-top:0px">
				</div>
				<div class="col-xs-6">
					<div class="col-xs-4 no-padding text-center"><img src="../images/nh3.png" style="width: 5rem;"><br><span></span></div>
					<div class="col-xs-8 no-padding text-right">암모니아(ppm)<br><span id="" style="font-size:28px">0</span></div>
					<div style="clear:both"></div><hr style="margin-top:0px">
				</div>
				<div class="col-xs-6">
					<div class="col-xs-3 no-padding text-center"><img src="../images/h2s.png" style="width: 5rem;"><br><span></span></div>
					<div class="col-xs-9 no-padding text-right">황화수소(ppm)<br><span id="" style="font-size:28px">0</span></div>
					<div style="clear:both"></div><hr style="margin-top:0px">
				</div>
				<div class="col-xs-6">
					<div class="col-xs-4 no-padding text-center"><img src="../images/pm10.png" style="width: 10rem;"><br><span></span></div>
					<div class="col-xs-8 no-padding text-right">미세먼지(㎍/㎥)<br><span id="" style="font-size:28px">0</span></div>
					<div style="clear:both"></div><hr style="margin-top:0px">
				</div>
				<div class="col-xs-6">
					<div class="col-xs-4 no-padding text-center"><img src="../images/pm2.5.png" style="width: 10rem;"><br><span></span></div>
					<div class="col-xs-8 no-padding text-right">초미세먼지(㎍/㎥)<br><span id="" style="font-size:28px">0</span></div>
					<div style="clear:both"></div><hr style="margin-top:0px">
				</div>
				<div class="col-xs-6">
					<div class="col-xs-3 no-padding text-center"><img src="../images/wind-direction.png" style="width: 6rem;"><br><span></span></div>
					<div class="col-xs-9 no-padding text-right">풍향<br><span id="" style="font-size:28px">0</span></div>
					<div style="clear:both"></div>
				</div>
				<div class="col-xs-6">
					<div class="col-xs-3 no-padding text-center"><img src="../images/wind.png" style="width: 3.5rem;"><br><span></span></div>
					<div class="col-xs-9 no-padding text-right">풍속(m/s)<br><span id="" style="font-size:28px">0</span></div>
					<div style="clear:both"></div>
				</div>
			</div>
		</div>
	</div>
</div>

<?
include_once("../inc/bottom.php")
?>

<script language="javascript">

</script>