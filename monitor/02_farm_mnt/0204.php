
<?
include_once("../inc/top.php");

// 축종선택 콤보박스
$query = "SELECT cName1 FROM codeinfo WHERE cGroup = \"생계구분\"";
$type_combo = make_combo_by_query($query, "request_type", "", "cName1");

$init_farm = isset($_REQUEST["farmID"]) ? $_REQUEST["farmID"] : "";
$init_dong = isset($_REQUEST["dongID"]) ? $_REQUEST["dongID"] : "";

$init_id = $init_farm != "" ? $init_farm . "|" . $init_dong : ""; 

?>
<!--농장정보 & 이슈사항-->
<article class="col-xl-10 float-right"> 

	<!--출하이력-->
	<div class="row">
		<div class="col-xl-12">
			<div class="jarviswidget jarviswidget-color-white no-padding" id="wid-id-1" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
				<header>
					<div class="widget-header">	
						<h2><i class="fa fa-file-text-o text-red"></i>&nbsp;출하이력</h2>	
					</div>
				</header> 

				<div class="widget-body">

					<div class="jqgrid_zone">
						<table id="jqgrid" class="jqgrid_table"></table>
						<div id="jqgrid_pager"></div>
					</div>
					
				</div>
						
			</div>
		</div>
	</div>

	<!--평균중량(표) & 오류이력-->
	<div class="row">
		<div class="col-xl-6">
			<div class="jarviswidget jarviswidget-color-light no-padding" id="wid-id-5" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
				<header>
					<div class="widget-header">	
						<h2><i class="fa fa-bar-chart-o text-orange"></i>&nbsp;평균중량</h2>	
					</div>

					<div class="widget-toolbar ml-auto">
						<div class="form-inline">
							<button type="button" class="btn btn-default btn-sm" onClick="get_avg_data('day')">일령별</button>&nbsp;
							<button type="button" class="btn btn-default btn-sm" onClick="get_avg_data('time')">시간별</button>&nbsp;
							<button type="button" class="btn btn-warning btn-sm btn-labeled" onClick="$('#avg_weight_table_div').toggle(400)"><span class="btn-label"><i class="fa fa-table"></i></span>표 출력</button>&nbsp;
							<button type="button" class="btn btn-secondary btn-sm btn-labeled" onClick="get_avg_data('excel')" selection="day" id="btn_excel_avg"><span class="btn-label"><i class="fa fa-file-excel-o"></i></span>엑셀</button>
						</div>
					</div>
				</header>

				<div class="widget-body">

					<div class="col-xl-12">
						<div id="avg_weight_chart" style="height:465px; width:100%;"></div>
					</div>
					
					<div class="col-xl-12" id="avg_weight_table_div" style="display:none;">
						<table id="avg_weight_table"  data-page-list="[]" data-pagination="true" data-page-list="false" data-page-size="10" data-toggle="table" style="font-size:14px">
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

		<div class="col-xl-6">
			<div class="jarviswidget jarviswidget-color-white" id="wid-id-4" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
				<header>
					<div class="widget-header">	
						<h2><i class="fa fa-file-text-o text-red"></i>&nbsp;오류 이력</h2>	
					</div>

					<div class="widget-toolbar ml-auto" style="padding-top: 4px">
						<div class="form-inline">
							<button type="button" class="btn btn-secondary btn-sm btn-labeled" onClick="get_error_data('excel')"><span class="btn-label"><i class="fa fa-file-excel-o"></i></span>엑셀</button>
						</div>
					</div>
				</header>
					
				<div class="widget-body p-2" style="height:465px;">

					<table id="error_history_table"  data-page-list="[]" data-pagination="true" data-page-list="false" data-page-size="10" data-toggle="table" style="font-size:14px">
						<thead>
							<tr>
								<th data-field='f1' data-visible="true" data-sortable="true">오류시간</th>
								<th data-field='f2' data-visible="true" data-sortable="true" data-align="center">오류상태</th>
								<th data-field='f3' data-visible="true" data-sortable="true" data-align="center">저울번호</th>
							</tr>
						</thead>
					</table>
					
				</div>
						
			</div>
		</div>
	</div>

	<!--재산출-->
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

	<!--로우데이터 확인-->
	<div class="row">
		<div class="col-xl-12">
			<div class="jarviswidget jarviswidget-color-white no-padding" id="wid-id-8" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
				<header>
					<div class="widget-header">	
						<h2><i class="fa fa-list text-primary"></i>&nbsp;로우데이터 확인</h2>	
					</div>
					<div class="widget-toolbar ml-auto" style="cursor: default">
						<span class="font-weight-bold text-info">※ 조회범위 설정 후 조회 버튼을 눌러주세요.</span>
					</div>
				</header>

				<div class="widget-body">

					<ul class="nav nav-tabs nav-tabs-right bordered" id="nav_raw_data" style="padding:5px;">&nbsp;&nbsp;
						<form id="raw_data_search_form" class="form-inline" onsubmit="return false;">
							<span class="fa fa-clock-o"></span>&nbsp;조회범위&nbsp;&nbsp;
							<input class="form-control" type="text" name="search_sdate" maxlength="10" placeholder="시작일" size="10" />&nbsp;
							<input class="form-control" type="text" name="search_stime" maxlength="5" placeholder="시작시간" size="7" />
							&nbsp;&nbsp; ~ &nbsp;&nbsp;
							<input class="form-control" type="text" name="search_edate" maxlength="10" placeholder="종료일" size="10" />&nbsp;
							<input class="form-control" type="text" name="search_etime" maxlength="5" placeholder="종료시간" size="7" />&nbsp;&nbsp;
							LIMIT&nbsp;<input class="form-control" type="text" name="search_limit" placeholder="1~9999" size="7" />&nbsp;&nbsp;
							<div class="form-check">
								<input class="form-check-input" type="radio" name="search_order" id="order_1" value="1">오름차순&nbsp;
							</div>
							<div class="form-check">
								<input class="form-check-input" type="radio" name="search_order" id="order_2" value="-1" checked>내림차순&nbsp;&nbsp;
							</div>
							<button type="button" class="btn btn-default btn-sm btn-labeled" onClick="search_raw_data('search')"><span class="btn-label"><i class="fa fa-search text-primary"></i></span>조회</button>&nbsp;
							<button type="button" class="btn btn-secondary btn-sm btn-labeled" onClick="search_raw_data('excel')"><span class="btn-label"><i class="fa fa-file-excel-o"></i></span>엑셀</button>
						</form>
						
						<li class="nav-item ml-auto">
							<a data-toggle="tab" class="nav-link tab-raw" id="ext">급이/급수/외기</a>
						</li>
						<li class="nav-item">
							<a data-toggle="tab" class="nav-link tab-raw" id="dev">PLC 제어</a>
						</li>
						<li class="nav-item">
							<a data-toggle="tab" class="nav-link tab-raw" id="plc">PLC 환경</a>
						</li>
						<li class="nav-item">
							<a data-toggle="tab" class="nav-link active tab-raw" id="cell">IoT저울</a>
						</li>
					</ul>

					<table id="cell_raw_data_table" data-page-list="[]" data-pagination="true" data-page-list="false" data-page-size="10" data-toggle="table" style="font-size:14px;">
						<thead>
							<tr>
								<th data-field='f1' data-visible="true" data-sortable="true">획득시간</th>
								<th data-field='f2' data-visible="true" data-sortable="true">저울ID</th>
								<th data-field='f3' data-visible="true" data-sortable="true">온도(℃)</th>
								<th data-field='f4' data-visible="true" data-sortable="true">습도(%)</th>
								<th data-field='f5' data-visible="true" data-sortable="true">CO2(ppm)</th>
								<th data-field='f6' data-visible="true" data-sortable="true">NH3(ppm)</th>
								<th data-field='f7' data-visible="true" data-sortable="false">w01</th>
								<th data-field='f8' data-visible="true" data-sortable="false">w02</th>
								<th data-field='f9' data-visible="true" data-sortable="false">w03</th>
								<th data-field='f10' data-visible="true" data-sortable="false">w04</th>
								<th data-field='f11' data-visible="true" data-sortable="false">w05</th>
							</tr>
						</thead>
					</table>

					<table id="plc_raw_data_table" data-page-list="[]" data-pagination="true" data-page-list="false" data-page-size="10" data-toggle="table" style="font-size:14px;">
						<thead>
							<tr>
								<th data-field='f1' data-sortable='true'>획득시간</th>
								<th data-field='f2' data-sortable='true'>내부온도(℃)</th>
								<th data-field='f3' data-sortable='true'>내부습도(%)</th>
								<th data-field='f4' data-sortable='true'>내부CO2(ppm)</th>
								<th data-field='f5' data-sortable='true'>내부음압</th>
								<th data-field='f6' data-sortable='true'>외부온도(℃)</th>
								<th data-field='f7' data-sortable='true'>외부습도(%)</th>
								<th data-field='f8' data-sortable='true'>외부NH3(ppm)</th>
								<th data-field='f9' data-sortable='true'>외부H2S(ppm)</th>
							</tr>
						</thead>
					</table>

					<table id="dev_raw_data_table" data-page-list="[]" data-pagination="true" data-page-list="false" data-page-size="10" data-toggle="table" style="font-size:14px;">
						<thead>
							<tr>
								<th data-field='f1' data-sortable='true'>획득시간</th>
								<th data-field='f2' data-sortable='true'>유닛ID</th>
								<th data-field='f3' data-sortable='true'>장치속성</th>
								<th data-field='f4' data-sortable='true'>장치구분</th>
								<th data-field='f5' data-sortable='true'>장치명</th>
								<th data-field='f6' data-sortable='true'>상태</th>
							</tr>
						</thead>
					</table>

					<table id="ext_raw_data_table" data-page-list="[]" data-pagination="true" data-page-list="false" data-page-size="10" data-toggle="table" style="font-size:14px;">
						<thead>
							<tr>
								<th data-field='f1' data-sortable='true'>획득시간</th>
								<th data-field='f2' data-sortable='true'>사료빈무게</th>
								<th data-field='f3' data-sortable='true'>현재값-직전값</th>
								<th data-field='f4' data-sortable='true'>유량센서값</th>
								<th data-field='f5' data-sortable='true'>온도(℃)</th>
								<th data-field='f6' data-sortable='true'>습도(%)</th>
								<th data-field='f7' data-sortable='true'>NH3(ppm)</th>
								<th data-field='f8' data-sortable='true'>H2S(ppm)</th>
								<th data-field='f9' data-sortable='true'>미세먼지(ppm)</th>
								<th data-field='f10' data-sortable='true'>초미세먼지(ppm)</th>
								<th data-field='f11' data-sortable='true'>풍향</th>
								<th data-field='f12' data-sortable='true'>풍속(m/s)</th>
							</tr>
						</thead>
					</table>
					
				</div>
					
			</div>
		</div>
	</div>

