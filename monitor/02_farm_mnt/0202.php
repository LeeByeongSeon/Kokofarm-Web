<?
include_once("../inc/top.php");

// Google Map API Key
$map_key="AIzaSyDhI36OUKqVjyFrUQYufwr80bon1Y0-hZ0";

?>

<!--전국 농장 현황-->
<article class="col-xl-10 float-right">
	<div class="row">
		<article class="col-xl-12">
			<div class="jarviswidget jarviswidget-color-darken no-padding" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
				<header>
					<div class="widget-header">	
						<h2><i class="fa fa-map-marker text-green"></i>&nbsp;전국 농장 현황</h2>	
					</div>
					<div class="widget-toolbar ml-auto" style="cursor: default">
						전체 : <span class="badge badge-default" id="farm_cnt_total">&nbsp;</span>&nbsp;
						정상 : <span class="badge badge-primary" id="farm_cnt_normal">&nbsp;</span>&nbsp;
						주의 : <span class="badge badge-success" id="farm_cnt_caution">&nbsp;</span>&nbsp;
						경고 : <span class="badge badge-warning" id="farm_cnt_warning">&nbsp;</span>&nbsp;
						위험 : <span class="badge badge-danger"  id="farm_cnt_danger">&nbsp;</span>&nbsp;&nbsp;&nbsp;
						<span class='fa fa-map-marker text-blue'> </span>&nbsp;입추&nbsp;
						<span class='fa fa-map-marker text-orange'> </span>&nbsp;출하&nbsp;
					</div>
				</header>
					
				<div class="widget-body">
					<!-- <div class="col-xl-12 d-flex w-100 h-25 justify-content-between" style="position: absolute; z-index: 1000; top:20%">
						<div class="col-xl-2 border w-25 h-25 text-center d-flex align-items-center bg-white font-lg font-weight-bold"><span>전체</span><span id=""></span></div>
						<div class="col-xl-2 border w-25 h-25 text-center d-flex align-items-center bg-white font-lg font-weight-bold"><span>정상</span><span id=""></span></div>
						<div class="col-xl-2 border w-25 h-25 text-center d-flex align-items-center bg-white font-lg font-weight-bold"><span>주의</span><span id=""></span></div>
						<div class="col-xl-2 border w-25 h-25 text-center d-flex align-items-center bg-white font-lg font-weight-bold"><span>경고</span><span id=""></span></div>
						<div class="col-xl-2 border w-25 h-25 text-center d-flex align-items-center bg-white font-lg font-weight-bold"><span>위험</span><span id=""></span></div>
					</div> -->

					<div id="map_div" style="height: 700px"></div>
					
				</div>
					
			</div>
		</article>
	</div>
</article>

<!--Modal Alert-->
<div id="farm_modal" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="top:20%">
	<div class="modal-dialog" style="max-width:50%">
		<div class="modal-content">
			<div class="modal-header">
				<h4 id="modal_alert_title" class="modal-title float-right">Modal title</h4>
				<button type="button" class="close float-left" data-dismiss="modal" aria-hidden="true">×</button>
			</div>
			<div id="modal_alert_body" class="modal-body">
				<div class="jqgrid_zone">
					<table id="jqgrid" class="jqgrid_table"></table>
					<div id="jqgrid_pager"></div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary float-left" onClick="page_move(../01_device_mnt/0102.php);">세부현황</button>
				<button type="button" class="btn btn-primary float-left" onClick="page_move(./0204.php);">출하이력</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">닫기</button>
			</div>
		</div>
	</div>
</div>

