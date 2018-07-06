var root_url = 'http://ichat.com';

$(document).ready(function(){

    //获取登录用户信息
    json_get(root_url + '/loginuser','',function(result){
        var data = result.data;
        $(".username").html(data.name);

    }, function(HttpRequest){
        var result =  jQuery.parseJSON(HttpRequest.responseText);
        if (result.statusCode == 1000){ //没有登录
            window.location.href = root_url + '/login';
        }
    },'',false);

   //退出登录
   $("#logout").click(function(){
       json_get(root_url + '/logout','',function(result){
            if (result.statusCode == 0){
                window.location.href = root_url + '/login';
            }
       });
   });

    //顶部菜单弹出
    $("#menu").click(function () {
        $(".hide_menu").toggle();
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
    if (!dataType){
        dataType = 'json';
    }
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