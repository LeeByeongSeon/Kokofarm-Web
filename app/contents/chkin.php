<?
	include_once("../common/common_func.php");

	$farmID=chkCHAR($_REQUEST["farmID"]);	//농장ID
	$dongID=chkCHAR($_REQUEST["dongID"]);	//동ID
	$chkInOutCode=chkCHAR($_REQUEST["chkInOutCode"]); //입추코드

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

	<!--알람 메시지--->
	<div class="row" id="alarm_form">
		<div class="col-xs-12">
			<div class="alert alert-danger" role="alert" id="alarm_msg" style="text-align:center; margin:0; font-size:18px;">
				message
			</div>
		</div>
	</div><!--row--->

	<!--데이터 변경 요청-->
	<div class="row" id="request_layer">
		<div class="col-xs-12">
		<div class="jarviswidget jarviswidget-color-blue" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-togglebutton="false">
			<header>
				<span class="widget-icon"> <i class="fa fa-chevron-down"></i> </span>
				<h2>데이터 변경 요청</h2>
			</header>
			<form id="request_form" onsubmit="return false;">
				<input type="hidden" name="request_origin" value="">
				<input type="hidden" name="request_dong_name" value="">
					<div class="well">
						<label id="request_alarm" style="font-size:12px; font-weight:bold; color:#A94442"></label>
						
						<div class="well" style="margin-bottom:10px">
							<div class="col-xs-12 no-padding">
								<div class="col-xs-12 no-padding text-center"><label style="font-size:25px; font-weight:bold">일령 변경</label></div>
								<div class="col-xs-12 no-padding text-center"><label id="request_in_time" style="font-size:13px; font-weight:bold; color:#A4A4A4">현재 입추시간 : (2021-03-02 00:00)</label></div>
							</div>

							<div class="col-xs-12 no-padding">
								<div class="col-xs-3 no-padding" style="font-size:15px; height:46px; line-height:45px;">- 입추일자 </div>
								<div class="col-xs-9 no-padding">
									<select class="form-control input-lg" name="in_date" style="display:inline;">
										<option value="2021-04-26" selected>2021-04-26</option>
									</select>
								</div>
							</div>

							<div class="col-xs-12 no-padding">
								<div class="col-xs-3 no-padding" style="font-size:15px; height:46px; line-height:45px;">- 입추시간 </div>
								<div class="col-xs-4 no-padding">
									<select class="form-control input-lg" name="in_time_hour" style="display:inline;">
										<option value="11" selected>11시</option>
									</select>
								</div>

								<div class="col-xs-1 no-padding" style="font-size:20px; text-align:center; font-wieght:bold; height:46px; line-height:45px;">
									:
								</div>

								<div class="col-xs-4 no-padding">
									<select class="form-control input-lg" name="in_time_minute" style="display:inline;">
										<option value="00" >00분</option>
										<option value="10" >10분</option>
										<option value="20" >20분</option>
										<option value="30" >30분</option>
										<option value="40" >40분</option>
										<option value="50" >50분</option>
									</select>
								</div>

								<label id="request_day_alarm" style="font-size:12px; font-weight:bold; color:#A94442"></label>
							</div>

							<div style="clear:both"></div>
						</div>

						<div class="well" style="margin-bottom:10px">
							<div class="col-xs-12 no-padding">
								<div class="col-xs-12 no-padding text-center"><label style="font-size:25px; font-weight:bold">사육 변경</label></div>
							</div>
							<div class="col-xs-12 no-padding" style="height:46px; line-height:45px; font-size:15px;">
								<div class="col-xs-3 no-padding">- 축종 </div>
								
								<div class="col-xs-9 no-padding" style="height:46px; line-height:45px; font-size:15px;">
									<div class="input-group">
										<label class="vradio m-0">
											<input type="radio" class="radiobox style-0" name="changeIntype" value="육계"><span>&nbsp;육계</span>
										</label>&nbsp;&nbsp;
										<label class="vradio m-0">
											<input type="radio" class="radiobox style-0" name="changeIntype" value="삼계"><span>&nbsp;삼계</span>
										</label>&nbsp;&nbsp;
										<label class="vradio m-0">
											<input type="radio" class="radiobox style-0" name="changeIntype" value="토종닭"><span>&nbsp;토종닭</span>
										</label>
									</div><!--input-group-->
								</div>
							</div>
							<div class="col-xs-12 no-padding">
								<div class="col-xs-3 no-padding" style="height:46px; line-height:45px; font-size:15px;">- 입추수 </div>
								<div class="col-xs-9 no-padding">
									<input class="form-control input-lg" type="number" name="changeInSU" placeholder="입추수" min="0" max="99999" style="font-size:20px; display:inline;">
								</div>
							</div>

							<div style="clear:both"></div>
						</div>
						
						<div class="well" style="margin-bottom:10px">
							<div class="col-xs-12 no-padding">
								<div class="col-xs-12 no-padding text-center"><label style="font-size:25px; font-weight:bold">평균중량 재산출</label></div>
							</div>	

							<div class="col-xs-12 no-padding">
							<div class="col-xs-3 no-padding" style="font-size:15px; height:46px; line-height:45px;">- 실측일자 </div>
								<div class="col-xs-9 no-padding">
									<select class="form-control input-lg" name="measure_date" style="display:inline;">
										<option value="2021-04-26" selected>2021-04-26</option>
									</select>
								</div>
							</div>

							<div class="col-xs-3 no-padding" style="font-size:15px; height:46px; line-height:45px;">- 실측시간 </div>
								<div class="col-xs-4 no-padding">
									<select class="form-control input-lg" name="measure_time_hour" style="display:inline;">
										<option value="11" selected>11시</option>
									</select>
								</div>

								<div class="col-xs-1 no-padding" style="font-size:20px; text-align:center; font-wieght:bold; height:46px; line-height:45px;">
									:
								</div>

								<div class="col-xs-4 no-padding">
									<select class="form-control input-lg" name="measure_time_minute" style="display:inline;">
										<option value="00" >00분</option>
										<option value="10" >10분</option>
										<option value="20" >20분</option>
										<option value="30" >30분</option>
										<option value="40" >40분</option>
										<option value="50" >50분</option>
									</select>
								</div>

							<div class="col-xs-12 no-padding">
								<div class="col-xs-3 no-padding" style="height:46px; line-height:45px; font-size:15px;">- 실측값 </div>
								<div class="col-xs-9 no-padding">
									<input class="form-control input-lg" type="number" name="measure_val" placeholder="실측중량" min="400" max="2500" style="font-size:20px;display:inline;">
								</div>

								<label id="request_opt_alarm" style="font-size:12px; font-weight:bold; color:#A94442"></label>
							</div>

							<div style="clear:both"></div>
						</div>

						<div class="col-xs-12 no-padding"><label style="color:#A94442; font-size:13px; font-weight:bold">※ 평균중량 재산출은 20일령 이후에 적용가능합니다.</label></div>
						<div class="col-xs-12 no-padding"><label style="color:#A94442; font-size:13px; font-weight:bold">※ 모든 변경사항은 관리자 승인후에 적용됩니다.</label></div>

						<div style="float:right;">
							<button type="button" class="btn btn-danger" id="request_ok">적용</button>
							<button type="button" class="btn btn-primary" id="request_close">닫기</button>
						</div>

						<div style="clear:both"></div>

					</div>

			</form>
			</div>
		</div>
	</div>

	<!--요약자료--->
	<div class="row" id="summary_layer">
		<div class="col-xs-12">
			<div class="well">
				<div class="col-xs-4 no-padding" style="text-align:center;" onClick="editIntype('<?=$chkInOutCode?>');">
					<img class="henImage" src="../images/block-icon-scale1.png" width="80px" height="90px">
					<div style="position:absolute;top:28px;font-size:20px;color:white;width:100%;">
						<span id="summaryInterm">0</span>일
					</div>
					<div style="position:absolute;top:88px;font-size:16px;color:#A94442;width:100%;font-weight:bold">
						<span id="summaryInType"></span>
						<span id="summaryInsu">0<span>
					</div>
				</div>
				<div class="col-xs-5 no-padding" style="text-align:center;">
					<font style="font-size:20px">실시간 평균</font><br>
					<font style="padding-top:10px;font-size:38px" class="text-danger slideInRight fast animated"><strong><span id="summaryAvgWeight">0</span></strong></font><br>
					<font>입추일 : <span id="summaryIndate"></span></font>
				</div>
				<div class="col-xs-3 no-padding" style="font-size:18px">
					<div class="pull-right" style="text-align:right">
						표준편차<br><span id="summaryDevi">0</span><br>
						변이계수<br><span id="summaryVc">0</span>
					</div>
				</div>
				<div style="clear:both"></div>
			</div><!--well-->

			<!--표준편차 적용-->
			<div class="well">
				<div class="col-xs-4 no-padding" style="text-align:center">
					<span style="text-align:center;font-size:14px">최소중량</span><br>
					<span style="font-size:16px"><font color='blue'><i class='fa fa-caret-down'> </i></font>&nbsp;<span id="summaryMinAvgWeight">0</span></span>
				</div>
				<div class="col-xs-4 no-padding" style="text-align:center">
					<span style="text-align:center;font-size:14px">평균중량</span><br>
					<span style="font-size:16px"><span id="summaryCurrAvgWeight">0</span></span>
				</div>
				<div class="col-xs-4 no-padding" style="text-align:center">
					<span style="text-align:center;font-size:14px">최대중량</span><br>
					<span style="font-size:16px"><font color='red'><i class='fa fa-caret-up'> </i></font>&nbsp;<span id="summaryMaxAvgWeight">0</span></span>
				</div>
				<div style="clear:both"></div>
			</div>

		</div><!--col-xs-12-->
	</div><!--row--->


	<!--1일차 중량-->
	<div class="row" id="avg_layer">
		<div class="col-xs-12">
			<div class="jarviswidget jarviswidget-color-blue" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-togglebutton="false">
				<header>
					<span class="widget-icon"> <i class="fa fa-info-circle"></i> </span>
					<h2>예측평체 (16일령 이후 표시)</h2>
				</header>
				<div class="widget-body">
					<div class="row">
						<div class="col-xs-4">
							<div class="alert alert-warning" role="alert"><span class="widget-icon"> <i class="fa fa-arrow-circle-right"></i> </span> 어제<br>(<span id="summaryDayTerm1"></span>)</div>
							<div style="font-size:24px;text-align:center;margin-top:-10px"><span id="summaryDay1">0</span></div>
							<div style="font-size:12px;text-align:center;color:gray"><span id="summaryDayInc1">0</span></div>
						</div>
						<div class="col-xs-4" style="border-left:1px solid #EEEEEE;border-right:1px solid #EEEEEE">
							<div class="alert alert-success" role="alert"><span class="widget-icon"> <i class="fa fa-arrow-circle-right"></i> </span> 내일<br>(<span id="summaryDayTerm2"></span>)</div>
							<div style="font-size:24px;text-align:center;margin-top:-10px"><span id="summaryDay2">0</span></div>
							<div style="font-size:18px;text-align:center;color:gray"><span class="widget-icon"> <i class="fa fa-plus-square"></i> </span> <span id="summaryDayInc2">0</span></div>

						</div>
						<div class="col-xs-4">
							<div class="alert alert-info" role="alert"><span class="widget-icon"> <i class="fa fa-arrow-circle-right"></i> </span> 모레<br>(<span id="summaryDayTerm3"></span>)</div>
							<div style="font-size:24px;text-align:center;margin-top:-10px"><span id="summaryDay3">0</span></div>
							<div style="font-size:18px;text-align:center;color:gray"><span class="widget-icon"> <i class="fa fa-plus-square"></i> </span> <span id="summaryDayInc3">0</span></div>

						</div>
					</div><!--row-->

				</div><!--widget-body-->
			</div><!--widget-->
		</div><!--col-xs-12-->
	</div><!--row-->

	<!--2일차 중량-->
	<!--3일차 중량-->

	<div class="row">
		
		<!--평균온도,습도,CO2,NH3-->
		<div class="col-xs-12">
			<div class="jarviswidget jarviswidget-color-blue" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-togglebutton="false">
				<header>
					<span class="widget-icon"> <i class="fa fa-info-circle"></i> </span>
					<h2>현재 센서별 평균정보</h2>
				</header>
				<div class="widget-body">
					<div class="row">
						<div class="col-xs-6">
							<div class="col-xs-3 no-padding" style="text-align:center"><img src="../images/mnu_icon/mnu_04.png" width="40"><br><span id="currAvgTempAlert"></span></div>
							<div class="col-xs-9" style="text-align:right">온도(℃)<br><span id="currAvgTemp" style="font-size:28px">0</span></div>
							<div style="clear:both"></div><hr style="margin-top:0px">
						</div>
						<div class="col-xs-6">
							<div class="col-xs-3 no-padding" style="text-align:center"><img src="../images/mnu_icon/mnu_05.png" width="40"><br><span id="currAvgHumiAlert"></span></div>
							<div class="col-xs-9" style="text-align:right">습도(％)<br><span id="currAvgHumi" style="font-size:28px">0</span></div>
							<div style="clear:both"></div><hr style="margin-top:0px">
						</div>
						<div class="col-xs-6">
							<div class="col-xs-3 no-padding" style="text-align:center"><img src="../images/mnu_icon/mnu_06.png" width="40"><br><span id="currAvgCO2Alert"></span></div>
							<div class="col-xs-9" style="text-align:right">이산화탄소(ppm)<br><span id="currAvgCO2" style="font-size:28px">0</span></div>
						</div>
						<div class="col-xs-6">
							<div class="col-xs-3 no-padding" style="text-align:center"><img src="../images/mnu_icon/mnu_07.png" width="40"><br><span id="currAvgNH3Alert"></span></div>
							<div class="col-xs-9" style="text-align:right">암모니아(ppm)<br><span id="currAvgNH3" style="font-size:28px">0</span></div>
							<div style="clear:both"></div>
						</div>
					</div><!--row-->

				</div><!--widget-body-->
			</div><!--widget-->
		</div><!--col-xs-12-->



		<!--오늘 평균중량 변화추이 -->
		<!--
		<div class="col-xs-12" style="margin-top:-10px">
			<div class="jarviswidget jarviswidget-color-green" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-togglebutton="false">
				<header>
					<span class="widget-icon"> <i class="fa fa-bar-chart-o"></i> </span>
					<h2>오늘 평균중량</h2>
				</header>
				<div class="widget-body">
					<div class="row">
						<div id="todayWeightChart" style="height:260px;"></div>
					</div>
				</div>
			</div>
		</div>
		-->


		<!--오늘 증체중량 변화추이-->
		<div class="col-xs-12" style="margin-top:-10px">
			<div class="jarviswidget jarviswidget-color-green" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-togglebutton="false">
				<header>
					<span class="widget-icon"> <i class="fa fa-bar-chart-o"></i> </span>
					<h2>오늘 증체중량</h2>
				</header>
				<div class="widget-body">
					<div class="row">
						<div id="todayIncWeightChart" style="height:260px;"></div>
					</div>
				</div>
			</div>
		</div>



		<!--일령별 평균중량 변화추이 -->
		<div class="col-xs-12" style="margin-top:-10px">
			<div class="jarviswidget jarviswidget-color-green" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-togglebutton="false">
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



		<!--IP 카메라 -->
		<div class="col-xs-12" style="margin-top:-10px">
			<div class="jarviswidget jarviswidget-color-purple" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-togglebutton="false">
				<header>
					<span class="widget-icon"> <i class="fa fa-camera"></i> </span>
					<h2>IP 카메라</h2>
				</header>
				<div class="widget-body">
					<div class="row">
						<div class="col-xs-12">
							<img id="cameraDIV" src="../images/noimage.jpg" onError=" $(this).attr('src','../images/noimage.jpg'); $('#cameraIcon').hide(); " onClick="cameraClose();" width="100%">
							<img id="cameraIcon" src="../images/play.png" class="fadeIn animated" onClick="cameraPlayBtn();">
						</div>
					</div>
				</div><!--widget-body-->
			</div><!--widget-->
		</div><!--col-xs-12-->



		<!--오늘 환경센서 변화 -->
		<!--
		<div class="col-xs-12" style="margin-top:-10px">
			<div class="jarviswidget jarviswidget-color-pink" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-togglebutton="false">
				<header>
					<span class="widget-icon"> <i class="fa fa-bar-chart-o"></i> </span>
					<h2>오늘 환경센서</h2>
				</header>
				<div class="widget-body">
					<div class="widget-body-toolbar">
						<div id="todayBtnGroup" class="btn-group">
							<button type="button" class="btn btn-default" onClick="getSensor('<?=$chkInOutCode?>','온도','TODAY');">
								<i class="fa fa-sun-o"></i>&nbsp;&nbsp;온도
							</button>
							<button type="button" class="btn btn-default" onClick="getSensor('<?=$chkInOutCode?>','습도','TODAY');">
								<i class="fa fa-tint"></i>&nbsp;&nbsp;습도
							</button>
							<button type="button" class="btn btn-default" onClick="getSensor('<?=$chkInOutCode?>','CO2','TODAY');">
								<i class="fa fa-warning"></i>&nbsp;&nbsp;이산화탄소
							</button>
							<button type="button" class="btn btn-default" onClick="getSensor('<?=$chkInOutCode?>','NH3','TODAY');">
								<i class="fa fa-ambulance"></i>&nbsp;&nbsp;암모니아
							</button>
						</div>
					</div>

					<div class="row">
						<div id="todaySensorChart" style="height:300px"></div>
					</div>

				</div>
			</div>
		</div>
		-->


		<!--일령별 환경센서 변화 -->
		<!--
		<div class="col-xs-12" style="margin-top:-10px">
			<div class="jarviswidget jarviswidget-color-pink" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-togglebutton="false">
				<header>
					<span class="widget-icon"> <i class="fa fa-bar-chart-o"></i> </span>
					<h2>일령별 환경센서</h2>
					<div class="widget-toolbar">
						<button type="button" class="btn btn-default" onClick="excelConvert('일령별환경센서','alldaySensorTable')"><span class="fa fa-table"></span> Excel</button>&nbsp;&nbsp;
						<button id="toggleSensorBtn" type="button" class="btn btn-default">
							<span class="fa fa-plus"> </span>
						</button>
					</div>
				</header>
				<div class="widget-body">
					<div class="widget-body-toolbar">
						<div id="alldayBtnGroup" class="btn-group">
							<button type="button" class="btn btn-default" onClick="getSensor('<?=$chkInOutCode?>','온도','ALLDAY');">
								<i class="fa fa-sun-o"></i>&nbsp;&nbsp;온도
							</button>
							<button type="button" class="btn btn-default" onClick="getSensor('<?=$chkInOutCode?>','습도','ALLDAY');">
								<i class="fa fa-tint"></i>&nbsp;&nbsp;습도
							</button>
							<button type="button" class="btn btn-default" onClick="getSensor('<?=$chkInOutCode?>','CO2','ALLDAY');">
								<i class="fa fa-warning"></i>&nbsp;&nbsp;이산화탄소
							</button>
							<button type="button" class="btn btn-default" onClick="getSensor('<?=$chkInOutCode?>','NH3','ALLDAY');">
								<i class="fa fa-ambulance"></i>&nbsp;&nbsp;암모니아
							</button>
						</div>
					</div>

					<div class="row">
						<div id="alldaySensorChart" style="height:300px"></div>
					</div>

					<div id="toggleSensorDIV" class="row fadeInDown animated" style="display:none">
						<div class="col-xs-12">
							<table id="alldaySensorTable" data-toggle="table" style="font-size:14px">
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
						</div>
					</div>
					

				</div>
			</div>
		</div>
		-->

		<!--1번/2번/3번 저울--->
		<div class="col-xs-12" style="margin-top:-10px">
			<div class="jarviswidget jarviswidget-color-purple" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-togglebutton="false">
				<header>
					<span class="widget-icon"> <i class="fa fa-reorder"></i> </span>
					<h2>현재 저울상태</h2>
				</header>
				<div class="widget-body">
					<div class="row">
						<div class="col-xs-12">
							<table class="table table-bordered mb-0" width="100%" style="text-align:center">
								<thead>
									<tr>
										<td>저울<br>구분</td>
										<td>중량<br>(g)</td>
										<td>온도<br>(℃)</td>
										<td>습도<br>(％)</td>
										<td>CO2<br>(ppm)</td>
										<td>NH3<br>(ppm)</td>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>1번</td>
										<td id="currWeight_01">0</td>
										<td id="currTemp_01">0</td>
										<td id="currHumi_01">0</td>
										<td id="currCO2_01">0</td>
										<td id="currNH3_01">0</td>
									</tr>
									<tr>
										<td>2번</td>
										<td id="currWeight_02">0</td>
										<td id="currTemp_02">0</td>
										<td id="currHumi_02">0</td>
										<td id="currCO2_02">0</td>
										<td id="currNH3_02">0</td>
									</tr>
									<tr>
										<td>3번</td>
										<td id="currWeight_03">0</td>
										<td id="currTemp_03">0</td>
										<td id="currHumi_03">0</td>
										<td id="currCO2_03">0</td>
										<td id="currNH3_03">0</td>
									</tr>
								</tbody>
							</table>
						</div><!--col-xs-12-->
					</div><!--row-->
				</div><!--widget-body-->
			</div><!--widget-->
		</div><!--col-xs-12-->




	</div><!--row-->



