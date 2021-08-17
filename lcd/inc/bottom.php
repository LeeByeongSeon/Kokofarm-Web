							<div class="modal" id="modalPopup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content" style="padding:15px">

										<div class="jarviswidget jarviswidget-color-blueDark" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-togglebutton="false">
											<header>
												<span class="widget-icon"> <i class="fa fa-align-justify"></i> </span>
												<h2 id="modal_title"></h2>
											</header>
											<div class="widget-body">
												<div id="modal_msg" style="width:100%;text-align:center;font-size:20px">

												</div>
											</div><!--widget-body-->
										</div><!--widget-->
										<div style="text-align:right;margin-top:-10px">
											<button type="button" class="btn btn-primary" data-dismiss="modal">닫기</button>
										</div>

									</div><!-- /.modal-content -->
								</div><!-- /.modal-dialog -->
							</div><!-- /.modal -->

							<!----Loading Circle-->
							<div id="loading_circle" style="display:none;"><ul id="loading_circle_image"><img src="../images/loading_circle.gif"></ul></div>
							
							</div><!--container-->
						</section>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>

<script src="../../common/library/vendors/vendors.bundle.js"></script>
<script src="../../common/library/app/app.bundle.js"></script>

<!--BOOTSTRAP Table-->
<script src="../../common/library/bootstrap_table/bootstrap-table.js"></script>

