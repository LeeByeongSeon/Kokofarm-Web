<?

session_start();

include_once("../common/php_module/mysql_conn.php");   	//Mysql
include_once("../common/php_module/mongo_conn.php");	//mongo

define("corr_devi", 1.28);	//표준편차보정=>초기화는 *1임(곱하기)
define("corr_temp", -1.2);	//저울-온도보정
define("corr_humi", 7);		//저울-습도보정
define("corr_co2", 0);		//저울-CO2보정
define("corr_nh3", 0);		//저울-NH3보정
define("feed_hunt", 10);	//사료빈 저울 헌팅값 제거

function buffer_code(){
	$query = "SELECT cmFarmid, cmDongid, MAX(cmCode) AS maxCode FROM comein_master GROUP BY cmFarmid, cmDongid";

	$farm_arr = get_select_data($query);

	foreach($farm_arr as $row){
		$update_map = array();
		$update_map["beComeinCode"] = $row["maxCode"];

		$where = "beFarmid = '" . $row["cmFarmid"] . "' AND beDongid = '" . $row["cmDongid"] . "'";

		run_sql_update("buffer_sensor_status", $update_map, $where);

	}
}

function test_insert(){

	for($k=104; $k<=150; $k++){
		$farmID = "KF" . sprintf("%04d", $k);
		$dongID = "01";
		
		$insert_map = array();
		$insert_map["fID"] = "kk" . sprintf("%04d", $k);
		$insert_map["fPW"] = "kk" . sprintf("%04d", $k);
		$insert_map["fGroupName"] = "이모션";
		$insert_map["fFarmid"] = $farmID;

		run_sql_insert("farm", $insert_map);

		// $insert_map = array();
		// $insert_map["fdFarmid"] = $farmID;
		// $insert_map["fdDongid"] = $dongID;
		// $insert_map["fdName"] 	= "테스터-" . $farmID;
		// $insert_map["fdTel"] 	= "010-5022-1684";
		// $insert_map["fdType"] 	= "육계";
		// $insert_map["fdScale"] 	= "30000";
		// $insert_map["fdAddr"] 	= "연구소";

		// run_sql_insert("farm_detail", $insert_map);

		// // 버퍼테이블 생성
		// $insert_map = array();
		// $insert_map["beFarmid"] = $farmID;
		// $insert_map["beDongid"] = $dongID;

		// run_sql_insert("buffer_sensor_status", $insert_map);
		
		// // 디폴트로 저울 3개를 insert
		// $insert_map = array();
		// $now = date('Y-m-d H:i:s');
		// $insert_map["siFarmid"] = $farmID;
		// $insert_map["siDongid"] = $dongID;
		// $insert_map["siDate"] = $now;
		// for($i=1; $i<=3; $i++){
		// 	$insert_map["siCellid"] = sprintf('%02d', $i);
		// 	run_sql_insert("set_iot_cell", $insert_map);
		// }

		// // 디폴트로 카메라 1개 insert
		// $insert_map = array();
		// $insert_map["scFarmid"] = $farmID;
		// $insert_map["scDongid"] = $dongID;
		// $insert_map["scPort"] = "150" . $dongID;
		// $insert_map["scUrl"] = "/stw-cgi/video.cgi?msubmenu=snapshot&action=view&Resolution=640x480";
		// $insert_map["scId"] = "admin";
		// $insert_map["scPw"] = "kokofarm5561";
		// run_sql_insert("set_camera", $insert_map);
	}

}

// select 결과 데이터 반환
function get_select_data($query){
    $ret = sql_conn::get_inst()->select($query);
	return $ret;
}

// select 결과 데이터 길이 반환
function get_select_count($query){
    $ret = sql_conn::get_inst()->get_select_count($query);
    return $ret;
}

// 인젝션 방지 및 trim
function check_str($str){
    $ret = sql_conn::get_inst()->check_str($str);
	return $ret;
}

/* insert 쿼리 수행
param
- table : insert를 수행할 테이블
- data_map : insert될 필드명-값 쌍 (연관배열)
*/
function run_sql_insert($table, $data_map){
    sql_conn::get_inst()->insert($table, $data_map);
}

/* update 쿼리 수행
param
- table : update를 수행할 테이블
- data_map : update될 필드명-값 쌍 (연관배열)
- where : update문에서 사용할 where절
*/
function run_sql_update($table, $data_map, $where){
    sql_conn::get_inst()->update($table, $data_map, $where);
}

/* delete 쿼리 수행
param
- table : delete 수행할 테이블
- where : delete문에서 사용할 where절
*/
function run_sql_delete($table, $where){
    sql_conn::get_inst()->delete($table, $where);
}

/* jqgrid 데이터 가져오기
param
- query : 표시할 데이터의 select query
- page : jqgrid page 속성 값
- limit : jqgrid 한페이지 표현 raw 개수
- sidx : jqgrid 정렬 기준 필드
- sord : jqgrid 정렬 속성
return
- ret : 현재 페이지에 표시할 데이터
*/
function get_jqgrid_data($query, $page, $limit, $sidx, $sord){

	$ret = array();
	$total_len = get_select_count($query);

	$total_pages = $total_len > 0 ? ceil($total_len / $limit) : 0;
	$page = $page > $total_pages ? $total_pages : $page;
	$limit = $limit < 0 ? 0 : $limit;

	$start = $limit * $page - $limit; // do not put $limit*($page - 1)
	if ($start < 0) {
		$start = 0;
	}

	//jqGrid 속성 및 Data return
	$ret["page"] = $page;
	$ret["total"] = $total_pages;
	$ret["records"] = $total_len;
    $jqgrid_query = $query . " ORDER BY " .$sidx. " " .$sord. " LIMIT " .$start. ", " .$limit. ";";

	$result = get_select_data($jqgrid_query);

	foreach($result as $row){
		$ret["print_data"][] = $row;
	}

	return $ret;
}

