
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
					<button type="button" class="btn btn-primary" data-dismiss="modal"><span class="KKF-32">닫기</span></button>
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
                    <button type="button" class="btn btn-primary" data-dismiss="modal" id="modal_confirm_ok"><span class="KKF-33">확인</span></button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" id="modal_confirm_cancle"><span class="KKF-34">취소</span></button>
                </div>
            </div><!--modal-content -->
        </div><!--modal-dialog -->
    </div><!--modal -->

</body>
</html>

<script src="../common/library/vendors/vendors.bundle.js"></script>
<script src="../common/library/app/app.bundle.js"></script>

<!--BOOTSTRAP Table-->
<script src="../common/library/bootstrap_table/bootstrap-table.js"></script>

<!-- date & time picker-->
<script src="../common/library/bootstrap_datepicker/bootstrap-datepicker.js" type="text/javascript"></script>
<script src="../common/library/bootstrap_clockpicker/bootstrap-clockpicker.js" type="text/javascript"></script>


<script language="javascript">
	
	$(document).ready(function(){

		//상단 시계
		setInterval(function(){$("#clock_now").html("&nbsp;"+get_now_time());});
		
		change_lang(curr_lang);
	});

	var get_lang = get_lang().split("-"); // ko-KR
	var curr_lang = get_lang[0];		  // ko
	
	// 현재 local language 가져옴
	function get_lang(){
		return navigator.language || navigator.userLanguage;
	}

	// 번역
	function change_lang(curr_lang){
		$.getJSON("../common/kkf_lang/KKF_lang.json", function(data){
			$.each(data, function(idx, obj){
				// switch(curr_lang){
				// 	case "ko" :
				// 		$("."+idx).html(obj.KR);

				// 		break;
				// 	case "en" :
				// 		$("."+idx).html(obj.EN);
				// 		break;
				// }
				if(curr_lang == 'ko'){
					$("."+idx).html(obj.KR);
				} else {
					$("."+idx).html(obj.EN);
				}
			})
		});
	}

</script>