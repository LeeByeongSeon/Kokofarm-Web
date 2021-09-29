<?
include_once("../inc/top.php");
?>
<style>
#cameraIcon {
	position:absolute;
	max-width:100%; max-height:100%;
	width:auto; height:auto;
	margin:auto;
	top:0; bottom:0; left:15px; right:0;
	cursor:pointer;
}
</style>
<!--동 정보 요약-->
<article class="col-xl-10 float-right">
	<div class="row">
		<article class="col-xl-12">
			<div class="jarviswidget jarviswidget-color-darken" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
				<header>
					<div class="widget-header">	
						<h2><i class="fa fa-home"></i>&nbsp;동 정보 요약</h2>	
					</div>
				</header>

				<div>
					
					<div class="widget-body d-flex justify-content-between align-items-center">

						<!-- 농가 정보 div -->
						<div class="well col-xl-4 no-padding">
							<div class="col-xl-12 text-center text-secondary mb-2">
								<h2 class="font-weight-bold p-2 no-margin"><span id="summary_name">망성농장-01동 (KF0013-01) </span></h2>
							</div>

							<div class="col-xl-12 d-flex justify-content-between align-items-center no-padding">
								<div class="col-xl-4 no-padding text-center">
									<img class="img-reponsive" id="hen_img" src="../images/hen-scale1.png" alt="닭 이미지">
									<div class="carousel-caption" style="text-shadow: none;"><h2 class="p-3 no-margin font-weight-bold"> <span id="summary_days"></span>일</h2></div>
								</div>
								<div class="col-xl-8 no-padding d-flex justify-content-between">
									<div class="col-xl-6 text-center font-weight-bold pt-0">
										<span class="font-weight-bold font-lg">평균중량</sapn><span class="text-danger" id="summary_avg" style="font-size: 35px;">-</span>
									</div>
									<div class="col-xl-6 no-margin text-center font-weight-bold pt-2">
										<p><span class="font-md">표준편차</span>&nbsp;&nbsp;&nbsp;<span class="font-md" id="summary_devi">-</span></p>
										<span class="font-md">일일증체량</span>&nbsp;&nbsp;&nbsp;<span class="font-md" id="summary_inc">-</span>
									</div>
								</div>
							</div>

							<div class="col-xl-12 no-padding d-flex justify-content-between">
								<div class="col-xl-4 no-padding">
									<div class="text-center"><h6 class="m-2 font-weight-bold"><span id="summary_type">육계 -수</span></h6></div>
								</div>
								<div class="col-xl-8 no-padding">
									<div class="text-center"><h6 class="m-2 font-weight-bold"><span id="summary_comein">입추일자 : -</span></h6></div>

									<div id="summary_indate" style="display:none;"></div>
									<div id="summary_outdate" style="display:none;"></div>
								</div>
								<div>
							</div>
						</div>

						<!-- 급이 / 급수 div -->
						<div class="col-xl-5 float-left pr-5 pl-0 feed_info_div" style="border-right: 2px dotted #ddd;">
							<div class="row d-flex align-items-center">
								<div class="col-xl-4 no-padding text-center">
									<div class="col-xl-12 text-center">
										<img src="../images/feed-00.png" id="feed_img" style="width: 7rem;" alt="급이 이미지">
										<div class="carousel-caption h-100" style="text-shadow: none;"><h5 class="font-weight-bold text-secondary" id="extra_feed_percent">-%<h5></div>
									</div>
									<div class="col-xl-12 text-center no-padding"><span>사료잔량 <span id="extra_feed_remain">-</span>(kg)</span></div>
								</div>
								<div class="col-xl-4 h-50 no-padding">
									<div class="col-xl-12 h-75 text-right no-padding">
										<span class="font-weight-bold text-secondary font-md">오늘 급이량(㎏)</span><br>
										<span class="font-xl" id="extra_curr_feed">-</span>
									</div>
								</div>
								<div class="col-xl-4 h-50 float-right no-padding">
									<div class="col-xl-12 h-75 text-right no-padding">
										<span class="font-weight-bold text-secondary font-md">전일 급이량(㎏)</span><br>
										<span class="font-xl" id="extra_prev_feed">-</span>
									</div>
								</div>
							</div>
							<div class="row mt-3 d-flex align-items-center">
								<div class="col-xl-4 no-padding text-center">
									<div class="col-xl-12 text-center"><img src="../images/water-02.png" style="width: 5rem;" alt="급수 이미지"></div>
									<div class="col-xl-12 text-center no-padding"><span>시간당 급수량 <span id="extra_water_per_hour">-</span>(L)</span></div>
								</div>
								<div class="col-xl-4 h-50 no-padding">
									<div class="col-xl-12 h-75 text-right no-padding">
										<span class="font-weight-bold text-secondary font-md">오늘 급수량(L)</span><br>
										<span class="font-xl" id="extra_curr_water">-</span>
									</div>
								</div>
								<div class="col-xl-4 h-50 float-right no-padding">
									<div class="col-xl-12 h-75 text-right no-padding">
										<span class="font-weight-bold text-secondary font-md">전일 급수량(L)</span><br>
										<span class="font-xl" id="extra_prev_water">-</span>
									</div>
								</div>
							</div>
						</div>

						<!-- 카메라 div -->
						<div class="col-xl-3 pr-2" id="summary_camera">
						
						</div>
						
					</div>
					
				</div>
						
			</div>
		</article>
	</div>


	<!--평균중량 현황-->
	<div class="row">
		<article class="col-xl-12">
			<div class="jarviswidget jarviswidget-color-white no-padding" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
				<header>
					<div class="widget-header">	
						<h2><i class="fa fa-list"></i>&nbsp;평균중량 현황</h2>	
					</div>

					<div class="widget-toolbar ml-auto">
						<div class="form-inline">
							<button type="button" class="btn btn-default btn-sm" onClick="get_avg_data('day')">일령별</button>&nbsp;
							<button type="button" class="btn btn-default btn-sm" onClick="get_avg_data('time')">시간별</button>&nbsp;
							<button type="button" class="btn btn-warning btn-sm btn-labeled" onClick="$('#avg_weight_table_div').toggle(700).focus()" id="avg_table_slide"><span class="btn-label"><i class="fa fa-table"></i></span>표 출력</button>&nbsp;
							<button type="button" class="btn btn-secondary btn-sm btn-labeled" onClick="get_avg_data('excel')" selection="day" id="btn_excel_avg"><span class="btn-label"><i class="fa fa-file-excel-o"></i></span>엑셀</button>
						</div>
					</div>
				</header>

				<div class="widget-body">
					<div class="col-xl-12">
						<div id="avg_weight_chart" style="height:465px; width:100%;"></div>
					</div>

					<div class="col-xl-12" id="avg_weight_table_div" style="display:none;" tabindex="-1"> <!-- tabindex로 div에 focus()를 줄 수 있다 -1 일 경우 js로만 focus 가능 -->
						<table id="avg_weight_table"  data-page-list="[]" data-pagination="true" data-page-list="false" data-page-size="10" data-sort-name="f2" data-sort-order="desc" data-toggle="table" style="font-size:14px">
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
		</article>
	</div>


	<!--환경센서 현황-->
	<div class="row">
		<article class="col-xl-12">
			<div class="jarviswidget jarviswidget-color-white" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
				<header>
					<div class="widget-header">	
						<h2><i class="fa fa-list"></i>&nbsp;환경센서 현황</h2>	
					</div>
				</header>
					
				<div class="widget-body no-padding">
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
				</div>
					<div class="col-xl-12">
						<div id="daily_sensor_chart" style="height:465px; width:100%;"></div>
					</div>

				</div>
						
			</div>
		</article>
	</div>

	<!--실측 중량 & 재산출 기록-->
	<div class="row">
		<div class="col-xl-3">
			<div class="jarviswidget jarviswidget-color-white no-padding" id="wid-id-9" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
				<header>
					<div class="widget-header">	
						<h2><i class="fa fa-file-text-o text-primary"></i>&nbsp;실측 중량</h2>	
					</div>
				</header>

				<div class="widget-body" style="height: 250px">
					<table id="measure_weight_table"  data-page-list="[]" data-pagination="true" data-page-list="false" data-page-size="5" data-toggle="table" style="font-size:14px">
						<thead>
							<tr>
								<th data-field='f1' data-visible="true">실측시간</th>
								<th data-field='f2' data-visible="true">실측값</th>
								<th data-field='f3' data-visible="true">비고</th>
							</tr>
						</thead>
					</table>
				</div>
						
			</div>
		</div>

		<div class="col-xl-9">
			<div class="jarviswidget jarviswidget-color-white no-padding" id="wid-id-10" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
				<header>
					<div class="widget-header">	
						<h2><i class="fa fa-check-square-o text-primary"></i>&nbsp;재산출 기록</h2>	
					</div>
				</header>

				<div class="widget-body" style="height: 250px">	
					<table id="request_history_table"  data-page-list="[]" data-pagination="true" data-page-list="false" data-page-size="5" data-toggle="table" style="font-size:14px">
						<thead>
							<tr>
								<th data-field='f1' data-visible="true">완료시간</th>
								<th data-field='f2' data-visible="true">요청사항</th>
								<th data-field='f3' data-visible="true">변경사항</th>
								<th data-field='f4' data-visible="true">실측시간</th>
								<th data-field='f5' data-visible="true">실측값</th>
								<th data-field='f6' data-visible="true">재산출 전 예측</th>
							</tr>
						</thead>
					</table>
					
				</div>
						
			</div>
		</div>
	</div>

	<!--급이량 현황-->
	<div class="row">
		<article class="col-xl-12">
			<div class="jarviswidget jarviswidget-color-white" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
				<header>
					<div class="widget-header">	
						<h2><i class="fa fa-list"></i>&nbsp;급이량 현황</h2>	
					</div>
				</header>

				<div>
				
					<div class="widget-body">

						<div id="daily_feed_chart" style="height: 260px;"></div>
						
					</div>
					
				</div>
						
			</div>
		</article>
	</div>


	<!--급수량 현황-->
	<div class="row">
		<article class="col-xl-12">
			<div class="jarviswidget jarviswidget-color-white" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
				<header>
					<div class="widget-header">	
						<h2><i class="fa fa-list"></i>&nbsp;급수량 현황</h2>	
					</div>
				</header>

				<div>
					
					<div class="widget-body">

						<div id="daily_water_chart" style="height: 260px;"></div>
						
					</div>
					
				</div>
						
			</div>
		</article>
	</div>


	<!--평균중량 이력 비교-->
	<div class="row">
		<article class="col-xl-12">
			<div class="jarviswidget jarviswidget-color-white" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
				<header>
					<div class="widget-header">	
						<h2><i class="fa fa-list"></i>&nbsp;평균중량 이력 비교</h2>	
					</div>
				</header>

				<div class="widget-body">

					
				</div>
						
			</div>
		</article>
	</div>


	<!--환경센서 이력 비교-->
	<div class="row">
		<article class="col-xl-12">
			<div class="jarviswidget jarviswidget-color-white" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
				<header>
					<div class="widget-header">	
						<h2><i class="fa fa-list"></i>&nbsp;환경센서 이력 비교</h2>	
					</div>
				</header>

				<div class="widget-body">

					
				</div>
						
			</div>
		</article>
	</div>

