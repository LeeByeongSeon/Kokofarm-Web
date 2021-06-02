<?
include_once("../inc/top.php");

// 계열회사 콤보박스
$query = "SELECT cName1 FROM codeinfo WHERE cGroup= \"계열회사명\"";
$group_combo = make_combo_by_query($query, "search_group", "계열회사명", "cName1");
$group_combo_json = make_jqgrid_combo($query, "cName1");

// 동 선택 콤보박스
$dong_combo_json = make_jqgrid_combo_num(32);

?>
<!--농장 계정 관리-->
<div class="row fullSc">
	<article class="col-xl-12">
		<div class="jarviswidget jarviswidget-color-teal no-padding" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
			<header>
				<div class="widget-header">	
					<h2><i class="fa fa-home"></i>&nbsp;&nbsp;&nbsp;농장 계정 관리</h2>	
				</div>
			</header>
				
			<div class="widget-body">
				<div class="widget-body-toolbar">
					<form id="search_form" class="form-inline" onsubmit="return false;">&nbsp;&nbsp;
						<?=$group_combo?>&nbsp;&nbsp;
						<input class="form-control" type="text" name="search_name" maxlength="20" placeholder="농장명, 농장ID" size="15" >&nbsp;&nbsp;
						<button type="button" class="btn btn-primary btn-sm" onClick="actionBtn('Search')"><span class="fa fa-search"></span>&nbsp;&nbsp;검색</button>&nbsp;
						<button type="button" class="btn btn-danger btn-sm" onClick="actionBtn('Search')"><span class="fa fa-times"></span>&nbsp;&nbsp;취소</button>&nbsp;
						<button type="button" class="btn btn-success btn-sm" onClick="actionBtn('Search')"><span class="fa fa-file-excel-o"></span>&nbsp;&nbsp;엑셀</button>&nbsp;
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

		call_tree_view("", act_grid_data);
		set_tree_search(act_grid_data);
	});

	function get_grid_data(){
		$("#jqgrid").jqGrid({
			url:"0301_action.php", 
			editurl:"0301_action.php",
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
				{label: "농장ID", 			name: "siFarmid",	align:'center', 	editable:true, editrules:{ required: true} },
				{label: "동ID",				name: "siDongid",	align:'center',		editable:true, editrules:{ required: true}, 
					edittype:'select', editoptions:{value:<?=$dong_combo_json?>}
				},
				{label: "저울ID",			name: "siCellid",	align:'center',		editable:true, editrules:{ required: true}, 
					edittype:'select', editoptions:{value:<?=$cell_combo_json?>}
				},
				{label: "저울 버전",		name: "siVersion",	align:'center',		editable:true, editrules:{ required: true} },
				{label: "펌웨어 버전", 		name: "siFirmware",	align:'center',		editable:true, editrules:{ required: true} },
				{label: "설치 일자", 		name: "siDate",		align:'center',		editable:true, editrules:{ required: true} },
				{label: "온도 센서 유무", 	name: "siHaveTemp",	align:'center',		editable:true, editrules:{ required: true}, 
					edittype:'select', editoptions:{value:{'y':'설치', 'n':'없음'}, defaultValue:'y'}, 
				},
				{label: "습도 센서 유무", 	name: "siHaveHumi",	align:'center',		editable:true, editrules:{ required: true}, 
					edittype:'select', editoptions:{value:{'y':'설치', 'n':'없음'}, defaultValue:'y'}, 
				},
				{label: "CO2 센서 유무", 	name: "siHaveCo2",	align:'center',		editable:true, editrules:{ required: true}, 
					edittype:'select', editoptions:{value:{'y':'설치', 'n':'없음'}, defaultValue:'y'}, 
				},
				{label: "NH3 센서 유무", 	name: "siHaveNh3",	align:'center',		editable:true, editrules:{ required: true}, 
					edittype:'select', editoptions:{value:{'y':'설치', 'n':'없음'}, defaultValue:'n'}, 
				},
				{label: "pk", 	name: "pk",	hidden:true },
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
					$("#jqgrid").setColProp('siDongid', {editoptions:{readonly:false}} );

					if(selected_id == ""){
						popup_alert("농장 미선택", "농장을 먼저 선택해주세요");
						return false;
					}
					
					var keys = selected_id.split("|");
					
					switch(keys.length){	// 농장 버튼이 선택된 경우 selected_id => KF0006 -- 동 버튼이 선택된 경우 selected_id => KF0006|01

						case 1:		//농장만 선택
							$("#jqgrid").setColProp('siFarmid', {editoptions:{readonly:true, defaultValue:keys[0]}} );
							break;

						case 2:		//동까지 선택
							$("#jqgrid").setColProp('siFarmid', {editoptions:{readonly:true, defaultValue:keys[0]}} );
							$("#jqgrid").setColProp('siDongid', {editoptions:{readonly:true, defaultValue:keys[1]}} );
							break;
					}

				},editCaption:"자료수정", recreateForm:true, checkOnUpdate:true, closeAfterEdit:true, errorTextFormat:function(data){ return 'Error: ' + data.responseText}
			},
			{	
				beforeInitData:function(){
					$("#jqgrid").setColProp('siDongid', {editoptions:{readonly:false}} );

					if(selected_id == ""){
						popup_alert("농장 미선택", "농장을 먼저 선택해주세요");
						return false;
					}

					var keys = selected_id.split("|");
					
					switch(keys.length){	// 농장 버튼이 선택된 경우 selected_id => KF0006 -- 동 버튼이 선택된 경우 selected_id => KF0006|01

						case 1:		//농장만 선택
							$("#jqgrid").setColProp('siFarmid', {editoptions:{readonly:true, defaultValue:keys[0]}} );
							break;

						case 2:		//동까지 선택
							$("#jqgrid").setColProp('siFarmid', {editoptions:{readonly:true, defaultValue:keys[0]}} );
							$("#jqgrid").setColProp('siDongid', {editoptions:{readonly:true, defaultValue:keys[1]}} );
							break;
					}

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
		$("#jqgrid").jqGrid('excelExport', {url:'0301_action.php'});
    });

</script>