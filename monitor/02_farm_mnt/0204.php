
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
						<h2><i class="fa fa-file-text-o text-red"></i>&nbsp;<span class="KKF-9">출하이력</span></h2>	
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
						<h2><i class="fa fa-bar-chart-o text-orange"></i>&nbsp;<span class="KKF-42">평균중량</span></h2>	
					</div>

					<div class="widget-toolbar ml-auto">
						<div class="form-inline">
							<button type="button" class="btn btn-default btn-sm" onClick="get_avg_data('day')"  id="btn_day_avg"><span class="KKF-67">일령별</span></button>&nbsp;
							<button type="button" class="btn btn-default btn-sm" onClick="get_avg_data('time')" id="btn_time_avg"><span class="KKF-68">시간별</span></button>&nbsp;
							<button type="button" class="btn btn-warning btn-sm btn-labeled" onClick="$('#avg_weight_table_div').toggle(400)"><span class="btn-label"><i class="fa fa-table"></i></span><span class="KKF-69">표 출력</span></button>&nbsp;
							<button type="button" class="btn btn-secondary btn-sm btn-labeled" onClick="get_avg_data('excel')" selection="day" id="btn_excel_avg"><span class="btn-label"><i class="fa fa-file-excel-o"></i></span><span class="KKF-70">엑셀</span></button>
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
									<th data-field='f1' data-visible="true" data-sortable="true"><span class="KKF-71">산출시간</span></th>
									<th data-field='f2' data-visible="true" data-sortable="true"><span class="KKF-72">일령</span></th>
									<th data-field='f3' data-visible="true" data-sortable="true"><span class="KKF-73">평체</span></th>
									<th data-field='f4' data-visible="true" data-sortable="true"><span class="KKF-74">권고</span></th>
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
						<h2><i class="fa fa-file-text-o text-red"></i>&nbsp;<span class="KKF-75">오류 이력</span></h2>	
					</div>

					<div class="widget-toolbar ml-auto" style="padding-top: 4px">
						<div class="form-inline">
							<button type="button" class="btn btn-secondary btn-sm btn-labeled" onClick="get_error_data('excel')"><span class="btn-label"><i class="fa fa-file-excel-o"></i></span><span class="0204-03-btn-excel">엑셀</span></button>
						</div>
					</div>
				</header>
					
				<div class="widget-body p-2" style="height:465px;">

					<table id="error_history_table"  data-page-list="[]" data-pagination="true" data-page-list="false" data-page-size="10" data-toggle="table" style="font-size:14px">
						<thead>
							<tr>
								<th data-field='f1' data-visible="true" data-sortable="true" data-align="center"><span class="KKF-76">오류시간</span></th>
								<th data-field='f2' data-visible="true" data-sortable="true" data-align="center"><span class="KKF-77">오류상태</span></th>
								<th data-field='f3' data-visible="true" data-sortable="true" data-align="center"><span class="KKF-78">저울번호</span></th>
							</tr>
						</thead>
					</table>
					
				</div>
						
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col-xl-12">
			<div class="jarviswidget jarviswidget-color-white" id="wid-id-4" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
				<header>
					<div class="widget-header">
						<h2><i class="fa fa-file-text-o text-red"></i>&nbsp;<span>정규분포</span>
							<span class="font-sm badge bg-orange">15일령 이후 표시</span>
						</h2>
					</div>
					<div class="widget-toolbar ml-auto">
						<button type="button" class="btn btn-xl btn-default" style="height: 25px" onClick="$('#weigth_ndis_table_div').toggle(700).focus()">표 출력</button>
					</div>
				</header>
				<div class="widget-body p-2">
					<div class="col-xl-12 no-padding">
						<div id="weight_ndis_chart" style="height: 260px;"></div>
					</div>
					<div class="col-xl-12">
						<div id="weigth_ndis_table_div" style="width:100%; display: none;" tabindex="-1">
							<table id="weigth_ndis_table"  data-page-list="[]" data-pagination="true" data-page-list="false" data-page-size="50" data-sort-name="f1" data-sort-order="asc" data-toggle="table" style="font-size:14px">
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

	<!--재산출-->
	<div class="row">
		<div class="col-xl-3">
			<div class="jarviswidget jarviswidget-color-white no-padding" id="wid-id-9" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
				<header>
					<div class="widget-header">	
						<h2><i class="fa fa-file-text-o text-primary"></i>&nbsp;<span class="KKF-166">실측 중량</span></h2>	
					</div>
				</header>

				<div class="widget-body" style="height: 300px">

					<table id="measure_weight_table" data-page-list="[]" data-pagination="true" data-page-list="false" data-page-size="4" data-toggle="table" style="font-size:14px">
						<thead>
							<tr>
								<th data-field='f1' data-sortable="true" data-visible="true"><span class="KKF-167">실측시간</span></th>
								<th data-field='f2' data-visible="true"><span class="KKF-134">실측값</span></th>
								<th data-field='f3' data-visible="true"><span class="KKF-167">비고</span></th>
							</tr>
						</thead>
					</table>

					<div class="widget-body-toolbar">
						<form id="input_form" class="form-inline" onsubmit="return false;">&nbsp;&nbsp;
							<input class="form-control" type="text" name="input_date" maxlength="20" placeholder="시간" size="16" >
							<input class="form-control" type="text" name="input_val" maxlength="10" placeholder="중량" size="3" >
							<input class="form-control" type="text" name="input_prop" maxlength="10" placeholder="속성" size="3" >&nbsp;&nbsp;
							<button type="button" class="btn btn-secondary btn-sm" onClick="input_action()"><span class="KKF-">입력</span></button>
						</form>
					</div>
				</div>
						
			</div>
		</div>

		<div class="col-xl-9">
			<div class="jarviswidget jarviswidget-color-white no-padding" id="wid-id-10" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
				<header>
					<div class="widget-header">	
						<h2><i class="fa fa-check-square-o text-primary"></i>&nbsp;<span class="0204-05-hdr-title">재산출 기록</span></h2>	
					</div>
				</header>

				<div class="widget-body" style="height: 300px">	
					<table id="request_history_table"  data-page-list="[]" data-pagination="true" data-page-list="false" data-page-size="6" data-toggle="table" style="font-size:14px">
						<thead>
							<tr>
								<th data-field='f1' data-visible="true"><span class="KKF-130">완료시간</span></th>
								<th data-field='f2' data-visible="true"><span class="KKF-131">요청사항</span></th>
								<th data-field='f3' data-visible="true"><span class="KKF-132">변경사항</span></th>
								<th data-field='f4' data-visible="true"><span class="KKF-133">실측시간</span></th>
								<th data-field='f5' data-visible="true"><span class="KKF-134">실측값</span></th>
								<th data-field='f6' data-visible="true"><span class="KKF-135">재산출 전 예측</span></th>
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
						<h2><i class="fa fa-list text-primary"></i>&nbsp;<span class="KKF-94">로우데이터 확인</span></h2>	
					</div>
					<div class="widget-toolbar ml-auto" style="cursor: default">
						<span class="KKF-95 font-weight-bold text-info">※ 조회범위 설정 후 조회 버튼을 눌러주세요.</span>
					</div>
				</header>

				<div class="widget-body">

					<ul class="nav nav-tabs nav-tabs-right bordered" id="nav_raw_data" style="padding:5px;">&nbsp;&nbsp;
						<form id="raw_data_search_form" class="form-inline" onsubmit="return false;">
							<span class="fa fa-clock-o"></span>&nbsp;<span class="KKF-96">조회범위</span>&nbsp;&nbsp;
							<input class="form-control" type="text" name="search_sdate" maxlength="10" placeholder="시작일" size="10" />&nbsp;
							<input class="form-control" type="text" name="search_stime" maxlength="5" placeholder="시작시간" size="7" />
							&nbsp;&nbsp; ~ &nbsp;&nbsp;
							<input class="form-control" type="text" name="search_edate" maxlength="10" placeholder="종료일" size="10" />&nbsp;
							<input class="form-control" type="text" name="search_etime" maxlength="5" placeholder="종료시간" size="7" />&nbsp;&nbsp;
							Limit : &nbsp;<input class="form-control" type="text" name="search_limit" placeholder="1~9999" size="7" />&nbsp;&nbsp;
							<div class="form-check-inline">
								<input class="form-check-input" type="radio" name="search_order" id="order_1" value="1">
								<label class="form-check-label pt-0 KKF-101" for="order_1">오름차순</label>
							</div>
							<div class="form-check-inline">
								<input class="form-check-input" type="radio" name="search_order" id="order_2" value="-1" checked>
								<label class="form-check-label pt-0 KKF-102" for="order_2">내림차순</label>
							</div>
							<button type="button" class="btn btn-default btn-sm btn-labeled" onClick="search_raw_data('search')"><span class="btn-label"><i class="fa fa-search text-primary"></i></span><span class="KKF-81">조회</span></button>&nbsp;
							<button type="button" class="btn btn-secondary btn-sm btn-labeled" onClick="search_raw_data('excel')"><span class="btn-label"><i class="fa fa-file-excel-o"></i></span><span class="KKF-70">엑셀</span></button>
						</form>
						
						<li class="nav-item ml-auto"><a data-toggle="tab" class="KKF-103 nav-link tab-raw" id="ext">급이/급수/외기</a></li>
						<li class="nav-item"><a data-toggle="tab" class="KKF-104 nav-link tab-raw" id="dev">PLC 제어</a></li>
						<li class="nav-item"><a data-toggle="tab" class="KKF-105 nav-link tab-raw" id="plc">PLC 환경</a></li>
						<li class="nav-item"><a data-toggle="tab" class="KKF-57 nav-link active tab-raw" id="cell">IoT저울</a></li>
					</ul>

					<table id="cell_raw_data_table" data-page-list="[]" data-pagination="true" data-page-list="false" data-page-size="10" data-toggle="table" style="font-size:14px;">
						<thead>
							<tr>
								<th data-field='f1'  data-visible="true" data-sortable="true"><span class="KKF-106">획득시간</span></th>
								<th data-field='f2'  data-visible="true" data-sortable="true"><span class="KKF-107">저울ID</span></th>
								<th data-field='f3'  data-visible="true" data-sortable="true"><span class="KKF-108">온도</span>(℃)</th>
								<th data-field='f4'  data-visible="true" data-sortable="true"><span class="KKF-109">습도</span>(%)</th>
								<th data-field='f5'  data-visible="true" data-sortable="true">CO2(ppm)</th>
								<th data-field='f6'  data-visible="true" data-sortable="true">NH3(ppm)</th>
								<th data-field='f7'  data-visible="true" data-sortable="false">w01</th>
								<th data-field='f8'  data-visible="true" data-sortable="false">w02</th>
								<th data-field='f9'  data-visible="true" data-sortable="false">w03</th>
								<th data-field='f10' data-visible="true" data-sortable="false">w04</th>
								<th data-field='f11' data-visible="true" data-sortable="false">w05</th>
							</tr>
						</thead>
					</table>

					<table id="plc_raw_data_table" data-page-list="[]" data-pagination="true" data-page-list="false" data-page-size="10" data-toggle="table" style="font-size:14px;">
						<thead>
							<tr>
								<th data-field='f1' data-sortable='true'><span class="KKF-106">획득시간</span></th>
								<th data-field='f2' data-sortable='true'><span class="KKF-110">내부온도</span>(℃)</th>
								<th data-field='f3' data-sortable='true'><span class="KKF-111">내부습도</span>(%)</th>
								<th data-field='f4' data-sortable='true'><span class="KKF-112">내부CO2</span>(ppm)</th>
								<th data-field='f5' data-sortable='true'><span class="KKF-113">내부음압</span></th>
								<th data-field='f6' data-sortable='true'><span class="KKF-114">외부온도</span>(℃)</th>
								<th data-field='f7' data-sortable='true'><span class="KKF-115">외부습도</span>(%)</th>
								<th data-field='f8' data-sortable='true'><span class="KKF-116">외부NH3</span>(ppm)</th>
								<th data-field='f9' data-sortable='true'><span class="KKF-117">외부H2S</span>(ppm)</th>
							</tr>
						</thead>
					</table>

					<table id="dev_raw_data_table" data-page-list="[]" data-pagination="true" data-page-list="false" data-page-size="10" data-toggle="table" style="font-size:14px;">
						<thead>
							<tr>
								<th data-field='f1' data-sortable='true'><span class="KKF-106">획득시간</span></th>
								<th data-field='f2' data-sortable='true'><span class="KKF-118">유닛ID</span></th>
								<th data-field='f3' data-sortable='true'><span class="KKF-119">장치속성</span></th>
								<th data-field='f4' data-sortable='true'><span class="KKF-120">장치구분</span></th>
								<th data-field='f5' data-sortable='true'><span class="KKF-55">장치명</span></th>
								<th data-field='f6' data-sortable='true'><span class="KKF-121">상태</span></th>
							</tr>
						</thead>
					</table>

					<table id="ext_raw_data_table" data-page-list="[]" data-pagination="true" data-page-list="false" data-page-size="10" data-toggle="table" style="font-size:14px;">
						<thead>
							<tr>
								<th data-field='f1'  data-sortable='true'><span class="KKF-106">획득시간</span></th>
								<th data-field='f2'  data-sortable='true'><span class="KKF-122">사료빈무게</span></th>
								<th data-field='f3'  data-sortable='true'><span class="KKF-123">현재값-직전값</span></th>
								<th data-field='f4'  data-sortable='true'><span class="KKF-124">유량센서값</span></th>
								<th data-field='f5'  data-sortable='true'><span class="KKF-108">온도</span>(℃)</th>
								<th data-field='f6'  data-sortable='true'><span class="KKF-109">습도</span>(%)</th>
								<th data-field='f7'  data-sortable='true'>NH3(ppm)</th>
								<th data-field='f8'  data-sortable='true'>H2S(ppm)</span></th>
								<th data-field='f9'  data-sortable='true'><span class="KKF-125">미세먼지</span>(ppm)</th>
								<th data-field='f10' data-sortable='true'><span class="KKF-126">초미세먼지</span>(ppm)</th>
								<th data-field='f11' data-sortable='true'><span class="KKF-127">풍향</span></th>
								<th data-field='f12' data-sortable='true'><span class="KKF-128">풍속</span>(m/s)</th>
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
	var farm_name = "";

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

		$("#raw_data_search_form [name=search_stime]").clockpicker({placement: 'bottom', align: 'left', autoclose: true});		//로우데이터 검색 시작시간
		$("#raw_data_search_form [name=search_etime]").clockpicker({placement: 'bottom', align: 'left', autoclose: true});		//로우데이터 검색 종료시간

	});

	// 데이터 불러오기
	function load_data(){

		get_avg_data("day");
		get_error_data();
		get_request_data();
		get_ndis_data();
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
				{label: "입출하코드", 	name: "cmCode",		hidden:true},
				{label: "농장ID", 		name: "cmFarmid",	align:'center'},
				{label: "동ID", 		name: "cmDongid",	align:'center'},
				{label: "동 이름", 		name: "fdName",		align:'left'},
				{label: "축종", 		name: "cmIntype",	align:'center'},
				{label: "입추수", 		name: "cmInsu",		align:'center'},
				{label: "산출 Ratio", 	name: "cmRatio",	align:'center'},
				{label: "입추일", 		name: "cmIndate",	align:'center'},
				{label: "출하일", 		name: "cmOutdate",	align:'center'},
			],
			onSelectRow: function(id){	
				let row = $(this).jqGrid('getRowData', id);

				code = row.cmCode;
				indate = row.cmIndate;
				outdate = row.cmOutdate;
				farm_name = row.fdName;

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
				load_data();
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
			console.log(code);
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

	//중량별 산포도
	function get_ndis_data(){
		if(code != null && code != ""){			// "" or null 체크
			var data_arr = {};
			data_arr["oper"] = "get_ndis_chart";
			data_arr["code"] = code;

			$.ajax({
				url:"0204_action.php",
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
	}

	// 로우데이터 검색 이벤트
	function search_raw_data(action){
		let search_map = {};
		$.each($("#raw_data_search_form").serializeArray(), function(){ 
			search_map[this.name] = this.value;
		});

		let type = $("#nav_raw_data").children(".nav-item").find("a.active").attr("id");

		get_raw_data(action, type, search_map);
	}

	function input_action(){
		let input_map = {};
		$.each($("#input_form").serializeArray(), function(){ 
			input_map[this.name] = this.value;
		});

		let msg = farm_name + " " + indate + " ~ " + outdate + " 입추기간에 " + input_map["input_date"] + "에 실측한 " + input_map["input_val"] + "g 을 입력합니다.";
		msg += input_map["input_prop"] != "" ? " (" + input_map["input_prop"] + ")" : "";

		popup_confirm("실측중량 입력", msg, function(confirm){

			if(confirm){
				input_map['oper'] = "input_measure_val";
				input_map['code'] = code;

				$.ajax({url:'0204_action.php',data:input_map,cache:false,type:'post',dataType:'json',
					success: function(data) {
						get_request_data();
					}
				});
			}
		});
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