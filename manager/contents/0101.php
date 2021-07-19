<?
include_once("../inc/top.php");
?>

<div class="row">
	<div class="col-xs-12">
		<div class="jarviswidget jarviswidget-color-white no-padding" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
			<header style="border-radius: 10px 10px 0 0">
				<div class="widget-header">	
					<h2 class="font-weight-bold text-primary"><i class="fa fa-home text-success"></i>&nbsp;&nbsp;전국 농장 센서 현황&nbsp;</h2>	
				</div>
			</header>
			<div class="widget-body shadow" style="border-radius: 0 0 10px 10px; padding:0.5rem">
				<div class="widget-body-toolbar">
					<form id="search_form" class="form-inline mr-auto" onsubmit="return false;">&nbsp;&nbsp;
						<!--임시 select-->
						<select class="form-control w-auto">
                            <option>전체</option>
                            <option>입추</option>
                            <option>출하</option>
                        </select>&nbsp;&nbsp;
						<input class="form-control w-auto" type="text" name="search_name" maxlength="20" placeholder=" 농장명, 농장ID" size="20">&nbsp;&nbsp;
						<button type="button" class="btn btn-primary btn-sm" onClick="search_action('search')"><span class="fa fa-search"></span>&nbsp;&nbsp;검색</button>&nbsp;&nbsp;
						<button type="button" class="btn btn-danger btn-sm" onClick="search_action('cancle')"><span class="fa fa-times"></span>&nbsp;&nbsp;취소</button>&nbsp;&nbsp;
					</form>
				</div>

				<div class="jqgrid_zone">
					<table id="jqgrid" class="jqgrid_table"></table>
					<div id="jqgrid_pager"></div>
				</div>

			</div>	
		</div>
	</div>
</div>

<?
include_once("../inc/bottom.php")
?>