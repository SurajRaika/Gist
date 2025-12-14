<?php
session_start();
  include 'utils/global.php';

// http://localhost:8080/gist.php?id=1
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== TRUE) {
    echo "<script>" . "window.location.href='./login.php';" . "</script>";
    exit;
}

require_once "./config.php";
require_once "model/GIST.php";

// Check if the ID is provided in the URL
if (isset($_GET['id'])) {
    $gist_id = $_GET['id'];
} else {
    // If ID is not provided, redirect to an error page or handle it accordingly
    echo "<script>window.location.href='./404.php';</script>";
    exit;
}



$gist = new GIST($link);
$gist_data = $gist->getGist($gist_id);

if (!$gist_data) {
    // Handle if the Gist with the provided ID is not found
    echo "<script>window.location.href='./404.php';</script>";
    exit;
}

$description = $gist_data['description'];
$filename = $gist_data['filename'];
$content = $gist_data['content'];
$numberOfNewlines = substr_count($content, "\n")+2;
$height = $numberOfNewlines * 30;
$file_split = explode(".", $filename);
$file_type = $file_split[count($file_split)-1];


$page = "Home Page";
ob_start();
?>
<!-- 
<h3 class=" mt-4 "><?php echo $description ?></h3>

<div id="liveToast" style="width:100vw;" class="toast fade show" role="alert" aria-live="assertive" aria-atomic="true">
<div class="toast-header d-flex align-items-center justify-content-between py-0" style="height: 2rem;">
    <span class="fs-5 fw-bolder">
        <?php echo $filename ?>
    </span>
    <small>11 mins ago</small>
</div>
    <div class="toast-body fs-5">
        <?php echo $content ?>
    </div>
</div> -->


<form class=" p-2 pt-3 m-0 border-0" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" novalidate>

    <div class="mb-3">
        <!-- <label for="gist_description" class="form-label">Discription</label> -->
        <h2 class="" name="description">
            <?php safePrint($description) ?>dsd
        </h2>
    </div>
    <div class="mb-3 ">
        <dev type="text" class="form-control my-1 " id="gist_filename"  name="filename"><?php safePrint( $filename) ?>
        </dev>


        <!-- <textarea class="form-control" id="gist_content" rows="6" name="content"></textarea> -->
        <!-- Iblize Editor Integration -->
        <div class="border">

            <div id="editor" desable style="width: 100%; height:<?php echo $height ?>px;">
                <!--
        <?php echo htmlspecialchars($content); ?>
        -->
            </div>
        </div>
    </div>

</form>













<script src="https://cdn.jsdelivr.net/npm/iblize/dist/iblize.min.js"></script>


<script>
    // Initialize Iblize editor

    const iblize = new Iblize("#editor", {
        language: "<?php safePrint($file_type) ?>",
        // tabSize:20,
        readOnly: true // Set the editor to be read-only

    });
    //   document.body.getElementsByClassName('iblize_textarea')[0].setAttribute('name', 'content');

    // Set editor default value programmatically if necessary
    iblize.setValue(<?php echo json_encode($content);?>);

    // Listening for changes in the editor
    iblize.onUpdate((value) => {
        // Handle the updated value
        console.log(value);
    });
</script>






<?php $slot = ob_get_clean();
include 'layout/base.php';
?>




