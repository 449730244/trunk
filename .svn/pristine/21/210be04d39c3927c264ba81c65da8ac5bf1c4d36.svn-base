<?php

namespace App\Admin\Controllers;

use App\Models\Advertising;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class AdvertisingsController extends Controller
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

            $content->header('广告');

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

            $content->header('广告');

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

            $content->header('广告');

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
        return Admin::grid(Advertising::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->title('标题');
            $grid->image('图像')->image(null, null, 100);
            $grid->url('链接');
            $grid->advertising_space()->name('所属广告位');
            $grid->sort('排序')->editable();

            $grid->filter(function($filter) {
                $filter->disableIdFilter(); // 去掉默认的id过滤器
                $filter->equal('advertising_space_id', '广告位')->select(\App\Models\AdvertisingSpace::all()->pluck('name','id'));
            });

        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Advertising::class, function (Form $form) {

            $form->select('advertising_space_id', '所属广告位')->rules('required|integer')->options(\App\Models\AdvertisingSpace::all()->pluck('name','id'));
            $form->text('title','标题')->rules('required');
            $form->image('image', '图片')->uniqueName()->rules('nullable|image');
            $form->url('url', '链接')->rules('nullable|url');
            $form->number('sort', '排序')->min(0);

        });
    }
}
