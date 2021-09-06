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

// cmCode에서 농장, 동 id 추출
if(isset($_REQUEST["code"])){
    $code = $_REQUEST["code"];
    $id = explode("_", $code)[1];
    $farmID = substr($id, 0, 6);
    $dongID = substr($id, 6);
}

switch($oper){

    default:
        $page = check_str($_REQUEST['page']); // jqGrid의 page 속성의 값
        $limit = check_str($_REQUEST['rows']);// jqGrid의 rowNum 속성의 값
        $sidx = check_str($_REQUEST['sidx']); // jqGrid의 sortname 속성의 값
        $sord = check_str($_REQUEST['sord']); // jqGrid의 sortorder 속성의 값

        //검색필드
        $append_query = "";

        if(isset($_REQUEST["select"]) && $_REQUEST["select"] != ""){
            $select = $_REQUEST["select"];
            $select_ids = explode("|", $select);
            
            $append_query = "AND cmFarmid = \"" . $select_ids[0] . "\"";

            $append_query = isset($select_ids[1]) ? $append_query . " AND cmDongid = \"" . $select_ids[1] . "\"" : $append_query;
        }

        //jqgrid 출력
        $select_query = "SELECT cm.*, fd.fdName FROM comein_master AS cm
                        JOIN farm_detail AS fd ON fd.fdFarmid = cm.cmFarmid AND fd.fdDongid = cm.cmDongid 
                        WHERE LENGTH(cmOutdate) > 2 " .$append_query;

        $response = get_jqgrid_data($select_query, $page, $limit, $sidx, $sord);
        echo json_encode($response);

        break;

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

        $avg_history = get_avg_history($code, $_REQUEST["term"], "all");

        switch($_REQUEST["comm"]){
            case "view":
                $response["avg_weight_table"] = $avg_history["table"];
                $response["avg_weight_chart"] = $avg_history["chart"];

                echo json_encode($response);
                break;
            
            case "excel":
                // $title = $farmID . "_" . $dongID . "_평균중량";

                // header("Content-Type: application/vnd.ms-excel");
                // header("Expires: 0");
                // header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
                // header("content-disposition: attachment; filename=" . date('Ymd_His') . "_" . $title . ".xls");

                // $field_data = array(
                //     /*농가 정보*/
                //     array("번호",       "No", "INT", "center"),
                //     array("농장ID",     "awFarmid", "STR", "center"),
                //     array("동ID",       "awDongid", "STR", "center"),
                //     array("산출시간",   "awDate", "STR", "center"),
                //     array("예측중량",   "awWeight", "STR", "center"),
                //     array("권고중량",   "refWeight", "STR", "center"),
                //     array("표준편차",   "awDevi", "STR", "center"),
                //     array("변이계수",   "awVc", "STR", "center"),
                //     array("+1 예측",    "awEstiT1", "STR", "center"),
                //     array("+2 예측",    "awEstiT2", "STR", "center"),
                //     array("+3 예측",    "awEstiT3", "STR", "center"),
                //     array("일령",       "awDays", "STR", "center"),
                //     array("정규분포",   "awNdis", "STR", "left"),
                // );

                // //echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
                // convert_excel(get_select_data($avg_history["query"]), $field_data, $title, $code);
                // break;
                $excel_title = date('Ymd_His') . "_" . $avg_history["name"] . "_평균중량.xls";
				
				$field_data = array(
					/*농가 정보*/
					array("번호", "No", "INT", "center"),
					array("농장ID", "awFarmid", "STR", "center"),
					array("동ID", "awDongid", "STR", "center"),
					array("농장명", "fdName", "STR", "center"),
					array("일령", "awDays", "STR", "center"),
					array("산출시간", "awDate", "STR", "center"),
					array("예측중량", "awWeight", "STR", "center"),
					array("권고중량", "refWeight", "STR", "center"),
					array("표준편차", "awDevi", "STR", "center"),
					array("변이계수", "awVc", "STR", "center"),
					array("+1 예측", "awEstiT1", "STR", "center"),
					array("+2 예측", "awEstiT2", "STR", "center"),
					array("+3 예측", "awEstiT3", "STR", "center"),
					//array("정규분포", "awNdis", "STR", "left"),
				);

				// echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
				$excel_html = convert_excel(get_select_data($avg_history["query"]), $field_data, $excel_title, $code, false);
                
                $response["excel_title"] = $excel_title; 
				$response["excel_html"]  = $excel_html;
				
				echo json_encode($response);

				break;
        }

		break;

    // case "get_error_history":          //오류이력 - 추후에 입추기간만 가져오게 변경
    
    //     $append_query = "AND ccFarmid = \"" . $farmID . "\" AND ccDongid = \"" . $dongID . "\" ORDER BY ccCapDate DESC";

    //     $select_query = "SELECT * FROM capture_camera WHERE ccFarmid = ccFarmid " . $append_query;

    //     $select_data = get_select_data($select_query);

    //     $error_history_data = array();
    //     foreach($select_data as $row){
    //         $error_history_data[] = array(
    //             'f1'  => $row["ccCapDate"],							
    //             'f2'  => $row["ccStatus"],									
    //             'f3'  => "01",									
    //         );
    //     }

    //     $response["error_history_data"] = $error_history_data;
    //     echo json_encode($response);

    //     break;

    case "get_error_history":          //오류이력 - 추후에 입추기간만 가져오게 변경

        $append_query = "AND ccFarmid = \"" . $farmID . "\" AND ccDongid = \"" . $dongID . "\" ORDER BY ccCapDate DESC";

        $select_query = "SELECT * FROM capture_camera WHERE ccFarmid = ccFarmid " . $append_query;

        $select_data = get_select_data($select_query);

		switch($_REQUEST['comm']){
			case "view":
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

			case "excel":
				$error_excel_title = date('Ymd_His')."_" .$farmID. "_" .$dongID. "_오류이력.xls";

				$field_data = array(
					array("번호", "No", "INT", "center"),
					array("오류시간", "ccCapDate", "STR", "center"),
					array("오류상태", "ccStatus", "STR", "center"),
					array("저울번호", "01", "STR", "center"),
				);

				$error_excel_html = convert_excel($select_data, $field_data, $error_excel_title, $code, false);

				$response["error_excel_title"] = $error_excel_title;
				$response["error_excel_html"]  = $error_excel_html;
        		echo json_encode($response);
				break;
		}
		
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

                header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
                header("Expires: 0");
                header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
                header("content-disposition: attachment; filename=" . date('Ymd_His') . "_" . $title . ".xls");

                $field_data = array();
                $field_data[] = array("번호", "No", "INT", "center");
                foreach($result[0] as $key => $val){
                    $field_data[] = array($key, $key, "STR", "center");
                }

                convert_excel($result, $field_data, $title, $code, true);

                break;
        }

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