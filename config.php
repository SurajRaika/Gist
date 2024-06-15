<?php
if (basename($_SERVER['PHP_SELF']) == 'config.php') {
  header("Location: index.php");
  exit;
}

define("DB_SERVER", "localhost");
define("DB_USERNAME", "root");
define("DB_PASSWORD", "password");
define("DB_NAME", "registered");

# Connection
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

# Check connection
if (!$link) {
  // die("Connection failed: " . mysqli_connect_error());
  header("Location: index.php");
  exit;

}
