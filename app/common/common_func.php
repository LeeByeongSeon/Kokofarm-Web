<?
@session_start();


//======================================
//--로컬 접속 정보
//======================================
$dbArr=dbINIT();
$localDB_Host	= $dbArr["DB_Host"]; 
$localDB_User	= $dbArr["DB_User"];
$localDB_Pass	= $dbArr["DB_Pass"];
$localDB_Name	= $dbArr["DB_Name"];

$localDB_Conn = @mysql_connect($localDB_Host,$localDB_User,$localDB_Pass);
define('localDB_Conn',   $localDB_Conn);
mysql_select_db($localDB_Name,$localDB_Conn);
mysql_query("SET NAMES utf8");


//======================================
//보정변수 선언(2021-02-05)
//=====================================
define("corrDevi",1.28);		//표준편차보정=>초기화는 *1임(곱하기)
define("corrDayWeightPer",1.5);   //일별 증체중량의 보정값=>초기화는 *1임(곱하기)

define("corrTemp",-1.2);	//저울-온도보정
define("corrHumi",7);		//저울-습도보정
define("corrCo2", 0);		//저울-CO2보정
define("corrNh3", 0);		//저울-NH3보정


//==========================================
//육계-일령별 base값 및 최대 증체량을 배열에 정의(2021-02-05)
//==========================================

$dayWeightArr=array();		//권고중량 배열
$dayWeightArr[0]=0;

$strSql="SELECT * FROM feeding_mgr WHERE fmIntype='육계' AND fmSensorType='평균중량'";
$getData=multiFindData($strSql,localDB_Conn);
$preLevel1=40;
foreach($getData as $Val){
	$preLevel1=$Val["fmLevel1"]-$preLevel1;			//이전일령과 현재일령과의 차이=>일령별 권고증체량 
	array_push($dayWeightArr,$Val["fmLevel1"]);		//권고중량 배열에 넣기 : 1일령부터 시작
	$preLevel1=$Val["fmLevel1"];
}



//==========================================
//육계-일령별 base값 및 최대 증체량(2021-02-05)
//==========================================
//$inType : 육계/육계종계
//$inTerm : 일령
//$avgWeight : 산출된 평균중량
//$connName : DB연결
//=========================================
function corrAvgWeight($inType,$inTerm,$avgWeight){
/*
	global $dayWeightArr;


	if(!empty($avgWeight)){

		$retCorrWeight=0; //보정값

		$preDayWeight=$dayWeightArr[$inTerm-1];		//이전일령 권고중량
		$currDayWeight=$dayWeightArr[$inTerm];		//현재일령 권고중량

		$dayWeight=$currDayWeight-$preDayWeight;	//이전일령 대비 현재일령 증체값

		//비교 Range
		$maxRange=$currDayWeight+$dayWeight;
		$minRange=$currDayWeight-$dayWeight;

		//범위안에 들어가면
		if($minRange <= $avgWeight && $avgWeight <= $maxRange){
			$retCorrWeight=$avgWeight;
		}
		else{
			
			//증체율
			$tmp=100-@($currDayWeight/$avgWeight*100);

			if($avgWeight>$currDayWeight){
				//$retCorrWeight=$maxRange + ($dayWeight * ($tmp/100));
				$retCorrWeight=$currDayWeight + ($dayWeight * ($tmp/100 * corrDayWeightPer ));
			}
			else{
				//$retCorrWeight=$minRange - ($dayWeight * ($tmp/100));
				$retCorrWeight=$currDayWeight - ($dayWeight * ($tmp/100 * corrDayWeightPer ));
			}
		}
		return $retCorrWeight;
	}

	else{
		return $avgWeight;
	}
*/

return $avgWeight;
}


//======================================
//Google Map API Key
//=====================================
$mapKey="AIzaSyDhI36OUKqVjyFrUQYufwr80bon1Y0-hZ0";



//======================================
//Up/DownLoad 경로
//======================================
//서버 도메인
$serverDomain="http://localhost";
//$serverDomain="http://monitor.kokofarm.co.kr";


//공지사항
//$prn_boardURL="/rastool2/data/board/";
//$up_boardURL=$_SERVER['DOCUMENT_ROOT'] . "/rastool2/data/board/";



//======================================
//자료 정규화
//======================================
function chkCHAR($getData){
	$retData=trim($getData);
	$retData=mysql_real_escape_string($retData); //SQL injection 공격 방지
	$retData=str_replace(",","",$retData);
	return $retData;
}


//======================================
//Query에 의한 자료찾기(공용)
//Input  => $strSql : Query문 / $connName : DB연결 Name
//Output => $dataArr[0]["m_email"]
//======================================
function multiFindData($strSql,$connName){
	$dataArr=array(); $recNo=-1;
	$result20= mysql_query($strSql, $connName);

	$fieldCount = mysql_num_fields($result20)-1;
	while ($row20 = mysql_fetch_array($result20)){
		$recNo++;
		for($i=0; $i<=$fieldCount; $i++){
			$fieldType=mysql_field_type($result20,$i);	//Field type
			$fieldName=mysql_field_name($result20,$i);	//Field name
			$fieldVal=$row20[$i];					//Field value

			//값이 null or empty 일때 field type에 따라 초기값 설정
			if (empty($fieldVal)){
				$dataArr[$recNo][$fieldName]=0;
				if($fieldType=="string" || $fieldType=="blob" || $fieldType=="date" || $fieldType=="datetime") {$dataArr[$recNo][$fieldName]=""; }
			}
			else{
				$dataArr[$recNo][$fieldName]=$fieldVal;			//연관배열로 저장
			}
		}
	}
	return $dataArr;
};


