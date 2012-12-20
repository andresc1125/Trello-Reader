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

function getCheckItemsPerCard($idCard,$key,$token){
    $url='https://api.trello.com/1/card/'.$idCard.'/checklists?key='.$key.'&token='.$token;
    $getCheckItems = api_request($url);
    return $getCheckItems;
}

function getCheckItemsState($idCard,$key,$token){
    $url='https://api.trello.com/1/card/'.$idCard.'?key='.$key.'&token='.$token;
    $checkItemStates=api_request($url);
    return $checkItemStates['checkItemStates'];
}

function getItemsChecked($idCard,$key,$token)
{
  $items = getCheckItemsPerCard($idCard,$key,$token);
  $itemsOk = '';
  $CheckItemsState = getCheckItemsState($idCard,$key,$token);
  if( isset($items[0]) )
  {
    foreach($items[0]['checkItems'] as $item)
    {
      foreach ($CheckItemsState as $CheckItemState)
      {
          if($item['id']==$CheckItemState['idCheckItem'])
          {
            $itemsOk=$itemsOk.$item['name'].'|';
          }
      }
    }
  }
  return $itemsOk;
}

function getItemsUnChecked($idCard,$key,$token){
  $items = getCheckItemsPerCard($idCard,$key,$token);
  $itemsOk='';
  $CheckItemsState=getCheckItemsState($idCard,$key,$token);
  if(isset($items[0]))
  {
    foreach($items[0]['checkItems'] as $item)
    {
      if(!isChecked($item,$CheckItemsState))
      {
        $itemsOk=$itemsOk.$item['name'].'|';
      }
    }
  }
  return $itemsOk;
}

function isChecked($item,$CheckItemsState){
  $val=FALSE;
  foreach ($CheckItemsState as $CheckItemState)
    {
        if($item['id']==$CheckItemState['idCheckItem'])
        {
          $val=TRUE;
        }
    }
  return $val;
}


function api_request($url) {
    $call = curl_init($url);
    curl_setopt($call,CURLOPT_RETURNTRANSFER, TRUE);
    $result = curl_exec($call);
    $result = json_decode($result,true);
    curl_close($call);
    return $result;
}