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
 
        // $grid->filter(function($filter){
        //     // 去掉默认的id过滤器
        //     $filter->disableIdFilter();
        //     // 在这里添加字段过滤器
        //     // $filter->like('fanclub', '查询应援会');
        //     $filter->where(function ($query) {
        //         $query->where('fanclub', 'like', "%{$this->input}%")
        //             ->orWhere('member', 'like', "%{$this->input}%");

        //     }, '输入应援会或成员搜索');
        //});
        //快捷搜搜
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