//======================================
//숫자형 문자형 자료 찾기
//======================================
function singleFindData($strSql,$connName) {
	$result25 = mysql_query($strSql,$connName);
	$row25= mysql_fetch_array($result25,MYSQL_NUM);
	$fieldType=mysql_field_type($result25,0);
	$retunVal=$row25[0];

	if(empty($retunVal)){
		$retunVal=0;
		if($fieldType=="string" || $fieldType=="blob" || $fieldType=="date") $retunVal="";
	}
	return $retunVal;
};


//==============================================================
//jqGrid 자료 보기
//--------------------------------------------------------------
//$strSql : Query문
//$page   : jqGrid의 page 속성의 값
//$limit  : jqGrid의 sortname 속성의 값
//$sidx   : jqGrid의 page 속성의 값
//$sord   : jqGrid의 sortorder 속성의 값
//==============================================================
function jqGridView($query,$page,$limit,$sidx,$sord,$connName){

	$arrData=array();
	//총 레코드 갯수		
	$executeQuery=mysql_query($query,$connName);
	$total_rec=mysql_num_rows($executeQuery);


	$total_pages = 0;
	if( $total_rec>0) {
		$total_pages = ceil($total_rec/$limit);
	}
	if ($page > $total_pages) $page=$total_pages;
	if ($limit<0) $limit = 0;
	$start = $limit*$page - $limit; // do not put $limit*($page - 1)
	if ($start<0) $start = 0;

	//jqGrid 속성 및 Data return
	$arrData["page"]=$page;
	$arrData["total"]=$total_pages;
	$arrData["records"]=$total_rec;
	$strSql=$query . " ORDER BY $sidx $sord LIMIT $start,$limit";

	$result20 = mysql_query($strSql,$connName);
	while ($row20 = mysql_fetch_array($result20)){
		$arrData["prnData"][]=$row20;
	}
	return $arrData;
}

//======================================
//날짜 [월-일]
//======================================
function monthdayConvert($cdate) {
	$Convert="";
	if ($cdate!="") $Convert = substr($cdate,4,2)."/".substr($cdate,6,2);
	return $Convert;
};
//======================================
//날짜 [년-월-일]
//======================================
function dateConvert($cdate) {
	$Convert="";
	if ($cdate!="") $Convert = substr($cdate,0,4)."-".substr($cdate,4,2)."-".substr($cdate,6,2);
	return $Convert;
};

//======================================
//날짜 [년-월-일 시:분:초]
//======================================
function datetimeConvert($cdate) {
	$Convert="";
	if ($cdate!="") $Convert = substr($cdate,0,4)."-".substr($cdate,4,2)."-".substr($cdate,6,2) . " " .substr($cdate,8,2) .":" .substr($cdate,10,2) .":" .substr($cdate,12,2);
	return $Convert;
};


//======================================
//배열에 의한 콤보 버튼 만들기
//======================================
function comboByArray($arrData,$comboName,$defaultName,$defaultVal,$type){
	switch($type){
		case "SEARCH":
			$returnHTML="<select class=\"form-control\" name=\"$comboName\">";
			if($defaultVal=="") { 
				if($defaultName==""){
					$returnHTML .="<option value=\"\">전체</option>";
				}
				else{
					$returnHTML .="<option value=\"\">$defaultName</option>";
				}
			}
			break;
		case "INPUT":
			$returnHTML="<select class=\"form-control input-sm\" name=\"$comboName\">";
			if($defaultVal=="") { 
				if($defaultName==""){
					$returnHTML .="<option value=\"\">없음</option>";
				}
				else{
					$returnHTML .="<option value=\"\">$defaultName</option>";
				}
			}
			break;
	}


	foreach($arrData as $keyName){
		if($defaultVal==$keyName){
			$returnHTML .="<option value=\"$keyName\" selected>$keyName</option>";
		}
		else{
			$returnHTML .="<option value=\"$keyName\">$keyName</option>";
		}

	}
	$returnHTML .="</select>";

	return $returnHTML;
};


//======================================
//Query에 의한 콤보박스 만들기
//======================================
function comboByQuery($strSql,$comboName,$defaultName,$defaultVal,$type,$connName){
	switch($type){
		case "SEARCH":
			$returnHTML="<select class=\"form-control\" name=\"$comboName\">";
			if($defaultVal=="") { 
				if($defaultName==""){
					$returnHTML .="<option value=\"\">전체</option>";
				}
				else{
					$returnHTML .="<option value=\"\">$defaultName</option>";
				}
			}
			break;
		case "INPUT":
			$returnHTML="<select class=\"form-control input-sm\" name=\"$comboName\">";
			if($defaultVal=="") { 
				if($defaultName==""){
					$returnHTML .="<option value=\"\">없음</option>";
				}
				else{
					$returnHTML .="<option value=\"\">$defaultName</option>";
				}
			}
			break;
	}


	$result20 = mysql_query($strSql,$connName);
	while ($row20 = mysql_fetch_array($result20)){
		if($defaultVal==$row20[0]){
			$returnHTML .="<option value=\"" . $row20[0] . "\" selected>" . $row20[0] . "</option>";
		}
		else{
			$returnHTML .="<option value=\"" . $row20[0] . "\">" . $row20[0] . "</option>";
		}
	}
	$returnHTML .="</select>";

	return $returnHTML;
};


