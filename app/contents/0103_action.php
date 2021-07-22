<?

include_once("../../common/php_module/common_func.php");
	
	$response = array();

	$oper = isset($_REQUEST["oper"]) ? $oper = check_str($_REQUEST["oper"]) : "";

	if(isset($_REQUEST["cmCode"])){
		$code = $_REQUEST["cmCode"];

		$result = get_feed_history($code, $oper);

		switch($oper){
			case "get_today":
				$response["chart_feed"] = $result["chart_feed_stack"];
				$response["chart_water"] = $result["chart_water_stack"];
				break;
			
			case "get_all":
				$response["chart_feed"] = $result["chart_feed"];
				$response["chart_water"] = $result["chart_water"];
				break;
		}

		echo json_encode($response);
	
	};
?>