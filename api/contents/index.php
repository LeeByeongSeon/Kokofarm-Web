<?
	// include_once("../common/common_func.php");
	// include_once("../common/common_mongodb.php");


	// $response=array();

	// $apiKey=chkCHAR($_REQUEST["apiKey"]);	//API KEY
	// $getComm=chkCHAR($_REQUEST["getComm"]);	//명령어
	// $farmID=str_replace("SS","KF",chkCHAR($_REQUEST["farmID"]));	//농장ID
	// $dongID=chkCHAR($_REQUEST["dongID"]);	//동ID
	// $sDate=chkCHAR($_REQUEST["sDate"]);		//검색시작 년월일
	// $eDate=chkCHAR($_REQUEST["eDate"]);		//검색종료 년월일

	// //키값 Query
	// if(empty($apiKey)){
	// 	echo "<h1>생육관제 공공DB API</h1><br>";
	// 	echo "Error : 키값이 존재하지 않습니다.";
	// 	exit(0);
	// }

	// if(empty($getComm)){
	// 	echo "<h1>생육관제 공공DB API</h1><br>";
	// 	echo "Error : 명령어가 존재하지 않습니다.";
	// 	exit(0);
	// }
		
	// $strSql="SELECT akKey FROM api_key WHERE akKey='$apiKey' ";
	// $getData=singleFindData($strSql,localDB_Conn);
	// if(empty($getData)){
	// 	echo "<h1>생육관제 공공DB API</h1><br>";
	// 	echo "Error : 키값이 존재하지 않습니다.";
	// 	exit(0);
	// }

	// //URL Error 확인
	// $errMsg="";
	// switch($getComm){
	// 	case "INOUT":		//농장별 입출하 정보
	// 		$errMsg="";
	// 		break;
	// 	case "AVGWEIGHT":	//기간별 평균중량(RDB)
	// 		if ( empty($farmID) || empty($dongID) || empty($sDate) || empty($eDate) ){
	// 			$errMsg	="파라미터값이 없습니다.";
	// 		}
	// 		break;
	// 	case "AVGSENSOR":		//일자별 평균센서정보(mongoDB)
	// 		if ( empty($farmID) || empty($dongID) || empty($sDate) || empty($eDate) ){
	// 			$errMsg	="파라미터값이 없습니다.";
	// 		}
	// 		break;
	// 	case "RAWDATA":	//센서 Raw Data(mongoDB)
	// 		if ( empty($farmID) || empty($dongID) || empty($sDate) ){
	// 			$errMsg	="파라미터값이 없습니다.";
	// 		}
	// 		break;
	// }
	// if(!empty($errMsg)){
	// 	echo "<h1>생육관제 공공DB API</h1><br>";
	// 	echo $errMsg;
	// 	exit(0);
	// }




	// //본 Query==========================================================================
	// switch($getComm){
	// 	case "INOUT":		//농장별 입출하 정보
	// 		$strSql="SELECT * FROM comein_master ORDER BY cmIndate";
	// 		$getData=multiFindData($strSql,localDB_Conn);
	// 		foreach($getData as $Val){
	// 			$response[]=array(
	// 				"farmID"	=> str_replace("KF","SS",$Val["cmFarmid"]),	//농장ID
	// 				"dongID"	=> $Val["cmDongid"],						//동ID
	// 				"inType"	=> $Val["cmIntype"],						//입추형식
	// 				"inDate"	=> $Val["cmIndate"],						//입추일자
	// 				"outDate"	=> $Val["cmOutdate"]						//출하일자
	// 			);
	// 		}
	// 		break;

	// 	case "AVGWEIGHT":	//기간별 평균중량(RDB)
	// 		$startDate=$sDate;
	// 		$endDate=$eDate;

	// 		$strSql="SELECT * FROM avg_weight WHERE awFarmid='$farmID' AND awDongid='$dongID' AND (LEFT(awDate,10) BETWEEN '$startDate' AND '$endDate') ORDER BY awDate ";
	// 		$getData=multiFindData($strSql,localDB_Conn);

	// 		foreach($getData as $Val){
	// 			$response[]=array(
	// 				"farmID"	=> str_replace("KF","SS",$Val["awFarmid"]),	//농장ID
	// 				"dongID"	=> $Val["awDongid"],						//동ID
	// 				"inTerm"	=> $Val["awDays"] + 0,						//일령
	// 				"dateTime"	=> $Val["awDate"],							//계산시간
	// 				"avgWeight"	=> sprintf('%0.1f',$Val["awWeight"])+0,		//평균중량
	// 				"stdDevi"	=> sprintf('%0.1f',$Val["awDevi"])+0,		//표준편차
	// 				"coVari"	=> sprintf('%0.1f',$Val["awVc"])+0,			//변이계수
	// 				"preDay1"	=> sprintf('%0.1f',$Val["awEstiT1"])+0,		//예측 평균중량 1일후
	// 				"preDay2"	=> sprintf('%0.1f',$Val["awEstiT2"])+0,		//예측 평균중량 2일후
	// 				"preDay3"	=> sprintf('%0.1f',$Val["awEstiT3"])+0		//예측 평균중량 3일후
	// 			);
	// 		}
	// 		break;

	// 	case "AVGSENSOR":		//일자별 평균센서정보(mongoDB)
	// 		$startDate=$sDate . " 00:00:00";
	// 		$endDate=$eDate . " 23:59:59";

	// 		//mongoDB Query==========================
	// 		$mongoCollection= $mongoDB -> sensorData;
	// 		$pipeLine=array(
	// 					array('$match' => array(
	// 										'farmID'	=> $farmID,
	// 										'dongID'	=> $dongID,
	// 										'getTime'	=> array('$gte' => $startDate,'$lte' => $endDate),
	// 									  )
	// 					),
	// 					array('$group' => array(
	// 											'_id' => array('$substr' => array('$getTime',0,10) ),
	// 											'avgTemp' => array('$avg' => array( '$cond' => array(array('$gt' => array('$temp',0)),'$temp',Null) ) ),
	// 											'avgHumi' => array('$avg' => array( '$cond' => array(array('$gt' => array('$humi',0)),'$humi',Null) ) ),
	// 											'avgCO' => array('$avg' => array( '$cond' => array(array('$gt' => array('$co',0)),'$co',Null) ) ),
	// 											'avgNH' => array('$avg' => array( '$cond' => array(array('$gt' => array('$nh',0)),'$nh',Null) ) )
	// 										)
	// 					),
	// 					array('$sort' => array("_id"=>1))
	// 		);

	// 		$mongocursor=$mongoCollection->aggregate($pipeLine, array("cursor" => array("batchSize" => 100)) ); //LIMIT 1440개와 동일(60EZ*24H)
	// 		$mongoResult=mongoExcute($mongocursor);
	// 		foreach($mongoResult as $Val){
	// 			$response[]=array(
	// 				"farmID"	=> str_replace("KF","SS",$farmID),		//농장ID
	// 				"dongID"	=> $dongID,								//동ID
	// 				"dateTime"  => $Val["_id"],							//날짜
	// 				"avgTemp"	=> sprintf('%0.1f',$Val["avgTemp"])+0,	//평균-온도
	// 				"avgHumi"	=> sprintf('%0.1f',$Val["avgHumi"])+0,	//평균-습도
	// 				"avgCO"		=> sprintf('%0.1f',$Val["avgCO"])+0,	//평균-CO2
	// 				"avgNH"		=> sprintf('%0.1f',$Val["avgNH"])+0		//평균-NH3
	// 			);
	// 		}
	// 		break;

	// 	case "RAWDATA":	//센서 Raw Data(mongoDB)
	// 		$startDate=$sDate . " 00:00:00";
	// 		$endDate=$sDate . " 23:59:59";

	// 		//mongoDB Query==========================
	// 		$mongoCollection= $mongoDB -> sensorData;
	// 		$pipeLine=array(
	// 					array('$match' => array(
	// 										'farmID'	=> $farmID,
	// 										'dongID'	=> $dongID,
	// 										'getTime'	=> array('$gte' => $startDate,'$lte' => $endDate),
	// 									  )
	// 					),
	// 					array('$sort' => array("_id"=>1))
	// 		);

	// 		$mongocursor=$mongoCollection->aggregate($pipeLine, array("cursor" => array("batchSize" => 4320)) ); //LIMIT 60*24H*저울3대
	// 		$mongoResult=mongoExcute($mongocursor);

	// 		foreach($mongoResult as $Val){
	// 			$response[]=array(
	// 				"farmID"	=> str_replace("KF","SS",$farmID),	//농장ID
	// 				"dongID"	=> $dongID,							//동ID
	// 				"jeoulID"	=> $Val["jeoulID"],					//저울ID
	// 				"dateTime"  => $Val["getTime"],					//획득시간
	// 				"temp"		=> sprintf('%0.1f',$Val["temp"])+0,	//온도
	// 				"humi"		=> sprintf('%0.1f',$Val["humi"])+0,	//습도
	// 				"co"		=> sprintf('%0.1f',$Val["co"])+0,	//이산화탄소
	// 				"nh"		=> sprintf('%0.1f',$Val["nh"])+0,	//암모니아
	// 				"w01"=>$Val["w01"], "w02"=>$Val["w02"], "w03"=>$Val["w03"], "w04"=>$Val["w04"], "w05"=>$Val["w05"], "w06"=>$Val["w06"], "w07"=>$Val["w07"], "w08"=>$Val["w08"], "w09"=>$Val["w09"], "w10"=>$Val["w10"],
	// 				"w11"=>$Val["w11"], "w12"=>$Val["w12"], "w13"=>$Val["w13"], "w14"=>$Val["w14"], "w15"=>$Val["w15"], "w16"=>$Val["w16"], "w17"=>$Val["w17"], "w18"=>$Val["w18"], "w19"=>$Val["w19"],	"w20"=>$Val["w20"],
	// 				"w21"=>$Val["w21"], "w22"=>$Val["w22"], "w23"=>$Val["w23"], "w24"=>$Val["w24"],	"w25"=>$Val["w25"], "w26"=>$Val["w26"], "w27"=>$Val["w27"], "w28"=>$Val["w28"], "w29"=>$Val["w29"], "w30"=>$Val["w30"],
	// 				"w31"=>$Val["w31"], "w32"=>$Val["w32"], "w33"=>$Val["w33"], "w34"=>$Val["w34"], "w35"=>$Val["w35"], "w36"=>$Val["w36"], "w37"=>$Val["w37"], "w38"=>$Val["w38"], "w39"=>$Val["w39"],	"w40"=>$Val["w40"],
	// 				"w41"=>$Val["w41"], "w42"=>$Val["w42"], "w43"=>$Val["w43"], "w44"=>$Val["w44"], "w45"=>$Val["w45"], "w46"=>$Val["w46"], "w47"=>$Val["w47"], "w48"=>$Val["w48"], "w49"=>$Val["w49"], "w50"=>$Val["w50"],
	// 				"w51"=>$Val["w51"], "w52"=>$Val["w52"], "w53"=>$Val["w53"], "w54"=>$Val["w54"], "w55"=>$Val["w55"],	"w56"=>$Val["w56"], "w57"=>$Val["w57"], "w58"=>$Val["w58"], "w59"=>$Val["w59"], "w60"=>$Val["w60"]
	// 			);			
	// 		}
	// 		break;
	// }

	// echo json_encode($response);

?>