//======================================
//Query에 의한 라디오 버튼 만들기
//======================================
function radioByQuery($strSql,$radioName,$defaultVal,$connName){
	$result20 = mysql_query($strSql,$connName);
	while ($row20 = mysql_fetch_array($result20)){
		if($defaultVal==$row20[0]){
			$returnHTML .="<input type=\"radio\" name=\"$radioName\" value=\"" . $row20[0] . "\" checked>&nbsp;" . $row20[0] . "&nbsp;&nbsp;&nbsp;&nbsp;";
		}
		else{
			$returnHTML .="<input type=\"radio\" name=\"$radioName\" value=\"" . $row20[0] . "\">&nbsp;" . $row20[0] . "&nbsp;&nbsp;&nbsp;&nbsp;";
		}
	}

	$returnHTML=substr($returnHTML,0,strlen($returnHTML)-24);
	return $returnHTML;
}

//======================================
//Query에 의한 체크박스 만들기
//======================================
function checkboxByQuery($strSql,$checkboxName,$defaultVal,$connName){
	$tmp=0;
	$result20 = mysql_query($strSql,$connName);
	while ($row20 = mysql_fetch_array($result20)){
		$tmp++;
		$chkField="N";
		foreach((array)$defaultVal as $keyName => $Val){
			if($Val==$row20[0]) $chkField="Y";
		}
		if($chkField=="Y"){
			$returnHTML .="<input type=\"checkbox\" name=\"" . $checkboxName . "[" . trim($tmp) . "]\" value=\"" . $row20[0] . "\" checked>&nbsp;" . $row20[0] . "&nbsp;&nbsp;&nbsp;&nbsp;";
		}
		else{
			$returnHTML .="<input type=\"checkbox\" name=\"" . $checkboxName . "[" . trim($tmp) . "]\" value=\"" . $row20[0] . "\">&nbsp;" . $row20[0] . "&nbsp;&nbsp;&nbsp;&nbsp;";
		}
	}

	$returnHTML=substr($returnHTML,0,strlen($returnHTML)-24);
	return $returnHTML;
}

//======================================
//배열에 의한 체크박스 만들기
//======================================
function checkboxByArray($arrData,$checkboxName,$defaultVal){
	$tmpCnt=0;
	foreach($arrData as $keyName){
		$tmpCnt++;
		if($defaultVal==$keyName){
			$returnHTML .="<input type=\"checkbox\" name=\"" . $checkboxName . "[" . $tmpCnt. "]\" value=\"$keyName\" checked>&nbsp;" . $keyName . "&nbsp;&nbsp;&nbsp;&nbsp;";
		}
		else{
			$returnHTML .="<input type=\"checkbox\" name=\"" . $checkboxName . "[" . $tmpCnt . "]\" value=\"$keyName\">&nbsp;" . $keyName . "&nbsp;&nbsp;&nbsp;&nbsp;";
		}

	}
	return $returnHTML;
};


//======================================
//JSON 형식의 콤보박스 만들기
//======================================
function comboByJSON($strSql,$connName){
	$reponse=array();
	$result20 = mysql_query($strSql,$connName);
	while ($row20 = mysql_fetch_array($result20,MYSQL_NUM)){
		$reponse[$row20[0]]=$row20[0];
	}
	return json_encode($reponse);
};


//======================================
//자리수 변환
//======================================
function digitConvert($getData,$chk_digit){
	$getData=trim($getData);
	$temp_data="";

	for($i=1; $i<=$chk_digit-strlen($getData); $i++){
		$temp_data=$temp_data . "0";
	}
	return $temp_data . $getData;
};

//======================================
//서버에 파일 Upload
//======================================
function FileUPload($arr_localpath,$arr_localfile,$str_serverpath,$str_serverfile){
   $return_data="";
   if (is_uploaded_file($arr_localpath)) {
		$tmpLocalFileFullName=explode(".",$arr_localfile);
		if(count($tmpLocalFileFullName)>=1){
			$localFileExt=strtolower($tmpLocalFileFullName[count($tmpLocalFileFullName)-1]);
		}
		else{
			$localFileExt="jpg";		//확장자가 없을경우 jpg으로
		}
		$serverfile_fullname=$str_serverpath . $str_serverfile . "." . $localFileExt; //서버Path+서버파일명+로컬 확장자명
		move_uploaded_file($arr_localpath,$serverfile_fullname);  //파일 서버에 전송
		$return_data=$str_serverfile . "." . $localFileExt;
	}
	return $return_data;
};



//======================================
//WordWrap(자동 줄바꿈)
//======================================
function commentwordWrap($getStr) {
	$returnVal=str_replace("\n","<br>",$getStr);
	$returnVal=str_replace("\r\n","<br>",$returnVal);

	return $returnVal;
};


//======================================
//PK의 MAX값 
//======================================
function queryMAXPK($tableName,$pkName,$connName){
	$chk_OK="N";
	while ($chk_OK!="Y") {
		$valuePK=date('YmdHis') . "_" . digitConvert(secureRand(1,9990),4) ;
		$strSql="SELECT count(*) FROM $tableName WHERE $pkName='$valuePK'";
		if (singleFindData($strSql,$connName)<=0) $chk_OK="Y";
	}
	return $valuePK;
};

//======================================
//보안랜덤 발생기:Sparrow 2019.10.18 수정
//======================================
function secureRand($min,$max) {
    $range = $max - $min + 1;
    if ($range == 0) return $min;
    $length = (int) (log($range,2) / 8) + 1;
    $max = pow(2, 8 * $length);
    $num = $max + 1; // Hackish, I know..
    while ($num > $max) {
        $num = hexdec(bin2hex(openssl_random_pseudo_bytes($length,$s)));
    }
    return ($num  % $range) + $min;
}




