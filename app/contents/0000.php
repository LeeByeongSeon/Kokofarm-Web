<?
include_once("../inc/top.php");

$htmlDOM = new DOMDocument("1.0", "utf-8");

if($init_data){
	$dong_list_html = "";

	foreach($init_data as $val){
		$dong_list_html .= "<tr>";
		$dong_list_html .= "<td style='text-align:center'>".$val["fdDongid"]."동</td>";
		$dong_list_html .= "<td style='text-align:right'>".$val["interm"]."</td>";
		$dong_list_html .= "<td style='text-align:right'>".sprintf('%0.1f', $val["beAvgWeight"])."</td>";
		$dong_list_html .= "<td style='text-align:center'></td>";
		$dong_list_html .= "<td style='text-align:right'>".$val["sfFeed"]."</td>";
		$dong_list_html .= "<td style='text-align:center'><button class='btn btn-primary' onClick='set_breed_data()'>작성</button></td>";
		$dong_list_html .= "</tr>";
	}
}

?>

<!--농장 동 목록-->
<div class="row" id="row_dong_list">
	<div class="col-xs-12">
		<div class="jarviswidget jarviswidget-color-white no-padding mb-3" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
			<header style="border-radius: 10px 10px 0px 0px; border : 4px solid #eee; border-bottom: 0; background-color: #0c6ad0;">
				<div class="widget-header" style="max-width: 100%;">	
					<h2 class="font-weight-bold text-white avg"><i class="fa fa-clock-o"></i>&nbsp;보유 동 목록&nbsp;
						<span class="font-sm badge bg-orange"> <span id=""> - </span> </span>
					</h2>	
				</div>
			</header>
			<div class="widget-body p-1" style="border-radius: 0px 0px 10px 10px; border : 4px solid #eee; border-top: 0;">
				<!-- <table id="dong_list_table" data-page-list="[]" data-pagination="true" data-page-list="false" data-page-size="10" data-toggle="table" style="font-size:14px"> -->
				<table class="table table-bordered">
					<thead>
						<tr>
							<th style="text-align: center">동</th>
							<th style="text-align: center">일령</th>
							<th style="text-align: center">평균체중</th>
							<th style="text-align: center">오류</th>
							<th style="text-align: center">사료잔량</th>
							<th style="text-align: center">사육일지</th>
						</tr>
					</thead>
					<tbody id="dong_list_table">
						<?=$dong_list_html?>
					</tbody>
				</table>
			</div>	
		</div>
	</div>
</div>

<!--차트-->
<div class="row">
	<div class="col-xs-12">
		<div class="jarviswidget jarviswidget-color-white no-padding mb-3" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">							
			<header style="border-radius: 10px 10px 0px 0px; border : 4px solid #eee; border-bottom: 0; background-color: #0c6ad0;">
				<div class="widget-header">	
					<h2 class="font-weight-bold text-white"><i class="fa fa-bar-chart-o"></i>&nbsp;오늘 증체중량</h2>	
				</div>
			</header>
			<div class="widget-body no-padding" style="border-radius: 0px 0px 10px 10px; border : 4px solid #eee; border-top: 0;">
				<div class="col-xs-12 no-padding">
					<div id="" style="height: 260px;"></div>
				</div>
			</div>
		</div>
	</div>
</div>

<?
include_once("../inc/bottom.php")
?>

<script language="javascript">

	$(document).ready(function(){

		$(".btn_display_toggle").off("click").on("click", function(){

			$(this).children("i").toggleClass("fa-minus").toggleClass("fa-plus");
			$(this).parents(".jarviswidget").children(".widget-body").toggle();
		});

	});

	function get_dong_data(){

	};
	

</script>