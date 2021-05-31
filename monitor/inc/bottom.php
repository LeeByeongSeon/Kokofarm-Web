
						</section>

					</div> <!-- END .d-flex w-100 -->

				</div> <!-- END .sa-content -->
    
				<footer class="sa-page-footer"> <!-- BEGIN .sa-page-footer -->
					<div class="d-flex align-items-center w-100 h-100">
						<div class="footer-left">
							<span class="txt-color-white">KOKOFARM <span class="hidden-xs"> : Copyright</span> © 2019 EMOTION Co., Ltd. All rights reserved.</span>
						</div>
					</div>
				</footer> <!-- END .sa-page-footer -->
      
			</div> <!-- END .sa-content-wrapper -->
      
		</div> <!-- END .sa-page-body -->

	</div> <!-- END .sa-wrapper -->

	<!--Modal Alert-->
	<div id="modal_alert" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="top:20%">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 id="modal_alert_title" class="modal-title">Modal title</h4>
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
	<div id="modal_confirm" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="top:20%">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 id="modal_confirm_title" class="modal-title">Modal title</h4>
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

<script>
	$(document).ready(function(){
		//농장 목록 트리뷰 (임시 제한)
		if($('div').hasClass('fullSc')){
			$("#treeView").css("display","none");
		}

	});
</script>