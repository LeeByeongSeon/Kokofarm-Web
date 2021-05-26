<?
include_once("../inc/top.php");
?>

<!--농가별 현황-->
<article class="col-xl-12 no-padding">
	<div class="jarviswidget jarviswidget-color-teal fullSc no-padding" id="wid-id-1" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
		<header>
			<div class="widget-header">	
				<h2><i class="fa fa-file-text-o"></i>&nbsp;&nbsp;&nbsp;농가별 현황</h2>	
			</div>
		</header>

		<div class="widget-body">
			
			<table id="summary_table" data-page-list="[]" data-pagination="true" data-page-list="false" data-page-size="30" data-toggle="table" style="font-size:14px">
				<thead>
					<tr>
						<th data-sortable="true" data-field='f1' data-visible="true">농장명</th>
						<th data-sortable="true" data-field='f2' data-visible="true">일령</th>
						<th data-sortable="true" data-field='f3' data-visible="true">축종</th>

						<th data-sortable="false" data-field='f4' style="word-wrap: break-word">IoT저울</th>
						<th data-sortable="false" data-field='f5' data-align="center">온도(℃)</th>
						<th data-sortable="false" data-field='f6' data-align="center">습도(%)</th>
						<th data-sortable="false" data-field='f7' data-align="center">CO2(ppm))</th>
						<th data-sortable="false" data-field='f8' data-align="center">NH3(ppm)</th>

						<th data-sortable="true" data-field='f9' data-align="center">환경경보</th>
						<th data-sortable="true" data-field='f10' data-align="center">평균중량(권고대비)</th>
						<th data-sortable="true" data-field='f11' data-align="center">네트워크</th>

						<th data-sortable="true" data-field='f12' data-align="center">PLC 제어</th>
						<th data-sortable="true" data-field='f13' data-align="center">PLC 환경</th>
						<th data-sortable="true" data-field='f14' data-align="center">급이/급수</th>
						<th data-sortable="true" data-field='f15' data-align="center">외기환경</th>
					</tr>
				</thead>
			</table>
			
		</div>
				
	</div>
</article>
	
<?
include_once("../inc/bottom.php");
?>

<script language="javascript">
	var timer_interval;	
	var timer_count;

	$(document).ready(function(){
		get_data();

		//Timer
		timer_count=0; clearInterval(timer_interval);
		timer_interval= setInterval(function(){
			timer_count++;
			if(timer_count >= 60) { 
				timer_count=0; 
				get_data(); 
			}
			else{ 
				var updatePer = parseInt(timer_count / 60 * 100); $("#stateBar").css('width', updatePer + "%"); 
				$("#stateBar").html(updatePer + "%"); $("#stateBar").parent().attr("data-original-title",updatePer + "%"); }
		},1000);
	});

	function get_data(){
		var data_arr = {}; 
		data_arr['oper'] = "get_data";

		$.ajax({url:'0101_action.php', data:data_arr, cache:false, type:'post', dataType:'json',
			success: function(data) {
				//$.each(data.alertLevelCNT,function(key,value){ $("#" + key).html(value); }); //경보단계별 갯수
				$('#summary_table').bootstrapTable('load', data.summary_data); //data-toggle="table" 하지않으면 Update 불가
			}
		});
	};

	//sparkline binding 처리
	$('#summary_table').on('post-body.bs.table', function (e, rowData, $element) {
		$(".sparkLine").each(function(index,element) {
			var data1=$(this).attr("data-bar-val").split(",");
			var data2=$(this).attr("data-line-val").split(",");
			$(this).sparkline(data1,{type:'bar',barColor:'#496949',width:100,height:20});
			$(this).sparkline(data2,{type:'line',composite:'true',fillColor:false,lineColor:'red',lineWidth:1});
		});
	});
</script>