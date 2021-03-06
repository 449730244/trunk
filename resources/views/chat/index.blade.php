<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>聊天室</title>
    <link rel="stylesheet" href="/chat/css/css.css">
    <script src="/chat/js/jquery.min.js"></script>
    <script src="/chat/js/up.js"></script>
</head>
<body>
<div class="char_out ">
    <div class="chat_top  outer ">
        <div class="chart_l fl "></div>
        <div class="chart_r  ">
            <div class="search_out fl ">
                <div class="search fl">
                    <img src="/chat/img/search.png" alt="">
                    <input type="text" class="fl">
                </div>
                <div class="search_btn fr">搜索</div>
            </div>
            <span class="cen_txt">ice</span>
            <div class="message fr ">
                <div class="notice fl"><img src="/chat/img/notice.png" alt=""></div>
                <div class="menu fl" id="menu"><img src="/chat/img/menu_bar.png" alt=""></div>
            </div>
        </div>
        <div class="hide_menu">
            <div class="cen"><p><img src="/chat/img/to_top.png" alt="">&nbsp;&nbsp;置顶</p></div>
            <div class="cen"><p><img src="/chat/img/out.png" alt="">&nbsp;&nbsp;退出</p></div>
        </div>
    </div>
    <div class="chat_bot  outer">
        <div class="chart_l fl">
            <div class="menus_top">
                <a href="message.html">
                    <div class="menu_li new_mes" id="ifNewChat">
                        <p class="new"></p>
                        <p class="menu_img ">
                            <img src="/chat/img/left_menu1.png" alt="">
                        </p>
                        <p class="img_dis">
                            <img src="/chat/img/left_menu1_sel.png" alt="">
                        </p>
                        <p class="menu_txt">
                            消息
                        </p>
                    </div>
                </a>
                <a href="index.html">
                    <div class="menu_li menu_sel" id="ifNewGroup">
                        <p class="menu_img ">
                            <img src="/chat/img/left_menu2.png" alt="">
                        </p>
                        <p class="img_dis">
                            <img src="/chat/img/left_menu2_sel.png" alt="">
                        </p>
                        <p class="menu_txt">
                            群聊
                        </p>
                    </div>
                </a>
                <a href="fenzu.html">
                    <div class="menu_li ">
                        <p class="menu_img ">
                            <img src="/chat/img/fenzu.png" alt="">
                        </p>
                        <p class="img_dis">
                            <img src="/chat/img/fenzu_sel.png" alt="">
                        </p>
                        <p class="menu_txt">
                            分组
                        </p>
                    </div>
                </a>
                <a href="file.html">
                    <div class="menu_li">
                        <p class="menu_img ">
                            <img src="/chat/img/left_menu3.png" alt="">
                        </p>
                        <p class="img_dis">
                            <img src="/chat/img/left_menu3_sel.png" alt="">
                        </p>
                        <p class="menu_txt">
                            文件
                        </p>
                    </div>
                </a>

            </div>
            <div class="menus_bot">
                <div class="menu_li ">
                    <p class="menu_img ">
                        <img src="/chat/img/set.png" alt="">
                    </p>
                    <p class="img_dis">
                        <img src="/chat/img/set_sel.png" alt="">
                    </p>
                    <p class="menu_txt">
                        设置
                    </p>
                </div>
            </div>

        </div>
        <div class="chart_l_c fl">
            <div class="member_top outer">
                <div class="margin_cen">
                    <p class="fl">成员列表</p>
                    <p class="fr">
                        <img src="/chat/img/cen_menu.png" alt="">
                    </p>
                </div>
            </div>
            <div class="member_bot">
                <div class="margin_cen members">
                    <p class="fl">
                        <img src="/chat/img/cut_down.png" alt="">
                    </p>
                    <p class="txt fl">成员列表</p>
                    <p class="fr">
                        <img src="/chat/img/cen_menu.png" alt="">
                    </p>
                </div>
                <div class="margin_cen  outer">
                    <div class="people_out outer">
                        <div class="peoples fl">
                            <div class="circle fl">
                                <p class="radius">
                                    <img src="/chat/img/head.jpg" alt="">
                                </p>
                            </div>
                            <div class="mes_txt fl">ice</div>
                        </div>
                        <div class="mes_del fr"><img src="/chat/img/delete.png" alt=""></div>
                    </div>
                </div>
                <div class="margin_cen  outer">
                    <div class="people_out outer">
                        <div class="peoples fl">
                            <div class="circle fl">
                                <p class="radius">
                                    <img src="/chat/img/head.jpg" alt="">
                                </p>
                            </div>
                            <div class="mes_txt fl">ice</div>
                        </div>
                        <div class="mes_del fr"><img src="/chat/img/delete.png" alt=""></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="chart_r">
            <div class="conversation ">
                <div class="tips ">
                    <p>没有更多消息了</p>
                    <p>———— 14:25 ————</p>
                </div>
                <div class="say ">
                    <div class="say_l ">
                        <div class="circle ">
                            <p class="radius">
                                <img src="/chat/img/head.jpg" alt="">
                            </p>
                        </div>
                    </div>
                    <div class="say_r ">
                        <div><span class="user">ice</span><span class="time">13:41</span></div>
                        <div class="pop">
                            <div class="pop_r ">
                                <div class="pop_l ">
                                    <img src="/chat/img/pop_left.png" alt="">
                                </div>
                                <p>当前使用的是免费版</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="say ">
                    <div class="say_l ">
                        <div class="circle ">
                            <p class="radius">
                                <img src="/chat/img/head.jpg" alt="">
                            </p>
                        </div>
                    </div>
                    <div class="say_r ">
                        <div><span class="user">ice</span><span class="time">13:41</span></div>
                        <div class="pop">
                            <div class="pop_r ">
                                <div class="pop_l ">
                                    <img src="/chat/img/pop_left.png" alt="">
                                </div>
                                <p>当前使用的是免费版</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="say ">
                    <div class="say_l ">
                        <div class="circle ">
                            <p class="radius">
                                <img src="/chat/img/head.jpg" alt="">
                            </p>
                        </div>
                    </div>
                    <div class="say_r ">
                        <div><span class="user">ice</span><span class="time">13:41</span></div>
                        <div class="pop">
                            <div class="pop_r ">
                                <div class="pop_l ">
                                    <img src="/chat/img/pop_left.png" alt="">
                                </div>
                                <p>当前使用的是免费版</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="say ">
                    <div class="say_l ">
                        <div class="circle ">
                            <p class="radius">
                                <img src="/chat/img/head.jpg" alt="">
                            </p>
                        </div>
                    </div>
                    <div class="say_r ">
                        <div><span class="user">ice</span><span class="time">13:41</span></div>
                        <div class="pop">
                            <div class="pop_r ">
                                <div class="pop_l ">
                                    <img src="/chat/img/pop_left.png" alt="">
                                </div>
                                <p>当前使用的是免费版</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="say ">
                    <div class="say_l ">
                        <div class="circle ">
                            <p class="radius">
                                <img src="/chat/img/head.jpg" alt="">
                            </p>
                        </div>
                    </div>
                    <div class="say_r ">
                        <div><span class="user">ice</span><span class="time">13:41</span></div>
                        <div class="pop">
                            <div class="pop_r ">
                                <div class="pop_l ">
                                    <img src="/chat/img/pop_left.png" alt="">
                                </div>
                                <p>当前使用的是免费版</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="say ">
                    <div class="say_l ">
                        <div class="circle ">
                            <p class="radius">
                                <img src="/chat/img/head.jpg" alt="">
                            </p>
                        </div>
                    </div>
                    <div class="say_r ">
                        <div><span class="user">ice</span><span class="time">13:41</span></div>
                        <div class="pop">
                            <div class="pop_r ">
                                <div class="pop_l ">
                                    <img src="/chat/img/pop_left.png" alt="">
                                </div>
                                <p>当前使用的是免费版当前使用的是免费版当前使用的是免费版当前使用的是免费版</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="say ">
                    <div class="say_l ">
                        <div class="circle ">
                            <p class="radius">
                                <img src="/chat/img/head.jpg" alt="">
                            </p>
                        </div>
                    </div>
                    <div class="say_r ">
                        <div><span class="user">ice</span><span class="time">13:41</span></div>
                        <div class="pop">
                            <div class="pop_r ">
                                <div class="pop_l ">
                                    <img src="/chat/img/pop_left.png" alt="">
                                </div>
                                <p>当前使用的是免费版当前使用的是免费版当前使用的是免费版当前使用的是免费版</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="say ">
                    <div class="say_l ">
                        <div class="circle ">
                            <p class="radius">
                                <img src="/chat/img/head.jpg" alt="">
                            </p>
                        </div>
                    </div>
                    <div class="say_r ">
                        <div><span class="user">ice</span><span class="time">13:41</span></div>
                        <div class="pop">
                            <div class="pop_r ">
                                <div class="pop_l ">
                                    <img src="/chat/img/pop_left.png" alt="">
                                </div>
                                <p>当前使用的是免费版当前使用的是免费版当前使用的是免费版当前使用的是免费版</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="say ">
                    <div class="say_l ">
                        <div class="circle ">
                            <p class="radius">
                                <img src="/chat/img/head.jpg" alt="">
                            </p>
                        </div>
                    </div>
                    <div class="say_r ">
                        <div><span class="user">ice</span><span class="time">13:41</span></div>
                        <div class="pop">
                            <div class="pop_r ">
                                <div class="pop_l ">
                                    <img src="/chat/img/pop_left.png" alt="">
                                </div>
                                <p>当前使用的是免费版当前使用的是免费版当前使用的是免费版当前使用的是免费版</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="say ">
                    <div class="say_l ">
                        <div class="circle ">
                            <p class="radius">
                                <img src="/chat/img/head.jpg" alt="">
                            </p>
                        </div>
                    </div>
                    <div class="say_r ">
                        <div><span class="user">ice</span><span class="time">13:41</span></div>
                        <div class="pop">
                            <div class="pop_r ">
                                <div class="pop_l ">
                                    <img src="/chat/img/pop_left.png" alt="">
                                </div>
                                <p>当前使用的是免费版当前使用的是免费版当前使用的是免费版当前使用的是免费版</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="send">
                <div class="imgbox">
                    <img src="/chat/img/faceimg/1.png">
                    <img src="/chat/img/faceimg/2.png">
                    <img src="/chat/img/faceimg/3.png">
                    <img src="/chat/img/faceimg/4.png">
                    <img src="/chat/img/faceimg/5.png">
                </div>
                <div class="send_nav ">
                    <div class="face_change li fl">
                        <img src="/chat/img/face.png" alt="">
                    </div>
                    <div class="img_chang li fl">
                        <img src="/chat/img/img.png" alt="">
                        <input type="file">
                    </div>
                    <div class="file_chang li fl">
                        <img src="/chat/img/file.png" alt="">
                        <input type="file">
                    </div>

                </div>
                <div class="bot_out">
                    <div class="send_bot editbox fl" id="testdiv" contenteditable="true" onkeydown="enterkey()">
                        当前使用的是免费版，支付之后升级高级版
                    </div>
                    <div class="send_btn fl" onclick="send()">发送</div>

                </div>

            </div>
        </div>
    </div>
</div>
</body>
</html>
<script type="text/javascript">

    $(document).ready(function(){
        $.get('test');
    });

    //此处必须防止在最下端。

    var edt = document.getElementById("testdiv");

    if (edt.addEventListener) {

        edt.addEventListener("paste", pasteHandler, false);

    } else {

        edt.attachEvent("onpaste", pasteHandler);

    }

    function send() {
        var content = document.getElementById("testdiv").innerHTML;
        $.get('test');
       // alert(content);
    }

    //    $(".face_change").hover(function () {
    //        $(".imgbox").show();
    //    })
    $(".face_change").hover(function () {
        $(".imgbox").show();
    }, function () {
        $(".imgbox").hide();

    });
    $(".imgbox").hover(function () {
        $(".imgbox").show();
    }, function () {
        $(".imgbox").hide();

    });





</script>