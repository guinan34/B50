<?php

namespace App\Admin\Controllers;

use App\background;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class backgroundCtl extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '背景图';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new background);

        $grid->column('id', __('ID'));
        // $grid->column('img', __('图片'));
        $grid->column('img', __('图片'))->image('http://admin.zhengzai.tv/uploads',100,100);
        // $grid->column('created_at', __('Created at'));
        
        // $grid->column('updated_at', __('Updated at'));

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(background::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('img', __('Img'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new background);

        $form->image('img', __('图片'));

        return $form;
    }
}
