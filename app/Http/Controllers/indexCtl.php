<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\song;
use App\project;
use App\fanclub;
use App\groupMember;
use App\background;
use DB;


use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class indexCtl extends Controller
{
    public function indexList()
    {   
    	$a=-1;

        $songdb=DB::select("
            SELECT *
            FROM
            (
                SELECT F1.song, F1.actress, F1.type, IFNULL(SUM(F1.amount), 0) AS amount
                FROM
                (
                    SELECT S.song, S.type, S.actress, P.project_name, P.amount
                    FROM 
                    (
                        SELECT id, song, actress, type 
                        FROM songs
                        WHERE type = '队歌'
                    ) AS S
                    LEFT JOIN
                    (
                        SELECT song_id, project_name, amount 
                        FROM projects
                        WHERE is_obsolete = 0
                    ) AS P ON S.id = P.song_id
                ) AS F1
                GROUP BY F1.song, F1.actress, F1.type
                ORDER BY amount DESC
            ) AS M1
            UNION
            SELECT *
            FROM
            (
                SELECT F1.song, F1.actress, F1.type, IFNULL(SUM(F1.amount), 0) AS amount
                FROM
                (
                    SELECT S.song, S.type, S.actress, P.project_name, P.amount
                    FROM 
                    (
                        SELECT id, song, actress, type 
                        FROM songs
                        WHERE type = 'Unit' OR type = 'Solo'
                    ) AS S
                    LEFT JOIN
                    (
                        SELECT song_id, project_name, amount 
                        FROM projects
                        WHERE is_obsolete = 0
                    ) AS P ON S.id = P.song_id
                ) AS F1
                GROUP BY F1.song, F1.actress, F1.type
                ORDER BY amount DESC
            ) AS M2");

        //return var_dump($songdb);
        $songdb=collect($songdb)->map(function($x){ return (array) $x; })->toArray();

        $data=array();
        $song=song::select('id','song','type','actress')->orderBy('type','asc')->get();

        $total_amount=project::where('is_obsolete',0)->sum('amount');
        $total_song=song::count();

        $data['total_amount']=$total_amount;
        $data['total_song']=$total_song;

        foreach ($songdb as $key => $valueSong) {
            //return $songdb;
        	$a=$a+1;
        	//$amount='select song_id,sum(amount) from projects group by song_id';
        	//$amount=project::where('song_id',$valueSong['id'])->where('is_obsolete',0)->sum('amount');
        	//$data['data'][$a]['id'] =$valueSong['id'];
            //return $key;
	        $data['data'][$a]['song'] =$valueSong['song'];
	        $data['data'][$a]['type'] =$valueSong['type'];
            $data['data'][$a]['amount'] =$valueSong['amount'];
	        //$data['data'][$a]['amount'] =$amount;
	        //$data[$a]['total_song']=;
            $actressId=explode(",",$valueSong['actress']);
        	foreach ($actressId as $key => $value) {
                //return $value;
        		$actressList=groupMember::select('member')->where('id',$value)->get()->toArray();
            	$data['data'][$a]['actress'][] =$actressList[0]['member'];
            }
        }
        //$json_string = json_encode($data);
        return $data;
    }


    public function detailList(Request $Request)
    {   
        $input=$Request->all();

        if ($Request->filled('select_type') && $Request->input('select_type') === 'song') {

            $inputsong = $input['select_song'];
            $searchSongId=song::where('song',$inputsong)->value('id');
            $project=project::select('song_id','project_id','project_name','platform','amount','fanclub_id','remark')->where('is_obsolete',0)->where('song_id',$searchSongId)->get();

        }elseif ($Request->filled('select_type') && $Request->input('select_type') === 'member') {
            $inputmember = $input['select_member'];
            $fanclub_id = fanclub::where('member','like','%'.$inputmember.'%')->pluck('id');
            //return $fanclub_id;
            //$searchMemberId=groupMember::where('member',$inputmember)->value('id');
            //return $searchMemberId;
            //$memberBelongSongId=song::whereRaw("FIND_IN_SET($searchMemberId,actress)",true)->pluck('id');
            // return $memberBelongSongId;
            $project=project::select('song_id','project_id','project_name','platform','amount','fanclub_id','remark')->where('is_obsolete',0)->whereIn('fanclub_id',$fanclub_id)->get();
            // return $project;

        }else{
            //return $member;
            $project=project::select('song_id','project_id','project_name','platform','amount','fanclub_id','remark')->where('is_obsolete',0)->get();
        }

        
    	$data=array();

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

            if ($platform==='owhat') {
                $project_url='https://m.owhat.cn/shop/shopdetail.html?id='.$project_id;
                $data[$a]['project_url']=$project_url;
            }elseif($platform==='摩点') {
                $project_url='https://zhongchou.modian.com/item/'.$project_id.'.html';
                $data[$a]['project_url']=$project_url;
            }else{
                $project_url='#';
                $data[$a]['project_url']=$project_url;
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
