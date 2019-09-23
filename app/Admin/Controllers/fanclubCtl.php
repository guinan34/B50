<?php

namespace App\Admin\Controllers;

use App\fanclub;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class fanclubCtl extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '应援会管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new fanclub);

        $grid->column('id', __('ID'));
        $grid->column('fanclub', __('应援会'));
        $grid->column('member', __('成员'));
        // $grid->column('created_at', __('Created at'));
        // $grid->column('updated_at', __('Updated at'));
        $grid->actions(function ($actions) {
            // // 去掉删除
            // $actions->disableDelete();
            // // 去掉编辑
            // $actions->disableEdit();
            // 去掉查看
            $actions->disableView();
        });
        $grid->quickSearch('fanclub','member');

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
        $show = new Show(fanclub::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('fanclub', __('Fanclub'));
        $show->field('member', __('Member'));
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
        $form = new Form(new fanclub);

        $form->text('fanclub', __('应援会'))->rules('required|unique:fanclubs');
        $form->text('member', __('成员'))->rules('required');

        return $form;
    }
}
