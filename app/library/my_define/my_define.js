//=======================================
//구글맵 관련
//=======================================
var map=new Array();			//마커 Object 생성
var markers=new Array();		//마커 핸들링을 위한 배열
var markersCircle=new Array();	//마커 circle 핸들링을 위한 배열

//구글맵 마커
var iconBase = '../images/markers/';
var icons = {orange:{icon: iconBase + 'orange_m.png'},
			 green:	{icon: iconBase + 'green_m.png'	},
			 purple:{icon: iconBase + 'purple_m.png'},
			 blue:	{icon: iconBase + 'blue_m.png'	},
};

//마커와 마커써클 Delete
function delMarkers(mapVariable){
	for(var key in markers[mapVariable]){
		markers[mapVariable][key].setMap(null);			//마커삭제(Key값이 없을 경우를 대비 각자 지우기)
	}
	markers[mapVariable]=[];

	for(var key in markersCircle[mapVariable]){
		markersCircle[mapVariable][key].setMap(null);	//마커써클 삭제(Key값이 없을 경우를 대비 각자 지우기)
	}
	markersCircle[mapVariable]=[];
}

//마커생성
//mapName : 맵의 메인 변수명
//houseData : 맵의 자표Data
function addMarkers(mapName,houseData){


	markers[mapName]=new Array();

	for(var i=0; i<=houseData.length-1; i++){
		if(houseData[i].houseStatus==="입추"){
			var marker=new google.maps.Marker({
				position: new google.maps.LatLng(houseData[i].gpsLat, houseData[i].gpsLng),title:houseData[i].dongName,icon: icons["purple"].icon,map:map[mapName],
				animation:google.maps.Animation.DROP,zIndex:9999
			});
		}
		else{
			var marker=new google.maps.Marker({
				position: new google.maps.LatLng(houseData[i].gpsLat, houseData[i].gpsLng),title:houseData[i].dongName,icon: icons["orange"].icon,map:map[mapName],
			});
		}
		markers[mapName].push(marker);
		

		//Marker click event
		google.maps.event.addListener(marker, 'click', (function(marker, i) {
			return function() {
				var houseID=houseData[i].houseID;	
				getHouse(houseID);	 	//하우스 현황 가져오기
	
			}
		})(marker, i));
	}
};


//마커생성--영역표시(Km)
function addMarkersZone(mapName,houseData){
	markers[mapName]=new Array();
	markersCircle[mapName]=new Array();

	for(var i=0; i<=houseData.length-1; i++){
		//마커생성
		if(houseData[i].marker_icon==="orange" || houseData[i].marker_icon==="purple"){
			var marker=new google.maps.Marker({
				position: new google.maps.LatLng(houseData[i].gpsLat, houseData[i].gpsLng),title:houseData[i].dongName, icon: icons[houseData[i].marker_icon].icon,map:map[mapName],
				animation:google.maps.Animation.DROP,zIndex:9999
			});
		}
		else{
			var marker=new google.maps.Marker({
				position: new google.maps.LatLng(houseData[i].gpsLat, houseData[i].gpsLng),title:houseData[i].dongName, icon: icons[houseData[i].marker_icon].icon,map:map[mapName],
			});
		}
		markers[mapName].push(marker);

		//마커 영역 생성
		if(houseData[i].marker_icon==="orange"){
			var mapCircle = new google.maps.Circle({
				strokeColor: 'orange',strokeOpacity: 0.3,strokeWeight: 1,fillColor: 'orange',fillOpacity: 0.3,map: map[mapName],
				center: new google.maps.LatLng(houseData[i].gpsLat, houseData[i].gpsLng),
				radius:5000 /*5Km 반경*/
			});
			markersCircle[mapName].push(mapCircle);
		}
		if(houseData[i].marker_icon==="purple"){
			var mapCircle = new google.maps.Circle({
				strokeColor: 'purple',strokeOpacity: 0.3,strokeWeight: 1,fillColor: 'purple',fillOpacity: 0.3,map: map[mapName],
				center: new google.maps.LatLng(houseData[i].gpsLat, houseData[i].gpsLng),
				radius:30000 /*30Km 반경*/
			});
			markersCircle[mapName].push(mapCircle);
		}

		//Marker click event
		google.maps.event.addListener(marker, 'click', (function(marker, i) {
			return function() {
				var houseID=houseData[i].houseID;	
				getHouse(houseID);	 	//하우스 현황 가져오기
	
			}
		})(marker, i));

	}
};