<script language="javascript">
	$(document).ready(function(){

		$("#alarm_form").hide();
		$("#request_layer").hide();

		cameraImg.onload="";  //카메라 종료
		$("html, body").animate({scrollTop :0}, 0); //페이지를 상단으로 올림
		getData("<?=$farmID?>","<?=$dongID?>","<?=$chkInOutCode?>");

		farmID="<?=$farmID?>";
		dongID="<?=$dongID?>";
		chkInOutCode="<?=$chkInOutCode?>";
	});

	//자료불러오기
	function getData(farmID,dongID,chkInOutCode){
		var dataArr={}; dataArr['oper']="chkIN"; dataArr['farmID']=farmID; dataArr['dongID']=dongID;  dataArr['chkInOutCode']=chkInOutCode;
		$.ajax({url:'common_action.php',data:dataArr,cache:false,type:'post',dataType:'json',
			success: function(data) {

				var inTerm=data.summary.summaryInterm; //일령

				//일령 이미지
				if(inTerm<=10){	$(".henImage").attr("src","../images/block-icon-scale1.png"); }
				if(inTerm>=11 && inTerm<=20){ $(".henImage").attr("src","../images/block-icon-scale2.png");  }
				if(inTerm>=21){ $(".henImage").attr("src","../images/block-icon-scale3.png");  }
				
				//요약정보(summary)
				$.each(data.summary, function(Key,Val){	$("#" + Key).html(Val); });

				// 어제평균중량 산출 시간 표현
				var prev_date = data.summary.summaryDayInc1;
				//$("#summaryDayInc1").html("산출시간<br>" + prev_date.substr(5, 2) + "월 " + prev_date.substr(8, 2) + "일 " + prev_date.substr(11, 2) + "시");
				$("#summaryDayInc1").html("기준 " + prev_date.substr(11, 2) + "시 " + prev_date.substr(14, 2) + "분");

				//현재 센서별 평균정보
				$.each(data.currAvgData, function(Key,Val){	$("#" + Key).html(Val); });

				//오늘 평균중량 변화추이
				//var todayWeightChart=drawBarLineChart("todayWeightChart",data.todayWeightChart,"N","N",12);

				//오늘 증체중량 변화추이
				var todayIncWeightChart=drawBarLineChart("todayIncWeightChart",data.todayIncWeightChart,"N","N",12);

				//일령별 평균중량 변화추이
				var alldayWeightChart=drawSelectChart("alldayWeightChart",data.alldayWeightChart,"세로-Bar","N","N",12);
									
				//일령별 평균중량표(Table)
				$('#alldayWeightTable').bootstrapTable();
				$("#alldayWeightTable").bootstrapTable("load",data.alldayWeightTable); //한번더 Loading하여 Data 갱신

				//카메라 URL 받아오기
				$("#cameraDIV").attr("src",data.cameraURL);

				//오늘환경센서 + 일령별환경센서 변화추이 가져오기
				$("#todayBtnGroup > button.btn:first").trigger('click');  $("#todayBtnGroup > button.btn:first").addClass("active");
				$("#alldayBtnGroup > button.btn:first").trigger('click'); $("#alldayBtnGroup > button.btn:first").addClass("active");

				//현재 저울별 센서 Data값
				//$.each(data.currSensor, function(Key,Val){	$("#" + Key).html(Val); });

				var curr_day = Number(inTerm);

				var state_data = {};
				state_data['oper'] = "check_request";
				state_data["farmID"] = farmID;
				state_data["dongID"] = dongID;
				state_data["day"] = curr_day;

				$.ajax({url:'common_action.php',data:state_data,cache:false,type:'post',dataType:'json',
					success: function(data) {

						// 데이터 입력이 
						if(data.msg == ""){
							$("#alarm_msg").html("");
							$("#alarm_form").hide();
							$("#summary_layer").show();
							$("#avg_layer").show();
						}
						else{
							$("#alarm_msg").html(data.msg);
							$("#alarm_form").show();
							$("#summary_layer").hide();
							$("#avg_layer").hide();
						}

						if(data.view_alert){		// 실측 입력을 요청해야 하는 일령 (25, 30) 이고, 오늘 아직 입력한 데이터가 없는 경우
							if(get_cookie("is_refuse" + farmID + dongID) != "yes"){		
								// confirm_modal_popup_with_check("실측값 입력 요청 (" + String(curr_day) + "일령)", "실측값을 입력해주시면 평균중량 산출 정확도가 올라갑니다.<br>입력하시겠습니까?", "1일 동안 그만보기", 
								// 	function(confirm, checked){
								// 		// 체크박스 선택 여부 확인
								// 		if(checked){
								// 			set_cookie("is_refuse" + farmID + dongID, "yes", 1);
								// 		}
										
								// 		// 확인버튼 클릭 여부 확인
								// 		if(confirm){
								// 			editIntype(chkInOutCode);
								// 		}
								// 	}
								// );
							}

							confirm_modal_popup("실측값 입력 요청 (" + String(curr_day) + "일령)", "실측값을 입력해주시면 평균중량 산출 정확도가 올라갑니다.<br>입력하시겠습니까?", 
								function(confirm, checked){
									// 확인버튼 클릭 여부 확인
									if(confirm){
										editIntype(chkInOutCode);
									}
								}
							);
						}
						
					}
				});

			}
		});
	}

	//센서 Data 가져오기
	function getSensor(chkInOutCode,sensorType,prnType){
		/*
		var dataArr={}; dataArr['oper']="getSensor"; dataArr['chkInOutCode']=chkInOutCode; dataArr['sensorType']=sensorType;  dataArr['prnType']=prnType;
		$.ajax({url:'common_action.php',data:dataArr,cache:false,type:'post',dataType:'json',
			success: function(data) {
				switch(prnType){
					case "TODAY":
						var todaySensorChart=drawBarLineChart("todaySensorChart",data.todaySensorChart,"N","N",12);
						break;
					case "ALLDAY":
						var alldaySensorChart=drawBarLineChart("alldaySensorChart",data.alldaySensorChart,"N","N",12);
						$("#alldaySensorTable").bootstrapTable();
						$("#alldaySensorTable").bootstrapTable("load",data.alldaySensorTable); //한번더 Loading하여 Data 갱신
						break;
				}
			}
		});
		*/
	}

	//카메라 구동
	function cameraPlayBtn(){
		var imgURL=$("#cameraDIV").attr("src");
		$("#cameraIcon").hide();
		cameraStart(imgURL);
	}

	function cameraClose(){
		cameraImg.onload="";
		$("#cameraIcon").show();
		return false;
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

	//입추구분 변경
	function editIntype(chkInOutCode){
		if(chkInOutCode!=""){

			alarm_clear();

			var dataArr={};
			dataArr['oper']="setModal";
			dataArr['chkInOutCode'] = chkInOutCode;

			$.ajax({url:'common_action.php',data:dataArr,cache:false,type:'post',dataType:'json',
				success: function(data) {
					//alert(JSON.stringify(data));

					// 기존
					$("#request_form [name=changeIntype]").removeAttr("checked");
					$("#request_form [name=changeIntype]:input[value=" + data.cmIntype + "]").prop("checked", true);
					$("#request_form [name=chkInOutCode]").val(chkInOutCode);
					$("#request_form [name=changeInSU]").val($("#summaryInsu").html());
					
					data.cmIndate = data.cmIndate.substr(0, 15) + "0:00";
					var in_date = data.cmIndate.substr(0,10);
					var in_time = data.cmIndate.substr(11,5);

					var now = get_now_datetime();

					// 추가사항
					//$("#request_dong_name").html("데이터 변경 요청 (" + data.fdName + ")");
					$("#request_in_time").html("현재 입추시간 : ("+ data.cmIndate.substr(0, 16) +")");
					$("#request_form [name=in_date]").html(make_date_combo(data.cmIndate, -3));
					$("#request_form [name=in_time_hour]").html(make_time_combo(data.cmIndate, data.cmIndate.substr(11, 2)));
					$("#request_form [name=in_time_minute]").val(data.cmIndate.substr(14, 1) + "0").attr("selected", true);

					$("#request_form [name=measure_date]").html(make_date_combo(now, -3));
					$("#request_form [name=measure_time_hour]").html(make_time_combo(now, "00"));
					$("#request_form [name=measure_time_minute]").val("00").attr("selected", true);
					
					// 일자 변경 시 - 오늘일 경우 현재 시간 이전만 선택가능하게
					$("#request_form [name=in_date]").off("change").on("change", function(){
						$("#request_form [name=in_time_hour]").html(make_time_combo(this.value, data.cmIndate.substr(11, 2)));
					});
					$("#request_form [name=measure_date]").off("change").on("change", function(){
						$("#request_form [name=measure_time_hour]").html(make_time_combo(this.value, "00"));
					});

					// 변경사항 확인을 위한 변수
					$origin = data.cmIntype + "|" + data.cmIndate;
					$("#request_form [name=request_origin]").val($origin);
					$("#request_form [name=request_dong_name]").val(data.fdName);

					$("#request_layer").show();
					$("html, body").animate({scrollTop :200}, 0); //재산출에 포커싱함
				}
			});
		}
	}

	// 현재 일령에서 iter 만큼 앞까지만 콤보박스로 변경
	function make_date_combo(base, iter){

		var ret = "";

		for(var i= iter; i <= -1 * iter; i++){
			var date = get_plus_minus_time(base, i * 1000 * 60 * 60 * 24).substr(0, 10);

			if(get_date_diff(get_now_date(), date) > 0){
				break;
			}

			if(date == base.substr(0, 10)){
				ret += "<option value=\"" + date + "\" selected>" + date + "</option>";
			}
			else{
				ret += "<option value=\"" + date + "\">" + date + "</option>";
			}
		}  

		return ret;
	};

	function make_time_combo(sel, def){
		var ret = "";
		var now = get_now_datetime();

		var limit = 24;

		if(sel.substr(0, 10) == now.substr(0, 10)){
			limit = parseInt(now.substr(11, 2));
		}

		// 00시에 데이터 입력 시 하나도 안나오는걸 방지
		if(limit == 0){
			ret = "<option value=\"00\" selected>00시</option>";
		}

		for(var i=0; i<limit; i++){
			var temp = "";
			if(i < 10){
				temp += "0";
			}

			temp += i;

			if(temp == def){
				ret += "<option value=\"" + temp + "\" selected>" + temp + "시</option>";
			}
			else{
				ret += "<option value=\"" + temp + "\">" + temp + "시</option>";
			}
		}

		return ret;
	};

	// 선택된 일자의 00:00분 부터 현재 시각 (이미 지난 일자인 경우 23:50까지) 를 콤보박스로 변경
	// function make_time_combo(base, selected){

	// 	var ret = "";

	// 	var end = base.substr(11, 4) + "0";
	// 	var temp = base.substr(0, 11) + "00:00:00";

	// 	while(temp.substr(11, 5) != end){
	// 		var time = temp.substr(11, 5);

	// 		if(time == selected){
	// 			ret += "<option value=\"" + time + "\" selected>" + time + "</option>";
	// 		}
	// 		else{
	// 			ret += "<option value=\"" + time + "\">" + time + "</option>";
	// 		}

	// 		temp = get_plus_minus_time(temp, 1000 * 60 * 10);
	// 	}

	// 	return ret;
	// };

	//입추수량을 숫자만 입력
	$("#request_form [name=changeInSU]").on("keyup", function() {
		var temp = $(this).val();
		temp = temp.replace(/[^0-9]/g,"");
		temp = temp.length > 5 ? temp.substr(0, 5) : temp;

		$(this).val(temp);
	});

	//실측값을 숫자만 입력
	$("#request_form [name=measure_val]").on("keyup", function() {
		var temp = $(this).val();
		temp = temp.replace(/[^0-9]/g,"");
		temp = temp.length > 4 ? temp.substr(0, 4) : temp;

		$(this).val(temp);
	});

	function alarm_clear(){
		$("#request_alarm").html("");
		$("#request_day_alarm").html("");
		$("#request_opt_alarm").html("");

		$("#request_alarm").hide();
		$("#request_day_alarm").hide();
		$("#request_opt_alarm").hide();
	}

	function view_alarm(id, msg){
		alarm_clear();
		$("#" + id).html("오류 : " + msg);
		$("#" + id).show();

		$("html, body").animate({scrollTop :100}, 0); //페이지를 상단으로 올림
	}

	function datetime_easy(time){
		var ret = time.substr(5, 2) + "월 " + time.substr(8, 2) + "일 " + time.substr(11, 5);
		return ret;
	}

	$("#request_close").click(function(){
		$("#request_layer").hide();

		$("html, body").animate({scrollTop :0}, 0); //상단으로 포커싱함
	});

	// 일령변경, 축종변경, 최적화 요청
	$("#request_ok").click(function() {

		var origin = $("#request_form [name=request_origin]").val().split("|");		// 0:cmIntype 1:cmIndate
		var dong_name = $("#request_form [name=request_dong_name]").val();		// 요청 동 이름

		var tr_date = $("#request_form [name=in_date]").val() + " " + $("#request_form [name=in_time_hour]").val() + ":" + $("#request_form [name=in_time_minute]").val();
		var tr_type = $("#request_form [name=changeIntype]:checked").val();
		var tr_count = $("#request_form [name=changeInSU]").val();
		var measure_date = $("#request_form [name=measure_date]").val() + " " + $("#request_form [name=measure_time_hour]").val() + ":" + $("#request_form [name=measure_time_minute]").val();
		var measure_val = $("#request_form [name=measure_val]").val();

		var rc_comm = "";

		//alert("origin : " + origin + "\ntr_date : " + tr_date + "\ntr_type : " + tr_type  + "\nmeasure_date : " + measure_date + "\nmeasure_val : " + measure_val);

		var notice = "";

		var curr_day = get_now_date();
		var days = $("#summaryInterm").html();

		// 축종 변경
		if(origin[0] != tr_type){
			notice += "- 축종을 <span style='font-weight:bold;'>\"" + origin[0] + "\"</span>에서 <span style='font-weight:bold;'>\"" + tr_type + "\"</span>으로 변경<br><br>";
			rc_comm += "Lst|";
		}

		// 입추수 변경
		var in_count = $("#summaryInsu").html();
		if(in_count != tr_count){
			notice += "- 입추수를 <span style='font-weight:bold;'>\"" + in_count + "\"</span>에서 <span style='font-weight:bold;'>\"" + tr_count + "\"</span>으로 변경<br><br>";
		}

		// 입추일자 오류처리
		if(origin[1].substr(0, 16) != tr_date){
			var origin_diff = get_date_diff(origin[1], curr_day) + 1;
			var trans_diff = get_date_diff(tr_date, curr_day) + 1;

			notice += "- 입추일자를 <span style='font-weight:bold;'>\"" + datetime_easy(origin[1]) + " ("+ origin_diff +"일령)\"</span>에서 <br>";
			notice += "<span style='font-weight:bold;'>\"" + datetime_easy(tr_date) + " ("+ trans_diff +"일령)\"</span>으로 변경<br><br>";

			rc_comm += "Day|";
		}

		// 최적화 오류처리
		if(measure_val.length != 0){

			// 20일령 이전 차단
			if(parseInt(days) < 20){
				view_alarm("request_opt_alarm", "평균중량 재산출은 20일령 이후에 진행해주세요");
				return;
			}

			var measure_diff = get_time_diff(measure_date + ":00", get_now_datetime());
			
			if(measure_diff < 1800){
				view_alarm("request_opt_alarm", "실측시간은 현재시간보다 최소 30분 이전으로 입력해주세요");
				return;
			}

			if(parseInt(measure_val) < 400 || parseInt(measure_val) > 2500){
				view_alarm("request_opt_alarm", "실측값은 400 ~ 2500 사이의 값을 입력해주세요");
				return;
			}

			notice += "- 평균중량 재산출을 <span style='font-weight:bold;'>\"" + datetime_easy(measure_date) + "\"</span>에 측정한 <span style='font-weight:bold;'>" + measure_val + "g</span>으로 진행<br><br>";
			rc_comm += "Opt|";
		}

		// 에러 확인 완료 후 적용될 값이 있으면 confirm창 출력
		if(notice.length < 1){
			view_alarm("request_alarm", "수정하여 적용할 값이 존재하지 않습니다");
		}
		else{
			notice = "- " + dong_name + "의 데이터를 변경<br><br>" + notice;

			confirm_modal_popup("아래의 변경사항을 적용하시겠습니까?", notice, 
				function(confirm) {
					alarm_clear();

					if(confirm){
						var dataArr = {};
						dataArr['oper'] = "request";

						dataArr["rcFarmid"] = farmID;		//농장 ID
						dataArr["rcDongid"] = dongID;		//동 ID
						dataArr["rcCode"] = chkInOutCode;	//입추코드
						dataArr["rcCommand"] = rc_comm.substr(0, rc_comm.length-1);		//변환 명령

						dataArr["rcPrevLst"] = origin[0];		//변경 전 축종
						dataArr["rcChangeLst"] = tr_type;		//변경 후 축종

						dataArr["rcPrevDate"] = origin[1];		//변경 전 입추시간
						dataArr["rcChangeDate"] = tr_date + origin[1].substr(origin[1].length - 3, 3);		//변경 후 입추시간

						dataArr["rcMeasureDate"] = measure_date.length > 3 ? measure_date + ":00" : "2000-01-01 00:00:00";		// 실측 시간
						dataArr["rcMeasureVal"] = measure_date.length > 3 ? measure_val : 0;				// 실측 중량

						dataArr["tr_count"] = tr_count;

						set_cookie("is_opt_com", "yes", 1);

						set_cookie("is_end_request", "no", 2);

						$.ajax({url:'common_action.php',data:dataArr,cache:false,type:'post',dataType:'json',
							success: function(data) {
								$("#request_form").each(function() {	this.reset();  });
								$("#summaryInsu").html(data.summaryInsu);	//입추수만 변경
								$("#request_layer").hide();

								getData(farmID,dongID,chkInOutCode);  //자료 새로고침

								$("html, body").animate({scrollTop :0}, 0); //상단으로 포커싱함
							}
						});
					}
				}
			);
		}
	});

</script>