/* 구간별 평균중량 데이터 가져오기
param
- comein_code : 입출하 코드
- term : 1시간, 1일 중 어떤 간격으로 가져올지
- type : 출력할 타입 지정 - 하루의 데이터인지 전체 입추구간 데이터인지
return
- ret : 평균중량 데이터
*/
function get_avg_history($comein_code, $term, $type){

	$ret = array();

	$now = date("Y-m-d H:i:s");

	$term_query = $term == "time" ? "RIGHT(aw.awDate, 5) = '00:00' " : "RIGHT(aw.awDate, 8) = '" . substr(get_term_date($now, "-30"), 11, 4) . "0:00'";
	$type_query = "";

	switch($type){
		case "all":
			$type_query = " AND (aw.awDate BETWEEN cm.cmIndate AND 
							(CASE WHEN (cm.cmOutdate is null) THEN NOW() 
								WHEN (cm.cmOutdate = '2000-01-01 00:00:00') THEN NOW() 
							ELSE cm.cmOutdate END))";
			break;
		
		case "day":
			$type_query = " AND (aw.awDate BETWEEN \"" . substr($now, 0, 10) . " 00:00:00\" AND \"" . substr($now, 0, 10) . " 23:59:59\")";
			break;
	}

	$select_query = "SELECT cm.cmCode, DATEDIFF(aw.awDate, cm.cmIndate) + 1 AS days, aw.*, c.cName3 AS refWeight, fd.fdName FROM comein_master AS cm 
						JOIN farm_detail AS fd ON fd.fdFarmid = cm.cmFarmid AND fd.fdDongid = cm.cmDongid 
                        JOIN avg_weight AS aw ON aw.awFarmid = cm.cmFarmid AND aw.awDongid = cm.cmDongid AND " . $term_query . $type_query ." 
                        LEFT JOIN codeinfo AS c ON c.cGroup = '권고중량' AND c.cName1 = cm.cmIntype AND c.cName2 = aw.awDays
                        WHERE cm.cmCode = \"" .$comein_code. "\" ORDER BY aw.awDate ASC";
	
	$select_data = get_select_data($select_query);

	$chart = array();		// 차트에 사용할 데이터
	$increase = array();	// 증체 차트에 사용할 데이터
	$table = array();		// 테이블에 사용할 데이터

	$first = $select_data[0]["awWeight"];
	$last = 0;

	$remark = $type == "all" ? "일령" : "시간";

	foreach($select_data as $val){

		$inc_val = $val["awWeight"] - $first;				// 증체값 계산
		$inc_val = $inc_val >= $last ? $inc_val : $last;	// 계산된 값이 마지막 증체값 보다 작으면 마지막 증체값으로 사용

		$last = $inc_val;		// 마지막 증체값 저장

		$chart[] = array(
			//$remark => substr($val["awDate"], 5, $term == "time" ? 11 : 5),
			$remark => $val["awDate"],
			"평균중량" => sprintf('%0.1f', $val["awWeight"]),
			"권고중량" => sprintf('%0.1f', $val["refWeight"])
		);

		$increase[] = array(
			//$remark => substr($val["awDate"], 5, $term == "time" ? 11 : 5),
			$remark => $val["awDate"],
			"증체중량" => sprintf('%0.1f', $inc_val)
		);

		$table[] = array(
			"f1" => $val["awDate"],
			"f2" => $val["days"],
			"f3" => sprintf('%0.1f', $val["awWeight"]),
			"f4" => sprintf('%0.1f', $val["refWeight"])
		);
	}

	$ret["name"] = $select_data[0]["fdName"];
	$ret["query"] = $select_query;
	$ret["chart"] = $chart;
	$ret["increase"] = $increase;
	$ret["table"] = $table;

	return $ret;
}

//Mysql 종료*********************************************************//

//UI 관련************************************************************//

/* query로 데이터를 불러온 후 콤보박스로 만들어 리턴
param
- query : 콤보박스에 출력할 데이터의 select query
- form_name : 콤보박스의 name
- default_name : 콤보박스에 처음 출력될 값
- field : 쿼리에서 콤보박스로 출력될 필드
return
- ret : 콤보박스 html
*/
function make_combo_by_query($query, $form_name, $default_name, $field, $selected = ""){
	$ret = "<select class=\"form-control w-auto\" name=\"" .$form_name. "\">";

	if($default_name != ""){
		$ret .= "<option value=''>".$default_name."</option>";
	}

	$result = get_select_data($query);

	foreach($result as $row){
		// selected로 받은 값이 있을 경우 selected를 삽입
		$ret .="<option value=\"" . $row[$field] . "\" " .($row[$field] == $selected ? "selected" : ""). ">" . $row[$field] . "</option>";
	}

	$ret .="</select>";

	return $ret;
};

/* 배열을 콤보박스로 만들어 리턴
param
- arr : 콤보박스에 출력할 데이터 배열
- form_name : 콤보박스의 name
- default_name : 콤보박스에 처음 출력될 값
return
- ret : 콤보박스 html
*/
function make_combo_by_array($arr, $form_name, $default_name, $selected = ""){
	$ret = "<select class=\"form-control w-auto\" name=\"" .$form_name. "\">";

	if($default_name != ""){
		$ret .= "<option value=''>".$default_name."</option>";
	}

	foreach($arr as $key => $val){
		// selected로 받은 값이 있을 경우 selected를 삽입
		$ret .="<option value=\"" . $key . "\" " .($key == $selected ? "selected" : ""). ">" . $val . "</option>";
	}

	$ret .="</select>";

	return $ret;
};

