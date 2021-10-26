<?
include_once("../inc/top.php");

// 축종선택 콤보박스
$query = "SELECT cName1 FROM codeinfo WHERE cGroup = \"생계구분\"";
$type_combo = make_combo_by_query($query, "request_type", "", "cName1");

$init_farm = isset($_REQUEST["farmID"]) ? $_REQUEST["farmID"] : "";
$init_dong = isset($_REQUEST["dongID"]) ? $_REQUEST["dongID"] : "";

$init_id = $init_farm != "" ? $init_farm . "|" . $init_dong : ""; 

?>

<style>
#cameraIcon {
	position:absolute;
	max-width:100%; max-height:100%;
	width:auto; height:auto;
	margin:auto;
	top:0; bottom:0; left:15px; right:0;
	cursor:pointer;
}
</style>

<!--농장정보 & 이슈사항-->
<article class="col-xl-10 float-right">
	<div class="row">
		<div class="col-xl-6">
			<div class="jarviswidget jarviswidget-color-darken" id="wid-id-1" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
				<header>
					<div class="widget-header">	
						<h2><i class="fa fa-info-circle"></i>&nbsp;요약정보</h2>	
					</div>
				</header>

				<div class="widget-body d-flex justify-content-between pt-1" style="height: 294.97px">

					<div class="well col-xl-6 no-padding" style="margin-top:2%">
						<div class="col-xl-12 text-center text-secondary mb-4">
							<h2 class="font-weight-bold p-2 no-margin"><span id="summary_name">망성농장-01동 (KF0013-01) </span></h2>
						</div>

						<div class="col-xl-12 d-flex justify-content-between align-items-center no-padding mb-3">
							<div class="col-xl-4 no-padding text-center">
								<img class="img-reponsive" id="hen_img" src="../images/hen-scale1.png" alt="닭 이미지">
								<div class="carousel-caption" style="text-shadow: none;"><h2 class="p-3 no-margin font-weight-bold"> <span id="summary_days"></span>일</h2></div>
							</div>
							<div class="col-xl-8 no-padding d-flex justify-content-between">
								<div class="col-xl-6 text-center font-weight-bold pt-3">
									<span class="font-weight-bold font-lg">평균중량</sapi_windows_vt100_support><br>
									<span class="text-danger font-xl" id="summary_avg">-</span>
								</div>
								<div class="col-xl-6 no-margin text-center font-weight-bold pt-2">
									<span class="font-md">표준편차</span><br><span class="font-md" id="summary_devi">-</span><br>
									<span class="font-md">일일증체량</span><br><span class="font-md" id="summary_inc">-</span>
								</div>
							</div>
						</div>

						<div class="col-xl-12 no-padding d-flex justify-content-between">
							<div class="col-xl-4 no-padding">
								<div class="text-center"><h6 class="m-2 font-weight-bold"><span id="summary_type">육계 -수</span></h6></div>
							</div>
							<div class="col-xl-8 no-padding">
								<div class="text-center"><h6 class="m-2 font-weight-bold"><span id="summary_comein">입추일자 : -</span></h6></div>

								<div id="summary_indate" style="display:none;"></div>
								<div id="summary_outdate" style="display:none;"></div>
							</div>
						</div>
					</div>

					<div class="col-xl-6 pr-2" id="summary_camera" style="padding-top:1.5%">
						
					</div>
					
				</div>
						
			</div>
		</div>

		<div class="col-xl-6">
			<div class="jarviswidget jarviswidget-color-darken" id="wid-id-2" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
				<header>
					<div class="widget-header">	
						<h2><i class="fa fa-bell-o"></i>&nbsp;사육정보</h2>	
					</div>
				</header>
				<div class="widget-body p-3" style="height: 294.97px">
					<!--급이 / 급수가 없으면 나타날 div-->
					<!-- <div class="col-xs-7 float-left pr-4 pl-0 feed_none_div" style="height: -webkit-fill-available; display: none;">
						<h1 class='font-weight-bold m-auto'><i class='glyphicon glyphicon-remove-sign text-danger'></i> 표시할 데이터가 없습니다.</h1>
					</div> -->

					<div class="col-xl-8 float-left mt-4 pr-5 pl-0 feed_info_div" style="border-right: 2px dotted #ddd;">
						<div class="row d-flex align-items-center">
							<div class="col-xl-4 no-padding text-center">
								<div class="col-xl-12 text-center">
									<img src="../images/feed-00.png" id="feed_img" style="width: 7rem;" alt="급이 이미지">
									<div class="carousel-caption h-100" style="text-shadow: none;"><h5 class="font-weight-bold text-secondary" id="extra_feed_percent">-%<h5></div>
								</div>
								<div class="col-xl-12 text-center no-padding"><span>사료잔량 <span id="extra_feed_remain">-</span>(kg)</span></div>
							</div>
							<div class="col-xl-4 h-50 no-padding">
								<div class="col-xl-12 h-75 text-right no-padding">
									<span class="font-weight-bold text-secondary font-md">오늘 급이량(㎏)</span><br>
									<span class="font-xl" id="extra_curr_feed">-</span>
								</div>
							</div>
							<div class="col-xl-4 h-50 float-right no-padding">
								<div class="col-xl-12 h-75 text-right no-padding">
									<span class="font-weight-bold text-secondary font-md">전일 급이량(㎏)</span><br>
									<span class="font-xl" id="extra_prev_feed">-</span>
								</div>
							</div>
						</div>
						<div class="row mt-3 d-flex align-items-center">
							<div class="col-xl-4 no-padding text-center">
								<div class="col-xl-12 text-center"><img src="../images/water-02.png" style="width: 5rem;" alt="급수 이미지"></div>
								<div class="col-xl-12 text-center no-padding"><span>시간당 급수량 <span id="extra_water_per_hour">-</span>(L)</span></div>
							</div>
							<div class="col-xl-4 h-50 no-padding">
								<div class="col-xl-12 h-75 text-right no-padding">
									<span class="font-weight-bold text-secondary font-md">오늘 급수량(L)</span><br>
									<span class="font-xl" id="extra_curr_water">-</span>
								</div>
							</div>
							<div class="col-xl-4 h-50 float-right no-padding">
								<div class="col-xl-12 h-75 text-right no-padding">
									<span class="font-weight-bold text-secondary font-md">전일 급수량(L)</span><br>
									<span class="font-xl" id="extra_prev_water">-</span>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xs-4 float-right mt-3">
						<div class="row">
						</div>
					</div>
					<!-- <div class="col-xs-5 float-right mt-3">
						<div class="col-xs-12 h-100 no-padding">
							<ul class="list-group" id="alarm_list">
								<li class="list-group-item"><div class="alert alert-secondary m-0">재산출 요청 중</div></li>
								<li class="list-group-item"><div class="alert alert-danger m-0">결함 진행사항 존재</div></li>
								<li class="list-group-item"><div class="alert alert-danger m-0">재산출 요청 중</div></li>
								<li class="list-group-item"><div class="alert alert-danger m-0">결함 진행사항 존재</div></li>
								<li class="list-group-item"><div class="alert m-0 text-white" style="background-color: #455a64; border-color: #568a89;">재산출 요청 중</div></li>
								<li class="list-group-item"><div class="alert m-0 text-white" style="background-color: #568a89; border-color: #455a64;">재산출 요청 중</div></li>
							</ul>
						</div>
					</div> -->
				</div>
						
			</div>
		</div>
	</div>

	<!--장치현황-->
	<div class="row">
		<div class="col-xl-3">
			<div class="jarviswidget jarviswidget-color-white no-padding" id="wid-id-3" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
				<header>
					<div class="widget-header">	
						<h2><i class="fa fa-gears text-dark"></i>&nbsp;장치 현황</h2>	
					</div>
				</header>
			
				<div class="widget-body" style="height: 323.5px">
					<table class="table table-bordered table-hover" style="text-align: center;">
						<thead>
							<tr>
								<th>장치명</th>
								<th>설치수</th>
								<th>장치 설정</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>IoT 저울</td>
								<td id="device_cnt_cell">3</td>
								<td><button type="button" class="btn btn-outline-secondary btn-block btn-sm" onClick="page_move('../04_device_mgr/0401.php')"><span class="fa fa-gear text-orange"></span></button></td>
							</tr>
							<tr>
								<td>IP 카메라</td>
								<td id="device_cnt_camera">1</td>
								<td><button type="button" class="btn btn-outline-secondary btn-block btn-sm" onClick="page_move('../04_device_mgr/0402.php')"><span class="fa fa-gear text-orange"></span></button></td>
							</tr>
							<tr>
								<td>자동환경제어장치</td>
								<td id="device_cnt_plc">1</td>
								<td><button type="button" class="btn btn-outline-secondary btn-block btn-sm" onClick="page_move('../04_device_mgr/0403.php')"><span class="fa fa-gear text-orange"></span></button></td>
							</tr>
							<tr>
								<td>사료빈 로드셀</td>
								<td id="device_cnt_feeder">1</td>
								<td><button type="button" class="btn btn-outline-secondary btn-block btn-sm" onClick="page_move('../04_device_mgr/0404.php')"><span class="fa fa-gear text-orange"></span></button></td>
							</tr>
							<tr>
								<td>유량센서</td>
								<td id="device_cnt_water">1</td>
								<td><button type="button" class="btn btn-outline-secondary btn-block btn-sm" onClick="page_move('../04_device_mgr/0404.php')"><span class="fa fa-gear text-orange"></span></button></td>
							</tr>
							<tr>
								<td>외기환경센서</td>
								<td id="device_cnt_out">1</td>
								<td><button type="button" class="btn btn-outline-secondary btn-block btn-sm" onClick="page_move('../04_device_mgr/0404.php')"><span class="fa fa-gear text-orange"></span></button></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>

		<div class="col-xl-9">
			<div class="jarviswidget jarviswidget-color-white no-padding" id="wid-id-4" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
				<header>
					<div class="widget-header">	
						<h2><i class="fa fa-gears text-dark"></i>&nbsp;장치 데이터</h2>	
					</div>
				</header>
				<div class="widget-body" style="height: 323.5px">
					<table id="device_buffer_table"  data-page-list="[]" data-pagination="false" data-page-list="false" data-page-size="10" data-toggle="table" style="font-size:14px; height: 323.5px">
						<thead>
							<tr>
								<th data-field='f1' data-visible="true" data-align="center" data-cell-style="del_padding">장치</th>
								<th data-field='f2' data-visible="true" data-align="center" data-cell-style="del_padding">수집시간</th>
								<th data-field='f3' data-visible="true" data-cell-style="del_padding">데이터</th>
							</tr>
						</thead>
					</table>
				</div>
						
			</div>
		</div>
	</div>


	<!--평균중량(표) & 오류이력-->
	<div class="row">
		<div class="col-xl-6">
			<div class="jarviswidget jarviswidget-color-white no-padding" id="wid-id-5" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
				<header>
					<div class="widget-header">	
						<h2><i class="fa fa-bar-chart-o text-orange"></i>&nbsp;평균중량</h2>	
					</div>

					<div class="widget-toolbar ml-auto">
						<div class="form-inline">
							<button type="button" class="btn btn-default btn-sm" onClick="get_avg_data('day')">일령별</button>&nbsp;
							<button type="button" class="btn btn-default btn-sm" onClick="get_avg_data('time')">시간별</button>&nbsp;
							<button type="button" class="btn btn-warning btn-sm btn-labeled" onClick="$('#avg_weight_table_div').toggle(700).focus()" id="avg_table_slide"><span class="btn-label"><i class="fa fa-table"></i></span>표 출력</button>&nbsp;
							<button type="button" class="btn btn-secondary btn-sm btn-labeled" onClick="get_avg_data('excel')" selection="day" id="btn_excel_avg"><span class="btn-label"><i class="fa fa-file-excel-o"></i></span>엑셀</button>
						</div>
					</div>
				</header>

				<div class="widget-body">

					<div class="col-xl-12">
						<div id="avg_weight_chart" style="height:465px; width:100%;"></div>
					</div>
					
					<div class="col-xl-12" id="avg_weight_table_div" style="display:none;" tabindex="-1"> <!-- tabindex로 div에 focus()를 줄 수 있다 -1 일 경우 js로만 focus 가능 -->
						<table id="avg_weight_table"  data-page-list="[]" data-pagination="true" data-page-list="false" data-page-size="10" data-sort-name="f2" data-sort-order="desc" data-toggle="table" style="font-size:14px">
							<thead>
								<tr>
									<th data-field='f1' data-visible="true" data-sortable="true">산출시간</th>
									<th data-field='f2' data-visible="true" data-sortable="true">일령</th>
									<th data-field='f3' data-visible="true" data-sortable="true">평체</th>
									<th data-field='f4' data-visible="true" data-sortable="true">권고</th>
								</tr>
							</thead>
						</table>
					</div>
					
				</div>
						
			</div>
		</div>

		<div class="col-xl-6">
			<div class="jarviswidget jarviswidget-color-white" id="wid-id-4" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
				<header>
					<div class="widget-header">	
						<h2><i class="fa fa-file-text-o text-red"></i>&nbsp;오류 이력</h2>	
					</div>

					<div class="widget-toolbar ml-auto" style="padding-top: 4px">
						<div class="form-inline">
							<button type="button" class="btn btn-secondary btn-sm btn-labeled" onClick="get_error_data('excel')"><span class="btn-label"><i class="fa fa-file-excel-o"></i></span>엑셀</button>
						</div>
					</div>
				</header>
					
				<div class="widget-body p-2" style="height:465px;">

					<table id="error_history_table"  data-page-list="[]" data-pagination="true" data-page-list="false" data-page-size="10" data-toggle="table" style="font-size:14px">
						<thead>
							<tr>
								<th data-field='f1' data-visible="true" data-sortable="true" data-align="center">오류시간</th>
								<th data-field='f2' data-visible="true" data-sortable="true" data-align="center">오류상태</th>
								<th data-field='f3' data-visible="true" data-sortable="true" data-align="center">저울번호</th>
							</tr>
						</thead>
					</table>
					
				</div>
						
			</div>
		</div>
	</div>


	<!--IoT 저울 & GW 관리-->
	<div class="row">
		<div class="col-xl-6">
			<div class="jarviswidget jarviswidget-color-white" id="wid-id-6" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
				<header>
					<div class="widget-header">	
						<h2><i class="fa fa-gear text-dark"></i>&nbsp;GW 관리 (농장ID-동ID)</h2>	
					</div>
				</header>

				<div class="widget-body p-2 d-flex align-items-center" style="height: 260px;">
					<div class="col-xl-12 no-padding">
						<div class="col-xl-6 float-left" style="height: 235.2px">
							<table class="table table-bordered table-hover text-center">
								<thead>
									<th colspan="3" style="line-height: 32px">GW 냉각팬 정보
										<button class="btn btn-outline-secondary btn-sm ml-auto" onClick="send_gw_itr('gw_fan_info')"><span class='fa fa-refresh text-orange'></span> 조회</button>
									</th>
								</thead>
								<tbody>
									<tr>
										<th>동작 온도</th>
										<td><input class='form-control input-sm' id='text_gw_fan_on_temp' type='text' maxlength='2' size='2'></td>
										<td><button class="btn btn-outline-secondary btn-sm btn-block" onClick="send_gw_itr('gw_fan_on_temp', true)"><span class="fa fa-gear text-orange"></span> 설정</button></td>
									</tr>
									<tr>
										<th>정지 온도</th>
										<td><input class='form-control input-sm' id='text_gw_fan_off_temp' type='text' maxlength='2' size='2' style="height: 29.6px"></td>
										<td><button class="btn btn-outline-secondary btn-sm btn-block" onClick="send_gw_itr('gw_fan_off_temp', true)"><span class="fa fa-gear text-orange"></span> 설정</button></td>
									</tr>
									<tr>
										<th>현재 온도</th>
										<td id='text_gw_fan_curr_temp'></td>
										<td></td>
									</tr>
									<tr>
										<th>동작 상태</th>
										<td id='text_gw_fan_status'></td>
										<td></td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="col-xl-6 float-right" style="height: 235.2px">
							<table class="table table-bordered table-hover text-center">
								<thead class="p-1">
									<th colspan="2">GW 조회 및 설정</th>
								</thead>
								<tbody class="p-1">
									<tr>
										<td>펌웨어 버전 조회</td>
										<td><button class='btn btn-outline-secondary btn-sm btn-block' id='btn_gw_version_info' onClick="send_gw_itr('gw_version_info')"><span id='ret'></span><span class='fa fa-refresh text-orange'></span> 조회</button></td>
									</tr>
									<tr>
										<td>펌웨어 업데이트</td>
										<td><button class="btn btn-outline-secondary btn-sm btn-block" id='btn_gw_update' onClick="send_gw_itr('gw_update', true)"><span class="fa fa-gear text-orange"></span> 전송</button></td>
									</tr>
									<tr>
										<td>로그 데이터 삭제</td>
										<td><button class="btn btn-outline-secondary btn-sm btn-block" id='btn_gw_log_delete' onClick="send_gw_itr('gw_log_delete', true)"><span class="fa fa-gear text-orange"></span> 전송</button></td>
									</tr>
									<tr>
										<td>GW 재부팅</td>
										<td><button class="btn btn-outline-secondary btn-sm btn-block" id='btn_gw_restart' onClick="send_gw_itr('gw_restart', true)"><span class="fa fa-gear text-orange"></span> 전송</button></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
						
			</div>
		</div>

		<div class="col-xl-6">
			<div class="jarviswidget jarviswidget-color-white" id="wid-id-7" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
				<header>
					<div class="widget-header">	
						<h2><i class="fa fa-gear text-dark"></i>&nbsp;IoT 저울 관리 (농장ID-동ID)</h2>	
					</div>
				</header>
				
				<div class="widget-body" style="height: 260px">

					<table id="cell_control_table"  data-page-list="[]" data-pagination="true" data-page-list="false" data-page-size="10" data-toggle="table" style="font-size:14px">
						<thead>
							<tr>
								<th data-field='f1' data-visible="true" data-align="center" >저울 번호</th>
								<th data-field='f2' data-visible="true" data-align="center" >펌웨어 버전</th>
								<th data-field='f3' data-visible="true" data-align="center" >데이터 (온도/습도/CO2/NH3/중량)</th>
								<th data-field='f4' data-visible="true" data-align="center" >영점조정</th>
							</tr>
						</thead>
					</table>
					
				</div>
						
			</div>
		</div>
	</div>


	<!--로우데이터 확인-->
	<div class="row">
		<div class="col-xl-12">
			<div class="jarviswidget jarviswidget-color-white no-padding" id="wid-id-8" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
				<header>
					<div class="widget-header">	
						<h2><i class="fa fa-list text-primary"></i>&nbsp;로우데이터 확인</h2>	
					</div>
					<div class="widget-toolbar ml-auto" style="cursor: default">
						<span class="font-weight-bold text-info">※ 조회범위 설정 후 조회 버튼을 눌러주세요.</span>
					</div>
				</header>

				<div class="widget-body">

					<ul class="nav nav-tabs nav-tabs-right bordered px-3" id="nav_raw_data">
						<form id="raw_data_search_form" class="form-inline" onsubmit="return false;">
							<span class="fa fa-clock-o"></span>&nbsp;조회범위&nbsp;&nbsp;
							<input class="form-control" type="text" name="search_sdate" maxlength="10" placeholder="시작일" size="10" />&nbsp;
							<input class="form-control" type="text" name="search_stime" maxlength="5" placeholder="시작시간" size="7" />
							&nbsp;&nbsp; ~ &nbsp;&nbsp;
							<input class="form-control" type="text" name="search_edate" maxlength="10" placeholder="종료일" size="10" />&nbsp;
							<input class="form-control" type="text" name="search_etime" maxlength="5" placeholder="종료시간" size="7" />&nbsp;&nbsp;
							LIMIT&nbsp;<input class="form-control" type="text" name="search_limit" placeholder="1~9999" size="7" />&nbsp;&nbsp;
							<div class="form-check">
								<input class="form-check-input" type="radio" name="search_order" id="order_1" value="1">오름차순&nbsp;
							</div>
							<div class="form-check">
								<input class="form-check-input" type="radio" name="search_order" id="order_2" value="-1" checked>내림차순&nbsp;&nbsp;
							</div>
							<button type="button" class="btn btn-default btn-sm btn-labeled" onClick="search_raw_data('search')"><span class="btn-label"><i class="fa fa-search text-primary"></i></span>조회</button>&nbsp;
							<button type="button" class="btn btn-secondary btn-sm btn-labeled" onClick="search_raw_data('excel')"><span class="btn-label"><i class="fa fa-file-excel-o"></i></span>엑셀</button>
						</form>
						
						<li class="nav-item ml-auto">
							<a data-toggle="tab" class="nav-link tab-raw" id="ext">급이/급수/외기</a>
						</li>
						<li class="nav-item">
							<a data-toggle="tab" class="nav-link tab-raw" id="dev">PLC 제어</a>
						</li>
						<li class="nav-item">
							<a data-toggle="tab" class="nav-link tab-raw" id="plc">PLC 환경</a>
						</li>
						<li class="nav-item">
							<a data-toggle="tab" class="nav-link active tab-raw" id="cell">IoT저울</a>
						</li>
					</ul>

					<table id="cell_raw_data_table" data-page-list="[]" data-pagination="true" data-page-list="false" data-page-size="10" data-toggle="table" style="font-size:14px;">
						<thead>
							<tr>
								<th data-field='f1'  data-visible="true" data-sortable="true">획득시간</th>
								<th data-field='f2'  data-visible="true" data-sortable="true">저울ID</th>
								<th data-field='f3'  data-visible="true" data-sortable="true">온도(℃)</th>
								<th data-field='f4'  data-visible="true" data-sortable="true">습도(%)</th>
								<th data-field='f5'  data-visible="true" data-sortable="true">CO2(ppm)</th>
								<th data-field='f6'  data-visible="true" data-sortable="true">NH3(ppm)</th>
								<th data-field='f7'  data-visible="true" data-sortable="false">w01</th>
								<th data-field='f8'  data-visible="true" data-sortable="false">w02</th>
								<th data-field='f9'  data-visible="true" data-sortable="false">w03</th>
								<th data-field='f10' data-visible="true" data-sortable="false">w04</th>
								<th data-field='f11' data-visible="true" data-sortable="false">w05</th>
							</tr>
						</thead>
					</table>

					<table id="plc_raw_data_table" data-page-list="[]" data-pagination="true" data-page-list="false" data-page-size="10" data-toggle="table" style="font-size:14px;">
						<thead>
							<tr>
								<th data-field='f1' data-sortable='true'>획득시간</th>
								<th data-field='f2' data-sortable='true'>내부온도(℃)</th>
								<th data-field='f3' data-sortable='true'>내부습도(%)</th>
								<th data-field='f4' data-sortable='true'>내부CO2(ppm)</th>
								<th data-field='f5' data-sortable='true'>내부음압</th>
								<th data-field='f6' data-sortable='true'>외부온도(℃)</th>
								<th data-field='f7' data-sortable='true'>외부습도(%)</th>
								<th data-field='f8' data-sortable='true'>외부NH3(ppm)</th>
								<th data-field='f9' data-sortable='true'>외부H2S(ppm)</th>
							</tr>
						</thead>
					</table>

					<table id="dev_raw_data_table" data-page-list="[]" data-pagination="true" data-page-list="false" data-page-size="10" data-toggle="table" style="font-size:14px;">
						<thead>
							<tr>
								<th data-field='f1' data-sortable='true'>획득시간</th>
								<th data-field='f2' data-sortable='true'>유닛ID</th>
								<th data-field='f3' data-sortable='true'>장치속성</th>
								<th data-field='f4' data-sortable='true'>장치구분</th>
								<th data-field='f5' data-sortable='true'>장치명</th>
								<th data-field='f6' data-sortable='true'>상태</th>
							</tr>
						</thead>
					</table>

					<table id="ext_raw_data_table" data-page-list="[]" data-pagination="true" data-page-list="false" data-page-size="10" data-toggle="table" style="font-size:14px;">
						<thead>
							<tr>
								<th data-field='f1'  data-sortable='true'>획득시간</th>
								<th data-field='f2'  data-sortable='true'>사료빈무게</th>
								<th data-field='f3'  data-sortable='true'>현재값-직전값</th>
								<th data-field='f4'  data-sortable='true'>유량센서값</th>
								<th data-field='f5'  data-sortable='true'>온도(℃)</th>
								<th data-field='f6'  data-sortable='true'>습도(%)</th>
								<th data-field='f7'  data-sortable='true'>NH3(ppm)</th>
								<th data-field='f8'  data-sortable='true'>H2S(ppm)</th>
								<th data-field='f9'  data-sortable='true'>미세먼지(ppm)</th>
								<th data-field='f10' data-sortable='true'>초미세먼지(ppm)</th>
								<th data-field='f11' data-sortable='true'>풍향</th>
								<th data-field='f12' data-sortable='true'>풍속(m/s)</th>
							</tr>
						</thead>
					</table>
					
				</div>
					
			</div>
		</div>
	</div>


	<!--재산출-->
	<div class="row">
		<div class="col-xl-12">
			<div class="jarviswidget jarviswidget-color-white" id="wid-id-10" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
				<header>
					<div class="widget-header">	
						<h2><i class="fa fa-check-square-o text-primary"></i>&nbsp;재산출 기록</h2>	
					</div>
				</header>

				<div class="widget-body p-2">	
				
					<table id="request_history_table"  data-page-list="[]" data-pagination="true" data-page-list="false" data-page-size="5" data-toggle="table" style="font-size:14px">
						<thead>
							<tr>
								<th data-field='f1' data-visible="true">완료시간</th>
								<th data-field='f2' data-visible="true">요청사항</th>
								<th data-field='f3' data-visible="true">변경사항</th>
								<th data-field='f4' data-visible="true">실측시간</th>
								<th data-field='f5' data-visible="true">실측값</th>
								<th data-field='f6' data-visible="true">재산출 전 예측</th>
							</tr>
						</thead>
					</table>
					
				</div>
						
			</div>
		</div>
	</div>
