

<!--  AUXILIAR FILE  ainda nao sei se vamos precisar , por enquanto estou a fazer como o prof
está a fazer com o ficheiro databse.php na pasta includes -->

<?php
  $dbh = new PDO('sqlite:database/a.db');
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
?>