/* query로 데이터를 불러온 후 jqgrid edit 형식의 콤보박스 json을 생성
param
- query : 콤보박스에 출력할 데이터의 select query
- field : 쿼리에서 콤보박스로 출력될 필드
return
- ret : 콤보박스 json
*/
function make_jqgrid_combo($query, $field){
	$ret = array();
	$result = get_select_data($query);

	foreach($result as $row){
		$ret[$row[$field]] = $row[$field];
	}
	return json_encode($ret);
};

/* 01부터 입력받은 숫자까지 반복하여 jqgrid edit 형식의 콤보박스 json을 생성
param
- max : 반복할 숫자
return
- ret : 콤보박스 json
*/
function make_jqgrid_combo_num($max){
	$ret = "";
	for($i=1; $i<=$max; $i++){
		$temp = sprintf('%02d', $i);
		$ret .= $i . ":'" . $temp . "', ";
	}
	$ret = "{" . substr($ret, 0, -2) . "}";

	return $ret;
};

//UI 종료************************************************************//

/* 데이터를 엑셀로 변환하여 출력
param
- query : 엑셀로 변환할 데이터의 select 쿼리
- field_data : 필드별 엑셀 변환 정보
- title : 엑셀 파일 제목
- option : 검색 조건
*/
function convert_excel($data, $field_data, $title, $option, $ret=false){
	$row_len = count($data);
	$colspan = count($field_data) - 1;

	$html  = "<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN' 'http://www.w3.org/TR/html4/loose.dtd'>";
	$html .= "<html>";
	$html .= "<head><meta http-equiv='Content-Type' content='application/vnd.ms-excel; charset=utf-8;'></head>";
	$html .= "<style> #excel_table th {background:#A0B3B3; text-align:center; color:white;} </style>";
	$html .= "<body style='border:solid 0.1pt #CCCCCC; font-size:14px'>";
	$html .= "<table id='excel_table' border='1' style='width:100%; font-size:14px'>";
	$html .= "<tr><th>출력일시</th><td style=\"mso-number-format:'\@'\" colspan='" . $colspan . "'>" . date('Y-m-d H:i:s') . "</td></tr>";
	$html .= "<tr><th>메 뉴 명</th><td style=\"mso-number-format:'\@'\" colspan='" . $colspan . "'>" . $title . "</td></tr>";
	$html .= "<tr><th>검색조건</th><td style=\"mso-number-format:'\@'\" colspan='" . $colspan . "'>" . $option . "</td></tr>";
	$html .= "</table>";
	$html .= "<br><br>";

	if($row_len > 0){
		//헤더출력
		$html .="<table border='1' style='width:100%; font-size:14px;'>";
		$html .="<tr>";
			foreach($field_data as $key => $val){
				$html .="<th>" . $val[0] . "</th>";
			}
		$html .="</tr>";

		//내용출력
		$num = 0;
		foreach($data as $row){
			$num++;
			$html .="<tr><th>" . $num . "</th>";

			$contents = "";
			for($i=1; $i<=$colspan; $i++){
				$field_name		= $field_data[$i][1];	
				$field_val   	= $row[$field_name];
				$field_type		= $field_data[$i][2];
				$field_align	= $field_data[$i][3];	

				if(empty($field_val)){ 
					$contents .= "<td></td>"; 
				}
				else{
					switch($field_type){
						case "INT":
							$contents .= "<td style='text-align:" . $field_align . "'>" . number_format($field_val) .  "</td>";
							break;
						case "STR":
							$contents .= "<td style=\"text-align:" . $field_align . ";mso-number-format:'\@'\">" . $field_val .  "</td>";
							break;
						case "DATE":
							$contents .= "<td style=\"text-align:" . $field_align . ";mso-number-format:'\@'\">" . conv_str_to_date($field_val) .  "</td>";
							break;
					}
				}
			}
			$html .= $contents . "</tr>";
		}

		$html .="</table></body></html>";
	}
	if($ret){
		echo $html;
	}
	else{
		return $html;
	}
	
}

// 일단 사용안되지만 유지
function conv_str_to_date($str) {
	$ret = "";
	if ($str != "") {
		$ret = substr($str, 0, 4) ."-". substr($str, 4, 2) ."-". substr($str, 6, 2) ." ". substr($str, 8, 2) .":". substr($str, 10, 2) .":". substr($str, 12, 2);
	}
	return $ret;
};

/* 날짜 차이를 초로 환산
param
- start : 시작시간
- end : 종료시간
return
- ret : 시작시간 ~ 종료시간 차이 (초)
*/
function get_date_diff($start, $end){
	$ret = (strtotime($end) - strtotime($start));
    $ret = (int) $ret;
	return $ret;
}

/* 초를 받아서 일-시-분-초로 변환
param
- second : 시간(초)
return
- ret : 일-시-분-초
*/
function conv_second_to_read($second){
	$day = 24 * 60 * 60; 			// 시 * 분 * 초
	$hour = 60 * 60;				// 분 * 초

	$ret = "";
	if($second > $day){		//1일 이상인 경우
		$temp = ($second - ($second % $day)) / $day ;
		$ret .= $temp . "일 ";
		$second = $second % $day;
	}

	if($second > $hour){	//1시간 이상인 경우
		$temp = ($second - ($second % $hour)) / $hour ;
		$ret .= $temp . "시 ";
		$second = $second % $hour;
	}

	if($second > 60){	//1분 이상인 경우
		$temp = ($second - ($second % 60)) / 60 ;
		$ret .= $temp . "분 ";
		$second = $second % 60;
	}

	$ret .= $second . "초";

	return $ret;
}

/* 분 단위 전후의 시간을 구함
param
- time : 기준시간
- term : 더하거나 뺄 시간 (분)
return
- ret : 기준시간에서 term을 계산한 시간
*/
function get_term_date($time, $term){
	$ret = date("Y-m-d H:i:s", strtotime( $term . " minutes", strtotime($time)));
	return $ret;
}

