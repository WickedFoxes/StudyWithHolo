<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
?>

<?php
	$db = new mysqli('localhost', 'root', '!sos65683629', 'studyholo');
  if ($db->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
?>