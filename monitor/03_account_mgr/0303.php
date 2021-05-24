<?
include_once("../inc/top.php");
?>
<!--관리자 계정 관리-->
<div class="row fullSc">
	<article class="col-xl-12">
		<div class="jarviswidget jarviswidget-color-darken no-padding" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
			<header>
				<div class="widget-header">	
					<h2><i class="fa fa-home"></i>&nbsp;&nbsp;&nbsp;관리자 계정 관리</h2>	
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
						&nbsp;&nbsp;
						<select class="form-control">
							<option>계정 구분</option>
							<option>수퍼관리자</option>
							<option>지역관리자</option>
							<option>그룹관리자</option>
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
						<th>등록일자</th>
						<th>아이디</th>
						<th>비밀번호</th>
						<th>계열회사</th>
						<th>성명</th>
						<th>전화번호</th>
						<th>이메일</th>
						<th>계정구분</th>
					</thead>
					<tbody>
						<tr>
							<td>1</td>
							<td>2020-11-03 14:28:44</td>
							<td>Test1</td>
							<td>Test1234</td>
							<td>이모션</td>
							<td>테스터</td>
							<td>010-1234-1234</td>
							<td>test@demotion.co.kr</td>
							<td>일반</td>
						</tr>
						<tr>
							<td>2</td>
							<td>2020-11-03 14:28:44</td>
							<td>Test1</td>
							<td>Test1234</td>
							<td>이모션</td>
							<td>테스터</td>
							<td>010-1234-1234</td>
							<td>test@demotion.co.kr</td>
							<td>일반</td>
						</tr>
						<tr>
							<td>3</td>
							<td>2020-11-03 14:28:44</td>
							<td>Test1</td>
							<td>Test1234</td>
							<td>이모션</td>
							<td>테스터</td>
							<td>010-1234-1234</td>
							<td>test@demotion.co.kr</td>
							<td>일반</td>
						</tr>
						<tr>
							<td>4</td>
							<td>2020-11-03 14:28:44</td>
							<td>Test1</td>
							<td>Test1234</td>
							<td>이모션</td>
							<td>테스터</td>
							<td>010-1234-1234</td>
							<td>test@demotion.co.kr</td>
							<td>일반</td>
						</tr>
						<tr>
							<td>5</td>
							<td>2020-11-03 14:28:44</td>
							<td>Test1</td>
							<td>Test1234</td>
							<td>이모션</td>
							<td>테스터</td>
							<td>010-1234-1234</td>
							<td>test@demotion.co.kr</td>
							<td>일반</td>
						</tr>
						<tr>
							<td>6</td>
							<td>2020-11-03 14:28:44</td>
							<td>Test1</td>
							<td>Test1234</td>
							<td>이모션</td>
							<td>테스터</td>
							<td>010-1234-1234</td>
							<td>test@demotion.co.kr</td>
							<td>일반</td>
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