/* 초미세먼지 좋음, 나쁨 구분
param
- udust : 초미세먼지 수치
return
- ret : 기준시간에서 term을 계산한 시간
*/
function get_udust_status($udust){
	$ret = "좋음";

	if($udust >= 16 && $udust < 36)	{ $ret = "보통"; }
	else if($udust >= 36 && $udust < 76)	{ $ret = "나쁨"; }
	else if($udust >= 76)			{ $ret = "매우나쁨"; }
	else if($udust < 0) 			{ $ret = "-"; }

	return $ret;
}

/* 풍향 구분
param
- direction : 초미세먼지 수치
return
- ret : 기준시간에서 term을 계산한 시간
*/
function get_wind_status($direction){
	$ret = "-";

	$direction = sprintf('%d', $direction);

	switch($direction){
		case 0:
		case 360:
			$ret = "북";
			break;
		case 45:
			$ret = "북동";
			break;
		case 90:
			$ret = "동";
			break;
		case 135:
			$ret = "남동";
			break;
		case 180:
			$ret = "남";
			break;
		case 225:
			$ret = "남서";
			break;
		case 270:
			$ret = "서";
			break;
		case 315:
			$ret = "북서";
			break;
		default : 
			$ret ="-";
			break;
	}

	return $ret;
}

/* 센서값 정규화
param
- udust : 초미세먼지 수치
return
- ret : 기준시간에서 term을 계산한 시간
*/
function check_sensor_val($format, $val){
	$ret = sprintf($format, $val);

	switch($val){
		case 0 : $ret = "-";
			break;
		case -100 : $ret = "-";
			break;
		case -200 : $ret = "-";
			break;
	}

	return $ret;
}


// 몽고db 관련---------------------------------------------------------------------------

/* aggregate 하여 데이터를 가져옴
param
- db : 데이터를 가져올 데이터베이스 이름
- coll : 데이터를 가져올 컬렉션 이름
- pipe : aggregate 파이프라인
return
- ret : aggregate 결과값을 배열로 정리
*/
function get_aggregate_data($db, $coll, $pipe){
    return mongo_conn::get_inst()->aggregate($db, $coll, $pipe);
}

function get_sensor_history_row($code, $type){
	$ret = array();

	$id = explode("_", $code)[1];
	$farmID = substr($id, 0, 6);
	$dongID = substr($id, 6);

	$select_query = "SELECT *, IFNULL(DATEDIFF(current_date(), cmIndate) + 1, 0) AS interm FROM comein_master WHERE cmCode = \"" .$code. "\""; 
	$select_data = get_select_data($select_query);
	
	if($select_data > 0){
		$comein_data = get_select_data($select_query)[0];

		$now = date("Y-m-d H:i:s");

		$start_time = $comein_data["cmIndate"];
		$end_time = $comein_data["cmOutdate"] == "" ? $now : $comein_data["cmOutdate"];

		$start_time = substr($start_time, 0, 13) . ":00:00";
		$end_time = substr($end_time, 0, 13) . ":00:00";

		$history_query = "SELECT * FROM sensor_history WHERE shFarmid = \"" .$farmID. "\" AND shdongid = \"" .$dongID. "\" AND ";

		switch($type){
			case "get_all":
				$history_query .= " (shDate BETWEEN \"" .$start_time. "\" AND \"" .$end_time. "\")";
				break;
			
			case "get_today":
				$history_query .= " (shDate BETWEEN \"" . substr($now, 0, 10) . " 00:00:00\" AND \"" . substr($now, 0, 10) . " 23:59:59\")";
				break;
		}

		$ret = get_select_data($history_query);
	}

	return $ret;
}

/* 급이량 및 급수량 데이터를 가져옴
param
- code : 입출하코드
- type : 일령별 또는 오늘 데이터를 가져올지 선택
return
- ret : aggregate 결과값을 배열로 정리
*/
function get_feed_history($code, $type){
	$ret = array();

	$history_data = get_sensor_history_row($code, $type);
	
	if($history_data > 0){

		$chart_feed = array();
		$chart_water = array();

		$chart_feed_stack = array();
		$chart_water_stack = array();

		$chart_feed_daily = array();
		$chart_water_daily = array();

		$feed_stack = 0;
		$water_stack = 0;

		$table = array();

		$day_map = array();

		foreach($history_data as $val){

			$json = json_decode($val["shFeedData"]);

			// 2021-11-11 이병선 시간 60분전으로 계산
			$sensor_date = $val["shDate"];
			//$sensor_date = get_term_date($val["shDate"], -60);
			$feed = $json->feed_feed;
			$water = $json->feed_water;

			// 2021-11-08 이병선 급이 (-) 값 수정
			$feed = abs($feed) <= feed_hunt ? 0 : $feed;
			
			$date = substr($sensor_date, 0, 10);
			$day_map[$date]["feed"] = isset($day_map[$date]["feed"]) ? $day_map[$date]["feed"] + $feed : $feed;
			$day_map[$date]["water"] = isset($day_map[$date]["water"]) ? $day_map[$date]["water"] + $water : $water;

			$chart_feed[] = array(
				"시간" => $sensor_date,
				"급이량(kg)" => $feed,
			);

			$chart_water[] = array(
				"시간" => $sensor_date,
				"급수량(L)" => $water,
			);

			$feed_stack = $feed_stack + $feed;
			$chart_feed_stack[] = array(
				"시간" => $sensor_date,
				"누적급이량(kg)" => $feed_stack,
			);

			$water_stack = $water_stack + $water;
			$chart_water_stack[] = array(
				"시간" => $sensor_date,
				"누적급수량(L)" => $water_stack,
			);

			$table[] = array(
				"f1" => $sensor_date,
				"f2" => $feed,
				"f3" => $water,
			);
		}

		foreach($day_map as $key => $val){

			$chart_feed_daily[] = array(
				"시간" => $key,
				"급이량(kg)" => $val["feed"],
			);
			$chart_water_daily[] = array(
				"시간" => $key,
				"급수량(L)" => $val["water"],
			);
		}

		$ret["chart_feed"] = $chart_feed;
		$ret["chart_water"] = $chart_water;
		$ret["chart_feed_stack"] = $chart_feed_stack;
		$ret["chart_water_stack"] = $chart_water_stack;
		$ret["chart_feed_daily"] = $chart_feed_daily;
		$ret["chart_water_daily"] = $chart_water_daily;
		$ret["table"] = $table;
	}

	return $ret;
}
// function get_feed_history($code, $type){

