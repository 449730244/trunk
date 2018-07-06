<?php

namespace App\Admin\Controllers;

use App\Models\Newstype;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Tree;

class NewstypesController extends Controller
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

            $content->header('资讯分类');

            $content->body($this->tree());
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

            $content->header('资讯分类');

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

            $content->header('资讯分类');

            $content->body($this->form());
        });
    }

    protected function tree()
    {
        return Newstype::tree(function (Tree $tree) {
            $tree->branch(function ($branch) {
               // $src = config('admin.upload.host') . '/' . $branch['logo'] ;
               // $logo = "<img src='$src' style='max-width:30px;max-height:30px' class='img'/>";
                return "{$branch['id']} - {$branch['title']} ";
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
        return Admin::form(Newstype::class, function (Form $form) {

            $form->select('parent_id', '父分类')->options(Newstype::selectOptions());
            $form->text('title', '名称');

        });
    }
}