</article>
<?
include_once("../inc/bottom.php");
?>

<script language="javascript">

	var code = "";
	var indate = "";
	var outdate = "";

	var reloaded = false;

	// 로우데이터가 로드된적이 있는지 확인
	var is_load = {};
	is_load["cell"] = false;
	is_load["plc"] = false;
	is_load["dev"] = false;
	is_load["ext"] = false;

	var init_id = "<?=$init_id?>";

	$(document).ready(function(){

		get_grid_data();

		call_tree_view("", act_grid_data);
		set_tree_search(act_grid_data);

		$("#plc_raw_data_table").parent(".fixed-table-body").parent(".fixed-table-container").parent(".bootstrap-table").hide();
		$("#dev_raw_data_table").parent(".fixed-table-body").parent(".fixed-table-container").parent(".bootstrap-table").hide();
		$("#ext_raw_data_table").parent(".fixed-table-body").parent(".fixed-table-container").parent(".bootstrap-table").hide();

		$("#raw_data_search_form [name=search_sdate]").datepicker({format:"yyyy-mm-dd", language: "kr", autoclose: true});		//로우데이터 검색 시작일
		$("#raw_data_search_form [name=search_edate]").datepicker({format:"yyyy-mm-dd", language: "kr", autoclose: true});		//로우데이터 검색 종료일

		$("#raw_data_search_form [name=search_stime]").clockpicker({placement: 'bottom', align: 'left', autoclose: true});			//로우데이터 검색 시작시간
		$("#raw_data_search_form [name=search_etime]").clockpicker({placement: 'bottom', align: 'left', autoclose: true});			//로우데이터 검색 종료시간
	});

	// 데이터 불러오기
	function load_data(){

		get_avg_data("day");
		get_error_data();
		get_request_data();
	};

	// 동 선택 변경 시 검색 초기화
	function clear_search(){

		is_load["cell"] = false;
		is_load["plc"] = false;
		is_load["dev"] = false;
		is_load["ext"] = false;
		
		$("#raw_data_search_form").each(function() {this.reset();});
		$("#nav_raw_data li").removeClass("active").children("a").removeClass("active").removeClass("show");
		$("#nav_raw_data li a#cell").addClass("active").addClass("show").parent("li").addClass("active");

		$("#cell_raw_data_table").parent(".fixed-table-body").parent(".fixed-table-container").parent(".bootstrap-table").hide();
		$("#plc_raw_data_table").parent(".fixed-table-body").parent(".fixed-table-container").parent(".bootstrap-table").hide();
		$("#dev_raw_data_table").parent(".fixed-table-body").parent(".fixed-table-container").parent(".bootstrap-table").hide();
		$("#ext_raw_data_table").parent(".fixed-table-body").parent(".fixed-table-container").parent(".bootstrap-table").hide();

		$("#cell_raw_data_table").parent(".fixed-table-body").parent(".fixed-table-container").parent(".bootstrap-table").show();

		$("#cell_raw_data_table").bootstrapTable('removeAll');
		//raw_tab_click("cell");
	}

	function get_grid_data(){
		$("#jqgrid").jqGrid({
			url:"0204_action.php", 
			editurl:"0204_action.php",
			styleUI:"Bootstrap",
			autowidth:true,
			shrinkToFit:true,
			mtype:'post',
			sortorder:"desc",
			datatype:"json",
			rowNum:5,
			pager:"#jqgrid_pager",
			viewrecords:true,
			sortname:"cmCode",
			rownumbers:true,
			height:170,
			jsonReader:{repeatitems:false, id:'cmCode', root:'print_data', page:'page', total:'total', records:'records'},
			colModel: [
				{label: "입출하코드", 		name: "cmCode",		hidden:true},
				{label: "농장ID", 			name: "cmFarmid",	align:'center'},
				{label: "동ID", 			name: "cmDongid",	align:'center'},
				{label: "동 이름", 			name: "fdName",		align:'center'},
				{label: "축종", 			name: "cmIntype",	align:'center'},
				{label: "입추수", 			name: "cmInsu",		align:'center'},
				{label: "산출 Ratio", 		name: "cmRatio",	align:'center'},
				{label: "입추일", 			name: "cmIndate",	align:'center'},
				{label: "출하일", 			name: "cmOutdate",	align:'center'},
			],
			onSelectRow: function(id){	
				let row = $(this).jqGrid('getRowData', id);

				code = row.cmCode;
				indate = row.cmIndate;
				outdate = row.cmOutdate;

				clear_search();
				load_data();
			},
			loadComplete:function(data){	
				if(reloaded){
					let ids = jQuery("#jqgrid").jqGrid("getDataIDs");
					if(ids.length > 0){
						jQuery("#jqgrid").jqGrid("setSelection", ids[0]);
						reloaded = false;
					}
				}
			}
		});
		
		$('#jqgrid').navGrid('#jqgrid_pager',
			{ 
				edit:false, add:false, del:false, search:false, refresh: true, view: false, position:"left", cloneToTop:false 
			}
		);
	};

	// 트리뷰 버튼 클릭시 리로드 이벤트
	function act_grid_data(action){
		switch(action){
			default:
				reloaded = true;
				jQuery("#jqgrid").jqGrid('setGridParam', {postData:{"select" : action}}).trigger("reloadGrid");	//POST 형식의 parameter 추가
				
				break;
		}
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
			}

			data_arr['term'] = $("#btn_excel_avg").attr("selection");
			
			$.ajax({url:'0204_action.php',data:data_arr,cache:false,type:'post',dataType:'json',
				success: function(data) {
					// $('#avg_weight_table').bootstrapTable('load', data.avg_weight_table); 
					// draw_select_chart("avg_weight_chart", data.avg_weight_chart, "영역차트", "Y", "N", 12);
					
					switch(data_arr['comm']){
						case "view":

							draw_select_chart("avg_weight_chart", data.avg_weight_chart, "영역차트", "Y", "N", 12);

							$('#avg_weight_table').bootstrapTable('load', data.avg_weight_table);

							break;
						case "excel":
							let excel_html = data.excel_html;
							let excel_title = data.excel_title;

							table_to_excel(excel_title, excel_html);
							break;
					}
				}
			});
		}
	};

	// // 오류이력 불러오기
	// function get_error_data(){
	// 	if(code != null && code != ""){			// "" or null 체크
	// 		var data_arr = {}; 
	// 		data_arr['oper'] = "get_error_history";
	// 		data_arr['code'] = code;
	// 		$.ajax({url:'0204_action.php',data:data_arr,cache:false,type:'post',dataType:'json',
	// 			success: function(data) {
	// 				$('#error_history_table').bootstrapTable('load', data.error_history_data); 
	// 			}
	// 		});
	// 	}
	// };
	
	// 오류이력 불러오기
	function get_error_data(sub_comm){
		if(code != null && code != ""){			// "" or null 체크
			var data_arr = {}; 
			data_arr['oper'] = "get_error_history";
			data_arr['code'] = code;

			switch(sub_comm){
				default:
					data_arr['comm'] = "view";
					break;
				case "excel":
					data_arr['comm'] = "excel";
					break;
			}

			$.ajax({url:'0204_action.php',data:data_arr,cache:false,type:'post',dataType:'json',
				success: function(data) {
					switch(data_arr['comm']){
						case "view":

							$('#error_history_table').bootstrapTable('load', data.error_history_data);

							break;

						case "excel":
							let excel_title = data.error_excel_title;
							let excel_html  = data.error_excel_html;
							
							// alert(excel_html);
							table_to_excel(excel_title,excel_html);

							break;

					}
				}
			});
		}
	};

	// 재산출 이력 불러오기
	function get_request_data(){
		if(code != null && code != ""){			// "" or null 체크
			var data_arr = {}; 
			data_arr['oper'] = "get_request_history";
			data_arr['code'] = code;
			data_arr['indate'] = indate;
			$.ajax({url:'0204_action.php',data:data_arr,cache:false,type:'post',dataType:'json',
				success: function(data) {
					$('#request_history_table').bootstrapTable('load', data.request_history_data); 

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

	// 로우데이터 불러오기
	function get_raw_data(action, type, search_map){
		$("#" + type + "_raw_data_table").bootstrapTable('showLoading');

		if(code != null && code != ""){			// "" or null 체크
			var data_arr = {}; 
			data_arr['oper'] = "get_raw_data";
			data_arr['code'] = code;
			data_arr['type'] = type;
			data_arr['action'] = action;
			data_arr['search_map'] = search_map;
			data_arr['indate'] = indate;

			$.ajax({url:'0204_action.php',data:data_arr,cache:false,type:'post',dataType:'json',
				success: function(data) {
					$("#" + type + "_raw_data_table").bootstrapTable('load', data.raw_data);
					$("#" + type + "_raw_data_table").bootstrapTable('hideLoading');

					is_load[type] = true;
				},
				complete: function(){
					$("#" + type + "_raw_data_table").bootstrapTable('hideLoading');
				}
			});
		}
	};

	// 로우데이터 검색 이벤트
	function search_raw_data(action){
		let search_map = {};
		$.each($("#raw_data_search_form").serializeArray(), function(){ 
			search_map[this.name] = this.value;
		});

		let type = $("#nav_raw_data").children(".nav-item").find("a.active").attr("id");

		get_raw_data(action, type, search_map);
	}

	// 탭버튼 선택 이벤트
	function raw_tab_click(type){
		let search_map = {};
		$.each($("#raw_data_search_form").serializeArray(), function(){ 
			search_map[this.name] = this.value;
		});

		$("#cell_raw_data_table").parent(".fixed-table-body").parent(".fixed-table-container").parent(".bootstrap-table").hide();
		$("#plc_raw_data_table").parent(".fixed-table-body").parent(".fixed-table-container").parent(".bootstrap-table").hide();
		$("#dev_raw_data_table").parent(".fixed-table-body").parent(".fixed-table-container").parent(".bootstrap-table").hide();
		$("#ext_raw_data_table").parent(".fixed-table-body").parent(".fixed-table-container").parent(".bootstrap-table").hide();

		$("#" + type + "_raw_data_table").parent(".fixed-table-body").parent(".fixed-table-container").parent(".bootstrap-table").show();

		if(!is_load[type]){
			get_raw_data("search", type, search_map);
		}
	};

	// 탭버튼 선택
	$(".tab-raw").click( function(){
		let type = $(this).attr("id");
		raw_tab_click(type);
	});


	//로우데이터 검색부 키 제한
	$("#raw_data_search_form [name=search_sdate]").on("keyup", function() { $(this).val(""); });
	$("#raw_data_search_form [name=search_edate]").on("keyup", function() { $(this).val(""); });
	$("#raw_data_search_form [name=search_stime]").on("keyup", function() { $(this).val(""); });
	$("#raw_data_search_form [name=search_etime]").on("keyup", function() { $(this).val(""); });
	$("#raw_data_search_form [name=search_limit]").on("keyup", function() {
		var temp = $(this).val();
		temp = temp.replace(/[^0-9]/,"");
		temp = temp.length > 4 ? temp.substr(0, 4) : temp;

		$(this).val(temp);
	});

	// 버퍼테이블 패딩 삭제
	function del_padding(value, row, index){
		return {
			css: {
				padding: '0px'
			}
		}
	};

</script>