//=======================================
//panel Collapsible function (패널 접고 펼치기)
//=======================================
$(document).on('click', '.panel-heading span.clickable', function(e){
	var $this = $(this);
	if(!$this.hasClass('panel-collapsed')) {
		$this.parents('.panel').find('.panel-body').slideUp();
		$this.addClass('panel-collapsed');
		$this.find('i').removeClass('glyphicon-chevron-up').addClass('glyphicon-chevron-down');
	} else {
		$this.parents('.panel').find('.panel-body').slideDown();
		$this.removeClass('panel-collapsed');
		$this.find('i').removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-up');
	}
})


//=======================================
//현재 날짜 가져오기
//=======================================
function getToday(){
	var toDay = new Date();
	var date=toDay.getFullYear() + "-" + digitConvert(toDay.getMonth()+1,2) + "-" + digitConvert(toDay.getDate(),2);
	return date;
}

//년월일시분초
function getDateTime(){
	var toDay = new Date();
	var datetime=toDay.getFullYear() + digitConvert(toDay.getMonth()+1,2) + digitConvert(toDay.getDate(),2) + digitConvert(toDay.getHours(),2) + digitConvert(toDay.getMinutes(),2) + digitConvert(toDay.getSeconds(),2);
	return datetime;
}

//=======================================
//시계
//=======================================
function currClock() {
    var today = new Date();
    var h = today.getHours();
    var m = today.getMinutes();
    var s = today.getSeconds();
	h = digitConvert(h,2);
    m = digitConvert(m,2);
    s = digitConvert(s,2);
	$("#clockDate").html("오늘:" + getToday());
	$("#clockTime").html( "<i class='fa fa-clock-o'></i>&nbsp;" + h + ":" + m + ":" + s);
    var t = setTimeout(currClock, 1000);
}

//======================================
//자리수
//======================================
function digitConvert(n, width) {
	n = n + '';
	return n.length >= width ? n : new Array(width - n.length + 1).join('0') + n;
};


//===================================
//팝업 메시지창(Alert를 대신)
//===================================
function Common_popupAlert(geTtitle,getMsg){
	$("#modalTitle").html(geTtitle);					//modal title
	$("#modalBody").html("<p>" + getMsg + "</p>");		//modal 내용
	$("#modalPopup").modal('show');						//modal open
};

//===================================
//모달창 팝업 및 선택 callback
//===================================
function confirm_modal_popup(title, msg, work){
	$("#confirmModalTitle").html(title);					//modal title
	$("#confirmModalBody").html("<p>" + msg + "</p>");		//modal 내용

	// 체크박스를 숨김
	$("#confirm_check").hide();
	$("#confirmModalCheckLabel").html("");

	$("#confirmModal").modal('show');						//modal open

	modal_confirm(work);
};

// 확인 및 취소 버튼 클릭 시 실행 할 작업을 바인딩 함
var modal_confirm = function (work){
	$("#confirm_ok").off("click").on("click", function(){		// off로 이벤트 중복을 방지함
		$("#confirmModal").modal('hide');
		work(true);
	});
	
	$("#confirm_cancle").off("click").on("click", function(){
		$("#confirmModal").modal('hide');
		work(false);
	});
};

//===================================
//모달창 팝업 및 선택 callback (체크박스 포함)
//===================================
function confirm_modal_popup_with_check(title, msg, check_msg, work){
	$("#confirmModalTitle").html(title);					//modal title
	$("#confirmModalBody").html("<p>" + msg + "</p>");		//modal 내용

	// 체크박스를 출력
	$("#confirmModalCheckLabel").html("&nbsp;&nbsp;" + check_msg);
	$("#confirm_check").show();

	$("#confirmModal").modal('show');						//modal open

	check_modal_confirm(work);
};

