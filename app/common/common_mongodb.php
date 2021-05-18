<?
//======================================
//--mongoDB 접속 정보
//======================================
$mongodbArr=mongodbINIT();
$mongoDB_Host	= $mongodbArr["mongoDB_Host"]; 
$mongoDB_User	= $mongodbArr["mongoDB_User"];
$mongoDB_Pass	= $mongodbArr["mongoDB_Pass"];		
$mongoDB_Name	= $mongodbArr["mongoDB_Name"];

$mongoConn=new MongoClient("mongodb://$mongoDB_Host",array(
	'username' => $mongoDB_User,
	'password' => $mongoDB_Pass,
	'db'	   => $mongoDB_Name
));

//몽고DB선택 (use testDB)
$mongoDB = $mongoConn -> kokofarm1;

//======================================
//DB연결 정보 가져오기
//======================================
function mongodbINIT(){
	$dbConfigArr=array();

	$fp = fopen("../common/mongodbconn.cfg","r"); 
	$tmp=fgets($fp); $posi=strpos($tmp,";"); $dbConfigArr["mongoDB_Host"]=trim(substr($tmp,0,$posi));
	$tmp=fgets($fp); $posi=strpos($tmp,";"); $dbConfigArr["mongoDB_User"]=trim(substr($tmp,0,$posi));
	$tmp=fgets($fp); $posi=strpos($tmp,";"); $dbConfigArr["mongoDB_Pass"]=trim(substr($tmp,0,$posi));
	$tmp=fgets($fp); $posi=strpos($tmp,";"); $dbConfigArr["mongoDB_Name"]=trim(substr($tmp,0,$posi));
	fclose($fp);

	return $dbConfigArr;
}


//======================================
//몽고DB Query 실행
//======================================
function mongoExcute($mongoCursor){
	return $mongoCursor["cursor"]["firstBatch"];
}


/*
	db.getCollection('sensorData').aggregate(
	   {
		   '$match':{
			   'farmID':'KF0001',
			   'dongID':'01',
			   'getTime':{'$gte':'2019-08-21 12:57:00','$lte':'2019-08-21 13:00:59'},
		   }
		   
	   },
	   {
			'$group':{
				'_id' :{ '$substr':['$getTime',11,5] },
				'avgTemp':{'$avg':{$cond: [ { $gt: [ '$temp', 0 ] }, '$temp', null ]}},
				'avgHumi':{'$avg':{$cond: [ { $gt: [ 'humi', 0 ] }, '$humi', null ]}},
				'avgCO':{'$avg':{$cond: [ { $gt: [ '$co', 0 ] }, '$co', null ]}},
				'avgNH':{'$avg':{$cond: [ { $gt: [ '$nh', 0 ] }, '$nh', null ]}}
			} 
	   },
	   {
		   '$sort':{'_id':1}
	   } 
	)




입추상태일 경우=>BoardID별로 모두 보여줌(기준시점에서 -20시간 까지)
db.getCollection('gatherEnvironment').aggregate(
   {
       "$match":{
           "farmID":"KF3425",
           "dongID":"01",
           "getTime":{"$gte":"2018-06-12 08:13:01","$lte":"2018-06-12 23:00:01"}
       }
       
   },
   {
       "$sort":{"getTime":1}
   } 
)

출하상태일 경우는 전 일정에 대해 시간대별 평균온도/습도/CO2/NH3 보여줌
db.gatherEnvironment.aggregate([
    {
      '$match' :{
           "farmID":"KF3425",
           "dongID":"01",
           "getTime":{"$gte":"2018-06-29 13:07:50","$lte":"2018-06-29 13:08:26"},
           "temp":{"$ne":-99} =센서 Error Data는 제외
      }
    },
    {
        '$group':{
            '_id':{'$substr':['$getTime',0,13] },
            'avgValue':{'$avg':'$temp'},
        },
    },
    {
        '$sort':{'_id':1}
    }
])


db.gatherEnvironment.aggregate([
    {
        '$match':{'farmID':'KF3425','dongID':'01'}
    },
    {
        '$sort':{'getTime':-1}
    },
    {
        '$limit':501
    }
    
])


	//=========================================================
	//오늘 온도,습도,CO2,NH3 변화추이(저울별)
	//=========================================================
	/*
	db.sensorData.aggregate([
		{
		  '$match' :{
			   'farmID':'KF0001',
			   'dongID':'01',
			   'getTime':{'$gte':'2019-08-21 12:57:00','$lte':'2019-08-21 13:00:59'},
		  }
		},
		{
			'$project':{
			   'jeoulID':1,'getTime':{'$substr':['$getTime',11,5]},'temp':1,'humi':1,'co':1,'nh':1
			}
		},
		{
			'$sort':{'_id':1}
		}    
	])

	function toDayEnvironment($farmID,$dongID,$mongoDB,$retType){
		$toDay=date('Y-m-d'); //오늘일자
		$sDate=$toDay . " 00:00:00";
		$eDate=$toDay . " 23:59:59";

		$mongoCollection= $mongoDB -> sensorData;
		$pipeLine=array(
					array('$match' => array(
										'farmID'	=> $farmID,
										'dongID'	=> $dongID,
										'getTime'	=> array('$gte' => $sDate,'$lte' => $eDate),
									  )
					),
					array('$project' => array(
										'_id' => 1,
										'jeoulID' => 1,
										'getTime' => array('$substr' => array('$getTime',11,5)),
										'temp' => 1,
										'humi' => 1,
										'co' => 1,
										'nh' => 1
										)
					),
					array('$sort' => array("getTime"=>1))
		);
	}
	*/
?>