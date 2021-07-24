<?
include_once("../inc/top.php")
?>

<!--제목--->
<div class="row" id="row_none" style="display:none;">
	<div class="col-xs-12">
		<div class="well text-center shadow">
			<h3 class="font-weight-bold">지난 출하내역 <span class="text-danger"><strong id="select_dong_name">없음</strong></span></h3>
		</div><!--well-->
	</div><!--col-xs-12-->
</div><!--row--->

<!---출하목록--->
<div class="row">
	<div class="col-xs-12">
		<div class="jarviswidget jarviswidget-color-white" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-togglebutton="false">
			<header>
				<div class="widget-header">	
					<h2 class="font-weight-bold text-primary"><i class="fa fa-bar-chart-o text-warning"></i>&nbsp;&nbsp;지난 출하내역</h2>	
				</div>
			</header>
			<div class="widget-body shadow" style="border-radius: 0 0 10px 10px; padding:0.5rem">
				<table id="come_out_table" data-page-list="[]" data-toggle="table" data-pagination='true' data-page-size='5' style="font-size:14px">
					<thead>
						<tr>
						<th data-field='f1' data-align="center">번호</th>
						<th data-field='f2' data-align="center" data-visible="false">code</th>
						<th data-field='f3' data-align="center" data-visible="false">농장ID</th>
						<th data-field='f4' data-align="center" data-visible="false">동ID</th>
						<th data-field='f5' data-align="center" data-sortable="true">동명</th>
						<th data-field='f6' data-align="center" data-sortable="true">입추일자</th>
						<th data-field='f7' data-align="center">출하일자</th>
						</tr>
					</thead>

				</table>
			</div><!--widget-body-->
		</div><!--widget-->
	</div><!--col-xs-12-->
</div><!--row--->


<div class="row">
	<div class="col-xs-12">
		<div class="jarviswidget jarviswidget-color-white no-padding" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
			<header style="border-radius: 10px 10px 0 0">
				<div class="widget-header">	
					<h2 class="font-weight-bold text-primary"><i class="fa fa-file-text-o text-success"></i>&nbsp;&nbsp;일령별 평균중량</h2>	
				</div>

				<div class="widget-toolbar ml-auto" style="height: 25px; line-height: 25px; margin-top: 0.3rem;">
					<div class="form-inline">
						<div class="btn-group no-margin">
							<button type="button" class="btn btn-default btn-sm" style="padding:0.2rem 0.4rem;" onClick="get_avg_history('day')">일령별</button>
							<button type="button" class="btn btn-default btn-sm" style="padding:0.2rem 0.4rem;" onClick="get_avg_history('time')">시간별</button>&nbsp;&nbsp;
							<button type="button" class="btn btn-primary btn-sm" style="padding:0.2rem 0.4rem;" onClick="$('#avg_weight_table_div').toggle(400)"><span class="fa fa-table"></span>&nbsp;&nbsp;표 출력</button>&nbsp;&nbsp;
							<button type="button" class="btn btn-success btn-sm" style="padding:0.2rem 0.4rem;" onClick="get_avg_history('excel')" selection="day" id="btn_excel_avg"><span class="fa fa-file-excel-o"></span>&nbsp;&nbsp;엑셀</button>
						</div>
					</div>
				</div>
			</header>
			<div class="widget-body shadow" style="border-radius: 0 0 10px 10px; padding:0.5rem">
			
				<div class="col-xs-12">
					<div id="avg_weight_chart" style="height:400px; width:100%;"></div>
				</div>

				<div class="col-xs-12" id="avg_weight_table_div" style="display:none;">
					<table id="avg_weight_table" data-page-list="[]" data-pagination="true" data-page-list="false" data-page-size="10" data-toggle="table" style="font-size:14px">
						<thead>
							<tr>
								<th data-field='f1' data-visible="true" data-sortable="true">산출시간</th>
								<th data-field='f2' data-visible="true" data-sortable="true">일령</th>
								<th data-field='f3' data-visible="true" data-sortable="true">평체</th>
								<th data-field='f4' data-visible="true" data-sortable="true">권고</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>	
		</div>
	</div>
</div>