// 확인 및 취소 버튼 클릭 시 실행 할 작업을 바인딩 함 (체크박스 포함)
var check_modal_confirm = function (work){

	$("#confirm_ok").off("click").on("click", function(){		// off로 이벤트 중복을 방지함
		$("#confirmModal").modal('hide');
		work(true, $("#confirm_check [name=invisible]").is(":checked"));
	});
	
	$("#confirm_cancle").off("click").on("click", function(){
		$("#confirmModal").modal('hide');
		work(false, $("#confirm_check [name=invisible]").is(":checked"));
	});
};


//===================================
//3자리 (,) 찍기
//===================================
function comma(n) {
	var reg = /(^[+-]?\d+)(\d{3})/;   // 정규식
	n += "";                          // 숫자를 문자열로 변환
	while (reg.test(n)){
		n = n.replace(reg, "$1" + "," + "$2");
	}
	return n;
}


//===================================
//jqGrid 관련 function
//===================================

//jqGrid resize
$(document).ready(function(){
	$(".jqGridMasterZone").bind("resize", function(){
		$(".jqGridMasterTable").setGridWidth($(".jqGridMasterZone").width());
		$(".jqGridDetailTable").setGridWidth($(".jqGridDetailZone").width());
	});

	$(".jqGridDetailZone").bind("resize", function(){
		$(".jqGridMasterTable").setGridWidth($(".jqGridMasterZone").width());
		$(".jqGridDetailTable").setGridWidth($(".jqGridDetailZone").width());
	});
});

//jqGrid formatter==>날짜 : 년-월-일 시:분:초
function func_showDateTime(cellvalue,options,roeObject){
	var returnData="";
	if (cellvalue!=="") {
		var strDate=cellvalue;
		var yy=strDate.substr(0,4);
		var mm=strDate.substr(4,2);
		var dd=strDate.substr(6,2);
		var hh=strDate.substr(8,2);
		var ii=strDate.substr(10,2);
		var ss=strDate.substr(12,2);
		returnData=yy + "-" + mm + "-" + dd + " " + hh + ":" + ii + ":" + ss;
	}
	return returnData;
};

//jqGrid formatter==>날짜 : 년-월-일
function func_showDate(cellvalue,options,roeObject){
	var returnData="";
	if (cellvalue!=="") {
		var strDate=cellvalue;
		returnData=strDate.substr(0,10);
	}
	return returnData;
};

// 두 날짜의 차이를 구함
function get_date_diff(start, end){

	if(start.length >= 10 && end.length >= 10){
		start_date = new Date(start.substr(0,4), parseInt(start.substr(5,2)) - 1, parseInt(start.substr(8,2)) + 1);
		end_date = new Date(end.substr(0,4), parseInt(end.substr(5,2)) - 1, parseInt(end.substr(8,2)) + 1);

		var diff = end_date.getTime() - start_date.getTime();

    	diff = Math.ceil(diff / (1000 * 3600 * 24));

		return diff;
	}
	return 0;
};

// 두 시간의 차이를 구함
function get_time_diff(start, end){

	if(start.length >= 15 && end.length >= 15){
		start_date = new Date(start.substr(0,4), start.substr(5,2), start.substr(8,2), start.substr(11,2), start.substr(14,2), start.substr(17,2));
		end_date = new Date(end.substr(0,4), end.substr(5,2), end.substr(8,2), end.substr(11,2), end.substr(14,2), end.substr(17,2));

		var diff = end_date.getTime() - start_date.getTime();
    	diff = Math.ceil(diff / 1000);

		return diff;
	}
	return 0;
};

// 현재 시간을 YYYY-MM-DD hh:mm:ss 형식으로 가져옴
function get_now_datetime(){
    return get_now_date() + " " + get_now_time();
};

// 현재 날짜를 YYYY-MM-DD 형식으로 가져옴
function get_now_date(){
    var date = new Date();
    var year = date.getFullYear();
    var month = ("0" + (1 + date.getMonth())).slice(-2);
    var day = ("0" + date.getDate()).slice(-2);

    return year + "-" + month + "-" + day;
};

// 현재 시간을 hh:mm:ss 형식으로 가져옴
function get_now_time(){
    var date = new Date();
    var hour = ("0" + date.getHours()).slice(-2);
    var min = ("0" + date.getMinutes()).slice(-2);
    var sec = ("0" + date.getSeconds()).slice(-2);

    return hour + ":" + min + ":" + sec;
};

