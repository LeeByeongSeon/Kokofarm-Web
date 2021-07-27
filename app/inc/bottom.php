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

</body>
</html>

<script src="../../common/library/vendors/vendors.bundle.js"></script>
<script src="../../common/library/app/app.bundle.js"></script>

<!--BOOTSTRAP Table-->
<script src="../../common/library/bootstrap_table/bootstrap-table.js"></script>

<script>

	var top_code = "";
	var top_avg = "";
	var top_time = "";
	var top_interm = "";
	var top_rc_status = "";
	var top_be_status = "";
	var top_name = "";

	$(document).ready(function(){

		$("#top_select").off("change").on("change", function(){		// off로 이벤트 중복을 방지함
			load_data();
		});
		
		// $(document).click(function(e){
		// 	if(!$(e.target).is('.sa-aside-left > *')){
		// 		alert('제발');
		// 	}
		// });
	});

	// 데이터를 불러옴
	function load_data(){
		let option = $("#top_select option:selected");
		top_code = $(option).val();
		top_avg = $(option).attr("beAvgWeight");
		top_time = $(option).attr("beAvgWeightDate");
		top_interm = $(option).attr("interm");
		top_rc_status = $(option).attr("rcStatus");
		top_be_status = $(option).attr("beStatus");
		top_name = $(option).html();

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
				request_info = "산출 대기 중.. <i class='fa fa-spinner fa-pulse'></i>";
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
				$("#top_last_avg").html(avg + "g");
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

		get_dong_data();		// 각 페이지 별로 선언 필요
	};

</script>