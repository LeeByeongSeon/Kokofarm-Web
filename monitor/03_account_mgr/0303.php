<?
include_once("../inc/top.php");

include_once("../../common/php_module/common_func.php");

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
	<article class="col-xl-12" style="padding-left: 0rem; padding-right: 0rem;">
		<div class="jarviswidget jarviswidget-color-teal no-padding" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
			<header>
				<div class="widget-header">	
					<h2><i class="fa fa-user"></i>&nbsp;&nbsp;&nbsp;관리자 계정 관리</h2>	
				</div>
			</header>
				
			<div class="widget-body">

				<div class="widget-body-toolbar">
					<form id="searchFORM" class="form-inline" onsubmit="return false;">&nbsp;&nbsp;
						<?=$group_combo?>&nbsp;&nbsp;
						<?=$mgr_combo?>&nbsp;&nbsp;
						<input class="form-control" type="text" name="searchName" maxlength="20" placeholder=" 농장명, 농장ID" size="15" >&nbsp;&nbsp;
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
				{label: "전화번호",		name: "mgrTel",			align:'center',		editable:true, editrules:{ required: true} },
				{label: "이메일", 		name: "mgrEmail",		align:'center',		editable:true, editrules:{ required: true} },
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

	// 엑셀버튼 클릭 이벤트
	$("#btn_excel").on("click", function(){
        $("#jqgrid").jqGrid('setGridParam', {postData:{"select" : selected_id}}); //POST 형식의 parameter 추가
		$("#jqgrid").jqGrid('excelExport', {url:'0303_action.php'});
    });

</script>