function get_plus_minus_time(origin, gap){
	var origin_date = new Date(origin);
	var ret = origin_date.getTime() + gap;
	var return_date = new Date(ret);

	return get_format_datetime(return_date);
};

// date 객체를 받아 YYYY-MM-DD 포맷팅
function get_format_date(date){
    var year = date.getFullYear();
    var month = ("0" + (1 + date.getMonth())).slice(-2);
    var day = ("0" + date.getDate()).slice(-2);

    return year + "-" + month + "-" + day;
};

// date 객체를 받아 hh:mm:ss 포맷팅
function get_format_time(date){
    var hour = ("0" + date.getHours()).slice(-2);
    var min = ("0" + date.getMinutes()).slice(-2);
    var sec = ("0" + date.getSeconds()).slice(-2);

    return hour + ":" + min + ":" + sec;
};

// date 객체를 받아 YYYY-MM-DD hh:mm:ss 포맷팅
function get_format_datetime(date){
    var year = date.getFullYear();
    var month = ("0" + (1 + date.getMonth())).slice(-2);
    var day = ("0" + date.getDate()).slice(-2);
	var hour = ("0" + date.getHours()).slice(-2);
    var min = ("0" + date.getMinutes()).slice(-2);
    var sec = ("0" + date.getSeconds()).slice(-2);

    return year + "-" + month + "-" + day + " " + hour + ":" + min + ":" + sec;
};

// 쿠키 설정
function set_cookie(name, val, time){
	var date = new Date();
	date.setTime(date.getTime() + time*24*60*60*1000);
	document.cookie = name + '=' + val + ';expires=' + date.toUTCString() + ';path=/';
};

// 쿠키 가져오기
function get_cookie(name){
	var value = document.cookie.match('(^|;) ?' + name + '=([^;]*)(;|$)');
	//var tt = value ? value[2] : null;
	//alert("get_cookie => " + name + " : " + tt);
	return value ? value[2] : null;
};

// 쿠키 삭제하기
function del_cookie(name){
	document.cookie = name + '=; expires=Thu, 01 Jan 1999 00:00:10 GMT;path=/';
};


