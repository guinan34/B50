<?php

namespace App\Admin\Controllers;

use App\fanclub;
use App\project;
use App\song;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use App\Admin\Controllers\projectCtl;

class HomeController extends Controller
{
    public function index(Content $content)
    {
            $content->title('饺子榜-B50');
            $content->description('后台数据管理');

            
            $content->row(Dashboard::title());
            $content->row(function (Row $row) {

                // $row->column(16, function (Column $column) {
                //     $column->append(Dashboard::showProject());
                // });

                // $row->column(4, function (Column $column) {
                //     $column->append(Dashboard::extensions());
                // });

                // $row->column(4, function (Column $column) {
                //     $column->append(Dashboard::dependencies());
                // });
             });

        return $content;

    }
}