// 	$ret = array();

// 	$id = explode("_", $code)[1];
// 	$farmID = substr($id, 0, 6);
// 	$dongID = substr($id, 6);

// 	$select_query = "SELECT *, IFNULL(DATEDIFF(current_date(), cmIndate) + 1, 0) AS interm FROM comein_master WHERE cmCode = \"" .$code. "\""; 
// 	$comein_data = get_select_data($select_query)[0];

// 	$start_time = $comein_data["cmIndate"];
// 	$end_time = $comein_data["cmOutdate"] == "" ? date("Y-m-d H:i:s") : $comein_data["cmOutdate"];
// 	$order = 1;

// 	$pipe_sort  =   [ '$sort' => ['_id' => $order] ];

// 	$pipe_project = [
// 		'$project' => [
// 			'_id' => 1,
// 			'feed' => [
// 				'$reduce' => [
// 					'input' => '$feedval',
// 					'initialValue' => ['feed' => 0],
// 					'in' => ['feed' => ['$add' => [ '$$value.feed', '$$this' ] ] ]
// 				]
// 			],
// 			'water' => [
// 				'$reduce' => [
// 					'input' => '$waterval',
// 					'initialValue' => ['water' => 0],
// 					'in' => ['water' => ['$add' => [ '$$value.water', '$$this' ] ] ]
// 				]
// 			]
// 		]
// 	];

// 	$pipe_branches = array();

// 	switch($type){

// 		case "get_all":
// 			$end_time = substr($end_time, 0, 10) . " 00:00:00";
// 			$end_time = get_term_date($end_time, 1440);

// 			$pipe_match =   [ '$match' => ['farmID' => $farmID, 'dongID' => $dongID, 'getTime' => ['$gte' => $start_time, '$lte' => $end_time] ] ];

// 			$iter_time = substr($start_time, 0, 10) . " 00:00:00";		// 일령별로 자르기 위함
// 			while($iter_time != $end_time){
// 				$pipe_branches[] = [
// 					'case' => [
// 						'$and' => [ 
// 							['$gte' => ['$getTime', $iter_time]],
// 							['$lte' => ['$getTime', substr($iter_time, 0, 10) . " 23:59:59"]],
// 						]
// 					],
// 					'then' => $iter_time
// 				];

// 				$iter_time = get_term_date($iter_time, 1440);
// 			}

// 			break;

// 		case "get_today":
// 			$start_time = $comein_data["interm"] > 1 ? substr(date("Y-m-d H:i:s"), 0, 10) . " 00:00:00" : substr($start_time, 0, 15) . "0:00";
// 			$end_time = substr($end_time, 0, 15) . "0:00";

// 			$pipe_match =   [ '$match' => ['farmID' => $farmID, 'dongID' => $dongID, 'getTime' => ['$gte' => $start_time, '$lte' => $end_time] ] ];

// 			$iter_time = $start_time;
// 			while($iter_time != $end_time){
// 				$pipe_branches[] = [
// 					'case' => [
// 						'$and' => [ 
// 							['$gte' => ['$getTime', $iter_time]],
// 							['$lte' => ['$getTime', substr($iter_time, 0, 15) . "9:59"]],
// 						]
// 					],
// 					'then' => $iter_time
// 				];

// 				$iter_time = get_term_date($iter_time, 10);
// 			}

// 			break;
// 	}

// 	$pipe_group = [ 
// 		'$group' => [
// 			'_id' => [ 
// 				'$switch' => [ 
// 					'branches' => $pipe_branches,
// 					'default' => 'default value'
// 				] 
// 			],
// 			'feedval' => [ '$push' => '$feedWeightval' ],
// 			'waterval' => [ '$push' => '$feedWaterval' ],
// 		] 
// 	];

// 	$pipeline = [ $pipe_match, $pipe_group, $pipe_sort, $pipe_project];

// 	$result = get_aggregate_data("kokofarm1", "sensorExtData", $pipeline);

// 	$remark = $type == "get_all" ? "일령" : "시간";

// 	$chart_feed = array();
// 	$chart_water = array();

// 	$chart_feed_stack = array();
// 	$chart_water_stack = array();

// 	$feed_stack = 0;
// 	$water_stack = 0;

// 	$table = array();

// 	// 차트데이터로 변환
// 	for($i=0; $i<count($result); $i++){
// 		$val = $result[$i];

// 		$chart_feed[] = array(
// 			$remark => $val->_id,
// 			"급이량" => $val->feed->feed,
// 		);

// 		$chart_water[] = array(
// 			$remark => $val->_id,
// 			"급수량" => $val->water->water,
// 		);

// 		$feed_stack = $feed_stack + $val->feed->feed;
// 		$chart_feed_stack[] = array(
// 			$remark => $val->_id,
// 			"누적급이량" => $feed_stack,
// 		);

