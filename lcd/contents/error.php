
<!DOCTYPE html>

<html lang="en-us" class="smart-style-6">
<head>
	<title>KOKOFARM RENEWAL</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  	<!--<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,500,700">-->
  	<link rel="stylesheet" href="../../common/library/fonts/font.css"> <!--Google fonts-->
	
	<script src="../../common/library/jquery/jquery.min.js"></script>						<!-- jQuery -->
	<script src="../../common/library/jquery/jquery-ui-1.10.3.min.js"></script>				<!-- jQuery UI-->
	<script src="../../common/library/bootstrap/bootstrap.min.js"></script>					<!-- BOOTSTRAP JS -->
	<script src="../../common/library/smartwidgets/jarvis.widget.min.js"></script>			<!-- JARVIS WIDGETS -->
	<script src="../../common/library/plugin/sparkline/jquery.sparkline.min.js"></script>	<!-- SPARKLINES -->
	
	<!-- FAVICONS -->
	<link rel="shortcut icon" href="../images/icon.png" type="image/x-icon">
	<link rel="icon" href="../images/icon.png" type="image/x-icon">
	
	<!-- BOOTSTRAP CSS -->
	<link rel="stylesheet" type="text/css" media="screen" href="../../common/library/bootstrap/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" media="screen" href="../../common/library/fonts/font-awesome.min.css"> 

	<!--editable Table-->
	<script src='../../common/library/editable_table/mindmup-editabletable.js'></script>
	<script src='../../common/library/editable_table/numeric-input-example.js'></script>
	<script src="../../common/library/editable_table/external/adamwdraper/numeral.min.js"></script>
	
	<!-- jQuery Grid -->
	<script src="../../common/library/jqgrid/jquery.jqGrid.min.js" type="text/javascript"></script>     	<!--JQGrid-->
	<script src="../../common/library/jqgrid/i18n/grid.locale-kr.js" type="text/javascript"></script>  		<!--JQGrid:Language-->
	<link rel="stylesheet" type="text/css" href="../../common/library/jqgrid/ui.jqgrid-bootstrap.css">  	<!--JQGrid:CSS--->

	<!--amChart-->
	<script src="../../common/library/amchart/amcharts.js" type="text/javascript"></script>
	<script src="../../common/library/amchart/serial.js" type="text/javascript"></script>
	<script src="../../common/library/amchart/lang/ko.js" type="text/javascript"></script>

	<!-- myDefined JS-->
	<script src="../../common/library/my_define/my_define.js"></script>
	<link rel="stylesheet" type="text/css" href="../../common/library/my_define/my_define.css">

	<!--Template CSS-->
	<link rel="stylesheet" media="screen, print" href="../../common/library/vendors/vendors.bundle.css">
	<link rel="stylesheet" media="screen, print" href="../../common/library/app/app.bundle.css">
	<link rel="stylesheet" type="text/css" href="../../common/library/pages/homepage.css">
	<link rel="stylesheet" type="text/css" href="../../common/library/pages/forms.css">
	<link rel="stylesheet" type="text/css" href="../../common/library/pages/buttons.css">

	<!-- date & time picker-->
	<link rel="stylesheet" href="../../common/library/bootstrap_datepicker/datepicker.css">
	<link rel="stylesheet" href="../../common/library/bootstrap_clockpicker/bootstrap-clockpicker.css">
	<script src="../../common/library/bootstrap_datepicker/bootstrap-datepicker.js" type="text/javascript"></script>
	<script src="../../common/library/bootstrap_clockpicker/bootstrap-clockpicker.js" type="text/javascript"></script>

	<!--BOOTSTRAP Table-->
	<link rel="stylesheet" href="../../common/library/bootstrap_table/bootstrap-table.css"/>

	<!--common-->
	<script src="../../common/js_module/common_func.js"></script>
	
<style>
	*{-webkit-text-size-adjust:none;}
</style>
</head>

<body class="smart-style-6">

	<div class="sa-wrapper">

		<div class="sa-page-body">
		
			<div class="sa-content-wrapper" style="margin:0">
        
				<div class="sa-content no-padding">

					<div class="d-flex w-100">
						<section id="widget-grid" class="w-100">

                            <div class="text-center" style="margin-top:15rem;">
                                <!-- <code>Login Error :(</code><br><br> -->
                                <h1 class="error-text shake animated font-weight-bold text-danger"> <img class="img-reponsive" src="../images/logo2.png" style="width: 20rem"> <em class="fa fa-warning"></em></h1>
                                <br><br><h5 class="font-weight-bold m-0"> 존재하지않는 계정입니다.</h5><br><h6 class="font-weight-bold m-0"> 관리자에게 문의 바랍니다.</h6>
                            </div>

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

</body>
</html>

<script src="../../common/library/vendors/vendors.bundle.js"></script>
<script src="../../common/library/app/app.bundle.js"></script>

<!--BOOTSTRAP Table-->
<script src="../../common/library/bootstrap_table/bootstrap-table.js"></script>