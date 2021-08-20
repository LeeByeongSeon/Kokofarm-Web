
// 트리뷰 선택 농장 저장
var selected_id = "";
var hide_dong = false;

// css 속성 정의
const color_over = "#FFFFFF";
const color_leave = "#455a64";
const color_select = "#FFFFFF";

const background_over = "#568a89";
const background_leave = "#FFFFFF";
const background_select = "#455a64";

const border_over = "1px dotted #568a89";
const border_leave = "1px dotted #455a64";
const border_select = "1px dotted #568a89";

// jqgrid resize
$(document).ready(function(){
	$(".jqgrid_zone").bind("resize", function(){
		$(".jqgrid_table").setGridWidth($(".jqgrid_zone").width());
		$(".jqgrid_slave_table").setGridWidth($(".jqgrid_slave_zone").width());
        $(".jqgrid_sub_table").setGridWidth($(".jqgrid_sub_zone").width());
	});

	$(".jqgrid_slave_zone").bind("resize", function(){
		$(".jqgrid_table").setGridWidth($(".jqgrid_zone").width());
		$(".jqgrid_slave_table").setGridWidth($(".jqgrid_slave_zone").width());
        $(".jqgrid_sub_table").setGridWidth($(".jqgrid_sub_zone").width());
	});

    $(".jqgrid_sub_zone").bind("resize", function(){
		$(".jqgrid_table").setGridWidth($(".jqgrid_zone").width());
		$(".jqgrid_slave_table").setGridWidth($(".jqgrid_slave_zone").width());
        $(".jqgrid_sub_table").setGridWidth($(".jqgrid_sub_zone").width());
	});
});

/* 트리뷰 호출
param
- search : 농장 검색 입력 string
- work : 농장 버튼 클릭 시 실행할 함수
*/
function call_tree_view(search, work, in_out = "none"){ 

    $("#treeView").show();

    var tree_html = "";
    
    var data_map = {}; 
    data_map['oper'] = "get_tree";
    data_map['search'] = search;

    $.ajax({url:'../../common/php_module/common_action.php', data:data_map, cache:false, type:'post', dataType:'json',
        success: function(data) {

            tree_html += "<ul role='tree'>\n";

            // 농장버튼 생성
            for(var farm_key in data){       // {KF0006|농장명 : {"KF0006|01":동명}, ...}
                var infos = farm_key.split("|");

                let head = "";
                let tail = "";

                head += "<li role='treeitem' style='cursor:pointer;'>\n";
                head += "<span class='tree-content' style='padding: 7px; color: #455a64;' id='" + infos[0] + "' title='" + infos[1] + "'><i class='fa fa-lg fa-folder'></i>&nbsp";
                head += infos[1];

                tail += "</span>\n";
                tail += "<ul class='tree-group' style='display:none;'>\n";

                let cnt_in = 0;         //입추 수
                let cnt_out = 0;        //출하 수

                // 동 버튼 생성
                for(var dong_key in data[farm_key]){
                    let [name, status, cmCode, cmIndate, cmOutdate, cmIntype] = data[farm_key][dong_key].split("|");

                    status == "입추" ? cnt_in++ : cnt_out++;

                    switch(in_out){
                        case "none":
                            status = "";
                            break;
                        case "all":
                            status = "&nbsp<span class='badge bg-" + (status == "입추" ? "blue" : "gray")  + " text-white'>" + status + "</span>";
                            break;
                        case "in":
                            status = status == "입추" ? "&nbsp<span class='badge bg-blue text-white'>입추</span>" : "pass";
                            break;
                        case "out":
                            status = status == "출하" ? "&nbsp<span class='badge bg-gray text-white'>출하</span>" : "pass";
                            break;
                    }

                    // pass 이면 출력 안함
                    if(status == "pass") {continue;}

                    tail += "<li style='cursor:pointer;'> <span class='tree-content' id='" + dong_key + "' ";
                    tail += "style='padding: 7px; color: #455a64;' cmCode='" + cmCode + "', cmIndate='" + cmIndate + "', cmOutdate='" + cmOutdate + "', cmIntype='" + cmIntype + "'>" + name + status + "</li>\n";
                }
                tail += "</ul>\n";
                tail += "</li>\n";

                if(in_out == "in" && cnt_in == 0) {continue;};          //입추 농가없으면 출력 x
                if(in_out == "out" && cnt_out == 0) {continue;};        //출하 농가없으면 출력 x

                head += cnt_in > 0 ? "&nbsp<span class='badge bg-blue text-white'>" + cnt_in + "</span>" : "";
                head += cnt_out > 0 ? "&nbsp<span class='badge bg-gray text-white'>" + cnt_out + "</span>" : "";

                tree_html += head + tail;

            }

            tree_html += "</ul>\n";

            $("#tree-body").html(tree_html);

            set_tree_action(search, work);
        },
        error: function(){
            $("#tree-body").html("");
        }
    });
};

