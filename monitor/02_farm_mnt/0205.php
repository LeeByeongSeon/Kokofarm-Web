<?
include_once("../inc/top.php");

include_once("../common/php_module/common_func.php");

// 동 선택 콤보박스
$dong_combo_json = make_jqgrid_combo_num(32);

// 진행상태 콤보박스
$query = "SELECT CONCAT(cName1, '(', cName2, ')') AS cName1 FROM codeinfo WHERE cGroup= \"진행상태\"";
$stat_combo = make_combo_by_query($query, "search_stat", "진행상태", "cName1", "R(요청)");
$stat_combo_json = make_jqgrid_combo($query, "cName1");

// 요청구분 콤보박스
$query = "SELECT CONCAT(cName1, '(', cName2, ')') AS cName1 FROM codeinfo WHERE cGroup= \"요청구분\"";
$request_combo = make_combo_by_query($query, "search_request", "요청구분", "cName1");
$request_combo_json = make_jqgrid_combo($query, "cName1");

// 축종 콤보박스
$query = "SELECT cName1 FROM codeinfo WHERE cGroup= \"생계구분\"";
$lst_combo = make_combo_by_query($query, "search_lst", "생계구분", "cName1");
$lst_combo_json = make_jqgrid_combo($query, "cName1");

?>

