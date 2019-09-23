<?php

namespace App\Admin\Controllers;

use App\groupMember;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class groupMemberCtl extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '成员管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new groupMember);

        $grid->column('id', __('ID'));
        $grid->column('member', __('成员'))->sortable();
        $grid->column('theater', __('组合'))->sortable();
        $grid->column('team', __('队伍'))->sortable();
        // $grid->column('created_at', __('Created at'));
        // $grid->column('updated_at', __('Updated at'));
        $grid->filter(function($filter){
            // 去掉默认的id过滤器
            $filter->disableIdFilter();
            // 在这里添加字段过滤器
            $filter->like('theater', '所属组合');
        });

        $grid->actions(function ($actions) {
            // // 去掉删除
            // $actions->disableDelete();
            // // 去掉编辑
            // $actions->disableEdit();
            // 去掉查看
            $actions->disableView();
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
        $show = new Show(groupMember::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('member', __('Member'));
        $show->field('theater', __('Theater'));
        $show->field('team', __('Team'));
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
        $form = new Form(new groupMember);

        $form->text('member', __('成员'));
        $form->select('theater','组合')->options(['BEJ48' => 'BEJ48', 'SNH48' => 'SNH48', 'GNZ48' => 'GNZ48']);
        $form->text('team', __('队伍'));

        return $form;
    }
}
