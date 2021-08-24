<?
include_once("../inc/top.php");

include_once("../common/php_module/common_func.php");

// PLC유닛 콤보박스
$pUnit_query = "SELECT suAddr FROM set_plc_unitid";
$pUnit_combo = make_combo_by_query($pUnit_query,"search_pUnit", "PLC유닛", "suAddr");
$pUnit_combo_json = make_jqgrid_combo($pUnit_query, "suAddr");

// PLC속성 콤보박스
$pProp_query = "SELECT suProperty FROM set_plc_unitid";
$pProp_combo = make_combo_by_query($pProp_query,"search_pProp", "PLC속성", "suProperty");
$pProp_combo_json = make_jqgrid_combo($pProp_query, "suProperty");

?>
<!--PLC Unit ID 관리-->
<div class="row fullSc">
	<article class="col-xl-12">
		<div class="jarviswidget jarviswidget-color-teal no-padding" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
			<header>
				<div class="widget-header">	
					<h2><i class="fa fa-list"></i>&nbsp;&nbsp;&nbsp;PLC Unit ID 관리</h2>	
				</div>
			</header>
				
			<div class="widget-body">

				<div class="widget-body-toolbar">
					<form id="searchFORM" class="form-inline" onsubmit="return false;">&nbsp;&nbsp;
						<?=$pUnit_combo?>&nbsp;&nbsp;
						<?=$pProp_combo?>&nbsp;&nbsp;
						<button type="button" class="btn btn-primary btn-sm" onClick="actionBtn('Search')"><span class="fa fa-search"></span>&nbsp;&nbsp;검색</button>&nbsp;
						<button type="button" class="btn btn-danger btn-sm"  onClick="actionBtn('Reset')"><span class="fa fa-times"></span>&nbsp;&nbsp;취소</button>&nbsp;
						<button type="button" class="btn btn-success btn-sm" onClick="actionBtn('Excel')"><span class="fa fa-file-excel-o"></span>&nbsp;&nbsp;엑셀</button>&nbsp;
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

		get_grid_data();

	});

	function get_grid_data(){
		$("#jqgrid").jqGrid({
			url:"0502_action.php", 
			editurl:"0502_action.php",
			styleUI:"Bootstrap",
			autowidth:true,
			shrinkToFit:true,
			mtype:'post',
			sortorder:"asc",
			datatype:"json",
			rowNum:17,
			pager:"#jqgrid_pager",
			viewrecords:true,
			sortname:"suAddr",
			rownumbers:true,
			height:570,
			jsonReader:{repeatitems:false, id:'suAddr', root:'print_data', page:'page', total:'total', records:'records'},
			colModel: [
				{label: "PLC주소", 			name: "suAddr",		align:'center', 	editable:true, editrules:{ required: true} },
				{label: "PLC속성",			name: "suProperty",	align:'center',		editable:true, editrules:{ required: true} ,
					edittype:'select', editoptions:{value:<?=$pProp_combo_json?>},
				},
				{label: "장치명(유닛명)",	name: "suName",		align:'center',		editable:true, editrules:{ required: true} },
				{label: "장치설명",			name: "suRemark",	align:'center',		editable:true, editrules:{ required: true} },
				{label: "파싱규칙",			name: "suParseRule",align:'center',		editable:true, editrules:{ required: false} },
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
					$("#jqgrid").setColProp('suAddr', {editoptions:{readonly:false}} );

				},editCaption:"자료수정", recreateForm:true, checkOnUpdate:true, closeAfterEdit:true, errorTextFormat:function(data){ return 'Error: ' + data.responseText}
			},
			{	
				beforeInitData:function(){
					$("#jqgrid").setColProp('suAddr', {editoptions:{readonly:false}} );

				},addCaption:"자료추가", closeAfterAdd: true, recreateForm: true, errorTextFormat:function (data) {return 'Error: ' + data.responseText} 
			},
			{	
				beforeInitData:function(){
				},delcaption:"자료삭제", width:500, errorTextFormat:function (data) {return 'Error: ' + data.responseText}
			}
		);
	};

	// 트리뷰 버튼 클릭시 리로드 이벤트
	function act_grid_data(action){

		switch(action){
			default:
				jQuery("#jqgrid").jqGrid('setGridParam', {postData:{"select" : action}}).trigger("reloadGrid");	//POST 형식의 parameter 추가
				break;
		}
	};

	// 엑셀버튼 클릭 이벤트
	$("#btn_excel").on("click", function(){
        $("#jqgrid").jqGrid('setGridParam', {postData:{"select" : selected_id}}); //POST 형식의 parameter 추가
		$("#jqgrid").jqGrid('excelExport', {url:'0502_action.php'});
    });

</script>