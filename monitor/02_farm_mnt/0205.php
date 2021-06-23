<?
include_once("../inc/top.php");

include_once("../../common/php_module/common_func.php");

// 동 선택 콤보박스
$dong_combo_json = make_jqgrid_combo_num(32);

// 진행상태 콤보박스
$query = "SELECT CONCAT(cName1, '(', cName2, ')') AS cName1 FROM codeinfo WHERE cGroup= \"진행상태\"";
$stat_combo = make_combo_by_query($query, "search_stat", "진행상태", "cName1");
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
		<div class="jarviswidget jarviswidget-color-teal no-padding" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
			<header>
				<div class="widget-header">	
					<h2><i class="fa fa-list"></i>&nbsp;&nbsp;&nbsp;재산출 요청 관리</h2>	
				</div>
			</header>
			
			<div class="widget-body">

				<div class="widget-body-toolbar">
					<form id="search_form" class="form-inline" onsubmit="return false;">&nbsp;&nbsp;
						<?=$stat_combo?>&nbsp;&nbsp;
						<?=$request_combo?>&nbsp;&nbsp;
						<input class="form-control" type="text" name="search_sdate" maxlength="10" placeholder="시작일" size="10" />&nbsp;~&nbsp;
						<input class="form-control" type="text" name="search_edate" maxlength="10" placeholder="종료일" size="10" />&nbsp;
						<button type="button" class="btn btn-primary btn-sm" onClick="act_grid_data('search')"><span class="fa fa-search"></span>&nbsp;&nbsp;검색</button>&nbsp;
						<button type="button" class="btn btn-danger btn-sm" onClick="act_grid_data('cancle')"><span class="fa fa-times"></span>&nbsp;&nbsp;취소</button>&nbsp;
						<button type="button" class="btn btn-success btn-sm" onClick="act_grid_data('excel')"><span class="fa fa-file-excel-o"></span>&nbsp;&nbsp;엑셀</button>&nbsp;&nbsp;
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
			height:530,
			jsonReader:{repeatitems:false, id:'pk', root:'print_data', page:'page', total:'total', records:'records'},
			colModel: [
				{label: "요청시간", 		name: "rcRequestDate",	align:'center', width:"110%"},
				{label: "동 이름", 			name: "fdName",			align:'center', width:"100%"},
				{label: "농장",				name: "rcFarmid",		hidden:true, editable:true, editrules:{ required: true, edithidden: true}},
				{label: "동",				name: "rcDongid",		hidden:true, editable:true, editrules:{ required: true, edithidden: true}, 
					edittype:'select', editoptions:{value:<?=$dong_combo_json?>}
				},
				{label: "입추시간",			name: "cmIndate",			hidden:true,},
				{label: "입추축종",			name: "cmIntype",			hidden:true,},
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
				{label: "입추시간",	name: "rcChangeDate",	hidden:true, editable:true, editrules:{ required:false, edithidden:true}, editoptions:{placeholder:"0000-00-00 00:00:00"}
					// editoptions:{
					// 	dataInit: function(element) {
					// 		$(element).datepicker({ format: "yyyy-mm-dd", language: "kr", autoclose: true,});
					// 	}
					// }
				},
				{label: "실측시간",			name: "rcMeasureDate",	align:'center',	editable:true, width:"110%", 
					editrules:{ required:true, edithidden:true}, 
					editoptions:{placeholder:"0000-00-00 00:00:00"}
				},
				{label: "실측값",			name: "rcMeasureVal",	align:'center',		editable:true, editrules:{ required: false, edithidden: true, number: true}, width:"60%"},
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
					});
				}
				//show_data_modal(data_id);
                //$("#del_jqGridSlave").click();
			},
			onSelectRow: function(id){		  },
			loadComplete:function(data){
				
			}
		});

		$('#jqgrid').navGrid('#jqgrid_pager',
			{ 
				edit:true, add:false, del:true, search:false, refresh: true, view: false, position:"left", cloneToTop:false 
			},
			{ 
				beforeInitData:function(){
					$("#jqgrid").setColProp('rcFarmid', {editoptions:{readonly:true}} );
					$("#jqgrid").setColProp('rcDongid', {editoptions:{readonly:true}} );

				},
				beforeSubmit:function(postdata, formid){
					let valid_change_date = date_valid_check(postdata.rcChangeDate);
					let valid_measure_date = date_valid_check(postdata.rcMeasureDate);

					if(valid_change_date[0]) {return valid_change_date[1];} 
					if(valid_measure_date[0]) {return valid_measure_date[1];} 

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

					var keys = selected_id.split("|");
					
					switch(keys.length){	// 농장 버튼이 선택된 경우 selected_id => KF0006 -- 동 버튼이 선택된 경우 selected_id => KF0006|01

						case 1:		//농장만 선택
							$("#jqgrid").setColProp('rcFarmid', {editoptions:{readonly:true, defaultValue:keys[0]}} );
							break;

						case 2:		//동까지 선택
							$("#jqgrid").setColProp('rcFarmid', {editoptions:{readonly:true, defaultValue:keys[0]}} );
							$("#jqgrid").setColProp('rcDongid', {editoptions:{readonly:true, defaultValue:keys[1]}} );
							
							// 입추시간
							$("#jqgrid").setColProp('rcChangeDate', {editoptions:{defaultValue:indate}});
							break;
					}
				},
				beforeSubmit:function(postdata, formid){

					if(postdata.rcChangeDate != ""){
						let valid_change_date = date_valid_check(postdata.rcChangeDate);
						if(valid_change_date[0]) {return valid_change_date[1];} 
					}

					if(postdata.rcMeasureDate != ""){
						let valid_measure_date = date_valid_check(postdata.rcMeasureDate);
						if(valid_measure_date[0]) {return valid_measure_date[1];} 
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
	$("#btn_excel").on("click", function(){
        $("#jqgrid").jqGrid('setGridParam', {postData:{"select" : selected_id}}); //POST 형식의 parameter 추가
		$("#jqgrid").jqGrid('excelExport', {url:'0502_action.php'});
    });

	// 트리뷰 버튼 클릭시 리로드 이벤트
	function act_grid_data(action){

		let search_map = {};
		$.each($("#search_form").serializeArray(), function(){ 
			search_map[this.name] = this.value;
		});
		search_data = JSON.stringify(search_map);

		switch(action){
			default:
				if(action.split("|").length == 2){
					let temp = $("#" + action.replace("|", "\\|") + "");
					code = $(temp).attr("cmCode");
					indate = $(temp).attr("cmIndate");
					outdate = $(temp).attr("cmOutDate");
				}

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