//===================================
//amChart 관련 function
//===================================
//=====================================================================
//amChart => 선택형 차트
//=====================================================================
//Usage : var tt=drawSelectChart("charDIV",chartData,"라인차트","Y","Y",12);
//=====================================================================
//chartID : 화면에 출력할 div tag의 ID값
//chartData : josn배열
//chartStyle : 차트모양
//zoomYN : Zoom 출력 여부
//labelYN : Label 출력 여부
//fontSize : 차트의 출력되는 font size
//=====================================================================
function drawSelectChart(chartID,chartData,chartStyle,zoomYN,labelYN,fontSize){
	if(chartData.length<=0){ return false; } //Data 갯수가 없으면 return false;

	//01-amChart의 graphs ==> JSON 형식으로
	var graphsJSON=new Array();
	var categoryField="";
	var graphsCnt=-1;
	var graphsColor=["#3366CC","#FF9900","#109618","#990099","#0099C6","#DD4477","#66AA00","#B82E2E","#316395","#994499","#22AA99","#AAAA11","#DC3912"];
	var olnyCircle_lastKey=""; //원형차트를 위함

	$.each(chartData[0], function(key,value){
		graphsCnt++;
		if(graphsCnt===0){
			categoryField=key;
		}
		else{
			var graphsObj={};
			graphsObj["title"]=key; 
			graphsObj["valueField"]=key;
			graphsObj["balloonText"]="<font style='font-size:" + fontSize + "px'><b>[[title]]</b><br>[[[value]]]</font>";	/*마우스 Over Label*/
			graphsObj["bullet"]="round";						/*꼭지점*/
			graphsObj["bulletSize"]=4;							/*차트 꼭지점 Size*/
			graphsObj["useLineColorForBulletBorder"]="true";	/*꼭지점*/

			if(labelYN==="Y"){
				graphsObj["labelText"]="[[value]]";					/*값 출력*/
			}

			switch(chartStyle){
				case "라인차트":
					graphsObj["type"]="smoothedLine";					/*차트모양*/
					graphsObj["lineThickness"]=1;						/*라인굵기*/
					break;
				case "영역차트":
					graphsObj["type"]="smoothedLine";					/*smoothedLine*/
					graphsObj["lineThickness"]=1;						/*라인굵기*/
					graphsObj["fillAlphas"]=0.2;
					break;
				default:
					graphsObj["type"]="column";							/*차트모양*/
					graphsObj["lineAlpha"]=0.2;
					graphsObj["fillAlphas"]=0.9;

					break;
			}
			graphsJSON.push(graphsObj);
		}
		olnyCircle_lastKey=key; /*원형차트를 위함*/
	});


	//차트옵션 정하기
	var chartOption=new Array();
	chartOption={"type": "serial","theme": "light","language":"ko","marginRight":20,"fontSize":fontSize,
				 "dataProvider": chartData,"categoryField":categoryField,"graphs": graphsJSON,
				 "chartCursor": {"categoryBalloonDateFormat": "YYYY-MM-DD HH:NN","cursorPosition": "mouse"},					  /*가이드라인*/
				 "legend":{"bulletType":"round","valueWidths":"false","useGraphSettings":true,"color":"black","align":"center"},  /*범례*/
				 /* "categoryAxis":{"minPeriod": "ss","parseDates": true} 가로눈금  =====>삭제*/
	};

	switch(chartStyle){
		case "가로-Bar":
			chartOption["rotate"]=true;
			break;
		case "세로-Bar":
			chartOption["rotate"]=false;
			break;
		case "가로-누적":
			chartOption["rotate"]=true;
			chartOption["valueAxes"]=[{"stackType": "regular","axisAlpha": 0.5,"gridAlpha": 0}]; /*누적형식(regular:일반,100%:100%누적)*/
			break;
		case "세로-누적":
			chartOption["rotate"]=false;
			chartOption["valueAxes"]=[{"stackType": "regular","axisAlpha": 0.5,"gridAlpha": 0}]; /*누적형식(regular:일반,100%:100%누적)*/
			break;
		case "원형차트":
			chartOption=new Array();
			chartOption={
				"type": "pie","theme": "light","startDuration":0.1,"fontSize":fontSize,
				"dataProvider": chartData,"valueField": olnyCircle_lastKey,"titleField": categoryField,
				"outlineAlpha": 0.4,
				"innerRadius": 80,	 /*내부 Holl*/
				"pullOutRadius": 50, /*Pie 크기조정==>숫자가 작을수록 Pie는 커짐*/
				"legend":{"bulletType":"round","position":"right","align":"center","valueWidth":0}, /*범례*/
				"depth3D": 10,		 /*3D효과 각도조절*/
				"balloonText": "<font style='font-size:14px'><b>[[title]]</b><br>[[value]] ([[percents]]%)</font>",
				"allLabels": [{"y": "48%","align": "center","size": 25,"bold": true,"text": olnyCircle_lastKey,"color": "#555"}], /*Pie안쪽의 Text*/
			};
			break;
	}

	if(zoomYN==="Y"){
		chartOption["chartScrollbar"]={"autoGridCount": true,"scrollbarHeight": 30};
	}

	//차트 그리기
	var chart = AmCharts.makeChart(chartID,chartOption);
	chart.addListener("dataUpdated", zoomChart(chart));
	//chart.addListener("clickGraphItem", chartClick ); //클릭 이벤트 발생
}


