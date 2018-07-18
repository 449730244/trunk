<?php

namespace App\Admin\Controllers;

use App\Models\File;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class FilesController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('文件管理');

            $content->body($this->grid());
        });
    }


    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(File::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->name('文件名');
            $grid->size('大小');
            $grid->url('路径');
            $grid->created_at('创建时间');
            $grid->user()->name('发送人')->display(function($val){
                return "<span class='label label-primary'>".$val."</span>";
            });
            $grid->column('to','接收人')->display(function(){
                $to_user_id = $this->to_user_id;
                $group_id = $this->group_id;
                if ($to_user_id){
                    return "<span class='label label-success'>".\App\Models\User::find($to_user_id)->name."</span>";
                }elseif ($group_id){
                    return "<span class='label label-info'>".\App\Models\Group::find($group_id)->name."</span>";
                }

            });
            $grid->disableCreateButton(); //禁用创建按钮
            $grid->actions(function ($actions) {
                $actions->disableEdit(); //禁用修改
            });
            $grid->disableExport(); //禁用导出

            //筛选设置
            $grid->filter(function($filter){
                $filter->disableIdFilter(); //去掉默认的id过滤器
                $filter->like('name','文件名');
                $filter->equal('user_id', '发送人')->select(\App\Models\User::all()->pluck('name','id'));
            });
        });
    }

}
