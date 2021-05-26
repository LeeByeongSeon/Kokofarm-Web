<?
include_once("../inc/top.php");
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
	});

	function get_grid_data(){
		$("#jqgrid").jqGrid({
			url:"0401_action.php", 
			editurl:"0401_action.php",
			styleUI:"Bootstrap",
			autowidth:true,
			shrinkToFit:false,
			mtype:'post',
			sortorder:"desc",
			datatype:"json",
			rowNum:15,
			pager:"#jqgrid_pager",
			viewrecords:true,
			sortname:"pk",
			rownumbers:true,
			height:520,
			jsonReader:{repeatitems:false, id:'pk', root:'print_data', page:'page', total:'total', records:'records'},
			colModel: [
				{label: "농장ID", 			name: "siFarmid",	align:'center'},
				{label: "동ID",				name: "siDongid",	align:'center',		editable:true, editrules:{ required: true} },
				{label: "저울ID",			name: "siCellid",	align:'center',		editable:true, editrules:{ required: true} },
				{label: "저울 버전",		name: "siVersion",	align:'center',		editable:true, editrules:{ required: true} },
				{label: "펌웨어 버전", 		name: "siFirmware",	align:'center',		editable:true, editrules:{ required: true} },
				{label: "설치 일자", 		name: "siDate",		align:'center',		editable:true, editrules:{ required: true} },
				{label: "온도 센서 유무", 	name: "siHaveTemp",	align:'center',		editable:true, editrules:{ required: true} },
				{label: "습도 센서 유무", 	name: "siHaveHumi",	align:'center',		editable:true, editrules:{ required: true} },
				{label: "CO2 센서 유무", 	name: "siHaveCo2",	align:'center',		editable:true, editrules:{ required: true} },
				{label: "NH3 센서 유무", 	name: "siHaveNh3",	align:'center',		editable:true, editrules:{ required: true} },
				{label: "pk", 	name: "pk",	hidden:true },
			],
			onSelectRow: function(id){		},
			loadComplete:function(data){		}
		});

		$('#jqgrid').navGrid('#jqgrid_pager',
			{ 
				edit:true, add:true, del:true, search:false, refresh: true, view: false, position:"left", cloneToTop:false 
			},
			{ 
				beforeInitData:function(){
					$("#jqgrid").setColProp('siFarmid', {editoptions:{readonly:true}} );
				},editCaption:"자료수정", recreateForm:true, checkOnUpdate:true, closeAfterEdit:true, errorTextFormat:function(data){ return 'Error: ' + data.responseText}
			},
			{	
				beforeInitData:function(){
					$("#jqgrid").setColProp('siFarmid', {editoptions:{readonly:false}} );
				},addCaption:"자료추가", closeAfterAdd: true, recreateForm: true, errorTextFormat:function (data) {return 'Error: ' + data.responseText} 
			},
			{	
				beforeInitData:function(){
				},delcaption:"자료삭제", width:500, errorTextFormat:function (data) {return 'Error: ' + data.responseText}
			}
		);
	};

</script>