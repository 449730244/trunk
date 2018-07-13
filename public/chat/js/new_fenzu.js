
var uid='0';
    //此处必须防止在最下端。

    $(".fenzu_li .name").click(function () {
        $(this).parent('.fenzu_li').find($('.lists')).toggle();
    })

    $(document).ready(function () {
        //获取分组列表


        
    });
    var fenzu_name = [];//分钟列表除默认分组外其他所有分组
    function fz_getOnline() {
        //获取登陆状态 samelogin
        // json_get(root_url+"/team/getIslogin", '', function(data){
        //     onlineUsers=[];
        //     if (data.data) {
        //         $.each(data.data,function (k,v) {
        //             var is_login=v.is_login;
        //             if(is_login==1)
        //             {
        //                 onlineUsers.push(v.user_id);
        //             }

        //         })
        //     }
        // }, http_request_error, true, true, 'json');
        
        onlineUsers=[];
        getfenzu();


    }
    function getfenzu() {
        $.ajax({
            url: root_url+"/team",    //请求的url地址
            // dataType:"json",   //返回格式为json
            async: false,//请求是否异步，默认为异步，这也是ajax重要特性
//          data:data,    //参数值
            type: "get",   //请求方式
            beforeSend: function () {
                //请求前的处理
            },
            success: function (data, status, xhr) {
                var data_obj = jQuery.parseJSON(data);
                var my_GroupList = data_obj.data.team_list;
                uid=data_obj.data.user_info.id;
                var avatar_d = data_obj.data.user_info.avatar;
                //$("#auth_user_name").text(data_obj.data.user_info.name);
                var html = '';
                fenzu_name = [];
                for (var j = 0; j < my_GroupList.length; j++) {
                    var group_name = my_GroupList[j]['name'];
                    var team_id = my_GroupList[j].team_id ? team_id = my_GroupList[j].team_id : team_id = null;
                    fenzu_name = fenzu_name.concat({'group_name': group_name, 'team_id': team_id});

                    html += '<div class="fenzu_li " id="' + team_id + '">' +
                        '<div class="margin_cen members outer">' +
                        '<p class="fl name_cut">' +
                        '<img src="img/cut_down.png" alt="">' +
                        '</p>' +
                        '<p class="txt otw fl">' + group_name + '</p>';
                    if (j !== 0) {
                        html += '<p class="fr fenzu_change dkzu" id="' + team_id + '">' +
                            '<img src="img/cen_menu.png" alt="" >' +
                            '</p>' +
                            '<div class="hide_menu member_hide click_hide" id="member_hide_' + team_id + '" >' +
                            '<div class="cen edit_fenzu" id="editfenzu_' + team_id + '" onclick="edit_fenzu(' + team_id + ',\'' + group_name + '\')">' +
                            '<p><img src="img/re_name.png" alt="">&nbsp;&nbsp;修改分组名称 </p></div>' +
                            ' <div class="cen" onclick="del_fenzu(' + team_id + ')"><p><img src="img/del.png" alt="">&nbsp;&nbsp;删除分组 </p></div>' +
                            ' </div>';
                    }


                    html += '</div>' +
                        '<div class="lists" id="lists_' + j + '">' +
                        '</div>' +
                        '</div>';
                    $("#goodfirend").html(html);
                }
                
                    for (var l = 0; l < my_GroupList.length; l++) {
                        var list = my_GroupList[l]['data'];
                        if (list.length > 0) {
                        for (var k = 0; k < list.length; k++) {
                            var goupIn = '';
                            var team_id = list[k]['team_id'];
                            var team_name = list[k]['team_name'];
                            var team_owner = list[k]['team_owner'];
                            var index = list[k]['user_id'];
                            var name = list[k]['nickname']
                            var head = list[k]['avatar'];
                            var online_personal = onlineUsers.indexOf(Number(index));
                            goupIn += '<div class="margin_cen  outer">' +
                                '<div class="people_out outer">' +
                                '<div class="peoples fl" onClick="right_show(this,' + index + ')" style="width:170px;">' +
                                '<div class="circle fl">';
                            if (online_personal !== -1) {
                                goupIn += '<p class="radius">' +
                                    '<img src="' + head + '" alt="" onerror="nofind()">' +
                                    '</p>' +
                                    '<div class="point">' +
                                    '</div>';
                            }
                            else {
                                goupIn += '<p class="radius gray_head" >' +
                                    '<img src="' + head + '" alt="" onerror="nofind()" style="width: 100%;height: 100%; border-radius: 50%;border: 29px dotted;border-width: 0vw;margin: 0vw;overflow: hidden;color: #ffffff;position: relative;z-index: 1;">' +
                                    '</p>' +
                                    '<div class="point outline">' +
                                    '</div>';
                            }

                            goupIn += '</div>' +
                                '<div class="mes_txt fl">' + name + '</div>' +
                                '</div>';
                            if (list[k].user_id !== uid) {
                                goupIn += '<div class="mes_del fr" style="display:none;" id="' + index + '">' +
                                    '<img src="img/add.png" alt="">';
                            }


                            if (l == 0) {

                                goupIn += '<div class="send_hide send_del click_hide">' +
                                    '<div class="circle">';
                                if (online_personal !== -1) {
                                    goupIn += '<p class="radius">' +
                                        '<img src="' + head + '" alt="" onerror="nofind()">' +
                                        '</p>';
                                }
                                else {
                                    goupIn += '<p class="radius gray_head" >' +
                                        '<img src="' + head + '" alt="" onerror="nofind()" style="width: 100% ;height: 100%; border-radius: 50%;border: 29px dotted;border-width: 0vw;margin: 0vw;overflow: hidden;color: #ffffff;position: relative;z-index: 1;">' +
                                        '</p>';
                                }

                                goupIn += '</div>' +
                                    '<div class="send_name">' + name + '</div>' +
                                    '<div class="selectin fenzu_select" id="' + index + '" data-oldId="' + team_id + '">';
                                if (list[k].user_id !== uid) {
                                    goupIn += '<select onChange="joinTeam()" id="joinTeam_"+' + index + '>' +
                                        '<option value="">请选择</option>' +
                                        '<option value="0">我的好友</option>' +
                                        '<option value=""></option>' +
                                        '</select>';
                                }
                                goupIn += '<img src="img/select_right.png" alt="">' +
                                    '</div>' +
                                    '<div class="to_send outer">' +
                                    '<div class="send_btn del fl del_not">移除用户</div>';
                                if (list[k].user_id == uid) {
                                    goupIn += '<div class="send_btn bac del_not fr" >发信息</div>';

                                }
                                else {
                                    goupIn +=
                                        '<a href="javascript:;">' +
                                        '<div class="send_btn_1 bac fr" onclick=redirect_to_message("' + list[k].user_id + '","' + list[k].nickname + '","' + head + '")>发信息</div>' +
                                        '</a>';
                                }

                                goupIn += '</div>' +
                                    '</div>';
                            }
                            else {
                                goupIn += '<div class="send_hide send_del click_hide">' +
                                    '<div class="circle">' +
                                    '<p class="radius">' +
                                    '<img src="' + head + '" alt="" onerror="nofind()">' +
                                    '</p>' +
                                    '</div>' +
                                    '<div class="send_name">' + name + '</div>' +
                                    '<div class="selectin fenzu_select" id="' + index + '" data-oldId="' + team_id + '">' +
                                    '<select onChange="joinTeam()" id="joinTeam_"+' + index + '>' +
                                    '<option value="">请选择</option>' +
                                    '<option value="0">我的好友</option>' +
                                    '<option value=""></option>' +
                                    '</select>' +
                                    '<img src="img/select_right.png" alt="">' +
                                    '</div>' +
                                    '<div class="to_send outer">' +
                                    '<div class="send_btn del fl" onClick=leaveTeam("' + team_id + '","' + list[k].user_id + '")>移除用户</div>' +
                                    '<a href="javascript:;">' +
                                    '<div class="send_btn_1 bac fr" onclick=redirect_to_message("' + list[k].user_id + '","' + list[k].nickname + '","' + head + '")>发信息</div>' +
                                    '</a>' +
                                    '</div>' +
                                    '</div>';
                            }

                            goupIn += '</div>' +
                                '</div>' +
                                '</div>';
                            if (list[k].user_id !== uid) {
                                goupIn += '</div>';
                            }

                            $("#lists_" + l).prepend(goupIn);
                        }
                    }
                   
                }

                $(".mes_del").on('click', function (e) {
                    var selectIn = '';
                    var select_id = $(this).attr('id');
                    selectIn += '<select onChange="joinTeam(this)" id="joinTeam" class="otw">';
                    $.each(fenzu_name, function (key, value) {
                        
                   
                        selectIn += '<option value="' + value.team_id + '" >' + value.group_name + '</option>';

                    });
                    selectIn += '</select>';
                    if (select_id !== uid) {
                        $(this).find('.fenzu_select').css('display','block');
                        $(this).find('.fenzu_select').html(selectIn);
                    }
                    else {
                        $(this).find('.fenzu_select').html('');
                    }
                    $(".click_hide").hide();
                    var fz_id = $(this).attr("id");
                    var str = $(this).children(".send_hide ").children(".to_send").children(".firends").text();
           
                    var del = '<div class="send_btn fl del fl"  onClick=leaveTeam("' + fz_id + '","' + fenzu_name + '")>移除用户</div>';
                    var add = '<div class="send_btn fl " onclick="add_friends(' + fz_id + ')">加好友</div>';
                    var strArray = []; //定义一数组
                    strArray = str.split(","); //字符分割
                    if (strArray.indexOf(fz_id) === -1) {
                        $(this).children(".send_hide ").children(".to_send").children('.to_friend').html(add);
                    }
                    else {
                        $(this).children(".send_hide ").children(".to_send").children('.to_friend').html(del);
                    }
                    var clone = $(this).find($('.send_hide')).html();
                    $("#send_hide_clone").html(clone);
                    var oEvent = e || event;
                    $(".click_hide").hide();
                    $("#send_hide_clone").show();
                    var top = $(this).offset().top;
                    if (top < 689) {
                        var btn_height = top - 40;
                        $("#send_hide_clone").css("left", oEvent.screenX + 0 + "px").css("top", btn_height + "px");
                    }
                    if (top > 689) {
                        var btn_height = top - 300;
                        $("#send_hide_clone").css("left", oEvent.screenX + 0 + "px").css("top", btn_height + "px");
                    }
                    $(document).one("click", function () {
                        //任意位置点击隐藏
                        $("#send_hide_clone").hide();
                    });
                    e.stopPropagation();
                });

                $("#send_hide_clone").on("click", function (e) {
                    //点击带单时不隐藏
                    e.stopPropagation();
                });

                function fenzu_change(teamId) {
                    $("#xg_fenzu_name").val(teamId);
                    $("#fenzu_name_edit").show();
                }

                $(".dkzu").on('click', function (e) {
                    //var long_id = $(this).attr('id');
                    // var index = long_id.lastIndexOf("_");
                    var c_id = $(this).attr('id');
                    var clone = $('#member_hide_' + c_id).html();
                    $(".click_hide").hide();
                    $("#member_hide_clone").html(clone);
                    $("#member_hide_clone").show();
                    var oEvent = e || event;
                    var top = $(this).offset().top;
                    if (top < 826) {
                        var btn_height = top - 30;
                        $("#member_hide_clone").css("left", oEvent.screenX + 0 + "px").css("top", btn_height + "px");
                    }
                    if (top > 826) {
                        var btn_height = top - 170;
                        $("#member_hide_clone").css("left", oEvent.screenX + 0 + "px").css("top", btn_height + "px");
                    }
                    $(document).one("click", function () {
                        //任意位置点击隐藏
                        $("#member_hide_clone").hide();
                    });
                    e.stopPropagation();
                });
                //菜单收起
                $(".fenzu_li .margin_cen").click(function () {
                    var img_src = $(this).find(".name_cut img").attr('src');
                    if (img_src == 'img/cut_down.png') {
                        $(this).find(".name_cut img").attr('src','img/ico_jt_off.png');
                    }else{
                        $(this).find(".name_cut img").attr('src','img/cut_down.png');
                    }
                    
                    $(this).next('.lists').toggle();
                });

            },
            complete: function (req) {
                //请求完成的处理
                $(".click_hide").hide();
            },
            error: function () {
                //请求出错处理
                console.error('初始化连接失败');
            }
        });
    }


    
    //新增分组
    function fenzu_change_show() {
        var html='<form class="layui-form"><div id="create_fenzu_box" style="margin:10px;"><div class="layui-form-item"><label class="layui-form-label">分组名称</label><div class="layui-input-block"><input name="fenzu_name" id="fenzu_name" lay-verify="title" autocomplete="off" placeholder="分组名称" class="layui-input" type="text" maxlength="20"></div></div></div></form>';
        var loading = layer.load(); //加载中的效果
        layer.close(loading); // 加载完成关闭效果
            layer.open({
                type: 1,
                id: 'create_fenzu',
                title: '新建分组',
                area: ['600px', '200px'],
                shadeClose: true, //点击遮罩关闭
                content: html,
                btn: ['确定', '取消'],
                yes: function(index, layero){
                    var name = $('#fenzu_name').val();
                    if (name == "") {
                        layer.alert('分组名称必须填写。',{closeBtn: 0});
                    }else{
                        //提交到服务器
                        var loading = layer.load(); //提交中的效果
                        var postData = {
                            //"teamOwner": uid,
                            "name": name
                        };
                        json_post(root_url+"/team/add_team_name", postData, function(data_obj){
                            //更新群列表
                            //console.log(data);
                            //var data_obj = jQuery.parseJSON(data);
                            if (data_obj.code == 1) {
                                $('#fenzu_name').val('');
                                $(".click_hide").hide();
                                getfenzu();
                            }else{
                                layer.alert(data_obj.msg,{closeBtn: 0});
                            }

                            layer.close(loading); //提交完成关闭效果
                            layer.close(index);   //关闭窗口

                        }, http_request_error, true, true);


                    }

                }
            });
    }

    // $("#add_alert .close").click(function () {
    //     $("#add_alert").hide();
    // });

    // $("#fenzu_name_edit .close").click(function () {
    //     $("#fenzu_name_edit").hide();
    // });

    // $("#fenzu_change_m .close").click(function () {
    //     $("#fenzu_change_m").hide();
    // });
    $(".chart_l_c .nav p").on('click', function (e) {
        $(this).parent('.nav').children('p').removeClass('sel');
        $(this).addClass('sel');
        var id = $(this).attr("id");
        if (id === "nav_fz") {
            $("#fenzu_top .margin_cen").hide();
            $("#fz_cen").show();
            $("#goodfirend").show();
            $("#conversation").show();

        }
        if (id === "nav_chat") {
            $("#fenzu_top .margin_cen").hide();
            $("#goodfirend").hide();
            $("#conversation").hide();
            $("#chat_cen").show();

        }

    });


    //编辑分组
    function edit_fenzu(id,name) {
        $(".click_hide").hide();
        var html='<form class="layui-form"><div id="edit_fenzu_box" style="margin:10px;"><div class="layui-form-item"><label class="layui-form-label">分组名称</label><div class="layui-input-block"><input name="fenzu_name" id="fenzu_name" lay-verify="title" autocomplete="off" placeholder="分组名称" class="layui-input" type="text" maxlength="20" value="'+name+'"></div></div></div></form>';
        var loading = layer.load(); //加载中的效果
        layer.close(loading); // 加载完成关闭效果
            layer.open({
                type: 1,
                id: 'edit_fenzu',
                title: '修改分组名称',
                area: ['600px', '200px'],
                shadeClose: true, //点击遮罩关闭
                content: html,
                btn: ['确定', '取消'],
                yes: function(index, layero){
                    var new_name = $('#fenzu_name').val();
                    if (new_name == "") {
                        layer.alert('分组名称必须填写。',{closeBtn: 0});
                    }else{
                        //提交到服务器
                        var loading = layer.load(); //提交中的效果
                        var postData = {
                            "teamId": id,
                            "name": new_name
                        };
                        json_post(root_url+"/team/renameTeam", postData, function(data_obj){
                            if (data_obj.code == 1) {
                                $(".click_hide").hide();
                                getfenzu();
                            }else{
                                layer.alert(data_obj.msg,{closeBtn: 0});
                            }

                            layer.close(loading); //提交完成关闭效果
                            layer.close(index);   //关闭窗口

                        }, http_request_error, true, true);


                    }

                }
            });
    }

    //删除分组
    function del_fenzu(teamId) {
        $(".click_hide").hide();
        layer.confirm('确定删除当前分组?', {icon: 3, title:'提示'}, function(index){
            //提交到服务器
            var loading = layer.load(); //提交中的效果
            json_post(root_url+"/team/removeTeam", {'teamId': teamId}, function(result){
                getfenzu();
                $(".info_right").css('display','none');
                layer.close(loading); //提交完成关闭效果
                layer.close(index);

            }, http_request_error, true, true);


        });
    }
    //显示用户编辑内容
    function right_show(th,id) {
        $.each($(".mes_del"),function(){
            $(this).prev().css('background','#ffffff');
            $(this).css('display','none');
            if ($(this).attr("id") == id) {
                $(this).css('display','block');
                $(this).prev().css('background','#f2f2f2');
            }

        })
        $(".info_right").hide();
        if (id != uid) {
            $(".info_right").show();
            $.post(root_url+"/team/user", "id=" + id, function (data) {
                var data_obj = jQuery.parseJSON(data);
                var  avatar_d = data_obj['data']['0']['avatar'];
                var sli = '<div class="circle"><p class="radius"><img src="'+avatar_d+'" alt="" onerror="nofind()" style="width: 100%;height: 100%;border-radius: 50%;border: 29px dotted;border-width: 0vw;margin: 0vw;"></p></div><div class="name">'+data_obj['data']['0']['name']+'</div><a href="javascript:;" onclick=\'redirect_to_message('+data_obj['data']['0']['id']+', "'+data_obj['data']['0']['name']+'", "'+avatar_d+'");\'><div class="btn_touch">发起对话</div></a>';
                $(".info_right").html(sli);

            });
        }
        
    }
    //修改分组用户
    function joinTeam(thd) {

        var teamUser = $("#send_hide_clone .fenzu_select").attr('id');
        var join_id = $(thd).val();
        var old_id = $("#send_hide_clone .fenzu_select").attr('data-oldId');

        json_get(root_url+'/team/addTeamUser', {'teamId': join_id,"teamUser": teamUser,"current_teamId": old_id}, function(data_obj){

            if (data_obj.code == 1) {
                $(".click_hide").hide();
                $(".info_right").hide();
                getfenzu();
            }else{
                layer.alert(data_obj.msg,{closeBtn: 0});
            }

        }, http_request_error, true, true, 'json');

    }
    //移除用户
    function leaveTeam(teamId, teamUser) {
        
        $(".click_hide").hide();

        layer.confirm('确定移除该分组用户?', {icon: 3, title:'提示'}, function(index){
            //提交到服务器
            var loading = layer.load(); //提交中的效果
            json_post(root_url+"/team/leaveTeam", {'teamUser': teamUser,'teamId': teamId}, function(result){
                getfenzu();
                $(".info_right").css('display','none');
                layer.close(loading); //提交完成关闭效果
                layer.close(index);

            }, http_request_error, true, true);


        });
    }


