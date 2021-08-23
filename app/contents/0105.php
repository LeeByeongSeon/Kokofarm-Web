<?
include_once("../inc/top.php");

// 생계구분 콤보박스
$type_query = "SELECT cName1 FROM codeinfo WHERE cGroup= \"생계구분\"";
$type_combo = make_combo_by_query($type_query, "change_intype", "", "cName1", "육계");

?>
	
<div class="row" id="row_request_form" style="display:none;">
	<div class="col-xs-12">
		<div class="jarviswidget jarviswidget-color-white no-padding mb-3" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">							
			<header style="border-radius: 10px 10px 0px 0px; border : 4px solid #eee; border-bottom: 0; background-color: #0c6ad0;">
				<div class="widget-header">	
					<h2 class="font-weight-bold text-white"><i class="fa fa-pencil-square-o"></i>&nbsp;재산출 요청</h2>	
				</div>
			</header>
			<div class="widget-body p-1" style="border-radius: 0px 0px 10px 10px; border : 4px solid #eee; border-top: 0; padding:0.5rem">
				<form id="request_form" onsubmit="return false;">
					
					<div class="col-xs-12 text-center no-padding" id="request_alarm"></div>

					<div class="col-xs-12 text-center">
						<h3 class="font-weight-bold text-primary" style="margin:0.5rem">일령변경<br><small><span id="request_intime">현재 입추 시간 : 0000-00-00 00:00</span></small></h3>
						
						<div class="input-group mb-3">
							<span class="input-group-text font-weight-bold">입추일자</span>
							<select class="form-control" name="change_indate">
								<option value="2021-04-26" selected>0000-00-00</option>
							</select>
						</div>

						<div class="input-group mb-3">
							<span class="input-group-text font-weight-bold">입추시간</span>
							<select class="form-control" name="change_hour">
								<option value="00" selected>00시</option>
							</select>

							<span class="input-group-text font-weight-bold">:</span>
							<select class="form-control" name="change_minute">
								<option value="00">00분</option>
								<option value="10">10분</option>
								<option value="20">20분</option>
								<option value="30">30분</option>
								<option value="40">40분</option>
								<option value="50">50분</option>
							</select>
						</div>
					</div>
					
					<div class="col-xs-12 text-center no-padding" id="request_day_alarm"></div>
					
					<div class="col-xs-12 text-center">
						<h3 class="font-weight-bold text-primary" style="margin:0.5rem">사육변경</h3>
						<div class="input-group mb-3">
							<span class="input-group-text font-weight-bold" id="basic-addon1" style="width: 73.5px">축종</span>
							<?=$type_combo?>
							<!-- <span class="input-group-text font-weight-bold" id="basic-addon1" style="width: 73.5px">축종</span>
								<label class="radio-inline" style="padding-left: 2.5rem; padding-top:0.5rem;">
									<input type="radio" class="form-check-input" name="change_intype" value="육계"><span>&nbsp;육계</span>
								</label>&nbsp;
								<label class="radio-inline" style="padding-left: 2.5rem; padding-top:0.5rem;">
									<input type="radio" class="form-check-input" name="change_intype" value="삼계"><span>&nbsp;삼계</span>
								</label>&nbsp;
								<label class="radio-inline" style="padding-left: 2.5rem; padding-top:0.5rem;">
									<input type="radio" class="form-check-input" name="change_intype" value="토종닭"><span>&nbsp;토종닭</span>
								</label> -->
						</div>
						<div class="input-group mb-3">
							<span class="input-group-text font-weight-bold" style="width: 73.5px">입추 수</span>
							<input type="text" class="form-control" aria-label="입추 수" name="change_insu" min="0" max="99999" value="">
						</div>
					</div>

					<div class="col-xs-12 text-center">
						<h3 class="font-weight-bold text-primary" style="margin:0.5rem">평균중량 재산출</h3>

						<div class="input-group mb-3">
							<span class="input-group-text font-weight-bold">실측일자</span>
							<select class="form-control" name="measure_date">
								<option value="2021-04-26" selected>0000-00-00</option>
							</select>
						</div>

						<div class="input-group mb-3">
							<span class="input-group-text font-weight-bold">실측시간</span>
							<select class="form-control" name="measure_hour">
								<option value="00" selected>00시</option>
							</select>

							<span class="input-group-text font-weight-bold">:</span>
							<select class="form-control" name="measure_minute">
								<option value="00">00분</option>
								<option value="10">10분</option>
								<option value="20">20분</option>
								<option value="30">30분</option>
								<option value="40">40분</option>
								<option value="50">50분</option>
							</select>
						</div>
						<div class="input-group mb-3">
							<span class="input-group-text font-weight-bold" style="width: 73.5px">실측값</span>
							<input type="text" class="form-control" name="measure_val" placeholder="실측중량" min="400" max="2500">
						</div>

						<div class="col-xs-12 text-center no-padding" id="request_opt_alarm"></div>

						<div class="col-xs-12 text-left no-padding"><label class="text-danger font-weight-bold no-padding">※ 평균중량 재산출은 20일령 이후에 적용가능합니다.</label></div>
						<div class="col-xs-12 text-left no-padding"><label class="text-danger font-weight-bold no-padding">※ 모든 변경사항은 관리자 승인 후에 적용됩니다.</label></div>
						<div class="col-xs-12 text-right no-padding">
							<button type="button" class="btn btn-primary" id="request_ok">요청</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<?
