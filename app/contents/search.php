<?
	include_once("../common/common_func.php");

	$farmID=chkCHAR($_REQUEST["farmID"]);	//농장ID
	$dongID=chkCHAR($_REQUEST["dongID"]);	//동ID
	$chkInOutCode=chkCHAR($_REQUEST["chkInOutCode"]); //입추코드

?>	

	<!--제목--->
	<div class="row">
		<div class="col-xs-12">
			<div class="well" align="center">
				<h3>지난 출하내역 검색</h3>
				<h3>선택한 동 : <span class="text-danger"><strong id="selectDongName">없음</strong></span></h3>
			</div><!--well-->
		</div><!--col-xs-12-->
	</div><!--row--->

	<!---출하목록--->
	<div class="row">
		<div class="col-xs-12">
			<div class="jarviswidget jarviswidget-color-green" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-togglebutton="false">
				<header>
					<span class="widget-icon"> <i class="fa fa-bar-chart-o"></i> </span>
					<h2>지난 출하내역</h2>
				</header>
				<div class="widget-body">
					<table id="chkOutTable" data-page-list="[]" data-toggle="table" data-pagination='true' data-page-size='5' style="font-size:14px">
						<thead>
							<tr>
							<th data-field='f1' data-align="center">번호</th>
							<th data-field='f2' data-align="center" data-visible="false">chkInOutCode</th>
							<th data-field='f3' data-align="center" data-visible="false">농장ID</th>
							<th data-field='f4' data-align="center" data-visible="false">동ID</th>
							<th data-field='f5' data-align="center" data-sortable="true">동명</th>
							<th data-field='f6' data-align="center" data-sortable="true">입추일자</th>
							<th data-field='f7' data-align="center">출하일자</th>
							<th data-field='f8' data-align="center" data-visible="false">생존수</th>
							</tr>
						</thead>

					</table>
				</div><!--widget-body-->
			</div><!--widget-->
		</div><!--col-xs-12-->
	</div><!--row--->


	<!--일령별 평균중량 변화추이 -->
	<div class="row">
		<div class="col-xs-12" style="margin-top:-10px">
			<div class="jarviswidget jarviswidget-color-purple" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-togglebutton="false">
				<header>
					<span class="widget-icon"> <i class="fa fa-bar-chart-o"></i> </span>
					<h2>일령별 평균중량</h2>
					<div class="widget-toolbar">
						<button type="button" class="btn btn-default" onClick="excelConvert('일령별평균중량','alldayWeightTable')"><span class="fa fa-table"></span> Excel</button>&nbsp;&nbsp;
						<button id="toggleWeightBtn" type="button" class="btn btn-default">
							<span class="fa fa-plus"> </span>
						</button>
					</div>
				</header>
				<div class="widget-body">
					<div class="row">
						<div id="alldayWeightChart" style="height:260px;"></div>
					</div>
					<div id="toggleWeightDIV" class="row fadeInDown animated" style="display:none">
						<div class="col-xs-12">
							<table id="alldayWeightTable" data-toggle="table" style="font-size:14px">
								<thead>
									<tr>
									<th data-field='f1' data-align="center" data-sortable="true">일령<br>(Day)</th>
									<th data-field='f2' data-align="center">일령별<br>날짜</th>
									<th data-field='f3' data-align="center">권고<br>중량(g)</th>
									<th data-field='f4' data-align="center">평균<br>중량(g)</th>
									<th data-field='f5' data-align="center">표준<br>편차</th>
									<th data-field='f6' data-align="center">변이<br>계수</th>
									</tr>
								</thead>

							</table>
						</div><!--col-xs-12-->
					</div><!--row-->

				</div><!--widget-body-->
			</div><!--widget-->
		</div><!--col-xs-12-->
	</div><!--row-->

	<!--일령별 환경센서 변화 -->
	<div class="row">
		<div class="col-xs-12" style="margin-top:-10px">
			<div class="jarviswidget jarviswidget-color-blueDark" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-togglebutton="false">
				<header>
					<span class="widget-icon"> <i class="fa fa-bar-chart-o"></i> </span>
					<h2>일령별 환경센서</h2>
					<div class="widget-toolbar">
						<button type="button" class="btn btn-default" onClick="excelConvert('일령별환경센서','inoutdaySensorTable')"><span class="fa fa-table"></span> Excel</button>&nbsp;&nbsp;
						<button id="toggleSensorBtn" type="button" class="btn btn-default">
							<span class="fa fa-plus"> </span>
						</button>
					</div>
				</header>
				<div class="widget-body">
					<div class="widget-body-toolbar">
						<div id="alldayBtnGroup" class="btn-group">
							<button type="button" class="btn btn-default" onClick="getSensor(chkInOutCode,'온도','INOUTDAY');">
								<i class="fa fa-sun-o"></i>&nbsp;&nbsp;온도
							</button>
							<button type="button" class="btn btn-default" onClick="getSensor(chkInOutCode,'습도','INOUTDAY');">
								<i class="fa fa-tint"></i>&nbsp;&nbsp;습도
							</button>
							<button type="button" class="btn btn-default" onClick="getSensor(chkInOutCode,'CO2','INOUTDAY');">
								<i class="fa fa-warning"></i>&nbsp;&nbsp;이산화탄소
							</button>
							<button type="button" class="btn btn-default" onClick="getSensor(chkInOutCode,'NH3','INOUTDAY');">
								<i class="fa fa-ambulance"></i>&nbsp;&nbsp;암모니아
							</button>
						</div>
					</div><!--widget-body-toolbar-->

					<div class="row">
						<div id="inoutdaySensorChart" style="height:300px"></div>
					</div>

					<div id="toggleSensorDIV" class="row fadeInDown animated" style="display:none">
						<div class="col-xs-12">
							<table id="inoutdaySensorTable" data-toggle="table" style="font-size:14px">
								<thead>
									<tr>
									<th data-field='f1' data-align="center" data-sortable="true">일령</th>
									<th data-field='f2' data-align="center"><span>날짜</span></th>
									<th data-field='f3' data-align="center"><span>권고자료</span></th>
									<th data-field='f4' data-align="center"><span>평균자료</span></th>
									<th data-field='f5' data-align="center"><span>차이</span></th>
									</tr>
								</thead>

							</table>
						</div><!--col-xs-12-->
					</div><!--row-->
					

				</div><!--widget-body-->
			</div><!--widget-->
		</div><!--col-xs-12-->
	</div><!--row-->


