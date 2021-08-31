<?
include_once("../inc/top.php");

include_once("../common/php_module/common_func.php");

// 동 선택 콤보박스
$dong_combo_json = make_jqgrid_combo_num(32);

$init_farm = isset($_REQUEST["farmID"]) ? $_REQUEST["farmID"] : "";
$init_dong = isset($_REQUEST["dongID"]) ? $_REQUEST["dongID"] : "";

$init_id = $init_farm != "" ? $init_farm . "|" . $init_dong : ""; 

?>
<!--급이 / 급수 / 외기 관리-->
<article class="col-xl-10 float-right">
	<div class="row">
		<div class="col-xl-7">
			<div class="jarviswidget jarviswidget-color-grey-dark no-padding" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
				<header>
					<div class="widget-header">	
						<h2><i class="fa fa-tablet"></i>&nbsp;급이센서 / 급수센서 관리</h2>	
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

		<div class="col-xl-5">
			<div class="jarviswidget jarviswidget-color-white no-padding" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
				<header>
					<div class="widget-header">	
						<h2><i class="fa fa-tablet"></i>&nbsp;외기환경센서 관리</h2>	
					</div>
					<div class="widget-toolbar ml-auto" style="padding-top: 4px">
						<div class="form-inline">
							<button class="btn btn-secondary btn-sm btn-labeled" id="btn_excel"><span class="btn-label"><i class="fa fa-file-excel-o"></i></span>엑셀</button>
						</div>
					</div>
				</header>
					
				<div class="widget-body">
					
					<div class="jqgrid_sub_zone">
						<table id="jqgrid_sub" class="jqgrid_sub_table"></table>
						<div id="jqgrid_sub_pager"></div>
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

	var init_id = "<?=$init_id?>";

	$(document).ready(function(){

		get_grid_data();
		get_sub_grid_data();

		call_tree_view("", act_grid_data);
		set_tree_search(act_grid_data);
	});

	function get_grid_data(){
		$("#jqgrid").jqGrid({
			url:"0404_action.php", 
			editurl:"0404_action.php",
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
				{label: "농장ID", 					name: "sfFarmid",	align:'center', 	editable:true, editrules:{ required: true}, width:"70%" },
				{label: "동ID",						name: "sfDongid",	align:'center',		editable:true, editrules:{ required: true}, width:"50%", 
					edittype:'select', editoptions:{value:<?=$dong_combo_json?>},
				},
				{label: "동 이름", 					name: "fdName",		align:'center' },
				{label: "사료빈 총 용량",			name: "sfFeedMax",	align:'center',		editable:true, formatter:'currency', formatoptions:{decimalPlaces:1}},
				{label: "유량센서 최대 펄스",		name: "sfWaterMax",	align:'center',		editable:true, formatter:'currency', formatoptions:{decimalPlaces:1}},
				{label: "급이/급수 설치일",			name: "sfDate",		align:'center',		editable:true,},
				{label: "pk", 						name: "pk",			hidden:true },
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
					$("#jqgrid").setColProp('sfDongid', {editoptions:{readonly:false}} );
					
					if(selected_id == ""){
						popup_alert("농장 미선택", "농장을 먼저 선택해주세요");
						return false;
					}

					var keys = selected_id.split("|");

					switch(keys.length){	// 농장 버튼이 선택된 경우 selected_id => KF0006 -- 동 버튼이 선택된 경우 selected_id => KF0006|01
						
						case 1:		//농장만 선택
							$("#jqgrid").setColProp('sfFarmid', {editoptions:{readonly:true, defaultValue:keys[0]}} );
							break;

						case 2:		//동까지 선택
							$("#jqgrid").setColProp('sfFarmid', {editoptions:{readonly:true, defaultValue:keys[0]}} );
							$("#jqgrid").setColProp('sfDongid', {editoptions:{readonly:true, defaultValue:keys[1]}} );
							break;
					}

				},editCaption:"자료수정", recreateForm:true, checkOnUpdate:true, closeAfterEdit:true, errorTextFormat:function(data){ return 'Error: ' + data.responseText}
			},
			{	
				beforeInitData:function(){
					$("#jqgrid").setColProp('sfDongid', {editoptions:{readonly:false}} );
					
					if(selected_id == ""){
						popup_alert("농장 미선택", "농장을 먼저 선택해주세요");
						return false;
					}
					
					var keys = selected_id.split("|");
					
					switch(keys.length){	// 농장 버튼이 선택된 경우 selected_id => KF0006 -- 동 버튼이 선택된 경우 selected_id => KF0006|01

						case 1:		//농장만 선택
							$("#jqgrid").setColProp('sfFarmid', {editoptions:{readonly:true, defaultValue:keys[0]}} );
							break;

						case 2:		//동까지 선택
							$("#jqgrid").setColProp('sfFarmid', {editoptions:{readonly:true, defaultValue:keys[0]}} );
							$("#jqgrid").setColProp('sfDongid', {editoptions:{readonly:true, defaultValue:keys[1]}} );
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

	function get_sub_grid_data(){
		$("#jqgrid_sub").jqGrid({
			url:"0404_sub_action.php", 
			editurl:"0404_sub_action.php",
			styleUI:"Bootstrap",
			autowidth:true,
			shrinkToFit:true,
			mtype:'post',
			sortorder:"asc",
			datatype:"json",
			rowNum:17,
			pager:"#jqgrid_sub_pager",
			viewrecords:true,
			sortname:"pk",
			rownumbers:true,
			height:570,
			jsonReader:{repeatitems:false, id:'pk', root:'print_data', page:'page', total:'total', records:'records'},
			colModel: [
				{label: "농장ID", 					name: "soFarmid",	align:'center', 	editable:true, editrules:{ required: true}, width:"70%"},
				{label: "동ID",						name: "soDongid",	align:'center',		editable:true, editrules:{ required: true}, width:"50%", 
					edittype:'select', editoptions:{value:<?=$dong_combo_json?>},
				},
				{label: "동 이름", 					name: "fdName",		align:'center' },
				{label: "외기환경센서 설치일",		name: "soDate",		align:'center',		editable:true,},
				{label: "pk", 						name: "pk",			hidden:true },
			],
			onSelectRow: function(id){		  },
			loadComplete:function(data){		}
		});

		$('#jqgrid_sub').navGrid('#jqgrid_sub_pager',
			{ 
				edit:true, add:true, del:true, search:false, refresh: true, view: false, position:"left", cloneToTop:false 
			},
			{ 
				beforeInitData:function(){
					$("#jqgrid_sub").setColProp('soDongid', {editoptions:{readonly:false}} );
					
					if(selected_id == ""){
						popup_alert("농장 미선택", "농장을 먼저 선택해주세요");
						return false;
					}

					var keys = selected_id.split("|");

					switch(keys.length){	// 농장 버튼이 선택된 경우 selected_id => KF0006 -- 동 버튼이 선택된 경우 selected_id => KF0006|01
						
						case 1:		//농장만 선택
							$("#jqgrid_sub").setColProp('soFarmid', {editoptions:{readonly:true, defaultValue:keys[0]}} );
							break;

						case 2:		//동까지 선택
							$("#jqgrid_sub").setColProp('soFarmid', {editoptions:{readonly:true, defaultValue:keys[0]}} );
							$("#jqgrid_sub").setColProp('soDongid', {editoptions:{readonly:true, defaultValue:keys[1]}} );
							break;
					}

				},editCaption:"자료수정", recreateForm:true, checkOnUpdate:true, closeAfterEdit:true, errorTextFormat:function(data){ return 'Error: ' + data.responseText}
			},
			{	
				beforeInitData:function(){
					$("#jqgrid_sub").setColProp('soDongid', {editoptions:{readonly:false}} );
					
					if(selected_id == ""){
						popup_alert("농장 미선택", "농장을 먼저 선택해주세요");
						return false;
					}
					
					var keys = selected_id.split("|");
					
					switch(keys.length){	// 농장 버튼이 선택된 경우 selected_id => KF0006 -- 동 버튼이 선택된 경우 selected_id => KF0006|01

						case 1:		//농장만 선택
							$("#jqgrid_sub").setColProp('soFarmid', {editoptions:{readonly:true, defaultValue:keys[0]}} );
							break;

						case 2:		//동까지 선택
							$("#jqgrid_sub").setColProp('soFarmid', {editoptions:{readonly:true, defaultValue:keys[0]}} );
							$("#jqgrid_sub").setColProp('soDongid', {editoptions:{readonly:true, defaultValue:keys[1]}} );
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

		if(action == "" && init_id != ""){
			click_tree_by_id(act_grid_data, init_id);
			init_id = "";
			return;
		}

		switch(action){
			default:
				jQuery("#jqgrid").jqGrid('setGridParam', {postData:{"select" : action}}).trigger("reloadGrid");	//POST 형식의 parameter 추가
				jQuery("#jqgrid_sub").jqGrid('setGridParam', {postData:{"select" : action}}).trigger("reloadGrid");	//POST 형식의 parameter 추가
				break;
		}
	};

	// 엑셀버튼 클릭 이벤트
	$("#btn_excel").on("click", function(){
        $("#jqgrid").jqGrid('setGridParam', {postData:{"select" : selected_id}}); //POST 형식의 parameter 추가
		$("#jqgrid").jqGrid('excelExport', {url:'0404_sub_action.php'});
    });

</script>