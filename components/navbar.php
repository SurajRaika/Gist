<?php function createNavbar($title) { ?>
    
    <nav class="navbar navbar-expand-lg  border ">
    <div class="container-fluid">
      <a class="navbar-brand" href="/">Gistbar</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="/">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./explore-gist.php">Explore</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Setting
            </a>
            <ul class="dropdown-menu">
              <!-- <li><a class="dropdown-item" href="#">Action</a></li> -->
              <!-- <li><a class="dropdown-item" href="#">Another action</a></li> -->
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="/profile.php">User Profile</a></li>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link disabled" aria-disabled="true">Disabled</a>
          </li>
        </ul>
        <form class="d-flex" role="search" id="navbar-search-form">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" id="navbar-search-input">
          <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
      </div>
    </div>
  </nav>
  
  <script>
    document.getElementById('navbar-search-form').addEventListener('submit', function(event) {
      event.preventDefault();
      const query = document.getElementById('navbar-search-input').value;
      const newUrl = new URL(window.location.href);
      newUrl.pathname = '/explore-gist.php';
      newUrl.searchParams.set('search', query);
      window.location.href = newUrl.toString();
    });
  </script>
  
  <?php } ?>
  