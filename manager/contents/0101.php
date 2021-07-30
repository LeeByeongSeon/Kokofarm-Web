<?
include_once("../inc/top.php");

$mgrID = $_SESSION["mgrID"];
$mgrPW = $_SESSION["mgrPW"];
?>

<style>
#cameraIcon {
	position:absolute;
	max-width:100%; max-height:100%;
	width:auto; height:auto;
	margin:auto;
	top:0; bottom:0; left:0; right:0;
}
</style>

<div class="row">
	<div class="col-xs-12">
		<div class="jarviswidget jarviswidget-color-white no-padding" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
			<header style="border-radius: 10px 10px 0 0">
				<div class="widget-header">	
					<h2 class="font-weight-bold text-primary"><i class="fa fa-home text-success"></i>&nbsp;&nbsp;전국 농장 센서 현황&nbsp;</h2>	
				</div>
			</header>
			<div class="widget-body shadow" style="border-radius: 0 0 10px 10px; ">
				<div class="widget-body-toolbar">
					<form id="search_form" class="form-inline mr-auto" onsubmit="return false;">&nbsp;&nbsp;
						<select class="form-control w-auto" name="search_inout">
                            <option value=''>전체</option>
                            <option value='입추' selected>입추</option>
                            <option value='출하'>출하</option>
                        </select>&nbsp;&nbsp;
						<input class="form-control w-auto" type="text" name="search_name" maxlength="15" placeholder=" 농장명, 농장ID" size="15">&nbsp;&nbsp;
						<button type="button" class="btn btn-primary btn-sm" onClick="search_action('search')"><span class="fa fa-search"></span>&nbsp;&nbsp;검색</button>&nbsp;&nbsp;
						<button type="button" class="btn btn-danger btn-sm" onClick="search_action('cancle')"><span class="fa fa-times"></span>&nbsp;&nbsp;취소</button>&nbsp;&nbsp;
					</form>
				</div>

				<table id="farm_list_table" class="table table-bordered table-hover"
							data-detail-view="true" data-detail-formatter="get_detail_info" 
							data-page-list="[]" data-toggle="table" style="font-size:14px;cursor:pointer">
					<thead>
						<tr>
							<th data-field='f_no'		data-align="center" data-visible='false'>No</th>
							<th data-field='f_interm'	data-align="center" >일령</th>
							<th data-field='f_name'		data-align="center" data-sortable="true" data-width="150">농장명</th>
							<th data-field='f_error'	data-align="center" data-sortable="true" data-width="20">오류(수)</th>
							<th data-field='f_sensor'	data-align="center" >저울</th>
							<th data-field='f_network'	data-align="center" >통신</th>
							<th data-field='f_code'		data-align="center" data-visible='false'>f_code</th>
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
				show_loading('show');

				let data_arr = {};
				$.each($("#search_form").serializeArray(), function(){ 
					data_arr[this.name] = this.value;
				});

				data_arr["oper"] = "get_farm_list";
				
				$.ajax({
					url:'0101_action.php',
					data:data_arr,
					cache:false,
					type:'post',
					dataType:'json',
					success: function(data){
						$("#farm_list_table").bootstrapTable("load",data.farm_list_table);
						detail_data = data.farm_detail_data;
						show_loading('hide');
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
		$table = $("#farm_list_table");
		let totRec = $table.bootstrapTable('getData').length-1;
		for(let i=0; i<=totRec; i++){
			if(index != i){
				$table.bootstrapTable('collapseRow', i);
			}
		}

		$detail.html("");

		let comein_code = rowData.f_code;

		let data = detail_data[comein_code];

		let html = "";

		html += "	<div style='padding-top:10px;padding-bottom:10px'>";																																																			
		html += "			<!---농장정보---->";
		html += "			<div class='alert alert-info' role='alert'>";
		html += "				<i class='fa fa-info-circle'></i>&nbsp;&nbsp;<strong>농장정보</strong>";
		html += "			</div>";
		html += "			<p>농장 : " + data["fdName"] + " [" + data["beFarmid"] + "]</p>";
		html += "			<p>주소 : " + data["fdAddr"] + "</p>";
		html += "			<p>전화 : " + data["fdTel"] + "</p>";

		if(data["beStatus"] != "O"){		// 입추

			html += "			<!---평균중량---->";
			html += "			<div class='alert alert-success' role='alert'>";
			html += "				<i class='fa fa-info-circle'></i>&nbsp;&nbsp;<strong>평균중량(보정전)</strong>";
			html += "			</div>";
			html += "			<div class='row'>";
			html += "				<div class='col-xs-12'>";
			html += "					<div class='well'>";
			html += "						<div class='col-xs-6 no-padding' style='text-align:center'>";
			html += "							<p style='font-size:18px'>" + data["interm"] + "일령</p>";
			html += "							입추일 : " +  data["cmIndate"].substr(0, 10) + "";
			html += "						</div>";
			html += "						<div class='col-xs-6 no-padding' style='text-align:center'>";
			html += "							<p style='font-size:18px'>" + data["beAvgWeight"] + "</p>";
			html += "							산출시간 : " + data["beAvgWeightDate"] + "";
			html += "						</div>";
			html += "						<div style='clear:both'></div>";
			html += "					</div><!--well-->";

			html += "					<!--표준편차 적용-->";
			html += "					<div class='well'>";
			html += "						<div class='col-xs-4 no-padding' style='text-align:center'>";
			html += "							<span style='text-align:center;font-size:14px'>최소평체</span><br>";
			html += "							<span style='font-size:16px'><font color='blue'><i class='fa fa-caret-down'> </i></font>&nbsp;<span>" + data["min_weight"] + "</span></span>";
			html += "						</div>";
			html += "						<div class='col-xs-4 no-padding' style='text-align:center'>";
			html += "							<span style='text-align:center;font-size:14px'>표준편차</span><br>";
			html += "							<span style='font-size:16px'><span>" + data["beDevi"] + "</span></span>";
			html += "						</div>";
			html += "						<div class='col-xs-4 no-padding' style='text-align:center'>";
			html += "							<span style='text-align:center;font-size:14px'>최대평체</span><br>";
			html += "							<span style='font-size:16px'><font color='red'><i class='fa fa-caret-up'> </i></font>&nbsp;<span>" + data["max_weight"] +  "</span></span>";
			html += "						</div>";
			html += "						<div style='clear:both'></div>";
			html += "					</div><!--well-->";

			html += "				</div><!--col-xs-12-->";
			html += "			</div><!--row-->";
			html += "			<br>";

			html += "			<div class='alert alert-info' role='alert'>";
			html += "				<i class='fa-fw fa fa-warning'></i>&nbsp;&nbsp;<strong>저울 데이터</strong>";
			html += "			</div>";
			html += "			<table class='table table-bordered' style='font-size:12px;text-align:center'>";
			html += "			<tr style='background:#F6F6F6'> <td>구분</td><td>시간</td><td>온도</td><td>습도</td><td>CO2</td><td>NH3</td><td>중량</td> </tr>";

			// 저울별 데이터
			//let sensor_date = data["siSensorDate"];
			//let tokens = data["siSensorDate"].split("|");

			let temp_arr = data["siTemp"].split("|");
			let humi_arr = data["siHumi"].split("|");
			let co2_arr = data["siCo2"].split("|");
			let nh3_arr = data["siNh3"].split("|");
			let weight_arr = data["siWeight"].split("|");
			
			for(let i=0; i<temp_arr.length; i++){
				html += "<tr>";
				html += 	"<td>"+(i+1)+"번</td><td>" +data["siSensorDate"]+ "</td><td>" +temp_arr[i]+ "</td><td>" +humi_arr[i]+ "</td><td>" +co2_arr[i]+ "</td><td>" +nh3_arr[i]+ "</td><td>" +weight_arr[i]+ "</td>";
				html += "</tr>";
			}

			html += "			</table>";
			html += "			<br>";

		}

		html += "			<div class='alert alert-info' role='alert'>";
		html += "				<i class='fa-fw fa fa-camera'></i>&nbsp;&nbsp;<strong>IP 카메라</strong>";
		html += "			</div>";
		html += "			<div class='col-xs-12 no-padding'>";
		html += data["camera_html"];
		html += "			</div>";
		
		html += "	</div>";
		
		$detail.html(html);

		//console.log(detail_data[comein_code]["camera_html"]);

		//$detail.html(data.detailHTML);
		//$("#cameraDIV").attr("src",data.cameraURL);
	};

	//클릭했을때
	$('#farm_list_table').on('click-cell.bs.table', function (e, field, value, row) {
		
		if(field != "f_no"){
			let inout = $("#search_form [name=search_inout]").val();
			location.href = "0102.php?mgrID=<?=$mgrID?>&mgrPW=<?=$mgrPW?>&inout=" + inout + "&code=" + row.f_code + "&name=" + row.f_name;
		}
	});


</script>