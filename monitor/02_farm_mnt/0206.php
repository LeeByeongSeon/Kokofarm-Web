<?
include_once("../inc/top.php");

include_once("../common/php_module/common_func.php");

// 동 선택 콤보박스
$dong_combo_json = make_jqgrid_combo_num(32);

// 조치상태 콤보박스
$status_query = "SELECT cName1 FROM codeinfo WHERE cGroup= \"조치상태\"";
$status_combo = make_combo_by_query($status_query, "search_status", "조치상태", "cName1");
$status_combo_json = make_jqgrid_combo($status_query, "cName1");

// 작성구분 콤보박스
$write_query = "SELECT cName1 FROM codeinfo WHERE cGroup= \"작성구분\"";
$write_combo = make_combo_by_query($write_query, "search_write", "작성구분", "cName1");
$write_combo_json = make_jqgrid_combo($write_query, "cName1");

// 결함구분 콤보박스
$defect_query = "SELECT cName1 FROM codeinfo WHERE cGroup= \"결함구분\"";
$defect_combo = make_combo_by_query($defect_query, "search_defect", "결함구분", "cName1");
$defect_combo_json = make_jqgrid_combo($defect_query, "cName1");

?>

<!--결함 및 A/S 관리-->
	<article class="col-xl-10 float-right">
		<div class="jarviswidget jarviswidget-color-grey-dark no-padding" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
			<header>
				<div class="widget-header">	
					<h2><i class="fa fa-list"></i>&nbsp;결함 및 A/S 관리</h2>	
				</div>
			</header>
				
			<div class="widget-body">

				<div class="widget-body-toolbar">
					<form id="search_form" class="form-inline" onsubmit="return false;">&nbsp;&nbsp;
						<?=$status_combo?>&nbsp;&nbsp;
						<?=$write_combo?>&nbsp;&nbsp;
						<?=$defect_combo?>&nbsp;&nbsp;
						<input class="form-control" type="text" name="search_sdate" maxlength="10" placeholder="시작일" size="10" />&nbsp;~&nbsp;
						<input class="form-control" type="text" name="search_edate" maxlength="10" placeholder="종료일" size="10" />&nbsp;
						<button type="button" class="btn btn-labeled btn-primary btn-sm" onClick="act_grid_data('search')"><span class="btn-label"><i class="fa fa-search"></i></span>검색</button>&nbsp;
						<button type="button" class="btn btn-labeled btn-danger btn-sm" onClick="act_grid_data('cancle')"><span class="btn-label"><i class="fa fa-times"></i></span>취소</button>&nbsp;
						<button type="button" class="btn btn-labeled btn-secondary btn-sm" onClick="act_grid_data('excel')"><span class="btn-label"><i class="fa fa-file-excel-o"></i></span>엑셀</button>
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
include_once("0206_modal.php");
?>

<?
include_once("../inc/bottom.php");
?>

