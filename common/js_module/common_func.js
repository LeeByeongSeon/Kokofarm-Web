
// 트리뷰 선택 농장 저장
var selected_id = "";

// jqgrid resize
$(document).ready(function(){
	$(".jqgrid_zone").bind("resize", function(){
		$(".jqgrid_table").setGridWidth($(".jqgrid_zone").width());
		$(".jqgrid_slave_table").setGridWidth($(".jqgrid_slave_zone").width());
	});

	$(".jqgrid_slave_zone").bind("resize", function(){
		$(".jqgrid_table").setGridWidth($(".jqgrid_zone").width());
		$(".jqgrid_slave_table").setGridWidth($(".jqgrid_slave_zone").width());
	});
});

/* 트리뷰 호출
param
- search : 농장 검색 입력 string
- work : 농장 버튼 클릭 시 실행할 함수
*/
function call_tree_view(search, work){ 

    var tree_html = "";
    
    var data_map = {}; 
    data_map['oper'] = "get_tree";
    data_map['search'] = search;

    $.ajax({url:'../../common/php_module/common_action.php', data:data_map, cache:false, type:'post', dataType:'json',
        success: function(data) {

            tree_html += "<ul role='tree'>\n";

            for(var farm_key in data){       // {KF0006|농장명 : {"KF0006|01":동명}, ...}

                var infos = farm_key.split("|");
                //tree_html += "<li class='parent_li' role='treeitem'>\n";
                tree_html += "<li role='treeitem' style='cursor:pointer;'>\n";
                tree_html += "<span class='tree-content' style='padding: 7px; color: #455a64;' id='" + infos[0] + "' title='" + infos[1] + "'><i class='fa fa-lg fa-folder'></i>&nbsp";
                tree_html += infos[1] + "</span>\n";
                tree_html += "<ul class='tree-group' style='display:none;'>\n";

                for(var dong_key in data[farm_key]){
                    tree_html += "<li style='cursor:pointer;'> <span class='tree-content' style='padding: 7px; color: #455a64;' id='" + dong_key + "'>" + data[farm_key][dong_key] + "</li>\n";
                }
                tree_html += "</ul>\n";
                tree_html += "</li>\n";
            }

            tree_html += "</ul>\n";

            $("#tree-body").html(tree_html);

            set_tree_action(work);
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
function set_tree_action(work){

    // 가장 첫 농장을 연다
    $(".tree-content").first().parent("li").children("ul.tree-group").toggle();
    $(".tree-content").first().children("i").toggleClass("fa-folder-open").toggleClass("fa-folder");

    selected_id = $(".tree-content").first().attr('id');
    work(selected_id);

    $(".tree-content").off("click").on("click", function(){		// 클릭 이벤트 

        selected_id = $(this).attr('id');
        var keys = selected_id.split("|");

        if(keys.length == 1){
            $(this).parent("li").children("ul.tree-group").toggle();
            $(this).children("i").toggleClass("fa-folder-open").toggleClass("fa-folder");
        }

        work(selected_id);
	});

    $(".tree-content").off("mouseenter").on("mouseenter", function(){		// 마우스 오버
        $(this).css("background-color", "#568a89").css("border", " 1px dotted #568a89").css("color", "#FFFFFF");
    });

    $(".tree-content").off("mouseleave").on("mouseleave", function(){		// 마우스 리브
		$(this).css("background-color", "#FFFFFF").css("border", "1px dotted #455a64").css("color", "#455a64");
	});

};

/* 트리뷰 검색 이벤트 세팅
param
- work : 농장 버튼 클릭 시 실행할 함수
*/
function set_tree_search(work){
    $("#btn_tree_search").off("click").on("click", function(){
        var search_text = $("#form_tree_search [name=text_tree_search]").val();

        call_tree_view(search_text, work);
    });
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



