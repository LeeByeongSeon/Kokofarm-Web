<?
include_once("../inc/top.php");

// Google Map API Key
$map_key="AIzaSyDhI36OUKqVjyFrUQYufwr80bon1Y0-hZ0";

?>

<!--입출하 농장 수 & 호수별 입추 수-->
<div class="row">
	<article class="col-xl-4">
		<div class="jarviswidget jarviswidget-color-darken no-padding" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
			<header>
				<div class="widget-header">	
					<h2><i class="fa fa-home"></i>&nbsp;<span class="KKF-137">입출하 농장 수</span></h2>	
				</div>
					
				<!-- <div class="widget-toolbar ml-auto">
					<div class="form-inline">
						<button class="btn btn-default btn-labeled btn-sm" onClick=""><span class="btn-label" style="top: auto;"><i class="fa fa-search text-primary"></i></span>농장별로 확인</button>&nbsp;
						<button class="btn btn-default btn-labeled btn-sm" onClick=""><span class="btn-label" style="top: auto;"><i class="fa fa-search text-primary"></i></span>동별로 확인</button>
					</div>
				</div> -->
			</header>

			<div class="widget-body">
				<table id="in_out_farm" data-page-list="[]" data-pagination="false" data-page-list="false" data-page-size="10" data-toggle="table" style="font-size:14px;">
					<thead>
						<tr>
							<th	data-field='f1'  data-sortable='true' data-align='center'><span class="KKF-29">입추</span></th>
							<th data-field='f2'  data-sortable='true' data-align='center'><span class="KKF-138">입추예정</span></th>
							<th	data-field='f3'  data-sortable='true' data-align='center'><span class="KKF-139">출하예정</span></th>
							<th data-field='f4'  data-sortable='true' data-align='center'><span class="KKF-30">출하</span></th>
						</tr>
					</thead>
				</table>
			</div>
					
		</div>
	</article>

	<article class="col-xl-8">
		<div class="jarviswidget jarviswidget-color-darken" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
			<header>
				<div class="widget-header">	
					<h2><i class="fa fa-list"></i>&nbsp;<span class="KKF-140">호수별 입추 수 (단위 : 1000마리)</span></h2>	
				</div>
			</header>

			<div class="widget-body no-padding">

				<table id="ho_insu" data-page-list="[]" data-pagination="false" data-page-list="false" data-page-size="1" data-toggle="table" style="font-size:14px;">
					<thead>
						<tr>
							<th data-field='f11' data-sortable='true' data-align='center'><span class="KKF-141">11호</span></th>
							<th data-field='f12' data-sortable='true' data-align='center'><span class="KKF-142">12호</span></th>
							<th data-field='f13' data-sortable='true' data-align='center'><span class="KKF-143">13호</span></th>
							<th data-field='f14' data-sortable='true' data-align='center'><span class="KKF-144">14호</span></th>
							<th data-field='f15' data-sortable='true' data-align='center'><span class="KKF-146">15호</span></th>
							<th data-field='f16' data-sortable='true' data-align='center'><span class="KKF-146">16호</span></th>
							<th data-field='f17' data-sortable='true' data-align='center'><span class="KKF-147">17호</span></th>
							<th data-field='f18' data-sortable='true' data-align='center'><span class="KKF-148">18호</span></th>
							<th data-field='f19' data-sortable='true' data-align='center'><span class="KKF-149">19호</span></th>
							<th data-field='f20' data-sortable='true' data-align='center'><span class="KKF-150">20호</span></th>
							<th data-field='f21' data-sortable='true' data-align='center'><span class="KKF-151">21호</span></th>
							<th data-field='f22' data-sortable='true' data-align='center'><span class="KKF-152">22호</span></th>
						</tr>
					</thead>
				</table>
				
			</div>
					
		</div>
	</article>
</div>

