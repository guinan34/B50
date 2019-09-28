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
        $song=song::select('id','song','type','actress')->orderBy('type','asc')->get();

        foreach ($song as $key => $valueSong) {
        	$total_amount=project::where('is_obsolete',0)->sum('amount');
        	$total_song=song::count();
        	$a=$a+1;
        	//$amount='select song_id,sum(amount) from projects group by song_id';
        	$amount=project::where('song_id',$valueSong['id'])->where('is_obsolete',0)->sum('amount');
	        $data['total_amount']=$total_amount;
	       	$data['total_song']=$total_song;
        	//$data['data'][$a]['id'] =$valueSong['id'];
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


    public function detailList(Request $Request)
    {   
        // if ($Request->has('song')) {
        //     $searchSong=$Request->input('song');
        //     $searchSongId=song::where('song',$searchSong)->value('id');
        //     $project=project::select('song_id','project_id','project_name','platform','amount','fanclub_id','remark')->where('is_obsolete',0)->where('song_id',$searchSongId)->get();
        // }elseif ($Request->has('member')) {
        //     $searchMember=$Request->input('member');
        //     $searchMemberId=groupMember::where('member',$searchMember)->value('id');

        $input=$Request->all();
        $member=$input['select_member'];

        return $member;

    	$project=project::select('song_id','project_id','project_name','platform','amount','fanclub_id','remark')->where('is_obsolete',0)->get();
    	$data=array();
    	// $total_amount=project::where('is_obsolete',0)->sum('amount');
     //    $total_song=song::count();

     //    $data['total_amount']=$total_amount;
     //    $data['total_song']=$total_song;
    	$a=-1;

        foreach ($project as $key => $value) {
        	$a=$a+1;

        	$song=song::where('id',$value['song_id'])->value('song');
        	$fanclub=fanclub::where('id',$value['fanclub_id'])->value('fanclub');
        	$project_name=$value['project_name'];
        	$platform=$value['platform'];
        	$amount=$value['amount'];
        	$remark=$value['remark'];
            $project_id=$value['project_id'];


        	$data[$a]['song']=$song;
        	$data[$a]['project_name']=$project_name;

            if ($platform==='Owhat') {
                $project_ur='https://m.owhat.cn/shop/shopdetail.html?id='.$project_id;
                $data[$a]['project_ur']=$project_ur;
            }elseif($platform==='摩点') {
                $project_ur='https://zhongchou.modian.com/item/'.$project_id.'.html';
                $data[$a]['project_ur']=$project_ur;
            }else{
                $project_ur='#';
                $data[$a]['project_ur']=$project_ur;
            }

        	$data[$a]['platform']=$platform;
        	$data[$a]['amount']=$amount;
        	$data[$a]['fan_club']=$fanclub;
        	$data[$a]['remark']=$remark;

        	// return $song;
        }
    	return $data;
    }

    public function backGroundsUrl()
    {
        $backGroundsUrl=background::select('img')->where('is_backgroud','1')->first();
        return $backGroundsUrl;
    }

    public function detailSearch()
    {

        $data=array();
        $total_amount=project::where('is_obsolete',0)->sum('amount');
        $total_song=song::count();

        $data['total_amount']=$total_amount;
        $data['total_song']=$total_song;
        $a=-1;
        
        $song_list=song::select('id','song','type')->get();
        // $member_list=groupMember::orderBy('member','desc')->pluck('member');
        $member_list=groupMember::orderByRaw('convert(member using gbk)')->pluck('member');

        foreach ($song_list as $key => $value) {
            $a=$a+1;
            $id=$value['id'];
            $song=$value['song'];
            $type=$value['type'];

            $data['song_list'][$a]['id']=$id;
            $data['song_list'][$a]['song']=$song;
            $data['song_list'][$a]['type']=$type;

        }

        $data['member_list']=$member_list;

        return $data;
    }



}
