<?
include_once("../inc/top.php");
?>
<!--재산출 요청 관리-->
<div class="row fullSc">
	<article class="col-xl-12">
		<div class="jarviswidget jarviswidget-color-darken no-padding" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
			<header>
				<div class="widget-header">	
					<h2><i class="fa fa-table"></i>&nbsp;&nbsp;&nbsp;재산출 요청 관리</h2>	
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
						<th>요청 시간</th>
						<th>농장</th>
						<th>동</th>
						<th>요청사항</th>
						<th>진행상태</th>
						<th>승인시간</th>
						<th>기존 축종</th>
						<th>변경 축종</th>
						<th>기존 입추시간</th>
						<th>변경 입추시간</th>
						<th>실측 시간</th>
						<th>실측 값</th>
						<th>기존 예측증량</th>
						<th>기존 ratio</th>
						<th>변경된 ratio</th>
						<th>완료시간</th>
					</thead>
					<tbody>
						<tr>
							<td>1</td>
							<td>2020-03-16 17:54:00</td>
							<td>KF0013<br>(망성농장)</td>
							<td>01</td>
							<td>Opt(재산출)</td>
							<td>R(요청)</td>
							<td>2020-03-16 17:54:00</td>
							<td>육계</td>
							<td>육계</td>
							<td>2020-03-16 17:54:00</td>
							<td>2020-05-03 13:50:00</td>
							<td>2020-04-16 13:50:00</td>
							<td>1420</td>
							<td>1375</td>
							<td>0.7</td>
							<td>0.61</td>
							<td>2021-05-06 13:00:00</td>
						</tr>
						<tr>
							<td>2</td>
							<td>2020-03-16 17:54:00</td>
							<td>KF0013<br>(망성농장)</td>
							<td>01</td>
							<td>Day(일령)</td>
							<td>R(요청)</td>
							<td>2020-03-16 17:54:00</td>
							<td>육계</td>
							<td>육계</td>
							<td>2020-03-16 17:54:00</td>
							<td>2020-05-03 13:50:00</td>
							<td>2020-04-16 13:50:00</td>
							<td>1420</td>
							<td>1375</td>
							<td>0.7</td>
							<td>0.61</td>
							<td>2021-05-06 13:00:00</td>
						</tr>
						<tr>
							<td>3</td>
							<td>2020-03-16 17:54:00</td>
							<td>KF0013<br>(망성농장)</td>
							<td>01</td>
							<td>Day(일령)<br>Lst(축종)</td>
							<td>R(요청)</td>
							<td>2020-03-16 17:54:00</td>
							<td>육계</td>
							<td>육계</td>
							<td>2020-03-16 17:54:00</td>
							<td>2020-05-03 13:50:00</td>
							<td>2020-04-16 13:50:00</td>
							<td>1420</td>
							<td>1375</td>
							<td>0.7</td>
							<td>0.61</td>
							<td>2021-05-06 13:00:00</td>
						</tr>
						<tr>
							<td>4</td>
							<td>2020-03-16 17:54:00</td>
							<td>KF0013<br>(망성농장)</td>
							<td>01</td>
							<td>Day(일령)<br>Lst(축종)</td>
							<td>R(요청)</td>
							<td>2020-03-16 17:54:00</td>
							<td>육계</td>
							<td>육계</td>
							<td>2020-03-16 17:54:00</td>
							<td>2020-05-03 13:50:00</td>
							<td>2020-04-16 13:50:00</td>
							<td>1420</td>
							<td>1375</td>
							<td>0.7</td>
							<td>0.61</td>
							<td>2021-05-06 13:00:00</td>
						</tr>
						<tr>
							<td>5</td>
							<td>2020-03-16 17:54:00</td>
							<td>KF0013<br>(망성농장)</td>
							<td>01</td>
							<td>Opt(재산출)</td>
							<td>R(요청)</td>
							<td>2020-03-16 17:54:00</td>
							<td>육계</td>
							<td>육계</td>
							<td>2020-03-16 17:54:00</td>
							<td>2020-05-03 13:50:00</td>
							<td>2020-04-16 13:50:00</td>
							<td>1420</td>
							<td>1375</td>
							<td>0.7</td>
							<td>0.61</td>
							<td>2021-05-06 13:00:00</td>
						</tr>
						<tr>
							<td>6</td>
							<td>2020-03-16 17:54:00</td>
							<td>KF0013<br>(망성농장)</td>
							<td>01</td>
							<td>Opt(재산출)</td>
							<td>R(요청)</td>
							<td>2020-03-16 17:54:00</td>
							<td>육계</td>
							<td>육계</td>
							<td>2020-03-16 17:54:00</td>
							<td>2020-05-03 13:50:00</td>
							<td>2020-04-16 13:50:00</td>
							<td>1420</td>
							<td>1375</td>
							<td>0.7</td>
							<td>0.61</td>
							<td>2021-05-06 13:00:00</td>
						</tr>
					</tbody>
				</table>
				
			</div>
					
		</div>
	</article>
</div>

<?
include_once("../inc/bottom.php");
?>