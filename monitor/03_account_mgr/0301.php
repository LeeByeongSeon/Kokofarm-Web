<?
include_once("../inc/top.php");
?>
<!--농장 계정 관리-->
<div class="row fullSc">
	<article class="col-xl-12">
		<div class="jarviswidget jarviswidget-color-darken no-padding" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
			<header>
				<div class="widget-header">	
					<h2><i class="fa fa-home"></i>&nbsp;&nbsp;&nbsp;농장 계정 관리</h2>	
				</div>
			</header>
				
			<div class="widget-body">

				<div class="widget-body-toolbar">
					<form id="searchFORM" class="form-inline" onsubmit="return false;">
						<select class="form-control">
							<option>계열회사</option>
							<option>이모션</option>
							<option>하림</option>
							<option>참프레</option>
							<option>올품</option>
							<option>동우</option>
						</select>
						&nbsp;&nbsp;<input class="form-control" type="text" name="searchName" maxlength="20" placeholder="농장명, 농장ID" size="15" >&nbsp;&nbsp;
						<button type="button" class="btn btn-primary btn-sm" onClick="actionBtn('Search')"><span class="fa fa-search"></span>&nbsp;&nbsp;검색</button>&nbsp;
						<button type="button" class="btn btn-danger btn-sm" onClick="actionBtn('Search')"><span class="fa fa-times"></span>&nbsp;&nbsp;취소</button>&nbsp;
						<button type="button" class="btn btn-success btn-sm" onClick="actionBtn('Search')"><span class="fa fa-file-excel-o"></span>&nbsp;&nbsp;엑셀</button>&nbsp;
					</form>
				</div>

				<table class="table table-bordered table-hover" style="text-align: center;">
					<thead>
						<th></th>
						<th>농장주ID</th>
						<th>농장주PW</th>
						<th>계열회사</th>
						<th>농장명</th>
						<th>농장주명</th>
						<th>농장ID</th>
						<th>계열화회사ID</th>
						<th>IP</th>
						<th>IoT저울</th>
						<th>IP 카메라</th>
						<th>PLC</th>
						<th>급이</th>
						<th>급수</th>
						<th>외기</th>
					</thead>
					<tbody>
						<tr>
							<td>1</td>
							<td>kk0011</td>
							<td>kk0011</td>
							<td>하림</td>
							<td>고산농장</td>
							<td>하림직영</td>
							<td>KF0011</td>
							<td>aaaaaa</td>
							<td>119.206.86.123</td>
							<td>12</td>
							<td>4</td>
							<td>0</td>
							<td>0</td>
							<td>0</td>
							<td>0</td>
						</tr>
						<tr>
							<td>2</td>
							<td>kk0012</td>
							<td>kk0012</td>
							<td>하림</td>
							<td>김제농장</td>
							<td>하림직영</td>
							<td>KF0012</td>
							<td>aaaaaa</td>
							<td>218.158.234.10</td>
							<td>15</td>
							<td>5</td>
							<td>0</td>
							<td>0</td>
							<td>0</td>
							<td>0</td>
						</tr>
						<tr>
							<td>3</td>
							<td>kk0016</td>
							<td>kk0016</td>
							<td>하림</td>
							<td>익산망성농장</td>
							<td>하림직영</td>
							<td>KF0016</td>
							<td>aaaaaa</td>
							<td>175.208.52.215</td>
							<td>96</td>
							<td>32</td>
							<td>0</td>
							<td>0</td>
							<td>0</td>
							<td>0</td>
						</tr>
						<tr>
							<td>4</td>
							<td>kk0017</td>
							<td>kk0017</td>
							<td>올품</td>
							<td>상주올품농장</td>
							<td>채병호</td>
							<td>KF0017</td>
							<td>aaaaaa</td>
							<td>118.43.116.223</td>
							<td>9</td>
							<td>3</td>
							<td>0</td>
							<td>0</td>
							<td>0</td>
							<td>0</td>
						</tr>
						<tr>
							<td>5</td>
							<td>kk0018</td>
							<td>kk0018</td>
							<td>하림</td>
							<td>부안예동농장</td>
							<td>김홍균</td>
							<td>KF0018</td>
							<td>aaaaaa</td>
							<td>221.164.227.42</td>
							<td>12</td>
							<td>4</td>
							<td>0</td>
							<td>0</td>
							<td>0</td>
							<td>0</td>
						</tr>
						<tr>
							<td>6</td>
							<td>kk0020</td>
							<td>33483348</td>
							<td>하림</td>
							<td>청운농장</td>
							<td>소병태</td>
							<td>KF0020</td>
							<td>aaaaaa</td>
							<td>175.208.127.174</td>
							<td>15</td>
							<td>5</td>
							<td>4</td>
							<td>3</td>
							<td>3</td>
							<td>1</td>
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