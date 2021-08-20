<?
include_once("../inc/top.php")
?>

<!--일일 급이 / 급수량-->
<div class="row" id="row_feed_water">
	<div class="col-xs-12">
		<div class="jarviswidget jarviswidget-color-white no-padding mb-3" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">							
			<header style="border-radius: 10px 10px 0px 0px; border : 4px solid #eee; border-bottom: 0; background-color: #0c6ad0;">
				<div class="widget-header">	
					<h2 class="font-weight-bold text-white feeder"><i class="fa fa-info-circle"></i>&nbsp;&nbsp;급이 및 급수 정보</h2>	
				</div>
			</header>
			<div class="widget-body pt-3" style="border-radius: 0px 0px 10px 10px; border : 4px solid #eee; border-top: 0; padding:1rem; height: 250px">
				<div class="col-xs-4 no-padding" style="margin-bottom: 15px">
					<div class="col-xs-12 text-center no-padding"><img id="feed_img" src="../images/feed-04.png" style="width: 8rem;"><br>
						<div class="carousel-caption" style="text-shadow: none;"><h3 class="font-weight-bold m-0 pt-4 text-secondary" id="extra_feed_percent">100%</h3></div>
					</div>
				</div>
				<div class="col-xs-4 no-padding" style="margin-top: 20px">
					<div class="col-xs-12 no-padding text-right"><span style="font-size:18px">일일 급이량</span>(kg)<br><span id="extra_curr_feed" style="font-size:28px">0</span></div>
				</div>
				<div class="col-xs-4 no-padding" style="margin-top: 20px">
					<div class="col-xs-12 no-padding text-right"><span style="font-size:18px">전일 급이량</span>(kg)<br><span id="extra_prev_feed" style="font-size:28px">0</span></div>
				</div>
				<div style="clear:both"></div><hr style="margin-top:0px">
				<div class="col-xs-4 no-padding" style="margin-top: 5px">
					<div class="col-xs-12 text-center"><img src="../images/water-02.png" style="width: 6rem;"><br><span></span></div>
				</div>
				<div class="col-xs-4 no-padding" style="margin-top: 10px">
					<div class="col-xs-12 no-padding text-right"><span style="font-size:18px">일일 급수량</span>(L)<br><span id="extra_curr_water" style="font-size:28px">0</span></div>
				</div>
				<div class="col-xs-4 no-padding" style="margin-top: 10px">
					<div class="col-xs-12 no-padding text-right"><span style="font-size:18px">전일 급수량</span>(L)<br><span id="extra_prev_water" style="font-size:28px">0</span></div>
				</div>
			</div>
		</div>
	</div>
</div>
	
<div class="row">
	<div class="col-xs-12">
		<div class="jarviswidget jarviswidget-color-white no-padding mb-3" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">							
			<header style="border-radius: 10px 10px 0px 0px; border : 4px solid #eee; border-bottom: 0; background-color: #0c6ad0;">
				<div class="widget-header">	
					<h2 class="font-weight-bold text-white"><i class="fa fa-bar-chart-o"></i>&nbsp;&nbsp;오늘 급이량 변화</h2>	
				</div>
			</header>
			<div class="widget-body no-padding" style="border-radius: 0px 0px 10px 10px; border : 4px solid #eee; border-top: 0;">
				<div id="today_feed_chart" style="height: 260px;"></div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-xs-12">
		<div class="jarviswidget jarviswidget-color-white no-padding mb-3" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">							
			<header style="border-radius: 10px 10px 0px 0px; border : 4px solid #eee; border-bottom: 0; background-color: #0c6ad0;">
				<div class="widget-header">	
					<h2 class="font-weight-bold text-white"><i class="fa fa-bar-chart-o"></i>&nbsp;&nbsp;일령별 급이량 변화</h2>	
				</div>
			</header>
			<div class="widget-body no-padding" style="border-radius: 0px 0px 10px 10px; border : 4px solid #eee; border-top: 0;">
				<div id="daily_feed_chart" style="height: 260px;"></div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-xs-12">
		<div class="jarviswidget jarviswidget-color-white no-padding mb-3" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">							
			<header style="border-radius: 10px 10px 0px 0px; border : 4px solid #eee; border-bottom: 0; background-color: #0c6ad0;">
				<div class="widget-header">	
					<h2 class="font-weight-bold text-white"><i class="fa fa-bar-chart-o"></i>&nbsp;&nbsp;오늘 급수량 변화</h2>	
				</div>
			</header>
			<div class="widget-body no-padding" style="border-radius: 0px 0px 10px 10px; border : 4px solid #eee; border-top: 0;">
				<div id="today_water_chart" style="height: 260px;"></div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-xs-12">
		<div class="jarviswidget jarviswidget-color-white no-padding mb-3" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">							
			<header style="border-radius: 10px 10px 0px 0px; border : 4px solid #eee; border-bottom: 0; background-color: #0c6ad0;">
				<div class="widget-header">	
					<h2 class="font-weight-bold text-white"><i class="fa fa-bar-chart-o"></i>&nbsp;&nbsp;일령별 급수량 변화</h2>	
				</div>
			</header>
			<div class="widget-body no-padding" style="border-radius: 0px 0px 10px 10px; border : 4px solid #eee; border-top: 0;">
				<div id="daily_water_chart" style="height: 260px;"></div>
			</div>
		</div>
	</div>
</div>


<?
include_once("../inc/bottom.php")
?>

<script language="javascript">

	function get_dong_data(){
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
				draw_bar_line_chart("daily_feed_chart", data.chart_feed, "Y", "N", 12, "DD");
				draw_bar_line_chart("daily_water_chart", data.chart_water, "Y", "N", 12, "DD");
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
				draw_bar_line_chart("today_feed_chart", data.chart_feed, "Y", "N", 12, "mm");
				draw_bar_line_chart("today_water_chart", data.chart_water, "Y", "N", 12, "mm");
			}
		});
	};
</script>