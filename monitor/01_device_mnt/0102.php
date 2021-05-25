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
						<h2><i class="fa fa-home"></i>&nbsp;&nbsp;&nbsp;박승민농장 - 1동</h2>	
					</div>
				</header>

				<div class="widget-body">

					<table style="width:350px; height:150px; text-align:center; float:left">
						<thead>
							<th colspan="3"><button class="btn btn-success" style="width:200px;" disabled>23일령</button></th>
						</thead>
						<tbody>
							<tr>
								<th style="font-size:15px">평균중량</th>
								<td style="font-size:15px; color:red" colspan="2">1020.0</td>
							</tr>
							<tr>
								<th>표준편차</th>
								<td colspan="2">15.7</td>
							</tr>
							<tr>
								<th>변이계수</th>
								<td colspan="2">1.4</td>
							</tr>
							<tr>
								<th>입추</th>
								<td>2021-04-03</td>
								<td>10:30:00</td>
							</tr>
						</tbody>
					</table>

					<div style="float:right; width:200px; height:140px;">
						<img src="../images/img1.png" style="width:200px; height:150px">
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


	<!--평균중량(표) & 오류이력-->
	<div class="row">
		<div class="col-xl-6">
			<div class="jarviswidget jarviswidget-color-green-dark no-padding" id="wid-id-3" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
				<header>
					<div class="widget-header">	
						<h2><i class="fa fa-table"></i>&nbsp;&nbsp;&nbsp;평균중량 (표)</h2>	
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
							<button type="button" class="btn btn-success  btn-sm" onClick="actionBtn('Reset')"><span class="fa fa-file-excel-o"></span>&nbsp;&nbsp;엑셀</button>
						</form>
					</div>

					<table class="table table-bordered table-hover" style="text-align: center;">
						<thead>
							<th></th>
							<th>산출 시간</th>
							<th>일령</th>
							<th>평채</th>
							<th>권고</th>
						</thead>
						<tbody>
							<tr>
								<td>1</td>
								<td>2021-05-03 15:00:00</td>
								<td>31</td>
								<td>1470</td>
								<td>1585</td>
							</tr>
							<tr>
								<td>2</td>
								<td>2021-05-03 15:00:00</td>
								<td>31</td>
								<td>1470</td>
								<td>1585</td>
							</tr>
							<tr>
								<td>3</td>
								<td>2021-05-03 15:00:00</td>
								<td>31</td>
								<td>1470</td>
								<td>1585</td>
							</tr>
							<tr>
								<td>4</td>
								<td>2021-05-03 15:00:00</td>
								<td>31</td>
								<td>1470</td>
								<td>1585</td>
							</tr>
							<tr>
								<td>5</td>
								<td>2021-05-03 15:00:00</td>
								<td>31</td>
								<td>1470</td>
								<td>1585</td>
							</tr>
							<tr>
								<td>6</td>
								<td>2021-05-03 15:00:00</td>
								<td>31</td>
								<td>1470</td>
								<td>1585</td>
							</tr>
							<tr>
								<td>7</td>
								<td>2021-05-03 15:00:00</td>
								<td>31</td>
								<td>1470</td>
								<td>1585</td>
							</tr>
						</tbody>
					</table>
					
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


	<!--장치현황-->
	<div class="row">
		<div class="col-xl-12">
			<div class="jarviswidget jarviswidget-color-white no-padding" id="wid-id-5" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
				<header>
					<div class="widget-header">	
						<h2><i class="fa fa-tablet"></i>&nbsp;&nbsp;&nbsp;장치 현황</h2>	
					</div>
					<div class="widget-toolbar ml-auto">
						<div class="form-inline">
							<button class="btn btn-primary"><i class="fa fa-gear"></i>&nbsp;&nbsp;&nbsp;장치관리로 이동</button>
						</div>
					</div>
				</header>
			
				<div class="widget-body">

					<table class="table table-bordered table-hover" style="text-align: center; margin-bottom:10px; margin-top:10px;">
						<thead>
							<th>IoT 저울</th>
							<th>IP 카메라</th>
							<th>PLC</th>
							<th>급이기</th>
							<th>급수기</th>
							<th>외기환경</th>
						</thead>
						<tbody>
							<tr>
								<td>3</td>
								<td>1</td>
								<td>0</td>
								<td>1</td>
								<td>1</td>
								<td>0</td>
							</tr>
						</tbody>
					</table>
					<table class="table table-bordered table-hover" style="text-align: center; margin-bottom:10px;">
						<thead>
							<th>장치</th>
							<th>최종수집시간</th>
							<th>온도 (℃)</th>
							<th>습도 (%)</th>
							<th>이산화탄소 (ppm)</th>
							<th>암모니아 (ppm)</th>
							<th>중량</th>
						</thead>
						<tbody>
							<tr>
								<td>IoT 저울-01</td>
								<td><span style="color:red">2021-05-10 14:30:00</span></td>
								<td>23.2</td>
								<td>55.9</td>
								<td>1431</td>
								<td>0</td>
								<td>1554</td>
							</tr>
							<tr>
								<td>IoT 저울-02</td>
								<td>2021-05-10 16:00:00</td>
								<td>24.1</td>
								<td>61.2</td>
								<td>1521</td>
								<td>0</td>
								<td>1122</td>
							</tr>
							<tr>
								<td>IoT 저울-03</td>
								<td>2021-05-10 16:00:00</td>
								<td><span style="color:red">27.9</span></td>
								<td><span style="color:red">78.8</span></td>
								<td><span style="color:red">2780</span></td>
								<td>1</td>
								<td>1788</td>
							</tr>
						</tbody>
					</table>
					<table class="table table-bordered table-hover" style="text-align: center; margin-bottom:10px;">
						<thead>
							<th>장치</th>
							<th>최종수집시간</th>
							<th>사료빈셀</th>
							<th>유량센서</th>
							<th>온도</th>
							<th>습도</th>
							<th>암모니아</th>
							<th>황화수소</th>
							<th>미세먼지</th>
							<th>초미세먼지</th>
							<th>풍향</th>
							<th>풍속</th>
						</thead>
						<tbody>
							<tr>
								<td>급이/급수/외기</td>
								<td><span style="color:red">2021-05-10 14:30:00</span></td>
								<td>4500</td>
								<td>32511</td>
								<td>12.7</td>
								<td>66.8</td>
								<td>1</td>
								<td>0.1</td>
								<td>19.1</td>
								<td>20.6</td>
								<td>90</td>
								<td>2.3</td>
							</tr>
						</tbody>
					</table>
					<table class="table table-bordered table-hover" style="text-align: center;">
						<thead>
							<th>장치</th>
							<th>최종수집시간</th>
							<th>내부온도</th>
							<th>내부습도</th>
							<th>내부 CO2</th>
							<th>내부 음압</th>
							<th>외기온도</th>
							<th>외기습도</th>
							<th>외기 NH3</th>
							<th>외기 H2S</th>
						</thead>
						<tbody>
							<tr>
								<td>PLC 센서</td>
								<td>2021-05-10 16:00:00</td>
								<td>31.9|34.0|32.0|30.1</td>
								<td>45.1|45.0|40.9|56.4</td>
								<td>2073</td>
								<td>0.0</td>
								<td>16.1</td>
								<td>61.4</td>
								<td>N</td>
								<td>N</td>
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