// 		$water_stack = $water_stack + $val->water->water;
// 		$chart_water_stack[] = array(
// 			$remark => $val->_id,
// 			"누적급수량" => $water_stack,
// 		);

// 		$table[] = array(
// 			"f1" => $val->_id,
// 			"f2" => $val->feed->feed,
// 			"f3" => $val->water->water,
// 		);
// 	}

// 	$ret["chart_feed"] = $chart_feed;
// 	$ret["chart_water"] = $chart_water;
// 	$ret["chart_feed_stack"] = $chart_feed_stack;
// 	$ret["chart_water_stack"] = $chart_water_stack;
// 	$ret["table"] = $table;

// 	return $ret;
// }

/* 외기환경 데이터를 가져옴
param
- code : 입출하코드
- type : 일령별 또는 오늘 데이터를 가져올지 선택
return
- ret : aggregate 결과값을 배열로 정리
*/
function get_outsensor_history($code, $type){
	$ret = array();

	$history_data = get_sensor_history_row($code, $type);
	
	if($history_data > 0){

		$chart_temp_humi = array();
		$chart_gas = array();
		$chart_dust = array();
		$chart_wind = array();

		$table_temp_humi = array();
		$table_gas = array();
		$table_dust = array();
		$table_wind = array();

		// 차트데이터로 변환
		foreach($history_data as $val){

			$json = json_decode($val["shExtSensorData"]);

			$sensor_date = $val["shDate"];
			$ext_temp = $json->ext_temp;
			$ext_humi = $json->ext_humi;
			$ext_nh3 = $json->ext_nh3;
			$ext_h2s = $json->ext_h2s;
			$ext_dust = $json->ext_dust;
			$ext_udust = $json->ext_udust;
			$ext_wdirec = $json->ext_wdirec;
			$ext_wspeed = $json->ext_wspeed;

			$chart_temp_humi[] = array(
				"시간" => $sensor_date,
				"온도" => $ext_temp,
				"습도" => $ext_humi,
			);

			$chart_gas[] = array(
				"시간" => $sensor_date,
				"암모니아" => $ext_nh3,
				"황화수소" => $ext_h2s,
			);

			$chart_dust[] = array(
				"시간" => $sensor_date,
				"미세먼지" => $ext_dust,
				"초미세먼지" => $ext_udust,
			);

			$chart_wind[] = array(
				"시간" => $sensor_date,
				"풍향" => $ext_wdirec,
				"풍속" => $ext_wspeed,
			);

			$table_temp_humi[] = array(
				"f1" => $sensor_date,
				"f2" => $ext_temp,
				"f3" => $ext_humi,
			);

			$table_gas[] = array(
				"f1" => $sensor_date,
				"f2" => $ext_nh3,
				"f3" => $ext_h2s,
			);

			$table_dust[] = array(
				"f1" => $sensor_date,
				"f2" => $ext_dust,
				"f3" => $ext_udust,
			);

			$table_wind[] = array(
				"f1" => $sensor_date,
				"f2" => $ext_wdirec,
				"f3" => $ext_wspeed,
			);
		}

		$ret["chart_temp_humi"] = $chart_temp_humi;
		$ret["chart_gas"] = $chart_gas;
		$ret["chart_dust"] = $chart_dust;
		$ret["chart_wind"] = $chart_wind;
		
		$ret["table_temp_humi"] = $table_temp_humi;
		$ret["table_gas"] = $table_gas;
		$ret["table_dust"] = $table_dust;
		$ret["table_wind"] = $table_wind;
	}

	return $ret;
}
// function get_outsensor_history($code, $type){
// 	$ret = array();

// 	$id = explode("_", $code)[1];
// 	$farmID = substr($id, 0, 6);
// 	$dongID = substr($id, 6);

// 	$select_query = "SELECT *, IFNULL(DATEDIFF(current_date(), cmIndate) + 1, 0) AS interm FROM comein_master WHERE cmCode = \"" .$code. "\""; 
// 	$comein_data = get_select_data($select_query)[0];

// 	$start_time = $comein_data["cmIndate"];
// 	$end_time = $comein_data["cmOutdate"] == "" ? date("Y-m-d H:i:s") : $comein_data["cmOutdate"];
// 	$order = 1;

// 	$pipe_sort  =   [ '$sort' => ['getTime' => $order] ];

// 	switch($type){
// 		case "get_all":
// 			$pipe_addfield = [ '$addFields' => ['minu' => ['$substr' => ['$getTime', 14, 2] ] ] ];			// 1시간 단위로 가져옴
// 			$pipe_match =   [ '$match' => ['farmID' => $farmID, 'dongID' => $dongID, 'getTime' => ['$gte' => $start_time, '$lte' => $end_time], 'minu' => ['$eq' => '00']] ];

// 			break;

// 		case "get_today":
// 			$start_time = $comein_data["interm"] > 1 ? substr(date("Y-m-d H:i:s"), 0, 10) . " 00:00:00" : substr($start_time, 0, 15) . "0:00";
// 			$end_time = substr($end_time, 0, 15) . "0:00";

// 			$pipe_addfield = [ '$addFields' => ['minu' => ['$substr' => ['$getTime', 15, 1] ] ] ];			// 10분 단위로 가져옴
// 			$pipe_match =   [ '$match' => ['farmID' => $farmID, 'dongID' => $dongID, 'getTime' => ['$gte' => $start_time, '$lte' => $end_time], 'minu' => ['$eq' => '0']] ];

// 			break;
// 	}

// 	$pipeline = [ $pipe_addfield, $pipe_match, $pipe_sort ];

// 	$result = get_aggregate_data("kokofarm1", "sensorExtData", $pipeline);

// 	$chart_temp_humi = array();
// 	$chart_gas = array();
// 	$chart_dust = array();
// 	$chart_wind = array();

