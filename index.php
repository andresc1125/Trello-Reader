<?php
  if(isset($_COOKIE['token'])) {
      header('Location: reader.php');
  }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <title>Trello Reader</title>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <meta name="generator" content="Geany 0.21" />
  </head>
  <body>
    <div id="info">
      You need a token <a href="https://trello.com/1/authorize?key=bd5a011b3723a9156b8ed35a5645b771&name=Trello+Reader&expiration=never&response_type=token" target="blank">Get Token</a>
    </div>
    <div id="consult">
    <form action="reader.php" method="get">
      <label>Token</label>
      <input type="text" name="token" >
      <input type="submit">
    </form>
    </div>
  </body>
</html>