</article>

<?
include_once("../inc/bottom.php");
?>

<script language="javascript">

	var code = "";
	var indate = "";
	var outdate = "";

	var select_code = "";
	var sensor_chart_data = null;

	var init_id = "<?=$init_id?>";

	$(document).ready(function(){

		call_tree_view("", act_grid_data, "all");
		set_tree_search(act_grid_data, "all");
		
	});

	// 데이터 불러오기
	function load_data(select){
		
		if(select == ""){
			if(init_id == ""){
				click_tree_first(act_grid_data);
			}
			else{
				click_tree_by_id(act_grid_data, init_id);
				init_id = "";
			}
			return;
		}

		select = select.split("|").length != 2 ? select + "|01" : select;
		let temp = $("#" + select.replace("|", "\\|") + "");

		code = $(temp).attr("cmCode");
		indate = $(temp).attr("cmIndate");
		outdate = $(temp).attr("cmOutDate");

		if(code == "" || code == null){
			popup_alert("입출하 데이터 없음", "선택된 농장의 입출하 데이터가 없습니다.");
		}

		get_buffer_data();
		get_avg_data("day");
		get_sensor_history('chart_temp');
		get_all();
	};

	// 트리뷰 버튼 클릭시 리로드 이벤트
	function act_grid_data(action){
		switch(action){
			default:
				load_data(action);
				break;
		}
	};

	// 버퍼테이블 불러오기
	function get_buffer_data(){

		if(code != null && code != ""){			// "" or null 체크
			var data_arr = {}; 
			data_arr['oper'] = "get_buffer";
			data_arr['code'] = code;
			$.ajax({url:'0203_action.php',data:data_arr,cache:false,type:'post',dataType:'json',
				success: function(data) {

					// 요약 정보
					$.each(data.summary_data, function(key, value){ 
						$("#" + key).html(value); 
					});

					// 닭 이미지 변경
					let days = data.summary_data.summary_days;
					if(days <= 10){	$("#hen_img").attr("src", "../images/hen-scale1.png"); }
					if(days >= 11 && days <= 20){ $("#hen_img").attr("src","../images/hen-scale2.png");  }
					if(days >= 21){ $("#hen_img").attr("src","../images/hen-scale3.png");  }
				
					// 급이, 급수 창 표시할지 선택
					if(data.extra.hasOwnProperty("extra_curr_feed")){
						$.each(data.extra, function(key, val){	$("#" + key).html(val); });
						let per = data.extra.extra_feed_percent;
						per = parseInt(per);
						if(per <= 10){ 				document.getElementById("feed_img").setAttribute("src", "../images/feed-00.png"); }
						if(per > 10 && per <= 35){ 	document.getElementById("feed_img").setAttribute("src", "../images/feed-01.png"); }
						if(per > 35 && per <= 65){ 	document.getElementById("feed_img").setAttribute("src", "../images/feed-02.png"); }
						if(per > 65 && per <= 90){ 	document.getElementById("feed_img").setAttribute("src", "../images/feed-03.png"); }
						if(per > 90){ 				document.getElementById("feed_img").setAttribute("src", "../images/feed-04.png"); }
					};
				}
			});
		};
	};

	// 평균중량 불러오기
	function get_avg_data(sub_comm){
		if(code != null && code != ""){			// "" or null 체크

			var data_arr = {}; 
			data_arr['oper'] = "get_avg_weight";
			data_arr['code'] = code;
			data_arr['comm'] = "view";

			switch(sub_comm){
				case "day":
					$("#btn_excel_avg").attr("selection", "day");
					break;
				case "time":
					$("#btn_excel_avg").attr("selection", "time");
					break;
				case "excel":
					data_arr['comm'] = "excel";
					break;
			};

			data_arr['term'] = $("#btn_excel_avg").attr("selection");

			
			$.ajax({url:'0203_action.php',data:data_arr,cache:false,type:'post',dataType:'json',
				success: function(data) {
					
					switch(data_arr['comm']){
						case "view":
							// 평균중량 Chart
							draw_select_chart("avg_weight_chart", data.avg_weight_chart, "영역차트", "Y", "N", 12);

							// 평균중량 Table
							$('#avg_weight_table').bootstrapTable('load', data.avg_weight_table);

							break;
						case "excel":
							let excel_html = data.excel_html;
							let excel_title = data.excel_title;

							table_to_excel(excel_title, excel_html);
							break;
					};

				}
			});
		};
	};

	// 환경센서 불러오기
	function get_sensor_history(chart_name){

		if(code != null && code != ""){
			if(sensor_chart_data == null){
				let data_arr = {};
				data_arr["oper"] = "get_sensor_history";
				data_arr["code"] = code;

				$.ajax({url:'0203_action.php',type:'post',cache:false,data:data_arr,dataType:'json',
					success: function(data){
						sensor_chart_data = data;
						draw_select_chart("daily_sensor_chart", sensor_chart_data[chart_name], "영역차트", "Y", "N", 12, "hh");
					}
				});
			}
			else{
				draw_select_chart("daily_sensor_chart", sensor_chart_data[chart_name], "영역차트", "Y", "N", 12, "hh");
			}
		}
	};
	

	// 재산출 이력 불러오기
	function get_request_data(){
		if(code != null && code != ""){			// "" or null 체크
			var data_arr = {}; 
			data_arr['oper'] = "get_request_history";
			data_arr['code'] = code;
			data_arr['indate'] = indate;
			$.ajax({url:'0203_action.php',data:data_arr,cache:false,type:'post',dataType:'json',
				success: function(data) {

					let measure = data.measure_weight_data;
					let measure_table = [];

					if(measure != 0 && measure != ""){
						for(date in measure){
							let map = {};
							let temp = measure[date].split("|");

							map["f1"] = date;
							map["f2"] = temp[0];
							map["f3"] = temp.length > 1 ? temp[1] : "";

							measure_table.push(map);
						}

						//alert(JSON.stringify(data.request_history_data));
						//alert(JSON.stringify(measure_table));
						$('#measure_weight_table').bootstrapTable('load', measure_table); 
					}
				}
			});
		}
	};

	// 급이/급수량 현황
	function get_all(){
		if(code != null && code != ""){			// "" or null 체크
			let data_arr = {};
			data_arr["oper"] = "get_all";
			data_arr["code"] = code;

			$.ajax({url:'0203_action.php',type:'post',cache:false,data:data_arr,dataType:'json',
				success: function(data){
					draw_bar_line_chart("daily_feed_chart", data.chart_feed, "Y", "N", 12, "DD");
					draw_bar_line_chart("daily_water_chart", data.chart_water, "Y", "N", 12, "DD");
				}
			});
		};
	};
</script>