// 	$table_temp_humi = array();
// 	$table_gas = array();
// 	$table_dust = array();
// 	$table_wind = array();

// 	// 차트데이터로 변환
// 	for($i=0; $i<count($result); $i++){
// 		$val = $result[$i];

// 		$chart_temp_humi[] = array(
// 			"시간" => $val->getTime,
// 			"온도" => $val->outTemp,
// 			"습도" => $val->outHumi,
// 		);

// 		$chart_gas[] = array(
// 			"시간" => $val->getTime,
// 			"암모니아" => $val->outNh3,
// 			"황화수소" => $val->outH2s,
// 		);

// 		$chart_dust[] = array(
// 			"시간" => $val->getTime,
// 			"미세먼지" => $val->outDust,
// 			"초미세먼지" => $val->outUDust,
// 		);

// 		$chart_wind[] = array(
// 			"시간" => $val->getTime,
// 			"풍향" => $val->outWinderec,
// 			"풍속" => $val->outWindspeed,
// 		);

// 		$table_temp_humi[] = array(
// 			"f1" => $val->getTime,
// 			"f2" => $val->outTemp,
// 			"f3" => $val->outHumi,
// 		);

// 		$table_gas[] = array(
// 			"f1" => $val->getTime,
// 			"f2" => $val->outNh3,
// 			"f3" => $val->outH2s,
// 		);

// 		$table_dust[] = array(
// 			"f1" => $val->getTime,
// 			"f2" => $val->outDust,
// 			"f3" => $val->outUDust,
// 		);

// 		$table_wind[] = array(
// 			"f1" => $val->getTime,
// 			"f2" => $val->outWinderec,
// 			"f3" => $val->outWindspeed,
// 		);
// 	}

// 	$ret["chart_temp_humi"] = $chart_temp_humi;
// 	$ret["chart_gas"] = $chart_gas;
// 	$ret["chart_dust"] = $chart_dust;
// 	$ret["chart_wind"] = $chart_wind;
	
// 	$ret["table_temp_humi"] = $table_temp_humi;
// 	$ret["table_gas"] = $table_gas;
// 	$ret["table_dust"] = $table_dust;
// 	$ret["table_wind"] = $table_wind;

// 	return $ret;
// }

/* 저울 센서 데이터를 가져옴
param
- code : 입출하코드
- type : 일령별 또는 오늘 데이터를 가져올지 선택
return
- ret : aggregate 결과값을 배열로 정리
*/
function get_cell_history($code, $type){
	$ret = array();

	$history_data = get_sensor_history_row($code, $type);
	
	if($history_data > 0){

		$chart_temp = array();
		$chart_humi = array();
		$chart_co2 = array();
		$chart_nh3 = array();

		$table = array();

		// 차트데이터로 변환
		foreach($history_data as $val){

			$json = json_decode($val["shSensorData"]);

			$sensor_date = $val["shDate"];
			$avg_temp = $json->cell_temp;
			$avg_humi = $json->cell_humi;
			$avg_co2 = $json->cell_co2;
			$avg_nh3 = $json->cell_nh3;

			$chart_temp[] = array(
				"시간" => $sensor_date,
				"온도" => $avg_temp,
			);

			$chart_humi[] = array(
				"시간" => $sensor_date,
				"습도" => $avg_humi,
			);

			$chart_co2[] = array(
				"시간" => $sensor_date,
				"이산화탄소" => $avg_co2,
			);

			$chart_nh3[] = array(
				"시간" => $sensor_date,
				"암모니아" => $avg_nh3,
			);

			$table[] = array(
				"f1" => $sensor_date,
				"f2" => $avg_temp,
				"f3" => $avg_humi,
				"f4" => $avg_co2,
				"f5" => $avg_nh3,
			);
		}

		$ret["chart_temp"] = $chart_temp;
		$ret["chart_humi"] = $chart_humi;
		$ret["chart_co2"] = $chart_co2;
		$ret["chart_nh3"] = $chart_nh3;
		
		$ret["table"] = $table;
	}

	return $ret;
}

// function get_cell_history($code, $type){
// 	$ret = array();

// 	$id = explode("_", $code)[1];
// 	$farmID = substr($id, 0, 6);
// 	$dongID = substr($id, 6);

// 	$select_query = "SELECT *, IFNULL(DATEDIFF(current_date(), cmIndate) + 1, 0) AS interm FROM comein_master WHERE cmCode = \"" .$code. "\""; 
// 	$comein_data = get_select_data($select_query)[0];

// 	$start_time = $comein_data["cmIndate"];
// 	$end_time = $comein_data["cmOutdate"] == "" ? date("Y-m-d H:i:s") : $comein_data["cmOutdate"];
// 	$order = 1;

// 	$pipe_sort  =   [ '$sort' => ['_id' => $order] ];

// 	switch($type){
// 		case "get_all":
// 			$pipe_addfield = [ '$addFields' => [						// 1시간 단위로 가져옴
// 				'minu' => ['$substr' => ['$getTime', 14, 2] ], 
// 				'group_time' => ['$substr' => ['$getTime', 0, 16] ]
// 			]];	
// 			$pipe_match =   [ '$match' => ['farmID' => $farmID, 'dongID' => $dongID, 'getTime' => ['$gte' => $start_time, '$lte' => $end_time], 'minu' => ['$eq' => '00']] ];

// 			break;

// 		case "get_today":
// 			$start_time = $comein_data["interm"] > 1 ? substr(date("Y-m-d H:i:s"), 0, 10) . " 00:00:00" : substr($start_time, 0, 15) . "0:00";
// 			$end_time = substr($end_time, 0, 15) . "0:00";

