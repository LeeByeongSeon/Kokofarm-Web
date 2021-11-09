<?
include_once("../inc/top.php")
?>

<!--일일 급이 / 급수량-->
<div class="row" id="row_feed_water">
	<div class="col-sm-12 no-padding" style="margin-top:-25px;">
		<div class="jarviswidget jarviswidget-color-white no-padding" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">							
			<header style="border-radius: 15px 15px 0px 0px; border : 4px solid #E6E6E6; border-bottom: 0; background-image: url(../images/bgcolor.png); background-repeat: no-repeat">
				<div class="widget-header">	
					<h2 class="font-weight-bold text-white feeder">급이 및 급수 정보</h2>	
				</div>
			</header>
			<div class="widget-body pt-3" style="border-radius: 0 0 15px 15px; padding:1rem;">
				<div class="col-sm-2 no-padding">
					<div class="col-sm-12 text-center"><img id="feed_img" src="../images/feed-04.png" style="width: 8rem;"><br>
						<div class="carousel-caption" style="text-shadow: none;"><h3 class="font-weight-bold m-0 pb-3 text-secondary" id="extra_feed_percent">-%</h3></div>
					</div>
					<div class="col-sm-12 text-center no-padding"><span>사료잔량 <span id="extra_feed_remain">-</span>(Kg)</span></div>
				</div>
				<div class="col-sm-2 no-padding">
					<div class="col-sm-12 text-right"><span style="font-size: 15px">오늘<br>급이량(㎏)</span><br><span id="extra_curr_feed" style="font-size:28px">-</span></div>
				</div>
				<div class="col-sm-2 no-padding" style="border-right:1px solid #C2C2C2">
					<div class="col-sm-12 text-right"><span style="font-size: 15px">전일<br>급이량(㎏)</span><br><span id="extra_prev_feed" style="font-size:28px">-</span></div>
				</div>
				<div class="col-sm-2 no-padding" style="margin-top: 2px">
					<div class="col-sm-12 text-center"><img src="../images/water-02.png" style="width: 6rem;"><br><span></span></div>
					<div class="col-sm-12 text-center no-padding"><span>시간당 급수량 <span id="extra_water_per_hour">-</span>(L)</span></div>
				</div>
				<div class="col-sm-2 no-padding">
					<div class="col-sm-12 text-right"><span style="font-size: 15px">오늘<br>급수량(L)</span><br><span id="extra_curr_water" style="font-size:28px">-</span></div>
				</div>
				<div class="col-sm-2 no-padding">
					<div class="col-sm-12 text-right"><span style="font-size: 15px">전일<br>급수량(L)</span><br><span id="extra_prev_water" style="font-size:28px">-</span></div>
				</div>
			</div>
		</div>
	</div>
</div>
	
