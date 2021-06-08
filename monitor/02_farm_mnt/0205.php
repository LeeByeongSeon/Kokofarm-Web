<?
include_once("../inc/top.php");

include_once("../../common/php_module/common_func.php");

// 동 선택 콤보박스
$dong_combo_json = make_jqgrid_combo_num(32);

// 진행상태 콤보박스
$stat_query = "SELECT cName1 FROM codeinfo WHERE cGroup= \"계열회사명\"";
$stat_combo = make_combo_by_query($stat_query, "search_group", "계열회사명", "cName1");
$stat_combo_json = make_jqgrid_combo($stat_query, "cName1");

// 요청시간 콤보박스
$time_query = "SELECT cName1 FROM codeinfo WHERE cGroup= \"계열회사명\"";
$time_combo = make_combo_by_query($time_query, "search_group", "계열회사명", "cName1");
$time_combo_json = make_jqgrid_combo($time_query, "cName1");

// 축종 콤보박스
$Lst_query = "SELECT cName1 FROM codeinfo WHERE cGroup= \"생계구분\"";
$Lst_combo = make_combo_by_query($Lst_query, "search_Lst", "생계구분", "cName1");
$Lst_combo_json = make_jqgrid_combo($Lst_query, "cName1");

?>

<!--재산출 요청 관리-->
<div class="row fullSc">
	<article class="col-xl-12">
		<div class="jarviswidget jarviswidget-color-teal no-padding" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
			<header>
				<div class="widget-header">	
					<h2><i class="fa fa-list"></i>&nbsp;&nbsp;&nbsp;재산출 요청 관리</h2>	
				</div>
			</header>
			
			<div class="widget-body">

				<div class="widget-body-toolbar">
					<form id="searchFORM" class="form-inline" onsubmit="return false;">&nbsp;&nbsp;
						<?=$group_combo?>&nbsp;&nbsp;
						<?=$group_combo?>&nbsp;&nbsp;
						<input type="text" id="sDate" name="sDate" class="form-control" maxlength='10' size="8" placeholder="시작일자">
						&nbsp;-&nbsp;
						<input type="text" id="eDate" name="eDate" class="form-control" maxlength='10' size="8" placeholder="종료일자">&nbsp;&nbsp;
						<input class="form-control" type="text" name="search_name" maxlength="20" placeholder=" 농장명, 농장ID" size="20" >&nbsp;&nbsp;
						<button type="button" class="btn btn-primary btn-sm" onClick="actionBtn('Search')"><span class="fa fa-search"></span>&nbsp;&nbsp;검색</button>&nbsp;
						<button type="button" class="btn btn-danger btn-sm" onClick="search_action('cancle')"><span class="fa fa-times"></span>&nbsp;&nbsp;취소</button>&nbsp;&nbsp;
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
			url:"0205_action.php", 
			editurl:"0205_action.php",
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
				{label: "요청시간", 		name: "rcRequestDate",	align:'center', 	editable:false, editrules:{ required: false}},
				{label: "농장",				name: "rcFarmid",		align:'center',		editable:true, editrules:{ required: true},  width:"55%", },
				{label: "동",				name: "rcDongid",		align:'center',		editable:true, editrules:{ required: true},  width:"30%", 
					edittype:'select', editoptions:{value:<?=$dong_combo_json?>}
				},
				{label: "요청 사항",		name: "rcCommand",		align:'center',		editable:true, editrules:{ required: true},  width:"60%", },
				{label: "진행 상태",		name: "rcStatus",		align:'center',		editable:true, editrules:{ required: false}, width:"60%", },
				{label: "승인시간",			name: "rcApproveDate",	align:'center',		editable:true, editrules:{ required: false} },
				{label: "기존 축종",		name: "rcPrevLst",		align:'center',		editable:false, editrules:{ required: false},width:"60%", },
				{label: "변경 축종",		name: "rcChangeLst",	align:'center',		editable:true, editrules:{ required: false}, width:"60%", 
					edittype:'select', editoptions:{value:<?=$Lst_combo_json?>}
				},
				{label: "기존 입추시간",	name: "rcPrevDate",		align:'center',		editable:false, editrules:{ required: false}},
				{label: "변경 입추시간",	name: "rcChangeDate",	align:'center',		editable:true, editrules:{ required: false} },
				{label: "실측시간",			name: "rcMeasureDate",	align:'center',		editable:true, editrules:{ required: false} },
				{label: "실측값",			name: "rcMeasureVal",	align:'center',		editable:true, editrules:{ required: false}, width:"80%", },
				{label: "기존 예측중량",	name: "rcPrevWeight",	align:'center',		editable:false, editrules:{ required: false},width:"80%", },
				{label: "기존 ratio",		name: "rcPrevRatio",	align:'center',		editable:false, editrules:{ required: false},width:"80%", },
				{label: "변경 ratio",		name: "rcChangeRatio",	align:'center',		editable:false, editrules:{ required: false},width:"80%", },
				{label: "완료시간",			name: "rcFinishDate",	align:'center',		editable:false, editrules:{ required: false}},
				{label: "pk", 				name: "pk",				hidden:true },
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
					$("#jqgrid").setColProp('rcDongid', {editoptions:{readonly:false}} );

				},editCaption:"자료수정", recreateForm:true, checkOnUpdate:true, closeAfterEdit:true, errorTextFormat:function(data){ return 'Error: ' + data.responseText}
			},
			{	
				beforeInitData:function(){
					$("#jqgrid").setColProp('rcDongid', {editoptions:{readonly:false}} );

				},addCaption:"자료추가", closeAfterAdd: true, recreateForm: true, errorTextFormat:function (data) {return 'Error: ' + data.responseText} 
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

</script>