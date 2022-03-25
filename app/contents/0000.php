<?
include_once("../inc/top.php");

$dong_list_html="";

foreach($init_data as $val){
	$dong_list_html .= "<div class='row' id=''>";
	$dong_list_html .= "<div class='col-xs-12'>";
	$dong_list_html .= "<div class='jarviswidget jarviswidget-color-white no-padding mb-3' data-widget-editbutton='false' data-widget-colorbutton='false' data-widget-deletebutton='false' data-widget-fullscreenbutton='false' data-widget-togglebutton='false'>";
	$dong_list_html .= "<div class='widget-body no-padding form-inline' style='border-radius: 10px; border : 4px solid #eee; border-top: 0;'>";
	$dong_list_html .= "<div class='col-xs-2 text-center no-padding'><p><span class='fong-md font-weight-bold' style='font-size:15px'>".$val["fdDongid"]."동</span></p><span id=''>".$val["interm"]."일령</span></div>";
	$dong_list_html .= "<div class='col-xs-4 text-center no-padding'><span class='font-lg text-danger font-weight-bold'>".sprintf('%0.1f', $val["beAvgWeight"])."g</span></div>";
	$dong_list_html .= "<div class='col-xs-1 text-center no-padding'><i class='fa fa-circle text-success'></i></div>";
	$dong_list_html .= "<div class='col-xs-3 text-center no-padding'><img src='../images/feed-00.png' style='width:40px'></div>";
	$dong_list_html .= "<div class='col-xs-2 text-center no-padding'><button class='btn btn-default' onClick='popup_breed()' style='border-color:white'><i class='fa fa-pencil-square-o font-lg text-secondary'></i></button></div></div></div></div></div>";
}

?>

<!--농장 전체 평균-->
<div class="row" id="row_summary" >
	<div class="col-xs-12">
		<div class="jarviswidget jarviswidget-color-white no-padding mb-3" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
			<header style="border-radius: 10px 10px 0px 0px; border : 4px solid #eee; border-bottom: 0; background-color: #0c6ad0;">
				<div class="widget-header" style="max-width: 100%;">
					<h2 class="font-weight-bold text-white avg"><i class="fa fa-home"></i>&nbsp;<span class="font-weight-bold" id="summary_farm_name">농장</span> 현황&nbsp;
						<span class="font-sm badge bg-orange">총 <span id="summary_dong_count"> 0 </span>개 동</span>
					</h2>
				</div>
				<div class="widget-toolbar ml-auto">
					<div class="btn-group">
						<button class="btn btn-default btn-sm" type="button">동별로 보기&nbsp;<i class="fa fa-angle-right font-weight-bold"></i></button>
					</div>
				</div>
			</header>
			<div class="widget-body p-1" style="border-radius: 0px 0px 10px 10px; border : 4px solid #eee; border-top: 0;">
				<div class="col-xs-12 d-flex align-items-center pt-3 pb-3">
					<div class="col-xs-6 float-left text-center no-padding">
						<span class="font-weight-bold" style="font-size: 20px">전체 평균중량</span><br>
						<span class="font-weight-bold text-danger" style="font-size: 45px" id="summary_farm_weight">-</span>
						<!-- <span class="font-weight-bold text-secondary" style="font-size:15px;">입추일<br><span id="summary_indate"> - </span></span> -->
					</div>
					<div class="col-xs-3 float-center text-center p-1">
						<span class="font-md text-secondary">표준편차<br><span class="font-md font-weight-bold" id="summary_farm_devi"></span></span>
					</div>
					<div class="col-xs-3 float-right text-center p-1">
						<span class="font-md text-secondary">변이계수<br><span class="font-md font-weight-bold" id="summary_farm_vc"></span></span>
					</div>
				</div>
				<div class="col-xs-12 mb-3">
					<div id="accordion">
						<div>
							<h4>전체 사육 수</h4>
							<div class="col-xs-12 no-padding">
								<!-- <div class="col-xs-6 text-center no-padding">생존수<br><span class="font-lg" id="summary_comein_count">0</span></div>
								<div class="col-xs-2 text-center no-padding">폐사<br><span class="font-lg" id="summary_death_count">0</span></div>
								<div class="col-xs-2 text-center no-padding">도태<br><span class="font-lg" id="summary_cull_count">0</span></div>
								<div class="col-xs-2 text-center no-padding">솎기<br><span class="font-lg" id="summary_thinout_count">0</span></div> -->

								<table class="table table-bordered text-center m-0">
									<thead>
										<tr>
											<th>생존 수</th><th>폐사 수</th><th>도태 수</th><th>솎기 수</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td><span class="font-lg" id="summary_comein_count">0</span></td>
											<td><span class="font-lg" id="summary_death_count">0</span></td>
											<td><span class="font-lg" id="summary_cull_count">0</span></td>
											<td><span class="font-lg" id="summary_thinout_count">0</span></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>	
		</div>
	</div>