//======================================
//Insert / Update / Delete Query
//======================================
//$queryType =>쿼리타입
//$tableName =>테이블명
//$fieldArr   =>Insert와 Update는 Array구조, Delete=""
//$whereStr   =>Where절
//$connName  =>DB 연결명
//======================================
function excuteQuery($queryType,$tableName,$fieldArr,$whereStr,$connName){
	switch($queryType){
		case "INSERT":
			$tmpLeft=""; $tmpRight="";
			foreach($fieldArr as $keyName => $dataVal){ if(strlen($dataVal)>0){  $tmpLeft  .= $keyName . ","; $tmpRight .= "\"$dataVal\","; } }
			$strSql="INSERT INTO $tableName (" .substr($tmpLeft,0,-1) . ") VALUES(" . substr($tmpRight,0,-1) . ")";
			break;

		case "UPDATE":
			$tmp="";
			foreach($fieldArr as $keyName => $dataVal){ $tmp .= $keyName . "=\"$dataVal\","; }
			$strSql="UPDATE $tableName SET " . substr($tmp,0,-1) . " WHERE $whereStr ";
			break;

		case "DELETE":
			$strSql="DELETE FROM $tableName WHERE $whereStr ";
			break;
	}
	$result=mysql_query($strSql, $connName);
}