<!--일령별 환경센서 변화 -->
<div class="row">
	<div class="col-xs-12" style="margin-top:-10px">
		<div class="jarviswidget jarviswidget-color-white" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-togglebutton="false">
			<header>
				<div class="widget-header">	
					<h2 class="font-weight-bold text-primary"><i class="fa fa-bar-chart-o text-warning"></i>&nbsp;&nbsp;일령별 환경센서</h2>	
				</div>
				<div class="widget-toolbar ml-auto">
					<button type="button" class="btn btn-default"><span class="fa fa-table"></span> Excel</button>&nbsp;&nbsp;
					<button id="toggle_sensor_btn" type="button" class="btn btn-default">
						<span class="fa fa-plus"> </span>
					</button>
				</div>
			</header>
			<div class="widget-body shadow" style="border-radius: 0 0 10px 10px; padding:0.5rem">

				<div class="widget-body-toolbar">
					<div id="sensor_btn_group" class="btn-group">
						<button type="button" class="btn btn-default" onClick="get_sensor_history('chart_temp');">
							<i class="fa fa-sun-o"></i>&nbsp;&nbsp;온도
						</button>
						<button type="button" class="btn btn-default" onClick="get_sensor_history('chart_humi');">
							<i class="fa fa-tint"></i>&nbsp;&nbsp;습도
						</button>
						<button type="button" class="btn btn-default" onClick="get_sensor_history('chart_co2');">
							<i class="fa fa-warning"></i>&nbsp;&nbsp;이산화탄소
						</button>
						<button type="button" class="btn btn-default" onClick="get_sensor_history('chart_nh3');">
							<i class="fa fa-ambulance"></i>&nbsp;&nbsp;암모니아
						</button>
					</div>
				</div><!--widget-body-toolbar-->

				<div class="row">
					<div id="daily_sensor_chart" style="height:300px"></div>
				</div>

				<div id="toggle_sensor_div" class="row fadeInDown animated" style="display:none">
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

	var select_code = "";
	var sensor_chart_data = null;

	$(document).ready(function(){
		load_data();

		$("#top_status_info").hide();
	});

	function get_dong_data(){
		get_history();
	};

	function get_history(){
		let data_arr = {};
		data_arr["oper"] = "get_history";	
		data_arr["cmCode"] = top_code;	//등록코드
		
		$.ajax({
			url:'0106_action.php',
			data:data_arr,
			cache:false,
			type:'post',
			dataType:'json',
			success: function(data){
				$("#come_out_table").bootstrapTable('load', data.come_out_table);
			}
		});
	};

	$('#come_out_table').on('click-row.bs.table', function (e, rowData, $element) {
		$('.success').removeClass('success');
		$($element).addClass('success');

		select_code = rowData.f2;

		//$("#selectDongName").text(rowData.f5);

		//일령별 평균중량 정보 가져오기
		get_avg_history("day");

		//일령별 센서정보 가져오기
		$("#sensor_btn_group > button.btn:first").addClass("active");
		$("#sensor_btn_group > button.btn:first").trigger('click');
	});

	function get_avg_history(comm){
		let data_arr = {};
		data_arr["oper"] = "get_avg_history";	
		data_arr["cmCode"] = select_code;	//등록코드
		data_arr['comm']   = "view";

		switch(comm){
			case "day":
				$("#btn_excel_avg").attr("selection", "day");
				break;
			case "time":
				$("#btn_excel_avg").attr("selection", "time");
				break;
			case "excel":
				data_arr['comm'] = "excel";
				break;
		}

		data_arr['term'] = $("#btn_excel_avg").attr("selection");
		
		$.ajax({
			url:'0106_action.php',
			data:data_arr,
			cache:false,
			type:'post',
			dataType:'json',
			success: function(data) {
				$('#avg_weight_table').bootstrapTable('load', data.avg_weight_table); 
				draw_select_chart("avg_weight_chart", data.avg_weight_chart, "영역차트", "Y", "N", 12, "hh");
			}
		});
	};

	function get_sensor_history(chart_name){
		// let data_arr = {};
		// data_arr["oper"]   = "get_sensor_history";
		// data_arr["cmCode"] = select_code;

		// $.ajax({
		// 	url:'0106_action.php',
		// 	type:'post',
		// 	cache:false,
		// 	data:data_arr,
		// 	dataType:'json',
		// 	success: function(data){
		// 		sensor_chart_data = data;
		// 		draw_select_chart("daily_sensor_chart", data[chart_name], "영역차트", "Y", "N", 12, "hh");
		// 	}
		// });
	};

</script>