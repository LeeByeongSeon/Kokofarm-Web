<?
include_once("../inc/top.php");

include_once("../../common/php_module/common_func.php");

// 동 선택 콤보박스
$dong_combo_json = make_jqgrid_combo_num(32);

// 작성구분 콤보박스
$write_query = "SELECT cName1 FROM codeinfo WHERE cGroup= \"작성구분\"";
$write_combo = make_combo_by_query($write_query, "search_write", "작성구분", "cName1");
$write_combo_json = make_jqgrid_combo($write_query, "cName1");

// 결함구분 콤보박스
$defect_query = "SELECT cName1 FROM codeinfo WHERE cGroup= \"결함구분\"";
$defect_combo = make_combo_by_query($defect_query, "search_defect", "결함구분", "cName1");
$defect_combo_json = make_jqgrid_combo($defect_query, "cName1");

// 조치상태 콤보박스
$action_query = "SELECT cName1 FROM codeinfo WHERE cGroup= \"조치상태\"";
$action_combo = make_combo_by_query($action_query, "search_action", "조치상태", "cName1");
$action_combo_json = make_jqgrid_combo($action_query, "cName1");

?>

<!--결함 및 A/S 관리-->
<div class="row fullSc">
	<article class="col-xl-12 no-padding">
		<div class="jarviswidget jarviswidget-color-orange-dark no-padding" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
			<header>
				<div class="widget-header">	
					<h2><i class="fa fa-list"></i>&nbsp;&nbsp;&nbsp;결함 및 A/S 관리</h2>	
				</div>
			</header>
				
			<div class="widget-body">

				<div class="widget-body-toolbar">
					<form id="searchFORM" class="form-inline" onsubmit="return false;">&nbsp;&nbsp;
						<?=$write_combo?>&nbsp;&nbsp;
						<?=$defect_combo?>&nbsp;&nbsp;
						<input type="text" id="sDate" name="sDate" class="form-control" maxlength='10' size="10" placeholder=" 시작일자">
						&nbsp;-&nbsp;
						<input type="text" id="eDate" name="eDate" class="form-control" maxlength='10' size="10" placeholder=" 종료일자">&nbsp;&nbsp;
						<input class="form-control" type="text" name="search_name" maxlength="20" placeholder=" 농장명, 농장ID" size="20" >&nbsp;&nbsp;
						<button type="button" class="btn btn-primary btn-sm" onClick="actionBtn('Search')"><span class="fa fa-search"></span>&nbsp;&nbsp;검색</button>&nbsp;
						<button type="button" class="btn btn-danger btn-sm"  onClick="search_action('cancle')"><span class="fa fa-times"></span>&nbsp;&nbsp;취소</button>&nbsp;&nbsp;
						<button type="button" class="btn btn-success btn-sm" onClick="search_action('excel')"><span class="fa fa-file-excel-o"></span>&nbsp;&nbsp;엑셀</button>&nbsp;&nbsp;
					</form>
				</div>

				<div class="jqgrid_zone">
					<table id="jqgrid" class="jqgrid_table"></table>
					<div id="jqgrid_pager"></div>
				</div>
				
			</div>
					
		</div>
	</article>
</div>

<?
include_once("../inc/bottom.php");
?>

