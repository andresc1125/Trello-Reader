<?php

unlink("reader.csv");


if((!isset($_COOKIE['token']))  ) {

	setcookie("token",$_GET["token"],time()+60*24*60*60);

    }

$token=$_COOKIE['token'];
$Key='bd5a011b3723a9156b8ed35a5645b771';

$numero = count($_GET);
$valores = array_values($_GET);
$tags = array_keys($_GET);
$boards=array();
$cards =array();


$boards=$_GET['board'];


function getBoardName($id,$key,$token){
	$req2='https://api.trello.com/1/board/'.$id.'?key='.$key.'&token='.$token;
	
	
	
	
	$cTrello2 = curl_init($req2);


	curl_setopt($cTrello2,CURLOPT_RETURNTRANSFER, TRUE);

	$gTrello2 = curl_exec($cTrello2);

	$getTrello2 = json_decode($gTrello2,true);



	curl_close($cTrello2);
	
	return $getTrello2['name'];
	
}

function getCardsPerBoard($board,$key,$token){
	
	$req='https://api.trello.com/1/board/'.$board.'?key='.$key.'&token='.$token.'&cards=open&lists=open';
	
	
	$cTrello = curl_init($req);


	curl_setopt($cTrello,CURLOPT_RETURNTRANSFER, TRUE);

	$gTrello = curl_exec($cTrello);

	$getTrello = json_decode($gTrello,true);

	$cards=$getTrello['cards'];


	curl_close($cTrello);
	
	
	return $cards;

}

function getBoards($key,$token){
	
	
	$query4='https://api.trello.com/1/member/me?key='.$key.'&token='.$token.'&boards=all';
	$cBoard = curl_init($query4);
	curl_setopt($cBoard,CURLOPT_RETURNTRANSFER, TRUE);
	$gBoard= curl_exec($cBoard);
	$getBoard = json_decode($gBoard,true);
	curl_close($cBoard);

	
	return $getBoard['boards'];
	
	}

function listName($idList,$key,$token)
	{	
	$query3='https://api.trello.com/1/list/'.$idList.'?key='.$key.'&token='.$token;
	$cList = curl_init($query3);
	curl_setopt($cList,CURLOPT_RETURNTRANSFER, TRUE);
	$gList = curl_exec($cList);
	$getList = json_decode($gList,true);
	curl_close($cList);

	return $getList['name'];
	}

function userName($idUser,$key,$token)
	{	
	$query2='https://api.trello.com/1/member/'.$idUser.'?key='.$key.'&token='.$token;
	$cUser = curl_init($query2);
	curl_setopt($cUser,CURLOPT_RETURNTRANSFER, TRUE);
	$gUser = curl_exec($cUser);
	$getUser = json_decode($gUser,true);
	curl_close($cUser);
	return $getUser['fullName'];
	}


	foreach($boards as $board)
		
		{
			
			
	$boardName=getBoardName($board,$Key,$token);
	
		$newCards = getCardsPerBoard($board,$Key,$token);
		
		foreach($newCards as $newCard){
			
			$newCard['idBoard']=$boardName;
			$cards[]=$newCard;
			
			}
		
		
		}
	
	

$fp = fopen('reader.csv', 'w+');

fputcsv($fp, array("Board", " Card name", "Card Description", "Card Points" , "Status","CheckItems", "ItemsChecked","Asigned users"));
	
foreach($cards as $card)

{
	
	$asigned='';
	
	foreach ($card['idMembers'] as $idmember)
	{
	
	$asigned = $asigned.userName($idmember,$Key,$token);
	
	}
	
	$points=substr($card['name'],1,1);
	$list=listName($card['idList'],$Key,$token);
	
	$output = preg_replace('/\t{1,}/', ' ', $card['desc']);
	$output = preg_replace('/\n{1,}/', ' ', $output);
	$output = preg_replace('/\r{1,}/', ' ', $output);
	$output = preg_replace('/\s{1,}/', ' ', $output);
	
   $field=array($card['idBoard'],$card['name'],$output,$points,$list,$card['badges']['checkItems'],$card['badges']['checkItemsChecked'],$asigned);
	fputcsv($fp,$field);


}

fclose($fp);



header ("Content-Disposition: attachment; filename=reader.csv"); 

header ("Content-Type: application/octet-stream");

header ("Content-Length: ".filesize("reader.csv"));

readfile("reader.csv");






?>




