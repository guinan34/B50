<?php

namespace App\Admin\Controllers;

use App\project;
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
        $grid = new Grid(new project);

        $grid->column('id', __('ID'));
        $grid->column('project_id', __('项目ID'));
        $grid->column('project_name', __('项目名称'));
        $grid->column('platform', __('平台'));
        $grid->column('amount', __('金额'));
        $grid->column('song.song', __('歌曲'));
        $grid->column('fanclub.fanclub', __('所属应援会'));
        $grid->column('start_time',__('开始时间'));
        $grid->column('end_time',__('结束时间'));
        //$grid->column('is_obsolete',__('是否废弃'));
        $grid->column('remark', __('备注'));
        // $grid->column('created_at', __('Created at'));
        // $grid->column('updated_at', __('Updated at'));
        $grid->disableCreation();
        $grid->disableActions();
        $states = [
            'on'  => ['value' => 0, 'text' => '启用', 'color' => 'success'],
            'off' => ['value' => 1, 'text' => '废弃', 'color' => 'danger'],
        ];
        $grid->column('is_obsolete','项目状态')->switch($states)->sortable();
        $grid->actions(function ($actions) {

            // 去掉删除
            $actions->disableDelete();

            // 去掉编辑
            $actions->disableEdit();

            // 去掉查看
            $actions->disableView();
        });
        $grid->model()->where('is_obsolete',1);

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    // protected function detail($id)
    // {
    //     $show = new Show(project::findOrFail($id));

    //     $show->field('id', __('Id'));
    //     $show->field('project_name', __('Project name'));
    //     $show->field('project_id', __('Project id'));
    //     $show->field('platform', __('Platform'));
    //     $show->field('amount', __('Amount'));
    //     $show->field('remark', __('Remark'));
    //     $show->field('song_id', __('Song id'));
    //     $show->field('fanClub_id', __('FanClub id'));
    //     $show->field('created_at', __('Created at'));
    //     $show->field('updated_at', __('Updated at'));

    //     return $show;
    // }

    // /**
    //  * Make a form builder.
    //  *
    //  * @return Form
    //  */
    protected function form()
    {
        $form = new Form(new project);

        // $form->number('project_id', __('项目ID'));
        // $form->text('project_name', __('项目名称'));
        // $form->text('platform', __('所属平台'));
        // $form->text('fanclub', __('应援会'));
        $states = [
            'on'  => ['value' => 0, 'text' => '启用', 'color' => 'primary'],
            'off' => ['value' => 1, 'text' => '废弃', 'color' => 'default'],
        ];
        $form->switch('is_obsolete','项目状态')->states($states);
        return $form;
    }
}
