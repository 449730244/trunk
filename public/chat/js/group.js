$(document).ready(function(){

    //加载群列表
    json_get(root_url+'/userGroups', '', function(result){

        //$("#my_group").html(html);
        var data = result.data;
        $(data).each(function(i, item){
            layui.use('laytpl', function(){
                var laytpl = layui.laytpl;
                var getTpl = $("#tpl_group_list").html();

                laytpl(getTpl).render(item, function(html){
                    $("#my_group").append(html);
                });
            });
        });

    }, http_request_error, true, true, 'json');

    //新建群聊弹出
    $("#group_box .ico_add").click(function(){
        var loading = layer.load(); //加载中的效果

        json_get(root_url+'/groupBox', '', function(html){

            layer.close(loading); // 加载完成关闭效果

            layer.open({
                type: 1,
                id: 'create_group',
                title: '新建群聊',
                area: ['600px', '400px'],
                shadeClose: true, //点击遮罩关闭
                content: html,
                btn: ['确定', '取消'],
                yes: function(index, layero){
                    var userids = '';
                    var groupName = $('#groupName').val();
                    var usernames = '';

                    $('#create_group .check_user_list li.check_ico').each(function(){
                        if (!userids){
                            userids += $(this).data('id');
                        }else{
                            userids += "|"+$(this).data('id');
                        }
                        if (!usernames){
                            usernames += $(this).data('name');
                        }else{
                            usernames += ","+$(this).data('name');
                        }
                    });

                    if (!groupName){

                        layer.alert('群名称不能为空',{closeBtn: 0});

                    }else if(!userids){

                        layer.alert('请选择人员',{closeBtn: 0});

                    }else{
                        //提交到服务器
                        var loading = layer.load(); //提交中的效果
                        json_post(root_url+"/groups", {name:groupName,userids:userids,usernames:usernames}, function(result){
                            //更新群列表
                            /*var data = result.data;
                            $(data).each(function(i, item){
                                layui.use('laytpl', function(){
                                    var laytpl = layui.laytpl;
                                    var getTpl = $("#tpl_group_list").html();

                                    laytpl(getTpl).render(item, function(html){
                                        $("#my_group").append(html);
                                    });
                                });
                            });*/

                            layer.close(loading); //提交完成关闭效果
                            layer.close(index);   //关闭窗口

                        }, http_request_error, true, true);


                    }

                }
            });

        }, http_request_error,true, false, 'html');

    });

    //新建群聊选择用户交互
    $("body").delegate("#create_group .check_user_list li","click",function(){
        if ($(this).hasClass('check_ico')){
            $(this).removeClass('check_ico');
        }else{
            $(this).addClass('check_ico');
        }

    });

    //点击群列表交互
    $('body').delegate(".group_head span.show_userlist", "click", function(){
       var id = $(this).parent().data('id');
       var name = $(this).parent().data('name');
       var obj = $(this);
        //显示用户列表
        $('#my_group ul').hide();//先关闭其它已经打开的用户列表
        obj.parent().next().find('ul').show();
        //隐藏群操作菜单
        $("#my_group .margin_cen").find('.group_menu').hide();

        $("#chat_message_box input[id='id']").val(id);
        $("#chat_message_box input[id='type']").val('group');
        //拉取群信息
        var tpl = '<div class="say" data-id="#id#" data-userid="#userid#">\n' +
            '                        <div class="say_l ">\n' +
            '                            <div class="circle ">\n' +
            '                                <p class="radius">\n' +
            '                                    <img src="#avatar#" alt="">\n' +
            '                                </p>\n' +
            '                            </div>\n' +
            '                        </div>\n' +
            '                        <div class="say_r  ">\n' +
            '                            <div>\n' +
            '                                <span class="user">#name#</span>\n' +
            '                                <span class="time">#time#</span>\n' +
            '                            </div>\n' +
            '                            <div class="pop">\n' +
            '                                <div class="pop_r ">\n' +
            '                                    <div class="pop_l ">\n' +
            '                                        <img src="img/pop_left.png" alt="">\n' +
            '                                    </div>\n' +
            '                                    <p>#content#</p>\n' +
            '                                </div>\n' +
            '                            </div>\n' +
            '                        </div>\n' +
            '                    </div>';

        json_get(root_url + '/groupMessages', {group_id:id,type:'gruop'}, function(result){
            var data = result.data;
            $("#chat_message_box .conversation").html('');
            $(data).each(function(i, item){
                var id = item.id;
                var user_id = item.user_id;
                var message = ata = eval("(" + item.content + ")");
                var user_name = message.user_name;
                var avatar = message.headimg;
                var time = item.created_at;
                var content = message.content;
                var file_id = message.file_id;
                var file_size = message.file_size;
                var file_url = message.file_url;
                var file_type = message.file_type;
                var float = '';
                //console.log(message.user_name);
                if (!file_id){
                    var message_item = '';
                    if (user_id == $("#chat_top").data("userid")){
                        float = 'fr';
                    }else{
                        float = '';
                    }
                    message_item = tpl.replace(/#id#/, id);
                    message_item = message_item.replace(/#userid#/, user_id);
                    message_item = message_item.replace(/#avatar#/, avatar);
                    message_item = message_item.replace(/#name#/, user_name);
                    message_item = message_item.replace(/#content#/, content);
                    message_item = message_item.replace(/#time#/, time);
                    message_item = message_item.replace(/#float#/, float);
                    //console.log(message_item);
                    $("#chat_message_box .conversation").prepend(message_item);
                }else{

                }
            });

        }, http_request_error,true, true, 'json');
    });

    //群操作菜单
    $('body').delegate('.group_head .group_do', 'click', function(){
        var index = $(this).parent().parent().index();
        var id = $(this).parent().data('id');
        var adminId = $(this).parent().data('admin');
        var menu = {add:'添加成员', edit:'编辑名称', delete:'解散群组', exit:'退出群聊'};
        var menu_html="";
        var user_id = $("#chat_top").data("userid"); //当前登录用户ID

        for (action in menu){
            if (action == 'edit' || action == 'delete' || action == 'add'){ //群主才显示添加，编辑，解散
                if (user_id == adminId){
                    menu_html += '<div class="'+action+'">'+menu[action]+'</div>';
                }
            }else if (action == 'exit'){ //群成员显示退出
                if (user_id != adminId){
                    menu_html += '<div class="'+action+'">'+menu[action]+'</div>';
                }
            }else{
                menu_html += '<div class="'+action+'">'+menu[action]+'</div>';
            }

        }

        $(this).next().html(menu_html);

        $(this).next().toggle("fast",function(){
            $("#my_group .margin_cen").not(':eq('+index+')').find('.group_menu').hide();
        });
    });

    //群操作菜单---添加成员
    $('body').delegate('.group_menu .add', 'click', function(){
        var loading = layer.load(); //加载中的效果
        var box_title = $(this).parent().parent().data('name');
        var user_list = '';
        var user_list_html ='';
        var obj = $(this);
        var group_id = $(this).parent().parent().data('id');

        json_get(root_url+"/userlist", '', function(result){
            layer.close(loading); //加载完成关闭效果

            var data = result.data;
            $(data).each(function(i, item){
                layui.use('laytpl', function(){
                    var laytpl = layui.laytpl;
                    var getTpl = '<li data-id="{{d.id}}" data-name="{{d.name}}">\n' +
                        '            <img src="{{d.avatar}}" alt="" >\n' +
                        '            <span>{{d.name}}</span>\n' +
                        '        </li>';

                    laytpl(getTpl).render(item, function(html){
                        user_list += html;
                    });
                });
            });

            user_list_html = '<div class="check_user_list">\n' +
                '        <ul>\n' +
                '        \n' + user_list +
                '        </ul>\n' +
                '    </div>';

            layer.open({
                type: 1,
                id:'user_list',
                title: box_title,
                area: ['600px', '400px'],
                shadeClose: true, //点击遮罩关闭
                content: user_list_html,
                btn: ['确定', '取消'],
                yes: function(index, layero){
                    var userids = '';
                    var usernames = '';
                   // var checked_list = '';

                    $('#user_list .check_user_list li.check_ico').each(function(){
                        if (!userids){
                            userids += $(this).data('id');
                        }else{
                            userids += "|"+$(this).data('id');
                        }

                        if (!usernames){
                            usernames += $(this).data('name');
                        }else{
                            usernames += ","+$(this).data('name');
                        }
                       // var avatar = $(this).find('img').attr('src');
                       // checked_list += '<li data-id="'+$(this).data('id')+'" data-name="'+$(this).data('name')+'"><img src="'+avatar+'"> <span>'+$(this).data('name')+'</span></li>';
                    });

                    if (!userids){
                        return ;
                    }
                    //提交到服务器
                    var loading = layer.load(); //提交中的效果
                    json_post(root_url+"/groupAddUser", {id:group_id,userids:userids,usernames:usernames}, function(result){
                        //更新群成员列表
                       // $("#group_item_"+group_id+" .group_user_list ul").append(checked_list);

                        layer.close(loading); //提交完成关闭效果
                        layer.close(index);   //关闭窗口

                    }, http_request_error, true, true);

                }
            });

            //选中该群已经选择的用户
            obj.parent().parent().next().find('li').each(function(i, item){
                var id = $(item).data('id');
                $("#user_list li[data-id='"+id+"']").addClass('checked_ico');

            });

        }, http_request_error, true, true, 'json');


    });

    //添加成员选择用户交互
    $("body").delegate("#user_list .check_user_list li[class!='checked_ico']","click",function(){
        if ($(this).hasClass('check_ico')){
            $(this).removeClass('check_ico');
        }else{
            $(this).addClass('check_ico');
        }

    });

    //群操作菜单---编辑群名称
    $("body").delegate(".group_menu .edit", "click", function(){
        var name = $(this).parent().parent().attr('data-name');
        var id = $(this).parent().parent().data('id');
        //隐藏群操作菜单
        $("#my_group .margin_cen").find('.group_menu').hide();

        layer.prompt({id:'group_edit_name',title:'修改群名称',value:name},function(val, index){
            //提交到服务器
            var loading = layer.load(); //提交中的效果
            json_post(root_url+"/groups/"+id, {name:val,_method:'PUT'}, function(result){
                //更新群名称
                $("#group_item_"+id+" .group_head span:eq(0)").html(val);
                $("#group_item_"+id+" .group_head").attr('data-name', val);

                layer.close(loading); //提交完成关闭效果
                layer.close(index);   //关闭prompt

            }, http_request_error, true, true);


        });

    });
    //群操作菜单---解散群组
    $("body").delegate('.group_menu .delete', 'click', function(){
        var id = $(this).parent().parent().data('id');
        layer.confirm('你确定要解散群组吗?', {icon: 3, title:'提示'}, function(index){
            //提交到服务器
            var loading = layer.load(); //提交中的效果
            json_post(root_url+"/groups/"+id, {_method:'DELETE'}, function(result){
                //更新群列表
                $("#group_item_"+id).remove();

                layer.close(loading); //提交完成关闭效果
                layer.close(index);

            }, http_request_error, true, true);


        });
    });

    //群列表-用户列表--交互（群主将显示移除成员按钮）
    $("body").delegate('.group_user_list li', 'mouseover', function(){
        var adminId = $(this).parent().parent().parent().find('.group_head').attr('data-admin');
        var user_id = $("#chat_top").data("userid"); //当前登录用户ID

        if ($(this).find('span.remove').length == 0 && user_id == adminId && !$(this).hasClass('group_admin')){
            $(this).append('<span class="remove"></span>');
        }
        //显示发消息按钮
        if ($(this).attr('data-id') != user_id && $(this).find('span.send_msg').length == 0){
            $(this).append('<span class="send_msg"></span>');
        }

    });
    $("body").delegate('.group_user_list li', 'mouseleave', function(){
        $(this).find('span.remove').remove();
        $(this).find('span.send_msg').remove();
    });
    //群主移除成员操作
    $("body").delegate('.group_user_list li span.remove', 'click', function(){
        var user_id = $(this).parent().attr('data-id');
        var user_name = $(this).parent().attr('data-name');
        var group_id = $(this).parent().parent().parent().parent().find('.group_head').attr('data-id');

        layer.confirm('你确定要移除 '+user_name+' 吗?', {icon: 3, title:'提示'}, function(index){

            //提交到服务器
            var loading = layer.load(); //提交中的效果
            json_post(root_url+"/groups/"+group_id+"/users/"+user_id, {user_id:user_id,user_name:user_name,group_id:group_id,_method:'DELETE'}, function(result){
                //更新群用户列表
                $('#group_item_'+group_id+' li[data-id="'+user_id+'"]').remove();

                layer.close(loading); //提交完成关闭效果
                layer.close(index);   //关闭prompt

            }, http_request_error, true, true);

        });
    });
    //点击用户发送信息
    $("body").delegate('.group_user_list li span.send_msg', 'click', function(){
        var id = $(this).parent().attr('data-id');
        var name = $(this).parent().attr('data-name');
        var avatar = $(this).parent().find('img').attr('src');
        var date = new Date();
        var time = date.getHours()+":"+ date.getMinutes();

        $('.conversation').empty();

        $(".menus_top .menu_li").removeClass('menu_sel');
        $("#menu_messages").addClass('menu_sel');
        $("#message_box").show();

        $("#group_box").hide();
        $("#team_box").hide();
        $("#file_box").hide();
        $(".file_lists").hide();
        $("#chat_message_box").show();

        var html = '<div class="outer">' +
            '<div class="people_out outer">' +
            '<div class="peoples fl on" data-type="user" data-id="'+id+'">' +
            '<div class="circle fl">    ' +
            '<p class="radius">       ' +
            '<img src="'+avatar+'" alt="">    ' +
            '</p></div>' +
            '<div class="mg fl">   ' +
            '<p class="tit otw">'+name+'</p>' +
            '<p class="detail otw"></p>' +
            '</div><div class="fl" style="width: 40px;margin-top: 23px;">' +
            '<p class="time">'+time+'</p></div></div></div></div>';
        if ($('#message_box .member_bot div[data-id="'+id+'"]').length == 0){
            $("#message_box .member_bot").prepend(html);
        }
        $('#message_box .member_bot .peoples').removeClass('on');
        $('#message_box .member_bot div[data-id="'+id+'"]').addClass('on');

        $("#chat_message_box input[id='id']").val(id);
        $("#chat_message_box input[id='type']").val('user');
    });

    //用户退出群聊
    $('body').delegate('.group_menu .exit', 'click', function(){
        var name = $(this).parent().parent().attr('data-name');
        var group_id = $(this).parent().parent().data('id');
        layer.confirm('你确定要退出 '+name+' 吗?', {icon: 3, title:'提示'}, function(index){
            //提交到服务器
            var loading = layer.load(); //提交中的效果
            json_post(root_url+"/groups/user/exit", {group_id:group_id}, function(result){
                //更新群用户列表
                $('#group_item_'+group_id+'').remove();

                layer.close(loading); //提交完成关闭效果
                layer.close(index);   //关闭prompt

            }, http_request_error, true, true);
        });
    });

});

//新建群
function group_create(result){
    var data = result.data;
    layui.use('laytpl', function(){
        var laytpl = layui.laytpl;
        var getTpl = $("#tpl_group_list").html();

        laytpl(getTpl).render(data, function(html){
            $("#my_group").append(html);
        });
    });
}

//用户退出群
function group_exit(result){
    var group_id = result.group_id;
    var exit_user_id = result.exit_user_id;
    $('#group_item_'+group_id+' li[data-id="'+exit_user_id+'"]').remove();
}
//群主添加成员
function group_adduser(result){
    var group_id = result.group_id;
    var data = result.data;

    if ($('#group_item_'+group_id).length > 0){ //已经存在的成员只理新用户列表
        var userlist = data.users;
        var user_list_html = '';
        $(userlist).each(function(i, item){
            layui.use('laytpl', function(){
                var laytpl = layui.laytpl;
                var getTpl = '<li {{#  if(d.isadmin == 1){ }} class="group_admin" {{#  } }} data-id="{{d.id}}" data-name="{{d.name}}">\n' +
                    '            <img src="{{d.avatar}}" alt="" >\n' +
                    '            <span>{{d.name}}</span>\n' +
                    '        </li>';

                laytpl(getTpl).render(item, function(html){
                    user_list_html += html;
                });
            });
        });

        $('#group_item_'+group_id).find('ul').html(user_list_html);

    }else{

        layui.use('laytpl', function(){
            var laytpl = layui.laytpl;
            var getTpl = $("#tpl_group_list").html();

            laytpl(getTpl).render(data, function(html){
                $("#my_group").append(html);
            });
        });
    }
}
//移除用户
function group_removeuser(result){
    var group_id = result.group_id;
    $('#group_item_'+group_id).remove();
}
//更新群名称
function group_updatename(result){
    var group_id = result.group_id;
    var group_name = result.group_name;
    $("#group_item_"+group_id+" .group_head span:eq(0)").html(group_name);
    $("#group_item_"+group_id+" .group_head").attr('data-name', group_name);
}
//解散群
function group_delete(result){
    var group_id = result.group_id;
    var group_name = result.group_name;
    $('#group_item_'+group_id).remove();
}