<script language="javascript">
	$(document).ready(function(){
		//Date Picker 선언
		$('#sDate').datepicker({ format: "yyyy-mm-dd",language: "kr",autoclose: true,});
		$('#eDate').datepicker({ format: "yyyy-mm-dd",language: "kr",autoclose: true,});

		get_grid_data();

	});

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
			rowNum:17,
			pager:"#jqgrid_pager",
			viewrecords:true,
			sortname:"pk",
			rownumbers:true,
			height:570,
			jsonReader:{repeatitems:false, id:'pk', root:'print_data', page:'page', total:'total', records:'records'},
			colModel: [
				{label: "작성일",						name: "dmDate",			align:'center', 	},
				{label: "농장ID",						name: "dmFarmid",		align:'center',		editable:true, editrules:{ required: true},
					editoptions : {size:10, maxlength:15}, formoptions:{label:"농장", rowpos:1, colpos:1}
				},
				{label: "동ID",							name: "dmDongid",		align:'center',		editable:true, editrules:{ required: true},  width:"40%", 
					edittype:'select', editoptions:{value:<?=$dong_combo_json?>}, formoptions:{label:"동", rowpos:1, colpos:2}
				},
				{label: "조치상태",						name: "dmStatus",		align:'center',		editable:true, editrules:{ required: true},
					edittype:'select', editoptions : {value:<?=$action_combo_json?>}, formoptions:{label:"조치상태", rowpos:2, colpos:1}
				},
				{label: "담당자",						name: "dmActor",		align:'center',		editable:true, editrules:{ required: false},
					formoptions:{label:"담당자", rowpos:2, colpos:2}
				},
				{label: "작성 구분",					name: "dmWrite",		align:'center',		editable:true, editrules:{ required: true},
					edittype:'select', editoptions:{value:<?=$write_combo_json?>}, formoptions:{label:"작성 구분", rowpos:3, colpos:1}
				},
				{label: "결함 구분",					name: "dmDefect",		align:'center',		editable:true, editrules:{ required: false},
					edittype:'select', editoptions:{value:<?=$defect_combo_json ?>}, formoptions:{label:"결함 구분", rowpos:3, colpos:2}
				},
				{label: "발생일",						name: "dmStartDate",	align:'center',		editable:true, editrules:{ required: false} ,
					formoptions:{label:"발생일", rowpos:4, colpos:1}, 
					editoptions:{dataInit:function(e){$(e).datepicker({dateFormat:'yy-mm-dd', language:'kr'});}, 
									defaultValue: function(){ 
													var currentTime = new Date(); 
													var month = parseInt(currentTime.getMonth() + 1); 
														month = month <= 9 ? "0" + month : month; 
													var day = currentTime.getDate(); 
														day = day <= 9 ? "0" + day : day; 
													var year = currentTime.getFullYear(); 
													
												 return year + "-" + month + "-" + day;
												}
								}
				},
				{label: "발생시간",						name: "dmStartDate",	align:'center',		editable:true, editrules:{ required: false},
					formoptions:{label:"발생시간", rowpos:4, colpos:2}
				},
				{label: "발생 장치<br>(존재 시 작성)",	name: "dmDevice",		align:'center',		editable:true, editrules:{ required: false},
					formoptions:{label:"발생 장치<br>(존재 시 작성)", rowpos:5, colpos:1}
				},
				{label: "버전(제품)",					name: "dmDeviceVer",	align:'center',		editable:true, editrules:{ required: false},
					formoptions:{label:"버전(제품)", rowpos:5, colpos:2}
				},
				{label: "문제점(현상)",					name: "dmProblem",		align:'center',		editable:true, editrules:{ required: false},
					edittype:'textarea', editoptions : { maxlength:1000, rows :2}, formoptions:{label:"문제점(현상)", rowpos:6}
				},
				{label: "원인(추정)",					name: "dmCause",		align:'center',		editable:true, editrules:{ required: false},
					edittype:'textarea', editoptions : { maxlength:1000, rows :2}, formoptions:{label:"원인(추정)", rowpos:7}
				},
				{label: "조치내용",						name: "dmAction",		align:'center',		editable:true, editrules:{ required: false},
					edittype:'textarea', editoptions : { maxlength:1000, rows :2}, formoptions:{label:"조치내용", rowpos:8}
				},
				{label: "기타",							name: "dmOthers",		align:'center',		editable:true, editrules:{ required: false},
					formoptions:{label:"기타", rowpos:9}
				},
				{label: "pk", 							name: "pk",				hidden:true },
			],
			onSelectRow: function(id){		  },
			loadComplete:function(data){		}
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
					var $tr1 = $("#tr_dmProblem").children("td.DataTD");
					$tr1.attr("colspan","3");
					var $tr2 = $("#tr_dmCause").children("td.DataTD");
					$tr2.attr("colspan","3");
					var $tr3 = $("#tr_dmAction").children("td.DataTD");
					$tr3.attr("colspan","3");
					var $tr4 = $("#tr_dmOthers").children("td.DataTD");
					$tr4.attr("colspan","3");
				}
			},
			{	
				beforeInitData:function(){
					$("#jqgrid").setColProp('dmDongid', {editoptions:{readonly:false}} );

				},addCaption:"자료추가", closeAfterAdd: true, recreateForm: true, errorTextFormat:function (data) {return 'Error: ' + data.responseText},
				beforeShowForm:function(){
					var $tr1 = $("#tr_dmProblem").children("td.DataTD");
					$tr1.attr("colspan","3");
					var $tr2 = $("#tr_dmCause").children("td.DataTD");
					$tr2.attr("colspan","3");
					var $tr3 = $("#tr_dmAction").children("td.DataTD");
					$tr3.attr("colspan","3");
					var $tr4 = $("#tr_dmOthers").children("td.DataTD");
					$tr4.attr("colspan","3");
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

</script>