<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Auth::routes();

Route::get('/home', 'HomeController@index');

//文件相关
Route::get('/returnResource', 'FileController@returnResource');
Route::post('/uploadfile', 'FileController@fileUpload')->name('upload');
Route::get('/download', 'FileController@download_file')->name('download');
Route::post('/filelist', 'FileController@file_list')->name('flist');
Route::post('/delfile', 'FileController@del_file')->name('delfile');
Route::post('/uploadimg', 'FileController@imgUpload')->name('delfile');

Route::get('test', 'HomeController@test');


//用户相关
Route::post('waplogin', 'UsersController@login'); //登录接口
Route::get('loginuser', 'UsersController@me'); //获取登录用户的信息
Route::get('logout', 'UsersController@logout'); //用户退出登录
Route::get('bind','UsersController@bind'); //绑定客户端
Route::get('userlist', 'UsersController@index'); //获取所有用户
Route::post('resetPssword', 'UsersController@resetPssword');//重置密码

//分组相关
Route::get('team', 'TeamController@index');
//Route::get('team/getIslogin', 'TeamController@getIslogin');//获取在线用户信息
Route::post('team/add_team_name', 'TeamController@add_team_name');//添加分组
Route::post('team/renameTeam', 'TeamController@renameTeam');//修改分组
Route::post('team/removeTeam', 'TeamController@removeTeam');//删除分组
Route::get('team/addTeamUser', 'TeamController@addTeamUser');//添加用户分组
Route::post('team/leaveTeam', 'TeamController@leaveTeam');//移除用户
Route::post('team/user', 'TeamController@user');//获取用户信息
Route::post('team/avatar', 'TeamController@avatar');//编辑个人资料-保存上传头像
Route::post('team/searchUsers', 'TeamController@searchUsers');//顶部用户搜索


//群聊相关
Route::post('groups', 'GroupsController@store')->name('groups.store'); //新建群
Route::get('groups', 'GroupsController@index')->name('groups.index'); //用户创建的群
Route::get('userGroups', 'GroupsController@userGroups')->name('groups.userGroups'); //登录用户加入的群
Route::post('groupAddUser', 'GroupsController@groupAddUser')->name('groups.addUser'); //群新增成员
Route::put('/groups/{group}', 'GroupsController@update')->name('groups.update'); //修改群名称
Route::delete('/groups/{group}', 'GroupsController@destroy')->name('groups.destroy'); //解散群聊
Route::delete('/groups/{group}/users/{user}', 'GroupsController@groupRemoveUser')->name('groups.removeUser'); //从群移除用户
Route::post('/groups/user/exit', 'GroupsController@userExit')->name('groups.userexit'); //用户退出群聊
Route::post('/users/send', 'GroupMessagesController@sendmessage')->name('groups.sendtouser'); //给用户发信息
Route::get('/groupMessages', 'GroupMessagesController@index')->name('groups.messages'); //群消息

//静态页面
Route::get('groupBox', 'HtmlController@groupBox');
Route::get('formtoken', 'HtmlController@formtoken');

//消息相关
Route::post('/sendGroupMessage','MessageController@sendGroupMessage'); //群消息发送
Route::post('/sendPrivateMessage','MessageController@sendPrivateMessage'); // 私聊消息发送
Route::get('/getQueueList','MessageController@getQueueList');      //获取消息队列
Route::get('/getGroupMessageList','MessageController@getGroupMessageList');  // 获取群消息列表
Route::get('/getUserMessageList','MessageController@getUserMessageList');  //获取私聊消息列表
Route::get('/delQueue','MessageController@delQueue');  //获取私聊消息列表