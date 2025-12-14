<?php
# Initialize session
session_start();

# Check if user is already logged in, If yes then redirect him to index page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == TRUE) {
  echo "<script>" . "window.location.href='./'" . "</script>";
  exit;
}

# Include connection
require_once "./config.php";
require_once "model/USER.php";
# Define variables and initialize with empty values
$user_login_err = $user_password_err = $login_err = "";
$user_login = $user_password = "";

# Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty(trim($_POST["user_login"]))) {
    $user_login_err = "Please enter your username or an email id.";
  } else {
    $user_login = trim($_POST["user_login"]);
  }

  if (empty(trim($_POST["user_password"]))) {
    $user_password_err = "Please enter your password.";
  } else {
    $user_password = trim($_POST["user_password"]);
  }

  # Validate credentials 
  if (empty($user_login_err) && empty($user_password_err)) {
    $localUser=new User($link);
    $user_login_err=$localUser->login($user_login,$user_password);
  }

  # Close connection
  mysqli_close($link);
}
?>

<?php $page = "login";
ob_start(); // Start output buffering
?>
<div class="row min-vh-100 justify-content-center align-items-center">
  <div class="col-lg-5">
    <?php
    if (!empty($login_err)) {
      echo "<div class='alert alert-danger'>" . $login_err . "</div>";
    }
    ?>
    <div class="form-wrap border rounded p-4">
      <h1>Log In</h1>
      <p>Please login to continue</p>
      <!-- form starts here -->
      <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" novalidate>
        <div class="mb-3">
          <label for="user_login" class="form-label">Email</label>
          <input type="Email" class="form-control" name="user_login" id="user_login" value="<?= $user_login; ?>">
          <small class="text-danger"><?= $user_login_err; ?></small>
        </div>
        <div class="mb-2">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control" name="user_password" id="password">
          <small class="text-danger"><?= $user_password_err; ?></small>
        </div>
        <div class="mb-3 form-check">
          <input type="checkbox" class="form-check-input" id="togglePassword">
          <label for="togglePassword" class="form-check-label">Show Password</label>
        </div>
        <div class="mb-3">
          <input type="submit" class="btn btn-primary form-control" name="submit" value="Log In">
        </div>
        <p class="mb-0">Don't have an account ? <a href="./register.php">Sign Up</a></p>
      </form>
      <!-- form ends here -->
    </div>
  </div>
</div>
<script defer src="./js/script.js"></script>

<?php $slot = ob_get_clean(); // Store the output buffer content into $slot
include 'layout/base.php'; // Include the layout file
?>