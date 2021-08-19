<?
include_once("../inc/top.php");

?>
<!--농장 계정 관리-->
	<article class="col-xl-12 no-padding">
		<div class="jarviswidget jarviswidget-color-grey-dark no-padding" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
			<header>
				<div class="widget-header">	
					<h2><i class="fa fa-home"></i>&nbsp;&nbsp;&nbsp;장치 요약 현황</h2>	
				</div>
				<div class="widget-toolbar">
					<div class="progress progress-striped active" rel="tooltip" data-original-title="55%" data-placement="bottom">
						<div id="state_bar" class="progress-bar bg-warning" role="progressbar" style="width: 55%">55 %</div>
					</div>
				</div>
			</header>
			<div class="widget-body">
				<div class="widget-body-toolbar">
					<form id="search_form" class="form-inline" onsubmit="return false;">&nbsp;&nbsp;
						<input class="form-control" type="text" name="search_name" maxlength="20" placeholder=" 농장명, 농장ID" size="20" >&nbsp;&nbsp;
						<button type="button" class="btn btn-primary btn-sm" onClick="search_action('search')"><span class="fa fa-search"></span>&nbsp;&nbsp;검색</button>&nbsp;&nbsp;
						<button type="button" class="btn btn-danger btn-sm" onClick="search_action('cancle')"><span class="fa fa-times"></span>&nbsp;&nbsp;취소</button>&nbsp;&nbsp;
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
		
		var progress_interval;
		var progress_cnt = 0;
		
		progress_interval = setInterval(function(){

			progress_cnt++;
			if(progress_cnt >= 60){ 
				progress_cnt = 0; 
				$("#jqgrid").trigger("reloadGrid");
			}
			else{ 
				let update_per = parseInt(progress_cnt/60*100); 
				$("#state_bar").css('width', update_per + "%"); 
				$("#state_bar").html(update_per + "%"); 
				$("#state_bar").parent().attr("data-original-title", update_per + "%");
			}
		}, 1000);
	});

	function get_grid_data(){
		$("#jqgrid").jqGrid({
			url:"0101_action.php", 
			editurl:"0101_action.php",
			styleUI:"Bootstrap",
			autowidth:true,
			shrinkToFit:true,
			mtype:'post',
			sortorder:"desc",
			datatype:"json",
			rowNum:100,
			pager:"#jqgrid_pager",
			viewrecords:true,
			sortname:"warning",
			rownumbers:true,
			height:"auto",
			jsonReader:{repeatitems:false, id:'cmCode', root:'print_data', page:'page', total:'total', records:'records'},
			colModel: [
				{label: "입출하코드", 		name: "cmCode",				hidden:true 	},
				{label: "농장ID", 			name: "cmFarmid",			hidden:true 	},
				{label: "동ID", 			name: "cmDongid",			hidden:true 	},
				{label: "농장명",			name: "fdName",				align:'center',		},
				{label: "일령",				name: "days",				align:'center',		width:"50%"},
				{label: "축종",				name: "cmIntype",			align:'center',		width:"80%"},
				{label: "저울연결",	 		name: "siSensorDate",		align:'center',		},
				{label: "온도(℃)", 		   name: "siTemp",			   align:'center',	   sortable:false},
				{label: "습도(%)",			name: "siHumi",				align:'center',		sortable:false},
				{label: "CO2(ppm)",	 		name: "siCo2",				align:'center',		sortable:false},
				{label: "NH3(ppm)", 		name: "siNh3",				align:'center',		sortable:false},
				{label: "환경경보",		 	name: "warning",			align:'center',		width:"90%"},
				{label: "평균중량(권고대비)",name: "beAvgWeight",		align:'center',		},
				{label: "네트워크",			name: "beNetwork",			align:'center',		width:"90%"},
				{label: "PLC 제어",		 	name: "bpDeviceDate",		align:'center',		},
				{label: "PLC 환경",		 	name: "bpSensorDate",		align:'center',		},
				{label: "급이/급수",		name: "sfFeedDate",			align:'center',		},
				{label: "외기환경",		 	name: "soSensorDate",		align:'center',		},
			],
			onSelectRow: function(id){		  },
			loadComplete:function(data){		},
			ondblClickRow:function(id){
				let row = $(this).jqGrid('getRowData', id);

				let farmID = row.cmFarmid;
				let dongID = row.cmDongid;

				window.location = "0102.php?farmID=" + farmID + "&dongID=" + dongID; 
			}
		});

		$('#jqgrid').navGrid('#jqgrid_pager',
			{ 
				edit:false, add:false, del:false, search:false, refresh: true, view: false, position:"left", cloneToTop:false 
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
				$("#jqgrid").jqGrid('excelExport', {url:'0101_action.php'});
				break;
		}
	};

	$("#search_form [name=search_name]").keyup(function(e){
        if(e.keyCode == 13){
            search_action("search");
        }
    });

</script>