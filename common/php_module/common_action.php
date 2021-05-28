<?

include_once("../../common/php_module/common_func.php");

$response = array();

// 어떤 작업인지 가져옴
$oper = isset($_REQUEST["oper"]) ? $oper = check_str($_REQUEST["oper"]) : "";

switch($oper){
	case "get_tree":
		$search = isset($_REQUEST["search"]) ? $search = check_str($_REQUEST["search"]) : "";

		//검색필드
		$select_query = "SELECT * FROM farm_detail ";

        $append_query = "";
        if($search != ""){
            $append_query = "WHERE fdName LIKE '%" .$search. "%'";
        }

		//jqgrid 출력
		$select_query .= $append_query;

        $result = get_select_data($select_query);



		echo json_encode($reponse);

		break;
}

?>