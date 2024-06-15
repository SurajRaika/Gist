  <!DOCTYPE html>
  <html lang="en" data-bs-theme="dark">
<?php  include 'components/header.php';echo createHeader($page); ?>

<body>
  <?php include 'components/navbar.php';  echo createNavbar($page); ?>
  <div class="container">
  <?php echo $slot ?? "Default content"; ?>

  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>