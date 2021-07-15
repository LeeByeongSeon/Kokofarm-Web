<?
include_once("../inc/top.php");
?>

<!--알람 메시지--->
<div class="row" id="alarm_form">
	<div class="col-xs-12">
		<div class="alert alert-danger" role="alert" id="alarm_msg" style="text-align:center; margin:0; font-size:18px;">
			message
		</div>
	</div>
</div><!--row--->
	
<div class="row">
	<div class="col-xs-12">
		<div class="jarviswidget jarviswidget-color-white no-padding" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">							
			<header style="border-radius: 10px 10px 0 0">
				<div class="widget-header">	
					<h2 class="font-weight-bold text-primary"><i class="fa fa-pencil-square-o text-warning"></i>&nbsp;&nbsp;재산출 요청</h2>	
				</div>
			</header>
			<div class="widget-body shadow" style="border-radius: 0 0 10px 10px; padding:0.5rem">
				<form id="request_form" onsubmit="return false;">
					<input type="hidden" name="request_origin" 	  value="">
					<input type="hidden" name="request_dong_name" value="<?=$fd_Name?>">
					
					<div class="col-xs-12 text-center no-padding" id="request_alarm"></div>

					<div class="col-xs-12 text-center">
						<h3 class="font-weight-bold text-primary" style="margin:0.5rem">일령변경<br><small><span id="request_in_time">현재 입추 시간 : 0000-00-00 00:00</span></small></h3>
						<div class="input-group mb-3">
							<span class="input-group-text font-weight-bold">입추일자</span>
								<select class="form-control" name="in_date">
									<option value="2021-04-26" selected>2021-04-26</option>
								</select>
						</div>
						<div class="input-group mb-3">
							<span class="input-group-text font-weight-bold">입추시간</span>
								<select class="form-control" name="in_time_hour">
									<option value="11" selected>11시</option>
								</select>
							<span class="input-group-text font-weight-bold">:</span>
								<select class="form-control" name="in_time_minute">
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
								<label class="radio-inline" style="padding-left: 2.5rem; padding-top:0.5rem;">
									<input type="radio" class="form-check-input" name="change_intype" value="육계"><span>&nbsp;육계</span>
								</label>&nbsp;
								<label class="radio-inline" style="padding-left: 2.5rem; padding-top:0.5rem;">
									<input type="radio" class="form-check-input" name="change_intype" value="삼계"><span>&nbsp;삼계</span>
								</label>&nbsp;
								<label class="radio-inline" style="padding-left: 2.5rem; padding-top:0.5rem;">
									<input type="radio" class="form-check-input" name="change_intype" value="토종닭"><span>&nbsp;토종닭</span>
								</label>
						</div>
						<div class="input-group mb-3">
							<span class="input-group-text font-weight-bold" style="width: 73.5px">입추 수</span>
							<input type="text" class="form-control" aria-label="입추 수" name="change_inSU" min="0" max="99999">
						</div>
					</div>
					<div class="col-xs-12 text-center">
						<h3 class="font-weight-bold text-primary" style="margin:0.5rem">평균중량 재산출</h3>
						<div class="input-group mb-3">
							<span class="input-group-text font-weight-bold">실측일자</span>
								<select class="form-control" name="measure_date">
									<option value="2021-04-26" selected>2021-04-26</option>
								</select>
						</div>
						<div class="input-group mb-3">
							<span class="input-group-text font-weight-bold">실측시간</span>
								<select class="form-control" name="measure_time_hour">
									<option value="11" selected>11시</option>
								</select>
							<span class="input-group-text font-weight-bold">:</span>
								<select class="form-control" name="measure_time_minute">
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
							<button type="submit" class="btn btn-primary" id="request_ok">요청</button>
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
	
	var cmCode = select_dong.attr("data-cmCode");	//동ID
	var days = "<?=$inTerm?>";						//일령

	$(document).ready(function(){
		
		$("#alarm_form").hide();
		get_intype(cmCode);

	});

	function get_intype(cmCode) {
		
		if(cmCode != "" && cmCode != null){
		
			var data_arr = {};
				data_arr["oper"] = "get_intype";
				data_arr["cmCode"] = cmCode;
				data_arr["day"] = days;

			$.ajax({
				url:"0105_action.php",
				type:"post",
				data:data_arr,
				dataType:"json",
				cache:false,
				success: function(data){
					var in_su = data.cm_in_su; // 입추 수

					// 기존 (수정 전)데이터 가져옴
					$("#request_form [name=change_intype]").removeAttr("checked");
					$("#request_form [name=change_intype]:input[value=" + data.cm_in_type + "]").prop("checked", true);
					$("#request_form [name=change_inSU]").val(in_su);

					data.cm_in_date = data.cm_in_date.substr(0, 15) + "0:00";
						var in_date = data.cm_in_date.substr(0,10);
						var in_time = data.cm_in_date.substr(11,5);
					
						
					var now = get_now_datetime();

					// 추가사항
					//$("#request_dong_name").html("데이터 변경 요청 (" + data.fdName + ")");
					$("#request_in_time").html("현재 입추시간 : ("+ data.cm_in_date.substr(0, 16) +")");
					$("#request_form [name=in_date]").html(make_date_combo(data.cm_in_date, -3));
					$("#request_form [name=in_time_hour]").html(make_time_combo(data.cm_in_date, data.cm_in_date.substr(11, 2)));
					$("#request_form [name=in_time_minute]").val(data.cm_in_date.substr(14, 1) + "0").attr("selected", true);

					$("#request_form [name=measure_date]").html(make_date_combo(now, -3));
					$("#request_form [name=measure_time_hour]").html(make_time_combo(now, "00"));
					$("#request_form [name=measure_time_minute]").val("00").attr("selected", true);

					// 일자 변경 시 - 오늘일 경우 현재 시간 이전만 선택가능하게
					$("#request_form [name=in_date]").off("change").on("change", function(){
						$("#request_form [name=in_time_hour]").html(make_time_combo(this.value, data.cm_in_date.substr(11, 2)));
					});
					$("#request_form [name=measure_date]").off("change").on("change", function(){
						$("#request_form [name=measure_time_hour]").html(make_time_combo(this.value, "00"));
					});

					// 변경사항 확인을 위한 변수
					$origin = data.cm_in_type + "|" + data.cm_in_date;
					$("#request_form [name=request_origin]").val($origin);
					$("#request_form [name=request_dong_name]").val();

					$("html, body").animate({scrollTop :200}, 0); //재산출에 포커싱함

					
					// 데이터 입력이 
					if(data.msg == ""){
						$("#alarm_msg").html("");
						$("#alarm_form").hide();
					}
					else{
						$("#alarm_msg").html(data.msg);
						$("#alarm_form").show();
					}
				}
			});	

		}
	}

	// 현재 일령에서 iter 만큼 앞까지만 콤보박스로 변경
	function make_date_combo(base, iter){

		var ret = "";

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

	function make_time_combo(sel, def){
		var ret = "";
		var now = get_now_datetime();

		var limit = 24;

		if(sel.substr(0, 10) == now.substr(0, 10)){
			limit = parseInt(now.substr(11, 2));
		}

		// 00시에 데이터 입력 시 하나도 안나오는걸 방지
		if(limit == 0){
			ret = "<option value=\"00\" selected>00시</option>";
		}

		for(var i=0; i<limit; i++){
			var temp = "";
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
	$("#request_form [name=change_inSU]").on("keyup", function() {
		var temp = $(this).val();
			temp = temp.replace(/[^0-9]/g,"");
			temp = temp.length > 5 ? temp.substr(0, 5) : temp;

		$(this).val(temp);
	});

	//실측값을 숫자만 입력
	$("#request_form [name=measure_val]").on("keyup", function() {
		var temp = $(this).val();
			temp = temp.replace(/[^0-9]/g,"");
			temp = temp.length > 4 ? temp.substr(0, 4) : temp;

		$(this).val(temp);
	});
	
	function alarm_clear(){
		$("#request_alarm").css("display", "block");
		$("#request_day_alarm").css("display", "block");
		$("#request_opt_alarm").css("display", "block");

		$("#request_alarm").css("display", "none");
		$("#request_day_alarm").css("display", "none");
		$("#request_opt_alarm").css("display", "none");
	}
	
	function view_alarm(id, msg){
		alarm_clear();
		$("#" + id).html("<label class='text-danger font-weight-bold' style='font-size: 1rem; padding : 20px 0;'>오류 : " + msg);
		$("#" + id).show();

		$("html, body").animate({scrollTop :100}, 0); //페이지를 상단으로 올림
	}

	// 일령변경, 축종변경, 최적화 요청
	$("#request_ok").click(function() {

		var origin 	  = $("#request_form [name=request_origin]").val().split("|");	// 0:cmIntype 1:cmIndate
		var dong_name = $("#request_form [name=request_dong_name]").val();			// 요청 동 이름

		var tr_date   = $("#request_form [name=in_date]").val() + " " + $("#request_form [name=in_time_hour]").val() + ":" + $("#request_form [name=in_time_minute]").val();
		var tr_type   = $("#request_form [name=change_intype]:checked").val();
		var tr_count  = $("#request_form [name=change_inSU]").val();
		var measure_date = $("#request_form [name=measure_date]").val() + " " + $("#request_form [name=measure_time_hour]").val() + ":" + $("#request_form [name=measure_time_minute]").val();
		var measure_val  = $("#request_form [name=measure_val]").val();

		//alert("origin : " + origin + "\ntr_date : " + tr_date + "\ntr_type : " + tr_type  + "\nmeasure_date : " + measure_date + "\nmeasure_val : " + measure_val);

		var rc_comm = "";
		var notice = "";

		var curr_day = get_now_date();			//현재
		var days = $("#summary_interm").html(); //일령
		
		//alert(days);

		// 축종 변경
		if(origin[0] != tr_type){
			notice += "- 축종을 <span style='font-weight:bold;'>\"" + origin[0] + "\"</span>에서 <span style='font-weight:bold;'>\"" + tr_type + "\"</span>으로 변경<br><br>";
			rc_comm += "Lst|";
		}

		// 입추수 변경
		var in_count = $("#summaryInsu").html();
		if(in_count != tr_count){
			notice += "- 입추수를 <span style='font-weight:bold;'>\"" + in_count + "\"</span>에서 <span style='font-weight:bold;'>\"" + tr_count + "\"</span>으로 변경<br><br>";
		}

		// 입추일자 오류처리
		if(origin[1].substr(0, 16) != tr_date){
			var origin_diff = get_date_diff(origin[1], curr_day) + 1;
			var trans_diff  = get_date_diff(tr_date, curr_day) + 1;

			notice += "- 입추일자를 <span style='font-weight:bold;'>\"" + datetime_easy(origin[1]) + " ("+ origin_diff +"일령)\"</span>에서 <br>";
			notice += "<span style='font-weight:bold;'>\"" + datetime_easy(tr_date) + " ("+ trans_diff +"일령)\"</span>으로 변경<br><br>";

			rc_comm += "Day|";
		}

		// 최적화 오류처리
		if(measure_val.length != 0){

			// 20일령 이전 차단
			if(parseInt(days) < 20){
				view_alarm("request_opt_alarm", "평균중량 재산출은 20일령 이후에 진행해주세요</label>");
				return;
			}

			var measure_diff = get_time_diff(measure_date + ":00", get_now_datetime());
			
			if(measure_diff < 1800){
				view_alarm("request_opt_alarm", "실측시간은 현재시간보다 최소 30분 이전으로 입력해주세요</label>");
				return;
			}

			if(parseInt(measure_val) < 400 || parseInt(measure_val) > 2500){
				view_alarm("request_opt_alarm", "실측값은 400 ~ 2500 사이의 값을 입력해주세요</label>");
				return;
			}

			notice += "- 평균중량 재산출을 <span style='font-weight:bold;'>\"" + datetime_easy(measure_date) + "\"</span>에 측정한 <span style='font-weight:bold;'>" + measure_val + "g</span>으로 진행<br><br>";
			rc_comm += "Opt|";
		}

		// 에러 확인 완료 후 적용될 값이 있으면 confirm창 출력
		if(notice.length < 1){
			view_alarm("request_alarm", "수정하여 적용할 값이 존재하지 않습니다</label>");
		}
		else{
			notice = "- " + dong_name + "의 데이터를 변경<br><br>" + notice;

			popup_confirm("아래의 변경사항을 적용하시겠습니까?", notice, 
				function(confirm) {
					alarm_clear();

					if(confirm){
						var data_arr = {};
							data_arr['oper'] = "edit_intype";

							data_arr["rcFarmid"]  = farmID;		//농장 ID
							data_arr["rcDongid"]  = dongID;		//동 ID
							data_arr["rcCode"]    = cmCode;		//입추코드
							data_arr["rcCommand"] = rc_comm.substr(0, rc_comm.length-1);	//변환 명령

							data_arr["rcPrevLst"]   = origin[0];	//변경 전 축종
							data_arr["rcChangeLst"] = tr_type;		//변경 후 축종

							data_arr["rcPrevDate"]   = origin[1];	//변경 전 입추시간
							data_arr["rcChangeDate"] = tr_date + origin[1].substr(origin[1].length - 3, 3);		//변경 후 입추시간

							data_arr["rcMeasureDate"] = measure_date.length > 3 ? measure_date + ":00" : "2000-01-01 00:00:00";		// 실측 시간
							data_arr["rcMeasureVal"]  = measure_date.length > 3 ? measure_val : 0;	// 실측 중량

							data_arr["tr_count"] = tr_count;

						set_cookie("is_opt_com", "yes", 1);

						set_cookie("is_end_request", "no", 2);

						$.ajax({url:'0105_action.php',data:data_arr,cache:false,type:'post',dataType:'json',
							success: function(data) {
								$("#request_form").each(function() {	this.reset();  });
							}
						});
					}
				}
			);
		}
	});
	
</script>