// 			$pipe_addfield = [ '$addFields' => [						// 10분 단위로 가져옴
// 				'minu' => ['$substr' => ['$getTime', 15, 1] ], 
// 				'group_time' => ['$substr' => ['$getTime', 0, 16] ]
// 			]];
// 			$pipe_match =   [ '$match' => ['farmID' => $farmID, 'dongID' => $dongID, 'getTime' => ['$gte' => $start_time, '$lte' => $end_time], 'minu' => ['$eq' => '0']] ];

// 			break;
// 	}

// 	$pipe_group  =   [ '$group' => [
// 		'_id' => '$group_time',
// 		'avg_temp' => ['$avg' => '$temp'],
// 		'avg_humi' => ['$avg' => '$humi'],
// 		'avg_co'   => ['$avg' => '$co'],
// 		'avg_nh'   => ['$avg' => '$nh']
// 	] ];

// 	$pipeline = [ $pipe_addfield, $pipe_match, $pipe_group, $pipe_sort ];

// 	$result = get_aggregate_data("kokofarm1", "sensorData", $pipeline);

// 	$chart_temp = array();
// 	$chart_humi = array();
// 	$chart_co2 = array();
// 	$chart_nh3 = array();

// 	$table = array();

// 	// 차트데이터로 변환
// 	for($i=0; $i<count($result); $i++){
// 		$val = $result[$i];

// 		$chart_temp[] = array(
// 			"시간" => $val->_id . ":00",
// 			"온도" => $val->avg_temp,
// 		);

// 		$chart_humi[] = array(
// 			"시간" => $val->_id . ":00",
// 			"습도" => $val->avg_humi,
// 		);

// 		$chart_co2[] = array(
// 			"시간" => $val->_id . ":00",
// 			"이산화탄소" => $val->avg_co,
// 		);

// 		$chart_nh3[] = array(
// 			"시간" => $val->getTime . ":00",
// 			"암모니아" => $val->avg_nh,
// 		);

// 		$table[] = array(
// 			"f1" => $val->_id . ":00",
// 			"f2" => $val->avg_temp,
// 			"f3" => $val->avg_humi,
// 			"f4" => $val->avg_co,
// 			"f5" => $val->avg_nh,
// 		);
// 	}

// 	$ret["chart_temp"] = $chart_temp;
// 	$ret["chart_humi"] = $chart_humi;
// 	$ret["chart_co2"] = $chart_co2;
// 	$ret["chart_nh3"] = $chart_nh3;
	
// 	$ret["table"] = $table;

// 	return $ret;
// }

// function get_test($code, $type){
// 	$ret = array();

// 	$id = explode("_", $code)[1];
// 	$farmID = substr($id, 0, 6);
// 	$dongID = substr($id, 6);

// 	$select_query = "SELECT *, IFNULL(DATEDIFF(current_date(), cmIndate) + 1, 0) AS interm FROM comein_master WHERE cmCode = \"" .$code. "\""; 
// 	$comein_data = get_select_data($select_query)[0];

// 	$start_time = $comein_data["cmIndate"];
// 	$end_time = $comein_data["cmOutdate"] == "" ? date("Y-m-d H:i:s") : $comein_data["cmOutdate"];
// 	$order = 1;

// 	$pipe_sort  =   [ '$sort' => ['getTime' => $order] ];

// 	switch($type){
// 		case "get_all":
// 			$pipe_match =   [ '$match' => ['farmID' => $farmID, 'dongID' => $dongID, 'getTime' => ['$gte' => $start_time, '$lte' => $end_time] ] ];

// 			break;

// 		case "get_today":
// 			$start_time = $comein_data["interm"] > 1 ? substr(date("Y-m-d H:i:s"), 0, 10) . " 00:00:00" : substr($start_time, 0, 15) . "0:00";
// 			$end_time = substr($end_time, 0, 15) . "0:00";
// 			$pipe_match =   [ '$match' => ['farmID' => $farmID, 'dongID' => $dongID, 'getTime' => ['$gte' => $start_time, '$lte' => $end_time] ] ];

// 			break;
// 	}

// 	$pipe_project = [ '$project' => [
// 		'farmID' => 1, 'dongID' => 1, 'getTiem' => 1, 'temp' => 1, 'humi' => 1, 'co' => 1, 'no' => 1
// 	]];

// 	$pipeline = [ $pipe_match, $pipe_sort, $pipe_project ];

// 	$result = get_aggregate_data("kokofarm3", "sensorData", $pipeline);

// 	$chart_temp = array();
// 	$chart_humi = array();
// 	$chart_co2 = array();
// 	$chart_nh3 = array();

// 	$table = array();

// 	// 차트데이터로 변환
// 	for($i=0; $i<count($result); $i++){
// 		$val = $result[$i];

// 		$chart_temp[] = array(
// 			"시간" => $val->getTime,
// 			"온도" => $val->temp,
// 		);

// 		$chart_humi[] = array(
// 			"시간" => $val->getTime,
// 			"습도" => $val->humi,
// 		);

// 		$chart_co2[] = array(
// 			"시간" => $val->getTime,
// 			"이산화탄소" => $val->co,
// 		);

// 		$chart_nh3[] = array(
// 			"시간" => $val->getTime,
// 			"암모니아" => $val->no,
// 		);

// 		$table[] = array(
// 			"f1" => $val->getTime,
// 			"f2" => $val->temp,
// 			"f3" => $val->humi,
// 			"f4" => $val->co,
// 			"f5" => $val->nh,
// 		);
// 	}

// 	$ret["chart_temp"] = $chart_temp;
// 	$ret["chart_humi"] = $chart_humi;
// 	$ret["chart_co2"] = $chart_co2;
// 	$ret["chart_nh3"] = $chart_nh3;
	
// 	$ret["table"] = $table;

// 	return $ret;
// }

?>