</div>

<!--일일 급이 / 급수량-->
<div class="row" id="row_feed_water">
	<div class="col-xs-12">
		<div class="jarviswidget jarviswidget-color-white no-padding mb-3" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">							
			<header style="border-radius: 10px 10px 0px 0px; border : 4px solid #eee; border-bottom: 0; background-color: #0c6ad0;">
				<div class="widget-header">	
					<h2 class="font-weight-bold text-white feeder"><i class="fa fa-info-circle"></i>&nbsp;급이량 및 급수량</h2>	
				</div>
				<div class="widget-toolbar ml-auto">
					<div class="btn-group">
						<button type="button" class="btn btn-xs btn-light text-primary btn_display_toggle" style="height: 25px">&nbsp;<i class="fa fa-minus"></i>&nbsp;</button>
					</div>
				</div>
			</header>
			<div class="widget-body pt-3" style="border-radius: 0px 0px 10px 10px; border : 4px solid #eee; border-top: 0; padding:1rem;">
				<div class="col-xs-12 d-flex align-items-center justify-content-between no-padding">
					<div class="col-xs-3 no-padding">
						<img id="feed_img" src="../images/feed-04.png" style="width: 7rem;"><br>
						<div class="carousel-caption mb-4"><h3 class="font-weight-bold text-secondary" id="summary_feed_percent">-%</h3></div>
						<div class="col-xs-12 text-center no-padding"><span>사료잔량 <span id="summary_feed_remain">-</span>(Kg)</span></div>
					</div>
					<div class="col-xs-3 no-padding text-right">
						<span style="font-size:12px">전체</span>(kg)<br><span id="summary_all_feed" style="font-size:23px">-</span>
					</div>
					<div class="col-xs-3 no-padding text-right">
						<span style="font-size:12px">오늘</span>(kg)<br><span id="summary_curr_feed" style="font-size:23px">-</span>
					</div>
					<div class="col-xs-3 no-padding text-right">
						<span style="font-size:12px">전일</span>(kg)<br><span id="summary_prev_feed" style="font-size:23px">-</span>
					</div>
				</div>
				<div style="clear:both"></div><hr style="margin-top:10px; margin-bottom: 10px">
				<div  class="col-xs-12 d-flex align-items-center justify-content-between no-padding">
					<div class="col-xs-3 no-padding">
						<img src="../images/water-02.png" style="width: 5rem;"><br><span></span>
					<div class="col-xs-12 text-center no-padding"><span>시간당 급수량 <span id="summary_water_per_hour">-</span>(L)</span></div>
					</div>
					<div class="col-xs-3 no-padding text-right">
						<span style="font-size:12px">전체</span>(L)<br><span id="summary_all_water" style="font-size:23px">-</span>
					</div>
					<div class="col-xs-3 no-padding text-right">
						<span style="font-size:12px">오늘</span>(L)<br><span id="summary_curr_water" style="font-size:23px">-</span>
					</div>
					<div class="col-xs-3 no-padding text-right">
						<span style="font-size:12px">전일</span>(L)<br><span id="summary_prev_water" style="font-size:23px">-</span>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?=$dong_list_html?>