include_once("../inc/bottom.php")
?>

<script language="javascript">

	var comein_intype = "";
	var comein_indate = "";
	var comein_insu = "";
	
	function get_dong_data(){

		// 입추상태인 경우에만 표시
		if(top_be_status == "O"){
			$("#row_request_form").hide();
		}
		else{
			if(!["R", "A", "W", "C"].includes(top_rc_status)){
				$("#row_request_form").show();
				get_info();
			}
		}
	};

	function get_info(){
		
		let data_arr = {};
		data_arr["oper"] = "get_info";
		data_arr["cmCode"] = top_code;

		$.ajax({
			url:"0105_action.php",
			type:"post",
			data:data_arr,
			dataType:"json",
			cache:false,
			success: function(data){

				comein_intype = data.comein_data["cmIntype"];
				comein_indate = data.comein_data["cmIndate"];
				comein_insu = data.comein_data["cmInsu"];

				// 기존 (수정 전)데이터 가져옴
				$("#request_form [name=change_intype]").val(comein_intype).prop("selected", true);
				$("#request_form [name=change_insu]").val(comein_insu);

				comein_indate = comein_indate.substr(0, 15) + "0:00";
				let in_date = comein_indate.substr(0, 10);
				let in_hour = comein_indate.substr(11, 2);
				let in_minute = comein_indate.substr(14, 2);
					
				let now = get_now_datetime();

				//$("#request_dong_name").html("데이터 변경 요청 (" + data.fdName + ")");
				$("#request_intime").html("현재 입추시간 : ("+ comein_indate +")");
				$("#request_form [name=change_indate]").html(make_date_combo(comein_indate, -3));
				$("#request_form [name=change_hour]").html(make_time_combo(comein_indate, in_hour));
				$("#request_form [name=change_minute]").val(in_minute).prop("selected", true);

				// 일자 변경 시 - 오늘일 경우 현재 시간 이전만 선택가능하게
				$("#request_form [name=change_indate]").off("change").on("change", function(){
					$("#request_form [name=change_hour]").html(make_time_combo(this.value, in_hour));
				});

				if(top_interm >= 20){		// 재산출은 20일령부터 입력
					$("#request_form [name=measure_date]").html(make_date_combo(now, -3));
					$("#request_form [name=measure_hour]").html(make_time_combo(now, "00"));
					$("#request_form [name=measure_minute]").val("00").prop("selected", true);

					$("#request_form [name=measure_date]").off("change").on("change", function(){
						$("#request_form [name=measure_hour]").html(make_time_combo(this.value, "00"));
					});
				}
				else{
					$("#request_form [name=measure_date]").prop("disabled", true);
					$("#request_form [name=measure_hour]").prop("disabled", true);
					$("#request_form [name=measure_minute]").prop("disabled", true);
					$("#request_form [name=measure_val]").prop("disabled", true);
				}
			}
		});
	}

	// 현재 일령에서 iter 만큼 앞까지만 콤보박스로 변경
	function make_date_combo(base, iter){

		let ret = "";

		for(var i= iter; i <= -1 * iter; i++){
			var date = get_gap_time(base, i * 1000 * 60 * 60 * 24).substr(0, 10);

			if(get_date_diff(get_now_date(), date) > 0){
				break;
			}

			if(date == base.substr(0, 10)){
				ret += "<option value=\"" + date + "\" selected>" + date + "</option>";
			}
			else{
				ret += "<option value=\"" + date + "\">" + date + "</option>";
			}
		}  

		return ret;
	};

	function make_time_combo(selected, def){
		let ret = "";
		let now = get_now_datetime();

		let limit = 24;

		if(selected.substr(0, 10) == now.substr(0, 10)){
			let minute = now.substr(14, 2);
			limit = parseInt(now.substr(11, 2));
			limit = minute >= 30 ? limit : limit - 1;		// 현재가 30분이 지났으면
		}

		// 00시에 데이터 입력 시 하나도 안나오는걸 방지
		if(limit < 0){
			ret = "<option value=\"--\" selected>--</option>";
		}

		for(let i=0; i<limit; i++){
			let temp = "";
			if(i < 10){
				temp += "0";
			}

			temp += i;

			if(temp == def){
				ret += "<option value=\"" + temp + "\" selected>" + temp + "시</option>";
			}
			else{
				ret += "<option value=\"" + temp + "\">" + temp + "시</option>";
			}
		}

		return ret;
	};
	
	//입추수량을 숫자만 입력
	$("#request_form [name=change_insu]").on("keyup", function() {
		let temp = $(this).val();
		temp = temp.replace(/[^0-9]/g,"");
		temp = temp.length > 5 ? temp.substr(0, 5) : temp;

		$(this).val(temp);
	});

	//실측값을 숫자만 입력
	$("#request_form [name=measure_val]").on("keyup", function() {
		let temp = $(this).val();
		temp = temp.replace(/[^0-9]/g,"");
		temp = temp.length > 4 ? temp.substr(0, 4) : temp;

		$(this).val(temp);
	});
	
	function alarm_clear(){
		$("#request_alarm").html();
		$("#request_day_alarm").html();
		$("#request_opt_alarm").html();

		$("#request_alarm").hide();
		$("#request_day_alarm").hide();
		$("#request_opt_alarm").hide();
	}
	
	function view_alarm(id, msg){
		alarm_clear();
		$("#" + id).html("<label class='text-danger font-weight-bold' style='font-size: 1rem; padding : 20px 0;'>오류 : " + msg);
		$("#" + id).show();

		//$("html, body").animate({scrollTop :100}, 0); //페이지를 상단으로 올림
	}

	// 일령변경, 축종변경, 최적화 요청
	$("#request_ok").click(function() {

		let change_date   = $("#request_form [name=change_indate]").val() + " " + $("#request_form [name=change_hour]").val() + ":" + $("#request_form [name=change_minute]").val() + ":00";
		let change_type   = $("#request_form [name=change_intype]").val();
		let change_insu  = $("#request_form [name=change_insu]").val();
		let measure_date = $("#request_form [name=measure_date]").val() + " " + $("#request_form [name=measure_hour]").val() + ":" + $("#request_form [name=measure_minute]").val()  + ":00";
		let measure_val  = $("#request_form [name=measure_val]").val();

		// alert("origin : " + origin + "\ntr_date : " + tr_date + "\ntr_type : " + tr_type  + "\nmeasure_date : " + measure_date + "\nmeasure_val : " + measure_val);

		let rc_comm = "";
		let msg = "";

		let curr_day = get_now_date();			//현재

		// 축종 변경
		if(comein_intype != change_type){
			msg += "- 축종을 <span style='font-weight:bold;'>\"" + comein_intype + "\"</span>에서 <span style='font-weight:bold;'>\"" + change_type + "\"</span>으로 변경<br><br>";
			rc_comm += "Lst|";
		}

		// 입추수 변경
		if(comein_insu != change_insu){
			msg += "- 입추수를 <span style='font-weight:bold;'>\"" + comein_insu + "\"</span>에서 <span style='font-weight:bold;'>\"" + change_insu + "\"</span>으로 변경<br><br>";
		}

		// 입추일자 오류처리
		if(comein_indate != change_date){
			let origin_day = get_date_diff(comein_indate, curr_day) + 1;
			let change_day  = get_date_diff(change_date, curr_day) + 1;

			msg += "- 입추일자를 <span style='font-weight:bold;'>\"" + get_korea_date(comein_indate) + " ("+ origin_day +"일령)\"</span>에서 <br>";
			msg += "<span style='font-weight:bold;'>\"" + get_korea_date(change_date) + " ("+ change_day +"일령)\"</span>으로 변경<br><br>";

			rc_comm += "Day|";
		}

		// 최적화 오류처리
		if(measure_val.length != 0){

			if(parseInt(measure_val) < 400 || parseInt(measure_val) > 2500){
				view_alarm("request_opt_alarm", "실측값은 400 ~ 2500 사이의 값을 입력해주세요</label>");
				return;
			}

			msg += "- 평균중량 재산출을 <span style='font-weight:bold;'>\"" + get_korea_date(measure_date) + "\"</span>에 측정한 <span style='font-weight:bold;'>" + measure_val + "g</span>으로 진행<br><br>";
			rc_comm += "Opt|";
		}

		// 에러 확인 완료 후 적용될 값이 있으면 confirm창 출력
		if(msg.length < 1){
			view_alarm("request_alarm", "수정하여 적용할 값이 존재하지 않습니다</label>");
			return;
		}
		else{
			msg = "- " + top_name + "의 데이터를 변경<br><br>" + msg;

			popup_confirm("아래의 변경사항을 적용하시겠습니까?", msg, function(confirm) {
					
					alarm_clear();

					if(confirm){
						let data_arr = {};
						data_arr["oper"] = "request";
						
						data_arr["cmCode"]    = top_code;			//입추코드
						data_arr["rcCommand"] = rc_comm.length > 2 ? rc_comm.substr(0, rc_comm.length-1) : "";	//변경 명령이 존재하지 않으면 입추수만 변경으로 판단

						data_arr["rcPrevLst"]   = comein_intype;	//변경 전 축종
						data_arr["rcChangeLst"] = change_type;		//변경 후 축종

						data_arr["rcPrevDate"]   = comein_indate;	//변경 전 입추시간
						data_arr["rcChangeDate"] = change_date;		//변경 후 입추시간

						data_arr["rcMeasureDate"] = measure_date.length > 3 ? measure_date : "";		// 실측 시간
						data_arr["rcMeasureVal"]  = measure_date.length > 3 ? measure_val : "";	// 실측 중량

						data_arr["change_insu"] = change_insu;

						set_cookie("is_opt_com", "yes", 1);

						set_cookie("is_end_request", "no", 2);

						$.ajax({url:'0105_action.php', data:data_arr, cache:false, type:'post', dataType:'json',
							success: function(data) {
								//$("#request_form").each(function() {	this.reset();  });
								//$("#change_insu").val(data.change_insu);	//입추수만 변경

								if(data.ok){
									$("#btn_home").click();
								}
							}
						});
					}
				}
			);
		}
	});
	
	
</script>