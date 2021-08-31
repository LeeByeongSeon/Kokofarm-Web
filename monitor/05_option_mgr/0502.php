<?
include_once("../inc/top.php");

include_once("../common/php_module/common_func.php");

// PLC유닛 콤보박스
$pUnit_query = "SELECT suAddr FROM set_plc_unitid";
$pUnit_combo = make_combo_by_query($pUnit_query,"search_pUnit", "PLC유닛", "suAddr");
$pUnit_combo_json = make_jqgrid_combo($pUnit_query, "suAddr");

// PLC속성 콤보박스
$pProp_query = "SELECT DISTINCT(suProperty) FROM set_plc_unitid";
$pProp_combo = make_combo_by_query($pProp_query,"search_pProp", "PLC속성", "suProperty");
$pProp_combo_json = make_jqgrid_combo($pProp_query, "suProperty");

?>
<!--PLC Unit ID 관리-->
<div class="row fullSc">
	<article class="col-xl-12">
		<div class="jarviswidget jarviswidget-color-grey-dark no-padding" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
			<header>
				<div class="widget-header">	
					<h2><i class="fa fa-list"></i>&nbsp;PLC Unit ID 관리</h2>	
				</div>
			</header>
				
			<div class="widget-body">

				<div class="widget-body-toolbar">
					<form id="search_form" class="form-inline" onsubmit="return false;">
						<?=$pUnit_combo?>&nbsp;
						<?=$pProp_combo?>&nbsp;
						<button type="button" class="btn btn-labeled btn-primary btn-sm" onClick="search_action('search')"><span class="btn-label"><i class="fa fa-search"></i></span>검색</button>&nbsp;
						<button type="button" class="btn btn-labeled btn-danger btn-sm"  onClick="search_action('reset')"><span class="btn-label"><i class="fa fa-times"></i></span>취소</button>&nbsp;
						<button type="button" class="btn btn-labeled btn-secondary btn-sm" onClick="search_action('excel')"><span class="btn-label"><i class="fa fa-file-excel-o"></i></span>엑셀</button>
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

	// 검색, 취소, 엑셀 버튼 이벤트
	function search_action(action){

		var search_map = {};
		$.each($("#search_form").serializeArray(), function(){ 
			search_map[this.name] = this.value;
		});

		var search_data = JSON.stringify(search_map);	//form Data 전체를 받아 name과 value값을 JSON으로 변환(이때,"name" 과 "value"를 전송하지 않음
		switch(action){
			case "search":
				$("#jqgrid").jqGrid('setGridParam', {postData:{"search_data" : search_data}}).trigger("reloadGrid");	//POST 형식의 parameter 추가
				break;

			case "cancle":
				//초기화
				$("#search_form").each(function() {	this.reset();  });

				//리로드
				$.each($("#search_form").serializeArray(), function(){ 
					search_map[this.name] = this.value; 
				});
				search_data = JSON.stringify(search_map);
				$("#jqgrid").jqGrid('setGridParam', {postData:{"search_data" : search_data}}).trigger("reloadGrid");	//POST 형식의 parameter 추가
				break;

			case "excel":
				$("#jqgrid").jqGrid('setGridParam', {postData:{"search_data" : search_data}}); //POST 형식의 parameter 추가
				$("#jqgrid").jqGrid('excelExport', {url:'0502_action.php'});
				break;
			}
	};

	$("#search_form [name=search_name]").keyup(function(e){
		if(e.keyCode == 13){
			search_action("search");
		};
	});

</script>