/* 트리뷰 클릭 이벤트 세팅
param
- work : 농장 버튼 클릭 시 실행할 함수
*/
function set_tree_action(search, work){

    if(search != ""){
        // 가장 첫 농장을 연다
        click_tree_first(work);
    }
    else{
        selected_id = "";
        work(selected_id);
    }

    $(".tree-content").off("click").on("click", function(){		// 클릭 이벤트 

        let prev_id = selected_id;
        selected_id = $(this).attr('id');

        var keys = selected_id.split("|");
        if(keys.length == 1 && !hide_dong){
            $(this).parent("li").children("ul.tree-group").toggle(400);
            $(this).children("i").toggleClass("fa-folder-open").toggleClass("fa-folder");
        }

        work(selected_id);

        set_selected_highlight(prev_id, selected_id);
	});

    $(".tree-content").off("mouseenter").on("mouseenter", function(){		// 마우스 오버
        let is_selected = $(this).attr("is_selected");
        if(!is_selected){
            $(this).css("background-color", background_over).css("border", border_over).css("color", color_over);
        }
    });

    $(".tree-content").off("mouseleave").on("mouseleave", function(){		// 마우스 리브
        let is_selected = $(this).attr("is_selected");
        if(!is_selected){
            $(this).css("background-color", background_leave).css("border", border_leave).css("color", color_leave);
        }
	});

};

/* 트리뷰 첫번째 아이템 강제 선택 함수
param
- work : 실행할 함수
*/
function click_tree_first(work){

    if(!hide_dong){
        $(".tree-content").first().parent("li").children("ul.tree-group").toggle(400);
        $(".tree-content").first().children("i").toggleClass("fa-folder-open").toggleClass("fa-folder");
    }

    selected_id = $(".tree-content").first().attr('id');
    set_selected_highlight("", selected_id);

    work(selected_id);
};

/* 트리뷰 특정 id 아이템 강제 선택 함수
param
- work : 실행할 함수
- pk : 선택할 농장 pk
*/
function click_tree_by_id(work, pk){

    let token = pk.split("|");
    let farmID = token[0];
    //let dongID = token.length > 1 ? token[1] : "01";

    if(!hide_dong){
        $("#" + farmID).parent("li").children("ul.tree-group").toggle(400);
        $("#" + farmID).children("i").toggleClass("fa-folder-open").toggleClass("fa-folder");
    }

    selected_id = pk;
    set_selected_highlight("", selected_id);

    work(selected_id);
}


/* 트리뷰 검색 이벤트 세팅
param
- work : 농장 버튼 클릭 시 실행할 함수
*/
function set_tree_search(work, in_out = "none"){
    $("#btn_tree_search").off("click").on("click", function(){
        var search_text = $("#form_tree_search [name=text_tree_search]").val();
        call_tree_view(search_text, work, in_out);
    });

    $("#form_tree_search [name=text_tree_search]").keyup(function(e){
        if(e.keyCode == 13){
            var search_text = $(this).val();
            call_tree_view(search_text, work, in_out);
        }
    });
};

