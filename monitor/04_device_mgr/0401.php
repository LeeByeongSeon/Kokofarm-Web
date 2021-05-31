<?
include_once("../inc/top.php");
include_once("../../common/php_module/common_func.php");

// 동 선택 콤보박스
$dong_combo_json = make_jqgrid_combo_num(32);
$cell_combo_json = make_jqgrid_combo_num(10);

?>

<!--IoT 저울 관리-->
<article class="col-xl-10 float-right">
	<div class="row">
		<div class="col-xl-12">
			<div class="jarviswidget jarviswidget-color-teal no-padding" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
				<header>
					<div class="widget-header">	
						<h2><i class="fa fa-tablet"></i>&nbsp;&nbsp;&nbsp;IoT 저울 관리</h2>	
					</div>
				</header> <!--end--widget-header-->
					
				<div class="widget-body">

					<div class="jqgrid_zone">
						<table id="jqgrid" class="jqgrid_table"></table>
						<div id="jqgrid_pager"></div>
					</div>
					
				</div> <!--end--widget-body-->
						
			</div> <!--end--jarviswidget-->
		</div>
	</div>
</article>

<?
include_once("../inc/bottom.php");
?>

<script language="javascript">
	$(document).ready(function(){

		get_grid_data();

		call_tree_view("", act_grid_data);
	});

	function get_grid_data(){
		$("#jqgrid").jqGrid({
			url:"0401_action.php", 
			editurl:"0401_action.php",
			styleUI:"Bootstrap",
			autowidth:true,
			shrinkToFit:true,
			mtype:'post',
			sortorder:"asc",
			datatype:"json",
			rowNum:15,
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
				{label: "온도 센서 유무", 	name: "siHaveTemp",	align:'center',		editable:true, editrules:{ required: true} },
				{label: "습도 센서 유무", 	name: "siHaveHumi",	align:'center',		editable:true, editrules:{ required: true} },
				{label: "CO2 센서 유무", 	name: "siHaveCo2",	align:'center',		editable:true, editrules:{ required: true} },
				{label: "NH3 센서 유무", 	name: "siHaveNh3",	align:'center',		editable:true, editrules:{ required: true} },
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
					var keys = selected_id.split("|");
					
					switch(keys.length){	// 농장 버튼이 선택된 경우 selected_id => KF0006 -- 동 버튼이 선택된 경우 selected_id => KF0006|01
						case 0:		//아무것도 선택 x
							popup_alert("농장을 먼저 선택해주세요");
							return false;
							break;

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
					var keys = selected_id.split("|");
					
					switch(keys.length){	// 농장 버튼이 선택된 경우 selected_id => KF0006 -- 동 버튼이 선택된 경우 selected_id => KF0006|01
						case 0:		//아무것도 선택 x
							popup_alert("농장을 먼저 선택해주세요");
							return false;
							break;

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

	function act_grid_data(action){

		switch(action){
			default:
				jQuery("#jqgrid").jqGrid('setGridParam', {postData:{"select" : action}}).trigger("reloadGrid");	//POST 형식의 parameter 추가
				break;
		}
	}

</script>