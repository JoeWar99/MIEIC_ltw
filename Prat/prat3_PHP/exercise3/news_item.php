


<?php

  $db = new PDO('sqlite:news.db');
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

  $stmt = $db->prepare('SELECT * FROM news JOIN users USING (username) WHERE id = :id');
  $stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
  $stmt->execute();
  $articles = $stmt->fetch();
  var_dump($articles);
?>