//======================================
//엑셀변환(HTML 형식)
//======================================
//$strSql : 쿼리문
//$fieldData : Excel로 표현할 형식 배열
//$title : 출력 제목
//$option : 쿼리 조건
//======================================
function convertExcel($strSql,$fieldData,$title,$option,$connName){
	$result20 = mysql_query($strSql,$connName);
	$totRec = mysql_num_rows($result20);
	$colspan=count($fieldData)-1;
	
	$html="<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN' 'http://www.w3.org/TR/html4/loose.dtd'>
			<html>
				<head><meta http-equiv='Content-Type' content='text/html; charset=utf-8'><head>
					<style> table th {background:#A0B3B3;font-weight:normal; text-align:center;color:white} </style>
				<body style='border:solid 0.1pt #CCCCCC;font-size:14px'>
					<table table border='1' style='width:100%;font-size:14px'>
						<tr><th>출력일시</th><td style=\"mso-number-format:'\@'\" colspan='" . $colspan . "'>" . date('Y-m-d H:i:s') . "</td></tr>
						<tr><th>메 뉴 명</th><td style=\"mso-number-format:'\@'\" colspan='" . $colspan . "'>" . $title . "</td></tr>
						<tr><th>검색조건</th><td style=\"mso-number-format:'\@'\" colspan='" . $colspan . "'>" . $option . "</td></tr>
					</table>
					<br><br>";

	if($totRec>0){
		$html .="<table table border='1' style='width:100%;font-size:14px'>";
		$html .="<tr>";
			//헤더출력
			foreach($fieldData as $keyName => $Val){ $html .="<th>" . $Val[0] . "</th>"; }
		$html .="</tr>";

		//내용출력
		while ($row20 = mysql_fetch_array($result20)){
			$recNo=$totRec--;
			$html .="<tr><th>" . $recNo . "</th>";

			$prnHTML="";
			for($i=1; $i<=count($fieldData)-1;$i++){
				$fieldName=$fieldData[$i][1];	$fieldVal=$row20[$fieldName];	$fieldAlign=$fieldData[$i][3];	$fieldType=$fieldData[$i][2];
				if(empty($fieldVal)){ $prnHTML .= "<td></td>"; }
				else{
					switch($fieldType){
						case "INT":
							$prnHTML .= "<td style='text-align:" . $fieldAlign . "'>" . number_format($fieldVal) .  "</td>";
							break;
						case "STR":
							$prnHTML .= "<td style=\"text-align:" . $fieldAlign . ";mso-number-format:'\@'\">" . $fieldVal .  "</td>";
							break;
						case "DATE":
							$prnHTML .= "<td style=\"text-align:" . $fieldAlign . ";mso-number-format:'\@'\">" . datetimeConvert($fieldVal) .  "</td>";
							break;
					}
				}
			}
			$html .= $prnHTML . "</tr>";
		}

		$html .="</table></body></html>";
	}
	echo $html;
}






//======================================
//DB연결 정보 가져오기
//======================================
function dbINIT(){
	$dbConfigArr=array();

	$fp = fopen("../common/dbconn.cfg","r"); 
	$tmp=fgets($fp); $posi=strpos($tmp,";"); $dbConfigArr["DB_Host"]=trim(substr($tmp,0,$posi));
	$tmp=fgets($fp); $posi=strpos($tmp,";"); $dbConfigArr["DB_User"]=trim(substr($tmp,0,$posi));
	$tmp=fgets($fp); $posi=strpos($tmp,";"); $dbConfigArr["DB_Pass"]=trim(substr($tmp,0,$posi));
	$tmp=fgets($fp); $posi=strpos($tmp,";"); $dbConfigArr["DB_Name"]=trim(substr($tmp,0,$posi));
	fclose($fp);

	return $dbConfigArr;
}

//=============================================
//두 날짜간의 일수 계산
//$strSDate = 문자형 시작 날짜
//$strEDate = 문자형 종료 날짜
//=============================================
function dateDiff($strSDate,$strEDate){
	$sDate=new DateTime($strSDate);
	$eDate=new DateTime($strEDate);
	$interVal=date_diff($sDate,$eDate);
	return $interVal->days +1;
}



//=====================================================================================
//폐사율 Data 불러오기
//=====================================================================================
//$chkInOutCode : comein_master의 cmCode
//$sensorType : 폐사율
//=====================================================================================
function deathPer($chkInOutCode,$sensorType,$dbConn){

	//입추 및 출하정보 가져오기=================
	$strSql="SELECT * FROM comein_master WHERE cmCode='" . $chkInOutCode . "'";
	$getData=multiFindData($strSql,$dbConn);

	$farmID=$getData[0]["cmFarmid"]; //농장ID
	$dongID=$getData[0]["cmDongid"]; //동ID
	$cmIntype=$getData[0]["cmIntype"]; //입추형식
	$cmIndate=$getData[0]["cmIndate"]; //입추일자
	$cmOutdate=$getData[0]["cmOutdate"]; //출하일자


	//폐사율 Data 가져오기
	$strSql="SELECT * FROM comein_detail WHERE LEFT(cdCode,21)='" . $chkInOutCode . "' ORDER BY cdCode";
	$getData=multiFindData($strSql,$dbConn);

	//결과값 Return==========================
	$retArr=array();
	$chartArr=array();		//차트배열
	$chartTable=array();	//테이블배열

	foreach($getData as $Val){
		$chartArr[]=array(
			"날짜" => $Val["cdDate"],
			"폐사율" => sprintf('%0.1f',$Val["cdDeathper"])
		);
	}

	$retArr["chartArr"]=$chartArr;

	return $retArr;
}


//=====================================================================================
//평균중량Data 불러오기
//=====================================================================================
//$chkInOutCode : comein_master의 cmCode
//$sensorType : 평균중량
//$prnType : TODAY, ALLDAY, INOUTDAY
//=====================================================================================
function avgWeight($chkInOutCode,$sensorType,$prnType,$dbConn){

	//입추 및 출하정보 가져오기=================
	$strSql="SELECT * FROM comein_master WHERE cmCode='" . $chkInOutCode . "'";
	$getData=multiFindData($strSql,$dbConn);

	$farmID=$getData[0]["cmFarmid"]; //농장ID
	$dongID=$getData[0]["cmDongid"]; //동ID
	$cmIntype=$getData[0]["cmIntype"]; //입추형식
	$cmIndate=$getData[0]["cmIndate"]; //입추일자
	$cmOutdate=$getData[0]["cmOutdate"]; //출하일자

	//센서별Range값 => 평균중량
	$recommRange=array();
	$strSql="SELECT fmCntday, fmLevel1 FROM feeding_mgr WHERE fmIntype='$cmIntype' AND fmSensortype='$sensorType' ORDER BY fmCntday";
	$getData=multiFindData($strSql,$dbConn);
	foreach($getData as $Val){
		$recommRange[$Val["fmCntday"]]=$Val["fmLevel1"];
	}

	$toDay=date('Y-m-d'); //오늘일자

	/*예전꺼(2020-10-14)
	//평균중량 변화추이 가져오기
	switch($prnType){
		case "TODAY": //입추상태+ 오늘자료만 Query
			$sDate=$toDay . " 00:00:00";
			$eDate=$toDay . " 23:59:59";
			$whereQuery=" WHERE awFarmid='$farmID' AND awDongid='$dongID' AND (awDate BETWEEN '$sDate' AND '$eDate') GROUP BY LEFT(awDate,16) ";
			break;
		case "ALLDAY": //입추상태+ 입추일자로 부터 오늘까지 Query
			$sDate=substr($cmIndate,0,10);
			$eDate=$toDay;
			$whereQuery=" WHERE awFarmid='$farmID' AND awDongid='$dongID' AND (LEFT(awDate,10) BETWEEN '$sDate' AND '$eDate') GROUP BY LEFT(awDate,10) ";
			break;
		case "INOUTDAY": //출하상태+ 입추일자로 부터 출하일자까지 Query
			$sDate=substr($cmIndate,0,10);
			$eDate=substr($cmOutdate,0,10);
			$whereQuery=" WHERE awFarmid='$farmID' AND awDongid='$dongID' AND (LEFT(awDate,10) BETWEEN '$sDate' AND '$eDate') GROUP BY LEFT(awDate,10) ";
			//$whereQuery=" WHERE awFarmid='$farmID' AND awDongid='$dongID' AND (awDate BETWEEN '$sDate' AND '$eDate') GROUP BY LEFT(awDate,16) ";
			break;
	}
	$strSql="SELECT awDate,DATEDIFF(LEFT(awDate,10),'" . substr($cmIndate,0,10) .  "')+1 as avgTerm, LEFT(awDate,16) as avgDate ,LEFT(awDate,10) as avgDate ,AVG(NULLIF(awWeight ,0)) as avgWeight,  AVG(NULLIF(awDevi ,0)) as avgDevi, AVG(NULLIF(awVc ,0)) as avgVc 
			 FROM avg_weight " . $whereQuery;
	*/

	$strSql="";
	switch($prnType){
		case "TODAYINC":	//어제대비 오늘 증체중량 변화추이

			$yesterDay=date("Y-m-d",strtotime("-1 Days"));
			$strSql="SELECT *, IFNULL(DATEDIFF(DATE_SUB(current_date(), INTERVAL 1 Day),cmIndate)+1,0) as inTERM  
					 FROM avg_weight,comein_master 
					 WHERE awFarmid=cmFarmid AND awDongid=cmDongid AND  cmCode='" . $chkInOutCode . "' AND LEFT(awDate,10)='" . $yesterDay . "'
					 ORDER BY awDate DESC LIMIT 0,1";
			$getData=multiFindData($strSql,$dbConn);

			$awWeight=$getData[0]["awWeight"];	//어제 평균중량
			$inTerm=$getData[0]["inTERM"];		//어제 일령

			//어제 마지막 중량 보정====================
			$yesterDayAvgWeight=corrAvgWeight("육계",$inTerm,$awWeight);
			//어제 마지막 중량====================

			$getData=array();

			$sDate=$toDay . " 00:00:00";
			$eDate=$toDay . " 23:59:59";
			$strSql="SELECT *,DATEDIFF(LEFT(awDate,10),'" . substr($cmIndate,0,10) .  "')+1 as avgTerm, awDate as avgDate, awWeight as avgWeight, awDevi as avgDevi,awVc as avgVc
					 FROM avg_weight WHERE	 awFarmid='$farmID' AND awDongid='$dongID' AND (awDate BETWEEN '$sDate' AND '$eDate') ORDER BY awDate ";
			break;

		case "TODAY": //입추상태+ 오늘자료만 Query
			$sDate=$toDay . " 00:00:00";
			$eDate=$toDay . " 23:59:59";
			$strSql="SELECT *,DATEDIFF(LEFT(awDate,10),'" . substr($cmIndate,0,10) .  "')+1 as avgTerm, awDate as avgDate, awWeight as avgWeight, awDevi as avgDevi,awVc as avgVc
					 FROM avg_weight WHERE	 awFarmid='$farmID' AND awDongid='$dongID' AND (awDate BETWEEN '$sDate' AND '$eDate') ORDER BY awDate ";
			break;
		case "ALLDAY": //입추상태+ 입추일자로 부터 오늘까지 Query
			$sDate=substr($cmIndate,0,10);
			$eDate=$toDay;
			$strSql="SELECT *
					 FROM (
							SELECT *,DATEDIFF(LEFT(awDate,10),'" . substr($cmIndate,0,10) .  "')+1 as avgTerm, awDate as avgDate, awWeight as avgWeight, awDevi as avgDevi,awVc as avgVc
							FROM avg_weight 
							WHERE  awFarmid='$farmID' AND awDongid='$dongID' AND (LEFT(awDate,10) BETWEEN '$sDate' AND '$eDate') ORDER BY awDate DESC
					 ) as TT
					 GROUP BY LEFT(TT.awDate,10)";
			break;
		case "INOUTDAY": //출하상태+ 입추일자로 부터 출하일자까지 Query
			$sDate=substr($cmIndate,0,10);
			$eDate=substr($cmOutdate,0,10);
			$strSql="SELECT *
					 FROM (
							SELECT *,DATEDIFF(LEFT(awDate,10),'" . substr($cmIndate,0,10) .  "')+1 as avgTerm, awDate as avgDate, awWeight as avgWeight, awDevi as avgDevi,awVc as avgVc
							FROM avg_weight 
							WHERE  awFarmid='$farmID' AND awDongid='$dongID' AND (LEFT(awDate,10) BETWEEN '$sDate' AND '$eDate') ORDER BY awDate DESC
					 ) as TT
					 GROUP BY LEFT(TT.awDate,10)";
			break;
	}

	$getData=multiFindData($strSql,$dbConn);


	//결과값 Return==========================
	$retArr=array();
	$chartArr=array();		//차트배열
	$chartTable=array();	//테이블배열

	//2021-04-28 이병선 수정 //어제대비 오늘 증체중량 변화추이 - 가로를 24시간 다채우게 고정함
	if($prnType == "TODAYINC"){

		$time_map = array();

		$today_inc_max = 0;
		
		foreach($getData as $val){
			$avg_weight = $val["avgWeight"];
			$avg_date = $val["avgDate"];

			$time_map[$avg_date] = $avg_weight;
		}

		$temp = $toDay . " 00:00:00";
		$end_day = date("Y-m-d",strtotime("+1 Days")) . " 00:00:00";	
		$now_date = date("Y-m-d H:i:s");
		$now_date = substr($now_date, 0, 15) . "0:00";

		while($temp != $end_day){
			$avg_weight = $yesterDayAvgWeight;
			//해당 시간에 산출된 데이터가 있는지 조회
			if(isset($time_map[$temp])){
				$avg_weight = $time_map[$temp];
			}

			$avg_inc = ($avg_weight - $yesterDayAvgWeight) > 0 ? $avg_weight - $yesterDayAvgWeight : 0;
			if($avg_inc > $today_inc_max){
				$today_inc_max = $avg_inc;
			}

			// 미래의 시간은 0으로 채움
			if($now_date == $temp){
				$today_inc_max = 0;
			}

			$chartArr[] = array(
				"시간" => substr($temp, 11, 5),
				"증체중량" => sprintf('%0.1f', $today_inc_max)
			);

			$temp = date("Y-m-d H:i:s", strtotime("+10 minutes", strtotime($temp)));
		}
	}

	foreach($getData as $Val){

		$avgTerm=$Val["avgTerm"];
		$avgWeight=$Val["avgWeight"];

		//중량값 보정(2021-02-05)====================================
		$avgWeight=corrAvgWeight("육계",$avgTerm,$avgWeight);
		//중량값 보정(2021-02-05)====================================

		switch($prnType){

			case "TODAY":
				$chartArr[]=array(
					"시간" => substr($Val["awDate"],11,5),
					"평균중량" => sprintf('%0.1f',$avgWeight)+0,
					"권고평체" => sprintf('%0.1f',$recommRange[$avgTerm])+0
				);
				break;
			case "ALLDAY":
				$chartArr[]=array(
					"일령" => $avgTerm ."일",
					"평균중량" => sprintf('%0.1f',$avgWeight)+0,
					"권고평체" => sprintf('%0.1f',$recommRange[$avgTerm])+0
				);
				$chartTable[]=array(
					"f1" => $avgTerm,									/*일령*/
					"f2" => substr($Val["avgDate"],5,5),				/*날짜*/
					"f3" => sprintf('%0.1f',$recommRange[$avgTerm])+0,	/*권고중량*/
					"f4" => sprintf('%0.1f',$avgWeight)+0,				/*평균중량*/
					"f5" => sprintf('%0.1f',$Val["avgDevi"]*corrDevi),	/*표준편차*/
					"f6" => sprintf('%0.1f',$Val["avgVc"])+0			/*변이계수*/
				);
				break;
			case "INOUTDAY":
				$chartArr[]=array(
					"일령" => $avgTerm . "일",
					"평균중량" => sprintf('%0.1f',$avgWeight) +0,
					"권고평체" => sprintf('%0.1f',$recommRange[$avgTerm]) +0
				);
				$chartTable[]=array(
					"f1" => $avgTerm,									/*일령*/
					"f2" => substr($Val["avgDate"],5,5),				/*날짜*/
					"f3" => sprintf('%0.1f',$recommRange[$avgTerm]) +0, /*권고중량*/
					"f4" => sprintf('%0.1f',$avgWeight)+0,				/*평균중량*/
					"f5" => sprintf('%0.1f',$Val["avgDevi"]*corrDevi),	/*표준편차*/
					"f6" => sprintf('%0.1f',$Val["avgVc"])+0			/*변이계수*/
				);
				break;
		}
	}

	$retArr["chartArr"]=$chartArr;	
	$retArr["chartTable"]=$chartTable;	

	return $retArr;
}


//=====================================================================================
//환경센서Data 불러오기
//=====================================================================================
//$chkInOutCode : comein_master의 cmCode
//$sensorType : 온도,습도,CO2,NH3
//$prnType : TODAY, ALLDAY, INOUTDAY
//=====================================================================================
function avgEnvironment($chkInOutCode,$sensorType,$prnType,$dbConn,$mongoDB){

	//입추 및 출하정보 가져오기=================
	$strSql="SELECT * FROM comein_master WHERE cmCode='" . $chkInOutCode . "'";
	$getData=multiFindData($strSql,$dbConn);

	$farmID=$getData[0]["cmFarmid"]; //농장ID
	$dongID=$getData[0]["cmDongid"]; //동ID
	$cmIntype=$getData[0]["cmIntype"]; //입추형식
	$cmIndate=$getData[0]["cmIndate"]; //입추일자
	$cmOutdate=$getData[0]["cmOutdate"]; //출하일자


	//센서별Range값 => 온도,습도,CO2,NH3
	$recommRange=array();
	$strSql="SELECT fmCntday, fmLevel1 FROM feeding_mgr WHERE fmIntype='$cmIntype' AND fmSensortype='$sensorType' ORDER BY fmCntday";
	$getData=multiFindData($strSql,$dbConn);
	foreach($getData as $Val){
		$recommRange[$Val["fmCntday"]]=$Val["fmLevel1"];
	}

	//mongodb Group 지정======================
	$toDay=date('Y-m-d'); //오늘일자

	switch($prnType){
		case "TODAY" : //입추상태+ 오늘자료만 Query
			$sDate=$toDay . " 00:00:00";
			$eDate=$toDay . " 23:59:59";
			$getTime=array('$getTime',11,5); //시:분	
			break;
		case "ALLDAY": //입추상태+ 입추일자로 부터 오늘까지 Query
			$sDate=	$cmIndate;
			$eDate= $toDay . " 23:59:59";
			$getTime=array('$getTime',0,10); //년-월-일

			break;
		case "INOUTDAY": //출하상태+ 입추일자로 부터 출하일자까지 Query
			$sDate=	$cmIndate;
			$eDate= $cmOutdate;
			$getTime=array('$getTime',0,10); //년-월-일			
			break;
	}

	//mongoDB Query==========================
	$mongoCollection= $mongoDB -> sensorData;
	$pipeLine=array(
				array('$match' => array(
									'farmID'	=> $farmID,
									'dongID'	=> $dongID,
									'getTime'	=> array('$gte' => $sDate,'$lte' => $eDate),
								  )
				),
				array('$group' => array(
										'_id' => array('$substr' => $getTime ),
										'avgTemp' => array('$avg' => array( '$cond' => array(array('$gt' => array('$temp',0)),'$temp',Null) ) ),
										'avgHumi' => array('$avg' => array( '$cond' => array(array('$gt' => array('$humi',0)),'$humi',Null) ) ),
										'avgCO' => array('$avg' => array( '$cond' => array(array('$gt' => array('$co',0)),'$co',Null) ) ),
										'avgNH' => array('$avg' => array( '$cond' => array(array('$gt' => array('$nh',0)),'$nh',Null) ) )
									)
				),
				array('$sort' => array("_id"=>1))
	);

	$mongocursor=$mongoCollection->aggregate($pipeLine, array("cursor" => array("batchSize" => 1440)) ); //LIMIT 1440개와 동일(60EZ*24H)
	$mongoResult=mongoExcute($mongocursor);


	//결과값 Return==========================
	$retArr=array();
	$chartArr=array();		//차트배열
	$chartTable=array();	//테이블배열


	//온도:-1.2도 습도:+7% 보정 ==> 2020.11.25

	foreach($mongoResult as $Val){
		
		switch($prnType){
			case "TODAY":
				$inTerm=dateDiff($toDay,substr($cmIndate,0,10)); //일령
				switch($sensorType){
					case "온도": $chartArr[]=array( '시간' => $Val["_id"], '평균온도' => sprintf('%0.1f',$Val["avgTemp"]-1.2), "권고온도" => $recommRange[$inTerm]); break;
					case "습도": $chartArr[]=array( '시간' => $Val["_id"], '평균습도' => sprintf('%0.1f',$Val["avgHumi"]+7), "권고습도" => $recommRange[$inTerm]); break;
					case "CO2": $chartArr[]=array( '시간' => $Val["_id"], '평균CO2' => sprintf('%0.1f',$Val["avgCO"]), "권고CO2" => $recommRange[$inTerm]); break;
					case "NH3": $chartArr[]=array( '시간' => $Val["_id"], '평균NH3' => sprintf('%0.1f',$Val["avgNH"]), "권고NH3" => $recommRange[$inTerm]); break;
				}
				break;

			default: // ALLDAY or INOUTDAY를 의미함.
				$inTerm=dateDiff($Val["_id"],substr($cmIndate,0,10)); //일령
				switch($sensorType){
					case "온도": 
						$chartArr[]=array( '일령' => $inTerm . "일", '평균온도' => sprintf('%0.1f',$Val["avgTemp"]-1.2), "권고온도" => sprintf('%0.1f',$recommRange[$inTerm]) );
						$tmpTerm=sprintf('%0.1f',($Val["avgTemp"]-1.2)-$recommRange[$inTerm]);
						$chartTable[]=array("f1" => $inTerm, "f2" => $Val["_id"], "f3" => sprintf('%0.1f',$recommRange[$inTerm])+0, "f4" => sprintf('%0.1f',$Val["avgTemp"])+0, "f5" => $tmpTerm+0);
						break;
					case "습도": 
						$chartArr[]=array( '일령' => $inTerm . "일", '평균습도' => sprintf('%0.1f',$Val["avgHumi"]+7), "권고습도" => $recommRange[$inTerm]); 
						$tmpTerm=sprintf('%0.1f',($Val["avgHumi"])-$recommRange[$inTerm]);
						$chartTable[]=array("f1" => $inTerm, "f2" => $Val["_id"], "f3" => sprintf('%0.1f',$recommRange[$inTerm])+0, "f4" => sprintf('%0.1f',$Val["avgHumi"])+0, "f5" => $tmpTerm+0);
						break;
					case "CO2": 
						$chartArr[]=array( '일령' =>  $inTerm . "일", '평균CO2' => sprintf('%0.1f',$Val["avgCO"]), "권고CO2" => $recommRange[$inTerm]); 
						$tmpTerm=sprintf('%0.1f',$Val["avgCO"]-$recommRange[$inTerm]);
						$chartTable[]=array("f1" => $inTerm, "f2" => $Val["_id"], "f3" => sprintf('%0.1f',$recommRange[$inTerm])+0, "f4" => sprintf('%0.1f',$Val["avgCO"])+0, "f5" => $tmpTerm+0);
						break;
					case "NH3": 
						$chartArr[]=array( '일령' =>  $inTerm . "일", '평균NH3' => sprintf('%0.1f',$Val["avgNH"]), "권고NH3" => $recommRange[$inTerm]); 
						$tmpTerm=sprintf('%0.1f',$Val["avgNH"]-$recommRange[$inTerm]);
						$chartTable[]=array("f1" => $inTerm, "f2" => $Val["_id"], "f3" => sprintf('%0.1f',$recommRange[$inTerm])+0, "f4" => sprintf('%0.1f',$Val["avgNH"])+0, "f5" => $tmpTerm+0);
						break;
				}
				break;
		}
	}
	$retArr["chartArr"]=$chartArr;	
	$retArr["chartTable"]=$chartTable;

	return $retArr;
}



//===========================================
//일령별 경보단계 확인
//$inType : 입추형식(육계,삼계,토종닭,산란계)
//$sensorType : 평균중량/온도/습도/CO2/NH3
//$cntDay : 일령
//$chkVal : 받은 Data
//$dbConn : DB연결
//===========================================
function sensorLevel($inType,$sensorType,$cntDay,$chkVal,$dbConn){
	$retArr=array();
	$levelMsg="";
	$strSql="SELECT * FROM feeding_mgr WHERE fmIntype=\"$inType\" AND fmSensortype=\"$sensorType\" AND fmCntday=$cntDay ";
	$getData=multiFindData($strSql,$dbConn);

	if(count($getData)>0){
		if ($chkVal < $getData[0]["fmLevel2"]){
			$levelMsg="<span class='label label-info'>정상</span>";
		} else if ($getData[0]["fmLevel2"]<= $chkVal && $chkVal  < $getData[0]["fmLevel3"]){
			$levelMsg="<span class='label label-success'>주의</span>";
		} else if ($getData[0]["fmLevel3"]<= $chkVal && $chkVal < $getData[0]["fmLevel4"]){
			$levelMsg="<span class='label label-warning'>경고</span>";
		} else if ($getData[0]["fmLevel4"]<= $chkVal){
			$levelMsg="<span class='label label-danger'>위험</span>";
		}
	}

	return $levelMsg;
}
?>