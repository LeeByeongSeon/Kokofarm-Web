
// 트리뷰 선택 농장 저장
var sel_tree_content = "";

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

// 트리뷰 호출
function call_tree_view(search, work){ 

    var tree_html = "";
    
    var data_map = {}; 
    data_map['oper'] = "get_tree";
    data_map['search'] = search;

    $.ajax({url:'../../common/php_module/common_action.php', data:data_map, cache:false, type:'post', dataType:'json',
        success: function(data) {

            tree_html += "<ul role='tree'>\n";

            for(var key in data){       // {KF0006|농장명 : {"KF0006|01":동명}, ...}

                var infos = key.split("|");
                //tree_html += "<li class='parent_li' role='treeitem'>\n";
                tree_html += "<li role='treeitem' style='cursor:pointer;'>\n";
                tree_html += "<span class='tree-content tree-parent' id='" + infos[0] + "' title='" + infos[1] + "'><i class='fa fa-lg fa-folder'></i>&nbsp";
                tree_html += infos[1] + "</span>\n";
                tree_html += "<ul class='tree-group' style='display:none;'>\n";

                for(var dong in data[key]){
                    tree_html += "<li style='cursor:pointer;'> <span class='tree-content' id='" + dong + "'>" + data[key][dong] + "</li>\n";
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

// 트리뷰 클릭 이벤트 세팅
function set_tree_action(work){

    // 가장 첫 농장을 연다
    $(".tree-parent").first().parent("li").children("ul.tree-group").toggle();
    $(".tree-parent").first().children("i").toggleClass("fa-folder-open").toggleClass("fa-folder");

    sel_tree_content = $(".tree-content").first().attr('id');
    work(sel_tree_content);

    $(".tree-content").off("click").on("click", function(){		// 클릭 이벤트 
		sel_tree_content = $(this).attr('id');
        work(sel_tree_content);
	});

    $(".tree-content").off("mouseenter").on("mouseenter", function(){		// 마우스 오버
        $(this).css("background-color", "#FF8505").css("border", "1px solid #C67605").css("color", "#FFFFFF");
    });

    $(".tree-content").off("mouseleave").on("mouseleave", function(){		// 마우스 리브
		$(this).css("background-color", "#FFFFFF").css("border", "1px solid #000000").css("color", "#000000");
	});

    $(".tree-parent").off("click").on("click", function(){		// 농장 버튼 선택 이벤트 - 아이콘 변경 및 동 버튼 hide
        $(this).parent("li").children("ul.tree-group").toggle();
        $(this).children("i").toggleClass("fa-folder-open").toggleClass("fa-folder");
	});

}


