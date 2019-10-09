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
        $grid->column('modian_id', __('摩点id'));
        $grid->column('owhat_id', __('owhat Id'));

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
        $states = [
            'on'  => ['value' => 1, 'text' => '启用', 'color' => 'success'],
            'off' => ['value' => 0, 'text' => '废弃', 'color' => 'danger'],
        ];
        $grid->column('active','应援会状态')->switch($states)->sortable();
        $grid->filter(function($filter){
            // 去掉默认的id过滤器
            $filter->disableIdFilter();
            // 在这里添加字段过滤器
            $filter->like('fanclub', '应援会');
            $filter->like('member','成员');
        });
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

        $form->text('fanclub', __('应援会'))->rules('required|unique:fanclubs,id');
        $form->text('modian_id', __('摩点id'));
        $form->text('owhat_id', __('owhat Id'));
        $form->text('member', __('成员'))->rules('required');
        $states = [
            'on'  => ['value' => 1, 'text' => '启用', 'color' => 'primary'],
            'off' => ['value' => 0, 'text' => '废弃', 'color' => 'default'],
        ];
        $form->switch('active','应援会状态')->states($states);

        return $form;
    }
}
