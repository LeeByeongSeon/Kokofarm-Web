<?

include_once("../../common/php_module/common_func.php");

$response = array();

// 어떤 작업인지 가져옴
$oper = isset($_REQUEST["oper"]) ? $oper = check_str($_REQUEST["oper"]) : "";

// cmCode에서 농장, 동 id 추출
if(isset($_REQUEST["code"])){
    $code = $_REQUEST["code"];
    $id = explode("_", $code)[1];
    $farmID = substr($id, 0, 4);
    $dongID = substr($id, 4);
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

            $reponse["code"] = $select_data[0]["cmCode"];

            echo json_encode($reponse);
        }

        break;

	case "get_avg_weight":          //평균중량
        
        $append_query = "AND awFarmid = \"" . $farmID . "\" AND awDongid = \"" . $dongID . "\"";

        $select_query = "SELECT * FROM avg_weight WHERE awFarmid = awFarmid " . $append_query;

        $select_data = get_select_data($select_query);

        $avg_weight_data = array();
        foreach($select_data as $row){
            $avg_weight_data[] = array(
                'f1'  => $row["awDate"],							
                'f2'  => $row["awDays"],									
                'f3'  => $row["awWeight"],								
                'f4'  => $row["awWeight"],									
            );
        }

        $reponse["avg_weight_data"] = $avg_weight_data;
		echo json_encode($reponse);

		break;
    
    case "get_buffer":          //버퍼테이블

        $ref_date = date('Y-m-d H:i:s');
        $ref_date = substr($ref_date, 0, 15) . "0:00";

        $select_query = "SELECT cm.*, fd.fdName, be.*, bp.*, sf.*, so.*, 
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
                        WHERE cmCode = '" .$code. "'
                        GROUP BY cm.cmCode";

        $select_data = get_select_data($select_query);
        $row = $select_data[0];

        $summary_data = array();
        

        $summary_data["summary_name"] = $row["fdName"] . " (" . $row["cmFarmid"] . "-" . $row["cmFarmid"] . ")";
        $summary_data["summary_days"] = $row["days"];
        $summary_data["summary_avg"] = number_format($row["beAvgWeight"], 0);
        $summary_data["summary_devi"] = "표준편차<br>" . number_format($row["beDevi"], 1);
        $summary_data["summary_inc"] = "일일증체량<br>" . empty($row["awWeight"]) ? "-" : number_format($row["beAvgWeight"] - $row["awWeight"], 0);
        $summary_data["summary_type"] = $row["cmIntype"] . " " . $row["cmInsu"] . "수";
        $summary_data["summary_comein"] = "입추일자 : " . substr($row["cmIndate"], 0, 10);

        $reponse["summary_data"] = $summary_data;

        $buffer_data = array();

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
        }

        // 급이 / 급수
        $buffer_data[] = array(
            'f1'  => "급이/급수",							
            'f2'  => $row["sfFeedDate"] == "" ? "NONE" : $row["sfFeedDate"],
            'f3'  => make_sub_table( array("사료빈 무게", "일일급이량", "유량센서", "일일급수량"), array($row["sfFeed"], $row["sfDailyFeed"], $row["sfWater"], $row["sfDailyWater"]) )
        );

        // 외기환경
        $buffer_data[] = array(
            'f1'  => "외기환경",							
            'f2'  => $row["soSensorDate"] == "" ? "NONE" : $row["soSensorDate"],
            'f3'  => make_sub_table( 
                        array("온도(℃)", "습도(%)", "CO2(ppm)", "H2S(ppm)", "미세먼지(ppm)", "초미세먼지(ppm)", "풍향", "풍속"), 
                        array($row["soTemp"], $row["soHumi"], $row["soNh3"], $row["soH2s"], $row["soDust"], $row["soUDust"], $row["soWindDirection"], $row["soWindSpeed"]) 
                    )
        );

        // plc 환경
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

        $reponse["buffer_data"] = $buffer_data;

        echo json_encode($reponse);

        break;
}


function make_sub_table($header_arr, $body_arr){
    $data_html = "<table class='table' style='text-align:center;'>";
    $data_html .= "<thead> <tr> ";

    foreach($header_arr as $header){
        $data_html .= "<th style='background-color:#455a64; color:#f8f9fa; padding:1px;'>" .$header. "</th>";
    }

    $data_html .= "</tr> </thead>";
    $data_html .= "<tbody> <tr>";

    foreach($body_arr as $body){
        $data_html .= "<td style='padding:1px;'>" .$body. "</td>";
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