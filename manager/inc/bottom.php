
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

	<!--Modal Camera-->
	<div id="modal_camera" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="top:20%">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 id="modal_camera_title" class="modal-title float-right">Modal title</h4>
                    <button type="button" class="close float-left" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div id="modal_camera_body" class="modal-body">
					<img class="img-responsive" id="modal_camera_img" src="../images/noimage.jpg" style="opacity: 1.0; filter: alpha(opacity=100); margin:auto">
                </div>
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-primary" id="modal_camera_plus" onClick="zoom('+')">확대</button>
					<button type="button" class="btn btn-primary" id="modal_camera_minus" onClick="zoom('-')">축소</button> -->
                    <button type="button" class="btn btn-danger" data-dismiss="modal" id="modal_camera_cancle" onClick="camera_modal_close()">닫기</button>
                </div>
            </div><!--modal-content -->
        </div><!--modal-dialog -->
    </div><!--modal -->

	<!----Loading Circle-->
	<div id="loading_circle" style="display:none;"><ul id="loading_img"><img src="../images/loading_circle.gif"></ul></div>
	<a id="scroll_top_btn" href="#" class="btn btn-lg btn-circle bg-orange text-white" role="button" style="cursor: pointer; position: fixed; bottom: 3%; right: 3%; display:none; z-index:999; opacity:0.9"><span class="fa fa-arrow-up font-md pt-3"></span></a>
</body>
</html>

<script src="../common/library/vendors/vendors.bundle.js"></script>
<script src="../common/library/app/app.bundle.js"></script>

<!--BOOTSTRAP Table-->
<script src="../common/library/bootstrap_table/bootstrap-table.js"></script>

<script>
	$(document).ready(function(){
		// TOP버튼
		$(window).scroll(function(){
			if($(this).scrollTop() > 50) {
				// $('#scroll_top_btn').fadeIn().hide(3000, 'linear');
				$('#scroll_top_btn').show().delay(2000).fadeOut();
			}
			else {
				$('#scroll_top_btn').fadeOut();
			}
		});
		$('#scroll_top_btn').click(function(){
			$('#scroll_top_btn').hide();
			$('body,html').animate({scrollTop: 0}, 800);
			return false;
		});
		//$('#scroll_top_btn').show();

		// 상세메뉴 열렸을때 상세메뉴 제외 영역 클릭 시 닫힘
		$('.sa-page-body').children().not('.sa-aside-left').on("mouseover", function(e){
			if($('body').hasClass('sa-hidden-menu')){
				$('body').removeClass('sa-hidden-menu');
			}
		});
		$(window).on("scroll", function(){ 
			if($('body').hasClass('sa-hidden-menu')){
				$('body').removeClass('sa-hidden-menu');
			}
		});
		
	});
</script>