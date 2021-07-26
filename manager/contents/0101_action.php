<?

include_once("../../common/php_module/common_func.php");

$response = array();

// 어떤 작업인지 가져옴
$oper = isset($_REQUEST["oper"]) ? $oper = check_str($_REQUEST["oper"]) : "";

switch($oper){
	case "get_farm_list":

        //검색필드
        $append_query = "";
        if(isset($_REQUEST["search_inout"])){
            $search_inout = check_str($_REQUEST["search_inout"]);
            switch($search_inout){
                case "전체":
                    break;
                case "입추":
                    $append_query .= " AND beStatus != 'O'";
                    break;
                case "출하":
                    $append_query .= " AND beStatus = 'O'";
                    break;
            }
        }

        if(isset($_REQUEST["search_name"])){
            $search_name = check_str($_REQUEST["search_name"]);
            $append_query .= " AND fdName LIKE \"%" .$search_name. "%\"";
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
		
        // 세부 데이터까지 가져오기
        $select_query = "SELECT be.*, cm.cmIndate, cm.cmIntype, cm.cmOutdate, fd.fdName, fd.fdAddr, fd.fdTel, sc.scPort, sc.scUrl, sc.scId, sc.scPw, 
                            IFNULL(DATEDIFF(current_date(), cm.cmIndate) + 1, 0) as interm, 
                            bp.bpSensorDate, bp.bpDeviceDate, sf.sfFeedDate, sf.sfWaterDate, so.soSensorDate, 
                            GROUP_CONCAT(siSensorDate separator '|') AS siSensorDate, 
                            GROUP_CONCAT(TRUNCATE(siWeight, 1) separator ' | ') AS siWeight,
                            GROUP_CONCAT(TRUNCATE(siTemp, 1) separator ' | ') AS siTemp, GROUP_CONCAT(TRUNCATE(siHumi, 1) separator ' | ') AS siHumi, 
                            GROUP_CONCAT(TRUNCATE(siCo2, 1) separator ' | ') AS siCo2, GROUP_CONCAT(TRUNCATE(siNh3, 1) separator ' | ') AS siNh3 
                        FROM buffer_sensor_status AS be 
                        LEFT JOIN comein_master AS cm ON cm.cmCode = be.beComeinCode 
                        LEFT JOIN farm_detail AS fd ON fd.fdFarmid = be.beFarmid AND fd.fdDongid = be.beDongid 
                        LEFT JOIN set_iot_cell AS si ON si.siFarmid = be.beFarmid AND si.siDongid = be.beDongid 
                        LEFT JOIN set_feeder AS sf ON sf.sfFarmid = be.beFarmid AND sf.sfDongid = be.beDongid 
                        LEFT JOIN set_outsensor AS so ON so.soFarmid = be.beFarmid AND so.soDongid = be.beDongid 
                        LEFT JOIN buffer_plc_status AS bp ON bp.bpFarmid = be.beFarmid AND bp.bpDongid = be.beDongid 
                        LEFT JOIN set_camera AS sc ON sc.scFarmid = be.beFarmid AND sc.scDongid = be.beDongid 
                        WHERE beFarmid = beFarmid " .$append_query. " GROUP BY be.beFarmid, be.beDongid, sc.scPort ORDER BY interm DESC";

        // 나타낼 표 데이터만 가져오기
        // $select_query = "SELECT be.*, fd.fdName, cm.cmIndate,
        //                     IFNULL(DATEDIFF(current_date(), cm.cmIndate) + 1, 0) as interm, 
        //                     bp.bpSensorDate, bp.bpDeviceDate, sf.sfFeedDate, sf.sfWaterDate, so.soSensorDate
        //                 FROM buffer_sensor_status AS be 
        //                 LEFT JOIN comein_master AS cm ON cm.cmCode = be.beComeinCode 
        //                 LEFT JOIN farm_detail AS fd ON fd.fdFarmid = be.beFarmid AND fd.fdDongid = be.beDongid 
        //                 LEFT JOIN set_iot_cell AS si ON si.siFarmid = be.beFarmid AND si.siDongid = be.beDongid 
        //                 LEFT JOIN set_feeder AS sf ON sf.sfFarmid = be.beFarmid AND sf.sfDongid = be.beDongid 
        //                 LEFT JOIN set_outsensor AS so ON so.soFarmid = be.beFarmid AND so.soDongid = be.beDongid 
        //                 LEFT JOIN buffer_plc_status AS bp ON bp.bpFarmid = be.beFarmid AND bp.bpDongid = be.beDongid 
        //                 WHERE beFarmid = beFarmid " .$append_query;

        $result = get_select_data($select_query);

        // 반환할 배열
        $farm_detail_data = array();    // 선택 시 표현될 세부 농장 정보
        $farm_list_table = array();     // 표로 나타낼 농장 목록 데이터

        // 경보로 소팅하기 위한 변수
        $warn_level_map = array();

        // 데이터 가공 작업
        $now = date('Y-m-d H:i:s');
        foreach($result as $idx => $row){
            $row["device_error"] = 0;           // 오류 장치 수
            $row["warning"] = "";               // 환경 경보

            // 최소중량 최대중량
            $row["min_weight"] = $row["beAvgWeight"] - $row["beDevi"];
            $row["max_weight"] = $row["beAvgWeight"] + $row["beDevi"];

            foreach($row as $key => $val){
                switch($key){
                    // 경과시간 확인하여 출력
                    case "bpSensorDate":
                    case "bpDeviceDate":
                    case "sfFeedDate":
                    case "sfWaterDate":
                    case "soSensorDate":
                        if(empty($val)){
                            $row[$key] = "<button type='button' class='btn btn-secondary btn-sm'> &nbsp;&nbsp;-&nbsp;&nbsp; </button>";
                        }
                        else{
                            $diff = get_date_diff($val, $now);
                            $conv_diff = conv_second_to_read($diff);
                            $row[$key] = "<button type='button' class='btn btn-" . ($diff > 180 ? "warning" : "primary") . " btn-sm'>" . $conv_diff . "</button>";

                            $row["device_error"] = $diff > 180 ? $row["device_error"] + 1 : $row["device_error"];         // 오류장치 있는 경우 카운트
                        }
                        break;

                    //평균중량 옆에 권고중량 붙임
                    case "beDevi":
                        $row["beDevi"] = sprintf("%0.1f", $row["beDevi"]);
                        break;
                    case "beAvgWeight":
                        $row["beAvgWeight"] = sprintf("%0.1f", $row["beAvgWeight"]);

                        $curr_days = $row["interm"] > 42 ? 42 : $row["interm"] ;
                        $curr_type = $row["cmIntype"];
                        $ref_type = array_key_exists($curr_type, $ref_map["Weight"]) ? $curr_type : "";

                        if($ref_type != ""){
                            $diff = $row["beAvgWeight"] - $ref_map["Weight"][$ref_type][$curr_days][0];     // 예측중량 - 권고중량 => 권고에 비해서 어느 정도 상태인지 비교
                            $diff_html = "<span style='color:" .($diff >= 0 ? "red" : "blue"). ";'>" . abs($diff) . "&nbsp;<i class='fa fa-caret-" .($diff >= 0 ? "up" : "down"). "'></i></span>";
                            $row["beAvgWeight"] .= "g ( " .$diff_html. " )";
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
                        $curr_days = $row["interm"] > 42 ? 42 : $row["interm"] ;
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
                            if(empty($tokens[$i])) continue;

                            $diff = get_date_diff($tokens[$i], $now);
                            $out = $diff > 180 ? $out . " | " . ($i+1) : $out;

                            $row["device_error"] = $diff > 180 ? $row["device_error"] + 1 : $row["device_error"];         // 오류장치 있는 경우 카운트
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
            //$warn_level_map["" . $idx] = $level;

            $row["warning"] = "<button type='button' class='btn btn-" . $level_map[$level-1]["class"] . " btn-sm'>" . $level_map[$level-1]["info"] . "</button>";

            //$temp["print_data"][] = $row;


            $img_url = "../../common/php_module/camera_func.php?ip=" .$row["beIPaddr"]. "&port=" .$row["scPort"]. "&url=" .urlencode($row["scUrl"]). "&id=" .$row["scId"]. "&pw=" .$row["scPw"];
			
			$camera_html = "<img src='".$img_url."' onError=\" $(this).attr('src','../images/noimage.jpg'); $('#cameraIcon').hide();\">
							<img id='cameraIcon' src='../images/play.png' class='fadeIn animated' onClick=\"camera_popup('" .$row["fdName"]. "','" .$img_url. "'); \">";
			
			$row["camera_html"] = $camera_html;

            $farm_list_table[] = array(
                'f_no'          => $idx + 1,
                'f_name'		=> $row["fdName"],
                'f_interm'	    => $row["interm"],
                'f_error'		=> $row["device_error"],  
                'f_network'     => $row["beNetwork"],
                'f_sensor'		=> $row["siSensorDate"],
                'f_code'	    => $row["beComeinCode"],
            );

            $farm_detail_data[$row["beComeinCode"]] = $row;

        }
        
        // if($sidx == "warning"){
        //     $sord == "asc" ? asort($warn_level_map) : arsort($warn_level_map);
            
        //     foreach($warn_level_map as $key => $val){
        //         $response["print_data"][] = $temp["print_data"][(int)$key];
        //     }
        // }
        // else{ 
        //     $response = $temp;
        // }
        

        $response["farm_list_table"] = $farm_list_table;
        $response["farm_detail_data"] = $farm_detail_data;

        echo json_encode($response);

		break;
}

?>