<div class="row">
	<div class="col-sm-12 no-padding" style="margin-top:-25px;">
		<div class="jarviswidget jarviswidget-color-white no-padding" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">							
			<header style="border-radius: 15px 15px 0px 0px; border : 4px solid #E6E6E6; border-bottom: 0; background-image: url(../images/bgcolor.png); background-repeat: no-repeat">
				<div class="widget-header">	
					<h2 class="font-weight-bold text-white">오늘 급이량 변화</h2>	
				</div>
			</header>
			<div class="widget-body" style="border-radius: 0px 0px 15px 15px; border : 4px solid #E6E6E6; border-top: 0;">
				<div id="today_feed_chart" style="height: 260px;"></div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-sm-12 no-padding" style="margin-top:-25px;">
		<div class="jarviswidget jarviswidget-color-white no-padding" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">							
			<header style="border-radius: 15px 15px 0px 0px; border : 4px solid #E6E6E6; border-bottom: 0; background-image: url(../images/bgcolor.png); background-repeat: no-repeat">
				<div class="widget-header">	
					<h2 class="font-weight-bold text-white">일령별 급이량 변화</h2>	
				</div>
			</header>
			<div class="widget-bodybody" style="border-radius: 0px 0px 15px 15px; border : 4px solid #E6E6E6; border-top: 0;">
				<div id="daily_feed_chart" style="height: 260px;"></div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-sm-12 no-padding" style="margin-top:-25px;">
		<div class="jarviswidget jarviswidget-color-white no-padding" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">							
			<header style="border-radius: 15px 15px 0px 0px; border : 4px solid #E6E6E6; border-bottom: 0; background-image: url(../images/bgcolor.png); background-repeat: no-repeat">
				<div class="widget-header">	
					<h2 class="font-weight-bold text-white">오늘 급수량 변화</h2>	
				</div>
			</header>
			<div class="widget-body" style="border-radius: 0px 0px 15px 15px; border : 4px solid #E6E6E6; border-top: 0;">
				<div id="today_water_chart" style="height: 260px;"></div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-sm-12 no-padding" style="margin-top:-25px;">
		<div class="jarviswidget jarviswidget-color-white no-padding" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">							
			<header style="border-radius: 15px 15px 0px 0px; border : 4px solid #E6E6E6; border-bottom: 0; background-image: url(../images/bgcolor.png); background-repeat: no-repeat">
				<div class="widget-header">	
					<h2 class="font-weight-bold text-white">일령별 급수량 변화</h2>	
				</div>
			</header>
			<div class="widget-body" style="border-radius: 0px 0px 15px 15px; border : 4px solid #E6E6E6; border-top: 0;">
				<div id="daily_water_chart" style="height: 260px;"></div>
			</div>
		</div>
	</div>
</div>


<?
include_once("../inc/bottom.php")
?>

<script language="javascript">

	function get_data(){
		get_buffer();
		get_all();
		get_today();
	};

	function get_buffer(){
		let data_arr = {};
		data_arr["oper"] = "get_buffer";	
		data_arr["cmCode"] = top_code;	//등록코드
		
		$.ajax({
			url:'0103_action.php',
			data:data_arr,
			cache:false,
			type:'post',
			dataType:'json',
			success: function(data){
				$.each(data.extra, function(key, val){	$("#" + key).html(val); });

				let per = data.extra.extra_feed_percent;
				per = parseInt(per);
				if(per <= 10){ 				document.getElementById("feed_img").setAttribute("src", "../images/feed-00.png"); }
				if(per > 10 && per <= 35){ 	document.getElementById("feed_img").setAttribute("src", "../images/feed-01.png"); }
				if(per > 35 && per <= 65){ 	document.getElementById("feed_img").setAttribute("src", "../images/feed-02.png"); }
				if(per > 65 && per <= 90){ 	document.getElementById("feed_img").setAttribute("src", "../images/feed-03.png"); }
				if(per > 90){ 				document.getElementById("feed_img").setAttribute("src", "../images/feed-04.png"); }
			}
		});
	};

	function get_all(){
		
		let data_arr = {};
		data_arr["oper"]   = "get_all";
		data_arr["cmCode"] = top_code;

		$.ajax({
			url:'0103_action.php',
			type:'post',
			cache:false,
			data:data_arr,
			dataType:'json',
			success: function(data){
				data.chart_feed = convert_amchart_time(data.chart_feed, "시간");
				data.chart_water = convert_amchart_time(data.chart_water, "시간");
				draw_bar_line_chart("daily_feed_chart", data.chart_feed, "Y", "N", 12, "DD", "#FF9900");
				draw_bar_line_chart("daily_water_chart", data.chart_water, "Y", "N", 12, "DD", "#2FB5F0");
			}
		});
	};

	function get_today(){
		
		let data_arr = {};
		data_arr["oper"]   = "get_today";
		data_arr["cmCode"] = top_code;

		$.ajax({
			url:'0103_action.php',
			type:'post',
			cache:false,
			data:data_arr,
			dataType:'json',
			success: function(data){
				data.chart_feed = convert_amchart_time(data.chart_feed, "시간");
				data.chart_water = convert_amchart_time(data.chart_water, "시간");
				draw_bar_line_chart("today_feed_chart", data.chart_feed, "Y", "N", 12, "hh", "#FF9900");
				draw_bar_line_chart("today_water_chart", data.chart_water, "Y", "N", 12, "hh", "#2FB5F0");
			}
		});
	};
</script>