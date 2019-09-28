<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


$router->get('indexList', 'indexCtl@indexList');
$router->get('detailList', 'indexCtl@detailList');
$router->post('detailList', 'indexCtl@detailList');

$router->get('backGroundsUrl', 'indexCtl@backGroundsUrl');
$router->get('detailSearch', 'indexCtl@detailSearch');





