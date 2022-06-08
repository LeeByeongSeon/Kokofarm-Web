<?
include_once("../common/php_module/common_func.php");

$code = isset($_REQUEST["code"]) ? $_REQUEST["code"] : "";
$farm = explode("_", $code)[1];
$farm = substr($farm, 0, 6);

$select_query = "SELECT be.*, IFNULL(DATEDIFF(IF(cm.cmOutdate is null, current_date(), cm.cmOutdate), cm.cmIndate) + 1, 0) AS interm, 
                cm.cmInsu, cm.cmDeathCount, cm.cmCullCount, cm.cmThinoutCount, sf.sfDongid, sf.sfFeed, sf.sfFeedMax
                FROM buffer_sensor_status AS be
                LEFT JOIN set_feeder AS sf ON sf.sfFarmid = be.beFarmid AND sf.sfDongid = be.beDongid
                LEFT JOIN comein_master AS cm ON cm.cmCode = be.beComeinCode
                WHERE beFarmid = \"" .$farm. "\"";

$init_data = get_select_data($select_query);

$dong_list_html="";

foreach($init_data as $val){

	$inout = $val["beStatus"] == "O" ? "출하" : "입추";

	$dong_list_html .= "<div class='row'>";
	$dong_list_html .= "	<div class='col-xs-12'>";
	$dong_list_html .= "		<div class='jarviswidget jarviswidget-color-white no-padding mb-3' data-widget-editbutton='false' data-widget-colorbutton='false' data-widget-deletebutton='false' data-widget-fullscreenbutton='false' data-widget-togglebutton='false'>";
	$dong_list_html .= "			<div class='widget-body no-padding form-inline move_dong' style='border-radius: 10px; border : 4px solid #eee; border-top: 0;' onClick='move_dong(\"".$val["beComeinCode"]."\", \"". $inout ."\" )'>";
	$dong_list_html .= "				<div class='col-xs-2 text-center no-padding'><p><span class='fong-md font-weight-bold' style='font-size:20px'>".$val["beDongid"]."동</span></p><span id=''>".$val["interm"]."일령</span></div>";
	$dong_list_html .= "				<div class='col-xs-3 text-center no-padding'><p><span class='fong-md font-weight-bold' style='font-size:12px' >평균중량</span></p><span class='font-lg text-danger font-weight-bold'>".sprintf('%0.1f', $val["beAvgWeight"])."g</span></div>";
	//$dong_list_html .= "				<div class='col-xs-1 text-center no-padding'><i class='fa fa-circle text-success'></i></div>";

	if($val["beStatus"] == "O"){
		$dong_list_html .= "			<div class='col-xs-3 text-center no-padding'>
											<span class='font-lg text-danger font-weight-bold'>출하상태</span>
										</div>";
	}
	else if($val["sfDongid"] == ""){
		$dong_list_html .= "			<div class='col-xs-3 text-center no-padding'>
											<p><span class='fong-md font-weight-bold' style='font-size:12px' >평균온도</span></p>
											<span class='font-lg font-weight-bold'>".sprintf('%0.1f', $val["beAvgTemp"])."℃</span>
										</div>";
	}
	else{
		// 사료빈 이미지 넣기
		$dong_list_html .= "				<div class='col-xs-3 text-center no-padding'><img src='";
		if($val["sfFeed"]>0){
			$per = round($val["sfFeed"] / $val["sfFeedMax"] * 100);
		}
		if($per <= 10)						$dong_list_html .= "../images/feed-00.png'";
		else if($per > 10 && $per <= 35)	$dong_list_html .= "../images/feed-01.png'";
		else if($per > 35 && $per <= 65)	$dong_list_html .= "../images/feed-02.png'";
		else if($per > 65 && $per <= 90)	$dong_list_html .= "../images/feed-03.png'";
		else if($per > 90)					$dong_list_html .= "../images/feed-04.png'";
		$dong_list_html .= "' style='width:40px'> <p><span class='fong-md font-weight-bold' style='font-size:12px'>" . $val["sfFeed"] . "(Kg)</span></p> </div>";
	}

	$dong_list_html .= "				<div class='col-xs-1 text-center no-padding'><i class='fa fa-circle text-success'></i></div>";

	$live_count = $val["cmInsu"] - $val["cmDeathCount"] - $val["cmCullCount"] - $val["cmThinoutCount"];

	$dong_list_html .= "				<div class='col-xs-3 text-center no-padding'><p><span class='fong-md font-weight-bold' style='font-size:12px'>생존수 : ".$live_count."</span></p>";
	$dong_list_html .= 					"<button class='btn btn-default move_breed' onClick='move_breed(\"".$val["beComeinCode"]."\", \"". $inout ."\" )' style='border-color:white'><i class='fa fa-pencil-square-o font-lg text-secondary'></i></button></div>"; 
	$dong_list_html .= "</div></div></div></div>";
}

echo json_encode($dong_list_html);

?>