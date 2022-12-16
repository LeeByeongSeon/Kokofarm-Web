

<form id="redirec_form" action="0000.php" method="post">

<?
	include_once("../common/php_module/common_func.php");

	$key = check_str($_REQUEST["key"]);
	$id = "kk0000";

	// $t = (int)substr($key, 2);
	// $tkey = (int) pow($t, 1/3);

	// $id = "kk" . sprintf('%04d', $tkey);

	// var_dump($tkey);
	// var_dump($id);

	switch($key){	//p - 3 (id ^ 3)
		case "p34913":
			$id = "kk0017";
			break;
		case "p3157464":
			$id = "kk0054";
			break;
		case "p3166375":
			$id = "kk0055";
			break;
		case "p379507":
			$id = "kk0043";
			break;
		case "p3357911":
			$id = "kk0071";
			break;
		case "p3753571":
			$id = "kk0091";
			break;
	}

	if($id != "kk0000"){
		$query = "SELECT * FROM farm WHERE fID = '".$id."';";
	
		$result = get_select_data($query);

		echo "<input type='hidden' name='userID' value='".$result[0]["fID"]."'>";
		echo "<input type='hidden' name='userPW' value='".$result[0]["fPW"]."'>";
	}
	else{
		echo "<input type='hidden' name='userID' value='kk0000'>";
		echo "<input type='hidden' name='userPW' value='0000'>";
	}

?>

</form>

<script type="text/javascript">
    document.getElementById('redirec_form').submit();
</script>