<?
include_once("../inc/top.php");
?>
<!--농가별 현황-->
<article class="col-xl-12 no-padding">
	<div class="jarviswidget jarviswidget-color-grey-dark fullSc no-padding" id="wid-id-1" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
		<header>
			<div class="widget-header">	
				<h2><i class="fa fa-file-text-o"></i>&nbsp;&nbsp;&nbsp;농가별 현황</h2>	
			</div>
		</header>

		<div class="widget-body">
			
			<table class="table table-bordered table-hover" style="text-align: center;">
				<thead>
					<th></th>
					<th>농장이름</th>
					<th>일령</th>
					<th>축종</th>
					<th>저울연결</th>
					<th>온도(℃)</th>
					<th>습도(%)</th>
					<th>CO2</th>
					<th>NH3</th>
					<th>환경 경보</th>
					<th>평균중량<br>(권고대비 비교)</th>
					<th>네트워크</th>
					<th>PLC 제어</th>
					<th>PLC 환경</th>
					<th>급이/급수</th>
					<th>외기환경</th>
				</thead>
				<tbody>
					<tr>
						<td>1</td>
						<td>망성 농장-01동</td>
						<td>15</td>
						<td>육계</td>
						<td><span class="label label-danger">3</span></td>
						<td>28.7|29.6|<span style="color:red">37.8</span></td>
						<td><span style="color:red">78.2</span>|55.7|55.8</td>
						<td>1320|1480|<span style="color:red">3700</span></td>
						<td>0|0|4</td>
						<td><span class="label label-primary">정상</span></td>
						<td>570 (40 <i class="fa fa-sort-up" style="color:red"></i> )</td>
						<td><span class="label label-success"><i class="fa fa-circle-o"></i></span></td>
						<td><span class="label label-success">56초</span></td>
						<td><span class="label label-success">2분 23초</span></td>
						<td><span class="label label-danger">5분 17초</span></td>
						<td><span class="label label-success">1분 23초</span></td>
					</tr>
					<tr>
						<td>2</td>
						<td>망성 농장-01동</td>
						<td><span style="color:red">15</span></td>
						<td>육계</td>
						<td><span class="label label-danger">3</span></td>
						<td>28.7|29.6|<span style="color:red">37.8</span></td>
						<td><span style="color:red">78.2</span>|55.7|55.8</td>
						<td>1320|1480|<span style="color:red">3700</span></td>
						<td>0|0|4</td>
						<td><span class="label label-success">주의</span></td>
						<td>570 (40 <i class="fa fa-sort-up" style="color:red"></i> )</td>
						<td><span class="label label-success"><i class="fa fa-circle-o"></i></span></td>
						<td><span class="label label-default">N</span></td>
						<td><span class="label label-default">N</span></td>
						<td><span class="label label-default">N</span></td>
						<td><span class="label label-default">N</span></td>
					</tr>
					<tr>
						<td>3</td>
						<td>망성 농장-01동</td>
						<td><span style="color:red">15</span></td>
						<td>육계</td>
						<td><span class="label label-danger">3</span></td>
						<td>28.7|29.6|<span style="color:red">37.8</span></td>
						<td><span style="color:red">78.2</span>|55.7|55.8</td>
						<td>1320|1480|<span style="color:red">3700</span></td>
						<td>0|0|4</td>
						<td><span class="label label-warning">경고</span></td>
						<td>570 (40 <i class="fa fa-sort-up" style="color:red"></i> )</td>
						<td><span class="label label-success"><i class="fa fa-circle-o"></i></span></td>
						<td><span class="label label-default">N</span></td>
						<td><span class="label label-default">N</span></td>
						<td><span class="label label-default">N</span></td>
						<td><span class="label label-default">N</span></td>
					</tr>
					<tr>
						<td>4</td>
						<td>망성 농장-01동</td>
						<td>15</td>
						<td>육계</td>
						<td><span class="label label-danger">3</span></td>
						<td>28.7|29.6|<span style="color:red">37.8</span></td>
						<td><span style="color:red">78.2</span>|55.7|55.8</td>
						<td>1320|1480|<span style="color:red">3700</span></td>
						<td>0|0|4</td>
						<td><span class="label label-danger">위험</span></td>
						<td>570 (40 <i class="fa fa-sort-up" style="color:red"></i> )</td>
						<td><span class="label label-success"><i class="fa fa-circle-o"></i></span></td>
						<td><span class="label label-success">56초</span></td>
						<td><span class="label label-success">2분 23초</span></td>
						<td><span class="label label-danger">5분 17초</span></td>
						<td><span class="label label-success">1분 23초</span></td>
					</tr>
					<tr>
						<td>5</td>
						<td>망성 농장-01동</td>
						<td>15</td>
						<td>육계</td>
						<td><span class="label label-danger">3</span></td>
						<td>28.7|29.6|<span style="color:red">37.8</span></td>
						<td><span style="color:red">78.2</span>|55.7|55.8</td>
						<td>1320|1480|<span style="color:red">3700</span></td>
						<td>0|0|4</td>
						<td><span class="label label-warning">경고</span></td>
						<td>570 (40 <i class="fa fa-sort-up" style="color:red"></i> )</td>
						<td><span class="label label-danger"><i class="fa fa-times"></i></span></td>
						<td><span class="label label-success">56초</span></td>
						<td><span class="label label-success">2분 23초</span></td>
						<td><span class="label label-danger">5분 17초</span></td>
						<td><span class="label label-success">1분 23초</span></td>
					</tr>
					<tr>
						<td>6</td>
						<td>망성 농장-01동</td>
						<td>15</td>
						<td>육계</td>
						<td><span class="label label-danger">3</span></td>
						<td>28.7|29.6|<span style="color:red">37.8</span></td>
						<td><span style="color:red">78.2</span>|55.7|55.8</td>
						<td>1320|1480|<span style="color:red">3700</span></td>
						<td>0|0|4</td>
						<td><span class="label label-primary">정상</span></td>
						<td>570 (40 <i class="fa fa-sort-up" style="color:red"></i> )</td>
						<td><span class="label label-danger"><i class="fa fa-times"></i></span></td>
						<td><span class="label label-success">56초</span></td>
						<td><span class="label label-success">2분 23초</span></td>
						<td><span class="label label-danger">5분 17초</span></td>
						<td><span class="label label-success">1분 23초</span></td>
					</tr>
					<tr>
						<td>7</td>
						<td>망성 농장-01동</td>
						<td>15</td>
						<td>육계</td>
						<td><span class="label label-success">0</span></td>
						<td>28.7|29.6|<span style="color:red">37.8</span></td>
						<td><span style="color:red">78.2</span>|55.7|55.8</td>
						<td>1320|1480|<span style="color:red">3700</span></td>
						<td>0|0|4</td>
						<td><span class="label label-primary">정상</span></td>
						<td>570 (40 <i class="fa fa-sort-up" style="color:red"></i> )</td>
						<td><span class="label label-danger"><i class="fa fa-times"></i></span></td>
						<td><span class="label label-success">56초</span></td>
						<td><span class="label label-success">2분 23초</span></td>
						<td><span class="label label-default">N</span></td>
						<td><span class="label label-default">N</span></td>
					</tr>
				</tbody>
			</table>
			
		</div>
				
	</div>
</article>
	
<?
include_once("../inc/bottom.php");
?>