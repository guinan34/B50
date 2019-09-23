<?php

namespace App\Admin\Controllers;

use App\song;
use App\project;
use App\fanclub;
use App\groupMember;

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
        // $grid->column('actress', __('演员'));
        $grid->column('actress','演员')->display(function($actress){
            $data=groupMember::whereIn('id',$actress)->get()->toArray();
            $str="";
            for ($i=0;$i<count($data);$i++){
                $item=$data[$i]['member'];
                $str.=$item." ";
            }
            return $str;
        });
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
        //$grid->model()->where('id',1);
        // $grid->quickCreate(function (Grid\Tools\QuickCreate $create) {
        //     $create->text('song', '曲目');
        //     $create->multipleSelect('actress','演员')->options('/admin/memberList')->rules('required');
        //     $create->select('type', '选择类型')->options(['队歌' => '队歌', 'Unit' => 'Unit', 'Solo' => 'Solo'])->rules('required');
        // });
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

        $show->field('id', __('ID'));
        $show->field('song', __('曲目'));
        $show->field('type', __('类型'));
        // $show->field('actress', __('Actress'));
        $show->field('actress', __('演员'))
        ->unescape()->as(function ($actress) {
            $data = groupMember::whereIn('id', $actress)
                ->get()
                ->toArray();
            $str="";
            for ($i=0;$i<count($data);$i++){
                $item=$data[$i]['member'];
                $str.=$item." ";
            }
            return  $str;
        });

        $show->field('created_at', __('创建时间'));
        $show->field('updated_at', __('更新时间'));

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

        $form->text('song', __('曲目'))->rules('required|unique:songs');
        $form->multipleSelect('actress','演员')->options('/admin/memberList')->rules('required');
        $form->select('type', '选择类型')->options(['队歌' => '队歌', 'Unit' => 'Unit', 'Solo' => 'Solo'])->rules('required');
        
        return $form;
    }

    public function memberList()
    {
        $memberList=groupMember::select('id','member as text')->get();
        return $memberList;
        //print_r($songList);
    }


}
