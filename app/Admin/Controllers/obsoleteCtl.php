<?php

namespace App\Admin\Controllers;

use App\obsolete;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class obsoleteCtl extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '废弃项目管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new obsolete);

        $grid->column('id', __('ID'));
        $grid->column('project_id', __('项目ID'));
        $grid->column('project_name', __('项目名称'));
        $grid->column('platform', __('所属平台'));
        $grid->column('fanclub', __('应援会'));
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
        $show = new Show(obsolete::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('project_name', __('Project name'));
        $show->field('project_id', __('Project id'));
        $show->field('platform', __('Platform'));
        $show->field('fanclub', __('Fanclub'));
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
        $form = new Form(new obsolete);

        $form->number('project_id', __('项目ID'));
        $form->text('project_name', __('项目名称'));
        $form->text('platform', __('所属平台'));
        $form->text('fanclub', __('应援会'));

        return $form;
    }
}
