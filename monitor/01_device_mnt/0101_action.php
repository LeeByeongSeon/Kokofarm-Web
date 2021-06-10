<?

include_once("../../common/php_module/common_func.php");

$response = array();

// 어떤 작업인지 가져옴
$oper = isset($_REQUEST["oper"]) ? $oper = check_str($_REQUEST["oper"]) : "";

switch($oper){
	default:
        $page  = check_str($_REQUEST['page']); // jqGrid의 page 속성의 값
        $limit = check_str($_REQUEST['rows']); // jqGrid의 rowNum 속성의 값
        $sidx  = check_str($_REQUEST['sidx']); // jqGrid의 sortname 속성의 값
        $sord  = check_str($_REQUEST['sord']); // jqGrid의 sortorder 속성의 값

        //검색필드
        $append_query = "";

        if(isset($_REQUEST["search_data"])){
            $search_data = $_REQUEST["search_data"];
            $search_json = json_decode(stripslashes($search_data), true);

            $append_query = ($search_json["search_name"] == "") ? $append_query : $append_query . " AND (fdName LIKE \"%" .$search_json["search_name"]. "%\" OR cmFarmid LIKE \"%" .$search_json["search_name"]. "%\") ";
        }

        // 권고 환경값 및 중량 가져오기
        $ref_data = get_select_data("SELECT * FROM codeinfo WHERE LEFT(cGroup, 2) = \"권고\"");
        $ref_map = array();

        foreach($ref_data as $val){
            $group = $val["cGroup"];
            $type = $val["cName1"];
            $day = $val["cName2"];

            switch($group){
                case "권고온도":
                    $group = "Temp";
                    break;
                case "권고습도":
                    $group = "Humi";
                    break;
                case "권고CO2":
                    $group = "Co2";
                    break;
                case "권고NH3":
                    $group = "Nh3";
                    break;
                case "권고중량":
                    $group = "Weight";
                    break;  
            }
            
            //ex) [Temp][육계][일령]{35,36,37,38}
            $ref_map[$group][$type][$day] = array($val["cName3"], $val["cName4"], $val["cName5"], $val["cName6"]);
        }
		
        // 표로 나타낼 데이터
        $select_query = "SELECT cm.cmCode, cm.cmFarmid, cm.cmDongid, cm.cmIntype, fd.fdName,
                            IFNULL(DATEDIFF(current_date(), cm.cmIndate) + 1, 0) as days, 
                            TRUNCATE(be.beAvgWeight, 0) AS beAvgWeight, be.beAvgTemp, be.beAvgHumi, be.beAvgCo2, be.beAvgNh3, 
                            be.beNetwork, bp.bpSensorDate, bp.bpDeviceDate, sf.sfFeedDate, sf.sfWaterDate, so.soSensorDate,
                            GROUP_CONCAT(siSensorDate separator '|') AS siSensorDate, 
                            GROUP_CONCAT(TRUNCATE(siTemp, 1) separator ' | ') AS siTemp, GROUP_CONCAT(TRUNCATE(siHumi, 1) separator ' | ') AS siHumi, 
                            GROUP_CONCAT(TRUNCATE(siCo2, 1) separator ' | ') AS siCo2, GROUP_CONCAT(TRUNCATE(siNh3, 1) separator ' | ') AS siNh3 
                        FROM comein_master AS cm
                        LEFT JOIN farm_detail AS fd ON fd.fdFarmid = cm.cmFarmid AND fd.fdDongid = cm.cmDongid
                        LEFT JOIN set_iot_cell AS si ON si.siFarmid = cm.cmFarmid AND si.siDongid = cm.cmDongid
                        LEFT JOIN buffer_sensor_status AS be ON be.beFarmid = cm.cmFarmid AND be.beDongid = cm.cmDongid
                        LEFT JOIN buffer_plc_status AS bp ON bp.bpFarmid = cm.cmFarmid AND bp.bpDongid = cm.cmDongid
                        LEFT JOIN set_feeder AS sf ON sf.sfFarmid = cm.cmFarmid AND sf.sfDongid = cm.cmDongid
                        LEFT JOIN set_outsensor AS so ON so.soFarmid = cm.cmFarmid AND so.soDongid = cm.cmDongid
                        WHERE (cmOutdate is NULL OR cmOutdate = '2000-01-01 00:00:00') ". $append_query . " 
                        GROUP BY cm.cmCode";

        // 페이징 처리
        $total_len = get_select_count($select_query);

        $total_pages = 0;
        if( $total_len > 0) {
            $total_pages = ceil($total_len / $limit);
        }
        if ($page > $total_pages) {
            $page = $total_pages;
        }
        if ($limit < 0) {
            $limit = 0;
        }

        $start = $limit * $page - $limit; // do not put $limit*($page - 1)
        if ($start < 0) {
            $start = 0;
        }

        $temp = array();

        $temp["page"] = $page;
        $temp["total"] = $total_pages;
        $temp["records"] = $total_len;

        $jqgrid_query = "";

        if($sidx == "warning"){
            $jqgrid_query = $select_query . " LIMIT " .$start. ", " .$limit. ";";
        }
        else{
            $jqgrid_query = $select_query . " ORDER BY " .$sidx. " " .$sord. " LIMIT " .$start. ", " .$limit. ";";
        }

        $result = get_select_data($jqgrid_query);

        // 경보로 소팅하기 위한 변수
        $warn_level_map = array();

        // 데이터 가공 작업
        $now = date('Y-m-d H:i:s');
        foreach($result as $idx => $row){
            $row["warning"] = "";               // 환경 경보

            foreach($row as $key => $val){
                switch($key){
                    // 경과시간 확인하여 출력
                    case "bpSensorDate":
                    case "bpDeviceDate":
                    case "sfFeedDate":
                    case "sfWaterDate":
                    case "soSensorDate":
                        if(empty($val) || $val == "2000-01-01 00:00:00"){
                            $row[$key] = "<button type='button' class='btn btn-secondary btn-sm'> &nbsp;&nbsp;-&nbsp;&nbsp; </button>";
                        }
                        else{
                            $diff = get_date_diff($val, $now);
                            $conv_diff = conv_second_to_read($diff);
                            $row[$key] = "<button type='button' class='btn btn-" . ($diff > 180 ? "warning" : "primary") . " btn-sm'>" . $conv_diff . "</button>";
                        }
                        break;

                    //평균중량 옆에 권고중량 붙임
                    case "beAvgWeight":
                        $curr_days = $row["days"] > 42 ? 42 : $row["days"] ;
                        $curr_type = $row["cmIntype"];
                        $ref_type = array_key_exists($curr_type, $ref_map["Weight"]) ? $curr_type : "";

                        if($ref_type != ""){
                            $diff = $row["beAvgWeight"] - $ref_map["Weight"][$ref_type][$curr_days][0];     // 예측중량 - 권고중량 => 권고에 비해서 어느 정도 상태인지 비교
                            $diff_html = "<span style='color:" .($diff >= 0 ? "red" : "blue"). ";'>" . abs($diff) . "&nbsp;<i class='fa fa-caret-" .($diff >= 0 ? "up" : "down"). "'></i></span>";
                            $row["beAvgWeight"] .= " ( " .$diff_html. " )";
                        }
                        else{
                            $row["beAvgWeight"] .= " ( - )";
                        }

                        break;
                    
                    // 경보 처리
                    case "beAvgTemp":
                    case "beAvgHumi":
                    case "beAvgCo2":
                    case "beAvgNh3":

                        //일령 가져와서 경보 처리
                        $curr_days = $row["days"] > 42 ? 42 : $row["days"] ;
                        $curr_type = $row["cmIntype"];

                        // $ref_map["Temp"]에 현재 축종이 존재하는지 확인하고, 없는 경우 육계 참조값으로 사용
                        $prop = substr($key, 5);
                        $ref_type = array_key_exists($curr_type, $ref_map[$prop]) ? $curr_type : "육계";

                        $val = number_format($val, 1);    // 숫자로 변환

                        switch($prop){
                            case "Temp":
                            case "Humi":
                                $checker = $val - $ref_map[$prop][$ref_type][$curr_days][0];       // ref_map[Temp][육계][일령]{35,36,37,38}
                                $checker = abs($checker);

                                for($i=1; $i<=3; $i++){
                                    if($checker <= $ref_map[$prop][$ref_type][$curr_days][$i] - $ref_map[$prop][$ref_type][$curr_days][0]){      // 0.7 <= 35 - 36
                                        $row["warning"] .= " | " . $i;
                                        break;
                                    }

                                    if($i == 3) $row["warning"] .= " | 4";
                                }
                                break;
                            
                            case "Co2":
                            case "Nh3":
                                for($i=0; $i<=3; $i++){
                                    if($val <= $ref_map[$prop][$ref_type][$curr_days][$i]){
                                        $row["warning"] .= " | " . ($i+1);
                                        break;
                                    }

                                    if($i == 3) $row["warning"] .= " | 4";
                                }

                                break;
                        }
                        break;
                    
                    // 경과시간 확인하여 현재 오류인지 아닌지 출력
                    case "siSensorDate":
                        $out = "";
                        $tokens = explode("|", $val);

                        for($i=0; $i<count($tokens); $i++){
                            $diff = get_date_diff($tokens[$i], $now);
                            $out = $diff > 180 ? $out . " | " . ($i+1) : $out;
                        }
                        
                        $out = strlen($out) > 2 ? substr($out, 3) : strlen($out);
                        $row[$key] = "<button type='button' class='btn btn-" . ($out == "" ? "primary" : "warning") . " btn-sm'>" . ($out == "" ? "&nbsp;&nbsp;O&nbsp;&nbsp;" : $out) . "</button>";
                        break;
                    
                    // 네트워크
                    case "beNetwork":
                        $row[$key] = "<button type='button' class='btn btn-" . ($val < 80 ? "primary" : "warning") . " btn-sm'>" . $val . "ms</button>";
                        break;
                }
            }

            $level_map = array(
                array("class" => "primary", "info" => "정상"), array("class" => "success", "info" => "경고"), 
                array("class" => "warning", "info" => "주의"), array("class" => "danger", "info" => "위험")
            );

            $row["warning"] = substr($row["warning"], 3);

            $tokens = explode(" | ", $row["warning"]);

            $level = max($tokens);

            // 경보로 소팅시 사용
            $warn_level_map["" . $idx] = $level;

            $row["warning"] = "<button type='button' class='btn btn-" . $level_map[$level-1]["class"] . " btn-sm'>" . $level_map[$level-1]["info"] . "</button>";

            $temp["print_data"][] = $row;
        }
        
        if($sidx == "warning"){
            $sord == "asc" ? asort($warn_level_map) : arsort($warn_level_map);
            
            foreach($warn_level_map as $key => $val){
                $reponse["print_data"][] = $temp["print_data"][(int)$key];
            }
        }
        else{ 
            $reponse = $temp;
        }

        $reponse["page"] = $page;
        $reponse["total"] = $total_pages;
        $reponse["records"] = $total_len;

        echo json_encode($reponse);

		break;
}

?>