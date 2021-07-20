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

	$(document).ready(function(){

		$("#top_select").off("change").on("change", function(){		// off로 이벤트 중복을 방지함
			load_data();
		});

	});

	// 데이터를 불러옴
	function load_data(){
		let option = $("#top_select option:selected");
		let code = $(option).val();
		let avg = $(option).attr("beAvgWeight");
		let time = $(option).attr("beAvgWeightDate");
		let interm = $(option).attr("interm");
		let rcStatus = $(option).attr("rcStatus");
		let beStatus = $(option).attr("beStatus");

		$("#top_interm").html(interm);
		$("#top_avg").html(avg);

		// 재산출 요청 존재 확인
		let request_info = "";
		$("#top_request_info").hide();
		switch(rcStatus){
			case "R":		//요청
				request_info = "요청 승인 대기 중";
				break;
			case "A":		//승인
				request_info = "요청 승인 후 산출 대기";
				break;
			case "W":		//대기
				request_info = "산출 대기 중..";
				break;
			case "C":		//산출중
				request_info = "산출 중...";
				break;
		}

		if(request_info != ""){
			$("#top_request_info").html(request_info);
			$("#top_request_info").show();
		}

		// 출하 상태 확인
		$("#top_status_info").hide();
		switch(beStatus){
			case "O": //출하
				$("#top_status_msg").html("<h3 class='font-weight-bold text-danger text-center'> 현재 '출하 상태' 입니다<br><small>해당 화면이 지속된다면 관리자에게 문의 바랍니다.</small></h3>").show();
				$("#top_last_avg").html("<i class='fa fa-database text-secondary'></i> 최종 평균 중량 : " + avg + "g");
				$("#top_last_time").html("<i class='fa fa-clock-o text-secondary'></i> 출하시간 : " + time);
				$("#top_status_info").show();
				break;
			
			case "E": //에러
				$("#top_status_msg").html("<h3 class='font-weight-bold text-center text-danger no-margin'>현재 '통신 오류 상태' 입니다.<br><small>해당 화면이 지속된다면 관리자에게 문의 바랍니다.</small></h3>").show();
				$("#top_last_avg").html("<i class='fa fa-database text-secondary'></i> 최종 평균 중량 : " + avg + "g");
				$("#top_last_time").html("<i class='fa fa-clock-o text-secondary'></i> 오류 발생 시간 : " + time);
				$("#top_status_info").show();
				break;

			case "W": //출하 대기
				$("#top_status_msg").html("<h3 class='font-weight-bold text-center text-danger no-margin'>현재 '출하 대기 상태' 입니다.<br><small>해당 화면이 지속된다면 관리자에게 문의 바랍니다.</small></h3>").show();
				$("#top_last_avg").html("<i class='fa fa-database text-secondary'></i> 최종 평균 중량 : " + avg + "g");
				$("#top_last_time").html("<i class='fa fa-clock-o text-secondary'></i> 저울 분리 시간 : " + time);
				$("#top_status_info").show();
				break;
		}
		

		get_dong_data(code);
	};

</script>