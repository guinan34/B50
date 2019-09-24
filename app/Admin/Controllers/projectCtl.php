<?php

namespace App\Admin\Controllers;

use App\project;
use App\fanclub;
use App\song;
use App\groupMember;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class projectCtl extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '项目管理';

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
        $grid->column('platform', __('平台'))->sortable();
        $grid->column('amount', __('金额'))->sortable();
        $grid->column('song.song', __('歌曲'))->sortable();
        $grid->column('fanclub.fanclub', __('所属应援会'));
        $grid->column('start_time',__('开始时间'))->sortable();
        $grid->column('end_time',__('结束时间'))->sortable();
        //$grid->column('is_obsolete',__('是否废弃'))->editable('select', [0 => '启用', 1 => '废弃'])->sortable();
        $grid->column('remark', __('备注'));
        
        //$grid->('is_obsolete')->switch();
        // 设置text、color、和存储值
        $states = [
            'on'  => ['value' => 0, 'text' => '启用', 'color' => 'success'],
            'off' => ['value' => 1, 'text' => '废弃', 'color' => 'danger'],
        ];
        $grid->column('is_obsolete','项目状态')->switch($states)->sortable();
        $grid->model()->orderBy('is_obsolete','asc');
        $grid->actions(function ($actions) {
            // // 去掉删除
            // $actions->disableDelete();
            // // 去掉编辑
            // $actions->disableEdit();
            // 去掉查看
            $actions->disableView();
        });

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
        $show = new Show(project::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('project_name', __('Project name'));
        $show->field('project_id', __('Project id'));
        $show->field('platform', __('Platform'));
        $show->field('amount', __('Amount'));
        $show->field('remark', __('Remark'));
        $show->field('song_id', __('Song id'));
        $show->field('fanClub_id', __('FanClub id'));
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
        $form = new Form(new project);
        $form->number('project_id', __('项目ID(摩点/Owhat必填)'));
        $form->text('project_name', __('项目名称'))->rules('required');
        $form->datetime('start_time',__('开始时间'));
        $form->datetime('end_time',__('结束时间'));
        $form->select('platform','平台')->options(['摩点' => '摩点', 'Owhat' => 'Owhat', '其他' => '其他'])->rules('required');

        $form->select('song_id','歌曲')->options('/admin/songList')->rules('required');
        $form->select('fanclub_id','所属应援会')->options('/admin/fanclubList')->rules('required'); 
        // $form->decimal('amount', __('金额'))->rules('required');
        //$form->select('is_obsolete','是否废弃')->options(['1' => '废弃', '0' => '启用']);
        $states = [
            'on'  => ['value' => 0, 'text' => '启用', 'color' => 'primary'],
            'off' => ['value' => 1, 'text' => '废弃', 'color' => 'default'],
        ];
        $form->switch('is_obsolete','项目状态')->states($states);
        $form->text('remark', __('备注'));


        return $form;
    }


    public function songList()
    {
        $songList=song::select('id','song as text')->get();
        return $songList;
        //print_r($songList);
    }

    public function fanclubList()
    {
        $fanclubList=fanclub::select('id','fanclub as text')->get();
        return $fanclubList;
        //print_r($songList);
    }

}