/* 트리뷰 선택 시 하이라이트 처리
param
- prev : 이전 선택된 버튼의 id
- curr : 현재 선택된 버튼의 id
*/
function set_selected_highlight(prev, curr){
    if(prev != curr){
        prev = prev.replace("|", "\\|");
        curr = curr.replace("|", "\\|");

        // 이전 선택 지우기
        if(prev != ""){
            $("#" + prev).removeAttr("is_selected");
            $("#" + prev).css("background-color", background_leave).css("border", border_leave).css("color", color_leave);
        }

        // 현재 선택
        $("#" + curr).attr("is_selected", true);
        $("#" + curr).css("background-color", background_select).css("border", border_select).css("color", color_select);
    }

    $("html, body").animate({scrollTop :0}, 0); //상단으로 포커싱함
};

/* 모달 팝업 - 기본형
param
- title : 모달 상단 제목 string
- msg : 모달에 표시될 내용
*/
function popup_alert(title, msg){
	$("#modal_alert_title").html(title);					//modal title
	$("#modal_alert_body").html("<p>" + msg + "</p>");		//modal 내용
	$("#modal_alert").modal('show');					//modal open
};

/* 모달 팝업 - 확인
param
- title : 모달 상단 제목 string
- msg : 모달에 표시될 내용
- wokr : 확인/취소 버튼 클릭 시 실행될 함수
*/
function popup_confirm(title, msg, work, ok_msg = "확인", cancle_msg = "취소"){

    $("#modal_confirm_ok").html(ok_msg);					//modal title
    $("#modal_confirm_cancle").html(cancle_msg);					//modal title

	$("#modal_confirm_title").html(title);					//modal title
	$("#modal_confirm_body").html("<p>" + msg + "</p>");		//modal 내용
	$("#modal_confirm").modal('show');						//modal open

	confirm_event(work);
};

// 확인 및 취소 버튼 클릭 시 실행 할 작업을 바인딩 함
var confirm_event = function (work){
	$("#modal_confirm_ok").off("click").on("click", function(){		// off로 이벤트 중복을 방지함
		work(true);
		$("#modal_confirm").modal('hide');
	});
	
	$("#modal_confirm_cancle").off("click").on("click", function(){
		work(false);
		$("#modal_confirm").modal('hide');
	});
};

