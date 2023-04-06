<?php echo
'<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div style="background-color: black; height: 60px; margin-top: -10px;" class="container-fluid">
    <a style="color: white;" class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
            <a style="color: white;" class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
        <li class="nav-item">
            <a style="color: white;" class="nav-link active" aria-current="page" href="#">About</a>
        </li>
        <li class="nav-item dropdown">
        <a style="color: white;" class="nav-link active dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          Topics
        </a>
        <ul class="dropdown-menu">
          <li><a class="dropdown-item" href="#">Javascript</a></li>
          <li><a class="dropdown-item" href="#">Python</a></li>
          <li><a class="dropdown-item" href="#">C++</a></li>
        </ul>
      </li>
        <li class="nav-item">
            <a style="color: white;" class="nav-link active" aria-current="page" href="#">Contact</a>
        </li>
        </ul>
        <div class="mx-3">
            <button class="mx-2 btn btn-primary">Login</button>
            <button class="mx-2 btn btn-primary">Sign Up</button>
        </div>
        <form class="d-flex" role="search">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
    </div>
    </div>
</nav>';
?>