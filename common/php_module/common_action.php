<?

include_once("../../common/php_module/common_func.php");

$response = array();

// 어떤 작업인지 가져옴
$oper = isset($_REQUEST["oper"]) ? $oper = check_str($_REQUEST["oper"]) : "";

switch($oper){
	case "get_tree":
		$search = isset($_REQUEST["search"]) ? $search = check_str($_REQUEST["search"]) : "";

		//검색필드
		$select_query = "SELECT fFarmid, fName, fdFarmid, fdDongid, fdName FROM farm_detail AS fd
                            JOIN farm AS f ON f.fFarmid = fd.fdFarmid";

        $append_query = "";
        if($search != ""){
            $append_query = "WHERE fdName LIKE '%" .$search. "%'";
        }

		//jqgrid 출력
		$select_query .= $append_query;

        $result = get_select_data($select_query);

        $tree_map = array();

        foreach($result as $row){

            $farm_key = $row["fFarmid"] . "|" . $row["fName"];

            $dong_key = $row["fdFarmid"] . "|" . $row["fdDongid"];

            // 키가 있는지 확인
            if(!array_key_exists($farm_key, $tree_map)){
                $temp = array();
                $temp[$dong_key] = $row["fdName"];
                $tree_map[$farm_key] = $temp;
            }
            else{
                $tree_map[$farm_key][$dong_key] = $row["fdName"];
            }
        }

        $reponse = $tree_map;

		echo json_encode($reponse);

		break;
}

?>