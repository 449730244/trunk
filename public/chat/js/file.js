$(document).ready(function () {
    //加载最近文件

    // /*顶部右上角菜单*/
    // $(".select .search_input").mouseover(function () {
    //     $(".select_hide").show();
    // }, function () {
    //     $(".select_hide").hide();
    //
    // });
    // $(".select_hide").mouseover(function () {
    //     $(".select_hide").show();
    // }, function () {
    //     $(".select_hide").hide();
    //
    // });
    // /*顶部右上角菜单*/
    //文件发送
    // $("#upload_file").change(function () {
    //     var formData = new FormData();
    //     formData.append("file", document.getElementById("upload_file").files[0]);
    //     $.ajax({
    //         url: "/upload?user_id=3",
    //         type: "POST",
    //         data: formData,
    //         /**
    //          *必须false才会自动加上正确的Content-Type
    //          */
    //         contentType: false,
    //         /**
    //          * 必须false才会避开jQuery对 formdata 的默认处理
    //          * XMLHttpRequest会对 formdata 进行正确的处理
    //          */
    //         processData: false,
    //         success: function (data) {
    //             // console.log(data.data.id)
    //             if($.isPlainObject(data)&&data.id>0)
    //             {
    //                 alert("上传成功！");
    //             }
    //             if (data.status == "error") {
    //                 alert(data);
    //             }
    //             $("#imgWait").hide();
    //         },
    //         error: function () {
    //             alert("上传失败！");
    //         }
    //     });
    // });

});

//文件搜索显示
function postFilelist(search) {
    var user_id  =    $("#chat_top").data("userid");
    //log('userid:'+user_id)
    var data = {user_id: user_id, search: search};
    var html = '';
    $.ajax({
        url: "/filelist", data: data, type: 'post', success: function (ret) {
            var table = '<tr>\n' +
                '<th class="t0 " >文件名</th>\n' +
                '<th class="t0">类型</th>\n' +
                '<th class="t3">大小(kb)</th>\n' +
                '<th class="t2">创建时间</th>\n' +
                '<th class="t3">创建者</th>\n' +
                '<th class="t4"></th>\n' +
                '</tr>';
            $.each(ret.data, function (k, v) {
                var time = v.created_at
                html += '<tr> <td class="tr_left"><img src="img/file_img.png" alt=""/>&nbsp;<span>' + (v.name) + '</span></td> <td>' + (v.type) + '</td><td>' + (v.size) + '</td><td>' + (time) + '</td><td>' + v.user_id + '</td><td><span onclick="filedownload(\'' + v.id + '\')">下载</span>&nbsp;&nbsp;<span onclick="filedel(\'' + v.id + '\')" >删除</span></td></tr>';
            })

            $(".file_table table").html(table + html);
        }
    });
}

//搜索框
function search() {

    /*        var where   =   $('#file_search').val();
            log(where)
            var search  =   new Array();
            search['date']  =   '';
            search['type']  =   '';
            search['content']   =   where;*/
    var search = $('#file_search').val();
    postFilelist(search)
}

//最近文件
function recentfiles() {

}


//删除文件  通过文件名删除
function filedel(fileid) {
    log(fileid)
    var userid  =   3;
    var data    =   {'user_id':userid,'file_id':fileid};
    $.ajax({
        url: '/delfile',
        data: data,
        type:'POST',
        success: function (ret) {
            var ret =   ($.parseJSON(ret))
            if(ret.error==0){
                alert(ret.msg)
                //移除当前标签  或者重新加载列表
                postFilelist()
            }

        }
    })
}

//下载文件
function filedownload(fileid) {
    log(fileid)
    window.location.href = ('/download?user_id=3&file_id=' + fileid)
}

function log($str) {
    console.log($str);
}