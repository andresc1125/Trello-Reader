<?php


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

if(sizeof($boards)>0){
	foreach($boards as $board)
		
		{
			
			
	$boardName=getBoardName($board,$Key,$token);
	
		$newCards = getCardsPerBoard($board,$Key,$token);
		
		foreach($newCards as $newCard){
			
			$newCard['idBoard']=$boardName;
			$cards[]=$newCard;
			
			}
		
		
		}
	
}

?> 

<html>
<head>
<LINK REL=StyleSheet HREF="style.css" TYPE="text/css" MEDIA=screen>
</head>

<body>
	<h1>Trello Reader </h1>
	<div id="consult">


	</div>
	
	
	
	
	
	<form  method="get">
	<?php 
	$boardsD = getBoards($Key,$token);
	
	
	
	$count=0;
	
	foreach($boardsD as $item){
		echo '<input type="checkbox" name="board[]" value="'.$item['id'] .'" />'.$item['name'].'<br/>';
		$count++;
		}
	unset($count);
?>
	<input type="submit" onclick = "this.form.action = 'reader.php'" value="Visualizar" />
   <input type="submit" onclick = "this.form.action = 'download.php'" value="Descargar csv" />
	
	</form>
	
	

<div id="results">
<?php
	
	echo '<table class="ans">';
	
	echo '<tr>';
	
	echo '<td>';echo "Board";echo'</td>';
	echo '<td>';echo "Card Name";echo'</td>';
	echo '<td>';echo "Card Description";echo'</td>';
	echo '<td>';echo "Card Points";echo'</td>';
	echo '<td>';echo "Status";echo'</td>';
	echo '<td>';echo "CheckItems";echo'</td>';
	echo '<td>';echo "ItemsChecked";echo'</td>';
	echo '<td>';echo "Asigned users";echo'</td>';
	
	echo '</tr>';
	foreach($cards as $card)
	{ 
	echo '<tr>';
	echo '<td>';echo $card['idBoard'];echo'</td>';
	echo '<td>';echo $card['name'];echo'</td>';
	echo '<td>';echo $card['desc'];echo'</td>';
	echo '<td>';echo substr($card['name'],1,1);echo'</td>';
	echo '<td>';echo listName($card['idList'],$Key,$token);echo'</td>';
	echo '<td>';echo $card['badges']['checkItems'];echo'</td>';
	echo '<td>';echo $card['badges']['checkItemsChecked'];echo'</td>';
	
	echo '<td>';
	foreach ($card['idMembers'] as $idmember){
	
	echo userName($idmember,$Key,$token).',';
	}
		echo '</td>';

}

	
	
	echo '</tr>';
	
	
	


echo '</table>';

?>



</div>



</body>



</html>

