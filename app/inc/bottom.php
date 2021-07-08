						</section>
					</div>

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

<script>

	//I:입추 O:출하 E:에러 W:대기(에러) 상태일 때 '출하'표시 & 예측평체 div를 지움
	var select_dong = $(".dropdown-item");

	$(document).ready(function(){
		
		var now_status = select_dong.attr("data-status");	//beStatus 상태 값 가져옴

		switch(now_status){
			case "O": //출하
				$(".alarm").css("display", "block").html("<h3 class='font-weight-bold text-danger text-center'> 현재 '출하 상태' 입니다<br><small>해당 화면이 지속된다면 관리자에게 문의 바랍니다.</small></h3>");
				$(".avg_weight").css("display", "none");
				$(".avg").html("<i class='fa fa-clock-o text-secondary'></i> 출하 된 평균");
				$(".sensor").html("<i class='fa fa-info-circle text-secondary'></i> 출하 된 센서별 평균정보");
				$(".feeder").html("<i class='fa fa-info-circle text-secondary'></i> 출하 된 급이 / 급수량");
				break;
			
			case "E": //에러
				$(".alarm").css("display", "block").html("<h3 class='font-weight-bold text-center text-danger no-margin'>현재 '오류 상태' 입니다.<br><small>해당 화면이 지속된다면 관리자에게 문의 바랍니다.</small></h3>");
				$(".error_alarm").css("display", "block");
				break;

			case "W": //에러
				$(".alarm").css("display", "block").html("<h3 class='font-weight-bold text-center text-danger no-margin'>현재 '오류 상태' 입니다.<br><small>해당 화면이 지속된다면 관리자에게 문의 바랍니다.</small></h3>");
				$(".error_alarm").css("display", "block");
				break;
		}

	});
</script>