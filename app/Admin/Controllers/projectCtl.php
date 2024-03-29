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

    public function url()
    {
        return url($this->id);
    }

    protected function grid()
    {
        $grid = new Grid(new project);
        // $href=
        $grid->column('id', __('ID'));
        $grid->column('project_id', __('项目ID'))->display(function () {
            if ($this->platform === 'Owhat' || $this->platform === 'owhat') {
                return 'https://m.owhat.cn/shop/shopdetail.html?id='.$this->project_id;
            }elseif ($this->platform === '摩点') {
                return 'https://zhongchou.modian.com/item/'.$this->project_id.'.html';
            }else{
                return '#';
            }
        })->link();

        $grid->column('project_name', __('项目名称'));

        $grid->column('platform', __('平台'))->sortable();
        $grid->column('amount', __('金额'))->sortable();
        $grid->column('song.song', __('歌曲'))->sortable();
        $grid->column('fanclub.fanclub', __('所属应援会'))->sortable();
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
        $grid->model()->orderBy('created_at','desc');
        $grid->actions(function ($actions) {
            // // 去掉删除
            // $actions->disableDelete();
            // // 去掉编辑
            // $actions->disableEdit();
            // 去掉查看
            $actions->disableView();
        });
        
        $grid->filter(function($filter){
            // 去掉默认的id过滤器
            $filter->disableIdFilter();
            // 在这里添加字段过滤器
            $filter->like('project_name', '项目名称');
            $filter->like('platform','平台');
            $filter->like('song.song','歌曲');
            $filter->like('fanclub.fanclub','应援会');
        });
        $grid->model()->where('is_obsolete',0);

        // $grid->column('created_at', __('Created at'));
        // $grid->column('updated_at', __('Updated at'));
        //$grid->quickSearch('project_name','platform');

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
        $form->select('platform','平台')->options(['摩点' => '摩点', 'owhat' => 'owhat', '其他' => '其他'])->rules('required');

        $form->select('song_id','歌曲')->options('/admin/songList')->rules('required');
        $form->select('fanclub_id','所属应援会')->options('/admin/fanclubList')->rules('required'); 
        $form->decimal('amount', __('金额'))->rules('required');
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
