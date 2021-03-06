						</section>
					</div>

				</div>

			</div>
		</div>
	</div>
	
	<!--Modal Alert-->
	<div id="modal_alert" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="top:20%">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 id="modal_alert_title" class="modal-title float-right">Modal title</h4>
					<button type="button" class="close float-left" data-dismiss="modal" aria-hidden="true">×</button>
				</div>
				<div id="modal_alert_body" class="modal-body">
					<p>One fine body…</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" data-dismiss="modal">닫기</button>
				</div>
			</div><!--modal-content -->
		</div><!--modal-dialog -->
	</div><!--modal -->

	<!--Modal Confirm-->
	<div id="modal_confirm" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="top:20%">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 id="modal_confirm_title" class="modal-title float-right">Modal title</h4>
                    <button type="button" class="close float-left" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div id="modal_confirm_body" class="modal-body">
                    <p>One fine body…</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal" id="modal_confirm_ok">확인</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" id="modal_confirm_cancle">취소</button>
                </div>
            </div><!--modal-content -->
        </div><!--modal-dialog -->
    </div><!--modal -->

	<!--Modal Camera-->
	<div id="modal_camera" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="top:20%">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 id="modal_camera_title" class="modal-title float-right">Modal title</h4>
                    <button type="button" class="close float-left" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div id="modal_camera_body" class="modal-body">
					<img class="img-responsive" id="modal_camera_img" src="../images/noimage.jpg" style="opacity: 1.0; filter: alpha(opacity=100); margin:auto">
                </div>
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-primary" id="modal_camera_plus" onClick="zoom('+')">확대</button>
					<button type="button" class="btn btn-primary" id="modal_camera_minus" onClick="zoom('-')">축소</button> -->
                    <button type="button" class="btn btn-danger" data-dismiss="modal" id="modal_camera_cancle" onClick="camera_modal_close()">닫기</button>
                </div>
            </div><!--modal-content -->
        </div><!--modal-dialog -->
    </div><!--modal -->

	<!--Modal breed 사육일지 모달-->
	<div id="modal_breed" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="top:20%">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 id="modal_breed_title" class="modal-title float-left font-weight-bold text-primary">사육일지 작성</h4>
					<button type="button" class="close float-right" data-dismiss="modal" aria-hidden="true">×</button>
				</div>
				<div id="modal_breed_body" class="modal-body">
					<form id="breed_form" onsubmit="return false;">
						<div class="col-xs-12 text-left">
							<div class="input-group mb-3">
								<h5 class="font-weight-bold text-secondary" style="margin:0.5rem">기준일자</h5>
								&nbsp;&nbsp;&nbsp;&nbsp;
								<select class="form-control w-25" name="breed_input_date">
									<option value="2021-04-26" selected>0000-00-00</option>
								</select>
								&nbsp;&nbsp;
								<h5 class="font-weight-bold text-secondary" style="margin:0.5rem">축종 </h5>
								&nbsp;&nbsp;
								<h5 class="font-weight-bold text-danger" id="modal_breed_type" style="margin:0.5rem">산란계 종계 </h5>
							</div>

							<hr>

							<div class="input-group mb-3">
								<!-- <span class="input-group-text font-weight-bold" style="width: 74.5px">입추</span>
								<input type="number" pattern="\d*" class="form-control" name="breed_comein_count" placeholder="입추 수" min="" max=""> -->
								<div class="col-xs-12 d-flex no-padding">
									<span class="input-group-text font-weight-bold" style="width: 200px">입추 전 사료 투입량 (Kg)</span>
									<input type="number" value="0" pattern="\d*" class="form-control" name="breed_already_feed" placeholder="입추 전 사료 투입량" min="" max="">
								</div>

							</div>

							<hr>

							<div class="input-group mb-3">
								<!-- <span class="input-group-text font-weight-bold" style="width: 74.5px">입추</span>
								<input type="number" pattern="\d*" class="form-control" name="breed_comein_count" placeholder="입추 수" min="" max=""> -->
								<div class="col-xs-6 d-flex no-padding">
									<span class="input-group-text font-weight-bold" style="width: 140px">입추</span>
									<input type="number" value="0" pattern="\d*" class="form-control" name="breed_comein_count" placeholder="입추 수" min="" max="">
								</div>
								<div class="col-xs-6 d-flex no-padding">
									<span class="input-group-text font-weight-bold" style="width: 140px">덤 수</span>
									<input inputmode="numeric" value="0" pattern="\d*" class="form-control" name="breed_extra_count" placeholder="덤 수" min="" max="">
								</div>

							</div>
							<div class="input-group mb-3">
								<div class="col-xs-6 d-flex no-padding">
									<span class="input-group-text font-weight-bold" style="width: 140px">폐사</span>
									<input inputmode="numeric" value="0" pattern="\d*" class="form-control" name="breed_death_input" placeholder="폐사 수" min="" max="">
								</div>
								<div class="col-xs-6 d-flex no-padding">
									<span class="input-group-text font-weight-bold" style="width: 200px">오늘 폐사 수</span>
									<input type="number" pattern="\d*" class="form-control" name="breed_death_count" placeholder="오늘 폐사 수" disabled style="opacity: 0.5">
								</div>
								<!-- <div class="col-xs-6 d-flex p-2 align-items-center">
									<span class="font-weight-bold" style="width: 150px;">오늘 폐사 수 : </span><span class="font-weight-bold text-danger">0</span>
								</div> -->
							</div>
							<div class="input-group mb-3">
								<div class="col-xs-6 d-flex no-padding">
									<span class="input-group-text font-weight-bold" style="width: 140px">도태</span>
									<input inputmode="numeric" value="0" pattern="\d*" class="form-control" name="breed_cull_input" placeholder="도태 수" min="" max="">
								</div>
								<div class="col-xs-6 d-flex no-padding">
									<span class="input-group-text font-weight-bold" style="width: 200px">오늘 도태 수</span>
									<input type="number" pattern="\d*" class="form-control" name="breed_cull_count" placeholder="오늘 도태 수" disabled style="opacity: 0.5">
								</div>
							</div>
							<div class="input-group mb-3">
								<div class="col-xs-6 d-flex no-padding">
									<span class="input-group-text font-weight-bold" style="width: 140px">솎기</span>
									<input inputmode="numeric" value="0" pattern="\d*" class="form-control" name="breed_thinout_input" placeholder="솎기 수" min="" max="">
								</div>
								<div class="col-xs-6 d-flex no-padding">
									<span class="input-group-text font-weight-bold" style="width: 200px">오늘 솎기 수</span>
									<input type="number" pattern="\d*" class="form-control" name="breed_thinout_count" placeholder="오늘 솎기 수" disabled style="opacity: 0.5">
								</div>
							</div>

							<div class="col-xs-12 text-center no-padding" id="breed_opt_alarm"></div>
						</div>
					</form>

					<div class="col-xs-12 text-left no-padding"><label class="text-danger font-weight-bold no-padding">※ 입추수는 최초 입추 기준 (덤 포함)</label></div>
					<div class="col-xs-12 text-left no-padding"><label class="text-danger font-weight-bold no-padding">※ 폐사, 도태, 솎기 수는 해당 일자에 발생된 것만 기록</label></div>
					<div class="col-xs-12 text-left no-padding"><label class="text-danger font-weight-bold no-padding">※ 초과 입력 시 음수를 입력하여 조정</label></div>
					
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" data-dismiss="modal" id="modal_breed_ok">적용</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal" id="modal_breed_cancle">취소</button>
				</div>
			</div><!--modal-content -->
		</div><!--modal-dialog -->
	</div><!--modal -->

	<a id="scroll_top_btn" href="#" class="btn btn-lg btn-circle bg-orange text-white" role="button" style="cursor: pointer; position: fixed; bottom: 3%; right: 3%; display:none; z-index:999; opacity:0.9"><span class="fa fa-arrow-up font-md pt-3"></span></a>
	
