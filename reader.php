<?php
include(__DIR__.'/functions.inc.php');
include(__DIR__.'/init.inc.php');
?><html>
  <head>
    <link rel="stylesheet" href="style.css" type="text/css" media="screen">
  </head>

  <body>
    <h1>Trello Reader </h1>
    <div id="consult">
    </div>
    <form  method="get">
      <?php
          $boardsD = getBoards($Key,$token);
          $count = 0;
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
          foreach($cards as $card) {
              echo '<tr>';
              echo '<td>';echo $card['idBoard'];echo'</td>';
              echo '<td>';echo $card['name'];echo'</td>';
              echo '<td>';echo $card['desc'];echo'</td>';
              echo '<td>';echo substr($card['name'],1,1);echo'</td>';
              echo '<td>';echo listName($card['idList'],$Key,$token);echo'</td>';
              echo '<td>';echo $card['badges']['checkItems'];echo'</td>';
              echo '<td>';echo $card['badges']['checkItemsChecked'];echo'</td>';
              echo '<td>';
              foreach ($card['idMembers'] as $idmember) {
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

