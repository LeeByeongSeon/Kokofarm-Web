<?

include_once("../../common/php_module/common_func.php");

$response = array();

// 어떤 작업인지 가져옴
$oper = isset($_REQUEST["oper"]) ? $oper = check_str($_REQUEST["oper"]) : "";

switch($oper){
	case "get_request_list":

        //검색필드
        $append_query = "";
        if(isset($_REQUEST["search_stat"])){
            $search_stat = check_str($_REQUEST["search_stat"]);
            $search_stat = explode("(", $search_stat)[0];
            $append_query .= $search_stat != "" ? " AND rcStatus = \"" .$search_stat. "\"" : "";
        }

        if(isset($_REQUEST["search_name"])){
            $search_name = check_str($_REQUEST["search_name"]);
            $append_query .= " AND fdName LIKE \"%" .$search_name. "%\"";
        }
		
        $select_query = "SELECT rc.*, fd.fdName FROM request_calculate AS rc 
                        JOIN farm_detail AS fd ON fd.fdFarmid = rc.rcFarmid AND fd.fdDongid = rc.rcDongid
                        WHERE rcFarmid = rcFarmid " . $append_query;

        $select_data = get_select_data($select_query);

        $request_list = array();
        foreach($select_data as $val){

			$rcCommand = $val["rcCommand"];
			$rcCommand = str_replace("Lst", "축종", $rcCommand);
			$rcCommand = str_replace("Day", "일령", $rcCommand);
			$rcCommand = str_replace("Opt", "최적화", $rcCommand);

			$request_list[] = array(
				"rcFarmid" =>		$val["rcFarmid"],
				"rcDongid" =>		$val["rcDongid"],
                "rcCode" =>		    $val["rcCode"],
				"fdName" =>			$val["fdName"],
				"rcRequestDate" =>	$val["rcRequestDate"],
				"rcCommand" =>		$rcCommand,
				"rcStatus" =>		$val["rcStatus"],
			);

		}
		$response["request_list"] = $request_list;

        echo json_encode($response);

		break;

    case "get_detail_data":
        $farmID = $_REQUEST["farmID"];
		$dongID = $_REQUEST["dongID"];
		$requestDate = $_REQUEST["requestDate"];

        $select_query = "SELECT fdFarmid, fdName, fdTel, rc.*,
                            IFNULL(DATEDIFF(current_date(), rcPrevDate) + 1, 0) AS prevDate, 
                            IFNULL(DATEDIFF(current_date(), rcChangeDate) + 1, 0) AS changeDate,
                            IFNULL(aw.awWeight, 0) AS awWeight
                        FROM request_calculate AS rc
                        JOIN farm_detail AS fd ON fd.fdFarmid = rcFarmid AND fd.fdDongid = rcDongid
                        LEFT JOIN avg_weight AS aw ON aw.awFarmid = rcFarmid AND aw.awDongid = rcDongid AND aw.awDate = CONCAT(LEFT(rcMeasureDate, 15), '0:00')
                        WHERE rcFarmid = \"" . $farmID . "\" AND rcDongid = \"" . $dongID . "\" AND rcRequestDate = \"" . $requestDate . "\"";

        $select_data = get_select_data($select_query);

        $detail_html = "<div style='padding-top:10px;padding-bottom:10px'>
                        <!---농장정보---->
                        <div class='alert alert-info' role='alert'>
                            <i class='fa-fw fa fa-bookmark'></i><strong>&nbsp;&nbsp;농장정보</strong>
                        </div>
                        <p>농장 : " . $select_data[0]["fdName"] . " [" . $select_data[0]["fdFarmid"] . "]</p>
                        <p>전화 : " . $select_data[0]["fdTel"] . "</p>

                        <!---평균중량---->
                        <div class='alert alert-success' role='alert'>
                            <i class='fa-fw fa fa-info'></i><strong>&nbsp;&nbsp;재산출 요청</strong>
                        </div>
                        <div class='row'>
                            <div class='col-xs-12'>";

        $rcCommand = $select_data[0]["rcCommand"];
        $comms = explode("|", $rcCommand);

        foreach($comms as $val){
			switch($val){
				case "Lst":		//축종변경
					$detail_html .= 	"<div class='well' style='padding:5px;'>
										<div class='col-xs-12 no-padding' style='text-align:center'>
											축종 변경
										</div>
										<div class='col-xs-5 no-padding' style='text-align:center'>
											<p style='font-size:18px; font-weight:bold'>" .  $select_data[0]["rcPrevLst"] . "</p>
										</div>
										<div class='col-xs-2 no-padding' style='text-align:center'>
											<i class='fa-fw fa fa-arrow-right'></i>
										</div>
										<div class='col-xs-5 no-padding' style='text-align:center'>
											<p style='font-size:18px; font-weight:bold; color:#B90000;'>" .  $select_data[0]["rcChangeLst"] . "</p>
										</div>
										<div style='clear:both'></div>
									</div><!--well-->";
					break;

				case "Day":
					$detail_html .= 	"<div class='well' style='padding:5px;'>
										<div class='col-xs-12 no-padding' style='text-align:center'>
											일령 변경
										</div>
										<div class='col-xs-5 no-padding' style='text-align:center'>
											<p style='font-size:13px; font-weight:bold;'>" .  $select_data[0]["rcPrevDate"] . "<br>
											(" . $select_data[0]["prevDay"] . " 일령)</p>
										</div>
										<div class='col-xs-2 no-padding' style='text-align:center'>
											<i class='fa-fw fa fa-arrow-right'></i>
										</div>
										<div class='col-xs-5 no-padding' style='text-align:center'>
											<p style='font-size:13px; font-weight:bold; color:#B90000'>" .  $select_data[0]["rcChangeDate"] . "<br>
											(" . $select_data[0]["changeDay"] . " 일령)</p>
										</div>
										<div style='clear:both'></div>
									</div><!--well-->";
					break;

				case "Opt":
					$detail_html .= 	"<div class='well' style='padding:5px;'>
										<div class='col-xs-12 no-padding' style='text-align:center'>
											평균중량 최적화
										</div>
										<div class='col-xs-5 no-padding' style='text-align:center'>
											<p style='font-size:13px; font-weight:bold;'>예측값 : " .  substr($select_data[0]["awWeight"], 0, -3) . "<br>
											(" .  substr($select_data[0]["rcMeasureDate"], 0, 15) . "0:00)</p>
										</div>
										<div class='col-xs-2 no-padding' style='text-align:center'>
											<i class='fa-fw fa fa-arrow-right'></i>
										</div>
										<div class='col-xs-5 no-padding' style='text-align:center'>
											<p style='font-size:13px; font-weight:bold; color:#B90000'>실측값 : " .  $select_data[0]["rcMeasureVal"] . "<br>
											(" .  $select_data[0]["rcMeasureDate"] . ")</p>
										</div>
										<div style='clear:both'></div>
									</div><!--well-->";
					break;
			}
		}

		$detail_html .= 			"</div><!--col-xs-12-->
							</div><!--row-->

							<br>

							<!---승인버튼---->
							<div class='col-xs-12 no-padding' style='text-align:right'>
								<button type='button' class='btn btn-primary btn-sm request_confirm' confirm='Y' request_info='" . $select_data[0]["rcFarmid"] . "|" . $select_data[0]["rcDongid"]  . "|" . $select_data[0]["rcRequestDate"] . "|" . substr($select_data[0]["awWeight"], 0, -3) . "'>
								<span class='glyphicon glyphicon-ok'></span>&nbsp;&nbsp;승인</button>&nbsp;

								<button type='button' class='btn btn-danger btn-sm request_confirm' confirm='N' request_info='" . $select_data[0]["rcFarmid"] . "|" . $select_data[0]["rcDongid"]  . "|" . $select_data[0]["rcRequestDate"] . "|" . substr($select_data[0]["awWeight"], 0, -3) . "'>
								<span class='glyphicon glyphicon-remove'></span>&nbsp;&nbsp;거절</button>
							</div>

					</div>";

		$response["detail_html"] = $detail_html;
		$response["fdName"] = $select_data[0]["fdName"];

        echo json_encode($response);

        break;

    case "approve":
        $info = $_REQUEST["info"];
		$status = $_REQUEST["status"];

		$tokens = explode("|", $info);
		$farmID = $tokens[0];
		$dongID = $tokens[1];
		$requestDate = $tokens[2];
		$prevWeight = $tokens[3];

		$select_query = "SELECT rcStatus FROM request_calculate WHERE rcFarmid = \"" . $farmID . "\" AND rcDongid = \"" . $dongID . "\" AND rcRequestDate = \"" . $requestDate . "\"";
		$select_data = get_select_data($select_query);

		if($select_data[0]["rcStatus"] == "R"){
            $update_map = array();
			$update_map['rcStatus'] = $status;
			$update_map['rcApproveDate'] = date("Y-m-d H:i:s");
			$update_map['rcPrevWeight'] = $prevWeight;

            run_sql_update("request_calculate", $update_map, "rcFarmid = '" . $farmID . "' AND rcDongid = '" . $dongID . "' AND rcRequestDate = '" . $requestDate . "'");
			$response['result'] = "ok";
		}
		else{
			$response['result'] = "fail";
			$response['errMsg'] = "이미 처리된 요청입니다.";
		}

        echo json_encode($response);

        break;
}

?>