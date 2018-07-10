$(document).ready(function(){

    var uploader = new plupload.Uploader({
        runtimes : 'html5,flash,silverlight,html4',
        browse_button : 'upload_img', // you can pass an id...
        url : root_url+'/uploadimg',
        flash_swf_url : '/vendor/plupload/js/Moxie.swf',
        silverlight_xap_url : '/vendor/plupload/js/Moxie.xap',
        file_data_name : 'image',

        filters : {
            max_file_size : '10mb',
            mime_types: [
                {title : "Image files", extensions : "jpg,gif,png"}
            ]
        },

        init: {
            PostInit: function() {

            },

            FilesAdded: function(up, files) {
                /* plupload.each(files, function(file) {
                     document.getElementById('filelist').innerHTML += '<div id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ') <b></b></div>';
                 });*/

                uploader.start();
            },

            UploadProgress: function(up, file) {
                //document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
            },

            UploadComplete : function(up, files){
                /* plupload.each(files, function(file) {
                     $("#"+file.id).find('span').html('<input class="form-control" type="text" name="phototitle[]" placeholder="描述"><input type="hidden" name="iscover[]"><button type="button" class="btn btn-default btn-xs set_cover">封面</button> <button type="button" class="btn btn-default btn-xs set_photo">插入</button><button type="button" class="btn btn-default btn-xs set_remove"><span class="fa fa-remove"></span></button>');
                 });*/
            },

            BeforeUpload: function(up, file) {
                // Called right before the upload for a given file starts, can be used to cancel it if required
                //{_token:$('meta[name="csrf-token"]').attr('content'),id:$("#chat_message_box input[id='id']").val(),type:$("#chat_message_box input[id='type']").val()}
                uploader.settings.multipart_params = {
                    _token:$('meta[name="csrf-token"]').attr('content'),
                    id:$("#chat_message_box input[id='id']").val(),
                    type:$("#chat_message_box input[id='type']").val()
                };
                //log('[BeforeUpload]', 'File: ', file);
            },

            FileUploaded : function(up,file,data){
                 var returndata = $.parseJSON(data.response);
                 console.log(data);
                 if (data.status == '201'){
                     //$("#"+file.id).find('img').attr('src', returndata.imgurl);
                     //$("#f"+file.id).val(returndata.imgpath);
                     $("#testdiv").append('<img src="'+ returndata.data.url +'" >');

                 }else{
                     //$("#upfilerror").html('上传失败');
                    // layer.alert(result.message);
                 }
            },

            Error: function(up, err) {

            }
        }
    });

    uploader.init();

    var uploader_file = new plupload.Uploader({
        runtimes : 'html5,flash,silverlight,html4',
        browse_button : 'upload_file', // you can pass an id...
        url : root_url+'/uploadfile',
        flash_swf_url : '/vendor/plupload/js/Moxie.swf',
        silverlight_xap_url : '/vendor/plupload/js/Moxie.xap',
        file_data_name : 'file',
        filters : {
            max_file_size : '2mb',
            mime_types: [
                {title : "files", extensions : "pdf,txt,zip,rar,doc,xsl,docx,jpeg,gif,bmp,jpg,png"}
            ]
        },

        init: {
            PostInit: function() {

            },

            FilesAdded: function(up, files) {
                /* plupload.each(files, function(file) {
                     document.getElementById('filelist').innerHTML += '<div id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ') <b></b></div>';
                 });*/
                uploader_file.start();
            },

            UploadProgress: function(up, file) {
                //document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
            },

            UploadComplete : function(up, files){
                postFilelist('')
                /* plupload.each(files, function(file) {
                     $("#"+file.id).find('span').html('<input class="form-control" type="text" name="phototitle[]" placeholder="描述"><input type="hidden" name="iscover[]"><button type="button" class="btn btn-default btn-xs set_cover">封面</button> <button type="button" class="btn btn-default btn-xs set_photo">插入</button><button type="button" class="btn btn-default btn-xs set_remove"><span class="fa fa-remove"></span></button>');
                 });*/
            },

            BeforeUpload: function(up, file) {
                // Called right before the upload for a given file starts, can be used to cancel it if required
                //{_token:$('meta[name="csrf-token"]').attr('content'),id:$("#chat_message_box input[id='id']").val(),type:$("#chat_message_box input[id='type']").val()}
                uploader_file.settings.multipart_params = {
                    _token:$('meta[name="csrf-token"]').attr('content'),
                    id:$("#chat_message_box input[id='id']").val(),
                    type:$("#chat_message_box input[id='type']").val(),
                    user_id:$("#chat_top").data("userid")
                };
                //log('[BeforeUpload]', 'File: ', file);
            },

            FileUploaded : function(up,file,data){
                /* var returndata = $.parseJSON(data.response);
                 if (data.status == '200'){
                     $("#"+file.id).find('img').attr('src', returndata.imgurl);
                     $("#f"+file.id).val(returndata.imgpath);
                 }else{
                     $("#upfilerror").html('上传失败');
                 }*/
            },

            Error: function(up, err) {

            }
        }
    });

    uploader_file.init();
});
