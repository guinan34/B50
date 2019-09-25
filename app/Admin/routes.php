<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('admin.home');
    $router->resource('songs', songCtl::class);
    $router->resource('projects', projectCtl::class);
    $router->resource('fanclubs', fanclubCtl::class);
    $router->resource('obsoletes', obsoleteCtl::class);
    $router->resource('group-members', groupMemberCtl::class);
    $router->resource('backgrounds', backgroundCtl::class);
    
    $router->get('songList', 'projectCtl@songList');
    $router->get('fanclubList', 'projectCtl@fanclubList');
    // $router->get('memberList', 'songCtl@memberList');


});
