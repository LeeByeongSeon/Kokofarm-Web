<?

include_once("../common/php_module/common_func.php");

$mgr_id    = $_SESSION["mgr_id"];
$mgr_name  = $_SESSION["mgr_name"];
$mgr_type  = $_SESSION["mgr_type"];
$mgr_group = $_SESSION["mgr_group"];

if(strlen($mgr_id)<=3 || strlen($mgr_name)<=3 || strlen($mgr_type)<=3 || strlen($mgr_group)<=3){
    echo ("<script>location.href='../00_login/index.php'</script>");
}

$response = array();

// 어떤 작업인지 가져옴
$oper = isset($_REQUEST["oper"]) ? $oper = check_str($_REQUEST["oper"]) : "";

switch($oper){
	// 환경경보
	case "get_warn":

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
            }
            
            //ex) [Temp][육계][일령]{35,36,37,38}
            $ref_map[$group][$type][$day] = array($val["cName3"], $val["cName4"], $val["cName5"], $val["cName6"]);
        };

        // 위젯 헤더에 나타낼 환경경보 데이터
        $select_query = "SELECT cm.cmCode, cm.cmFarmid, cm.cmDongid, cm.cmIndate,
								IFNULL(DATEDIFF(current_date(), cm.cmIndate) + 1, 0) AS days, 
								be.beAvgTemp, be.beAvgHumi, be.beAvgCo2, be.beAvgNh3
						FROM comein_master AS cm
						LEFT JOIN buffer_sensor_status AS be ON be.beFarmid = cm.cmFarmid AND be.beDongid = cm.cmDongid
						WHERE cm.cmFarmid = be.beFarmid AND cm.cmCode = be.beComeinCode";
					//  WHERE (cmOutdate is NULL OR cmOutdate = '2000-01-01 00:00:00')"; 
		$select_data = get_select_data($select_query);

        // 경보로 소팅하기 위한 변수
        $warn_level_map = array();

        // 데이터 가공 작업
        $now = date('Y-m-d H:i:s');
        foreach($select_data as $idx => $row){
            $row["warning"] = "";               // 환경 경보

            foreach($row as $key => $val){
                switch($key){
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
				}
			}

            $row["warning"] = substr($row["warning"], 3);

            $tokens = explode(" | ", $row["warning"]);	

            $level = max($tokens);

            // 경보로 소팅시 사용
            $warn_level_map["" . $idx] = $level;

			$warn_arr[$level] = $warn_arr[$level] + 1; // $warn_arr[0] -> 정상, $warn_arr[1] -> 주의, $warn_arr[2] -> 경고, $warn_arr[3] -> 위험
        }

		$response["warn_map"] = $warn_level_map;

		// var_dump($warn_level_map);

		echo json_encode($response);

		break;

	// 구글맵
	case "get_map":

		//검색필드
		$append_query = "";

		if(isset($_REQUEST["select"]) && $_REQUEST["select"] != ""){
			$select = $_REQUEST["select"];
			$select_ids = explode("|", $select);
			
			$append_query = "AND fdFarmid = \"" . $select_ids[0] . "\"";

			$append_query = isset($select_ids[1]) ? $append_query . " AND fdDongid = \"" . $select_ids[1] . "\"" : $append_query;
		}

		$select_query = "SELECT fd.*, be.beStatus FROM farm_detail AS fd
						 JOIN buffer_sensor_status AS be ON fd.fdFarmid = be.beFarmid AND fd.fdDongid = be.beDongid
						 WHERE fdFarmid = fdFarmid ". $append_query;
						 
		$select_data = get_select_data($select_query);
					
		// 구글맵 관련
		$json_map = array();

		if(!empty($select_data)){
			foreach($select_data as $val){

				$json_map[] = array(
					"f_status" => $val["beStatus"],
					"f_farmid" => $val["fdFarmid"]. "|" .$val["fdDongid"],
					"f_name"   => $val["fdName"],
					"gps_lat"  => $val["fdGpslat"],
					"gps_lng"  => $val["fdGpslng"],
				);

			};
		};

		$response["json_map"]  = $json_map;

		echo json_encode($response);

		break;

	// marker modal data
	case "get_farm":

		// f_farmid 에서 농장, 동 id 추출
		if(isset($_REQUEST["code"])){
			$code = $_REQUEST["code"];
			$id = explode("|", $code);
			$farmID = $id[0];
			$dongID = $id[1];
		}

        $page  = isset($_REQUEST['page']) ? $page  = check_str($_REQUEST['page']) : 1; // jqGrid의 page 속성의 값
        $limit = isset($_REQUEST['rows']) ? $limit = check_str($_REQUEST['rows']) : 1; // jqGrid의 rowNum 속성의 값
        $sidx  = isset($_REQUEST['sidx']) ? $sidx  = check_str($_REQUEST['sidx']) : 'warning'; // jqGrid의 sortname 속성의 값
        $sord  = isset($_REQUEST['sord']) ? $sord  = check_str($_REQUEST['sord']) : 'desc'; // jqGrid의 sortorder 속성의 값

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
        };
		
        // 표로 나타낼 데이터
        $select_query = "SELECT cm.cmCode, cm.cmFarmid, cm.cmDongid, cm.cmIntype, cm.cmIndate, cm.cmOutdate, fd.fdName, fd.fdScale, fd.fdAddr, fd.fdOutDays,
								IFNULL(DATEDIFF(current_date(), cm.cmIndate) + 1, 0) AS days, 
								TRUNCATE(be.beAvgWeight, 0) AS beAvgWeight, be.beAvgTemp, be.beAvgHumi, be.beAvgCo2, be.beAvgNh3, be.beComeinCode,
								be.beStatus, bp.bpSensorDate, bp.bpDeviceDate, sf.sfFeedDate, sf.sfWaterDate, so.soSensorDate
						FROM comein_master AS cm
						LEFT JOIN farm_detail AS fd ON fd.fdFarmid = cm.cmFarmid AND fd.fdDongid = cm.cmDongid
						LEFT JOIN buffer_sensor_status AS be ON be.beFarmid = cm.cmFarmid AND be.beDongid = cm.cmDongid
						LEFT JOIN buffer_plc_status AS bp ON bp.bpFarmid = cm.cmFarmid AND bp.bpDongid = cm.cmDongid
						LEFT JOIN set_feeder AS sf ON sf.sfFarmid = cm.cmFarmid AND sf.sfDongid = cm.cmDongid
						LEFT JOIN set_outsensor AS so ON so.soFarmid = cm.cmFarmid AND so.soDongid = cm.cmDongid
						WHERE cm.cmFarmid = \"$farmID\" AND cm.cmCode = be.beComeinCode";

		//var_dump($select_query);

		// // 구글맵 data select
		// $select_data = get_select_data($select_query);

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
                            $row[$key] = "<span  class='badge badge-pill badge-light text-secondary'> &nbsp;&nbsp;-&nbsp;&nbsp; </span>";
                        }
                        else{
                            $diff = get_date_diff($val, $now);
                            $conv_diff = conv_second_to_read($diff);
                            $row[$key] = "<span  class='badge badge-pill badge-" . ($diff > 180 ? "warning" : "primary") . " btn-sm' disabled>" . $conv_diff . "</span>";
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
                    
					// // 경과시간 확인하여 현재 오류인지 아닌지 출력
					// case "siSensorDate":
					// 	$out = "";
					// 	$tokens = explode("|", $val);

					// 	for($i=0; $i<count($tokens); $i++){
					// 		$diff = get_date_diff($tokens[$i], $now);
					// 		$out = $diff > 180 ? $out . " | " . ($i+1) : $out;
					// 	}
						
					// 	$out = strlen($out) > 2 ? substr($out, 3) : strlen($out);
					// 	$row[$key] = "<span class='badge badge-pill badge-" . ($out == "" ? "primary" : "warning") . " btn-sm'>" . ($out == "" ? "O" : $out) . "</span>";
					// 	break;
					
					// // 네트워크
					// case "beNetwork":
					// 	$row[$key] = "<span class='badge badge-pill badge-" . ($val < 80 ? "primary" : "warning") . " btn-sm'>" . $val . "ms</span>";
					// 	break;
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

			$warn_arr[$level] = $warn_arr[$level] + 1; // $warn_arr[0] -> 정상, $warn_arr[1] -> 주의, $warn_arr[2] -> 경고, $warn_arr[3] -> 위험

            $row["warning"] = "<span class='badge badge-pill badge-" . $level_map[$level-1]["class"] . " btn-sm'>" . $level_map[$level-1]["info"] . "</span>";

            $temp["print_data"][] = $row;
        }
        
        if($sidx == "warning"){
            $sord == "asc" ? asort($warn_level_map) : arsort($warn_level_map);
            
            foreach($warn_level_map as $key => $val){
                $response["print_data"][] = $temp["print_data"][(int)$key];
            }
        }
        else{ 
            $response = $temp;
        }

        $response["page"] = $page;
        $response["total"] = $total_pages;
        $response["records"] = $total_len;
			
		// // 구글맵 관련
		// $json_map = array();

		// if(!empty($select_data)){
		// 	foreach($select_data as $val){

		// 		$json_map[] = array(
		// 			"f_status" => $val["beStatus"],
		// 			"f_farmid" => $val["fdFarmid"]. "|" .$val["fdDongid"],
		// 			"f_name"   => $val["fdName"],
		// 			"gps_lat"  => $val["fdGpslat"],
		// 			"gps_lng"  => $val["fdGpslng"],
		// 		);

		// 	};
		// };

		// $response["json_map"]  = $json_map;

		echo json_encode($response);

		break;
}

?>