<?php
try {
  $db = new PDO("sqlite:".__DIR__."/../../database.sqlite");
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $stmt = $db->query('SELECT 1');
  if ($stmt === false) {
      throw new Exception('Test query failed');
  }
} catch (PDOException $e) {
  error_log('DB error: ' . $e->getMessage());
  die('Database connection failed');
}
return $db;
?>