</article>
<?
include_once("../inc/bottom.php");
?>

<script language="javascript">

	var code = "";
	var indate = "";
	var outdate = "";

	// 로우데이터가 로드된적이 있는지 확인
	var is_load = {};
		is_load["cell"] = false;
		is_load["plc"] = false;
		is_load["dev"] = false;
		is_load["ext"] = false;

	var init_id = "<?=$init_id?>";

	$(document).ready(function(){

		call_tree_view("", act_grid_data, "all");
		set_tree_search(act_grid_data, "all");

		$("#plc_raw_data_table").parent(".fixed-table-body").parent(".fixed-table-container").parent(".bootstrap-table").hide();
		$("#dev_raw_data_table").parent(".fixed-table-body").parent(".fixed-table-container").parent(".bootstrap-table").hide();
		$("#ext_raw_data_table").parent(".fixed-table-body").parent(".fixed-table-container").parent(".bootstrap-table").hide();

		$("#raw_data_search_form [name=search_sdate]").datepicker({format:"yyyy-mm-dd", language: "kr", autoclose: true});		//로우데이터 검색 시작일
		$("#raw_data_search_form [name=search_edate]").datepicker({format:"yyyy-mm-dd", language: "kr", autoclose: true});		//로우데이터 검색 종료일

		$("#raw_data_search_form [name=search_stime]").clockpicker({placement: 'bottom', align: 'left', autoclose: true});		//로우데이터 검색 시작시간
		$("#raw_data_search_form [name=search_etime]").clockpicker({placement: 'bottom', align: 'left', autoclose: true});		//로우데이터 검색 종료시간
	});

	// 데이터 불러오기
	function load_data(select){
		
		if(select == ""){
			if(init_id == ""){
				click_tree_first(act_grid_data);
			}
			else{
				click_tree_by_id(act_grid_data, init_id);
				init_id = "";
			}
			return;
		}

		select = select.split("|").length != 2 ? select + "|01" : select;
		let temp = $("#" + select.replace("|", "\\|") + "");

		code = $(temp).attr("cmCode");
		indate = $(temp).attr("cmIndate");
		outdate = $(temp).attr("cmOutDate");

		if(code == "" || code == null){
			popup_alert("입출하 데이터 없음", "선택된 농장의 입출하 데이터가 없습니다.");
		}

		get_buffer_data();
		get_avg_data("day");
		get_error_data();
		get_request_data();
	};

	// 동 선택 변경 시 검색 초기화
	function clear_search(){

		is_load["cell"] = false;
		is_load["plc"] = false;
		is_load["dev"] = false;
		is_load["ext"] = false;
		
		$("#raw_data_search_form").each(function() {this.reset();});
		$("#nav_raw_data li").removeClass("active").children("a").removeClass("active").removeClass("show");
		$("#nav_raw_data li a#cell").addClass("active").addClass("show").parent("li").addClass("active");

		$("#cell_raw_data_table").parent(".fixed-table-body").parent(".fixed-table-container").parent(".bootstrap-table").hide();
		$("#plc_raw_data_table").parent(".fixed-table-body").parent(".fixed-table-container").parent(".bootstrap-table").hide();
		$("#dev_raw_data_table").parent(".fixed-table-body").parent(".fixed-table-container").parent(".bootstrap-table").hide();
		$("#ext_raw_data_table").parent(".fixed-table-body").parent(".fixed-table-container").parent(".bootstrap-table").hide();

		$("#cell_raw_data_table").parent(".fixed-table-body").parent(".fixed-table-container").parent(".bootstrap-table").show();

		$("#cell_raw_data_table").bootstrapTable('removeAll');
		//raw_tab_click("cell");
	}

	// 트리뷰 버튼 클릭시 리로드 이벤트
	function act_grid_data(action){
		switch(action){
			default:
				clear_search();
				load_data(action);
				break;
		}
	};

	// 버퍼테이블 불러오기
	function get_buffer_data(){

		if(code != null && code != ""){			// "" or null 체크
			var data_arr = {}; 
			data_arr['oper'] = "get_buffer";
			data_arr['code'] = code;
			$.ajax({url:'0102_action.php',data:data_arr,cache:false,type:'post',dataType:'json',
				success: function(data) {

					// 요약 정보
					$.each(data.summary_data, function(key, value){ 
						$("#" + key).html(value); 
					});
					
					// 장치 현황
					$.each(data.device_cnt_data, function(key, value){ 
						$("#" + key).html(value); 
					});

					// 닭 이미지 변경
					let days = data.summary_data.summary_days;
					if(days <= 10){	$("#hen_img").attr("src", "../images/hen-scale1.png"); }
					if(days >= 11 && days <= 20){ $("#hen_img").attr("src","../images/hen-scale2.png");  }
					if(days >= 21){ $("#hen_img").attr("src","../images/hen-scale3.png");  }

					$('#device_buffer_table').bootstrapTable('load', data.buffer_data); //data-toggle="table" 하지않으면 Update 불가
					
					$('#cell_control_table').bootstrapTable('load', data.cell_control_data);
				
					// 급이, 급수 창 표시할지 선택
					if(data.extra.hasOwnProperty("extra_curr_feed")){
						$.each(data.extra, function(key, val){	$("#" + key).html(val); });
						let per = data.extra.extra_feed_percent;
						per = parseInt(per);
						if(per <= 10){ 				document.getElementById("feed_img").setAttribute("src", "../images/feed-00.png"); }
						if(per > 10 && per <= 35){ 	document.getElementById("feed_img").setAttribute("src", "../images/feed-01.png"); }
						if(per > 35 && per <= 65){ 	document.getElementById("feed_img").setAttribute("src", "../images/feed-02.png"); }
						if(per > 65 && per <= 90){ 	document.getElementById("feed_img").setAttribute("src", "../images/feed-03.png"); }
						if(per > 90){ 				document.getElementById("feed_img").setAttribute("src", "../images/feed-04.png"); }
					}
					
					// 급이, 급수 데이터 없으면 나타날 div -> class='feed_none_div' removeClass로 d- 관련 없애줘야 display none 이 먹힘
					// if(data.extra != null && data.extra != ""){
					// 	$(".feed_none_div").css("display", "none").removeClass("d-flex align-items-center");
					// 	$(".feed_info_div").css("display", "block");
					// }
					// else {
					// 	$(".feed_none_div").css("display", "block").addClass("d-flex align-items-center");
					// 	$(".feed_info_div").css("display", "none");
					// }
				}
			});
		}
	};

	// 평균중량 불러오기
	function get_avg_data(sub_comm){
		if(code != null && code != ""){			// "" or null 체크

			var data_arr = {}; 
			data_arr['oper'] = "get_avg_weight";
			data_arr['code'] = code;
			data_arr['comm'] = "view";

			switch(sub_comm){
				case "day":
					$("#btn_excel_avg").attr("selection", "day");
					break;
				case "time":
					$("#btn_excel_avg").attr("selection", "time");
					break;
				case "excel":
					data_arr['comm'] = "excel";
					break;
			}

			data_arr['term'] = $("#btn_excel_avg").attr("selection");

			
			$.ajax({url:'0102_action.php',data:data_arr,cache:false,type:'post',dataType:'json',
				success: function(data) {
					
					switch(data_arr['comm']){
						case "view":

							draw_select_chart("avg_weight_chart", data.avg_weight_chart, "영역차트", "Y", "N", 12);

							$('#avg_weight_table').bootstrapTable('load', data.avg_weight_table);

							break;
						case "excel":
							let excel_html = data.excel_html;
							let excel_title = data.excel_title;

							table_to_excel(excel_title, excel_html);
							break;
					}

				}
			});
		}
	};

	// 오류이력 불러오기
	function get_error_data(sub_comm){
		if(code != null && code != ""){			// "" or null 체크
			var data_arr = {}; 
			data_arr['oper'] = "get_error_history";
			data_arr['code'] = code;

			switch(sub_comm){
				default:
					data_arr['comm'] = "view";
					break;
				case "excel":
					data_arr['comm'] = "excel";
					break;
			}

			$.ajax({url:'0102_action.php',data:data_arr,cache:false,type:'post',dataType:'json',
				success: function(data) {
					switch(data_arr['comm']){
						case "view":

							$('#error_history_table').bootstrapTable('load', data.error_history_data);

							break;

						case "excel":
							let excel_title = data.error_excel_title;
							let excel_html  = data.error_excel_html;
							
							// alert(excel_html);
							table_to_excel(excel_title,excel_html);

							break;

					}
				}
			});
		}
	};

	// 오류이력 불러오기
	function get_request_data(){
		if(code != null && code != ""){			// "" or null 체크
			var data_arr = {}; 
			data_arr['oper'] = "get_request_history";
			data_arr['code'] = code;
			data_arr['indate'] = indate;
			$.ajax({url:'0102_action.php',data:data_arr,cache:false,type:'post',dataType:'json',
				success: function(data) {
					$('#request_history_table').bootstrapTable('load', data.request_history_data); 
				}
			});
		}
	};

	// 로우데이터 불러오기
	function get_raw_data(action, type, search_map){
		$("#" + type + "_raw_data_table").bootstrapTable('showLoading');

		if(code != null && code != ""){			// "" or null 체크
			var data_arr = {}; 
				data_arr['oper'] = "get_raw_data";
				data_arr['code'] = code;
				data_arr['type'] = type;
				data_arr['action'] = action;
				data_arr['search_map'] = search_map;
				data_arr['indate'] = indate;

			$.ajax({url:'0102_action.php',data:data_arr,cache:false,type:'post',dataType:'json',
				success: function(data) {
					$("#" + type + "_raw_data_table").bootstrapTable('load', data.raw_data);
					$("#" + type + "_raw_data_table").bootstrapTable('hideLoading');

					is_load[type] = true;
				},
				complete: function(){
					$("#" + type + "_raw_data_table").bootstrapTable('hideLoading');
				}
			});
		}
	};

	// 로우데이터 검색 이벤트
	function search_raw_data(action){
		let search_map = {};
		$.each($("#raw_data_search_form").serializeArray(), function(){ 
			search_map[this.name] = this.value;
		});

		let type = $("#nav_raw_data").children(".nav-item").find("a.active").attr("id");

		get_raw_data(action, type, search_map);
	}

	// 탭버튼 선택 이벤트
	function raw_tab_click(type){
		let search_map = {};
		$.each($("#raw_data_search_form").serializeArray(), function(){ 
			search_map[this.name] = this.value;
		});

		$("#cell_raw_data_table").parent(".fixed-table-body").parent(".fixed-table-container").parent(".bootstrap-table").hide();
		$("#plc_raw_data_table").parent(".fixed-table-body").parent(".fixed-table-container").parent(".bootstrap-table").hide();
		$("#dev_raw_data_table").parent(".fixed-table-body").parent(".fixed-table-container").parent(".bootstrap-table").hide();
		$("#ext_raw_data_table").parent(".fixed-table-body").parent(".fixed-table-container").parent(".bootstrap-table").hide();

		$("#" + type + "_raw_data_table").parent(".fixed-table-body").parent(".fixed-table-container").parent(".bootstrap-table").show();

		if(!is_load[type]){
			get_raw_data("search", type, search_map);
		}
	};

	// 탭버튼 선택
	$(".tab-raw").click( function(){
		let type = $(this).attr("id");
		raw_tab_click(type);
	});


	//로우데이터 검색부 키 제한
	$("#raw_data_search_form [name=search_sdate]").on("keyup", function() { $(this).val(""); });
	$("#raw_data_search_form [name=search_edate]").on("keyup", function() { $(this).val(""); });
	$("#raw_data_search_form [name=search_stime]").on("keyup", function() { $(this).val(""); });
	$("#raw_data_search_form [name=search_etime]").on("keyup", function() { $(this).val(""); });
	$("#raw_data_search_form [name=search_limit]").on("keyup", function() {
		var temp = $(this).val();
		temp = temp.replace(/[^0-9]/,"");
		temp = temp.length > 4 ? temp.substr(0, 4) : temp;

		$(this).val(temp);
	});

	// 버퍼테이블 패딩 삭제
	function del_padding(value, row, index){
		return {
			css: {
				padding: '0px'
			}
		}
	};

	// 페이지 이동
	function page_move(page){
		let keys = selected_id.split("|");

		let farmID = keys[0];
		let dongID = keys.length == 2 ? keys[1] : "01";

		window.location = page + "?farmID=" + farmID + "&dongID=" + dongID; 
	};

	// 웹소켓으로 서버에 명령 전송
	function itr_send(send, id, need_confirm = false){

		if(need_confirm){
			let msg = $("#summary_name").html() + " " + id.substr(id.length - 2, id.length) + "번 저울의 영점을 조정하시겠습니까?";
			popup_confirm("명령 전송 확인", msg, function(confirm){
				
				if(confirm){
					socket_send(send, id);
				}

			});
		}
		else{
			socket_send(send, id);
		}
	};

	function socket_send(send, id){
		let data_arr = {}; 
		data_arr['oper'] = "socket_send";
		data_arr['send'] = send;

		$.ajax({url:'0102_action.php', data:data_arr, cache:false, type:'post', dataType:'json',
			success: function(data) {

				switch(data.recv.retCode){
					case "S":
						$("#" + id + " #ret").html(data.recv.retValue + "&nbsp;&nbsp;");
						break;
					
					case "F":
						$("#" + id + " #ret").html("fail" + "&nbsp;&nbsp;");
						break;

					default:
						$("#" + id + " #ret").html("no response" + "&nbsp;&nbsp;");
						break;
				}
			}
		});
	}

	function send_gw_itr(comm, need_confirm = false){
		if(need_confirm){
			let msg = $("#summary_name").html() + " " + comm + " 명령을 전송합니다.";
			popup_confirm("명령 전송 확인", msg, function(confirm){
				
				if(confirm){
					socket_send_to_gw(comm);
				}
			});
		}
		else{
			socket_send_to_gw(comm);
		}
	}

	function socket_send_to_gw(comm){
		let data_arr = {}; 
		data_arr['oper'] = "socket_send_to_gw";
		data_arr['comm'] = comm;
		data_arr['code'] = code;

		switch(comm){
            case "gw_fan_on_temp":
			case "gw_fan_off_temp":
				let set_value = $("#text_" + comm).val().trim();
				data_arr['value'] = set_value;
                break;
		}

		$.ajax({url:'0102_action.php', data:data_arr, cache:false, type:'post', dataType:'json',
			success: function(data) {

				switch(comm){
					case "gw_version_info":
						$("#btn_" + comm + " #ret").html(data.recv.retValue + "&nbsp;&nbsp;");
                		break;

					case "gw_fan_info":
						//popup_alert("명령 전송 결과", data.recv.retValue);
						let ret_val = data.recv.retValue;
						let ret_arr = ret_val.split("/");
						if(ret_arr.length >= 4){
							$("#text_gw_fan_on_temp").val(ret_arr[0].split("=")[1].trim());
							$("#text_gw_fan_off_temp").val(ret_arr[1].split("=")[1].trim());
							$("#text_gw_fan_curr_temp").html(ret_arr[2].split("=")[1].trim());
							$("#text_gw_fan_status").html(ret_arr[3].split("=")[1].trim());
						}
                		break;

					default:
						popup_alert("명령 전송 결과", data.recv.retMsg);
						break;
				}
			}
		});
	}

	// function get_ajax_result(target, data_arr){
	// 	let ret = array();

	// 	$.ajax({url:target, data:data_arr, cache:false, type:'post', dataType:'json',
	// 		success: function(data) {
	// 			ret = data;
	// 		},
	// 		error: function(data) {
	// 			ret = data;
	// 		},
	// 		complete: function(data) {
	// 			return ret;
	// 		}
	// 	});
	// }

	
</script>