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




require_once "./config.php";
require_once "model/GIST.php";

$description_error = $filename_error = $content_error = $post_error = "";
$description = $filename = $content = "";
$gist = new GIST($link);



if ($_SERVER['REQUEST_METHOD'] == "POST") {
  if (empty(trim($_POST["description"]))) {
    $description_error = "Please enter a description.";
  }
  if (empty(trim($_POST["filename"]))) {
    $filename_error = "Please enter a filename.";
    # code...
  }
  if (empty(trim($_POST["content"]))) {
    $content_error = "Please enter content.";
  }

  if (empty($description_error) && empty($filename_error) && empty($content_error)) {
    $description = $_POST["description"];
    $filename = $_POST["filename"];
    $content = $_POST["content"];
    $gist->CreateGist($description, $filename, $content);
  }

  // Validate






  # code...
}




?>



<script src="https://cdn.jsdelivr.net/npm/iblize/dist/iblize.min.js"></script>




























<?php $page = "Home Page";
ob_start(); // Start output buffering
?>


<form class=" p-2 pt-3 m-0 border-0" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" novalidate>

  <div class="mb-3">
    <label for="gist_description" class="form-label">Describe Gist</label>
    <input type="text" class="form-control" id="gist_description" placeholder="Describe the Topic" name="description">
    <small class="text-danger"><?= $description_error; ?></small>

  </div>
  <div class="mb-3 ">
    <label for="gist_content" class="form-label mb-0">File Content</label>
    <input type="text" class="form-control my-1 " id="gist_filename" placeholder="Example.txt" name="filename">
    <small class="text-danger"><?= $filename_error; ?></small>



    <!-- <textarea class="form-control" id="gist_content" rows="6" name="content"></textarea> -->
      <!-- Iblize Editor Integration -->
      <div class="border">

      <div id="editor"  desable style="width: 100%; height: 55vh; ">
        <!--
        <?php echo htmlspecialchars($content); ?>
        -->
    </div>
    </div>

    <script>
        // Initialize Iblize editor
        
        const iblize = new Iblize("#editor", {
            language: "python",
            // tabSize:20,
            // readOnly: true // Set the editor to be read-only

        });
        document.body.getElementsByClassName('iblize_textarea')[0].setAttribute('name', 'content');

        // Set editor default value programmatically if necessary
        iblize.setValue("<?php echo addslashes("$content"); ?>");

        // Listening for changes in the editor
        iblize.onUpdate((value) => {
            // Handle the updated value
            console.log(value);
        });
    </script>




    <small class="text-danger"><?= $content_error; ?></small>

  </div>
  <div class="mb-3 d-flex flex-row justify-content-between ">
    <button class="btn btn-secondary" type="button" >Add File</button>
    <button class="btn btn-success" type="submit">Create Public Gist</button>

  </div>
</form>
<?php $slot = ob_get_clean(); // Store the output buffer content into $slot
include 'layout/base.php'; // Include the layout file
?>