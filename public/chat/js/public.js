var root_url = '',t_avatar='',t_user_id='0',error_head = '/chat/img/user.png';//未读取正确头像;


$(document).ready(function(){
    $(".username").text('消息');
   //退出登录
   $("#logout").click(function(){
       json_get(root_url + '/logout','',function(result){
            if (result.statusCode == 0){
                window.location.href = 'land.html';
            }
       },function(){}, false, false, 'json');
   });

    //顶部菜单弹出
    $("#menu").on('click', function (e) {
        //顶部右上菜单
        e.stopPropagation();
    });
    /*顶部右上角菜单*/
    $("#menu").click(function () {
        $(".click_hide").hide();
        $('#menu_hide').toggle();
    });
    $(document).on('click', function () {
        if ($("#set_hide").css('display') == 'block') {
            $("#set_hide").hide();
        }
        if ($("#menu_hide").css('display') == 'block') {
            $("#menu_hide").hide();
        }
        if ($("#searchBox2").css('display') == 'block') {
            $("#searchBox2").hide();
        }
        
        
    });
        //左下角设置
    $('#set_btn').click(function () {
        $(".click_hide").hide();
        $(this).find("#set_hide").toggle();
    });
    $(".menu_li ").on('click', function (e) {
        e.stopPropagation();
    });


    //左边菜单切换
    $('#menu_messages').click(function(){
        $(document).attr("title","聊天室-消息");
        $(".username").text('消息');
        $('#chat_top .chart_r .head_img').empty();
        $(".click_hide").hide();
        $(".menus_top .menu_li").removeClass('menu_sel');
        $(this).addClass('menu_sel');
        $("#message_box").show();
        $("#group_box").hide();
        $("#team_box").hide();
        $("#file_box").hide();
        $(".file_lists").hide();
        $("#chat_message_box").show();
        $(".info_right").hide();

    });
    $('#menu_groups').click(function(){
        $(document).attr("title","聊天室-群聊");
        $(".username").text('群聊');

        $('#chat_top .chart_r .head_img').empty();
        get_grouplist();

        $(".click_hide").hide();
        $(".menus_top .menu_li").removeClass('menu_sel');
        $(this).addClass('menu_sel');
        $("#message_box").hide();
        $("#group_box").show();
        $("#team_box").hide();
        $("#file_box").hide();
        $(".file_lists").hide();
        $("#chat_message_box").show();
        $(".info_right").hide();
        $('.send').css('display','none');
        $("#chat_message_box .conversation").empty();
    });
    $('#menu_teams').click(function(){
        $(document).attr("title","聊天室-分组");
        $(".username").text('分组');
        $('#chat_top .chart_r .head_img').empty();
        $(".click_hide").hide();
        $(".menus_top .menu_li").removeClass('menu_sel');
        $(this).addClass('menu_sel');
        $("#message_box").hide();
        $("#group_box").hide();
        $("#file_box").hide();
        $("#chat_message_box").hide();
        $(".file_lists").hide();
        $("#team_box").show();
        $(".info_right").show();
        fz_getOnline();
    });
    $('#menu_files').click(function(){
        $(document).attr("title","聊天室-文件");
        $('#chat_top .chart_r .head_img').empty();
        $(".username").text('文件');
        $(".click_hide").hide();
        $(".menus_top .menu_li").removeClass('menu_sel');
        $(this).addClass('menu_sel');
        $("#message_box").hide();
        $("#group_box").hide();
        $("#team_box").hide();
        $("#file_box").show();
        $(".file_lists").show();
        $("#chat_message_box").hide();
        $(".info_right").hide();
        //初始化加载文件列表
        var completeload =  $("#menu_files ").attr('init')
        if(completeload>0){return false;}
        else{
            postFilelist('');
        }

    });

});


function json_post(url, data, callback_function, callback_error, async, cache){

    $.ajax({
        url: url,
        type: "POST",
        processData: true,
        cache:cache,
        async: async,
        data: data,
        dataType: 'json',
        success: callback_function,
        error: callback_error
    });

}

function json_get(url, data, callback_function, callback_error, async, cache, dataType){

    $.ajax({
        url: url,
        type: "GET",
        processData: true,
        cache:cache,
        async: async,
        data: data,
        dataType: dataType,
        success: callback_function,
        error: callback_error
    });
}

//错误统一判断
function http_request_error(HttpRequest){
    // console.log(HttpRequest);
    var result =  jQuery.parseJSON(HttpRequest.responseText);

    if (result.statusCode == 1000){ //没有登录
        window.location.href = 'land.html';
    }else{
        layer.closeAll();
        layer.alert(result.message);
    }
}

function replace_html(data){
    var content = "";
    content = data.replace(/<img(.*?)>/g, "[图片]");
    content = content.replace(/<div(.*?)>/g, "");
    content = content.replace(/<\/div(.*?)>/g, "");
    content = content.replace(/<br(.*?)>/g, "");
    content = content.replace(/<span(.*?)>/g, "");
    content = content.replace(/<\/span(.*?)>/g, "");
    content = content.replace(/<p(.*?)>/g, "");
    content = content.replace(/<\/p(.*?)>/g, "");
    content = content.replace(/<h(.*?)>/g, "");
    content = content.replace(/<\/h(.*?)>/g, "");
    content = content.replace(/<a(.*?)>/g, "");
    content = content.replace(/<\/a(.*?)>/g, "");
    content = content.replace(/<em(.*?)>/g, "");
    content = content.replace(/<\/em(.*?)>/g, "");
    content = content.replace(/<table(.*?)\/table>/g, "");
    content = content.replace(/<script(.*?)\/script>/g, "");
    return content;
}










