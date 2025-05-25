<?php
$conn = new mysqli("localhost", "root", "", "foodexpress");
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>
