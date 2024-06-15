<?php
# Include connection
require_once "./config.php";
require_once "model/USER.php";

# Define variables and initialize with empty values
$username_err = $email_err = $password_err = "";
$username = $email = $password = "";


$user = new User($link);



# Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  # Validate username
  if (empty(trim($_POST["username"]))) {
    $username_err = "Please enter a username.";
  } else {
    $username = trim($_POST["username"]);
    if (!ctype_alnum(str_replace(array("@", "-", "_"), "", $username))) {
      $username_err = "Username can only contain letters, numbers and symbols like '@', '_', or '-'.";
    }
  }



  $email_result = $user->check_email($_POST["email"]);
$email=$email_result['email'];
$email_err=$email_result['email_err'];

  # Validate email 
  // if (empty(trim($_POST["email"]))) {
  //   $email_err = "Please enter an email address";
  // } else {
  //   $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
  //   if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  //     $email_err = "Please enter a valid email address.";
  //   } else {
  //     # Prepare a select statement
  //     $sql = "SELECT id FROM users WHERE email = ?";

  //     if ($stmt = mysqli_prepare($link, $sql)) {
  //       # Bind variables to the statement as parameters
  //       mysqli_stmt_bind_param($stmt, "s", $param_email);

  //       # Set parameters
  //       $param_email = $email;

  //       # Execute the prepared statement 
  //       if (mysqli_stmt_execute($stmt)) {
  //         # Store result
  //         mysqli_stmt_store_result($stmt);

  //         # Check if email is already registered
  //         if (mysqli_stmt_num_rows($stmt) == 1) {
  //           $email_err = "This email is already registered.";
  //         }
  //       } else {
  //         echo "<script>" . "alert('Oops! Something went wrong. Please try again later.');" . "</script>";
  //       }

  //       # Close statement
  //       mysqli_stmt_close($stmt);
  //     }
  //   }
  // }

  # Validate password
  if (empty(trim($_POST["password"]))) {
    $password_err = "Please enter a password.";
  } else {
    $password = trim($_POST["password"]);
    if (strlen($password) < 8) {
      $password_err = "Password must contain at least 8 or more characters.";
    }
  }

  # Check input errors before inserting data into database
  if (empty($username_err) && empty($email_err) && empty($password_err)) {
    # Prepare an insert statement
    $user->register($username, $email, $password);
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
    <div class="form-wrap border rounded p-4">
      <h1>Sign up</h1>
      <p>Please fill this form to register</p>
      <!-- form starts here -->
      <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" novalidate>
        <div class="mb-3">
          <label for="username" class="form-label">Username</label>
          <input type="text" class="form-control" name="username" id="username" value="<?= $username; ?>">
          <small class="text-danger"><?= $username_err; ?></small>
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Email Address</label>
          <input type="email" class="form-control" name="email" id="email" value="<?= $email; ?>">
          <small class="text-danger"><?= $email_err; ?></small>
        </div>
        <div class="mb-2">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control" name="password" id="password" value="<?= $password; ?>">
          <small class="text-danger"><?= $password_err; ?></small>
        </div>
        <div class="mb-3 form-check">
          <input type="checkbox" class="form-check-input" id="togglePassword">
          <label for="togglePassword" class="form-check-label">Show Password</label>
        </div>
        <div class="mb-3">
          <input type="submit" class="btn btn-primary form-control" name="submit" value="Sign Up">
        </div>
        <p class="mb-0">Already have an account ? <a href="./login.php">Log In</a></p>
      </form>
      <!-- form ends here -->
    </div>
  </div>
</div>




<script defer src="./js/script.js"></script>

<?php $slot = ob_get_clean(); // Store the output buffer content into $slot
include 'layout/base.php'; // Include the layout file
?>