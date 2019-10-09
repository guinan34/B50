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
use DB;


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
        // $grid->column('actress', __('演员'))->display(function($actress){
        //     $data=groupMember::whereIn('id',$actress)->orderBy(\DB::raw('FIND_IN_SET(id, "' . implode(",", $actress) . '"' . ")"))->get();
        //     return $data;
        // });
        $grid->column('actress','演员')->display(function($actress){
            $data=groupMember::whereIn('id',$actress)->orderBy(\DB::raw('FIND_IN_SET(id, "' . implode(",", $actress) . '"' . ")"))->get();
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

        $grid->filter(function($filter){
            // 去掉默认的id过滤器
            $filter->disableIdFilter();
            // 在这里添加字段过滤器
            $filter->like('song', '曲目');
            $filter->like('type','类型');
            $filter->equal('actress','演员')->select(groupMember::pluck('member as text','id'));
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

        $form->text('song', __('曲目'))->rules('required|unique:songs,id');
        $form->multipleSelect('actress','演员')->options(groupMember::pluck('member as text','id'))->rules('required');

        $form->select('type', '选择类型')->options(['队歌' => '队歌', 'Unit' => 'Unit', 'Solo' => 'Solo'])->rules('required');
        
        return $form;
    }

    // public function memberList()
    // {
    //     $memberList=groupMember::select('id','member as text')->get();
    //     return $memberList;
    //     //print_r($songList);
    // }


}
