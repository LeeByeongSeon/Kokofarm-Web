<?
include_once("../inc/top.php")
?>

<div class="row">
	<div class="col-sm-12 no-padding" style="margin-top:-25px">
		<div class="jarviswidget jarviswidget-color-white no-padding" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">							
			<header style="border-radius: 15px 15px 0px 0px; border : 4px solid #E6E6E6; border-bottom: 0; background-image: url(../images/bgcolor.png); background-repeat: no-repeat">
				<div class="widget-header">	
					<h2 class="font-weight-bold text-white">현재 저울 상태</h2>	
				</div>
			</header>
			<div class="widget-body" style="border-radius: 0px 0px 15px 15px; border : 4px solid #E6E6E6; border-top: 0;">
				<div class="row">
					<div class="col-sm-12">
						<table id="cell_status_table" data-page-list="[]" data-pagination="false" data-page-list="false" data-page-size="10" data-toggle="table" style="font-size:18px">
							<thead>
								<tr>
									<th data-field='f1' data-visible="true">저울</th>
									<th data-field='f2' data-visible="true">중량</th>
									<th data-field='f3' data-visible="true">온도</th>
									<th data-field='f4' data-visible="true">습도</th>
									<th data-field='f5' data-visible="true">CO2</th>
									<th data-field='f6' data-visible="true">NH3</th>
								</tr>
							</thead>
						</table>
					</div><!--col-xs-12-->
				</div><!--row-->
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-sm-12 no-padding" style="margin-top:-25px">
		<div class="jarviswidget jarviswidget-color-white no-padding" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
			<header style="border-radius: 15px 15px 0px 0px; border : 4px solid #E6E6E6; border-bottom: 0; background-image: url(../images/bgcolor.png); background-repeat: no-repeat">
				<div class="widget-header">	
					<h2 class="font-weight-bold text-white">평균중량</h2>	
				</div>
				<!-- <div class="widget-toolbar ml-auto" style="height: 25px; line-height: 25px; margin-top: 0.3rem;">
					<div class="form-inline">
						<div class="btn-group no-margin">
							<button type="button" class="btn btn-default btn-sm" style="padding:0.1rem 0.2rem;" onClick="get_avg_data('day')">일령별</button>
							<button type="button" class="btn btn-default btn-sm" style="padding:0.1rem 0.2rem;" onClick="get_avg_data('time')">시간별</button>&nbsp;&nbsp;
							<button type="button" class="btn btn-primary btn-sm" style="padding:0.1rem 0.2rem;" onClick="$('#avg_weight_table_div').toggle(400)"><span class="fa fa-table"></span>&nbsp;&nbsp;표 출력</button>&nbsp;&nbsp;
							<button type="button" class="btn btn-default btn-sm" style="padding:0.1rem 0.2rem;" onClick="get_avg_data('excel')" selection="day" id="btn_excel_avg"><span class="fa fa-file-excel-o"></span>&nbsp;&nbsp;Excel</button>
						</div>
					</div>
				</div> -->
			</header>
			<div class="widget-body" style="border-radius: 0px 0px 15px 15px; border : 4px solid #E6E6E6; border-top: 0;">
			
				<div class="col-sm-12">
					<div id="avg_weight_chart" style="height:300px; width:100%;"></div>
				</div>

				<div class="col-sm-12" id="avg_weight_table_div" style="display:none;">
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
	
<div class="row">
	<div class="col-sm-12 no-padding" style="margin-top:-25px">
		<div class="jarviswidget jarviswidget-color-white no-padding" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">							
			<header style="border-radius: 15px 15px 0px 0px; border : 4px solid #E6E6E6; border-bottom: 0; background-image: url(../images/bgcolor.png); background-repeat: no-repeat">
				<div class="widget-header">	
					<h2 class="font-weight-bold text-white">오늘 증체중량</h2>	
				</div>
			</header>
			<div class="widget-body" style="border-radius: 0px 0px 15px 15px; border : 4px solid #E6E6E6; border-top: 0;">
				<div class="col-sm-12">
				<div id="today_inc_chart" style="height: 260px;"></div>
				</div>
			</div>
		</div>
	</div>
</div>

