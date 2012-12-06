<?php
function getBoardName($id,$key,$token) {
    $url = 'https://api.trello.com/1/board/'.$id.'?key='.$key.'&token='.$token;
    $getTrello2 = api_request($url);
    return $getTrello2['name'];
}

function getCardsPerBoard($board,$key,$token) {
    $url = 'https://api.trello.com/1/board/'.$board.'?key='.$key.'&token='.$token.'&cards=open&lists=open';
    $getTrello = api_request($url);
    return $getTrello['cards'];
}

function getBoards($key,$token) {
    $url = 'https://api.trello.com/1/member/me?key='.$key.'&token='.$token.'&boards=all';
    $getBoard = api_request($url);
    return $getBoard['boards'];
}

function listName($idList,$key,$token) {
    $url = 'https://api.trello.com/1/list/'.$idList.'?key='.$key.'&token='.$token;
    $getList =  api_request($url);
    return $getList['name'];
}

function userName($idUser,$key,$token) {
    $url = 'https://api.trello.com/1/member/'.$idUser.'?key='.$key.'&token='.$token;
    $getUser = api_request($url);
    return $getUser['fullName'];
}

function api_request($url) {
    $call = curl_init($url);
    curl_setopt($call,CURLOPT_RETURNTRANSFER, TRUE);
    $result = curl_exec($call);
    $result = json_decode($result,true);
    curl_close($call);
    return $result;
}