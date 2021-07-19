<?

include_once("../../common/php_module/common_func.php");
include_once("../../common/php_module/socket_func.php");

$response = array();

// 어떤 작업인지 가져옴
$oper = isset($_REQUEST["oper"]) ? $oper = check_str($_REQUEST["oper"]) : "";

// cmCode에서 농장, 동 id 추출
if(isset($_REQUEST["code"])){
    $code = $_REQUEST["code"];
    $id = explode("_", $code)[1];
    $farmID = substr($id, 0, 6);
    $dongID = substr($id, 6);
}

switch($oper){

    case "get_code":
        if(isset($_REQUEST["select"]) && $_REQUEST["select"] != ""){
            $select = $_REQUEST["select"];
            $ids = explode("|", $select);
            
            $append_query = "cmFarmid = \"" . $ids[0] . "\"";

            $append_query .= " AND cmDongid = \"" .(isset($ids[1]) ? $ids[1] : "01" ). "\"";      // 농장버튼 클릭시 해당 농장 1동을 가져와서 출력

            $select_query = "SELECT * FROM comein_master WHERE " . $append_query . " ORDER BY cmIndate DESC LIMIT 1";

            $select_data = get_select_data($select_query);

            $response["code"] = $select_data[0]["cmCode"];
            $response["cmIndate"] = $select_data[0]["cmIndate"];
            $response["cmOutdate"] = $select_data[0]["cmOutdate"];

            echo json_encode($response);
        }

        break;

	case "get_avg_weight":          //평균중량

        //$now = date("Y-m-d H:i:s");

        //$term_query = $_REQUEST["term"] == "time" ? "RIGHT(aw.awDate, 5) = '00:00' " : "RIGHT(aw.awDate, 8) = '" . substr(get_term_date($now, "-30"), 11, 4) . "0:00'";

        // $select_query = "SELECT cm.cmCode, aw.*, c.cName3 AS refWeight FROM comein_master AS cm 
        //                 JOIN avg_weight AS aw ON aw.awFarmid = cm.cmFarmid AND aw.awDongid = cm.cmDongid AND " .$term_query. "
        //                 AND (awDate BETWEEN cm.cmIndate AND IFNULL(cm.cmOutdate, NOW()))
        //                 LEFT JOIN codeinfo AS c ON c.cGroup = '권고중량' AND c.cName1 = cm.cmIntype AND c.cName2 = aw.awDays
        //                 WHERE cm.cmCode = \"" .$code. "\" ORDER BY aw.awDate DESC";

        $avg_history = get_avg_history($code, $_REQUEST["term"], "all");

        switch($_REQUEST["comm"]){
            case "view":
                $response["avg_weight_table"] = $avg_history["table"];
                $response["avg_weight_chart"] = $avg_history["chart"];

                echo json_encode($response);
                break;
            
            case "excel":
                $title = $farmID . "_" . $dongID . "_평균중량";

                header("Content-Type: application/vnd.ms-excel");
                header("Expires: 0");
                header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
                header("content-disposition: attachment; filename=" . date('Ymd_His') . "_" . $title . ".xls");

                $field_data = array(
                    /*농가 정보*/
                    array("번호",       "No", "INT", "center"),
                    array("농장ID",     "awFarmid", "STR", "center"),
                    array("동ID",       "awDongid", "STR", "center"),
                    array("산출시간",   "awDate", "STR", "center"),
                    array("예측중량",   "awWeight", "STR", "center"),
                    array("권고중량",   "refWeight", "STR", "center"),
                    array("표준편차",   "awDevi", "STR", "center"),
                    array("변이계수",   "awVc", "STR", "center"),
                    array("+1 예측",    "awEstiT1", "STR", "center"),
                    array("+2 예측",    "awEstiT2", "STR", "center"),
                    array("+3 예측",    "awEstiT3", "STR", "center"),
                    array("일령",       "awDays", "STR", "center"),
                    array("정규분포",   "awNdis", "STR", "left"),
                );

                //echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
                convert_excel(get_select_data($avg_history["query"]), $field_data, $title, $code);
                break;
        }

		break;

    case "get_error_history":          //오류이력 - 추후에 입추기간만 가져오게 변경
    
        $append_query = "AND ccFarmid = \"" . $farmID . "\" AND ccDongid = \"" . $dongID . "\" ORDER BY ccCapDate DESC";

        $select_query = "SELECT * FROM capture_camera WHERE ccFarmid = ccFarmid " . $append_query;

        $select_data = get_select_data($select_query);

        $error_history_data = array();
        foreach($select_data as $row){
            $error_history_data[] = array(
                'f1'  => $row["ccCapDate"],							
                'f2'  => $row["ccStatus"],									
                'f3'  => "01",									
            );
        }

        $response["error_history_data"] = $error_history_data;
        echo json_encode($response);

        break;

    case "get_request_history":          //재산출 이력

        $select_query = "SELECT * FROM request_calculate WHERE rcFarmid = \"" . $farmID . "\" AND rcDongid = \"" . $dongID . "\" 
                        AND (rcRequestDate BETWEEN \"" . $_REQUEST["indate"] . "\" AND \"" . date('Y-m-d H:i:s') . "\") ORDER BY rcRequestDate DESC";

        $select_data = get_select_data($select_query);

        $request_history_data = array();
        foreach($select_data as $row){

            $change_status = "";
            $change_str = "";

            $checker = explode("|", $row["rcCommand"]);

            if(in_array("Day", $checker)){
                $change_str .= (strlen($change_str) > 2 ? "<br>" : "") . $row["rcPrevDate"] . " -> " . $row["rcChangeDate"];
                $change_status .= (strlen($change_status) > 2 ? "<br>" : "") . "Day(일령)";
            }

            if(in_array("Lst", $checker)){
                $change_str .= (strlen($change_str) > 2 ? "<br>" : "") . $row["rcPrevLst"] . " -> " . $row["rcChangeLst"];
                $change_status .= (strlen($change_status) > 2 ? "<br>" : "") . "Lst(축종)";
            }

            if(in_array("Opt", $checker)){
                $change_str .= (strlen($change_str) > 2 ? "<br>" : "") . $row["rcPrevRatio"] . " -> " . $row["rcChangeRatio"];
                $change_status .= (strlen($change_status) > 2 ? "<br>" : "") . "Opt(재산출)";
            }

            $request_history_data[] = array(
                'f1'  => $row["rcRequestDate"],							
                'f2'  => $change_status,									
                'f3'  => $change_str,
                'f4'  => $row["rcMeasureDate"],
                'f5'  => $row["rcMeasureVal"],	
                'f6'  => $row["rcPrevWeight"],									
            );
        }

        $response["request_history_data"] = $request_history_data;
        echo json_encode($response);

        break;

    case "get_raw_data":          //로우데이터

        $start_time = "";
        $end_time = "";
        $limit = "";
        $order = -1;

        if(isset($_REQUEST["search_map"])){
			$sjson = $_REQUEST["search_map"];

            $start_time = ($sjson["search_sdate"] != "" ? str_replace ("/", "-", $sjson["search_sdate"]) : substr($_REQUEST["indate"], 0, 10)) . " " . ($sjson["search_stime"] != "" ? $sjson["search_stime"] . ":00" : "00:00:00");
            $end_time = ($sjson["search_edate"] != "" ? str_replace ("/", "-", $sjson["search_edate"]) : date('Y-m-d')) . " " . ($sjson["search_etime"] != "" ? $sjson["search_etime"] . ":00" : date('H:i:s'));
            $limit = $sjson["search_limit"] != "" ? $sjson["search_limit"] : 100;
            $order = $sjson["search_order"];
		}

        $pipe_match =   [ '$match' => ['farmID' => $farmID, 'dongID' => $dongID, 'getTime' => ['$gte' => $start_time, '$lte' => $end_time] ] ];
        $pipe_sort  =   [ '$sort' => ['getTime' => (int)$order] ];
        $pipe_limit =   [ '$limit' => (int)$limit ];

        switch($_REQUEST["type"]){
            case "cell":
                $hide_arr = array("_id" => 0);
                for($i=6; $i<=60; $i++){
                    $field = sprintf("w%02d", $i);
                    $hide_arr[$field] = 0;
                }

                $pipeline = [ $pipe_match, $pipe_sort, $pipe_limit, [ '$project' => $hide_arr ] ];

                $result = get_aggregate_data("kokofarm3", "sensorData", $pipeline);

                $raw_data = array();
                foreach($result as $row){
                    $raw_data[] = array(
                        'f1'    => $row->getTime,
                        'f2'    => $row->jeoulID,
                        'f3'    => $row->temp,
                        'f4'    => $row->humi,
                        'f5'    => $row->co,
                        'f6'    => $row->nh,
                        'f7'    => $row->w01,
                        'f8'    => $row->w02,
                        'f9'    => $row->w03,
                        'f10'   => $row->w04,
                        'f11'   => $row->w05,
                    );
                }

                break;

            case "plc":
                $hide_arr = array("_id" => 0);
                
                $pipeline = [ $pipe_match, $pipe_sort, $pipe_limit, [ '$project' => $hide_arr ] ];

                $result = get_aggregate_data("kokofarm3", "plcSensor", $pipeline);

                $raw_data = array();
                foreach($result as $row){
                    $row->Temp = array_slice($row->Temp, 0, 10);
                    $row->Humi = array_slice($row->Humi, 0, 10);
                    $raw_data[] = array(
                        'f1'    => $row->getTime,
                        'f2'    => $row->Temp,
                        'f3'    => $row->Humi,
                        'f4'    => $row->Co2,
                        'f5'    => $row->Npre,
                        'f6'    => $row->OutTemp,
                        'f7'    => $row->OutHumi,
                        'f8'    => $row->OutNh3,
                        'f9'    => $row->OutH2s,
                    );
                }

                break;

            case "dev":
                $hide_arr = array("_id" => 0);
                
                $pipeline = [ $pipe_match, $pipe_sort, $pipe_limit, [ '$project' => $hide_arr ] ];

                $result = get_aggregate_data("kokofarm3", "plcHistory", $pipeline);

                $raw_data = array();
                foreach($result as $row){
                    $raw_data[] = array(
                        'f1'    => $row->getTime,
                        'f2'    => $row->unitID,
                        'f3'    => $row->uProperty,
                        'f4'    => $row->uName,
                        'f5'    => $row->uRemark,
                        'f6'    => $row->uStatus,
                    );
                }

                break;

            case "ext":
                $hide_arr = array("_id" => 0);
                
                $pipeline = [ $pipe_match, $pipe_sort, $pipe_limit, [ '$project' => $hide_arr ] ];

                $result = get_aggregate_data("kokofarm3", "sensorExtData", $pipeline);

                $raw_data = array();
                foreach($result as $row){
                    $raw_data[] = array(
                        'f1'    => $row->getTime,
                        'f2'    => $row->feedWeight,
                        'f3'    => $row->feedWeightVal,
                        'f4'    => $row->feedWater,
                        'f5'    => $row->outTemp,
                        'f6'    => $row->outHumi,
                        'f7'    => $row->outNh3,
                        'f8'    => $row->outH2s,
                        'f9'    => $row->outDust,
                        'f10'    => $row->outUDust,
                        'f11'    => $row->outWinderec,
                        'f12'    => $row->outWinspeed,
                    );
                }

                break;
        }

        switch($_REQUEST["action"]){
            case "search":
                $response["raw_data"] = $raw_data;
                echo json_encode($response);
                break;
            
            case "excel":
                $result = json_decode(json_encode($result), true);

                $title = $farmID . "_" . $dongID . "_rawdata_" . $_REQUEST["type"];

                header("Content-Type: application/vnd.ms-excel");
                header("Expires: 0");
                header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
                header("content-disposition: attachment; filename=" . date('Ymd_His') . "_" . $title . ".xls");

                $field_data = array();
                $field_data[] = array("번호", "No", "INT", "center");
                foreach($result[0] as $key => $val){
                    $field_data[] = array($key, $key, "STR", "center");
                }

                convert_excel($result, $field_data, $title, $code);

                break;
        }

        break;
    
    case "get_buffer":          //버퍼테이블

        $ref_date = date('Y-m-d H:i:s');
        $ref_date = substr($ref_date, 0, 15) . "0:00";

        $select_query = "SELECT cm.*, fd.fdName, be.*, bp.*, sf.*, so.*, sc.*, 
                        IFNULL(DATEDIFF(current_date(), cm.cmIndate) + 1, 0) as days, 
                        GROUP_CONCAT(siCellid separator ' | ') AS siCellid, 
                        GROUP_CONCAT(siSensorDate separator ' | ') AS siSensorDate, 
                        GROUP_CONCAT(TRUNCATE(siTemp, 1) separator ' | ') AS siTemp, GROUP_CONCAT(TRUNCATE(siHumi, 1) separator ' | ') AS siHumi, 
                        GROUP_CONCAT(TRUNCATE(siCo2, 1) separator ' | ') AS siCo2, GROUP_CONCAT(TRUNCATE(siNh3, 1) separator ' | ') AS siNh3,
                        aw.awWeight 
                        FROM comein_master AS cm
                        LEFT JOIN avg_weight AS aw ON aw.awFarmid = cm.cmFarmid AND aw.awDongid = cm.cmDongid AND awDate = '" .$ref_date. "' 
                        LEFT JOIN farm_detail AS fd ON fd.fdFarmid = cm.cmFarmid AND fd.fdDongid = cm.cmDongid
                        LEFT JOIN set_iot_cell AS si ON si.siFarmid = cm.cmFarmid AND si.siDongid = cm.cmDongid
                        LEFT JOIN buffer_sensor_status AS be ON be.beFarmid = cm.cmFarmid AND be.beDongid = cm.cmDongid
                        LEFT JOIN buffer_plc_status AS bp ON bp.bpFarmid = cm.cmFarmid AND bp.bpDongid = cm.cmDongid
                        LEFT JOIN set_feeder AS sf ON sf.sfFarmid = cm.cmFarmid AND sf.sfDongid = cm.cmDongid
                        LEFT JOIN set_outsensor AS so ON so.soFarmid = cm.cmFarmid AND so.soDongid = cm.cmDongid 
                        LEFT JOIN set_camera AS sc ON sc.scFarmid = cm.cmFarmid AND sc.scDongid = cm.cmDongid 
                        WHERE cmCode = '" .$code. "'
                        GROUP BY cm.cmCode, sc.scPort";

        $select_data = get_select_data($select_query);
        $row = $select_data[0];

        $summary_data = array();

        $summary_data["summary_name"] = $row["fdName"] . " (" . $row["cmFarmid"] . "-" . $row["cmDongid"] . ")";
        $summary_data["summary_days"] = $row["days"];
        $summary_data["summary_avg"] = number_format($row["beAvgWeight"], 0);
        $summary_data["summary_devi"] = "표준편차<br>" . number_format($row["beDevi"], 1);
        $summary_data["summary_inc"] = "일일증체량<br>" . (empty($row["awWeight"]) ? "-" : number_format($row["beAvgWeight"] - $row["awWeight"], 0));
        $summary_data["summary_type"] = $row["cmIntype"] . " " . $row["cmInsu"] . "수";
        $summary_data["summary_comein"] = "입추일자 : " . substr($row["cmIndate"], 0, 10);

        //카메라
        $img_url = "../../common/php_module/camera_func.php?ip=" .$row["beIPaddr"]. "&port=" .$row["scPort"]. "&url=" .urlencode($row["scUrl"]). "&id=" .$row["scId"]. "&pw=" .$row["scPw"];
        $summary_data["summary_camera"] = "<img src='" .$img_url. "' width='100%' onError=\" $(this).attr('src','../images/noimage.jpg'); $('#cameraIcon').hide();\">
                                        <img id='cameraIcon' src='../images/play.png' class='fadeIn animated' onClick=\"camera_popup('" .$name. "','" .$img_url. "'); \">";

        // $summary_data["summary_indate"] = $row["cmIndate"];
        // $summary_data["summary_outdate"] = $row["cmOutdate"];

        $response["summary_data"] = $summary_data;

        $buffer_data = array();         // 버퍼 데이터 테이블 표시
        $cell_control_data = array();        // 조회 및 설정 테이블 표시

        // set_iot_sensor 데이터 모음
        $sensor_map = array(
            explode(" | ", $row["siCellid"]), 
            explode(" | ", $row["siSensorDate"]), 
            explode(" | ", $row["siTemp"]), 
            explode(" | ", $row["siHumi"]), 
            explode(" | ", $row["siCo2"]), 
            explode(" | ", $row["siNh3"]), 
        );

        // 저울별로 테이블에 적재
        for($i=0; $i<count($sensor_map[0]); $i++){
            $buffer_data[] = array(
                'f1'  => "IoT저울-" . $sensor_map[0][$i],							
                'f2'  => $sensor_map[1][$i],	
                'f3'  => make_sub_table( array("온도(℃)", "습도(%)", "CO2(ppm)", "NH3(ppm)"), array($sensor_map[2][$i], $sensor_map[3][$i], $sensor_map[4][$i], $sensor_map[5][$i]) )
            );

            $cell_id = $sensor_map[0][$i];
            $version_info = cell_version_info($row["cmFarmid"], $row["cmDongid"], $cell_id);
            $sensor_info = cell_sensor_info($row["cmFarmid"], $row["cmDongid"], $cell_id);
            $zero_set = cell_zero_set($row["cmFarmid"], $row["cmDongid"], $cell_id);

            $cell_control_data[] = array(
                'f1'  => $sensor_map[0][$i], 
                'f2'  => "<button class='btn btn-primary' id='btn_cell_version_" .$cell_id. "' onClick='itr_send(\"" .$version_info. "\", \"btn_cell_version_" .$cell_id. "\")'><span id='ret'></span><span class='fa fa-refresh'></span></button>",
                'f3'  => "<button class='btn btn-primary' id='btn_cell_sensor_" .$cell_id. "' onClick='itr_send(\"" .$sensor_info. "\", \"btn_cell_sensor_" .$cell_id. "\")'><span id='ret'></span><span class='fa fa-refresh'></span></button>",
                'f4'  => "<button class='btn btn-primary' id='btn_zeor_set_" .$cell_id. "' onClick='itr_send(\"" .$zero_set. "\", \"btn_zeor_set_" .$cell_id. "\", true)'><span id='ret'></span><span class='fa fa-cog'></span></button>",
            );
        }

        // 급이 / 급수
        if($row["sfFarmid"] != ""){
            $buffer_data[] = array(
                'f1'  => "급이/급수",							
                'f2'  => $row["sfFeedDate"] == "" ? "NONE" : $row["sfFeedDate"],
                'f3'  => make_sub_table( array("사료빈 무게", "일일급이량", "유량센서", "일일급수량"), array($row["sfFeed"], $row["sfDailyFeed"], $row["sfWater"], $row["sfDailyWater"]) )
            );
        }

        // 외기환경
        if($row["soFarmid"] != ""){
            $buffer_data[] = array(
                'f1'  => "외기환경",							
                'f2'  => $row["soSensorDate"] == "" ? "NONE" : $row["soSensorDate"],
                'f3'  => make_sub_table( 
                            array("온도(℃)", "습도(%)", "CO2(ppm)", "H2S(ppm)", "미세먼지(ppm)", "초미세먼지(ppm)", "풍향", "풍속"), 
                            array($row["soTemp"], $row["soHumi"], $row["soNh3"], $row["soH2s"], $row["soDust"], $row["soUDust"], $row["soWindDirection"], $row["soWindSpeed"]) 
                        )
            );
        }

        // plc 환경
        if($row["bpFarmid"] != ""){
            $buffer_data[] = array(
                'f1'  => "plc환경",							
                'f2'  => $row["bpSensorDate"] == "" ? "NONE" : $row["bpSensorDate"],
                'f3'  => make_sub_table( 
                            array("내부온도(℃)", "내부습도(%)", "내부CO2(ppm)", "내부음압", "외부온도(℃)", "외부습도(%)", "외부NH3(ppm)", "외부H2S(ppm)"), 
                            array(
                                get_split_avg($row["bpTemp"]), get_split_avg($row["bpHumi"]), get_split_avg($row["bpCo2"]), get_split_avg($row["bpNPre"]), 
                                get_split_avg($row["bpOutTemp"]), get_split_avg($row["bpOutHumi"]), get_split_avg($row["bpOutNh3"]), get_split_avg($row["bpOutH2s"])
                            ) 
                        )
            );
        }

        $response["buffer_data"] = $buffer_data;
        $response["cell_control_data"] = $cell_control_data;
 
        $device_cnt_data = array();
        $device_cnt_data["device_cnt_cell"] = count($sensor_map[0]);
        $device_cnt_data["device_cnt_camera"] = 1;
        $device_cnt_data["device_cnt_plc"] = $row["bpFarmid"] == "" ? 0 : 1;
        $device_cnt_data["device_cnt_feeder"] = $row["sfFarmid"] == "" ? 0 : 1;
        $device_cnt_data["device_cnt_water"] = $row["sfFarmid"] == "" ? 0 : 1;
        $device_cnt_data["device_cnt_out"] = $row["soFarmid"] == "" ? 0 : 1;

        $response["device_cnt_data"] = $device_cnt_data;

        echo json_encode($response);

        break;

    case "socket_send":
        $send = $_REQUEST["send"];
        $recv = send_packet($send);

        $response["recv"] = $recv;

        echo json_encode($response);
        break;
}


function make_sub_table($header_arr, $body_arr){
    $data_html = "<table class='table' style='text-align:center;'>";
    $data_html .= "<thead> <tr> ";

    foreach($header_arr as $header){
        $data_html .= "<th style='background-color:#568a89; color:#f8f9fa; padding:1px; font-weight:normal;'>" .$header. "</th>";
    }

    $data_html .= "</tr> </thead>";
    $data_html .= "<tbody> <tr>";

    foreach($body_arr as $body){
        $data_html .= "<td style='padding:1px; background-color:#fbfbfb;'>" .number_format($body, 1). "</td>";
    }

    $data_html .= "</tr> </tbody>";
    $data_html .= "</table>";

    return $data_html;
}

function get_split_avg($splittable){
    if($splittable != ""){
        $temp = explode("|", $splittable);
        $avg = 0;
        $cnt = 0;
        foreach($temp as $val){
            if($val = "N"){
                break;
            }
            else{
                $cnt++;
                $avg += number_format($val, 1);
            }
        }

        return $cnt > 0 ? number_format($avg / $cnt, 1) : 0;
    }
    else{
        return 0;
    }
    
}
?>