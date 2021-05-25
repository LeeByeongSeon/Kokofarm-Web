<?
include_once("../inc/top.php");
?>
<!--PLC Unit ID 관리-->
<div class="row fullSc">
	<article class="col-xl-12">
		<div class="jarviswidget jarviswidget-color-teal no-padding" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
			<header>
				<div class="widget-header">	
					<h2><i class="fa fa-list"></i>&nbsp;&nbsp;&nbsp;PLC Unit ID 관리</h2>	
				</div>
			</header>
				
			<div class="widget-body">
				
				<table class="table table-bordered table-hover" style="text-align: center;">
					<thead>
						<th></th>
						<th>PLC주소</th>
						<th>PLC속성</th>
						<th>장치명(유닛명)</th>
						<th>장치설명</th>
						<th>파싱규칙</th>
					</thead>
					<tbody>
						<tr>
							<td>1</td>
							<td>9001</td>
							<td>R</td>
							<td>FarmInfo</td>
							<td>농장ID</td>
							<td>signed-1</td>
						</tr>
						<tr>
							<td>2</td>
							<td>9002</td>
							<td>R</td>
							<td>FarmInfo</td>
							<td>동ID</td>
							<td>unsigned-1</td>
						</tr>
						<tr>
							<td>3</td>
							<td>9003</td>
							<td>R</td>
							<td>FarmInfo</td>
							<td>입추상태</td>
							<td>signed-0</td>
						</tr>
						<tr>
							<td>4</td>
							<td>9004</td>
							<td>R</td>
							<td>FarmInfo</td>
							<td>일령</td>
							<td>signed-1</td>
						</tr>
						<tr>
							<td>5</td>
							<td>9011</td>
							<td>R</td>
							<td>FarmInfo</td>
							<td>평균체중</td>
							<td>signed-1</td>
						</tr>
						<tr>
							<td>6</td>
							<td>9012</td>
							<td>R</td>
							<td>FarmInfo</td>
							<td>증체율</td>
							<td>signed-1</td>
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