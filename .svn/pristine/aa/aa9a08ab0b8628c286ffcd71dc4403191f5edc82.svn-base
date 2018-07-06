<?php

namespace App\Admin\Controllers;

use App\Models\School;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;


class SchoolsController extends Controller
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

            $content->header('学校管理');

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

            $content->header('学校管理');

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

            $content->header('学校管理');

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
        return Admin::grid(School::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->code('学校代码');
            $grid->name('学校名称');
            $grid->logo('logo')->image(null, null, 50);
            $grid->type()->name('学校类型');
            $grid->category()->name('高校类别');
            $grid->nature()->name('高校性质');
            $grid->levels('高校级别')->pluck('name')->label();
            $grid->click('点击数');
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
        return Admin::form(School::class, function (Form $form) {

            $form->tab('基础信息', function(Form $form){
                $form->text('code','代码')->rules(function($form){
                    // 如果不是编辑状态，则添加字段唯一验证
                    if (!$id = $form->model()->id) {
                        return 'required|unique:schools,code';
                    }else{
                        return 'required|unique:schools,code,'.$id;
                    }
                });
                $form->text('name', '名称')->rules('required');
                $form->image('logo', 'LOGO')->rules('required|image');
                $form->citypicker('area', '地区')->rules('required');
                $form->year('createdate', '创办年份');
                $form->select('type_id','学校类型')->rules('required')->options(\App\Models\Type::all()->pluck('name','id'));
                $form->select('category_id','学校类别')->rules('required')->options(\App\Models\Category::all()->pluck('name','id'));
                $form->select('nature_id','高校性质')->rules('required')->options(\App\Models\Nature::all()->pluck('name','id'));
                $form->listbox('levels', '高校级别')->options(\App\Models\Level::all()->pluck('name', 'id'))->settings(['selectorMinimalHeight' => 100]);
                $form->text('department', '主管部门');
                $form->url('http', '官网')->rules('nullable');
                $form->number('click', '点击量')->min(0)->default(random_int(10, 100));
                $form->hidden('province');
                $form->hidden('province_code');
                $form->hidden('city');
                $form->hidden('city_code');
                $form->hidden('district');
                $form->hidden('district_code');
                $form->ignore(['area']); //area字段不用保存，忽略掉
            });



        });
    }
}
