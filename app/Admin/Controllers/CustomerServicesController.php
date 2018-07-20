<?php

namespace App\Admin\Controllers;

use \App\Models\CustomerService;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class CustomerServicesController extends Controller
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

            $content->header('客服管理');
            $content->description('列表');

            $content->body($this->grid());
        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('客服管理');
            $content->description('修改');

            $content->body($this->form()->edit($id));
        });
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->header('客服管理');
            $content->description('创建');

            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(CustomerService::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->user()->name('绑定用户')->display(function($val){
                return "<span class='label label-primary'>".$val."</span>";
            });
            $grid->name('客服名称');
            $grid->avatar('客服头像')->image(null,null,50);

            $states = [
                'on'  => ['value' => 1,  'color' => 'primary'],
                'off' => ['value' => 0,  'color' => 'default'],
            ];
            $grid->is_on('启用')->switch($states);

            $grid->created_at('创建时间');
            $grid->updated_at('更新时间');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(CustomerService::class, function (Form $form) {

            $form->select('user_id','绑定用户')->options(\App\Models\User::all()->pluck('name','id'))->rules(function($form){
                // 如果不是编辑状态，则添加字段唯一验证
                if (!$user_id = $form->model()->user_id) {
                    return 'required|unique:customer_services,user_id';
                }else{
                    return 'required|unique:customer_services,user_id,'.$user_id;
                }
            });
            $form->text('name', '客服名称')->rules('required');
            $form->image('avatar', '头像')->uniqueName()->rules('nullable|image|mimes:jpeg,bmp,png,gif|dimensions:max_width=300,max_height=300')->help('头像尺寸不能超过300px*300px');

            $states = [
                'on'  => ['value' => 1,  'color' => 'primary'],
                'off' => ['value' => 0,  'color' => 'default'],
            ];
            $form->switch('is_on','启用')->states($states)->default(1);
        });
    }
}
