<?
include_once("../inc/top.php");

// 진행상태 콤보박스
$query = "SELECT CONCAT(cName1, '(', cName2, ')') AS cName1 FROM codeinfo WHERE cGroup= \"진행상태\"";
$stat_combo = make_combo_by_query($query, "search_stat", "진행상태", "cName1", "R(요청)");
$stat_combo_json = make_jqgrid_combo($query, "cName1");

?>

<div class="row">
	<div class="col-xs-12">
		<div class="jarviswidget jarviswidget-color-white no-padding mb-3" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
			<header style="border-radius: 10px 10px 0px 0px; border : 4px solid #eee; border-bottom: 0; background-color: #0c6ad0;">
				<div class="widget-header">	
					<h2 class="font-weight-bold text-white"><i class="fa fa-clipboard"></i>&nbsp;재산출 요청 현황&nbsp;</h2>	
				</div>
			</header>
			<div class="widget-body no-padding" style="border-radius: 0px 0px 10px 10px; border : 4px solid #eee; border-top: 0;">
				<div class="widget-body-toolbar">
					<form id="search_form" class="form-inline mr-auto" onsubmit="return false;">
						<?=$stat_combo?>&nbsp;
						<input class="form-control w-auto" type="text" name="search_name" maxlength="20" placeholder=" 농장명" size="10">&nbsp;
						<button type="button" class="btn btn-sm btn-primary" onClick="search_action('search')"><span class="fa fa-search"></span>&nbsp;검색</button>&nbsp;
						<button type="button" class="btn btn-sm btn-danger" onClick="search_action('cancle')"><span class="fa fa-times"></span>&nbsp;취소</button>
					</form>
				</div>

				<table id="request_table" class="table table-bordered table-hover"
							data-detail-view="true" data-detail-formatter="get_detail_info" 
							data-page-list="[]" data-toggle="table" style="font-size:14px;cursor:pointer">
					<thead>
						<tr>
							<th data-field='rcFarmid'		data-align="center" data-visible='false'></th>
							<th data-field='rcDongid'		data-align="center" data-visible='false'></th>
							<th data-field='rcCode'			data-align="center" data-visible='false'></th>
							<th data-field='fdName'			data-align="center" data-sortable="true" data-width="120">농장명</th>
							<th data-field='rcRequestDate'	data-align="center" >요청시간</th>
							<th data-field='rcCommand'		data-align="center" >명령</th>
							<th data-field='rcStatus'		data-align="center" >상태</th>
						</tr>
					</thead>
				</table>

			</div>	
		</div>
	</div>
</div>

<?
include_once("../inc/bottom.php")
?>

<script language="javascript">

	var detail_data = null;

	$(document).ready(function(){
		search_action("search");
	});

	// 검색, 취소, 엑셀 버튼 이벤트
	function search_action(action){

		switch(action){
			case "search":

				let data_arr = {};
				$.each($("#search_form").serializeArray(), function(){ 
					data_arr[this.name] = this.value;
				});

				data_arr["oper"] = "get_request_list";
				
				$.ajax({
					url:'0104_action.php',
					data:data_arr,
					cache:false,
					type:'post',
					dataType:'json',
					success: function(data){
						$("#request_table").bootstrapTable("load",data.request_list);
					}
				});
				break;

			case "cancle":
				//초기화
				$("#search_form").each(function() {	this.reset();  });
				break;
		}
	};

	function get_detail_info(index, rowData, $detail){		// + 펼칠 때 이벤트
		$table = $("#request_table");
		let len = $table.bootstrapTable('getData').length-1;
		for(let i=0; i<=len; i++){
			if(index != i){
				$table.bootstrapTable('collapseRow', i);
			}
		}

		if(rowData.rcStatus != "R"){
			return;
		}
		
		//$detail.html(html);

		let data_arr = {}; 
		data_arr['oper'] = 'get_detail_data'; 
		data_arr['farmID'] = rowData.rcFarmid; 
		data_arr['dongID'] = rowData.rcDongid;
		data_arr['requestDate'] = rowData.rcRequestDate;

		$.ajax({url:'0104_action.php',data:data_arr,cache:false,type:'post',dataType:'json',
			success: function(data) {
				$detail.html(data.detail_html);

				$(".request_confirm").off("click").on("click", function(){		

					let info = $(this).attr("request_info");
					let prop = $(this).attr("confirm");

					prop = prop == "Y" ? "승인" : "거절";

					popup_confirm("재산출 요청 " + prop, data.fdName + " 농장의 재산출 요청을 " + prop + "하시겠습니까? ", 
						function(confirm){
							if(confirm){
								let confirm_data = {};
								confirm_data['oper'] = "approve";
								confirm_data['info'] = info;
								confirm_data['status'] = prop == "승인" ? "A" : "J";

								$.ajax({url:'0104_action.php',data:confirm_data,cache:false,type:'post',dataType:'json',
									success: function(data) {
										switch(data.result){
											case "ok":
												search_action("search");
												break;

											case "fail":
												alert(data.errMsg);
												search_action("search");
												break;
										}
									}
								});
							}
						}
					);
				});
			}
		});
	};

</script>