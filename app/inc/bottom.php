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
	// 농장 각 동의 'data-'를 가져옴 수정될수도
	var select_dong = $(".dropdown-item");

	$(document).ready(function(){
		
		//I:입추 O:출하 E:에러 W:대기(에러) 상태일 때 '출하'표시 & 예측평체 div를 지움
		var now_status = $("input[name=now_status]").val();	//beStatus 상태 값 가져옴

		switch(now_status){
			case "O": //출하
				$(".alarm").css("display", "block").html("<h3 class='font-weight-bold text-danger text-center'> 현재 '출하 상태' 입니다<br><small>해당 화면이 지속된다면 관리자에게 문의 바랍니다.</small></h3>");
				$(".avg_weight").css("display", "none");
				$(".avg").html("<i class='fa fa-clock-o text-secondary'></i> 출하 된 평균");
				$(".sensor").html("<i class='fa fa-info-circle text-secondary'></i> 출하 된 센서별 평균정보");
				$(".feeder").html("<i class='fa fa-info-circle text-secondary'></i> 출하 된 급이 / 급수량");
				break;
			
			case "E": //에러
				$(".alarm").css("display", "block").html("<h3 class='font-weight-bold text-center text-danger no-margin'>현재 '통신 오류 상태' 입니다.<br><small>해당 화면이 지속된다면 관리자에게 문의 바랍니다.</small></h3>");
				$(".error_alarm").css("display", "block");
				break;

			case "W": //에러
				$(".alarm").css("display", "block").html("<h3 class='font-weight-bold text-center text-danger no-margin'>현재 '통신 오류 상태' 입니다.<br><small>해당 화면이 지속된다면 관리자에게 문의 바랍니다.</small></h3>");
				$(".error_alarm").css("display", "block");
				break;
		}

		
		// 데이터 입력이 
		if(data.msg == ""){
			$("#alarm_msg").html("");
			$("#alarm_form").hide();
		}
		else{
			$("#alarm_msg").html(data.msg);
			$("#alarm_form").show();
		}

	});
</script>