<!--일령별 환경센서 변화 -->
<div class="row">
	<div class="col-sm-12 no-padding" style="margin-top:-25px">
		<div class="jarviswidget jarviswidget-color-white no-padding" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-togglebutton="false">
			<header style="border-radius: 15px 15px 0px 0px; border : 4px solid #E6E6E6; border-bottom: 0; background-image: url(../images/bgcolor.png); background-repeat: no-repeat">
				<div class="widget-header">	
					<h2 class="font-weight-bold text-white"><i class="fa fa-bar-chart-o"></i>&nbsp;일령별 환경센서</h2>	
				</div>
				<!-- <div class="widget-toolbar ml-auto">
					<div class="btn-group">
						<button type="button" class="btn btn-xs btn-default" style="height: 25px"><span class="fa fa-file-excel-o"></span>&nbsp;&nbsp;Excel</button>
					</div>
				</div> -->
			</header>
			<div class="widget-body" style="border-radius: 0px 0px 10px 10px; border : 4px solid #E6E6E6; border-top: 0;">

				<div class="widget-body-toolbar">
					<div id="sensor_btn_group" class="btn-group">
						<button type="button" class="btn btn-default btn-sm" onClick="get_sensor_history('chart_temp');">
							<i class="fa fa-sun-o text-danger"></i>&nbsp;&nbsp;온도
						</button>
						<button type="button" class="btn btn-default btn-sm" onClick="get_sensor_history('chart_humi');">
							<i class="fa fa-tint text-primary"></i>&nbsp;&nbsp;습도
						</button>
						<button type="button" class="btn btn-default btn-sm" onClick="get_sensor_history('chart_co2');">
							<i class="fa fa-cloud text-secondary"></i>&nbsp;&nbsp;이산화탄소
						</button>
						<button type="button" class="btn btn-default btn-sm" onClick="get_sensor_history('chart_nh3');">
							<i class="fa fa-warning text-danger"></i>&nbsp;&nbsp;암모니아
						</button>
					</div>
				</div><!--widget-body-toolbar-->

				<!-- <div class="row">
					<div id="daily_sensor_chart" style="height:300px"></div>
				</div> -->

				<div id="daily_sensor_chart" style="height:300px"></div>

				<!-- <div id="toggle_sensor_div" class="row fadeInDown animated" style="display:none">
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
					</div>
				</div> -->

			</div><!--widget-body-->
		</div><!--widget-->
	</div><!--col-xs-12-->
</div><!--row-->

<?
include_once("../inc/bottom.php")
?>

<script language="javascript">

	var sensor_chart_data = null;

	function get_data(){
		get_cell_data();
		get_avg_data("day");
		get_inc_data();
		get_sensor_history("chart_temp");
	};

	// 평균중량 불러오기
	function get_avg_data(comm){
		
		let data_arr = {}; 
		data_arr['oper']   = "get_avg_weight"
		data_arr["cmCode"] = top_code;	//등록코드
		data_arr['comm']   = "view";
		data_arr['term']   = "day";
		
		$.ajax({
			url:'0102_action.php',
			data:data_arr,
			cache:false,
			type:'post',
			dataType:'json',
			success: function(data) {
				data.avg_weight_chart = convert_amchart_time(data.avg_weight_chart, "일령");
				draw_select_chart("avg_weight_chart", data.avg_weight_chart, "영역차트", "Y", "N", 12, "hh");
			}
		});
	};

	//현재 저울 상태
	function get_cell_data(){

		let data_arr = {};
		data_arr['oper'] = "get_cell_status";
		data_arr['cmCode'] = top_code;
		
		$.ajax({
			url:'0102_action.php',
			data:data_arr,
			cache:false,
			type:'post',
			dataType:'json',
			success: function(data){
				$("#cell_status_table").bootstrapTable('load', data.cell_data);
			}
		});
	};

	//오늘 증체중량
	function get_inc_data(){

		let data_arr = {};
		data_arr["oper"] = "get_inc_weight";
		data_arr["cmCode"] = top_code;

		$.ajax({
			url:'0102_action.php',
			data:data_arr,
			cache:false,
			type:'post',
			dataType:'json',
			success: function(data){
				//console.log(JSON.stringify(data.today_inc_weight));
				data.today_inc_weight = convert_amchart_time(data.today_inc_weight, "시간");
				draw_bar_line_chart("today_inc_chart", data.today_inc_weight, "N", "N", 12, "hh");
			}
		});
	}

	// 일령별 센서변화
	function get_sensor_history(chart_name){

		if(sensor_chart_data == null){
			let data_arr = {};
			data_arr["oper"]   = "get_sensor_history";
			data_arr["cmCode"] = top_code;

			$.ajax({
				url:'0102_action.php',
				type:'post',
				cache:false,
				data:data_arr,
				dataType:'json',
				success: function(data){
					sensor_chart_data = data;
					sensor_chart_data[chart_name] = convert_amchart_time(sensor_chart_data[chart_name], "시간");
					draw_select_chart("daily_sensor_chart", sensor_chart_data[chart_name], "영역차트", "Y", "N", 12, "hh");
				}
			});
		}
		else{
			sensor_chart_data[chart_name] = convert_amchart_time(sensor_chart_data[chart_name], "시간");
			draw_select_chart("daily_sensor_chart", sensor_chart_data[chart_name], "영역차트", "Y", "N", 12, "hh");
		}
	};

</script>