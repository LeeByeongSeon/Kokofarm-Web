<?
include_once("../inc/top.php");

include_once("../../common/php_module/common_func.php");

// 계열회사 콤보박스
$query = "SELECT cName1 FROM codeinfo WHERE cGroup= \"계열회사명\"";
$group_combo = make_combo_by_query($query, "search_group", "계열회사명", "cName1");
$group_combo_json = make_jqgrid_combo($query, "cName1");

// 동 선택 콤보박스
$dong_combo_json = make_jqgrid_combo_num(32);

?>
<!--농장 계정 관리-->
	<article class="col-xl-12" style="padding-left: 0rem; padding-right: 0rem;">
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
						<input class="form-control" type="text" name="search_name" maxlength="20" placeholder=" 농장명, 농장ID" size="20" >&nbsp;&nbsp;
						<button type="button" class="btn btn-primary btn-sm" onClick="search_action('search')"><span class="fa fa-search"></span>&nbsp;&nbsp;검색</button>&nbsp;&nbsp;
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

<?
include_once("../inc/bottom.php");
?>

<script language="javascript">
	$(document).ready(function(){

		get_grid_data();
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
			sortname:"fID",
			rownumbers:true,
			height:570,
			jsonReader:{repeatitems:false, id:'fID', root:'print_data', page:'page', total:'total', records:'records'},
			colModel: [
				{label: "농장주ID", 		name: "fID",		align:'center', 	editable:true, editrules:{ required: true} },
				{label: "농장주PW",			name: "fPW",		align:'center',		editable:true, editrules:{ required: true} },
				{label: "계열회사",			name: "fGroupName",	align:'center',		editable:true, editrules:{ required: true},
					edittype:'select', editoptions:{value:<?=$group_combo_json?>}
				},
				{label: "계열화회사ID",		name: "fGroupid",	align:'center',		editable:true },
				{label: "농장ID",	 		name: "fFarmid",	align:'center',		editable:true, editrules:{ required: true} },
				{label: "농장주명", 		name: "fCeo",		align:'center',		editable:true, editrules:{ required: true} },
				{label: "농장명",			name: "fName",		align:'center',		editable:true, editrules:{ required: true} },
				{label: "IoT 저울",	 		name: "cnt_si",		align:'center',		},
				{label: "IP 카메라", 		name: "cnt_sc",		align:'center',		},
				{label: "PLC",		 		name: "cnt_sp",		align:'center',		},
				{label: "사료빈 저울",		name: "cnt_sf",		align:'center',		},
				{label: "유량센서",			name: "cnt_sf",		align:'center',		},
				{label: "외기환경센서",		 name: "cnt_so",	align:'center',		},
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
					$("#jqgrid").setColProp('fID', {editoptions:{readonly:true}} );

				},editCaption:"자료수정", recreateForm:true, checkOnUpdate:true, closeAfterEdit:true, errorTextFormat:function(data){ return 'Error: ' + data.responseText}
			},
			{	
				beforeInitData:function(){
					$("#jqgrid").setColProp('fID', {editoptions:{readonly:false}} );
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
				$("#jqgrid").jqGrid('excelExport', {url:'0301_action.php'});
				break;
		}
	};

	$("#search_form [name=search_name]").keyup(function(e){
        if(e.keyCode == 13){
            search_action("search");
        }
    });

</script>