<script language="javascript">
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
			url:"0206_action.php", 
			editurl:"0206_action.php",
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
				{label: "발생일",						name: "dmStartDate",	align:'center',		editable:true, editrules:{ required: false} ,
					formoptions:{label:"발생일", rowpos:4}, 
					editoptions:{defaultValue:get_now_datetime}
				},
				{label: "작성일",						name: "dmDate",			hidden:true, 	},
				{label: "농장ID",						name: "dmFarmid",		hidden:true,		editable:true, editrules:{ required: true, edithidden: true},
					editoptions : {size:10, maxlength:15}, formoptions:{label:"농장ID", rowpos:1, colpos:1}
				},
				{label: "동ID",							name: "dmDongid",		hidden:true,		editable:true, editrules:{ required: true, edithidden: true}, 
					edittype:'select', editoptions:{value:<?=$dong_combo_json?>}, formoptions:{label:"동ID", rowpos:1, colpos:2}
				},
				{label: "농장명",						name: "fdName",			align:"center",		},
				{label: "조치상태",						name: "dmStatus",		align:'center',		editable:true, editrules:{ required: true},
					edittype:'select', editoptions : {value:<?=$status_combo_json?>}, formoptions:{label:"조치상태", rowpos:2, colpos:1}
				},
				{label: "담당자",						name: "dmActor",		hidden:true,		editable:true, editrules:{ required: false},
					formoptions:{label:"담당자", rowpos:2, colpos:2}
				},
				{label: "작성 구분",					name: "dmWrite",		align:'center',		editable:true, editrules:{ required: true},
					edittype:'select', editoptions:{value:<?=$write_combo_json?>}, formoptions:{label:"작성 구분", rowpos:3, colpos:1}
				},
				{label: "결함 구분",					name: "dmDefect",		align:'center',		editable:true, editrules:{ required: false},
					edittype:'select', editoptions:{value:<?=$defect_combo_json ?>}, formoptions:{label:"결함 구분", rowpos:3, colpos:2}
				},
				{label: "발생 장치",	name: "dmDevice",		align:'center',		editable:true, editrules:{ required: false},
					formoptions:{label:"발생 장치", rowpos:5, colpos:1}
				},
				{label: "버전(제품)",					name: "dmDeviceVer",	align:'center',		editable:true, editrules:{ required: false},
					formoptions:{label:"버전(제품)", rowpos:5, colpos:2}
				},
				{label: "문제점(현상)",					name: "dmProblem",		hidden:true,		editable:true, editrules:{ required: false, edithidden: true},
					edittype:'textarea', editoptions : { maxlength:1000, rows :2}, formoptions:{label:"문제점(현상)", rowpos:6}
				},
				{label: "원인(추정)",					name: "dmCause",		hidden:true,		editable:true, editrules:{ required: false, edithidden: true},
					edittype:'textarea', editoptions : { maxlength:1000, rows :2}, formoptions:{label:"원인(추정)", rowpos:7}
				},
				{label: "조치내용",						name: "dmAction",		hidden:true,		editable:true, editrules:{ required: false, edithidden: true},
					edittype:'textarea', editoptions : { maxlength:1000, rows :2}, formoptions:{label:"조치내용", rowpos:8}
				},
				{label: "기타",							name: "dmOthers",		hidden:true,		editable:true, editrules:{ required: false, edithidden: true},
					formoptions:{label:"기타", rowpos:9}
				},
				{label: "pk", 							name: "pk",				hidden:true },
			],
			onSelectRow: function(id){	},
			loadComplete:function(data){	},
			ondblClickRow:function(id){
				let row = $(this).jqGrid('getRowData', id);

				for(let key in row){
					try {
						document.getElementById(key).innerHTML = row[key];
					} catch (error) {
						
					}
				}

				$("#modal_detail").modal('show');	
			}
		});

		$('#jqgrid').navGrid('#jqgrid_pager',
			{ 
				edit:true, add:true, del:true, search:false, refresh: true, view: false, position:"left", cloneToTop:false 
			},
			{ 
				beforeInitData:function(){
					$("#jqgrid").setColProp('dmDongid', {editoptions:{readonly:false}} );

				},editCaption:"자료수정", recreateForm:true, checkOnUpdate:true, closeAfterEdit:true, errorTextFormat:function(data){ return 'Error: ' + data.responseText},
				beforeShowForm:function(){ // colspan="3" 추가해서 폼 맞춤
					$("#tr_dmStartDate").children("td.DataTD").attr("colspan","3")
					$("#tr_dmProblem").children("td.DataTD").attr("colspan","3")
					$("#tr_dmCause").children("td.DataTD").attr("colspan","3");
					$("#tr_dmAction").children("td.DataTD").attr("colspan","3");
					$("#tr_dmOthers").children("td.DataTD").attr("colspan","3");
				}
			},
			{	
				beforeInitData:function(){
					$("#jqgrid").setColProp('dmDongid', {editoptions:{readonly:false}} );

					if(selected_id == ""){
						popup_alert("농장 미선택", "농장을 먼저 선택해주세요");
						return false;
					}

					var keys = selected_id.split("|");
					
					switch(keys.length){	// 농장 버튼이 선택된 경우 selected_id => KF0006 -- 동 버튼이 선택된 경우 selected_id => KF0006|01

						case 1:		//농장만 선택
							$("#jqgrid").setColProp('dmFarmid', {editoptions:{readonly:true, defaultValue:keys[0]}} );
							break;

						case 2:		//동까지 선택
							$("#jqgrid").setColProp('dmFarmid', {editoptions:{readonly:true, defaultValue:keys[0]}} );
							$("#jqgrid").setColProp('dmDongid', {editoptions:{readonly:true, defaultValue:keys[1]}} );
							
							break;
					}

				},addCaption:"자료추가", closeAfterAdd: true, recreateForm: true, errorTextFormat:function (data) {return 'Error: ' + data.responseText},
				beforeShowForm:function(){
					$("#tr_dmStartDate").children("td.DataTD").attr("colspan","3")
					$("#tr_dmProblem").children("td.DataTD").attr("colspan","3")
					$("#tr_dmCause").children("td.DataTD").attr("colspan","3");
					$("#tr_dmAction").children("td.DataTD").attr("colspan","3");
					$("#tr_dmOthers").children("td.DataTD").attr("colspan","3");
				}
			},
			{	
				beforeInitData:function(){
				},delcaption:"자료삭제", width:500, errorTextFormat:function (data) {return 'Error: ' + data.responseText}
			},
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
				$("#jqgrid").jqGrid('excelExport', {url:'0206_action.php'});
				break;
		}
	};

</script>