<!--재산출 요청 관리-->
	<article class="col-xl-10 float-right">
		<div class="jarviswidget jarviswidget-color-gray-dark no-padding" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
			<header>
				<div class="widget-header">	
					<h2><i class="fa fa-check-square-o"></i>&nbsp;<span class="KKF-10">재산출 요청 관리</span></h2>	
				</div>
			</header>
			
			<div class="widget-body">

				<div class="widget-body-toolbar">
					<form id="search_form" class="form-inline" onsubmit="return false;">&nbsp;&nbsp;
						<?=$stat_combo?>&nbsp;&nbsp;
						<?=$request_combo?>&nbsp;&nbsp;
						<input class="form-control" type="text" name="search_sdate" maxlength="10" placeholder="시작일" size="10" />&nbsp;~&nbsp;
						<input class="form-control" type="text" name="search_edate" maxlength="10" placeholder="종료일" size="10" />&nbsp;
						<button type="button" class="btn btn-labeled btn-default btn-sm" onClick="act_grid_data('search')"><span class="btn-label"><i class="fa fa-search text-primary"></i></span><span class="KKF-31">검색</span></button>&nbsp;
						<button type="button" class="btn btn-labeled btn-default btn-sm" onClick="act_grid_data('cancle')"><span class="btn-label"><i class="fa fa-times text-danger"></i></span><span class="KKF-34">취소</span></button>&nbsp;
						<button type="button" class="btn btn-labeled btn-secondary btn-sm" onClick="act_grid_data('excel')"><span class="btn-label"><i class="fa fa-file-excel-o"></i></span><span class="KKF-70">엑셀</span></button>
					</form>
				</div>

				<div class="jqgrid_zone">
					<table id="jqgrid" class="jqgrid_table"></table>
					<div id="jqgrid_pager"></div>
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
	var intype = "";

	$(document).ready(function(){
		//Date Picker 선언
		$("#search_form [name=search_sdate]").datepicker({ format: "yyyy-mm-dd", language: "kr", autoclose: true});
		$("#search_form [name=search_edate]").datepicker({ format: "yyyy-mm-dd", language: "kr", autoclose: true});

		get_grid_data();

		call_tree_view("", act_grid_data, "all");
		set_tree_search(act_grid_data, "all");

	});

	// 검색부 키 제한
	$("#search_form [name=search_sdate]").on("keyup", function() { $(this).val(""); });
	$("#search_form [name=search_edate]").on("keyup", function() { $(this).val(""); });

	function get_grid_data(){
		$("#jqgrid").jqGrid({
			url:"0205_action.php", 
			editurl:"0205_action.php",
			styleUI:"Bootstrap",
			autowidth:true,
			shrinkToFit:true,
			mtype:'post',
			sortorder:"asc",
			datatype:"json",
			rowNum:16,
			pager:"#jqgrid_pager",
			viewrecords:true,
			sortname:"pk",
			rownumbers:true,
			height:525,
			jsonReader:{repeatitems:false, id:'pk', root:'print_data', page:'page', total:'total', records:'records'},
			colModel: [
				{label: "요청시간", 		name: "rcRequestDate",	align:'center', width:"110%"},
				{label: "동 이름", 			name: "fdName",			align:'center', width:"100%"},
				{label: "농장",				name: "rcFarmid",		hidden:true, editable:true, editrules:{ required: true, edithidden: true}},
				{label: "동",				name: "rcDongid",		hidden:true, editable:true, editrules:{ required: true, edithidden: true}},
				{label: "입추시간",			name: "cmIndate",		hidden:true,},
				{label: "입추축종",			name: "cmIntype",		hidden:true,},
				{label: "진행 상태",		name: "rcStatus",		align:'center', width:"70%"},
				{label: "승인시간",			name: "rcApproveDate",	align:'center', width:"110%"},
				{label: "요청 사항",		name: "rcCommand",		align:'center',	width:"80%"},
				{label: "변경사항",			name: "rcChange",		align:'center', width:"300%"},
				{label: "기존 축종",		name: "rcPrevLst",		hidden:true, },
				{label: "축종",		name: "rcChangeLst",	hidden:true, editable:true, 
					editrules:{ required: false, edithidden: true}, 
					edittype:'select', editoptions:{value:<?=$lst_combo_json?>}
				},
				{label: "기존 입추시간",	name: "rcPrevDate",		hidden:true},
				{label: "입추시간",	name: "rcChangeDate",	hidden:true, editable:true, editrules:{ required:false, edithidden:true}, 
					editoptions:{
						placeholder:"0000-00-00 00:00:00", 
						dataInit: function(element) {
							$(element).on("keyup", function() {
								let temp = $(this).val();
								temp = force_input_date(temp);		// 데이트폼 입력 보조 함수
								$(this).val(temp);
							});
						}
					}
				},
				{label: "실측시간",			name: "rcMeasureDate",	align:'center',	editable:true, width:"110%", editrules:{edithidden:true}, 
					editoptions:{
						placeholder:"0000-00-00 00:00:00", 
						dataInit: function(element) {
							$(element).on("keyup", function() {
								let temp = $(this).val();
								temp = force_input_date(temp);		// 데이트폼 입력 보조 함수
								$(this).val(temp);
							});
						}
					}
				},
				{label: "실측값",			name: "rcMeasureVal",	align:'center',		editable:true, editrules:{edithidden: true, number: true}, width:"60%"},
				{label: "변경전 예측",		name: "rcPrevWeight",	align:'center',		 width:"60%", },
				{label: "pk", 				name: "pk",				hidden:true },
			],
			ondblClickRow: function(id){	
				let row = $(this).jqGrid('getRowData', id);
				
				let row_status = row.rcStatus.split("(")[0]
				let row_command = row.rcCommand.split("(")[0]

				if(row_status == "R"){
					let title = row.fdName + " 재산출 요청 승인";
					let msg = "";
					let now = get_now_datetime();

					msg += "<div class='well' style='padding:5px;'>";
					switch(row_command){
						case "Day":
							msg += "<div class='col-xs-12 no-padding' style='text-align:center'>일령 변경</div>";
							msg += "<div class='col-xs-5 no-padding' style='text-align:center'> <p style='font-size:13px; font-weight:bold;'>";
							msg += get_korea_date(row.rcPrevDate) + "<br>(" + get_date_diff(row.rcPrevDate, now) + "일령)</p> </div>";
							msg += "<div class='col-xs-2 no-padding' style='text-align:center'><i class='fa-fw fa fa-arrow-right'></i></div>";
							msg += "<div class='col-xs-5 no-padding' style='text-align:center'> <p style='font-size:13px; font-weight:bold;'>";
							msg += get_korea_date(row.rcChangeDate) + "<br>(" + get_date_diff(row.rcChangeDate, now) + "일령)</p> </div>";
							msg += "<div style='clear:both'></div>";
							msg += "</div>";
							break;

						case "Opt":
							msg += "<div class='col-xs-12 no-padding' style='text-align:center'>평균중량 최적화</div>";
							msg += "<div class='col-xs-5 no-padding' style='text-align:center'> <p style='font-size:13px; font-weight:bold;'>";
							msg += "예측값 : " + row.rcPrevWeight + "<br>(" + get_korea_date(row.rcMeasureDate) + ")</p> </div>";
							msg += "<div class='col-xs-2 no-padding' style='text-align:center'><i class='fa-fw fa fa-arrow-right'></i></div>";
							msg += "<div class='col-xs-5 no-padding' style='text-align:center'> <p style='font-size:13px; font-weight:bold;'>";
							msg += "실측값 : " + row.rcMeasureVal + "<br>(" + get_korea_date(row.rcMeasureDate) + ")</p> </div>";
							msg += "<div style='clear:both'></div>";
							msg += "</div>";
							break;

						case "Lst":
							msg += "<div class='col-xs-12 no-padding' style='text-align:center'>축종 변경</div>";
							msg += "<div class='col-xs-5 no-padding' style='text-align:center'> <p style='font-size:18px; font-weight:bold;'>";
							msg += row.rcPrevLst + "</p> </div>";
							msg += "<div class='col-xs-2 no-padding' style='text-align:center'><i class='fa-fw fa fa-arrow-right'></i></div>";
							msg += "<div class='col-xs-5 no-padding' style='text-align:center'> <p style='font-size:18px; font-weight:bold;'>";
							msg += row.rcChangeLst + "</p> </div>";
							msg += "<div style='clear:both'></div>";
							msg += "</div>";
							break;
					}

					popup_confirm(title, msg, function(confirm){
						let confirm_data = {};
						confirm_data['oper'] = "approve";
						confirm_data['pk'] = row.pk;
						confirm_data['status'] = confirm ? "A" : "J";

						$.ajax({url:'0205_action.php',data:confirm_data, cache:false, type:'post', dataType:'json',
							success: function(data) {
								switch(data.result){
									case "ok":
										act_grid_data("search");
										break;

									case "fail":
										popup_alert("승인 오류", data.err_msg);
										act_grid_data("search");
										break;
								}
							}
						});
					}, "승인", "거절");
				}
			},
			onSelectRow: function(id){		  },
			loadComplete:function(data){
				
			}
		});

		$('#jqgrid').navGrid('#jqgrid_pager',
			{ 
				edit:true, add:true, del:true, search:false, refresh: true, view: false, position:"left", cloneToTop:false 
			},
			{ 
				beforeInitData:function(){
					$("#jqgrid").setColProp('rcFarmid', {editoptions:{readonly:true}} );
					$("#jqgrid").setColProp('rcDongid', {editoptions:{readonly:true}} );

					$("#jqgrid").setColProp('rcChangeLst', {editoptions:{readonly:true}} );
					$("#jqgrid").setColProp('rcChangeDate', {editoptions:{readonly:true}} );
					$("#jqgrid").setColProp('rcMeasureDate', {editoptions:{readonly:true}} );
					$("#jqgrid").setColProp('rcMeasureVal', {editoptions:{readonly:true}} );

					let row_id = $("#jqgrid").jqGrid("getGridParam", "selrow");
					let row_data = $("#jqgrid").jqGrid("getRowData", row_id);

					let comm = row_data.rcCommand;

					// 요청된 명령에 대해서만 수정가능하게 조정
					if(comm.indexOf("Opt") != -1) {
						$("#jqgrid").setColProp('rcMeasureDate', {editoptions:{readonly:false}} );
						$("#jqgrid").setColProp('rcMeasureVal', {editoptions:{readonly:false}} );
					}

					if(comm.indexOf("Day") != -1) {
						$("#jqgrid").setColProp('rcChangeDate', {editoptions:{readonly:false}} );
					}

					if(comm.indexOf("Lst") != -1) {
						$("#jqgrid").setColProp('rcChangeLst', {editoptions:{readonly:false}} );
					}

				},
				beforeSubmit:function(postdata, formid){
					if(postdata.rcChangeDate != ""){
						let valid_change_date = date_valid_check(postdata.rcChangeDate);
						if(!valid_change_date[0]) {return valid_change_date;} 
					}

					if(postdata.rcMeasureDate != ""){
						let valid_measure_date = date_valid_check(postdata.rcMeasureDate);
						if(!valid_measure_date[0]) {return valid_measure_date;} 
					}

					let change_to_now = get_time_diff(postdata.rcChangeDate, get_now_datetime());			// 실측시간 - 현재시간 차이
					if(change_to_now < 60 * 30){
						return [false, "입추 후 최소 30분이 지난 후에 입력해주세요"];
					}

					if(postdata.rcMeasureVal > 500 && postdata.rcMeasureVal < 2500){	// 실측값이 존재하는 경우
						let meas_to_now = get_time_diff(postdata.rcMeasureDate, get_now_datetime());			// 실측시간 - 현재시간 차이
						if(meas_to_now < 60 * 30){		// 30분 이전의 실측 데이터만 입력 - 미래 데이터 입력 방지
							return [false, "실측 후 최소 30분이 지난 후에 입력해주세요"];
						}
					}
					else{
						if(postdata.rcMeasureVal != 0){			// 0이면 재산출 작업이 아닌것으로 판단
							return [false, "유효한 값을 입력해주세요"]; 
						}
					}

					return [true, ""];
				},
				editCaption:"재산출 요청 수정", recreateForm:true, checkOnUpdate:true, closeAfterEdit:true, errorTextFormat:function(data){ return 'Error: ' + data.responseText}
			},
			{	
				beforeInitData:function(){
					$("#jqgrid").setColProp('rcDongid', {editoptions:{readonly:false}} );

					if(selected_id == ""){
						popup_alert("농장 미선택", "농장을 먼저 선택해주세요");
						return false;
					}

					//alert("selected_id : " + selected_id + "\ncode : " + code + "\nindate : " + indate + "\noudate : " + outdate);

					if(outdate.length > 2){
						popup_alert("농장 선택 오류", "입추된 농장만 재산출 요청 가능합니다.");
						return false;
					}

					let keys = selected_id.split("|");
					let farm = keys[0];
					let dong = keys.length > 1 ? keys[1] : "01";

					$("#jqgrid").setColProp('rcFarmid', {editoptions:{readonly:true, defaultValue:farm}} );
					$("#jqgrid").setColProp('rcDongid', {editoptions:{readonly:true, defaultValue:dong}} );

					$("#jqgrid").setColProp('rcChangeDate', {editoptions:{defaultValue:indate}} );
					
				},
				beforeSubmit:function(postdata, formid){

					let comm = "";

					if(postdata.rcChangeDate != ""){
						let valid_change_date = date_valid_check(postdata.rcChangeDate);
						if(!valid_change_date[0]) {return valid_change_date;} 
					}

					if(postdata.rcMeasureDate != ""){
						let valid_measure_date = date_valid_check(postdata.rcMeasureDate);
						if(!valid_measure_date[0]) {return valid_measure_date;} 
					}

					// 실측값 입력 판단
					if(postdata.rcMeasureVal > 500 && postdata.rcMeasureVal < 2500){	// 실측값이 존재하는 경우
						let meas_to_indate = get_time_diff(indate, postdata.rcMeasureDate);		// 입추시간 - 실측시간 차이
						let meas_to_now = get_time_diff(postdata.rcMeasureDate, get_now_datetime());			// 실측시간 - 현재시간 차이

						if(meas_to_indate < (60 * 60 * 24) * 20){	// 20일 이후의 실측값만 입력 받음
							return [false, "20일령 이후의 실측값만 입력 가능"];
						}

						if(meas_to_now < 60 * 30){		// 30분 이전의 실측 데이터만 입력 - 미래 데이터 입력 방지
							return [false, "실측 후 최소 30분이 지난 후에 입력해주세요"];
						}

						comm += "Opt|";

					}
					else{
						if(postdata.rcMeasureVal != 0){			// 0이면 재산출 작업이 아닌것으로 판단
							return [false, "유효한 값을 입력해주세요"]; 
						}
					}

					// 입추일자 변경 판단
					if(postdata.rcChangeDate.substr(0, 17) != indate.substr(0, 17)){
						let change_to_now = get_time_diff(postdata.rcChangeDate, get_now_datetime());			// 실측시간 - 현재시간 차이
						if(change_to_now < 60 * 30){
							return [false, "입추 후 최소 30분이 지난 후에 입력해주세요"];
						}
						comm += "Day|";
					}

					// 축종 변경 판단
					if(postdata.rcChangeLst != intype){
						comm += "Lst|";
					}

					if(comm.length > 2){
						comm = comm.substr(0, comm.length - 1);
						postdata["rcCommand"] = comm;
						postdata["rcCode"] = code;
						postdata["rcPrevDate"] = indate;
						postdata["rcPrevLst"] = intype;
					}
					else{
						return [false, "변경된 값이 존재하지 않습니다"];
					}

					return [true, ""];
				},
				addCaption:"재산출 요청", closeAfterAdd: true, recreateForm: true, errorTextFormat:function (data) {return 'Error: ' + data.responseText} 
			},
			{	
				beforeInitData:function(){
				},delcaption:"자료삭제", width:500, errorTextFormat:function (data) {return 'Error: ' + data.responseText}
			}
		);
	};

	// 엑셀버튼 클릭 이벤트
	// $("#btn_excel").on("click", function(){
    //     $("#jqgrid").jqGrid('setGridParam', {postData:{"select" : selected_id}}); //POST 형식의 parameter 추가
	// 	$("#jqgrid").jqGrid('excelExport', {url:'0502_action.php'});
    // });

	// 트리뷰 버튼 클릭시 리로드 이벤트
	function act_grid_data(action){

		let search_map = {};
		$.each($("#search_form").serializeArray(), function(){ 
			search_map[this.name] = this.value;
		});
		search_data = JSON.stringify(search_map);

		switch(action){
			default:
				let keys = selected_id.split("|");
				let farm = keys[0];
				let dong = keys.length > 1 ? keys[1] : "01";

				let temp = $("#" + farm + "\\|" + dong + "");
				code 	= $(temp).attr("cmCode");
				indate  = $(temp).attr("cmIndate");
				outdate = $(temp).attr("cmOutDate");
				intype  = $(temp).attr("cmIntype");

				jQuery("#jqgrid").jqGrid('setGridParam', {postData:{"select" : action, "search_data" : search_data}}).trigger("reloadGrid");	//POST 형식의 parameter 추가
				break;
			
			case "search":
				jQuery("#jqgrid").jqGrid('setGridParam', {postData:{"select" : selected_id, "search_data" : search_data}}).trigger("reloadGrid");	//POST 형식의 parameter 추가
				break;

			case "cancle":
				//초기화
				$("#search_form").each(function() {	this.reset();  });

				//리로드
				$.each($("#search_form").serializeArray(), function(){ 
					search_map[this.name] = this.value; 
				});
				search_data = JSON.stringify(search_map);
				jQuery("#jqgrid").jqGrid('setGridParam', {postData:{"select" : selected_id, "search_data" : search_data}}).trigger("reloadGrid");	//POST 형식의 parameter 추가
				break;

			case "excel":
				$("#jqgrid").jqGrid('setGridParam', {postData:{"select" : selected_id, "search_data" : search_data}}); //POST 형식의 parameter 추가
				$("#jqgrid").jqGrid('excelExport', {url:'0205_action.php'});
				break;
		}
	};

</script>