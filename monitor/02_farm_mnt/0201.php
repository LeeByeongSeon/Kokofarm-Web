<?
include_once("../inc/top.php");
?>
<!--입출하 농장 수 & 호수별 입추 수-->
<div class="row fullSc">
	<article class="col-xl-4">
		<div class="jarviswidget jarviswidget-color-grey-dark no-padding" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
			<header>
				<div class="widget-header">	
					<h2><i class="fa fa-home"></i>&nbsp;&nbsp;&nbsp;입출하 농장 수</h2>	
				</div>
					
				<div class="widget-toolbar ml-auto">
					<div class="form-inline">
						<button class="btn btn-primary"><i class="fa fa-search"></i>&nbsp;&nbsp;&nbsp;농장별로 확인</button>&nbsp;&nbsp;&nbsp;
						<button class="btn btn-primary"><i class="fa fa-search"></i>&nbsp;&nbsp;&nbsp;동별로 확인</button>
					</div>
				</div>
			</header>

			<div class="widget-body">
				<table class="table table-bordered table-hover" style="text-align: center;">
					<thead>
						<th>입추</th>
						<th>입추예정</th>
						<th>출하예정</th>
						<th>출하</th>
					</thead>
					<tbody>
						<tr>
							<td>15</td>
							<td>4</td>
							<td>6</td>
							<td>27</td>
						</tr>
					</tbody>
				</table>
			</div>
					
		</div>
	</article>

	<article class="col-xl-8">
		<div class="jarviswidget jarviswidget-color-grey-dark" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
			<header>
				<div class="widget-header">	
					<h2><i class="fa fa-list"></i>&nbsp;&nbsp;&nbsp;호수별 입추 수 (단위 : 1000마리)</h2>	
				</div>
			</header>

			<div class="widget-body no-padding">

				<table class="table table-bordered table-hover" style="text-align: center;">
					<thead>
						<th>11호</th>
						<th>12호</th>
						<th>13호</th>
						<th>14호</th>
						<th>15호</th>
						<th>16호</th>
						<th>17호</th>
						<th>18호</th>
						<th>19호</th>
						<th>20호</th>
					</thead>
					<tbody>
						<tr>
							<td>30</td>
							<td>24</td>
							<td>12</td>
							<td>124</td>
							<td>45</td>
							<td>30</td>
							<td>30</td>
							<td>0</td>
							<td>60</td>
							<td>0</td>
						</tr>
					</tbody>
				</table>
				
			</div>
					
		</div>
	</article>
</div>


<!--입출하 일정 & 농가 지도-->
<div class="row">
	<article class="col-xl-7">
		<div class="jarviswidget jarviswidget-color-blue" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
			<header>
				<div class="widget-header">
					<span class="widget-icon"> <i class="fa fa-calendar"></i> </span>
					<h2> 입출하 일정</h2>						
				</div>
				<div class="widget-toolbar ml-auto">
					<!-- add: non-hidden - to disable auto hide -->
					<div class="form-inline">
						<a class="btn btn-default" href="javascript:void(0);" id="mt">Month</a>&nbsp;&nbsp;&nbsp;
						<a class="btn btn-default" href="javascript:void(0);" id="ag">Agenda</a>&nbsp;&nbsp;&nbsp;
						<a class="btn btn-default" href="javascript:void(0);" id="td">Today</a>&nbsp;&nbsp;&nbsp;
						<button class="btn btn-default" id="openModalBtn"><i class="fa fa-plus"></i></button>
					</div>
				</div>
			</header>

				<div class="widget-body no-padding">

					<div class="widget-body-toolbar text-right">

						<div id="calendar-buttons">

							<div class="btn-group">
								<a href="javascript:void(0)" class="btn btn-default btn-xs" id="btn-prev"><i class="fa fa-chevron-left"></i></a>
								<a href="javascript:void(0)" class="btn btn-default btn-xs" id="btn-next"><i class="fa fa-chevron-right"></i></a>
							</div>
						</div>

					</div>

					<div id="calendar"></div>

				</div>

		</div>
	</article>

	<article class="col-xl-5">
		<div class="jarviswidget jarviswidget-color-green-dark no-padding" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
			<header>
				<div class="widget-header">	
					<h2><i class="fa fa-map-marker"></i>&nbsp;&nbsp;&nbsp;농가 지도</h2>	
				</div>
			</header>
				
			<div class="widget-body">

				
				
			</div>
					
		</div>
	</article>

	


	<div id="modalBox" class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="myModalLabel"><b>일정 추가</b></h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
				</div>
				
				<div class="modal-body">
					
					<div class="col-xl-12">

						<div>

							<div class="widget-body">
								<!-- content goes here -->

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
									<!--<div class="form-actions">
										<div class="row">
											<div class="col-md-12">
												<button class="btn btn-default" type="button" id="add-event" >
													Add Event
												</button>
											</div>
										</div>
									</div>-->
								</form>

								<!-- end content -->
							</div>

						</div>
					</div>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-primary">확인</button>
					<button type="button" class="btn btn-default" id="closeModalBtn">취소</button>
				</div>
			</div>
		</div>
	</div>
</div>

<?
include_once("../inc/bottom.php");
?>

<script type="text/javascript">
	
	// 입출하 달력
	// DO NOT REMOVE : GLOBAL FUNCTIONS!
	
	$(document).ready(function() {
		
		$('#openModalBtn').on('click', function(){
			$('#modalBox').modal('show');
		});
			// 모달 안의 취소 버튼에 이벤트를 건다.
		$('#closeModalBtn').on('click', function(){
			$('#modalBox').modal('hide');
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
		
			var addEvent = function (title, priority, description, icon) {
				title = title.length === 0 ? "Untitled Event" : title;
				description = description.length === 0 ? "No Description" : description;
				icon = icon.length === 0 ? " " : icon;
				priority = priority.length === 0 ? "label label-default" : priority;
		
				var html = $('<li><span class="' + priority + '" data-description="' + description + '" data-icon="' +
					icon + '">' + title + '</span></li>').prependTo('ul#external-events').hide().fadeIn();
		
				$("#event-container").effect("highlight", 800);
		
				initDrag(html);
			};
		
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
			});
		
			/* initialize the calendar
				-----------------------------------------------------------------*/
		
			$('#calendar').fullCalendar({
		
				header: hdr,
				editable: true,
				droppable: true, // this allows things to be dropped onto the calendar !!!
		
				drop: function (date, allDay) { // this function is called when something is dropped
		
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
		
					// is the "remove after drop" checkbox checked?
					if ($('#drop-remove').is(':checked')) {
						// if so, remove the element from the "Draggable Events" list
						$(this).remove();
					}
		
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
				
				//달력에 표시되는 일정 들어가는 부분
				events: [],
		
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

		
			$('#calendar-buttons #btn-prev').click(function () {
				$('.fc-prev-button').click();
				return false;
			});
			
			$('#calendar-buttons #btn-next').click(function () {
				$('.fc-next-button').click();
				return false;
			});
			
			$('#calendar-buttons #btn-today').click(function () {
				$('.fc-today-button').click();
				return false;
			});	
				
			$('#mt').click(function () {
				$('#calendar').fullCalendar('changeView', 'month');
			});
			
			$('#ag').click(function () {
				$('#calendar').fullCalendar('changeView', 'agendaWeek');
			});
			
			$('#td').click(function () {
				$('#calendar').fullCalendar('changeView', 'agendaDay');
			});			
	
	})

	</script>