<!-- <div id="farm_modal" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="top:20%">
	<div class="modal-dialog" style="max-width:50%">
		<div class="modal-content">
			<div class="modal-header">
				<h4 id="modal_alert_title" class="modal-title float-right">Modal title</h4>
				<button type="button" class="close float-left" data-dismiss="modal" aria-hidden="true">×</button>
			</div>
			<div id="modal_alert_body" class="modal-body">
				<table id='farm_detail_table' data-page-list='[]' data-pagination='true' data-page-list='false' data-page-size='10' data-sort-name='f4' data-sort-order='desc' data-toggle='table' style='font-size:14px'>
					<thead>
						<tr>
							<th data-field='cmDongid' data-visible='true' data-sortable='true' data-align='center'>동</th>
							<th data-field='cmIntype' data-visible='true' data-sortable='true' data-align='center'>축종</th>
							<th data-field='fdScale' data-visible='true' data-sortable='true' data-align='center'>생존(수)</th>
							<th data-field='days' data-visible='true' data-sortable='true' data-align='center'>일령</th>
							<th data-field='fdOutDays' data-visible='true' data-sortable='true' data-align='center'>출하예상일령</th>
							<th data-field='beAvgWeight' data-visible='true' data-sortable='true' data-align='center'>평균중량(권고대비)</th>
							<th data-field='warning' data-visible='true' data-sortable='true' data-align='center'>환경경보</th>
						</tr>
					</thead>
				</table>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary float-left" onClick="page_move(../01_device_mnt/0102.php);">세부현황</button>
				<button type="button" class="btn btn-primary float-left" onClick="page_move(./0204.php);">출하이력</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">닫기</button>
			</div>
		</div>
	</div>
</div> -->

<?
include_once("../inc/bottom.php");
?>

<script src="https://maps.googleapis.com/maps/api/js?key=<?=$map_key?>&callback=initMap" async defer></script>

<script type="text/javascript">

	$(document).ready(function(){

		call_tree_view("", get_farm_data);
		set_tree_search(get_farm_data);

	});

	var map_data;
	var code = "";

	// $("#map_div").bind('resize',function(){ initMap(); });
	
	//구글맵 출력
	function initMap() {
		map["map_div"] = new google.maps.Map(document.getElementById("map_div"), {
			zoom:8,center:{lat:35.8391582,lng:127.0998321}
		});
		del_markers("map_div"); add_markers_modal("map_div", jQuery.makeArray(map_data));
	};

	// function get_farm_data(){
	// 	let data_arr = {};
	// 		data_arr["oper"] = "get_map";

	// 	$.ajax({
	// 		url:"0202_action.php",
	// 		type:"post",
	// 		cache:false,
	// 		data:data_arr,
	// 		dataType:"json",
	// 		success: function(data){
				
	// 			// 구글맵
	// 			let map_data = data.json_map;
	// 			del_markers("map_div"); add_markers_modal("map_div", jQuery.makeArray(map_data)); //JSON ==> javascript 배열로 변환
	// 		}
	// 	});
	// };

	function get_farm_data(){
		$("#jqgrid").jqGrid({
			url:"0202_action.php", 
			editurl:"0202_action.php",
			styleUI:"Bootstrap",
			autowidth:true,
			shrinkToFit:true,
			mtype:'post',
			sortorder:"desc",
			datatype:"json",
			rowNum:10,
			pager:"#jqgrid_pager",
			viewrecords:true,
			sortname:"warning",
			rownumbers:true,
			height:"auto",
			jsonReader:{repeatitems:false, id:'cmCode', root:'print_data', page:'page', total:'total', records:'records'},
			colModel: [
				{label: "입출하코드", 		 name: "cmCode",			hidden:true 	},
				{label: "농장ID", 			 name: "cmFarmid",			hidden:true 	},
				{label: "동ID", 			 name: "cmDongid",			align:'center', },
				{label: "농장명",			name: "fdName",				align:'center',	},
				{label: "축종",				 name: "cmIntype",			align:'center',	},
				{label: "일령",				 name: "days",				align:'center',	},
				{label: "생존수",	 		 name: "fdScale",			align:'center',	},
				{label: "출하예상일령",	 	 name: "fdOutDays",			align:'center',	},
				{label: "환경경보",		 	 name: "warning",			align:'center', },
				{label: "평균중량(권고대비)",name: "beAvgWeight",		align:'center',	},
			],
			onSelectRow: function(id){		  },
			loadComplete:function(data){	
				
				// 구글맵
				let map_data = data.json_map;
				del_markers("map_div"); add_markers_modal("map_div", jQuery.makeArray(map_data)); //JSON ==> javascript 배열로 변환

			},
		});

		$('#jqgrid').navGrid('#jqgrid_pager',
			{ 
				edit:false, add:false, del:false, search:false, refresh: true, view: false, position:"left", cloneToTop:false 
			}
		);
	};

	// 페이지 이동
	// function page_move(page){

	// 	let farmID = keys[0];
	// 	let dongID = keys.length == 2 ? keys[1] : "01";

	// 	window.location = page + "?farmID=" + farmID + "&dongID=" + dongID; 
	// };
</script>