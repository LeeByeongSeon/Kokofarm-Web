<?
include_once("../inc/top.php")
?>

<!---출하목록--->
<div class="row">
	<div class="col-xs-12">
		<div class="jarviswidget jarviswidget-color-white no-padding mb-3" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-togglebutton="false">
			<header style="border-radius: 10px 10px 0px 0px; border : 4px solid #eee; border-bottom: 0; background-color: #0c6ad0;">
				<div class="widget-header">	
					<h2 class="font-weight-bold text-white"><i class="fa fa-bar-chart-o"></i>&nbsp;지난 출하내역</h2>	
				</div>
			</header>
			<div class="widget-body no-padding" style="border-radius: 0px 0px 10px 10px; border : 4px solid #eee; border-top: 0;">
				<div class="widget-body-toolbar">
					<form id="search_form" class="form-inline mr-auto" onsubmit="return false;">
						<input class="form-control w-auto" type="text" name="search_name" maxlength="20" placeholder=" 농장명, 농장ID" size="15">&nbsp;
						<button type="button" class="btn btn-primary btn-sm" onClick="search_action('search')"><span class="fa fa-search"></span>&nbsp;검색</button>&nbsp;
						<button type="button" class="btn btn-danger btn-sm" onClick="search_action('cancle')"><span class="fa fa-times"></span>&nbsp;취소</button>
					</form>
                </div>
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
		<div class="jarviswidget jarviswidget-color-white no-padding mb-3" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
			<header style="border-radius: 10px 10px 0px 0px; border : 4px solid #eee; border-bottom: 0; background-color: #0c6ad0;">
				<div class="widget-header">	
					<h2 class="font-weight-bold text-white"><i class="fa fa-file-text-o"></i>&nbsp;일령별 평균중량</h2>	
				</div>
				<div class="widget-toolbar ml-auto">
					<button type="button" class="btn btn-xs btn-default" style="height: 25px" onClick="get_avg_history('day')">일령별</button>
					<button type="button" class="btn btn-xs btn-default" style="height: 25px" onClick="get_avg_history('time')">시간별</button>
					<button type="button" class="btn btn-xs btn-default" style="height: 25px" onClick="convert_excel('평균중량', 'avg_weight_table')" selection="day" id="btn_excel_avg"><span class="fa fa-file-excel-o"></span>&nbsp;Excel</button>
					<button type="button" class="btn btn-xs btn-primary" style="height: 25px" onClick="$('#avg_weight_table_div').toggle(400)"><span class="fa fa-plus"></span></button>
				</div>
			</header>
			<div class="widget-body no-padding" style="border-radius: 0px 0px 10px 10px; border : 4px solid #eee; border-top: 0;">
			
				<div class="col-xs-12">
					<div id="avg_weight_chart" style="height:300px; width:100%;"></div>
				</div>

				<div class="col-xs-12" id="avg_weight_table_div" style="display:none;">
					<table id="avg_weight_table" data-page-list="[]" data-pagination="true" data-page-list="false" data-page-size="10" data-toggle="table" data-sort-name="f2" data-sort-order="desc" style="font-size:14px">
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
		<div class="jarviswidget jarviswidget-color-white no-padding mb-3" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-togglebutton="false">
			<header style="border-radius: 10px 10px 0px 0px; border : 4px solid #eee; border-bottom: 0; background-color: #0c6ad0;">
				<div class="widget-header">	
					<h2 class="font-weight-bold text-white"><i class="fa fa-bar-chart-o"></i>&nbsp;일령별 환경센서</h2>	
				</div>
				<div class="widget-toolbar ml-auto">
					<button type="button" class="btn btn-xs btn-default" style="height: 25px"><span class="fa fa-file-excel-o"></span>&nbsp;Excel</button>
				<!-- <button id="toggle_sensor_btn" type="button" class="btn btn-default">
					<span class="fa fa-plus"> </span>
				</button> -->
				</div>
			</header>
			<div class="widget-body no-padding" style="border-radius: 0px 0px 10px 10px; border : 4px solid #eee; border-top: 0;">

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

	var select_code = "";
	var select_name = "";
	var sensor_chart_data = null;

	$(document).ready(function(){

		get_history("");
	});

	function get_history(search){
		let data_arr = {};
		data_arr["oper"] = "get_history";	
		data_arr["search"] = search;
		
		$.ajax({
			url:'0103_action.php',
			data:data_arr,
			cache:false,
			type:'post',
			dataType:'json',
			success: function(data){
				$("#come_out_table").bootstrapTable('load', data.come_out_table);
			}
		});
	};

	// 검색, 취소, 엑셀 버튼 이벤트
	function search_action(action){

		switch(action){
			case "search":
				let search = $("#search_form [name=search_name]").val();
				get_history(search);
				break;

			case "cancle":
				//초기화
				$("#search_form").each(function() {	this.reset();  });
				break;
		}
	};

	$('#come_out_table').on('click-row.bs.table', function (e, rowData, $element) {
		$('.success').removeClass('success');
		$($element).addClass('success');

		select_code = rowData.f2;
		select_name = rowData.f5;
		//$("#selectDongName").text(rowData.f5);

		//일령별 평균중량 정보 가져오기
		get_avg_history("day");

		//일령별 센서정보 가져오기
		//$("#sensor_btn_group > button.btn:first").addClass("active");
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
			// case "excel":
			// 	data_arr['comm'] = "excel";
			// 	break;
		}

		data_arr['term'] = $("#btn_excel_avg").attr("selection");
		
		$.ajax({
			url:'0103_action.php',
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

		if(sensor_chart_data == null){
			let data_arr = {};
			data_arr["oper"]   = "get_sensor_history";
			data_arr["cmCode"] = select_code;

			$.ajax({
				url:'0103_action.php',
				type:'post',
				cache:false,
				data:data_arr,
				dataType:'json',
				success: function(data){
					sensor_chart_data = data;
					draw_select_chart("daily_sensor_chart", sensor_chart_data[chart_name], "영역차트", "Y", "N", 12, "hh");
					//draw_select_chart("daily_sensor_chart", sensor_chart_data[chart_name], "세로-Bar", "Y", "N", 12, "hh");
					//draw_bar_line_chart("daily_sensor_chart", sensor_chart_data[chart_name], "N", "N", 12);
				}
			});
		}
		else{
			//draw_bar_line_chart("daily_sensor_chart", sensor_chart_data[chart_name], "N", "N", 12);
			//draw_select_chart("daily_sensor_chart", sensor_chart_data[chart_name], "세로-Bar", "Y", "N", 12, "hh");
			draw_select_chart("daily_sensor_chart", sensor_chart_data[chart_name], "영역차트", "Y", "N", 12, "hh");
		}
	};

	function convert_excel(title, table_id){
		title = select_name + "_" + select_code + "_" + title;

		send_excel_android(title, table_id);
	};

</script>