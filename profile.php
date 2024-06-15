<?php
# Initialize the session
session_start();

# If user is not logged in then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== TRUE) {
  echo "<script>" . "window.location.href='./login.php';" . "</script>";
  exit;
}
?>



<?php
$page = "Profile Page";
ob_start();

if (isset($_COOKIE['JustLogged'])) {
  $message = " Welcome ! You are now signed in to your account.";
} else {
  $message = " Welcome Back ";
}
?>


<div class="row justify-content-center my-5">
  <div class="col-lg-5 text-center border">
    <img src="./img/blank-avatar.jpg" class="img-fluid rounded" alt="User avatar" width="180">
    <h4 class="my-4">Hello, <?= htmlspecialchars($_SESSION["username"]) ?></h4>
    <a href="./logout.php" class="btn btn-primary">Log Out</a>
  </div>
</div>

<?php
$slot = ob_get_clean();
include 'layout/base.php';