</body>
</html>

<script src="../common/library/vendors/vendors.bundle.js"></script>
<script src="../common/library/app/app.bundle.js"></script>

<!--BOOTSTRAP Table-->
<script src="../common/library/bootstrap_table/bootstrap-table.js"></script>

<script>

	var top_code = "";
	var top_avg = "";
	var top_time = "";
	var top_interm = "";
	var top_rc_status = "";
	var top_be_status = "";
	var top_name = "";

	var curr_item;
	var prev_item;

	$(document).ready(function(){
		
		// TOP버튼
		$(window).scroll(function(){
			if($(this).scrollTop() > 50) {
				// $('#scroll_top_btn').fadeIn().hide(3000, 'linear');
				$('#scroll_top_btn').show().delay(2000).fadeOut();
			}
			else {
				$('#scroll_top_btn').fadeOut();
			}
		});
		$('#scroll_top_btn').click(function(){
			$('#scroll_top_btn').hide();
			$('body,html').animate({scrollTop: 0}, 800);
			return false;
		});
		//$('#scroll_top_btn').show();

		$("#top_select li").off("click").on("click", function(){		// off로 이벤트 중복을 방지함

			prev_item = curr_item;
			curr_item = this;

			if((prev_item != null) && (prev_item != curr_item)){
				$(prev_item).removeClass("active");
			}

			$(curr_item).addClass("active");
			load_data();
		});

		// 상세메뉴 열렸을때 상세메뉴 제외 영역 클릭 시 닫힘
		$('.sa-page-body').children().not('.sa-aside-left').on("mouseover", function(e){
			if($('body').hasClass('sa-hidden-menu')){
				$('body').removeClass('sa-hidden-menu');
			}
		});
		$(window).on("scroll", function(){ 
			if($('body').hasClass('sa-hidden-menu')){
				$('body').removeClass('sa-hidden-menu');
			}
		});

		// 처음 시작 시 강제 클릭
		if(!!"<?=$request_dong?>"){
			$("#top_select li").eq("<?=$request_dong?>" - 1).click();
		}

		if(curr_item == null){
			$("#top_select li").first().click();
		}

	});

	// 데이터를 불러옴
	function load_data(){
		// let option = $("#top_select option:selected");
		// top_code = $(option).val();
		// top_avg = $(option).attr("beAvgWeight");
		// top_time = $(option).attr("beAvgWeightDate");
		// top_interm = $(option).attr("interm");
		// top_rc_status = $(option).attr("rcStatus");
		// top_be_status = $(option).attr("beStatus");
		// top_name = $(option).html();

		let option 	  = $(curr_item).children("a");
		top_code 	  = option.attr("data-code");
		top_avg 	  = option.attr("data-beavgweight");
		top_time 	  = option.attr("data-beavgweightdate");
		top_interm 	  = option.attr("data-interm");
		top_rc_status = option.attr("data-rcstatus");
		top_be_status = option.attr("data-bestatus");
		top_name 	  = option.attr("data-name");

		// $("#btn_home").html(top_name);

		//alert(top_code+" / "+top_avg+" / "+top_time+" / "+top_interm+" / "+top_rc_status+" / "+top_be_status+" / "+top_name);
		
		$("#top_interm").html(top_interm);
		$("#top_avg").html(top_avg);

		// 재산출 요청 존재 확인
		let request_info = "";
		$("#top_request_row").hide();
		switch(top_rc_status){
			case "R":		//요청
				request_info = "재산출 요청 승인 대기 중 <i class='fa fa-spinner fa-pulse'></i>";
				break;
			case "A":		//승인
				request_info = "재산출 요청 승인 후 산출 대기 <i class='fa fa-spinner fa-pulse'></i>";
				break;
			case "W":		//대기
				request_info = "산출 대기 중... <i class='fa fa-spinner fa-pulse'></i>";
				break;
			case "C":		//산출중
				request_info = "산출 중... <i class='fa fa-spinner fa-pulse'></i>";
				break;
		}

		if(request_info != ""){
			$("#top_request_info").html(request_info);
			$("#top_request_row").show();
		}

		// 출하 상태 확인
		//$("#top_status_info").hide();

		let notice = "<span class='font-xs text-secondary'> ※해당 상태가 지속되면 관리자에게 문의 바랍니다.</span>";

		$("#top_status_info").addClass('d-none');

		if("<?=$depth_1_url?>" != "0000.php"){

			switch(top_be_status){
			case "O": //출하
				
				$("#top_status_info").removeClass('d-none');
				$("#top_status_msg").html("<h3 class='font-weight-bold text-center text-secondary no-margin'>현재 <span class='text-danger'>'출하 상태'</span>입니다</h3>").show();
				$("#top_time_info").html("<i class='fa fa-clock-o text-secondary'></i> 최종 출하 시간 : ");
				$("#top_last_time").html(top_time);
				$("#top_avg_info").html("<i class='fa fa-database text-secondary'></i> 최종 평균 중량 : ");
				$("#top_last_avg").html(top_avg + "g");
				$("#top_notice").html(notice);
				break;
			
			case "E": //에러

				$("#top_status_info").removeClass('d-none');
				$("#top_status_msg").html("<h3 class='font-weight-bold text-center text-secondary no-margin'>현재 <span class='text-danger'>'통신 오류 상태'</span> 입니다</h3>").show();
				$("#top_time_info").html("<i class='fa fa-clock-o text-secondary'></i> 오류 발생 시간 : ");
				$("#top_last_time").html(top_time);
				$("#top_avg_info").html("<i class='fa fa-database text-secondary'></i> 최종 평균 중량 : ");
				$("#top_last_avg").html(top_avg + "g");
				$("#top_notice").html(notice);
				break;

			case "W": //출하 대기
				$("#top_status_info").removeClass('d-none');
				$("#top_status_msg").html("<h3 class='font-weight-bold text-center text-secondary no-margin'> 현재 <span class='text-danger'>'출하 대기 상태'</span> 입니다</h3>").show();
				$("#top_time_info").html("<i class='fa fa-clock-o text-secondary'></i> 저울 분리 시간 : ");
				$("#top_last_time").html(top_time);
				$("#top_avg_info").html("<i class='fa fa-database text-secondary'></i> 최종 평균 중량 : ");
				$("#top_last_avg").html(top_avg + "g");
				$("#top_notice").html(notice);
				break;
			}
		}

		get_dong_data();		// 각 페이지 별로 선언 필요
	};

</script>