<?
include_once("../inc/top.php");
?>
<!--IP 카메라 관리-->
<article class="col-xl-10 float-right">
	<div class="row">
		<div class="col-xl-12">
			<div class="jarviswidget jarviswidget-color-darken no-padding" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
				<header>
					<div class="widget-header">	
						<h2><i class="fa fa-video-camera"></i>&nbsp;&nbsp;&nbsp;IP 카메라 관리</h2>	
					</div>
				</header>
					
				<div class="widget-body">

					<table class="table table-bordered table-hover" style="text-align: center;">
						<thead>
							<th></th>
							<th>농장ID</th>
							<th>동ID</th>
							<th>카메라명</th>
							<th>IP</th>
							<th>Port</th>
							<th>URL</th>
							<th>ID</th>
							<th>PW</th>
						</thead>
						<tbody>
							<tr>
								<td>1</td>
								<td>KF0006</td>
								<td>01</td>
								<td>이모션농장-01동</td>
								<td>220.124.186.151</td>
								<td>15001</td>
								<td>/stw-cgi/video.cgi?msubmenu=snapshot&action=view&Resolution=640x480</td>
								<td>admin</td>
								<td>kokofarm5561</td>
							</tr>
							<tr>
								<td>1</td>
								<td>KF0006</td>
								<td>03</td>
								<td>이모션농장-03동</td>
								<td>220.124.186.151</td>
								<td>15001</td>
								<td>/stw-cgi/video.cgi?msubmenu=snapshot&action=view&Resolution=640x480</td>
								<td>admin</td>
								<td>kokofarm5561</td>
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