// 날짜 유효성 검사
function date_valid_check(input){
    let [date_arr, time_arr] = input.split(" ");

    if(time_arr == null) {return [false, "입력된 값이 (yyyy-MM-dd hh:mm:ss) 형식에 맞지 않습니다."];}

    date_arr = date_arr.split("-");
    time_arr = time_arr.split(":");

    if(date_arr.length != 3) {return [false, "입력된 값이 (yyyy-MM-dd hh:mm:ss) 형식에 맞지 않습니다."];}
    if(time_arr.length != 3) {return [false, "입력된 값이 (yyyy-MM-dd hh:mm:ss) 형식에 맞지 않습니다."];}

    if(date_arr[0].length != 4) {return [false, "입력된 연도가 (yyyy-MM-dd) 형식에 맞지 않습니다."];}
    if(date_arr[1].length != 2) {return [false, "입력된 월이 (yyyy-MM-dd) 형식에 맞지 않습니다."];}
    if(date_arr[2].length != 2) {return [false, "입력된 일이 (yyyy-MM-dd) 형식에 맞지 않습니다."];}

    if(time_arr[0].length != 2) {return [false, "입력된 시간이 (hh:mm:ss) 형식에 맞지 않습니다."];}
    if(time_arr[1].length != 2) {return [false, "입력된 분이 (hh:mm:ss) 형식에 맞지 않습니다."];}
    if(time_arr[2].length != 2) {return [false, "입력된 초가 (hh:mm:ss) 형식에 맞지 않습니다."];}

    if(date_arr[1] < 1 || date_arr[1] > 12) {return [false, "입력된 달이 유효하지 않습니다."];}

    // 숫자형으로 파싱
    date_arr = date_arr.map((val) => Number(val));
    time_arr = time_arr.map((val) => Number(val));

    let day_max = 0;
    day_max = [1,3,5,7,8,10,12].includes(date_arr[1]) ? 31 : 28;        // 31일인 달이 아니면
    day_max = [4,6,9,11].includes(date_arr[1]) ? 30 : day_max;               // 30일인 달이 아니면
    // 윤년계산
    if(date_arr[1] == 2 && date_arr[0] % 4 == 0){
        day_max = (date_arr[0] % 100 == 0) && (date_arr[0] % 400 != 0) ? 28 : 29;
    }

    if(date_arr[2] < 1 || date_arr[2] > day_max) {return [false, "입력된 일이 유효하지 않습니다."];}

    if(time_arr[0] < 0 || time_arr[0] > 23) {return [false, "입력된 시간이 유효하지 않습니다."];}
    if(time_arr[1] < 0 || time_arr[1] > 59) {return [false, "입력된 분이 유효하지 않습니다."];}
    if(time_arr[2] < 0 || time_arr[2] > 59) {return [false, "입력된 초가 유효하지 않습니다."];}

    return [true, "완료"];
    
};

// 날짜 형식 강제 입력 함수
function force_input_date(input){
    let len = input.length;	

    let iter = [-1, 4, 7, 10, 13, 16, 19];
    let limit = [0, 3000, 12, 31, 24, 60, 60];
    let spliter = ["-", "-", " ", ":", ":", ""];

    input = len > 19 ? input.slice(0, 19) : input;

    // 연월일시분초 검사
    for(i=1; i<iter.length; i++){
        if(len >= iter[i]){
            
            let check = input.slice(iter[i-1] + 1, iter[i])
            if(!isNaN(check) && check <= limit[i]){
                input = len == iter[i-1] ? input + spliter[i-1] : input;
            }
            else{
                let ret_val = input.slice(0, iter[i-1]) + (i >= 2 ? spliter[i-2] : "");
                return ret_val;
            }
        }

        if(len == iter[i]){				// 길이가 4면 '-'를 붙임 - 그 이후는 시간형식에 따라 반복됨 
            input = input + spliter[i-1];
        }
        else if(len > iter[i] + 1){		// 길이가 6이상 일때 index 4가 '-' 가 아니면 강제 변환
            if(input.charAt(iter[i]) != spliter[i-1]) { 
                input = input.slice(0, iter[i-1]) + spliter[i-1];
            }
        }
    }

    return input;
}

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

