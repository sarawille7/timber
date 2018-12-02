<?php
    $stmt = $db->prepare('SELECT banDate FROM banned WHERE username == ?');
    $stmt->execute(array($_SESSION['username']));
    $result_set = $stmt->fetchAll();
    if (count($result_set) != 0){
      $ban = "";
      foreach($result_set as $tuple) {
        if ($tuple['banDate'] > $ban){
          $ban = $tuple['banDate'];
        }
      }
      $currentTime = new DateTime("NOW");
      $now = $currentTime->format('Y-m-d H:i:s');
      if ($ban > $now){
        header('Location: userBanned.php');
        die();
      }
    }
?>