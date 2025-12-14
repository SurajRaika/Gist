
<?php $page = "Home Page";
ob_start(); // Start output buffering
?>



<!-- Error 404 Template 1 - Bootstrap Brain Component -->
<section class="py-3 py-md-5  d-flex justify-content-center align-items-center">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="text-center">
          <h2 class="d-flex justify-content-center align-items-center gap-2 mb-4">
            <span class="display-1 fw-bold">5</span>
            <span class="display-1 fw-bold text-danger">0</span>
            <span class="display-1 fw-bold bsb-flip-h ">3</span>
          </h2>
          <h3 class="h2 mb-2">Oops! Server lost.</h3>
          <p class="mb-5">Service Down</p>
          <a class="btn bsb-btn-5xl btn-dark rounded-pill px-5 fs-6 m-0" href="/" role="button">Back to Home</a>
        </div>
      </div>
    </div>
  </div>
</section>



<?php $slot = ob_get_clean(); // Store the output buffer content into $slot
include 'layout/base.php'; // Include the layout file
?>