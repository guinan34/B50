<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\song;
use App\project;
use App\fanclub;
use App\groupMember;
use App\background;

use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class indexCtl extends Controller
{
    public function indexList()
    {   
    	$a=-1;

        $data=array();
        $song=song::select('id','song','type','actress')->get();

        foreach ($song as $key => $valueSong) {
        	$total_amount=project::where('is_obsolete',0)->sum('amount');
        	$total_song=song::count();
        	$a=$a+1;
        	//$amount='select song_id,sum(amount) from projects group by song_id';
        	$amount=project::where('song_id',$valueSong['id'])->where('is_obsolete',0)->sum('amount');
	        $data['total_amount']=$total_amount;
	       	$data['total_song']=$total_song;
        	$data['data'][$a]['id'] =$valueSong['id'];
	        $data['data'][$a]['song'] =$valueSong['song'];
	        $data['data'][$a]['type'] =$valueSong['type'];
	        $data['data'][$a]['amount'] =$amount;
	        //$data[$a]['total_song']=;
        	foreach ($valueSong['actress'] as $key => $value) {
        		//print_r($value);
        		$actressList=groupMember::select('member')->where('id',$value)->get()->toArray();

            	$data['data'][$a]['actress'][] =$actressList[0]['member'];
            }
        }
        //$json_string = json_encode($data);
        return $data;
    }


    public function detailList()
    {   
    	$project=project::select('song_id','project_name','platform','amount','fanclub_id','remark')->where('is_obsolete',0)->get();
    	$data=array();
    	$total_amount=project::where('is_obsolete',0)->sum('amount');
        $total_song=song::count();

        $data['total_amount']=$total_amount;
        $data['total_song']=$total_song;
    	$a=-1;

        foreach ($project as $key => $value) {
        	$a=$a+1;
        	$song=song::where('id',$value['song_id'])->value('song');
        	$fanclub=fanclub::where('id',$value['fanclub_id'])->value('fanclub');
        	$project_name=$value['project_name'];
        	$platform=$value['platform'];
        	$amount=$value['amount'];
        	$remark=$value['remark'];

        	$data['data'][$a]['song']=$song;
        	$data['data'][$a]['project_name']=$project_name;
        	$data['data'][$a]['platform']=$platform;
        	$data['data'][$a]['amount']=$amount;
        	$data['data'][$a]['fanclub']=$fanclub;
        	$data['data'][$a]['remark']=$remark;

        	// return $song;
        }
    	return $data;
    }

    public function backGroundsUrl()
    {
        $backGroundsUrl=background::select('img')->where('is_backgroud','1')->first();
        return $backGroundsUrl;
    }

}
