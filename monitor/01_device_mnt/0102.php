<?
include_once("../inc/top.php");
?>
<!--농장정보 & 이슈사항-->
<article class="col-xl-10 float-right">
	<div class="row">
		<div class="col-xl-5">
			<div class="jarviswidget jarviswidget-color-green-dark" id="wid-id-1" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
				<header>
					<div class="widget-header">	
						<h2><i class="fa fa-home"></i>&nbsp;&nbsp;&nbsp;요약 정보</h2>	
					</div>
				</header>

				<div class="widget-body">

					<div class="col-md-6 no-padding">
						<div style="padding-top:0.2rem; padding-bottom:0.8rem; font-size: 15px">
							<b id="summary_name">망성농장-01동 (KF0013-01) </b>
						</div>

						<div>
							<div class="well" style="padding:15px;">
								<div class="col-md-12 no-padding">
									<div class="col-md-4 no-padding">
										<img id="hen_img" src="../images/hen-scale1.png" width="100%" height="100px">
										<div style="position:absolute; top:34px; font-size:16px; color:white; width:100%; text-align:center;">
											<span id="summary_days">30</span>일령
										</div>
									</div>
									<div class="col-md-8 no-padding">
										<div style="text-align:center; font-weight:bold; font-size:15px">평균중량</div>
										<div id="summary_avg" style="text-align:center; font-weight:bold; font-size:24px; color:#455a64">1020</div>

										<div id="summary_devi" class="col-md-6 no-padding" style="text-align:center; font-weight:bold;">표준편차<br>13.1</div>
										<div id="summary_inc" class="col-md-6 no-padding" style="text-align:center; font-weight:bold;">일일증체량<br>40</div>
									</div>
								</div>

								<div class="col-md-12 no-padding">
									<div class="col-md-4 no-padding">
										<div id="summary_type" style="text-align:center;">육계 20000수 </div>
									</div>
									<div class="col-md-8 no-padding">
										<div id="summary_comein" style="text-align:center;">입추일자 : 2021-06-10 </div>
									</div>
								</div>

								<div style="clear:both"></div>
							</div>
						</div>
					</div>

					<div class="col-md-6">
						
					</div>
					
				</div>
						
			</div>
		</div>

		<div class="col-xl-7">
			<div class="jarviswidget jarviswidget-color-red no-padding" id="wid-id-2" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
				<header>
					<div class="widget-header">	
						<h2><i class="fa fa-warning"></i>&nbsp;&nbsp;&nbsp;이슈사항</h2>	
					</div>
				</header>

				<div class="widget-body">

					<table class="table table-bordered table-hover" style="text-align: center;">
						<thead>
							<th>이슈</th>
							<th>상태</th>
							<th>내용</th>
							<th>비고</th>
						</thead>
						<tbody>
							<tr>
								<td>평균중량 현황</td>
								<td>정상</td>
								<td>권고중량 대비 +20 / 직전일령 증체량 43g</td>
								<td>-</td>
							</tr>
							<tr>
								<td>재산출 요청</td>
								<td><span style="color:red">승인 필요</span></td>
								<td>일령 변경 요청</td>
								<td>-</td>
							</tr>
							<tr>
								<td>경함 조치 진행</td>
								<td><span style="color:red">조치 필요</span></td>
								<td>카메라 이상</td>
								<td>-</td>
							</tr>
							<tr>
								<td>IoT 저울-01</td>
								<td><span style="color:red">장치 이상</span></td>
								<td>데이터 중단</td>
								<td>-</td>
							</tr>
						</tbody>
					</table>
					
				</div>
						
			</div>
		</div>
	</div>

	<!--장치현황-->
	<div class="row">
		<div class="col-xl-3">
			<div class="jarviswidget jarviswidget-color-custom no-padding" id="wid-id-3" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
				<header>
					<div class="widget-header">	
						<h2><i class="fa fa-tablet"></i>&nbsp;&nbsp;&nbsp;장치 현황</h2>	
					</div>
				</header>
			
				<div class="widget-body">
					<table class="table table-bordered table-hover" style="text-align: center; margin-bottom:10px;">
						<thead>
							<th>장치명</th>
							<th>설치수</th>
						</thead>
						<tbody>
							<tr>
								<td>IoT 저울</td>
								<td id="device_cnt_cell">3</td>
							</tr>
							<tr>
								<td>IP 카메라</td>
								<td id="device_cnt_camera">1</td>
							</tr>
							<tr>
								<td>자동환경제어장치</td>
								<td id="device_cnt_plc">1</td>
							</tr>
							<tr>
								<td>사료빈 로드셀</td>
								<td id="device_cnt_feeder">1</td>
							</tr>
							<tr>
								<td>유량센서</td>
								<td id="device_cnt_water">1</td>
							</tr>
							<tr>
								<td>외기환경센서</td>
								<td id="device_cnt_out">1</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>

		<div class="col-xl-9">
			<div class="jarviswidget jarviswidget-color-custom no-padding" id="wid-id-4" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
				<header>
					<div class="widget-header">	
						<h2><i class="fa fa-tablet"></i>&nbsp;&nbsp;&nbsp;장치 데이터</h2>	
					</div>
				</header>
				<div class="widget-body">
					<table id="device_buffer_table"  data-page-list="[]" data-pagination="false" data-page-list="false" data-page-size="10" data-toggle="table" style="font-size:14px">
						<thead>
							<tr>
								<th data-field='f1' data-visible="true" data-align="center">장치</th>
								<th data-field='f2' data-visible="true" data-align="center">수집시간</th>
								<th data-field='f3' data-visible="true">데이터</th>
							</tr>
						</thead>
					</table>
				</div>
						
			</div>
		</div>
	</div>


	<!--평균중량(표) & 오류이력-->
	<div class="row">
		<div class="col-xl-6">
			<div class="jarviswidget jarviswidget-color-green-dark no-padding" id="wid-id-5" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
				<header>
					<div class="widget-header">	
						<h2><i class="fa fa-table"></i>&nbsp;&nbsp;&nbsp;평균중량 (표)</h2>	
					</div>
				</header>

				<div class="widget-body">

					<div class="widget-body-toolbar">
						<form id="searchFORM" class="form-inline" onsubmit="return false;">
							&nbsp;&nbsp;<input class="form-control" type="text" name="searchName" maxlength="20" placeholder="시작시간" size="15" >&nbsp;&nbsp;-
							&nbsp;&nbsp;<input class="form-control" type="text" name="searchName" maxlength="20" placeholder="종료시간" size="15" >&nbsp;&nbsp;
							<button type="button" class="btn btn-primary btn-sm" onClick="actionBtn('Search')"><span class="fa fa-search"></span>&nbsp;&nbsp;검색</button>&nbsp;
							<button type="button" class="btn btn-success  btn-sm" onClick="actionBtn('Reset')"><span class="fa fa-file-excel-o"></span>&nbsp;&nbsp;엑셀</button>
						</form>
					</div>

					<!-- widget div-->
					<div>
						<!-- widget edit box -->
						<div class="jarviswidget-editbox">
							<!-- This area used as dropdown edit box -->
							<input class="form-control" type="text">	
						</div>
						<!-- end widget edit box -->
						
						<!-- widget content -->
						<div class="widget-body">
							<table id="avg_weight_table"  data-page-list="[]" data-pagination="true" data-page-list="false" data-page-size="10" data-toggle="table" style="font-size:14px">
								<thead>
									<tr>
										<th data-field='f1' data-visible="true" data-sortable="true">산출시간</th>
										<th data-field='f2' data-visible="true" data-sortable="true">일령</th>
										<th data-field='f3' data-visible="true" data-sortable="true">평체</th>
										<th data-field='f4' data-visible="true" data-sortable="true">권고</th>
									</tr>
								</thead>
							</table>
						</div>
					</div>
					
				</div>
						
			</div>
		</div>

		<div class="col-xl-6">
			<div class="jarviswidget jarviswidget-color-orange no-padding" id="wid-id-4" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
				<header>
					<div class="widget-header">	
						<h2><i class="fa fa-file-text-o"></i>&nbsp;&nbsp;&nbsp;오류 이력</h2>	
					</div>
				</header>
					
				<div class="widget-body">

					<div class="widget-body-toolbar">
						<form id="searchFORM" class="form-inline" onsubmit="return false;">
							<select class="form-control">
								<option>시간구분</option>
							</select>
							&nbsp;&nbsp;<input class="form-control" type="text" name="searchName" maxlength="20" placeholder="시작시간" size="15" >&nbsp;&nbsp;-
							&nbsp;&nbsp;<input class="form-control" type="text" name="searchName" maxlength="20" placeholder="종료시간" size="15" >&nbsp;&nbsp;
							<button type="button" class="btn btn-primary btn-sm" onClick="actionBtn('Search')"><span class="fa fa-search"></span>&nbsp;&nbsp;검색</button>&nbsp;
						</form>
					</div>

					<table class="table table-bordered table-hover" style="text-align: center;">
						<thead>
							<th></th>
							<th>오류 시간</th>
							<th>저울 번호</th>
							<th>오류 상태</th>
						</thead>
						<tbody>
							<tr>
								<td>1</td>
								<td>2021-05-03 15:00:00</td>
								<td>1</td>
								<td>-</td>
							</tr>
							<tr>
								<td>2</td>
								<td>2021-05-03 15:00:00</td>
								<td>1</td>
								<td>-</td>
							</tr>
							<tr>
								<td>3</td>
								<td>2021-05-03 15:00:00</td>
								<td>2</td>
								<td>-</td>
							</tr>
							<tr>
								<td>4</td>
								<td>2021-05-03 15:00:00</td>
								<td>2</td>
								<td>-</td>
							</tr>
							<tr>
								<td>5</td>
								<td>2021-05-03 15:00:00</td>
								<td>2</td>
								<td>-</td>
							</tr>
							<tr>
								<td>6</td>
								<td>2021-05-03 15:00:00</td>
								<td>3</td>
								<td>-</td>
							</tr>
							<tr>
								<td>7</td>
								<td>2021-05-03 15:00:00</td>
								<td>1</td>
								<td>-</td>
							</tr>
						</tbody>
					</table>
					
				</div>
						
			</div>
		</div>
	</div>


	<!--IoT 저울 & GW 관리-->
	<div class="row">
		<div class="col-xl-6">
			<div class="jarviswidget jarviswidget-color-white" id="wid-id-6" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
				<header>
					<div class="widget-header">	
						<h2><i class="fa fa-tablet"></i>&nbsp;&nbsp;&nbsp;GW 관리 (농장ID-동ID)</h2>	
					</div>
				</header>

				<div class="widget-body">
					<table class="table table-bordered table-hover" style="width:300px; height:170px; text-align:center; float:left;">
						<thead>
							<td colspan="4"><button class="btn btn-primary" style="width:200px">GW 냉각팬 조회</button></td>
						</thead>
						<tbody>
							<tr>
								<th>동작 온도</th>
								<th>정지 온도</th>
								<th>현재 온도</th>
								<th>동작 상태</th>
							</tr>
							<tr>
								<td>45</td>
								<td>3</td>
								<td>47</td>
								<td>1</td>
							</tr>
							<tr>
								<td><button class="btn btn-primary">설정</button></td>
								<td><button class="btn btn-primary">설정</button></td>
								<td></td>
								<td></td>
							</tr>
						</tbody>
					</table>
					<table style="width:350px; text-align:center; float:right">
						<thead>
							<td><button class="btn btn-default" style="width:300px;" disabled>V 3.5.1</button></td>
						</thead>
						<tbody>
							<tr>
								<td><button class="btn btn-primary" style="width:300px;">펌웨어 버전 조회</button></td>
							</tr>
							<tr>
								<td><button class="btn btn-primary" style="width:300px;">펌웨어 업데이트</button></td>
							</tr>
							<tr>
								<td><button class="btn btn-primary" style="width:300px;">로그 데이터 삭제</button></td>
							</tr>
							<tr>
								<td><button class="btn btn-primary" style="width:300px;">GW 재부팅</button></td>
							</tr>
						</tbody>
					</table>
				</div>
						
			</div>
		</div>

		<div class="col-xl-6">
			<div class="jarviswidget jarviswidget-color-white no-padding" id="wid-id-7" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
				<header>
					<div class="widget-header">	
						<h2><i class="fa fa-tablet"></i>&nbsp;&nbsp;&nbsp;IoT 저울 관리 (농장ID-동ID)</h2>	
					</div>
				</header>
				
				<div class="widget-body">

					<table class="table table-bordered table-hover" style="text-align: center;">
						<thead>
							<th></th>
							<th>영점조정</th>
							<th colspan="2">버전확인</th>
							<th colspan="2">데이터 조회(온도/습도/CO2/NH3/증량)</th>
						</thead>
						<tbody>
							<tr>
								<td>1</td>
								<td><button class="btn btn-success">영점</button></td>
								<td><button class="btn btn-success">버전</button></td>
								<td>3.2</td>
								<td><button class="btn btn-success">조회</button></td>
								<td>23.4/54.6/4300/0/517</td>
							</tr>
							<tr>
								<td>2</td>
								<td><button class="btn btn-success">영점</button></td>
								<td><button class="btn btn-success">버전</button></td>
								<td>3.2</td>
								<td><button class="btn btn-success">조회</button></td>
								<td>23.4/54.6/4300/0/517</td>
							</tr>
							<tr>
								<td>3</td>
								<td><button class="btn btn-success">영점</button></td>
								<td><button class="btn btn-success">버전</button></td>
								<td>3.1</td>
								<td><button class="btn btn-success">조회</button></td>
								<td>23.4/54.6/4300/0/517</td>
							</tr>
						</tbody>
					</table>
					
				</div>
						
			</div>
		</div>
	</div>


	<!--로우데이터 확인-->
	<div class="row">
		<div class="col-xl-12">
			<div class="jarviswidget jarviswidget-color-green-dark no-padding" id="wid-id-8" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
				<header>
					<div class="widget-header">	
						<h2><i class="fa fa-list"></i>&nbsp;&nbsp;&nbsp;로우데이터 확인</h2>	
					</div>
				</header>

				<div class="widget-body">

					<div class="widget-body-toolbar">
						<form id="searchFORM" class="form-inline" onsubmit="return false;">
							<input class="form-control" type="text" name="searchName" maxlength="20" placeholder="시작시간" size="15" >&nbsp;&nbsp;-
							&nbsp;&nbsp;<input class="form-control" type="text" name="searchName" maxlength="20" placeholder="종료시간" size="15" >&nbsp;&nbsp;
							<select class="form-control">
								<option>저울번호</option>
							</select>
							&nbsp;&nbsp;LIMIT&nbsp;&nbsp;<input class="form-control" type="text" maxlength="4" placeholder="1000" size="15">&nbsp;&nbsp;
							<button type="button" class="btn btn-primary btn-sm" onClick="actionBtn('Search')"><span class="fa fa-search"></span>&nbsp;&nbsp;검색</button>&nbsp;
							<button type="button" class="btn btn-success  btn-sm" onClick="actionBtn('Reset')"><span class="fa fa-file-excel-o"></span>&nbsp;&nbsp;엑셀</button>&nbsp;&nbsp;
						</form>
					</div>

					<table class="table table-bordered table-hover" style="text-align: center;">
						<thead>
							<th></th>
							<th>산출시간</th>
							<th>저울</th>
							<th>온도</th>
							<th>습도</th>
							<th>CO2</th>
							<th>NH3</th>
							<th>w01</th>
							<th>w10</th>
							<th>w20</th>
							<th>w30</th>
							<th>w40</th>
							<th>w50</th>
							<th>w60</th>
						</thead>
						<tbody>
							<tr>
								<td>1</td>
								<td>2021-05-03 13:26:49</td>
								<td>1</td>
								<td>23.7</td>
								<td>64.2</td>
								<td>1572</td>
								<td>0</td>
								<td>517</td>
								<td>779</td>
								<td>655</td>
								<td>445</td>
								<td>331</td>
								<td>555</td>
								<td>124</td>
							</tr>
							<tr>
								<td>2</td>
								<td>2021-05-03 13:26:49</td>
								<td>2</td>
								<td>23.9</td>
								<td>64.2</td>
								<td>1572</td>
								<td>0</td>
								<td>517</td>
								<td>779</td>
								<td>655</td>
								<td>445</td>
								<td>331</td>
								<td>555</td>
								<td>124</td>
							</tr>
							<tr>
								<td>3</td>
								<td>2021-05-03 13:26:49</td>
								<td>3</td>
								<td>24.2</td>
								<td>64.2</td>
								<td>1572</td>
								<td>0</td>
								<td>517</td>
								<td>779</td>
								<td>655</td>
								<td>445</td>
								<td>331</td>
								<td>555</td>
								<td>124</td>
							</tr>
							<tr>
								<td>4</td>
								<td>2021-05-03 13:26:49</td>
								<td>1</td>
								<td>23.7</td>
								<td>64.2</td>
								<td>1572</td>
								<td>0</td>
								<td>517</td>
								<td>779</td>
								<td>655</td>
								<td>445</td>
								<td>331</td>
								<td>555</td>
								<td>124</td>
							</tr>
							<tr>
								<td>5</td>
								<td>2021-05-03 13:26:49</td>
								<td>2</td>
								<td>23.7</td>
								<td>64.2</td>
								<td>1572</td>
								<td>0</td>
								<td>517</td>
								<td>779</td>
								<td>655</td>
								<td>445</td>
								<td>331</td>
								<td>555</td>
								<td>124</td>
							</tr>
							<tr>
								<td>6</td>
								<td>2021-05-03 13:26:49</td>
								<td>3</td>
								<td>23.7</td>
								<td>64.2</td>
								<td>1572</td>
								<td>0</td>
								<td>517</td>
								<td>779</td>
								<td>655</td>
								<td>445</td>
								<td>331</td>
								<td>555</td>
								<td>124</td>
							</tr>
						</tbody>
					</table>
					
				</div>
					
			</div>
		</div>
	</div>


	<!--재산출-->
	<div class="row">
		<div class="col-xl-3">
			<div class="jarviswidget jarviswidget-color-info" id="wid-id-9" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
				<header>
					<div class="widget-header">	
						<h2><i class="fa fa-file-text-o"></i>&nbsp;&nbsp;&nbsp;재산출 요청</h2>	
					</div>
				</header>

				<div class="widget-body">
					<form class="form-horizontal">
						<div class="form-group row">
							<label class="control-label col-xl-3">입추일자</label>
							<div class="col-xl-9">
								<input class="form-control" type="text">
							</div>
						</div>
						<div class="form-group row">
							<label class="control-label col-xl-3">입추시간</label>
							<div class="col-xl-9">
								<input class="form-control" type="text">
							</div>
						</div>
						<div class="form-group row">
							<label class="control-label col-xl-3">축종</label>
							<div class="col-xl-9">
								<select class="form-control">
									<option>육계</option>
									<option>삼계</option>
									<option>토종닭</option>
								</select>
							</div>
						</div>
						<div class="form-group row">
							<label class="control-label col-xl-3">실측일자</label>
							<div class="col-xl-9">
								<input class="form-control" type="text">
							</div>
						</div>
						<div class="form-group row">
							<label class="control-label col-xl-3">실측시간</label>
							<div class="col-xl-9">
								<input class="form-control" type="text">
							</div>
						</div>
						<div class="form-group row">
							<label class="control-label col-xl-3">실측값</label>
							<div class="col-xl-9">
								<input class="form-control" type="text">
							</div>
						</div>
							<button class="btn btn-primary" style="width:-webkit-fill-available">재산출</button>
					</form>
				</div>
						
			</div>
		</div>

		<div class="col-xl-9">
			<div class="jarviswidget jarviswidget-color-info no-padding" id="wid-id-10" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
				<header>
					<div class="widget-header">	
						<h2><i class="fa fa-check-square-o"></i>&nbsp;&nbsp;&nbsp;재산출 기록</h2>	
					</div>
				</header>

				<div class="widget-body">	
				
					<table class="table table-bordered table-hover" style="text-align: center;">
						<thead>
							<th></th>
							<th>완료시간</th>
							<th>요청사항</th>
							<th>변경사항</th>
							<th>실측시간</th>
							<th>실측값</th>
						</thead>
						<tbody>
							<tr>
								<td>1</td>
								<td>2021-05-03 15:00:00</td>
								<td>Day(일령)</td>
								<td>2021-05-05 12:40:00 → 2021-05-06 13:00:00</td>
								<td>-</td>
								<td>-</td>
							</tr>
							<tr>
								<td>2</td>
								<td>2021-05-03 14:00:00</td>
								<td>Lst(축종)</td>
								<td>육계 → 삼계</td>
								<td>-</td>
								<td>-</td>
							</tr>
							<tr>
								<td>3</td>
								<td>2021-05-03 13:00:00</td>
								<td>Opt(재산출)</td>
								<td>0.65 → 0.62</td>
								<td>2021-05-05 12:40:00</td>
								<td>14:00</td>
							</tr>
							<tr>
								<td>4</td>
								<td>2021-05-03 12:00:00</td>
								<td>Opt(재산출)</td>
								<td>0.7 → 0.65</td>
								<td>2021-05-05 12:40:00</td>
								<td>14:00</td>
							</tr>
						</tbody>
					</table>
					
				</div>
						
			</div>
		</div>
	</div>
