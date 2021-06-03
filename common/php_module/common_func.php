<?

//Mysql 시작****************************************************
include_once("../../common/php_module/mysql_conn.php");

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

	$total_pages = 0;
	if( $total_len > 0) {
		$total_pages = ceil($total_len / $limit);
	}
	if ($page > $total_pages) {
		$page=$total_pages;
	}
	if ($limit < 0) {
		$limit = 0;
	}

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
function make_combo_by_query($query, $form_name, $default_name, $field){
	$ret = "<select class=\"form-control\" name=\"$form_name\">";

	if($default_name == ""){
		$ret .= "<option value=\"\">전체</option>";
	}
	else{
		$ret .= "<option value=\"\">$default_name</option>";
	}

	$result = get_select_data($query);

	foreach($result as $row){
		$ret .="<option value=\"" . $row[$field] . "\">" . $row[$field] . "</option>";
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
function convert_excel($query, $field_data, $title, $option){
	$result = get_select_data($query);
	$row_len = count($result);
	$colspan = count($field_data) - 1;
	
	$html="<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN' 'http://www.w3.org/TR/html4/loose.dtd'>
			<html>
				<head><meta http-equiv='Content-Type' content='text/html; charset=utf-8'><head>
					<style> table th {background:#A0B3B3;font-weight:normal; text-align:center;color:white} </style>
				<body style='border:solid 0.1pt #CCCCCC;font-size:14px'>
					<table table border='1' style='width:100%;font-size:14px'>
						<tr><th>출력일시</th><td style=\"mso-number-format:'\@'\" colspan='" . $colspan . "'>" . date('Y-m-d H:i:s') . "</td></tr>
						<tr><th>메 뉴 명</th><td style=\"mso-number-format:'\@'\" colspan='" . $colspan . "'>" . $title . "</td></tr>
						<tr><th>검색조건</th><td style=\"mso-number-format:'\@'\" colspan='" . $colspan . "'>" . $option . "</td></tr>
					</table>
					<br><br>";

	if($row_len > 0){
		//헤더출력
		$html .="<table table border='1' style='width:100%;font-size:14px'>";
		$html .="<tr>";
			foreach($field_data as $key => $val){
				$html .="<th>" . $val[0] . "</th>";
			}
		$html .="</tr>";

		//내용출력
		$num = 0;
		foreach($result as $row){
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

/* 문자열을 날짜로 변환
param
- str : 변환할 문자열
return
- ret : 변환된 날짜
*/
function conv_str_to_date($str) {
	$ret = "";
	if ($str != "") {
		$ret = substr($str, 0, 4) ."-". substr($str, 4, 2) ."-". substr($str, 6, 2) ." ". substr($str, 8, 2) .":". substr($str, 10, 2) .":". substr($str, 12, 2);
	}
	return $ret;
};

?>