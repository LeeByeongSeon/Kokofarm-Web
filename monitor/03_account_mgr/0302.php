<?
include_once("../inc/top.php");

include_once("../common/php_module/common_func.php");

// 생계구분 콤보박스
$type_query = "SELECT cName1 FROM codeinfo WHERE cGroup= \"생계구분\"";
$type_combo_json = make_jqgrid_combo($type_query, "cName1");

// 동 선택 콤보박스
$dong_combo_json = make_jqgrid_combo_num(32);

?>
<!--농장별 동 관리-->
<article class="col-xl-10 float-right">
	<div class="row">
		<div class="col-xl-12">
			<div class="jarviswidget jarviswidget-color-grey-dark no-padding" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
				<header>
					<div class="widget-header">	
						<h2><i class="fa fa-home"></i>&nbsp;농장별 동 관리</h2>	
					</div>
					<div class="widget-toolbar ml-auto" style="padding-top: 4px">
						<div class="form-inline">
							<button class="btn btn-secondary btn-sm btn-labeled" id="btn_excel"><span class="btn-label"><i class="fa fa-file-excel-o"></i></span>엑셀</button>
						</div>
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
</article>

<?
include_once("../inc/bottom.php");
?>

<script language="javascript">
	$(document).ready(function(){

		hide_dong = true;

		get_grid_data();

		call_tree_view("", act_grid_data);
		set_tree_search(act_grid_data);
	});

	function get_grid_data(){
		$("#jqgrid").jqGrid({
			url:"0302_action.php", 
			editurl:"0302_action.php",
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
				{label: "농장ID", 	name: "fdFarmid",	align:'center', 	editable:true, editrules:{ required: true} },
				{label: "동ID",		name: "fdDongid",	align:'center',		editable:true, editrules:{ required: true},
					edittype:'select', editoptions:{value:<?=$dong_combo_json?>}
				},
				{label: "동이름",	name: "fdName",		align:'center',		editable:true, editrules:{ required: true} },
				{label: "전화번호",	name: "fdTel",		align:'center',		editable:true, editrules:{ required: true} },
				{label: "생계구분",	name: "fdType",		align:'center',		editable:true, editrules:{ required: true},
					edittype:'select', editoptions:{value:<?=$type_combo_json?>}
				},
				{label: "사육규모",	name: "fdScale",	align:'center',		editable:true, editrules:{ required: true} },
				{label: "주소",		name: "fdAddr",		align:'center',		editable:true, editrules:{ required: true} },
				{label: "위도",		name: "fdGpslat",	align:'center',		editable:true, editrules:{ required: true} },
				{label: "경도",		name: "fdGpslng",	align:'center',		editable:true, editrules:{ required: true} },
				{label: "pk", 		name: "pk",			hidden:true },
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

					if(selected_id == ""){
						popup_alert("농장 미선택", "농장을 먼저 선택해주세요");
						return false;
					}
					
					var key = selected_id;
					$("#jqgrid").setColProp('fdFarmid', {editoptions:{readonly:true, defaultValue:key}} );

				},editCaption:"자료수정", recreateForm:true, checkOnUpdate:true, closeAfterEdit:true, errorTextFormat:function(data){ return 'Error: ' + data.responseText}
			},
			{	
				beforeInitData:function(){
					if(selected_id == ""){
						popup_alert("농장 미선택", "농장을 먼저 선택해주세요");
						return false;
					}
					
					var key = selected_id;
					$("#jqgrid").setColProp('fdFarmid', {editoptions:{readonly:true, defaultValue:key}} );

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
		$("#jqgrid").jqGrid('excelExport', {url:'0302_action.php'});
    });

</script>