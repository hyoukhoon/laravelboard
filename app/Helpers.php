<?php

use App\Models\FileTables;

function disptime($regdate){

    $sec = strtotime(date("Y-m-d H:i:s")) - strtotime($regdate);
    if ($sec < 60) {
        $dispdates = $sec."초 전";
    } else if ($sec > 60 && $sec < 3600) {
        $f = floor($sec / 60);
        $dispdates = $f."분 전";
    } else if ($sec > 3600 && $sec < 86400) {
        $f = floor($sec / 3600);
        $dispdates = $f."시간 전";
    } else {
        $dispdates = date("Y-m-d",strtotime($regdate));
    }

    return $dispdates;

}

function dispmemo($memo_cnt, $memo_date){
    if((time()-strtotime($memo_date))<86400){
        return "<span style='color:red;'>[".$memo_cnt."]</span>";
    }else{
        return "<span>[".$memo_cnt."]</span>";
    }
}

function dispattach($bid){
    $attaches = FileTables::where('pid',$bid)->where('code','boardattach')->where('status',1)->get();
    if($attaches){
        return $attaches;
    }else{
        return null;
    }
}

?>