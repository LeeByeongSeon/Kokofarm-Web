<?
include_once("../inc/top.php")
?>

<!---출하목록--->
<div class="row">
	<div class="col-xs-12">
		<div class="jarviswidget jarviswidget-color-white" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-togglebutton="false">
			<header>
				<div class="widget-header">	
					<h2 class="font-weight-bold text-primary"><i class="fa fa-files-o text-warning"></i>&nbsp;&nbsp;지난 출하내역</h2>	
				</div>
			</header>
			<div class="widget-body shadow" style="border-radius: 0 0 10px 10px; padding:0.5rem">
				<div class="widget-body-toolbar no-padding">
					<form id="search_form" class="form-inline mr-auto" onsubmit="return false;">&nbsp;&nbsp;
						<input class="form-control w-auto" type="text" name="search_name" maxlength="20" placeholder=" 농장명, 농장ID" size="15">&nbsp;&nbsp;
						<button type="button" class="btn btn-primary btn-sm" onClick="search_action('search')"><span class="fa fa-search"></span>&nbsp;&nbsp;검색</button>&nbsp;&nbsp;
						<button type="button" class="btn btn-danger btn-sm" onClick="search_action('cancle')"><span class="fa fa-times"></span>&nbsp;&nbsp;취소</button>&nbsp;&nbsp;
					</form>
                </div>
				<table id="chk_out_table" data-page-list="[]" data-toggle="table" data-pagination='true' data-page-size='5' style="font-size:14px">
					<thead>
						<tr>
						<th data-field='f1' data-align="center">번호</th>
						<th data-field='f2' data-align="center" data-visible="false">cmCode</th>
						<th data-field='f3' data-align="center" data-visible="false">농장ID</th>
						<th data-field='f4' data-align="center" data-visible="false">동ID</th>
						<th data-field='f5' data-align="center" data-sortable="true">동명</th>
						<th data-field='f6' data-align="center" data-sortable="true">입추일자</th>
						<th data-field='f7' data-align="center">출하일자</th>
						<th data-field='f8' data-align="center" data-visible="false">생존수</th>
						</tr>
					</thead>

				</table>
			</div><!--widget-body-->
		</div><!--widget-->
	</div><!--col-xs-12-->
</div><!--row--->


<!--일령별 평균중량 변화추이 -->
<div class="row">
	<div class="col-xs-12">
		<div class="jarviswidget jarviswidget-color-white" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-togglebutton="false">
			<header>
				<div class="widget-header">	
					<h2 class="font-weight-bold text-primary"><i class="fa fa-bar-chart-o text-warning"></i>&nbsp;&nbsp;일령별 평균중량</h2>	
				</div>
				<div class="widget-toolbar ml-auto">
					<button type="button" class="btn btn-default"><span class="fa fa-file-excel-o"></span> Excel</button>&nbsp;&nbsp;
					<button id="toggle_weight_btn" type="button" class="btn btn-default">
						<span class="fa fa-plus"> </span>
					</button>
				</div>
			</header>
			<div class="widget-body shadow" style="border-radius: 0 0 10px 10px; padding:0.5rem">
				<div class="row">
					<div id="allday_weight_chart" style="height:260px;"></div>
				</div>
				<div id="toggle_weight_div" class="row fadeInDown animated d-none">
					<div class="col-xs-12">
						<table id="allday_weight_table" data-toggle="table" style="font-size:14px">
							<thead>
								<tr>
								<th data-field='f1' data-align="center" data-sortable="true">일령<br>(Day)</th>
								<th data-field='f2' data-align="center">일령별<br>날짜</th>
								<th data-field='f3' data-align="center">권고<br>중량(g)</th>
								<th data-field='f4' data-align="center">평균<br>중량(g)</th>
								<th data-field='f5' data-align="center">표준<br>편차</th>
								<th data-field='f6' data-align="center">변이<br>계수</th>
								</tr>
							</thead>
						</table>
					</div><!--col-xs-12-->
				</div><!--row-->

			</div><!--widget-body-->
		</div><!--widget-->
	</div><!--col-xs-12-->
</div><!--row-->

<!--일령별 환경센서 변화 -->
<div class="row">
	<div class="col-xs-12">
		<div class="jarviswidget jarviswidget-color-white" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-togglebutton="false">
			<header>
				<div class="widget-header">	
					<h2 class="font-weight-bold text-primary"><i class="fa fa-bar-chart-o text-warning"></i>&nbsp;&nbsp;일령별 환경센서</h2>	
				</div>
				<div class="widget-toolbar ml-auto">
					<button type="button" class="btn btn-default"><span class="fa fa-file-excel-o"></span> Excel</button>&nbsp;&nbsp;
					<button id="toggle_sensor_btn" type="button" class="btn btn-default">
						<span class="fa fa-plus"> </span>
					</button>
				</div>
			</header>
			<div class="widget-body shadow" style="border-radius: 0 0 10px 10px; padding:0.5rem">

				<div class="widget-body-toolbar no-padding">
					<div id="allday_btn_group" class="btn-group">
						<button type="button" class="btn btn-default" onClick="get_sensor(cmCode,'온도','INOUTDAY');">
							<i class="fa fa-sun-o"></i>&nbsp;&nbsp;온도
						</button>
						<button type="button" class="btn btn-default" onClick="get_sensor(cmCode,'습도','INOUTDAY');">
							<i class="fa fa-tint"></i>&nbsp;&nbsp;습도
						</button>
						<button type="button" class="btn btn-default" onClick="get_sensor(cmCode,'CO2','INOUTDAY');">
							<i class="fa fa-cloud"></i>&nbsp;&nbsp;이산화탄소
						</button>
						<button type="button" class="btn btn-default" onClick="get_sensor(cmCode,'NH3','INOUTDAY');">
							<i class="fa fa-warning"></i>&nbsp;&nbsp;암모니아
						</button>
					</div>
				</div><!--widget-body-toolbar-->

				<div class="row">
					<div id="inoutday_sensor_chart" style="height:300px"></div>
				</div>

				<div id="toggle_sensor_div" class="row fadeInDown animated d-none">
					<div class="col-xs-12">
						<table id="inoutday_sensor_table" data-toggle="table" style="font-size:14px">
							<thead>
								<tr>
								<th data-field='f1' data-align="center" data-sortable="true">일령</th>
								<th data-field='f2' data-align="center"><span>날짜</span></th>
								<th data-field='f3' data-align="center"><span>권고자료</span></th>
								<th data-field='f4' data-align="center"><span>평균자료</span></th>
								<th data-field='f5' data-align="center"><span>차이</span></th>
								</tr>
							</thead>

						</table>
					</div><!--col-xs-12-->
				</div><!--row-->

			</div><!--widget-body-->
		</div><!--widget-->
	</div><!--col-xs-12-->
</div><!--row-->

<?
include_once("../inc/bottom.php")
?>

<script language="javascript">

</script>