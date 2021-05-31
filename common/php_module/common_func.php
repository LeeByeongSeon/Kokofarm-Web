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
		$ret .= "<option value=\"\">$defaultName</option>";
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

// function test(){
// 	$query = "SELECT * FROM farm_detail";
// 	$result = get_select_data($query);

// 	foreach($result as $row){
// 		$insert_map = array();
		
// 		for($i=1; $i<=3; $i++){
// 			$insert_map["siFarmid"] = $row["fdFarmid"];
// 			$insert_map["siDongid"] = $row["fdDongid"];
// 			$insert_map["siCellid"] = "0" . $i;
// 			$insert_map["siVersion"] = "3.0";
// 			$insert_map["siFirmware"] = "3.2";
// 			$insert_map["siDate"] = date('Y-m-d H:i:s');
// 			$insert_map["siHaveTemp"] = "y";
// 			$insert_map["siHaveHumi"] = "y";
// 			$insert_map["siHaveCo2"] = "y";
// 			$insert_map["siHaveNh3"] = "n";

// 			run_sql_insert("set_iot_cell", $insert_map);
// 		}
		
// 	}
// }

?>