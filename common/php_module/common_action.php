<?

include_once("../../common/php_module/common_func.php");

$response = array();

// 어떤 작업인지 가져옴
$oper = isset($_REQUEST["oper"]) ? $oper = check_str($_REQUEST["oper"]) : "";

switch($oper){
	case "get_tree":
		$search = isset($_REQUEST["search"]) ? $search = check_str($_REQUEST["search"]) : "";

		//검색필드
		$select_query = "SELECT f.fFarmid, f.fName, IFNULL(fd.fdFarmid, '') AS fdFarmid, IFNULL(fd.fdDongid, '') AS fdDongid, IFNULL(fd.fdName, '') AS fdName FROM farm AS f
                        LEFT JOIN farm_detail AS fd ON fd.fdFarmid = f.fFarmid";

        $append_query = "";
        if($search != ""){
            $append_query = " WHERE f.fName LIKE '%" .$search. "%'";
        }

		//jqgrid 출력
		$select_query .= $append_query . " ORDER BY fName ASC";

        $result = get_select_data($select_query);

        $tree_map = array();

        foreach($result as $row){

            $farm_key = $row["fFarmid"] . "|" . $row["fName"];

            $dong_key = $row["fdFarmid"] . "|" . $row["fdDongid"];

            // 키가 있는지 확인
            if(!array_key_exists($farm_key, $tree_map)){
                $temp = array();

                // 농장만 존재할 경우 에러처리 - 
                if(empty($row["fdFarmid"]) || empty($row["fdDongid"]) || empty($row["fdName"])){
                    $tree_map[$farm_key] = $temp;
                    continue;
                }
                else{
                    $temp[$dong_key] = $row["fdName"];
                    $tree_map[$farm_key] = $temp;
                }
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