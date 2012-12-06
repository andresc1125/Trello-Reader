<?php
if(!isset($_COOKIE['token'])) {
    setcookie("token",$_GET["token"],time()+60*24*60*60);
}

$token = $_COOKIE['token'];
$Key = 'bd5a011b3723a9156b8ed35a5645b771';

$numero = count($_GET);
$valores = array_values($_GET);
$tags = array_keys($_GET);
$boards = array();
$cards = array();
$board = array();
if(isset($_GET['board'])) {
    $boards = $_GET['board'];
}
if(sizeof($boards)>0){
    foreach($boards as $board) {
        $boardName=getBoardName($board,$Key,$token);
        $newCards = getCardsPerBoard($board,$Key,$token);
        foreach($newCards as $newCard){
            $newCard['idBoard']=$boardName;
            $cards[]=$newCard;
        }
    }
}
