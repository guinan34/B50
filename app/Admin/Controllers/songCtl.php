<?php

namespace App\Admin\Controllers;

use App\song;
use App\project;
use App\fanclub;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class songCtl extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '曲目管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new song);

        $grid->column('id', __('ID'));
        $grid->column('song', __('曲目'));
        $grid->column('type', __('类型'));
        $grid->column('actress', __('演员'));
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
        $show = new Show(song::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('song', __('Song'));
        $show->field('type', __('Type'));
        $show->field('actress', __('Actress'));
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
        $form = new Form(new song);

        $form->text('song', __('曲目'))->rules('required');
        $form->multipleSelect('actress', __('演员'))->options('/admin/memberList')->rules('required');
        $form->select('type', '选择类型')->options(['队歌' => '队歌', 'Unit' => 'Unit', 'Solo' => 'Solo'])->rules('required');
        return $form;
    }

    public function memberList()
    {
        $memberList=fanclub::select('id','member as text')->get();
        return $memberList;
        //print_r($songList);
    }
}
