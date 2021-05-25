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



//Mysql 종료*********************************************************//

?>