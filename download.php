<?php
include(__DIR__.'/functions.inc.php');
include(__DIR__.'/init.inc.php');
unlink("reader.csv"); //FIXME: Don't use filesystem

$fp = fopen('reader.csv', 'w+');
fputcsv($fp, array("Board", " Card name", "Card Description", "Card Points" , "Status","CheckItems", "ItemsChecked","Asigned users"));
foreach($cards as $card) {
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