</article>
<?
include_once("../inc/bottom.php");
?>

<script language="javascript">
	$(document).ready(function(){
		call_tree_view("", act_grid_data);
		set_tree_search(act_grid_data);
	});

	// 데이터 불러오기
	function load_data(select){

		let code = "";

		var data_arr = {}; 
		data_arr['oper'] = "get_code";
		data_arr['select'] = select;
		// 입출하코드 가져오기
		$.ajax({url:'0102_action.php',data:data_arr,cache:false,type:'post',dataType:'json',
			success: function(data) {
				code = data.code;
				get_buffer_data(code);
				get_avg_data(code);
			}
		});
	};

	// 트리뷰 버튼 클릭시 리로드 이벤트
	function act_grid_data(action){
		switch(action){
			default:
				load_data(action);
				break;
		}
	};

	// 버퍼테이블 불러오기
	function get_buffer_data(code){

		if(code != null && code != ""){			// "" or null 체크
			var data_arr = {}; 
			data_arr['oper'] = "get_buffer";
			data_arr['code'] = code;
			$.ajax({url:'0102_action.php',data:data_arr,cache:false,type:'post',dataType:'json',
				success: function(data) {

					let summary = data.summary_data;
					$("#summary_name").html(summary.summary_name);
					$("#summary_days").html(summary.summary_days);
					$("#summary_avg").html(summary.summary_avg);
					$("#summary_devi").html(summary.summary_devi);
					$("#summary_inc").html(summary.summary_inc);
					$("#summary_type").html(summary.summary_type);
					$("#summary_comein").html(summary.summary_comein);

					$('#device_buffer_table').bootstrapTable('load', data.buffer_data); //data-toggle="table" 하지않으면 Update 불가
				}
			});
		}
	};

	// 평균중량 불러오기
	function get_avg_data(code){

		if(code != null && code != ""){			// "" or null 체크
			var data_arr = {}; 
			data_arr['oper'] = "get_avg_weight";
			data_arr['code'] = code;
			$.ajax({url:'0102_action.php',data:data_arr,cache:false,type:'post',dataType:'json',
				success: function(data) {
					$('#avg_weight_table').bootstrapTable('load', data.avg_weight_data); //data-toggle="table" 하지않으면 Update 불가
				}
			});
		}
	};

</script>