// gap 만큼 더하거나 뺀 시간을 리턴
function get_gap_time(origin, gap){
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

// 월 일 시간 형태로 변경
function get_korea_date(time){
    var ret = time.substr(5, 2) + "월 " + time.substr(8, 2) + "일 " + time.substr(11, 5);
    return ret;
}

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

// 로딩 ui 띄우기
function show_loading(stat){
	let window_obj = $(window);
	let obj_top = 0;
	let obj_left = 0;

	let obj_width = window_obj.width();
	let obj_height = window_obj.height();

	$("#loading_circle").css({
		'top':obj_top,'left':obj_left,'width':obj_width,'height':obj_height,'position':'fixed','z-index':'9999','background':'gray',opacity:0.5
	});

    //loading_img css
    let img_post = 'relative';          //position
	let img_left = (obj_width-340)/2;   //left
	let img_top = (obj_height-252)/2;   //top

	$("#loading_img").css({
		'position':img_post,'left':img_left,'top':img_top
	});
		
	switch(stat){
		case "show":
			$("#loading_circle").fadeIn();
			break;
		case "hide":
			$("#loading_circle").fadeOut();
			break;
	}
};


// am chart 관련---------------------------------------------------------------------
/* 차트 형태 별 그래프 데이터 리턴
param
- chart_id : 화면에 출력할 div tag의 ID값
- chart_data : josn배열
- chart_style : 차트모양
- is_zoom : Zoom 출력 여부
- is_label : Label 출력 여부
- font_size : 차트의 출력되는 font size
*/
function draw_select_chart(chart_id, chart_data, chart_style, is_zoom, is_label, font_size, period = "hh"){
    if(chart_data.length <= 0){ return false; }

    let graph_json = [];
    let category = "";
    let graph_cnt = -1;
    let graph_color = ["#3366CC","#FF9900","#109618","#990099","#0099C6","#DD4477","#66AA00","#B82E2E","#316395","#994499","#22AA99","#AAAA11","#DC3912"];
    let circle_lastkey = "";

    for(key in chart_data[0]){
        graph_cnt++;
        if(graph_cnt == 0) { 
            category = key; 
        }
        else{
            var graph_obj = {};
            graph_obj["title"] = key; 
			graph_obj["valueField"] = key;
			graph_obj["balloonText"] = "<font style='font-size:" + font_size + "px'><b>[[title]]</b><br>[[[value]]]</font>";	/*마우스 Over Label*/
			graph_obj["bullet"] = "round";						/*꼭지점*/
			graph_obj["bulletSize"] = 4;							/*차트 꼭지점 Size*/
			graph_obj["useLineColorForBulletBorder"] = "true";	/*꼭지점*/

            if(is_label === "Y"){
				graph_obj["labelText"]="[[value]]";					/*값 출력*/
			}

			switch(chart_style){
				case "라인차트":
					graph_obj["type"] = "smoothedLine";					/*차트모양*/
					graph_obj["lineThickness"] = 1;						/*라인굵기*/
					break;
				case "영역차트":
					graph_obj["type"] = "smoothedLine";					/*smoothedLine*/
					graph_obj["lineThickness"] = 1;						/*라인굵기*/
					graph_obj["fillAlphas"] = 0.2;
					break;
				default:
					graph_obj["type"] = "column";							/*차트모양*/
					graph_obj["lineAlpha"] = 0.2;
					graph_obj["fillAlphas"] = 0.9;

					break;
			}
			graph_json.push(graph_obj);
        }

        circle_lastkey = key;
    }

    //차트옵션 정하기
	let chart_option = {"type": "serial", "theme": "light", "language":"ko", "marginRight":20, "fontSize":font_size,
                        "dataProvider": chart_data, "categoryField":category, "graphs": graph_json,
                        "chartCursor": {"categoryBalloonDateFormat": "YYYY-MM-DD HH:NN", "cursorPosition": "mouse"},					  /*가이드라인*/
                        "legend":{"bulletType":"round", "valueWidths":"false", "useGraphSettings":true, "color":"black", "align":"center"},  /*범례*/
                        "categoryAxis":{ "minPeriod": period, "parseDates": true, "gridPosition" : "start" , "gridAlpha" : 0} /*가로눈금==>매우중요*/
	};

    switch(chart_style){
		case "가로-Bar":
			chart_option["rotate"] = true;
			break;
		case "세로-Bar":
			chart_option["rotate"] = false;
			break;
		case "가로-누적":
			chart_option["rotate"] = true;
			chart_option["valueAxes"] = [{"stackType": "regular", "axisAlpha": 0.5, "gridAlpha": 0}]; /*누적형식(regular:일반,100%:100%누적)*/
			break;
		case "세로-누적":
			chart_option["rotate"] = false;
			chart_option["valueAxes"] = [{"stackType": "regular", "axisAlpha": 0.5, "gridAlpha": 0}]; /*누적형식(regular:일반,100%:100%누적)*/
			break;
		case "원형차트":
			chart_option = {};
			chart_option = {
				"type":"pie", "theme":"light", "startDuration":0.1, "fontSize":font_size,
				"dataProvider": chart_data, "valueField": circle_lastkey, "titleField": category,
				"outlineAlpha": 0.4,
				"innerRadius": 80,	 /*내부 Holl*/
				"pullOutRadius": 50, /*Pie 크기조정==>숫자가 작을수록 Pie는 커짐*/
				"legend":{"bulletType":"round", "position":"right", "align":"center", "valueWidth":0}, /*범례*/
				"depth3D": 10,		 /*3D효과 각도조절*/
				"balloonText": "<font style='font-size:14px'><b>[[title]]</b><br>[[value]] ([[percents]]%)</font>",
				"allLabels": [{"y": "48%", "align": "center", "size": 25, "bold": true, "text": circle_lastkey, "color": "#555"}], /*Pie안쪽의 Text*/
			};
			break;
	}

	if(is_zoom === "Y"){
		chart_option["chartScrollbar"] = {"autoGridCount": true, "scrollbarHeight": 30};
	}

    //차트 그리기
	let chart = AmCharts.makeChart(chart_id, chart_option);
	chart.addListener("dataUpdated", zoom_chart(chart));
};

// am chart 관련---------------------------------------------------------------------
/* 막대모양 차트 그리기
param
- chart_id : 화면에 출력할 div tag의 ID값
- chart_data : josn배열
- is_zoom : Zoom 출력 여부
- is_label : Label 출력 여부
- font_size : 차트의 출력되는 font size
*/
function draw_bar_line_chart(chart_id, chart_data, is_zoom, is_label, font_size, period = "hh"){
    if(chart_data.length <= 0){ return false; }

    //console.log(JSON.stringify(chart_data));

    let graph_json = [];
    let category = "";
    let graph_cnt = -1;
    let graph_color = ["#3366CC","#FF9900","#109618","#990099","#0099C6","#DD4477","#66AA00","#B82E2E","#316395","#994499","#22AA99","#AAAA11","#DC3912"];

    for(key in chart_data[0]){
        graph_cnt++;
        if(graph_cnt == 0) { 
            category = key; 
        }
        else{
            var graph_obj = {};
            graph_obj["title"] = key; 
			graph_obj["valueField"] = key;
			graph_obj["balloonText"] = "<font style='font-size:" + font_size + "px'><b>[[title]]</b><br>[[[value]]]</font>";	/*마우스 Over Label*/

            if(is_label === "Y"){
				graph_obj["labelText"]="[[value]]";					/*값 출력*/
                graph_obj["bullet"] = "round";						/*꼭지점*/
                graph_obj["bulletSize"] = 4;							/*차트 꼭지점 Size*/
                graph_obj["useLineColorForBulletBorder"] = "true";	/*꼭지점*/
			}

			switch(graph_cnt){
				case 1:
					graph_obj["type"] = "column";						/*차트모양*/
					graph_obj["lineColor"] = graph_color[1];			/*라인컬라*/
					graph_obj["lineAlpha"] = 0.2;
					graph_obj["fillAlphas"] = 0.9;
					break;
				case 2:
					//graph_obj["type"] = "smoothedLine";				/*차트모양*/
                    graph_obj["type"] = "column";				/*차트모양*/
					graph_obj["lineColor"] = graph_color[3];			/*라인컬라*/
					graph_obj["lineThickness"] = 3;					/*라인굵기*/
					graph_obj["bulletBorderThickness"] = 3;
					break;
			}
			graph_json.push(graph_obj);
        }
    }

    //차트옵션 정하기
	let chart_option = {"type": "serial", "theme": "light", "language":"ko", "marginRight":20, "fontSize":font_size,
                        "dataProvider": chart_data, "categoryField":category, "graphs": graph_json,
                        "chartCursor": {"categoryBalloonDateFormat": "YYYY-MM-DD HH:NN", "cursorPosition": "mouse"},					  /*가이드라인*/
                        "legend":{"bulletType":"round", "valueWidths":"false", "useGraphSettings":true, "color":"black", "align":"center"},  /*범례*/
                        "categoryAxis":{ "minPeriod": period, "parseDates": true, "gridPosition" : "start" , "gridAlpha" : 0} /*가로눈금==>매우중요*/
	};

	if(is_zoom === "Y"){
		chart_option["chartScrollbar"] = {"autoGridCount": true, "scrollbarHeight": 30};
	}

    //차트 그리기
	let chart = AmCharts.makeChart(chart_id, chart_option);
	//chart.addListener("dataUpdated", zoom_chart(chart));
};

function zoom_chart(chart) {

    try {
        //console.log(chart.chartData);
        let len = chart.chartData.length;
        // different zoom methods can be used - zoomToIndexes, zoomToDates, zoomToCategoryValues
        chart.zoomToIndexes(len-90, len-1);
    } catch (error) {
        
    }
};

var open_window;
var open_url = "";

// 카메라 선택 시 팝업창 띄움
function camera_popup(name, img_url){

    let pop_width = 1024;
    let pop_height = 800;

    let pop_left = Math.ceil(( window.screen.width - pop_width ) / 2);
    let pop_top = Math.ceil(( window.screen.height - pop_height ) / 2);

    let options = "width=" + pop_width + ", height=" + pop_height + ", left=" + pop_left + ", top=" + pop_top

    open_url = img_url;
    open_window = window.open("camera_popup.php?title=" + name, "camera_popup", options);
};

// 카메라 이미지 불러오기 팝업창에서 실행
function camera_load(img_obj){
    // 팝업창 닫히면 
    open_window.onbeforeunload = function(){
        img_obj.onload = function(){"";};
        img_obj.setAttribute("src", "");
    };   

    // 이미지가 로드되면
    img_obj.onload = function(){
        img_obj.setAttribute("src", open_url + "&date=" + (new Date()).getTime());
    };

    // 이미지 로드 중 에러 발생시
    img_obj.onerror = function(){
        img_obj.setAttribute("src", "../images/noimage.jpg");
        img_obj.onload = function(){"";};
    };

    // 첫 이미지 로드
    img_obj.setAttribute("src", open_url + "&date=" + (new Date()).getTime());
};

function camera_close(img_obj){
    img_obj.setAttribute("src", "../images/noimage.jpg");
    img_obj.onload = function(){"";};

    open_window.close();
};

// 엑셀파일 다운로드
function table_to_excel(title, html){
    let data_type = "data:application/vnd.ms-excel";
    let ua = window.navigator.userAgent;
    let is_ie = ua.indexOf("MSIE");
    let file_name = title;

    if (is_ie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./)) {
        if (window.navigator.msSaveBlob) {
            let blob = new Blob([html], {
                type: "application/csv;charset=utf-8;"
            });
            navigator.msSaveBlob(blob, file_name);
        }

    } else {
        let blob = new Blob([html], {
            type: "application/csv;charset=utf-8;"
        });
        let elem = window.document.createElement('a');
        elem.href = window.URL.createObjectURL(blob);
        elem.download = file_name;
        document.body.appendChild(elem);
        elem.click();
        document.body.removeChild(elem);
    }
};

// 엑셀 데이터 안드로이드 전송
function send_excel_android(title, table_id){
	let date_time = get_now_datetime();

	let clone = $("#" + table_id).bootstrapTable("getData", "");
	let json_data = JSON.stringify(clone);

	let header = new Array();	//Execel Header
	$("#" + table_id).find("th").each(function(key, val){ 
		header.push( $.trim($(this).text()) );
	});
	
	window.Android.convert_excel(date_time + "_" + title + ".xls", header, json_data);
}