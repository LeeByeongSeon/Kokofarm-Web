<?
include_once("../inc/top.php");
?>
<!--출하이력-->
<article class="col-xl-10 float-right">
	<div class="row">
		<div class="col-xl-12">
			<div class="jarviswidget jarviswidget-color-darken no-padding" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
				<header>
					<div class="widget-header">	
						<h2><i class="fa fa-file-text-o"></i>&nbsp;&nbsp;&nbsp;출하이력</h2>	
					</div>
				</header>

				<div class="widget-body">

					<table class="table table-bordered table-hover" style="text-align: center;">
						<thead>
							<th></th>
							<th>농장 ID</th>
							<th>동 ID</th>
							<th>동 이름</th>
							<th>입추일자</th>
							<th>출하일자</th>
							<th>축종</th>
							<th>출하 일령</th>
							<th>출하 수</th>
						</thead>
						<tbody>
							<tr>
								<td>1</td>
								<td>KF0013</td>
								<td>01</td>
								<td>망성농장 1동</td>
								<td>2021-05-06 12:00:00</td>
								<td>2021-05-06 12:00:00</td>
								<td>육계</td>
								<td>35</td>
								<td>23400</td>
							</tr>
							<tr>
								<td>2</td>
								<td>KF0013</td>
								<td>01</td>
								<td>망성농장 1동</td>
								<td>2021-05-06 12:00:00</td>
								<td>2021-05-06 12:00:00</td>
								<td>육계</td>
								<td>35</td>
								<td>23400</td>
							</tr>
							<tr>
								<td>3</td>
								<td>KF0013</td>
								<td>01</td>
								<td>망성농장 1동</td>
								<td>2021-05-06 12:00:00</td>
								<td>2021-05-06 12:00:00</td>
								<td>육계</td>
								<td>35</td>
								<td>23400</td>
							</tr>
							<tr>
								<td>4</td>
								<td>KF0013</td>
								<td>01</td>
								<td>망성농장 1동</td>
								<td>2021-05-06 12:00:00</td>
								<td>2021-05-06 12:00:00</td>
								<td>육계</td>
								<td>35</td>
								<td>23400</td>
							</tr>
						</tbody>
					</table>
					
				</div>
						
			</div>
		</div>
	</div>


	<!--실측중량 기록 & 재산출 기록-->
	<div class="row">
		<div class="col-xl-4">
			<div class="jarviswidget jarviswidget-color-darken no-padding" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
				<header>
					<div class="widget-header">	
						<h2><i class="fa fa-file-text-o"></i>&nbsp;&nbsp;&nbsp;실측중량 기록</h2>	
					</div>
				</header>

				<div class="widget-body">

					<table class="table table-bordered table-hover" style="text-align: center;">
						<thead>
							<th></th>
							<th>실측 일자</th>
							<th>실측 값</th>
						</thead>
						<tbody>
							<tr>
								<td>1</td>
								<td>2021-04-30 20:00:00</td>
								<td>1320</td>
							</tr>
							<tr>
								<td>2</td>
								<td>2021-04-30 20:00:00</td>
								<td>1320</td>
							</tr>
							<tr>
								<td>3</td>
								<td>2021-04-30 20:00:00</td>
								<td>1320</td>
							</tr>
						</tbody>
					</table>
					
				</div>
						
			</div>
		</div>
		
		<div class="col-xl-8">
			<div class="jarviswidget jarviswidget-color-info no-padding" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
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


	<!--환경센서 현황-->
	<div class="row">
		<div class="col-xl-6">
			<div class="jarviswidget jarviswidget-color-darken no-padding" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
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
						</tbody>
					</table>
					
				</div>
						
			</div>
		</div>

		<div class="col-xl-6">
			<div class="jarviswidget jarviswidget-color-orange no-padding" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
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
						</tbody>
					</table>
					
				</div>
						
			</div>
		</div>
	</div>


	<!--장치 현황-->
	<div class="row">
		<div class="col-xl-12">
			<div class="jarviswidget jarviswidget-color-darken no-padding" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
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

					<table class="table table-bordered table-hover" style="text-align: center;">
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
					
				</div>
						
			</div>
		</div>
	</div>


	<!--로우데이터 확인-->
	<div class="row">
		<div class="col-xl-12">
			<div class="jarviswidget jarviswidget-color-darken no-padding" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
				<header>
					<div class="widget-header">	
						<h2><i class="fa fa-table"></i>&nbsp;&nbsp;&nbsp;로우데이터 확인</h2>	
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
							LIMIT&nbsp;&nbsp;<input class="form-control" type="text" maxlength="4" placeholder="1000" size="15">&nbsp;&nbsp;
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
</article>
<?
include_once("../inc/bottom.php");
?>