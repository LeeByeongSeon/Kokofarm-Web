<?
include_once("../inc/top.php");

// if($init_data){
// 	$dong_list_html = "";

// 	foreach($init_data as $val){
// 		$dong_list_html .= "<tr>";
// 		$dong_list_html .= "<th style='text-align:center'>".$val["fdDongid"]."동</th>";
// 		$dong_list_html .= "<td style='text-align:center'>".$val["interm"]."</td>";
// 		$dong_list_html .= "<td style='text-align:right'><span class='text-danger font-weight-bold font-lg'>".sprintf('%0.1f', $val["beAvgWeight"])."g</span></td>";
// 		$dong_list_html .= "<td style='text-align:center'><i class='fa fa-circle text-success'></i></td>";
// 		$dong_list_html .= "<td style='text-align:center'><img src='../images/feed-00.png' style='width:40px'></td>";
// 		$dong_list_html .= "<td style='text-align:center'><button class='btn btn-default' onClick='set_breed_data()' style='border-color:white'><img src='../images/diary.png' style='width:30px' alt='사육일지'></button></td>";
// 		$dong_list_html .= "</tr>";
// 	}
// }

?>

<!--농장 동 목록-->
<!-- <div class="row" id="row_dong_list">
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
				<table id="dong_list_table" data-page-list="[]" data-pagination="true" data-page-list="false" data-page-size="10" data-toggle="table" style="font-size:14px">
				<table class="table">
					<thead>
						<tr>
							<th style='text-align:center'>동</th>
							<th style='text-align:center'>일령</th>
							<th style='text-align:center'>평균체중</th>
							<th style='text-align:center'>오류</th>
							<th style='text-align:center'>사료잔량</th>
							<th style='text-align:center'>사육일지</th>
						</tr>
					</thead>
					<tbody id="dong_list_table">
						<?=$dong_list_html?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div> -->

<div class="row" id="">
	<div class="col-xs-12">
		<div class="jarviswidget jarviswidget-color-white no-padding mb-3" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
			<!-- <header style="border-radius: 10px 10px 0px 0px; border : 4px solid #eee; border-bottom: 0; background-color: #0c6ad0;">
				<div class="widget-header" style="max-width: 100%;">	
					<h2 class="font-weight-bold text-white avg"><i class="fa fa-clock-o"></i>&nbsp;보유 동 목록&nbsp;
						<span class="font-sm badge bg-orange"> <span id=""> - </span> </span>
					</h2>	
				</div>
			</header> -->
			<div class="widget-body no-padding form-inline" style="border-radius: 10px; border : 4px solid #eee; border-top: 0;">
				<div class="col-xs-2 text-center"><p><span class="fong-md font-weight-bold" style="font-size:15px">동</span></p><span class="">일령</span></div>
				<div class="col-xs-4 text-center"><span class="font-lg text-danger font-weight-bold">평균체중</span></div>
				<div class="col-xs-2 text-center"><i class='fa fa-circle text-success'></i></div>
				<div class="col-xs-2 text-center"><img src='../images/feed-00.png' style='width:40px'></div>
				<div class="col-xs-2 text-center"><button class='btn btn-default' onClick='set_breed_data()' style='border-color:white'><img src='../images/diary.png' alt='사육일지'></button></div>
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
					<h2 class="font-weight-bold text-white"><i class="fa fa-bar-chart-o"></i>&nbsp;</h2>	
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