<!-- <div class="row">
	<article class="col-xl-12">
		<div class="well well-sm" id="event-container">
			<form>
				<fieldset>
					<legend>
						Draggable Events
					</legend>
					<ul id='external-events' class="list-unstyled">
						<li>
							<span class="bg-darken text-white" data-description="Currently busy" data-icon="fa-time">Office Meeting</span>
						</li>
					</ul>
					<div class="checkbox vcheck">
						<label>
							<input type="checkbox" id="drop-remove" class="checkbox style-0" checked="checked">
							<span>remove after drop</span>
						</label>
					</div>
				</fieldset>
			</form>
		</div>
	</article>
</div> -->

<!--입출하 일정 & 농가 지도-->
<div class="row">
	<article class="col-xl-8">
		<div class="jarviswidget jarviswidget-color-white" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
			<header>
				<div class="widget-header">
					<!-- <span class="widget-icon"> <i class="fa fa-calendar text-primary"></i> </span>
					<h2 class="0201-03-hdr-title"> 입출하 일정</h2> -->
					<h2><i class="fa fa-calendar text-primary"></i>&nbsp;<span class="KKF-153">입출하 일정</span></h2>	
				</div>
				<div class="widget-toolbar ml-auto" style="padding-top: 4px">
					<!-- add: non-hidden - to disable auto hide -->
					<div class="form-inline">
						<!-- <a class="btn btn-default btn-sm" href="javascript:void(0);" id="mt">Month</a>&nbsp;
						<a class="btn btn-default btn-sm" href="javascript:void(0);" id="ag">Agenda</a>&nbsp;
						<a class="btn btn-default btn-sm" href="javascript:void(0);" id="td">Today</a>&nbsp;
						<button class="btn btn-outline-primary btn-sm" id="open_modal_btn"><i class="fa fa-plus"></i></button> -->
					</div>
				</div>
			</header>

			<div class="widget-body no-padding">

				<div class="widget-body-toolbar text-right">

					<div id="calendar_buttons">

						<div class="btn-group">
							<a href="javascript:void(0)" class="btn btn-default btn-xs" id="btn_prev"><i class="fa fa-chevron-left"></i></a>
							<a href="javascript:void(0)" class="btn btn-default btn-xs" id="btn_next"><i class="fa fa-chevron-right"></i></a>
						</div>
					</div>

				</div>

				<div id="calendar"></div>

			</div>

		</div>
	</article>

	<article class="col-xl-4">
		<div class="jarviswidget jarviswidget-color-white no-padding" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
			<header>
				<div class="widget-header">	
					<h2><i class="fa fa-map-marker text-green"></i>&nbsp;<span class="KKF-154">농가 지도</span></h2>	
				</div>
				<div class="widget-toolbar ml-auto" style="cursor: default">
					<span class='fa fa-map-marker text-blue'> </span>&nbsp;<span class="KKF-29">입추</span>&nbsp;
					<span class='fa fa-map-marker text-orange'> </span>&nbsp;<span class="KKF-30">출하</span>&nbsp;
				</div>
			</header>
				
			<div class="widget-body">

				<div id="map_div" style="height: 876.4px;"></div>
				
			</div>
					
		</div>
	</article>

	<!--modal_box-->
	<!-- <div id="modal_box" class="modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content" style="top:20%">
				<div class="modal-header">
					<h4 class="modal-title" id="myModalLabel"><b>일정 추가</b></h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
				</div>
				
				<div class="modal-body">
					<div class="col-xl-12">
						<div>

							<div class="widget-body">

								<form id="add-event-form">
									<fieldset>

										<div class="form-group">
											<label>Select Event Icon</label>
											
											<div class="btn-group btn-group-sm btn-group-justified btn-group-toggle" data-toggle="buttons">
												<label class="btn btn-default active">
													<input type="radio" name="iconselect" id="icon-1" value="fa-info" checked>
													<i class="fa fa-info text-muted"></i> </label>
												<label class="btn btn-default">
													<input type="radio" name="iconselect" id="icon-2" value="fa-warning">
													<i class="fa fa-warning text-muted"></i> </label>
												<label class="btn btn-default">
													<input type="radio" name="iconselect" id="icon-3" value="fa-check">
													<i class="fa fa-check text-muted"></i> </label>
												<label class="btn btn-default">
													<input type="radio" name="iconselect" id="icon-4" value="fa-user">
													<i class="fa fa-user text-muted"></i> </label>
												<label class="btn btn-default">
													<input type="radio" name="iconselect" id="icon-5" value="fa-lock">
													<i class="fa fa-lock text-muted"></i> </label>
												<label class="btn btn-default">
													<input type="radio" name="iconselect" id="icon-6" value="fa-clock-o">
													<i class="fa fa-clock-o text-muted"></i> </label>
											</div>
										</div>

										<div class="form-group">
											<label>Event Title</label>
											<input class="form-control"  id="title" name="title" maxlength="40" type="text" placeholder="Event Title">
										</div>
										<div class="form-group">
											<label>Event Description</label>
											<textarea class="form-control" placeholder="Please be brief" rows="3" maxlength="40" id="description"></textarea>
											<p class="note">Maxlength is set to 40 characters</p>
										</div>

										<div class="form-group">
											<label>Select Event Color</label>
											<div class="btn-group btn-group-justified btn-select-tick btn-group-toggle" data-toggle="buttons">
												<label class="btn bg-darken active">
													<input type="radio" name="priority" id="option1" value="bg-darken text-white" checked>
													<i class="fa fa-check text-white"></i> </label>
												<label class="btn bg-blue">
													<input type="radio" name="priority" id="option2" value="bg-blue text-white">
													<i class="fa fa-check text-white"></i> </label>
												<label class="btn bg-orange">
													<input type="radio" name="priority" id="option3" value="bg-orange text-white">
													<i class="fa fa-check text-white"></i> </label>
												<label class="btn bg-green-light">
													<input type="radio" name="priority" id="option4" value="bg-green-light text-white">
													<i class="fa fa-check text-white"></i> </label>
												<label class="btn bg-blue-light">
													<input type="radio" name="priority" id="option5" value="bg-blue-light text-white">
													<i class="fa fa-check text-white"></i> </label>
												<label class="btn bg-red">
													<input type="radio" name="priority" id="option6" value="bg-red text-white">
													<i class="fa fa-check text-white"></i> </label>
											</div>
										</div>

									</fieldset>
								</form>

							</div>

						</div>
					</div>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-primary btn-sm" id="add-event">확인</button>
					<button type="button" class="btn btn-default btn-sm" id="close_modal_btn">취소</button>
				</div>

			</div>
		</div>
	</div> -->
	<!-- modal_box end -->

