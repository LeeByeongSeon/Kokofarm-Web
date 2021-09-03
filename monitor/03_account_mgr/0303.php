<?
include_once("../inc/top.php");

include_once("../common/php_module/common_func.php");

// 계열회사명 콤보박스
$query = "SELECT cName1 FROM codeinfo WHERE cGroup= \"계열회사명\"";
$group_combo = make_combo_by_query($query,"search_group", "계열회사명", "cName1");
$group_combo_json = make_jqgrid_combo($query, "cName1");

// 계정 구분 콤보박스
$mgr_query = "SELECT cName1 FROM codeinfo WHERE cGroup= \"계정구분\"";
$mgr_combo = make_combo_by_query($mgr_query,"search_mgr", "계정구분", "cName1");
$mgr_combo_json = make_jqgrid_combo($mgr_query, "cName1");

?>
<!--관리자 계정 관리-->
	<article class="col-xl-12 no-padding">
		<div class="jarviswidget jarviswidget-color-darken no-padding" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
			<header>
				<div class="widget-header">	
					<h2><i class="fa fa-user"></i>&nbsp;&nbsp;&nbsp;관리자 계정 관리</h2>	
				</div>
			</header>
				
			<div class="widget-body">

				<div class="widget-body-toolbar">
					<form id="search_form" class="form-inline" onsubmit="return false;">&nbsp;&nbsp;
						<?=$group_combo?>&nbsp;&nbsp;
						<?=$mgr_combo?>&nbsp;&nbsp;
						<input class="form-control" type="text" name="searchName" maxlength="20" placeholder=" 농장명, 농장ID" size="15" >&nbsp;&nbsp;
						<button type="button" class="btn btn-labeled btn-default btn-sm" onClick="search_action('search')"><span class="btn-label"><i class="fa fa-search text-primary"></i></span>검색</button>&nbsp;
						<button type="button" class="btn btn-labeled btn-default btn-sm" onClick="search_action('cancle')"><span class="btn-label"><i class="fa fa-times text-danger"></i></span>취소</button>&nbsp;
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

<?
include_once("../inc/bottom.php");
?>

<script language="javascript">
	$(document).ready(function(){

		get_grid_data();
	});

	function get_grid_data(){
		$("#jqgrid").jqGrid({
			url:"0303_action.php", 
			editurl:"0303_action.php",
			styleUI:"Bootstrap",
			autowidth:true,
			shrinkToFit:true,
			mtype:'post',
			sortorder:"asc",
			datatype:"json",
			rowNum:17,
			pager:"#jqgrid_pager",
			viewrecords:true,
			sortname:"mgrID",
			rownumbers:true,
			height:570,
			jsonReader:{repeatitems:false, id:'mgrID', root:'print_data', page:'page', total:'total', records:'records'},
			colModel: [
				{label: "아이디", 		name: "mgrID",			align:'center', 	editable:true, editrules:{ required: true} },
				{label: "비밀번호",		name: "mgrPW",			align:'center',		editable:true, editrules:{ required: true} },
				{label: "계열회사",		name: "mgrGroupName",	align:'center',		editable:true, editrules:{ required: true},
					edittype:'select', editoptions:{value:<?=$group_combo_json?>}
				},
				{label: "성명",			name: "mgrName",		align:'center',		editable:true, editrules:{ required: true} },
				{label: "이메일", 		name: "mgrEmail",		align:'center',		editable:true, editrules:{ required: true} },
				{label: "전화번호",		name: "mgrTel",			align:'center',		editable:true, editrules:{ required: true} },
				{label: "계정구분",		name: "mgrType",		align:'center',		editable:true, editrules:{ required: true},
					edittype:'select', editoptions:{value:<?=$mgr_combo_json?>}
				},
				{label: "등록일자",		name: "mgrDate",		align:'center',		editable:true, editrules:{ required: true} },
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
					$("#jqgrid").setColProp('mgrID', {editoptions:{readonly:true}} );

				},editCaption:"자료수정", recreateForm:true, checkOnUpdate:true, closeAfterEdit:true, errorTextFormat:function(data){ return 'Error: ' + data.responseText}
			},
			{	
				beforeInitData:function(){
					$("#jqgrid").setColProp('mgrID', {editoptions:{readonly:false}} );
				},addCaption:"자료추가", closeAfterAdd: true, recreateForm: true, errorTextFormat:function (data) {return 'Error: ' + data.responseText} 
			},
			{	
				beforeInitData:function(){
				},delcaption:"자료삭제", width:500, errorTextFormat:function (data) {return 'Error: ' + data.responseText}
			}
		);
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
			$("#jqgrid").jqGrid('excelExport', {url:'0303_action.php'});
			break;
		}
	};

	$("#search_form [name=search_name]").keyup(function(e){
		if(e.keyCode == 13){
			search_action("search");
		}
	});

</script>