<script language="javascript">
	var chkInOutCode="";
	var farmID="";
	var dongID="";
	var sensorType="온도";

	$(document).ready(function(){
		$("html, body").animate({scrollTop :0}, 0); //페이지를 상단으로 올림
		getData("<?=$farmID?>","<?=$dongID?>","<?=$chkInOutCode?>");

	});

	function getData(farmID,dongID,chkInOutCode){
		var dataArr={}; dataArr['oper']="chkOutList"; dataArr['farmID']=farmID; dataArr['dongID']=dongID;  dataArr['chkInOutCode']=chkInOutCode;
		$.ajax({url:'common_action.php',data:dataArr,cache:false,type:'post',dataType:'json',
			success: function(data) {
				$('#chkOutTable').bootstrapTable();
				$("#chkOutTable").bootstrapTable("load",data.chkOutTable); //한번더 Loading하여 Data 갱신

				$("#alldaySensorTable").bootstrapTable(); 
				$('#alldayWeightTable').bootstrapTable();

			}
		});
	}

	//Table를 클릭한 경우
	$('#chkOutTable').on('click-row.bs.table', function (e, rowData, $element) {
			$('.success').removeClass('success');
			$($element).addClass('success');

			chkInOutCode=rowData.f2;
			farmID=rowData.f3;
			dongID=rowData.f4;

			$("#selectDongName").text(rowData.f5);

			//일령별 평균중량 정보 가져오기
			getWeight(chkInOutCode,farmID,dongID);

			//일령별 센서정보 가져오기
			$("#alldayBtnGroup > button.btn:first").addClass("active");
			$("#alldayBtnGroup > button.btn:first").trigger('click');// getSensor(chkInOutCode,"온도","ALLDAY"); 와 동일
	});

	//일령별 평균중량 정보 가져오기
	function getWeight(chkInOutCode,farmID,dongID){
		var dataArr={}; dataArr['oper']="getWeight"; dataArr['chkInOutCode']=chkInOutCode;
		$.ajax({url:'common_action.php',data:dataArr,cache:false,type:'post',dataType:'json',
			success: function(data) {
				//일령별 평균중량 변화추이
				var alldayWeightChart=drawSelectChart("alldayWeightChart",data.alldayWeightChart,"세로-Bar","N","N",12);

									
				//일령별 평균중량표(Table)
				$('#alldayWeightTable').bootstrapTable();
				$("#alldayWeightTable").bootstrapTable("load",data.alldayWeightTable); //한번더 Loading하여 Data 갱신
			}
		});
	}



	//일령별 센서 Data 가져오기
	function getSensor(chkInOutCode,sensorType,prnType){
		var dataArr={}; dataArr['oper']="getSensor"; dataArr['chkInOutCode']=chkInOutCode; dataArr['sensorType']=sensorType;  dataArr['prnType']=prnType;
		$.ajax({url:'common_action.php',data:dataArr,cache:false,type:'post',dataType:'json',
			success: function(data) {

				var inoutdaySensorChart=drawBarLineChart("inoutdaySensorChart",data.inoutdaySensorChart,"N","N",12);
				$("#inoutdaySensorTable").bootstrapTable();
				$("#inoutdaySensorTable").bootstrapTable("load",data.inoutdaySensorTable); //한번더 Loading하여 Data 갱신
			}
		});
	}

	//버튼그룹
	$(".btn-group > button.btn").on("click", function(){
		$(this).addClass('active').siblings().removeClass('active');
	});

	//토글버튼
	$("#toggleWeightBtn").click(function(){
		var toggleWeightBtn=$(this).find("span").attr("class");
		if(toggleWeightBtn=="fa fa-plus"){
			$(this).find("span").attr("class","fa fa-minus");
			$("#toggleWeightDIV").show();
		}
		else{
			$(this).find("span").attr("class","fa fa-plus");
			$("#toggleWeightDIV").hide();
		}
	});
	$("#toggleSensorBtn").click(function(){
		var toggleWeightBtn=$(this).find("span").attr("class");
		if(toggleWeightBtn=="fa fa-plus"){
			$(this).find("span").attr("class","fa fa-minus");
			$("#toggleSensorDIV").show();
		}
		else{
			$(this).find("span").attr("class","fa fa-plus");
			$("#toggleSensorDIV").hide();
		}
	});
</script>