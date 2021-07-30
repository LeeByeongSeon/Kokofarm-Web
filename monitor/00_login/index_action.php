<?
include_once("../../common/php_module/common_func.php");

$response = array();
$oper = check_str($_REQUEST["oper"]);

switch($oper){
	case "login":
		$id = check_str($_REQUEST["id"]);
		$pw = check_str($_REQUEST["pw"]);

		$query = "SELECT * FROM manager WHERE mgrID = \"" .$id. "\" AND mgrPW = \"" .$pw. "\";";
		$result = get_select_data($query);

		$mgr_id    = $result[0]["mgrID"];
		$mgr_pw    = $result[0]["mgrPW"];
		$mgr_name  = $result[0]["mgrName"];
		$mgr_type  = $result[0]["mgrType"];
        $mgr_group = $result[0]["mgrGroupName"];

		if($mgr_id != "" && $mgr_pw != "" && $mgr_type != "" && $mgr_group != ""){
			$_SESSION["mgr_id"]    = $mgr_id;
			$_SESSION["mgr_name"]  = $mgr_name;
			$_SESSION["mgr_type"]  = $mgr_type;
            $_SESSION["mgr_group"] = $mgr_group;

			//계정권한에 따라 분기
			switch($mgr_type){
                case "계열화회사":
                    $response["msg"] = "ok";
					$response["url"] = "../02_farm_mnt/0201.php";
                    break;

				case "일반관리자":
					$response["msg"] = "ok";
					$response["url"] = "../01_device_mnt/0101.php";
					break;

				case "슈퍼관리자":
					$response["msg"] = "ok";
					$response["url"] = "../01_device_mnt/0101.php";
					break;
			}
		} else {
				$response["msg"]="error";
				$response["url"]="";
		}

		echo json_encode($response);

		break;

	case "logout":
		unset($_SESSION["mgr_id"]);
		unset($_SESSION["mgr_name"]);
		unset($_SESSION["mgr_type"]);
		unset($_SESSION["mgr_group"]);
		echo "<script>location.replace('../00_login/index.php');</script>";
		break;
}

?>