//=====================================================================
//amChart => Bar + Line
//=====================================================================
//Usage : var tt=drawBarLineChart("charDIV",chartData,"N","Y",12);
//=====================================================================
//chartID : 화면에 출력할 div tag의 ID값
//chartData : josn배열
//zoomYN : Zoom 출력 여부
//labelYN : Label 출력 여부
//fontSize : 차트의 출력되는 font size
//=====================================================================
function drawBarLineChart(chartID,chartData,zoomYN,labelYN,fontSize){

	if(chartData.length<=0){ return false; } //Data 갯수가 없으면 return false;

	//01-amChart의 graphs ==> JSON 형식으로
	var graphsJSON=new Array();
	var categoryField="";
	var graphsCnt=-1;

	var graphsColor=["#3366CC","#FF9900","#109618","#990099","#0099C6","#DD4477","#66AA00","#B82E2E","#316395","#994499","#22AA99","#AAAA11","#DC3912"];

	$.each(chartData[0], function(key,value){
		graphsCnt++;
		if(graphsCnt===0){
			categoryField=key;
		}
		else{
			var graphsObj={};
			graphsObj["title"]=key; 
			graphsObj["valueField"]=key;
			graphsObj["balloonText"]="<font style='font-size:" + fontSize + "px'><b>[[title]]</b><br>[[[value]]]</font>";	/*마우스 Over Label*/

			if(labelYN==="Y"){
				graphsObj["bullet"]="round";						/*꼭지점*/
				graphsObj["bulletSize"]=5;							/*차트 꼭지점 Size*/
				graphsObj["useLineColorForBulletBorder"]="true";	/*꼭지점*/
				graphsObj["labelText"]="[[value]]";					/*꼭지점에 값 출력(Label 출력)*/
			}

			switch(graphsCnt){
				case 1:		//첫번째 차트모양 결정
					graphsObj["type"]="column";						/*차트모양*/
					graphsObj["lineAlpha"]=0.2;
					graphsObj["fillAlphas"]=0.9;

					//라인칼라 정하기
					switch(chartID){
						case "todayWeightChart" : graphsObj["lineColor"]=graphsColor[0]; break;
						case "alldayWeightChart": graphsObj["lineColor"]=graphsColor[1]; break;
						case "todaySensorChart" : graphsObj["lineColor"]=graphsColor[0]; break;
						case "alldaySensorChart": graphsObj["lineColor"]=graphsColor[1]; break;
					}
					break;
				case 2:		//두번째 차트모양 결정
					graphsObj["type"]="smoothedLine";				/*차트모양*/
					graphsObj["lineColor"]=graphsColor[3];			/*라인컬라*/
					graphsObj["lineThickness"]=3;					/*라인굵기*/
					graphsObj["bulletBorderThickness"]=3;
					break;
			}
			graphsJSON.push(graphsObj);
		}
	});


	//차트옵션 정하기
	var chartOption=new Array();
	chartOption={"type": "serial","theme": "light","language":"ko","marginRight":20,"fontSize":fontSize,
				 "dataProvider": chartData,"categoryField":categoryField,"graphs": graphsJSON,
				 "chartCursor": {"cursorPosition": "mouse"},					  /*가이드라인*/
				 "legend":{"bulletType":"round","valueWidths":"false","useGraphSettings":true,"color":"black","align":"center"},  /*범례*/
	};
	if(zoomYN==="Y"){
		chartOption["chartScrollbar"]={"autoGridCount": true,"scrollbarHeight": 30};
	}

	//차트 그리기
	var chart = AmCharts.makeChart(chartID,chartOption);
	//chart.addListener("dataUpdated", zoomChart(chart));
}


function zoomChart(chart) {
	var len=chart.chartData.length;
    // different zoom methods can be used - zoomToIndexes, zoomToDates, zoomToCategoryValues
    chart.zoomToIndexes(len-90, len-1);
}



//카메라 구동
var cameraImg = new Image();
function cameraStart(cameraURL){
	cameraImg.src=cameraURL + "&date=" + (new Date()).getTime();
	cameraImg.onerror=function(){cameraError()};
	cameraImg.onload=function(){cameraUpdate(cameraURL)};
}
function cameraUpdate(cameraURL){
	cameraImg.src=cameraURL + "&date=" + (new Date()).getTime();
	$("#cameraDIV").attr("src",cameraImg.src);
}
function cameraError(){
	$("#cameraDIV").attr("src","../images/noimage.jpg");
	cameraClose();
}

/*
function cameraClose(){
	cameraImg.onload="";
	return false;
}
*/

//Excel 변환===================================================================
function excelConvert(tableTitle,tableID){
	var dateTime=getDateTime();

	var cloneTable=$("#" + tableID).bootstrapTable("getData","");
	var jsonData=JSON.stringify(cloneTable);

	var excelHeader=new Array();	//Execel Header
	$("#"+tableID).find("th").each(function(Key,Val){ 
		excelHeader.push( $.trim($(this).text()) );
	});
	
	window.Android.convertJavaExcel(dateTime + "_" + tableTitle + ".xls", excelHeader, jsonData);
}