
// 트리뷰 선택 농장 저장
var sel_tree_content = "";

// 트리뷰 호출
function call_tree_view(search){

    var tree_html = "";
    
    var data_map = {}; 
    data_map['oper'] = "get_tree";
    data_map['search'] = search;

    $.ajax({url:'../../common/php_module/common_action.php', data:data_map, cache:false, type:'post', dataType:'json',
        success: function(data) {

            tree_html += "<ul><li>\n";

            for(var key in data){       // {KF0006|농장명 : {"KF0006|01":동명}, ...}
                var infos = key.split("|");
                tree_html += "<span class='tree-content' id='" + infos[0] + "'><i class='fa fa-lg fa-folder-open'></i>";
                tree_html += infos[1] + "</span>\n";
                tree_html += "<ul>\n";

                for(var dong in data[key]){
                    tree_html += "<li> <span class='tree-content' id='" + dong + "'>" + data[key][dong] + "</li>\n";
                }

                tree_html += "</ul>\n";
            }

            tree_html += "</li></ul>\n";
        }
    });

	$("#tree-body").html(tree_html);
};

// 트리뷰 클릭 이벤트 세팅
function set_tree_action(work){
    $(".tree-content").off("click").on("click", function(){		// off로 이벤트 중복을 방지함
		sel_tree_content = $(this).attr('id');

        work(sel_tree_content);
	});
}