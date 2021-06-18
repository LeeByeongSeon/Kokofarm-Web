
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
                tree_html += "<li role='treeitem' style='cursor:pointer;'>\n";
                tree_html += "<span class='tree-content' style='padding: 7px; color: #455a64;' id='" + infos[0] + "' title='" + infos[1] + "'><i class='fa fa-lg fa-folder'></i>&nbsp";
                tree_html += infos[1] + "</span>\n";
                tree_html += "<ul class='tree-group' style='display:none;'>\n";

                // 동 버튼 생성
                for(var dong_key in data[farm_key]){
                    let [name, status] = data[farm_key][dong_key].split("|");

                    switch(in_out){
                        case "none":
                            status = "";
                            break;
                        case "all":
                            status = "&nbsp<span class='badge bg-" + (status == "입추" ? "blue" : "gray")  + " text-white'>" + status + "</span>";
                            break;
                    }

                    tree_html += "<li style='cursor:pointer;'> <span class='tree-content' id='" + dong_key + "' style='padding: 7px; color: #455a64;'>" + name + status + "</li>\n";
                }
                tree_html += "</ul>\n";
                tree_html += "</li>\n";
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
        click_tree_first(act_grid_data);
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
function popup_confirm(title, msg, work){
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


