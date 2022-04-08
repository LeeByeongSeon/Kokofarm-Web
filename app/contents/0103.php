<?
include_once("../inc/top.php")
?>

<!--일일 급이 / 급수량-->
<div class="row" id="row_feed_water">
	<div class="col-xs-12">
		<div class="jarviswidget jarviswidget-color-white no-padding mb-3" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">							
			<header style="border-radius: 10px 10px 0px 0px; border : 4px solid #eee; border-bottom: 0; background-color: #0c6ad0;">
				<div class="widget-header">	
					<h2 class="font-weight-bold text-white feeder"><i class="fa fa-info-circle"></i>&nbsp;급이량 및 급수량
						<!-- <span class="font-sm badge bg-orange">마리당 급이량 : <span id="total_per_feed"> 0 </span>g</span> -->
					</h2>	
				</div>
				<div class="widget-toolbar ml-auto">
					<div class="btn-group">
						<button type="button" class="btn btn-xs btn-light text-primary btn_display_toggle" style="height: 25px">&nbsp;<i class="fa fa-minus"></i>&nbsp;</button>
					</div>
				</div>
			</header>
			<div class="widget-body p-3" style="border-radius: 0px 0px 10px 10px; border : 4px solid #eee; border-top: 0; padding:0.5rem;">
				<div class="col-xs-12 d-flex align-items-center justify-content-between no-padding">
					<div class="col-xs-6 no-padding text-center">
						<span class="font-md text-secondary">수 당 급이량 <br><span class="font-md text-danger font-weight-bold" id="dong_per_feed"></span></span>
					</div>
					<div class="col-xs-6 no-padding text-center">
						<span class="font-md text-secondary">수 당 급수량 <br><span class="font-md text-primary font-weight-bold" id="dong_per_water"></span></span>
					</div>
				</div>

				<div style="clear:both"></div><hr style="margin-top:10px; margin-bottom: 10px">

				<div class="col-xs-12 d-flex align-items-center justify-content-between no-padding">
					<div class="col-xs-3 no-padding text-center">
						<img id="feed_img" src="../images/feed-04.png" style="width: 7rem;"><br>
						<div class="carousel-caption mb-4"><h3 class="font-weight-bold text-secondary" id="extra_feed_percent">-%</h3></div>
						<div class="col-xs-12 text-center no-padding"><span>사료잔량 <span id="extra_feed_remain">-</span>(Kg)</span></div>
					</div>
					<div class="col-xs-3 no-padding text-right">
						<span style="font-size:12px">전체</span>(kg)<br><span id="extra_all_feed" style="font-size:21px">-</span>
					</div>
					<div class="col-xs-3 no-padding text-right">
						<span style="font-size:12px">오늘</span>(kg)<br><span id="extra_curr_feed" style="font-size:21px">-</span>
					</div>
					<div class="col-xs-3 no-padding text-right">
						<span style="font-size:12px">전일</span>(kg)<br><span id="extra_prev_feed" style="font-size:21px">-</span>
					</div>
				</div>

				<div style="clear:both"></div><hr style="margin-top:10px; margin-bottom: 10px">

				<div  class="col-xs-12 d-flex align-items-center justify-content-between no-padding">
					<div class="col-xs-3 no-padding text-center">
						<img src="../images/water-02.png" style="width: 5rem;"><br><span></span>
					<div class="col-xs-12 text-center no-padding"><span>시간당 급수량 <span id="extra_water_per_hour">-</span>(L)</span></div>
					</div>
					<div class="col-xs-3 no-padding text-right">
						<span style="font-size:12px">전체</span>(L)<br><span id="extra_all_water" style="font-size:21px">-</span>
					</div>
					<div class="col-xs-3 no-padding text-right">
						<span style="font-size:12px">오늘</span>(L)<br><span id="extra_curr_water" style="font-size:21px">-</span>
					</div>
					<div class="col-xs-3 no-padding text-right">
						<span style="font-size:12px">전일</span>(L)<br><span id="extra_prev_water" style="font-size:21px">-</span>
					</div>
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
					<h2 class="font-weight-bold text-white"><i class="fa fa-bar-chart-o"></i>&nbsp;오늘 급이량 변화</h2>	
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
					<h2 class="font-weight-bold text-white"><i class="fa fa-bar-chart-o"></i>&nbsp;일령별 급이량 변화</h2>	
				</div>
				<div class="widget-toolbar ml-auto">
					<button type="button" class="btn btn-xs btn-default" style="height: 25px" onClick="send_excel_data('일령별급이량')"><span class="fa fa-file-excel-o"></span>&nbsp;Excel</button>
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
					<h2 class="font-weight-bold text-white"><i class="fa fa-bar-chart-o"></i>&nbsp;오늘 급수량 변화</h2>	
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
					<h2 class="font-weight-bold text-white"><i class="fa fa-bar-chart-o"></i>&nbsp;일령별 급수량 변화</h2>	
				</div>
				<div class="widget-toolbar ml-auto">
					<button type="button" class="btn btn-xs btn-default" style="height: 25px" onClick="send_excel_data('일령별급수량')"><span class="fa fa-file-excel-o"></span>&nbsp;Excel</button>
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

	var sensor_chart_data = null;

	function get_dong_data(){
		get_buffer();
		get_all();
		get_today();
		get_feed_per_count();
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

				sensor_chart_data = data;

				let params = {};
				params["graph_color"] = ["#FF9900","#2FB5F0","#109618","#990099"];
				params["font_size"] = 12;
				params["is_zoom"] = true;
				params["period"] = "DD";
				params["date_format"] = "YYYY-MM-DD";
				//draw_bar_line_chart("daily_feed_chart", data.chart_feed, "Y", "N", 12, "DD");
				//draw_bar_line_chart("daily_water_chart", data.chart_water, "Y", "N", 12, "DD", "#2FB5F0");
				draw_chart("daily_feed_chart", data.chart_feed_daily, params);
				params["graph_color"] = ["#2FB5F0","#FF9900","#109618","#990099"];
				draw_chart("daily_water_chart", data.chart_water_daily, params);
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
				draw_bar_line_chart("today_feed_chart", data.chart_feed, "Y", "N", 12, "hh");
				draw_bar_line_chart("today_water_chart", data.chart_water, "Y", "N", 12, "hh", "#2FB5F0");
			}
		});
	};

	function send_excel_data(title){

		let date_time = get_now_datetime();
		let header = [];
		let json_data = [];

		let target_data = [];

		switch(title){
			case "일령별급이량":
				header = ["날짜", "급이량(kg)"];
				target_data = sensor_chart_data["chart_feed_daily"];
				//json_data = JSON.stringify(sensor_chart_data["chart_feed_daily"]);
				break;

			case "일령별급수량":
				header = ["날짜", "급수량(L)"];
				target_data = sensor_chart_data["chart_water_daily"];
				break;
		}

		for(let idx in target_data){
			let row = target_data[idx];
			let n = 1;
			let data = {};
			for(let key in row){
				data["f" + n] = row[key];
				n++;
			}
			json_data.push(data);
		}

		json_data = JSON.stringify(json_data);

		title = top_name + "_" + top_code + "_" + title;

		window.Android.convert_excel(date_time + "_" + title + ".xls", header, json_data);
	}

	function get_feed_per_count(){
		
		let data_arr = {};
		data_arr["oper"] = "get_feed_per_count";
		data_arr["cmCode"] = top_code;		//등록코드
		
		$.ajax({
			url:'0101_action.php',
			data:data_arr,
			cache:false,
			type:'post',
			dataType:'json',
			success: function(data){

				$("#dong_per_feed").html(data.dong_per_feed + "g");
				$("#dong_per_water").html(data.dong_per_water + "L");
			},
			error: function(request,status,error){
				//alert("STATUS : "+request.status+"\n"+"ERROR : "+error);
			}
		});
	};

</script>