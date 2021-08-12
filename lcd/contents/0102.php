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
				<div class="widget-toolbar">
					<div class="progress progress-striped active" rel="tooltip" data-original-title="55%" data-placement="bottom">
						<div id="state_bar" class="progress-bar bg-warning" role="progressbar" style="width: 55%">55 %</div>
					</div>
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

<?
include_once("../inc/bottom.php")
?>

<script language="javascript">

	$(document).ready(function(){
		load_data();
	});

	function get_dong_data(){
		get_cell_data();
		get_avg_data("day");
		get_inc_data();
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
				//$('#avg_weight_table').bootstrapTable('load', data.avg_weight_table); 
				draw_select_chart("avg_weight_chart", data.avg_weight_chart, "영역차트", "Y", "N", 12);
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
				draw_bar_line_chart("today_inc_chart", data.today_inc_weight, "N", "N", 12);
			}
		});
	}

</script>