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

?>