</div>

<?
include_once("../inc/bottom.php");
?>

<script src="https://maps.googleapis.com/maps/api/js?key=<?=$map_key?>&callback=initMap" async defer></script>

<script type="text/javascript">
	var map_data;

	$("#map_div").bind('resize',function(){ initMap(); });
	
	//구글맵 출력
	function initMap() {
		map["map_div"] = new google.maps.Map(document.getElementById("map_div"), {
			zoom:8,center:{lat:35.8391582,lng:127.0998321}
		});
		del_markers("map_div"); add_markers("map_div", jQuery.makeArray(map_data));
	};

	// 입출하 달력
	// DO NOT REMOVE : GLOBAL FUNCTIONS!
	$(document).ready(function() {
		get_inout_data();
		get_ho_data();
		get_map_data();
		
		$('#open_modal_btn').on('click', function(){
			$('#modal_box').modal('show');
		});
			// 모달 안의 취소 버튼에 이벤트를 건다.
		$('#close_modal_btn').on('click', function(){
			$('#modal_box').modal('hide');
		});

		//pageSetUp();
		"use strict";
			
			var date = new Date();
			var d = date.getDate();
			var m = date.getMonth();
			var y = date.getFullYear();
		
			var hdr = {
				left: 'title',
				center: 'month,agendaWeek,agendaDay',
				right: 'prev,today,next'
			};
		
			var initDrag = function (e) {
				// create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
				// it doesn't need to have a start or end
		
				var eventObject = {
					title: $.trim(e.children().text()), // use the element's text as the event title
					description: $.trim(e.children('span').attr('data-description')),
					icon: $.trim(e.children('span').attr('data-icon')),
					className: $.trim(e.children('span').attr('class')) // use the element's children as the event class
				};
				// store the Event Object in the DOM element so we can get to it later
				e.data('eventObject', eventObject);
		
				// make the event draggable using jQuery UI
				e.draggable({
					zIndex: 999,
					revert: true, // will cause the event to go back to its
					revertDuration: 0 //  original position after the drag
				});
			};
		
			// var addEvent = function (title, priority, description, icon) {
			// 	title = title.length === 0 ? "Untitled Event" : title;
			// 	description = description.length === 0 ? "No Description" : description;
			// 	icon = icon.length === 0 ? " " : icon;
			// 	priority = priority.length === 0 ? "label label-default" : priority;
		
			// 	var html = $('<li><span class="' + priority + '" data-description="' + description + '" data-icon="' +
			// 		icon + '">' + title + '</span></li>').prependTo('ul#external-events').hide().fadeIn();
		
			// 	$("#event-container").effect("highlight", 800);
		
			// 	initDrag(html);
			// };
		
			/* initialize the external events
			 -----------------------------------------------------------------*/
		
			$('#external-events > li').each(function () {
				initDrag($(this));
			});
		
			$('#add-event').click(function () {
				var title = $('#title').val(),
					priority = $('input:radio[name=priority]:checked').val(),
					description = $('#description').val(),
					icon = $('input:radio[name=iconselect]:checked').val();
		
				addEvent(title, priority, description, icon);
				
				$('#modal_box').modal('hide');
			});
		
			/* initialize the calendar
			 -----------------------------------------------------------------*/
		
			$('#calendar').fullCalendar({
		
				header: hdr,	 // header 설정
				editable: true,	 // 수정 가능
				droppable: true, // 드래그 가능
		
				drop: function (date, allDay) { // drag & drop 성공시 실행
		
					// retrieve the dropped element's stored Event Object
					var originalEventObject = $(this).data('eventObject');
		
					// we need to copy it, so that multiple events don't have a reference to the same object
					var copiedEventObject = $.extend({}, originalEventObject);
		
					// assign it the date that was reported
					copiedEventObject.start = date;
					copiedEventObject.allDay = allDay;
		
					// render the event on the calendar
					// the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
					$('#calendar').fullCalendar('renderEvent', copiedEventObject, true);
		
					// // is the "remove after drop" checkbox checked?
					// if ($('#drop-remove').is(':checked')) {
					// 	// if so, remove the element from the "Draggable Events" list
					// 	$(this).remove();
					// }
				},
				select: function (start, end, allDay) {
					var title = prompt('Event Title:');
					if (title) {
						calendar.fullCalendar('renderEvent', {
								title: title,
								start: start,
								end: end,
								allDay: allDay
							}, true // make the event "stick"
						);
					}
					calendar.fullCalendar('unselect');
				},
				// 달력에 표시할 event 부분(현재 일령 기준에서 fdOutDays(33일령)이 되는 날을 캘린더에 표시)
				events: function(start, end, timezone, callback){
					
					let data_arr = {};
					data_arr['oper'] = "get_calendar";
					//data_arr['code'] = code;

					$.ajax({
						url:"0201_action.php",
						dataType:"json",
						type:"post",
						data:data_arr,
						success:function(data){

							// let out_date = data.calendar_map.out_days;	// 출하예정일령
							// let cur_date = data.calendar_map.cur_days;	// 현재일령

							// if(cur_date < out_date){
								
							// }

							let events = [];
							
							$.each(data.calendar_map, function(key, value){
							
								let out_farm = value.out_farm; // calendar title ex) 이모션농장-01동 출하예정일
								let cur_days = value.cur_days; // 해당 농장의 현재 일령
								let out_days = value.out_days; // 33일령(임시? 출하예정일령)
								let in_date  = value.in_date;  // 입추일자

								let out_date = "";

								if(cur_days <= out_days){

									out_date = date_add(in_date, out_days);

									console.log(out_date);

								};
								
								events.push({
									title: out_farm + " 출하예정", 	// 제목
									start: out_date,	 				// events 시작하는 시간
									end: out_date,		 			 	// events 끝나는 시간
									// description: out_farm,		 	// events 내용
									// className: ["event", "bg-red"],	// css 형태(?)
									// icon: 'fa-check'					// icon class명
								});
							});
							callback(events);
						}
					});
				},
				eventRender: function (event, element, icon) {
					if (!event.description == "") {
						element.find('.fc-title').append("<br/><span class='ultra-light'>" + event.description +
							"</span>");
					}
					if (!event.icon == "") {
						element.find('.fc-title').append("<i class='air air-top-right fa " + event.icon +
							" '></i>");
					}
				},
				windowResize: function (event, ui) {
					$('#calendar').fullCalendar('render');
				}
			});
		
			/* hide default buttons */
			$('.fc-right, .fc-center').hide();

		
			$('#calendar_buttons #btn_prev').click(function () {
				$('.fc-prev-button').click();
				return false;
			});
			
			$('#calendar_buttons #btn_next').click(function () {
				$('.fc-next-button').click();
				return false;
			});
			
			// Month button
			$('#mt').click(function () {
				$('#calendar').fullCalendar('changeView', 'month');
			});
			
			// // Agenda button
			// $('#ag').click(function () {
			// 	$('#calendar').fullCalendar('changeView', 'agendaWeek');
			// });
			
			// // today button
			// $('#td').click(function () {
			// 	$('#calendar').fullCalendar('changeView', 'agendaDay');
			// });	
	
	});

	// 날짜에 일 더하기
	function date_add(sDate, nDays) {
		var yy = parseInt(sDate.substr(0, 4), 10);
		var mm = parseInt(sDate.substr(5, 2), 10);
		var dd = parseInt(sDate.substr(8), 10);
	
		d = new Date(yy, mm - 1, dd + parseInt(nDays));
	
		yy = d.getFullYear();
		mm = d.getMonth() + 1; mm = (mm < 10) ? '0' + mm : mm;
		dd = d.getDate(); dd = (dd < 10) ? '0' + dd : dd;
	
		return '' + yy + '-' +  mm  + '-' + dd;
	};

	function get_inout_data(){
		let data_arr = {};
			data_arr["oper"] = "get_inout_data";
		
		$.ajax({
			url:"0201_action.php",
			data:data_arr,
			cache:false,
			type:"post",
			dataType:"json",
			success: function(data){
				$('#in_out_farm').bootstrapTable('load', data.inout_data);
			}
		});
	};

	function get_ho_data(){
		let data_arr = {};
			data_arr["oper"] = "get_ho_data";
		
		$.ajax({
			url:"0201_action.php",
			data:data_arr,
			cache:false,
			type:"post",
			dataType:"json",
			success: function(data){
				//alert(data.ho_data);
				$('#ho_insu').bootstrapTable('load', data.ho_data);
			}
		});
	}

	function get_map_data(){
		let data_arr = {};
			data_arr["oper"] = "get_map_data";

		$.ajax({
			url:"0201_action.php",
			data:data_arr,
			cache:false,
			type:"post",
			dataType:"json",
			success: function(data){
				// 지도 data
				let map_data = data.json_map;
				del_markers("map_div"); add_markers("map_div", jQuery.makeArray(map_data)); //JSON ==> javascript 배열로 변환
			}
		});
	};

	</script>