<!-- <div class="row" id="">
	<div class="col-xs-12">
		<div class="jarviswidget jarviswidget-color-white no-padding mb-3" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
			<div class="widget-body no-padding form-inline" style="border-radius: 10px; border : 4px solid #eee; border-top: 0;">
				<div class="col-xs-2 text-center"><p><span class="fong-md font-weight-bold" style="font-size:15px">동</span></p><span id="">일령</span></div>
				<div class="col-xs-4 text-center"><span class="font-lg text-danger font-weight-bold">평균체중</span></div>
				<div class="col-xs-1 text-center"><i class='fa fa-circle text-success'></i></div>
				<div class="col-xs-3 text-center"><img src='../images/feed-00.png' style='width:40px'></div>
				<div class="col-xs-2 text-center"><button class='btn btn-default' onClick='set_breed_data()' style='border-color:white'><i class="fa fa-pencil-square-o font-lg text-secondary"></i></button></div>
			</div>
		</div>
	</div>
</div> -->

<!--차트-->
<div class="row">
	<div class="col-xs-12">
		<div class="jarviswidget jarviswidget-color-white no-padding mb-3" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">							
			<header style="border-radius: 10px 10px 0px 0px; border : 4px solid #eee; border-bottom: 0; background-color: #0c6ad0;">
				<div class="widget-header">	
					<h2 class="font-weight-bold text-white"><i class="fa fa-bar-chart-o"></i>&nbsp;차트 부분</h2>	
				</div>
			</header>
			<div class="widget-body no-padding" style="border-radius: 0px 0px 10px 10px; border : 4px solid #eee; border-top: 0;">
				<div class="col-xs-12 no-padding">
					<div id="summary_feed_charts" style="height: 260px;"></div>
				</div>
			</div>
		</div>
	</div>
</div>

<?
include_once("../inc/bottom.php")
?>

<script language="javascript">

	// 아코디언
	let accordionIcons = {
		header: "fa fa-plus",
		activeHeader: "fa fa-minus"
	};
	$("#accordion").accordion({
		autoHeight : false,
		heightStyle : "content",
		collapsible : true,
		animate : 300,
		icons: accordionIcons,
		header : "h4",
	});

	$(document).ready(function(){

		$("#top_navbar").hide();

		$(".btn_display_toggle").off("click").on("click", function(){
			$(this).children("i").toggleClass("fa-minus").toggleClass("fa-plus");
			$(this).parents(".jarviswidget").children(".widget-body").toggle();
		});
	});

	function get_dong_data(){
		
		let data_arr = {};
		data_arr["oper"] = "get_buffer";
		data_arr["cmCode"] = top_code;		//등록코드
		
		$.ajax({
			url:'0000_action.php',
			data:data_arr,
			cache:false,
			type:'post',
			dataType:'json',
			success: function(data){

				//각 요약정보[summary]
				$.each(data.summary, function(key, val){	$("#" + key).html(val); });

				$("#summary_farm_name").html(data.summary.farm_name);
				$("#summary_dong_count").html(data.summary.dong_count);

				let per = data.summary.summary_feed_percent;
				per = parseInt(per);
				if(per <= 10){ 				document.getElementById("feed_img").setAttribute("src", "../images/feed-00.png"); }
				if(per > 10 && per <= 35){ 	document.getElementById("feed_img").setAttribute("src", "../images/feed-01.png"); }
				if(per > 35 && per <= 65){ 	document.getElementById("feed_img").setAttribute("src", "../images/feed-02.png"); }
				if(per > 65 && per <= 90){ 	document.getElementById("feed_img").setAttribute("src", "../images/feed-03.png"); }
				if(per > 90){ 				document.getElementById("feed_img").setAttribute("src", "../images/feed-04.png"); }

			},
			error: function(request,status,error){
				//alert("STATUS : "+request.status+"\n"+"ERROR : "+error);
			}
		});
	}

</script>