<script language="javascript">

	var progress_interval;
	var progress_cnt = 0;

	var top_code = "<?=$farm_code?>";
	var top_avg = "<?=$farm_avg?>";
	var top_time = "<?=$farm_avg_time?>";
	var top_interm = "<?=$farm_interm?>";
	var top_rc_status = "<?=$request_status?>";
	var top_be_status = "<?=$farm_status?>";
	var top_name = "<?=$farm_name?>";
	var top_lat = "<?=$farm_lat?>";
	var top_lng = "<?=$farm_lng?>";

	$(document).ready(function(){

		load_data();

		progress_interval = setInterval(function(){
			$("#clock_now").html(get_now_datetime());

			progress_cnt++;
			if(progress_cnt >= 60){ 
				progress_cnt = 0; 
				location.reload();		// 새로고침
			}
			else{ 
				let update_per = parseInt(progress_cnt/60*100); 
				$("#state_bar").css('width', update_per + "%"); 
				$("#state_bar").html(update_per + "%"); 
				$("#state_bar").parent().attr("data-original-title", update_per + "%");
			}
		}, 1000);

		get_weather(top_lat, top_lng);

		//일령기간별 이미지
		if(top_interm <= 10){ $(".henImage").attr("src","../images/hen-scale1.png");  $(".henInterm").addClass("p-4");}
		if(top_interm >= 11 && top_interm <= 20){ $(".henImage").attr("src","../images/hen-scale2.png");  $(".henInterm").addClass("p-3");}
		if(top_interm >= 21){ $(".henImage").attr("src","../images/hen-scale3.png"); $(".henInterm").addClass("p-3"); }
	});

	// 데이터를 불러옴
	function load_data(){

		// 재산출 요청 존재 확인
		let request_info = "";
		$("#top_request_row").hide();
		switch(top_rc_status){
			case "R":		//요청
				request_info = "재산출 요청 승인 대기 중 <i class='fa fa-spinner fa-pulse text-white'></i>";
				break;
			case "A":		//승인
				request_info = "재산출 요청 승인 후 산출 대기 <i class='fa fa-spinner fa-pulse text-white'></i>";
				break;
			case "W":		//대기
				request_info = "산출 대기 중... <i class='fa fa-spinner fa-pulse text-white'></i>";
				break;
			case "C":		//산출중
				request_info = "산출 중... <i class='fa fa-spinner fa-pulse text-white'></i>";
				break;
		}

		$("#top_request_info").html(request_info);
		if(request_info != ""){
			$("#top_request_row").show();
		}

		let notice = "<span class='font-lg text-secondary'> ※해당 상태가 지속되면 관리자에게 문의 바랍니다.&nbsp;&nbsp;</span>";

		switch(top_be_status){
			case "O": //출하
				
				//$("#top_status_info").removeClass('d-none');	// d-none -> display: none 과 동일, 해당 클래스를 지워야함
				$("#top_status_msg").html("<h1 class='font-weight-bold text-center text-secondary no-margin'>현재 <span class='text-danger' style='font-size:28px'> '출하 상태' </span>입니다</h1>").show();
				$("#top_time_info").html("<i class='fa fa-clock-o text-secondary'></i> 최종 출하 시간 : ");
				$("#top_last_time").html(top_time);
				$("#top_avg_info").html("<i class='fa fa-database text-secondary'></i> 최종 평균 중량 : ");
				$("#top_last_avg").html(top_avg + "g");
				$("#top_notice").html(notice);
				break;
			
			case "E": //에러

				$("#top_status_msg").html("<h1 class='font-weight-bold text-center text-secondary no-margin'>현재 <span class='text-danger' style='font-size:28px'> '통신 오류 상태' </span> 입니다</h1>").show();
				$("#top_time_info").html("<i class='fa fa-clock-o text-secondary'></i> 오류 발생 시간 : ");
				$("#top_last_time").html(top_time);
				$("#top_avg_info").html("<i class='fa fa-database text-secondary'></i> 최종 평균 중량 : ");
				$("#top_last_avg").html(top_avg + "g");
				$("#top_notice").html(notice);
				break;

			case "W": //출하 대기
				
				$("#top_status_msg").html("<h1 class='font-weight-bold text-center text-secondary no-margin'> 현재 <span class='text-danger' style='font-size:28px'> '출하 대기 상태' </span> 입니다</h1>").show();
				$("#top_time_info").html("<i class='fa fa-clock-o text-secondary'></i> 저울 분리 시간 : ");
				$("#top_last_time").html(top_time);
				$("#top_avg_info").html("<i class='fa fa-database text-secondary'></i> 최종 평균 중량 : ");
				$("#top_last_avg").html(top_avg + "g");
				$("#top_notice").html(notice);
				break;
		}

		$("#top_status_info").show();

		get_data();		// 각 페이지 별로 선언 필요
	};

	// gps 날씨 데이터 가져오기
	function get_weather(lat, lon){	// lat, lon 으로 구글 날씨 api
		if(lat != "" && lon != ""){	// null 체크
			let weather_api_key = "eebc730442c4127c56dfa7c7a4dca2ee";
			let url = "http://api.openweathermap.org/data/2.5/weather?lat="+ lat +"&lon="+ lon +"&appid=" + weather_api_key;
			$.ajax({ url: url, dataType:"json",
				success:function(data){
					let temp = parseFloat(data.main.temp - 273.15).toFixed(1);
					let humi = data.main.humidity;
					let win_speed = data.wind.speed;
					let icon = data.weather[0].icon;
					$("#weather_icon").attr("src","https://openweathermap.org/img/w/"+icon+".png");
					$("#weather_temp").html(temp);
					$("#weather_humi").html(humi);
					$("#weather_wind").html(win_speed);
				}
			});
		};
	};

	// 로딩 이미지
	function loading_circle(chk_on_off){
		let this_obj = $(window);
		let obj_top  = 0;
		let obj_left = 0;

		let obj_width  = this_obj.outerWidth();	 // 태블릿pc 화면에서 여백이 생겨 width() -> outerWidth()로 수정 height도 동일
		let obj_height = this_obj.outerHeight();

		$("#loading_circle").css({
			'top':obj_top,'left':obj_left,'width':obj_width,'height':obj_height,'position':'fixed','z-index':'9999','background':'gray', opacity:0.5
		});

		let img_left = (obj_width-350)/2;
		let img_top  = (obj_height-350)/2;

		$("#loading_circle_image").css({
			'margin-left':img_left,'margin-top':img_top
		});

		switch(chk_on_off){
			case "on":
				$("#loading_circle").fadeIn();
				break;
			case "off":
				$("#loading_circle").fadeOut();
				break;
		};
	};

	// window.onload = function(){
		// load_data();
	// };

</script>