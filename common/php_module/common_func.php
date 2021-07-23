<?

session_start();

include_once("../../common/php_module/mysql_conn.php");   	//Mysql
include_once("../../common/php_module/mongo_conn.php");	//mongo

// set_iot_cell 데이터 삽입용
// function cell_all(){
// 	$query = "SELECT * FROM farm_detail";

// 	$farm_arr = get_select_data($query);
// 	foreach($farm_arr as $row){
// 		$insert_map = array();
// 		$insert_map["siFarmid"] = $row["fdFarmid"];
// 		$insert_map["siDongid"] = $row["fdDongid"];

// 		$now = date('Y-m-d H:i:s');
// 		$insert_map["siDate"] = $now;
// 		for($i=1; $i<=3; $i++){
// 			$insert_map["siCellid"] = sprintf('%02d', $i);
// 			run_sql_insert("set_iot_cell", $insert_map);
// 		}
// 	}
// }

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

	$select_query = "SELECT cm.cmCode, DATEDIFF(aw.awDate, cm.cmIndate) + 1 AS days, aw.*, c.cName3 AS refWeight FROM comein_master AS cm 
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
function convert_excel($data, $field_data, $title, $option){
	$row_len = count($data);
	$colspan = count($field_data) - 1;
	
	$html="<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN' 'http://www.w3.org/TR/html4/loose.dtd'>
			<html>
				<head><meta http-equiv='Content-Type' content='text/html; charset=utf-8'><head>
					<style> table th {background:#A0B3B3;font-weight:normal; text-align:center; color:white;} </style>
				<body style='border:solid 0.1pt #CCCCCC;font-size:14px'>
					<table table border='1' style='width:100%;font-size:14px'>
						<tr><th>출력일시</th><td style=\"mso-number-format:'\@'\" colspan='" . $colspan . "'>" . date('Y-m-d H:i:s') . "</td></tr>
						<tr><th>메 뉴 명</th><td style=\"mso-number-format:'\@'\" colspan='" . $colspan . "'>" . $title . "</td></tr>
						<tr><th>검색조건</th><td style=\"mso-number-format:'\@'\" colspan='" . $colspan . "'>" . $option . "</td></tr>
					</table>
					<br><br>";

	if($row_len > 0){
		//헤더출력
		$html .="<table table border='1' style='width:100%; font-size:14px;'>";
		$html .="<tr>";
			foreach($field_data as $key => $val){
				$html .="<th>" . $val[0] . "</th>";
			}
		$html .="</tr>";

		//내용출력
		$num = 0;
		foreach($data as $row){
			$num++;
			$html .="<tr><td>" . $num . "</td>";

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
							$contents .= "<td style=\"text-align:" . $field_align . "\">" . number_format($field_val) .  "</td>";
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
	echo $html;
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

function get_feed_history($code, $type){

	$ret = array();

	$id = explode("_", $code)[1];
	$farmID = substr($id, 0, 6);
	$dongID = substr($id, 6);

	$select_query = "SELECT *, IFNULL(DATEDIFF(current_date(), cmIndate) + 1, 0) AS interm FROM comein_master WHERE cmCode = \"" .$code. "\""; 
	$comein_data = get_select_data($select_query)[0];

	$start_time = $comein_data["cmIndate"];
	$end_time = $comein_data["cmOutdate"] == "" ? date("Y-m-d H:i:s") : $comein_data["cmOutdate"];
	$order = 1;

	$pipe_sort  =   [ '$sort' => ['_id' => $order] ];

	$pipe_project = [
		'$project' => [
			'_id' => 1,
			'feed' => [
				'$reduce' => [
					'input' => '$feedval',
					'initialValue' => ['feed' => 0],
					'in' => ['feed' => ['$add' => [ '$$value.feed', '$$this' ] ] ]
				]
			],
			'water' => [
				'$reduce' => [
					'input' => '$waterval',
					'initialValue' => ['water' => 0],
					'in' => ['water' => ['$add' => [ '$$value.water', '$$this' ] ] ]
				]
			]
		]
	];

	$pipe_branches = array();

	switch($type){

		case "get_all":
			$start_time = substr($start_time, 0, 10) . " 00:00:00";
			$end_time = substr($end_time, 0, 10) . " 00:00:00";
			$end_time = get_term_date($end_time, 1440);

			$pipe_match =   [ '$match' => ['farmID' => $farmID, 'dongID' => $dongID, 'getTime' => ['$gte' => $start_time, '$lte' => $end_time] ] ];

			$iter_time = $start_time;
			while($iter_time != $end_time){
				$pipe_branches[] = [
					'case' => [
						'$and' => [ 
							['$gte' => ['$getTime', $iter_time]],
							['$lte' => ['$getTime', substr($iter_time, 0, 10) . " 23:59:59"]],
						]
					],
					'then' => $iter_time
				];

				$iter_time = get_term_date($iter_time, 1440);
			}

			break;

		case "get_today":
			$start_time = $comein_data["interm"] > 1 ? substr(date("Y-m-d H:i:s"), 0, 10) . " 00:00:00" : substr($start_time, 0, 15) . "0:00";
			$end_time = substr($end_time, 0, 15) . "0:00";

			$pipe_match =   [ '$match' => ['farmID' => $farmID, 'dongID' => $dongID, 'getTime' => ['$gte' => $start_time, '$lte' => $end_time] ] ];

			$iter_time = $start_time;
			while($iter_time != $end_time){
				$pipe_branches[] = [
					'case' => [
						'$and' => [ 
							['$gte' => ['$getTime', $iter_time]],
							['$lte' => ['$getTime', substr($iter_time, 0, 15) . "9:59"]],
						]
					],
					'then' => $iter_time
				];

				$iter_time = get_term_date($iter_time, 10);
			}

			break;
	}

	$pipe_group = [ 
		'$group' => [
			'_id' => [ 
				'$switch' => [ 
					'branches' => $pipe_branches,
					'default' => 'default value'
				] 
			],
			'feedval' => [ '$push' => '$feedWeightval' ],
			'waterval' => [ '$push' => '$feedWaterval' ],
		] 
	];

	$pipeline = [ $pipe_match, $pipe_group, $pipe_project, $pipe_sort];

	$result = get_aggregate_data("kokofarm1", "sensorExtData", $pipeline);

	$remark = $type == "get_all" ? "일령" : "시간";

	$chart_feed = array();
	$chart_water = array();

	$chart_feed_stack = array();
	$chart_water_stack = array();

	$feed_stack = 0;
	$water_stack = 0;

	// 차트데이터로 변환
	for($i=0; $i<count($result); $i++){
		$val = $result[$i];

		$chart_feed[] = array(
			$remark => $val->_id,
			"급이량" => $val->feed->feed,
		);

		$chart_water[] = array(
			$remark => $val->_id,
			"급수량" => $val->water->water,
		);

		$feed_stack = $feed_stack + $val->feed->feed;
		$chart_feed_stack[] = array(
			$remark => $val->_id,
			"누적급이량" => $feed_stack,
		);

		$water_stack = $water_stack + $val->water->water;
		$chart_water_stack[] = array(
			$remark => $val->_id,
			"누적급수량" => $water_stack,
		);

		$table[] = array(
			"f1" => $val->_id,
			"f2" => $val->feed->feed,
			"f3" => $val->water->water,
		);
	}

	$ret["chart_feed"] = $chart_feed;
	$ret["chart_water"] = $chart_water;
	$ret["chart_feed_stack"] = $chart_feed_stack;
	$ret["chart_water_stack"] = $chart_water_stack;
	$ret["table"] = $table;

	return $ret;
}

?>