<?
include_once("../inc/top.php")
?>
	
<div class="row">
	<div class="col-xs-12">
		<div class="jarviswidget jarviswidget-color-white no-padding" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">							
			<header style="border-radius: 10px 10px 0 0">
				<div class="widget-header">	
					<h2 class="font-weight-bold text-primary"><i class="fa fa-pencil-square-o text-warning"></i>&nbsp;&nbsp;재산출 요청</h2>	
				</div>
			</header>
			<div class="widget-body shadow" style="border-radius: 0 0 10px 10px; padding:0.5rem">
				<form onsubmit="return false;">
					<div class="col-xs-12 text-center">
						<h3 class="font-weight-bold text-primary" style="margin:0.5rem">일령변경<br><small>현재 입추 시간 : 0000-00-00 00:00</small></h3>
						<div class="input-group mb-3">
							<span class="input-group-text font-weight-bold" id="basic-addon1">입추일자</span>
							<input type="text" class="form-control" aria-label="입추시간" aria-describedby="basic-addon1">
						</div>
						<div class="input-group mb-3">
							<span class="input-group-text font-weight-bold" id="basic-addon1">입추시간</span>
							<input type="text" class="form-control" placeholder="시" aria-label="시">
							<span class="input-group-text font-weight-bold">:</span>
							<input type="text" class="form-control" placeholder="분" aria-label="분">
						</div>
					</div>
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
							<span class="input-group-text font-weight-bold" id="basic-addon1" style="width: 73.5px">입추 수</span>
							<input type="text" class="form-control" aria-label="입추 수" aria-describedby="basic-addon1">
						</div>
					</div>
					<div class="col-xs-12 text-center">
						<h3 class="font-weight-bold text-primary" style="margin:0.5rem">평균중량 재산출</h3>
						<div class="input-group mb-3">
							<span class="input-group-text font-weight-bold" id="basic-addon1">실측일자</span>
							<input type="text" class="form-control" aria-label="실측일자" aria-describedby="basic-addon1">
						</div>
						<div class="input-group mb-3">
							<span class="input-group-text font-weight-bold" id="basic-addon1">실측시간</span>
							<input type="text" class="form-control" placeholder="시" aria-label="시">
							<span class="input-group-text font-weight-bold">:</span>
							<input type="text" class="form-control" placeholder="분" aria-label="분">
						</div>
						<div class="input-group mb-3">
							<span class="input-group-text font-weight-bold" id="basic-addon1" style="width: 73.5px">실측값</span>
							<input type="text" class="form-control" aria-label="실측값" aria-describedby="basic-addon1">
						</div>
						<div class="col-xs-12 text-right no-padding">
							<button type="submit" class="btn btn-primary">요청</button>
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

</script>