<?php
try {
  $db = new PDO('sqlite:db/development.db');
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  "SQLite connection failed: " . $e->getMessage();
  exit();
}

function query($query, $parameters) {
    global $db;
    try {
      $statement = $db->prepare($query);
      $statement->execute($parameters);
      return $statement->fetchAll();
    } catch (PDOException $e) {
      echo "The query '".$query."' failed: ".$e->getMessage();
      exit();
    }
}

?>