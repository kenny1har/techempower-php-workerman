<?php
function dbraw($pdo) {
  $query_count = 1;
  if (isset($_GET['queries']) && $_GET['queries'] > 0) {
    $query_count = $_GET['queries'];
  }

  $arr = array();
  $id = mt_rand(1, 10000);
  $statement = $pdo->prepare('SELECT randomNumber FROM World WHERE id = :id');
  $statement->bindParam(':id', $id, PDO::PARAM_INT);

  while (0 < $query_count--) {
    $statement->execute();
    $arr[] = array('id' => $id, 'randomNumber' => $statement->fetchColumn());
    $id = mt_rand(1, 10000);
  }

  if (count($arr) == 1) {
    $arr = $arr[0];
  }

  echo json_encode($arr);
}
