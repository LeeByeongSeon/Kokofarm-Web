<?

include_once("../../common/php_module/common_func.php");
	
	$response = array();

	$oper = isset($_REQUEST["oper"]) ? $oper = check_str($_REQUEST["oper"]) : "";

	if(isset($_REQUEST["cmCode"])){
		$cmCode = $_REQUEST["cmCode"];
		$id = explode("_", $code)[1];
		$farmID = substr($id, 0, 6);
		$dongID = substr($id, 6);
	};

	switch($oper){

		case "get_feed":
			$today_query = "SELECT ";


			
			echo json_encode($response);

			break;

		case "get_water":

			break;
	}
?>