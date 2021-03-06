<?
include_once("../inc/top.php")
?>

<div class="row">
	<div class="col-sm-12 no-padding" style="margin-top:-25px">
		<div class="jarviswidget jarviswidget-color-white no-padding" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">							
			<header style="border-radius: 15px 15px 0px 0px; border : 4px solid #E6E6E6; border-bottom: 0; background-image: url(../images/bgcolor.png); background-repeat: no-repeat; background-size: cover">
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
					</div><!--col-sm-12-->
				</div><!--row-->
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-sm-12 no-padding" style="margin-top:-25px">
		<div class="jarviswidget jarviswidget-color-white no-padding" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
			<header style="border-radius: 15px 15px 0px 0px; border : 4px solid #E6E6E6; border-bottom: 0; background-image: url(../images/bgcolor.png); background-repeat: no-repeat; background-size: cover">
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
	<div class="col-sm-12 no-padding" style="margin-top:-10px">
		<div class="jarviswidget jarviswidget-color-white no-padding" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">							
			<header style="border-radius: 15px 15px 0px 0px; border : 4px solid #E6E6E6; border-bottom: 0; background-image: url(../images/bgcolor.png); background-repeat: no-repeat; background-size: cover">
				<div class="widget-header">	
					<h2 class="font-weight-bold text-white">중량별 정규분포
						<span class="font-sm badge bg-orange">15일령 이후 표시</span>
					</h2>
				</div>
				<div class="widget-toolbar ml-auto">
					<button type="button" class="btn btn-sm btn-default" style="height: 25px" onClick="$('#weigth_ndis_table_div').toggle(700).focus()">표 출력</button>
				</div>
			</header>
			<div class="widget-body weight_ndis_body" style="border-radius: 0px 0px 15px 15px; border : 4px solid #E6E6E6; border-top: 0;">
				<div class="col-sm-12 no-padding">
					<div id="weight_ndis_chart" style="height: 260px;"></div>
				</div>
				<div class="col-sm-12">
					<div id="weigth_ndis_table_div" style="width:100%; display: none;" tabindex="-1">
						<table id="weigth_ndis_table"  data-page-list="[]" data-pagination="true" data-page-list="false" data-page-size="10" data-sort-name="f1" data-sort-order="asc" data-toggle="table" style="font-size:14px">
							<thead>
								<tr>
									<th data-field='f1' data-visible="true" data-sortable="true">구간(g)</th>
									<th data-field='f2' data-visible="true" data-sortable="true">구간별 마리 수</th>
									<th data-field='f3' data-visible="true" data-sortable="true">구간별 비율(%)</th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-sm-12 no-padding" style="margin-top:-5px">
		<div class="jarviswidget jarviswidget-color-white no-padding mb-3" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">							
			<header style="border-radius: 15px 15px 0px 0px; border : 4px solid #E6E6E6; border-bottom: 0; background-image: url(../images/bgcolor.png); background-repeat: no-repeat; background-size: cover">
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
	<div class="col-sm-12 no-padding" style="margin-top:-5px">
		<div class="jarviswidget jarviswidget-color-white no-padding" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-togglebutton="false">
			<header style="border-radius: 15px 15px 0px 0px; border : 4px solid #E6E6E6; border-bottom: 0; background-image: url(../images/bgcolor.png); background-repeat: no-repeat; background-size: cover">
				<div class="widget-header">	
					<h2 class="font-weight-bold text-white"><i class="fa fa-bar-chart-o"></i>&nbsp;일령별 환경센서</h2>	
				</div>
				<!-- <div class="widget-toolbar ml-auto">
					<div class="btn-group">
						<button type="button" class="btn btn-sm btn-default" style="height: 25px"><span class="fa fa-file-excel-o"></span>&nbsp;&nbsp;Excel</button>
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
					<div class="col-sm-12">
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
	</div><!--col-sm-12-->
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
		get_ndis_data();
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

	//중량별 산포도
	function get_ndis_data(){

		let data_arr = {};
		data_arr["oper"] = "get_ndis_chart";
		data_arr["cmCode"] = top_code;

		$.ajax({
			url:"0102_action.php",
			data:data_arr,
			cache:false,
			type:"post",
			dataType:"json",
			success: function(data){
				let insu = data.ndis_data[0].cmInsu;	// cmInsu 입추 수
				let ndis = data.ndis_data[0].awNdis;	// awNdis 정규분포
				let arr  = ndis.split("|");

				let pers_list = {};

				// awNdis 정규분포 총합계
				let ret = arr.reduce(function add(sum, curr_val){
					return sum + parseInt(curr_val);
				}, 0);

				for(let z=0; z<arr.length; z++){
					let temp = (arr[z] / ret) * 100;
					pers_list[z] = temp.toFixed(1);
				}

				let ndis_chart = [];	// chart data를 담을 배열
				let ndis_table = [];	// table data 를 담을 배열
				let widx = 500;			// 무게 index
				let sidx = 0;			// start index
				let eidx = 0;			// end index
				
				// sidx 구하는 for문
				for(let s=0; s<arr.length; s++){
					if(arr[s] != 0){
						sidx = s-2;
						sidx = sidx < 0 ? 0 : sidx;
						break;
					}
				}

				// eidx 구하는 for문
				for(let e=(arr.length)-1; e>=0; e--){
					if(arr[e] != 0){
						eidx = e+3;
						eidx = eidx > 50 ? 50 : eidx;
						break;
					}
				}
				for(let i=sidx; i<eidx; i++){
					//let val = ((parseInt(arr[i])/insu)*100).toFixed(1);
					let val = insu * pers_list[i] / 100;
					val  = val.toFixed(1);

					let obj_chart = {
						"category": String(widx+(50*i)),
						"title0" : "마리 수",
						"value0": val,
						"pers": pers_list[i],
						"title1" : "",
						"value1": val
					}
					ndis_chart[i-sidx] = obj_chart;

					let obj_table = {
						"f1": widx+(50*i),
						"f2": (insu * pers_list[i] / 100).toFixed(0),
						"f3": pers_list[i]
					}
					ndis_table[i-sidx] = obj_table;
				}

				let params = {};
				params["graph_color"] = ["#FF9900","#ff6600","#109618","#990099"];
				params["font_size"] = 12;
				params["is_zoom"] = true;
				params["date_format"] = "입추수 " + insu;
				params["chart_style"] = "세로-Bar";

				$("#ndis_insu").html(insu+"수");
				$("#weigth_ndis_table").bootstrapTable('load', ndis_table); 
				draw_chart_detail("weight_ndis_chart", ndis_chart, params);
				if(ret == 0){$(".weight_ndis_body").css("display","none");}
				
			}
		});
	}

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