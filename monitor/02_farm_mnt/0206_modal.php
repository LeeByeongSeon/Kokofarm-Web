    <style>
        #detail_tb > thead > tr > th{ text-align: center; background-color: #b9cdcd;}
		#detail_tb > tbody > tr > th{ text-align: center; background-color: #b9cdcd;}
    </style>

	<!--Modal Confirm-->
	<div id="modal_detail" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="top:15%">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header" style="background-color: #558887;">
					<h4 id="modal_detail_title" class="modal-title text-white font-weight-bold"><span id="fdName">농장명</sapn>&nbsp;&nbsp;<small class="text-white" id="dmDate">작성일 0000-00-00 00:00:00</small></h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="color: white">×</button>
				</div>
				<div id="modal_detail_body" class="modal-body" style="padding: 1rem;">
					<table class="table" id="detail_tb">
						<thead>
							<tr>
								<th>발생일</th><td id="dmStartDate"></td>
								<th>종결일</th><td id="dmEndDate"></td>
							</tr>
							<tr>
								<th>담당자</th><td id="dmActor"></td>
								<th>조치상태</th><td id="dmStatus"></td>
							</tr>
							<tr>
								<th>작성구분</th><td id="dmWrite"></td>
								<th>결함구분</th><td id="dmDefect"></td>
							</tr>
							<tr>
								<th>발생장치</th><td id="dmDevice"></td>
								<th>버전(제품)</th><td id="dmDeviceVer"></td>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th>문제점(현상)</th><td colspan="3" id="dmProblem"></td>
							</tr>
							<tr>
								<th>원인(추정)</th><td colspan="3" id="dmCause"></td>
							</tr>
							<tr>
								<th>조치내용</th><td colspan="3" id="dmAction"></td>
							</tr>
							<tr>
								<th>기타</th><td colspan="3" id="dmOthers"></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div><!--modal-content -->
		</div><!--modal-dialog -->
	</div><!--modal -->